<?php
/**
 * Contrôleur d'authentification
 */
class AuthController extends Controller {
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
        $this->userModel = $this->model('User');
    }
    
    /**
     * Méthode pour afficher le formulaire de connexion
     * 
     * @return void
     */
    public function login(): void {
        // Si l'utilisateur est déjà connecté, rediriger vers la page d'accueil
        if ($this->isLoggedIn()) {
            $this->redirect('home/index');
        }
        
        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Valider les données
            $errors = [];
            
            if (empty($email)) {
                $errors['email'] = 'L\'adresse email est requise';
            }
            
            if (empty($password)) {
                $errors['password'] = 'Le mot de passe est requis';
            }
            
            // Si aucune erreur, tenter la connexion
            if (empty($errors)) {
                $user = $this->userModel->login($email, $password);
                
                if ($user) {
                    // Créer la session utilisateur
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_firstname'] = $user['firstname'];
                    $_SESSION['user_lastname'] = $user['lastname'];
                    $_SESSION['user_is_admin'] = ($user['is_admin'] == 1);
                    
                    // Rediriger vers la page d'accueil
                    $this->redirect('home/index');
                } else {
                    $errors['login'] = 'Email ou mot de passe incorrect';
                }
            }
            
            // S'il y a des erreurs, les passer à la vue
            $data = [
                'title' => 'Connexion',
                'email' => $email,
                'errors' => $errors
            ];
            
            $this->view('auth/login', $data);
        } else {
            // Afficher le formulaire de connexion
            $data = [
                'title' => 'Connexion',
                'email' => '',
                'errors' => []
            ];
            
            $this->view('auth/login', $data);
        }
    }
    
    /**
     * Méthode pour déconnecter l'utilisateur
     * 
     * @return void
     */
    public function logout(): void {
        // Détruire la session
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_is_admin']);
        
        session_destroy();
        
        // Rediriger vers la page d'accueil
        $this->redirect('home/index');
    }
} 