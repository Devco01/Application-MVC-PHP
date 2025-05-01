<?php
/**
 * Classe de base des contrôleurs
 * 
 * Cette classe fournit les méthodes de base pour les contrôleurs
 */
class Controller {
    /**
     * Méthode pour charger un modèle
     * 
     * @param string $model Nom du modèle à charger
     * @return object Instance du modèle
     */
    protected function model(string $model): object {
        // Inclure le fichier du modèle
        require_once ROOT_PATH . '/app/models/' . $model . '.php';
        
        // Retourner une nouvelle instance du modèle
        return new $model();
    }
    
    /**
     * Méthode pour charger une vue
     * 
     * @param string $view Chemin de la vue à charger
     * @param array $data Données à passer à la vue
     * @return void
     */
    protected function view(string $view, array $data = []): void {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);
        
        // Inclure la vue
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }
    
    /**
     * Méthode pour rediriger vers une URL
     * 
     * @param string $url URL de redirection
     * @return void
     */
    protected function redirect(string $url): void {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
    
    /**
     * Méthode pour vérifier si l'utilisateur est connecté
     * 
     * @return bool Vrai si l'utilisateur est connecté, faux sinon
     */
    protected function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Méthode pour vérifier si l'utilisateur est administrateur
     * 
     * @return bool Vrai si l'utilisateur est administrateur, faux sinon
     */
    protected function isAdmin(): bool {
        return $this->isLoggedIn() && isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin'] === true;
    }
    
    /**
     * Méthode pour vérifier l'accès à une ressource (nécessite connexion)
     * 
     * @return void
     */
    protected function requireLogin(): void {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
    }
    
    /**
     * Méthode pour vérifier l'accès à une ressource (nécessite privilèges admin)
     * 
     * @return void
     */
    protected function requireAdmin(): void {
        if (!$this->isAdmin()) {
            $this->redirect('home/index');
        }
    }
} 