<?php
/**
 * Modèle Ride
 * 
 * Gère les opérations liées aux trajets
 */
class Ride {
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
     * Récupérer tous les trajets disponibles (avec places > 0) et à venir
     * 
     * @return array Liste des trajets disponibles
     */
    public function getAvailableRides(): array {
        $query = "SELECT r.*, 
                    a1.name AS departure_agency_name, 
                    a2.name AS arrival_agency_name,
                    u.firstname, u.lastname, u.email, u.phone
                FROM rides r
                JOIN agencies a1 ON r.departure_agency_id = a1.id
                JOIN agencies a2 ON r.arrival_agency_id = a2.id
                JOIN users u ON r.user_id = u.id
                WHERE r.available_seats > 0 
                AND r.departure_datetime > NOW()
                ORDER BY r.departure_datetime ASC";
        
        return $this->db->query($query);
    }
    
    /**
     * Récupérer tous les trajets
     * 
     * @return array Liste de tous les trajets
     */
    public function getAllRides(): array {
        $query = "SELECT r.*, 
                    a1.name AS departure_agency_name, 
                    a2.name AS arrival_agency_name,
                    u.firstname, u.lastname, u.email, u.phone
                FROM rides r
                JOIN agencies a1 ON r.departure_agency_id = a1.id
                JOIN agencies a2 ON r.arrival_agency_id = a2.id
                JOIN users u ON r.user_id = u.id
                ORDER BY r.departure_datetime ASC";
        
        return $this->db->query($query);
    }
    
    /**
     * Récupérer un trajet par son ID
     * 
     * @param int $id ID du trajet
     * @return array|false Données du trajet ou false si non trouvé
     */
    public function getRideById(int $id): array|false {
        $query = "SELECT r.*, 
                    a1.name AS departure_agency_name, 
                    a2.name AS arrival_agency_name,
                    u.firstname, u.lastname, u.email, u.phone
                FROM rides r
                JOIN agencies a1 ON r.departure_agency_id = a1.id
                JOIN agencies a2 ON r.arrival_agency_id = a2.id
                JOIN users u ON r.user_id = u.id
                WHERE r.id = :id";
        
        return $this->db->single($query, ['id' => $id]);
    }
    
    /**
     * Récupérer les trajets d'un utilisateur
     * 
     * @param int $userId ID de l'utilisateur
     * @return array Liste des trajets de l'utilisateur
     */
    public function getRidesByUserId(int $userId): array {
        $query = "SELECT r.*, 
                    a1.name AS departure_agency_name, 
                    a2.name AS arrival_agency_name
                FROM rides r
                JOIN agencies a1 ON r.departure_agency_id = a1.id
                JOIN agencies a2 ON r.arrival_agency_id = a2.id
                WHERE r.user_id = :user_id
                ORDER BY r.departure_datetime ASC";
        
        return $this->db->query($query, ['user_id' => $userId]);
    }
    
    /**
     * Créer un nouveau trajet
     * 
     * @param array $data Données du trajet
     * @return bool Succès de l'opération
     */
    public function create(array $data): bool {
        $query = "INSERT INTO rides (
                    departure_agency_id, 
                    arrival_agency_id, 
                    departure_datetime, 
                    arrival_datetime, 
                    total_seats, 
                    available_seats, 
                    user_id
                ) VALUES (
                    :departure_agency_id, 
                    :arrival_agency_id, 
                    :departure_datetime, 
                    :arrival_datetime, 
                    :total_seats, 
                    :total_seats, 
                    :user_id
                )";
        
        $params = [
            'departure_agency_id' => $data['departure_agency_id'],
            'arrival_agency_id' => $data['arrival_agency_id'],
            'departure_datetime' => $data['departure_datetime'],
            'arrival_datetime' => $data['arrival_datetime'],
            'total_seats' => $data['total_seats'],
            'user_id' => $data['user_id']
        ];
        
        return $this->db->execute($query, $params) > 0;
    }
    
    /**
     * Mettre à jour un trajet
     * 
     * @param int $id ID du trajet
     * @param array $data Données du trajet
     * @return bool Succès de l'opération
     */
    public function update(int $id, array $data): bool {
        $query = "UPDATE rides SET 
                    departure_agency_id = :departure_agency_id, 
                    arrival_agency_id = :arrival_agency_id, 
                    departure_datetime = :departure_datetime, 
                    arrival_datetime = :arrival_datetime, 
                    total_seats = :total_seats, 
                    available_seats = :available_seats
                  WHERE id = :id";
        
        $params = [
            'id' => $id,
            'departure_agency_id' => $data['departure_agency_id'],
            'arrival_agency_id' => $data['arrival_agency_id'],
            'departure_datetime' => $data['departure_datetime'],
            'arrival_datetime' => $data['arrival_datetime'],
            'total_seats' => $data['total_seats'],
            'available_seats' => $data['available_seats']
        ];
        
        return $this->db->execute($query, $params) > 0;
    }
    
    /**
     * Supprimer un trajet
     * 
     * @param int $id ID du trajet
     * @return bool Succès de l'opération
     */
    public function delete(int $id): bool {
        $query = "DELETE FROM rides WHERE id = :id";
        
        return $this->db->execute($query, ['id' => $id]) > 0;
    }
} 