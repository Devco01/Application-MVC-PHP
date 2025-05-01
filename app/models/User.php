<?php
/**
 * Modèle User
 * 
 * Gère les opérations liées aux utilisateurs
 */
class User {
    /**
     * Instance de la base de données
     * 
     * @var Database
     */
    private Database $db;
    
    /**
     * Constructeur
     */
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Récupérer tous les utilisateurs
     * 
     * @return array Liste des utilisateurs
     */
    public function getAll(): array {
        return $this->db->query("SELECT * FROM users ORDER BY lastname, firstname");
    }
    
    /**
     * Récupérer un utilisateur par son ID
     * 
     * @param int $id ID de l'utilisateur
     * @return array|false Données de l'utilisateur ou false si non trouvé
     */
    public function getById(int $id): array|false {
        return $this->db->single("SELECT * FROM users WHERE id = :id", ['id' => $id]);
    }
    
    /**
     * Récupérer un utilisateur par son email
     * 
     * @param string $email Email de l'utilisateur
     * @return array|false Données de l'utilisateur ou false si non trouvé
     */
    public function getByEmail(string $email): array|false {
        return $this->db->single("SELECT * FROM users WHERE email = :email", ['email' => $email]);
    }
    
    /**
     * Vérifier les identifiants de connexion
     * 
     * @param string $email Email de l'utilisateur
     * @param string $password Mot de passe de l'utilisateur
     * @return array|false Données de l'utilisateur ou false si identifiants incorrects
     */
    public function login(string $email, string $password): array|false {
        $user = $this->getByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
} 