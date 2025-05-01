<?php
/**
 * Contrôleur de la page d'accueil
 */
class HomeController extends Controller {
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
        $this->rideModel = $this->model('Ride');
    }
    
    /**
     * Méthode pour afficher la page d'accueil
     * 
     * @return void
     */
    public function index(): void {
        // Récupérer tous les trajets disponibles
        $rides = $this->rideModel->getAvailableRides();
        
        // Données à passer à la vue
        $data = [
            'title' => 'Accueil - Liste des trajets disponibles',
            'rides' => $rides
        ];
        
        // Charger la vue
        $this->view('home/index', $data);
    }
} 