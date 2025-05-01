<?php
/**
 * Contrôleur des trajets
 */
class RideController extends Controller {
    /**
     * Modèle des trajets
     * 
     * @var Ride
     */
    private Ride $rideModel;
    
    /**
     * Modèle des agences
     * 
     * @var Agency
     */
    private Agency $agencyModel;
    
    /**
     * Modèle des utilisateurs
     * 
     * @var User
     */
    private User $userModel;
    
    /**
     * Constructeur
     */
    public function __construct() {
        $this->rideModel = $this->model('Ride');
        $this->agencyModel = $this->model('Agency');
        $this->userModel = $this->model('User');
    }
    
    /**
     * Méthode pour afficher les détails d'un trajet
     * 
     * @param int $id ID du trajet
     * @return void
     */
    public function show(int $id): void {
        // Vérifier si l'utilisateur est connecté
        $this->requireLogin();
        
        // Récupérer le trajet
        $ride = $this->rideModel->getRideById($id);
        
        // Vérifier si le trajet existe
        if (!$ride) {
            $this->redirect('home/index');
        }
        
        // Données à passer à la vue
        $data = [
            'title' => 'Détails du trajet',
            'ride' => $ride
        ];
        
        // Charger la vue
        $this->view('rides/show', $data);
    }
    
    /**
     * Méthode pour afficher le formulaire de création d'un trajet
     * 
     * @return void
     */
    public function create(): void {
        // Vérifier si l'utilisateur est connecté
        $this->requireLogin();
        
        // Récupérer les agences
        $agencies = $this->agencyModel->getAll();
        
        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $data = [
                'departure_agency_id' => $_POST['departure_agency_id'] ?? '',
                'arrival_agency_id' => $_POST['arrival_agency_id'] ?? '',
                'departure_datetime' => $_POST['departure_date'] . ' ' . $_POST['departure_time'] ?? '',
                'arrival_datetime' => $_POST['arrival_date'] . ' ' . $_POST['arrival_time'] ?? '',
                'total_seats' => $_POST['total_seats'] ?? '',
                'user_id' => $_SESSION['user_id']
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
            
            // Si aucune erreur, créer le trajet
            if (empty($errors)) {
                if ($this->rideModel->create($data)) {
                    // Rediriger vers la page d'accueil
                    $this->redirect('home/index');
                } else {
                    $errors['create'] = 'Une erreur est survenue lors de la création du trajet';
                }
            }
            
            // S'il y a des erreurs, les passer à la vue
            $viewData = [
                'title' => 'Créer un trajet',
                'agencies' => $agencies,
                'departure_agency_id' => $data['departure_agency_id'],
                'arrival_agency_id' => $data['arrival_agency_id'],
                'departure_date' => $_POST['departure_date'] ?? '',
                'departure_time' => $_POST['departure_time'] ?? '',
                'arrival_date' => $_POST['arrival_date'] ?? '',
                'arrival_time' => $_POST['arrival_time'] ?? '',
                'total_seats' => $data['total_seats'],
                'errors' => $errors
            ];
            
            $this->view('rides/create', $viewData);
        } else {
            // Afficher le formulaire de création
            $data = [
                'title' => 'Créer un trajet',
                'agencies' => $agencies,
                'departure_agency_id' => '',
                'arrival_agency_id' => '',
                'departure_date' => '',
                'departure_time' => '',
                'arrival_date' => '',
                'arrival_time' => '',
                'total_seats' => '',
                'errors' => []
            ];
            
            $this->view('rides/create', $data);
        }
    }
    
    /**
     * Méthode pour afficher le formulaire de modification d'un trajet
     * 
     * @param int $id ID du trajet
     * @return void
     */
    public function edit(int $id): void {
        // Vérifier si l'utilisateur est connecté
        $this->requireLogin();
        
        // Récupérer le trajet
        $ride = $this->rideModel->getRideById($id);
        
        // Vérifier si le trajet existe et si l'utilisateur est l'auteur ou admin
        if (!$ride || ($ride['user_id'] != $_SESSION['user_id'] && !$this->isAdmin())) {
            $this->redirect('home/index');
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
                    // Rediriger vers la page d'accueil
                    $this->redirect('home/index');
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
            
            $this->view('rides/edit', $viewData);
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
            
            $this->view('rides/edit', $data);
        }
    }
    
    /**
     * Méthode pour supprimer un trajet
     * 
     * @param int $id ID du trajet
     * @return void
     */
    public function delete(int $id): void {
        // Vérifier si l'utilisateur est connecté
        $this->requireLogin();
        
        // Récupérer le trajet
        $ride = $this->rideModel->getRideById($id);
        
        // Vérifier si le trajet existe et si l'utilisateur est l'auteur ou admin
        if (!$ride || ($ride['user_id'] != $_SESSION['user_id'] && !$this->isAdmin())) {
            $this->redirect('home/index');
        }
        
        // Supprimer le trajet
        if ($this->rideModel->delete($id)) {
            // Rediriger vers la page d'accueil
            $this->redirect('home/index');
        } else {
            // En cas d'erreur, rediriger vers la page d'accueil
            $this->redirect('home/index');
        }
    }
} 