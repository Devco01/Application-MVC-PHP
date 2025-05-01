<?php
/**
 * Modèle Agency
 * 
 * Gère les opérations liées aux agences (villes)
 */
class Agency {
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
     * Récupérer toutes les agences
     * 
     * @return array Liste des agences
     */
    public function getAll(): array {
        return $this->db->query("SELECT * FROM agencies ORDER BY name");
    }
    
    /**
     * Récupérer une agence par son ID
     * 
     * @param int $id ID de l'agence
     * @return array|false Données de l'agence ou false si non trouvée
     */
    public function getById(int $id): array|false {
        return $this->db->single("SELECT * FROM agencies WHERE id = :id", ['id' => $id]);
    }
    
    /**
     * Créer une nouvelle agence
     * 
     * @param array $data Données de l'agence
     * @return bool Succès de l'opération
     */
    public function create(array $data): bool {
        $query = "INSERT INTO agencies (name) VALUES (:name)";
        
        return $this->db->execute($query, ['name' => $data['name']]) > 0;
    }
    
    /**
     * Mettre à jour une agence
     * 
     * @param int $id ID de l'agence
     * @param array $data Données de l'agence
     * @return bool Succès de l'opération
     */
    public function update(int $id, array $data): bool {
        $query = "UPDATE agencies SET name = :name WHERE id = :id";
        
        return $this->db->execute($query, ['id' => $id, 'name' => $data['name']]) > 0;
    }
    
    /**
     * Supprimer une agence
     * 
     * @param int $id ID de l'agence
     * @return bool Succès de l'opération
     */
    public function delete(int $id): bool {
        // Vérifier si l'agence est utilisée dans un trajet
        $checkQuery = "SELECT COUNT(*) as count FROM rides WHERE departure_agency_id = :id OR arrival_agency_id = :id";
        $result = $this->db->single($checkQuery, ['id' => $id]);
        
        if ($result['count'] > 0) {
            // L'agence est utilisée, impossible de la supprimer
            return false;
        }
        
        $query = "DELETE FROM agencies WHERE id = :id";
        
        return $this->db->execute($query, ['id' => $id]) > 0;
    }
} 