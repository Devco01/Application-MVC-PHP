<?php
/**
 * Classe principale de l'application
 * 
 * Cette classe gère le routage et l'initialisation de l'application
 */
class App {
    /**
     * Nom du contrôleur par défaut
     * 
     * @var string
     */
    protected string $controllerName = 'HomeController';
    
    /**
     * Instance du contrôleur
     * 
     * @var object
     */
    protected object $controller;
    
    /**
     * Méthode par défaut
     * 
     * @var string
     */
    protected string $method = 'index';
    
    /**
     * Paramètres de la requête
     * 
     * @var array
     */
    protected array $params = [];
    
    /**
     * Constructeur de la classe App
     */
    public function __construct() {
        $url = $this->parseUrl();
        
        // Vérifier si le contrôleur existe
        if (isset($url[0]) && file_exists(ROOT_PATH . '/app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controllerName = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }
        
        // Inclure le contrôleur
        require_once ROOT_PATH . '/app/controllers/' . $this->controllerName . '.php';
        
        // Instancier le contrôleur
        $this->controller = new $this->controllerName();
        
        // Vérifier si la méthode existe
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }
        
        // Récupérer les paramètres
        $this->params = $url ? array_values($url) : [];
        
        // Appeler la méthode du contrôleur avec les paramètres
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    
    /**
     * Méthode pour analyser l'URL
     * 
     * @return array URL décomposée
     */
    private function parseUrl(): array {
        if (isset($_GET['url'])) {
            // Nettoyer l'URL
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            
            return $url;
        }
        
        return [];
    }
} 