<?php
/**
 * Classe de gestion de la connexion à la base de données
 * 
 * Cette classe utilise le pattern Singleton pour assurer une seule connexion à la base de données
 */
class Database {
    /**
     * Instance unique de la classe Database
     * 
     * @var Database|null
     */
    private static ?Database $instance = null;
    
    /**
     * Instance PDO de connexion à la base de données
     * 
     * @var PDO|null
     */
    private ?PDO $connection = null;
    
    /**
     * Constructeur privé (pattern Singleton)
     */
    private function __construct() {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            die();
        }
    }
    
    /**
     * Méthode pour obtenir l'instance unique de Database
     * 
     * @return Database Instance unique de la classe Database
     */
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Méthode pour obtenir la connexion PDO
     * 
     * @return PDO La connexion PDO à la base de données
     */
    public function getConnection(): PDO {
        return $this->connection;
    }
    
    /**
     * Méthode pour exécuter une requête et retourner plusieurs résultats
     * 
     * @param string $query La requête SQL à exécuter
     * @param array $params Les paramètres de la requête
     * @return array Les résultats de la requête
     */
    public function query(string $query, array $params = []): array {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }
    
    /**
     * Méthode pour exécuter une requête et retourner un seul résultat
     * 
     * @param string $query La requête SQL à exécuter
     * @param array $params Les paramètres de la requête
     * @return array|false Le résultat de la requête ou false si aucun résultat
     */
    public function single(string $query, array $params = []): array|false {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        
        return $stmt->fetch();
    }
    
    /**
     * Méthode pour exécuter une requête sans retour de résultat (INSERT, UPDATE, DELETE)
     * 
     * @param string $query La requête SQL à exécuter
     * @param array $params Les paramètres de la requête
     * @return int Le nombre de lignes affectées
     */
    public function execute(string $query, array $params = []): int {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        
        return $stmt->rowCount();
    }
    
    /**
     * Méthode pour obtenir le dernier ID inséré
     * 
     * @return string Le dernier ID inséré
     */
    public function lastInsertId(): string {
        return $this->connection->lastInsertId();
    }
} 