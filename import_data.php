<?php
/**
 * Script d'importation des données à partir des fichiers annexes
 */

// Inclure la configuration
require_once 'app/config/config.php';

// Connexion à la base de données
try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    echo "Connexion à la base de données établie.<br>";
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vider les tables existantes (en respectant les contraintes de clé étrangère)
try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("TRUNCATE TABLE rides");
    $pdo->exec("TRUNCATE TABLE agencies");
    $pdo->exec("TRUNCATE TABLE users");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "Tables vidées avec succès.<br>";
} catch (PDOException $e) {
    die("Erreur lors de la réinitialisation des tables : " . $e->getMessage());
}

// Importer les agences
$agencesFile = 'c:/Users/UTILISATEUR/annexe devoir php/jeu-d-essais/agences.txt';
$agences = file($agencesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if ($agences === false) {
    die("Erreur lors de la lecture du fichier des agences.");
}

try {
    $stmt = $pdo->prepare("INSERT INTO agencies (name) VALUES (:name)");
    foreach ($agences as $agence) {
        $stmt->execute(['name' => trim($agence)]);
    }
    echo "Importation de " . count($agences) . " agences réussie.<br>";
} catch (PDOException $e) {
    die("Erreur lors de l'importation des agences : " . $e->getMessage());
}

// Importer les utilisateurs
$usersFile = 'c:/Users/UTILISATEUR/annexe devoir php/jeu-d-essais/users.txt';
$users = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if ($users === false) {
    die("Erreur lors de la lecture du fichier des utilisateurs.");
}

try {
    $stmt = $pdo->prepare("INSERT INTO users (lastname, firstname, phone, email, password, is_admin) VALUES (:lastname, :firstname, :phone, :email, :password, :is_admin)");
    
    // Mot de passe par défaut : "password" (hashé)
    $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
    
    foreach ($users as $index => $user) {
        $userData = explode(',', $user);
        if (count($userData) >= 4) {
            $lastname = trim($userData[0]);
            $firstname = trim($userData[1]);
            $phone = trim($userData[2]);
            $email = trim($userData[3]);
            
            // Le premier utilisateur sera administrateur
            $isAdmin = ($index === 0) ? 1 : 0;
            
            $stmt->execute([
                'lastname' => $lastname,
                'firstname' => $firstname,
                'phone' => $phone,
                'email' => $email,
                'password' => $hashedPassword,
                'is_admin' => $isAdmin
            ]);
        }
    }
    echo "Importation de " . count($users) . " utilisateurs réussie.<br>";
} catch (PDOException $e) {
    die("Erreur lors de l'importation des utilisateurs : " . $e->getMessage());
}

// Créer quelques trajets d'exemple
try {
    $stmt = $pdo->prepare("
        INSERT INTO rides (
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
            :available_seats, 
            :user_id
        )
    ");
    
    // Récupérer les IDs des agences
    $agencyIds = $pdo->query("SELECT id FROM agencies ORDER BY id")->fetchAll(PDO::FETCH_COLUMN);
    
    // Récupérer les IDs des utilisateurs non-admin
    $userIds = $pdo->query("SELECT id FROM users WHERE is_admin = 0 ORDER BY id")->fetchAll(PDO::FETCH_COLUMN);
    
    // Créer 10 trajets aléatoires
    $now = new DateTime();
    $ridesCount = 0;
    
    for ($i = 1; $i <= 10; $i++) {
        // Sélectionner aléatoirement des agences différentes
        $departureAgencyIndex = array_rand($agencyIds);
        $arrivalAgencyIndex = $departureAgencyIndex;
        
        // S'assurer que les agences de départ et d'arrivée sont différentes
        while ($arrivalAgencyIndex === $departureAgencyIndex) {
            $arrivalAgencyIndex = array_rand($agencyIds);
        }
        
        $departureAgencyId = $agencyIds[$departureAgencyIndex];
        $arrivalAgencyId = $agencyIds[$arrivalAgencyIndex];
        
        // Générer des dates aléatoires dans le futur
        $departureDays = rand(1, 30);
        $departureHours = rand(0, 23);
        $departureMinutes = rand(0, 59);
        
        $departure = clone $now;
        $departure->add(new DateInterval("P{$departureDays}DT{$departureHours}H{$departureMinutes}M"));
        
        // L'arrivée est entre 1 et 8 heures après le départ
        $travelHours = rand(1, 8);
        $travelMinutes = rand(0, 59);
        
        $arrival = clone $departure;
        $arrival->add(new DateInterval("PT{$travelHours}H{$travelMinutes}M"));
        
        // Nombre de places
        $totalSeats = rand(2, 6);
        $availableSeats = rand(0, $totalSeats);
        
        // Utilisateur aléatoire
        $userId = $userIds[array_rand($userIds)];
        
        $stmt->execute([
            'departure_agency_id' => $departureAgencyId,
            'arrival_agency_id' => $arrivalAgencyId,
            'departure_datetime' => $departure->format('Y-m-d H:i:s'),
            'arrival_datetime' => $arrival->format('Y-m-d H:i:s'),
            'total_seats' => $totalSeats,
            'available_seats' => $availableSeats,
            'user_id' => $userId
        ]);
        
        $ridesCount++;
    }
    
    echo "Création de {$ridesCount} trajets d'exemple réussie.<br>";
    echo "<br>Importation des données terminée avec succès !";
} catch (PDOException $e) {
    die("Erreur lors de la création des trajets : " . $e->getMessage());
} 