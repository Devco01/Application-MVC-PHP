<?php
/**
 * Contrôleur d'administration
 */
class AdminController extends Controller {
    /**
     * Modèle des utilisateurs
     * 
     * @var User
     */
    private User $userModel;
    
    /**
     * Modèle des agences
     * 
     * @var Agency
     */
    private Agency $agencyModel;
    
    /**
     * Modèle des trajets
     * 
     * @var Ride
     */
    private Ride $rideModel;
    
    /**
     * Constructeur
     */
    public function __construct() {
        $this->userModel = $this->model('User');
        $this->agencyModel = $this->model('Agency');
        $this->rideModel = $this->model('Ride');
    }
    
    /**
     * Méthode pour afficher le tableau de bord administrateur
     * 
     * @return void
     */
    public function index(): void {
        // Vérifier si l'utilisateur est admin
        $this->requireAdmin();
        
        // Données à passer à la vue
        $data = [
            'title' => 'Tableau de bord administrateur'
        ];
        
        // Charger la vue
        $this->view('admin/index', $data);
    }
    
    /**
     * Méthode pour lister les utilisateurs
     * 
     * @return void
     */
    public function users(): void {
        // Vérifier si l'utilisateur est admin
        $this->requireAdmin();
        
        // Récupérer tous les utilisateurs
        $users = $this->userModel->getAll();
        
        // Données à passer à la vue
        $data = [
            'title' => 'Liste des utilisateurs',
            'users' => $users
        ];
        
        // Charger la vue
        $this->view('admin/users', $data);
    }
    
    /**
     * Méthode pour lister les agences
     * 
     * @return void
     */
    public function agencies(): void {
        // Vérifier si l'utilisateur est admin
        $this->requireAdmin();
        
        // Récupérer toutes les agences
        $agencies = $this->agencyModel->getAll();
        
        // Données à passer à la vue
        $data = [
            'title' => 'Liste des agences',
            'agencies' => $agencies
        ];
        
        // Charger la vue
        $this->view('admin/agencies', $data);
    }
    
    /**
     * Méthode pour afficher le formulaire de création d'une agence
     * 
     * @return void
     */
    public function createAgency(): void {
        // Vérifier si l'utilisateur est admin
        $this->requireAdmin();
        
        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $data = [
                'name' => trim($_POST['name'] ?? '')
            ];
            
            // Valider les données
            $errors = [];
            
            if (empty($data['name'])) {
                $errors['name'] = 'Le nom de l\'agence est requis';
            }
            
            // Si aucune erreur, créer l'agence
            if (empty($errors)) {
                if ($this->agencyModel->create($data)) {
                    // Rediriger vers la liste des agences
                    $this->redirect('admin/agencies');
                } else {
                    $errors['create'] = 'Une erreur est survenue lors de la création de l\'agence';
                }
            }
            
            // S'il y a des erreurs, les passer à la vue
            $viewData = [
                'title' => 'Créer une agence',
                'name' => $data['name'],
                'errors' => $errors
            ];
            
            $this->view('admin/createAgency', $viewData);
        } else {
            // Afficher le formulaire de création
            $data = [
                'title' => 'Créer une agence',
                'name' => '',
                'errors' => []
            ];
            
            $this->view('admin/createAgency', $data);
        }
    }
    
    /**
     * Méthode pour afficher le formulaire de modification d'une agence
     * 
     * @param int $id ID de l'agence
     * @return void
     */
    public function editAgency(int $id): void {
        // Vérifier si l'utilisateur est admin
        $this->requireAdmin();
        
        // Récupérer l'agence
        $agency = $this->agencyModel->getById($id);
        
        // Vérifier si l'agence existe
        if (!$agency) {
            $this->redirect('admin/agencies');
        }
        
        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $data = [
                'name' => trim($_POST['name'] ?? '')
            ];
            
            // Valider les données
            $errors = [];
            
            if (empty($data['name'])) {
                $errors['name'] = 'Le nom de l\'agence est requis';
            }
            
            // Si aucune erreur, mettre à jour l'agence
            if (empty($errors)) {
                if ($this->agencyModel->update($id, $data)) {
                    // Rediriger vers la liste des agences
                    $this->redirect('admin/agencies');
                } else {
                    $errors['update'] = 'Une erreur est survenue lors de la modification de l\'agence';
                }
            }
            
            // S'il y a des erreurs, les passer à la vue
            $viewData = [
                'title' => 'Modifier une agence',
                'agency' => $agency,
                'name' => $data['name'],
                'errors' => $errors
            ];
            
            $this->view('admin/editAgency', $viewData);
        } else {
            // Afficher le formulaire de modification
            $data = [
                'title' => 'Modifier une agence',
                'agency' => $agency,
                'name' => $agency['name'],
                'errors' => []
            ];
            
            $this->view('admin/editAgency', $data);
        }
    }
    
    /**
     * Méthode pour supprimer une agence
     * 
     * @param int $id ID de l'agence
     * @return void
     */
    public function deleteAgency(int $id): void {
        // Vérifier si l'utilisateur est admin
        $this->requireAdmin();
        
        // Récupérer l'agence
        $agency = $this->agencyModel->getById($id);
        
        // Vérifier si l'agence existe
        if (!$agency) {
            $this->redirect('admin/agencies');
        }
        
        // Supprimer l'agence
        if ($this->agencyModel->delete($id)) {
            // Rediriger vers la liste des agences
            $this->redirect('admin/agencies');
        } else {
            // En cas d'erreur (agence utilisée dans un trajet), afficher un message
            $agencies = $this->agencyModel->getAll();
            
            $data = [
                'title' => 'Liste des agences',
                'agencies' => $agencies,
                'error' => 'Impossible de supprimer cette agence car elle est utilisée dans un ou plusieurs trajets'
            ];
            
            $this->view('admin/agencies', $data);
        }
    }
    
    /**
     * Méthode pour lister les trajets
     * 
     * @return void
     */
    public function rides(): void {
        // Vérifier si l'utilisateur est admin
        $this->requireAdmin();
        
        // Récupérer tous les trajets
        $rides = $this->rideModel->getAllRides();
        
        // Données à passer à la vue
        $data = [
            'title' => 'Liste des trajets',
            'rides' => $rides
        ];
        
        // Charger la vue
        $this->view('admin/rides', $data);
    }
    
    /**
     * Méthode pour supprimer un trajet
     * 
     * @param int $id ID du trajet
     * @return void
     */
    public function deleteRide(int $id): void {
        // Vérifier si l'utilisateur est admin
        $this->requireAdmin();
        
        // Récupérer le trajet
        $ride = $this->rideModel->getRideById($id);
        
        // Vérifier si le trajet existe
        if (!$ride) {
            $this->redirect('admin/rides');
        }
        
        // Supprimer le trajet
        if ($this->rideModel->delete($id)) {
            // Rediriger vers la liste des trajets
            $this->redirect('admin/rides');
        } else {
            // En cas d'erreur, rediriger vers la liste des trajets
            $this->redirect('admin/rides');
        }
    }
    
    /**
     * Méthode pour modifier un trajet (admin)
     * 
     * @param int $id ID du trajet
     * @return void
     */
    public function editRide(int $id): void {
        // Vérifier si l'utilisateur est admin
        $this->requireAdmin();
        
        // Récupérer le trajet
        $ride = $this->rideModel->getRideById($id);
        
        // Vérifier si le trajet existe
        if (!$ride) {
            $this->redirect('admin/rides');
        }
        
        // Récupérer les agences
        $agencies = $this->agencyModel->getAll();
        
        // Préparer les données de date et heure
        $departureDatetime = new DateTime($ride['departure_datetime']);
        $arrivalDatetime = new DateTime($ride['arrival_datetime']);
        
        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $data = [
                'departure_agency_id' => $_POST['departure_agency_id'] ?? '',
                'arrival_agency_id' => $_POST['arrival_agency_id'] ?? '',
                'departure_datetime' => $_POST['departure_date'] . ' ' . $_POST['departure_time'] ?? '',
                'arrival_datetime' => $_POST['arrival_date'] . ' ' . $_POST['arrival_time'] ?? '',
                'total_seats' => $_POST['total_seats'] ?? '',
                'available_seats' => $_POST['available_seats'] ?? ''
            ];
            
            // Valider les données
            $errors = [];
            
            if (empty($data['departure_agency_id'])) {
                $errors['departure_agency_id'] = 'L\'agence de départ est requise';
            }
            
            if (empty($data['arrival_agency_id'])) {
                $errors['arrival_agency_id'] = 'L\'agence d\'arrivée est requise';
            }
            
            if ($data['departure_agency_id'] === $data['arrival_agency_id']) {
                $errors['arrival_agency_id'] = 'L\'agence d\'arrivée doit être différente de l\'agence de départ';
            }
            
            if (empty($_POST['departure_date']) || empty($_POST['departure_time'])) {
                $errors['departure_datetime'] = 'La date et l\'heure de départ sont requises';
            }
            
            if (empty($_POST['arrival_date']) || empty($_POST['arrival_time'])) {
                $errors['arrival_datetime'] = 'La date et l\'heure d\'arrivée sont requises';
            }
            
            // Vérifier que la date d'arrivée est postérieure à la date de départ
            $departureDateTime = new DateTime($data['departure_datetime']);
            $arrivalDateTime = new DateTime($data['arrival_datetime']);
            
            if ($arrivalDateTime <= $departureDateTime) {
                $errors['arrival_datetime'] = 'La date et l\'heure d\'arrivée doivent être postérieures à la date et l\'heure de départ';
            }
            
            if (empty($data['total_seats']) || !is_numeric($data['total_seats']) || $data['total_seats'] < 1) {
                $errors['total_seats'] = 'Le nombre total de places doit être un nombre positif';
            }
            
            if (empty($data['available_seats']) || !is_numeric($data['available_seats']) || $data['available_seats'] < 0) {
                $errors['available_seats'] = 'Le nombre de places disponibles doit être un nombre positif ou nul';
            }
            
            if ($data['available_seats'] > $data['total_seats']) {
                $errors['available_seats'] = 'Le nombre de places disponibles ne peut pas être supérieur au nombre total de places';
            }
            
            // Si aucune erreur, mettre à jour le trajet
            if (empty($errors)) {
                if ($this->rideModel->update($id, $data)) {
                    // Rediriger vers la liste des trajets
                    $this->redirect('admin/rides');
                } else {
                    $errors['update'] = 'Une erreur est survenue lors de la modification du trajet';
                }
            }
            
            // S'il y a des erreurs, les passer à la vue
            $viewData = [
                'title' => 'Modifier un trajet',
                'ride' => $ride,
                'agencies' => $agencies,
                'departure_agency_id' => $data['departure_agency_id'],
                'arrival_agency_id' => $data['arrival_agency_id'],
                'departure_date' => $_POST['departure_date'] ?? '',
                'departure_time' => $_POST['departure_time'] ?? '',
                'arrival_date' => $_POST['arrival_date'] ?? '',
                'arrival_time' => $_POST['arrival_time'] ?? '',
                'total_seats' => $data['total_seats'],
                'available_seats' => $data['available_seats'],
                'errors' => $errors
            ];
            
            $this->view('admin/editRide', $viewData);
        } else {
            // Afficher le formulaire de modification
            $data = [
                'title' => 'Modifier un trajet',
                'ride' => $ride,
                'agencies' => $agencies,
                'departure_agency_id' => $ride['departure_agency_id'],
                'arrival_agency_id' => $ride['arrival_agency_id'],
                'departure_date' => $departureDatetime->format('Y-m-d'),
                'departure_time' => $departureDatetime->format('H:i'),
                'arrival_date' => $arrivalDatetime->format('Y-m-d'),
                'arrival_time' => $arrivalDatetime->format('H:i'),
                'total_seats' => $ride['total_seats'],
                'available_seats' => $ride['available_seats'],
                'errors' => []
            ];
            
            $this->view('admin/editRide', $data);
        }
    }
} 