<?php
/**
 * Script pour tester la connexion directement dans le dossier public
 */

// Démarrer la session
session_start();

// Définir ROOT_PATH
define('ROOT_PATH', dirname(__DIR__));

// Inclure les fichiers de configuration
require_once ROOT_PATH . '/app/config/config.php';

// Connexion à la base de données
try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    echo "<h3>Statut</h3>";
    echo "✅ Connexion à la base de données réussie<br><br>";
} catch (PDOException $e) {
    die("<h3>Erreur</h3>Connexion à la base de données impossible : " . $e->getMessage());
}

// Créer un utilisateur simple pour le test
$email = 'simple@example.com';
$password = 'simple123';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Vérifier si l'utilisateur existe déjà
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();

if ($user) {
    echo "Utilisateur de test déjà existant, mise à jour du mot de passe...<br>";
    
    // Mettre à jour le mot de passe
    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
    $stmt->execute([
        'password' => $hashedPassword,
        'id' => $user['id']
    ]);
} else {
    // Créer un nouvel utilisateur
    $stmt = $pdo->prepare("INSERT INTO users (lastname, firstname, email, password, is_admin) VALUES (:lastname, :firstname, :email, :password, :is_admin)");
    $stmt->execute([
        'lastname' => 'Simple',
        'firstname' => 'User',
        'email' => $email,
        'password' => $hashedPassword,
        'is_admin' => 0
    ]);
    
    echo "Nouvel utilisateur de test créé<br>";
}

// Créer un utilisateur admin pour le test
$adminEmail = 'admin@example.com';
$adminPassword = 'admin123';
$adminHashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

// Vérifier si l'admin existe déjà
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $adminEmail]);
$admin = $stmt->fetch();

if ($admin) {
    echo "Utilisateur administrateur déjà existant, mise à jour du mot de passe...<br>";
    
    // Mettre à jour le mot de passe et s'assurer qu'il est admin
    $stmt = $pdo->prepare("UPDATE users SET password = :password, is_admin = 1 WHERE id = :id");
    $stmt->execute([
        'password' => $adminHashedPassword,
        'id' => $admin['id']
    ]);
} else {
    // Créer un nouvel admin
    $stmt = $pdo->prepare("INSERT INTO users (lastname, firstname, email, password, is_admin) VALUES (:lastname, :firstname, :email, :password, :is_admin)");
    $stmt->execute([
        'lastname' => 'Admin',
        'firstname' => 'User',
        'email' => $adminEmail,
        'password' => $adminHashedPassword,
        'is_admin' => 1
    ]);
    
    echo "Nouvel utilisateur administrateur créé<br>";
}

echo "<h3>Identifiants de connexion</h3>";
echo "<strong>Utilisateur normal :</strong><br>";
echo "Email: " . $email . "<br>";
echo "Mot de passe: " . $password . "<br><br>";

echo "<strong>Utilisateur administrateur :</strong><br>";
echo "Email: " . $adminEmail . "<br>";
echo "Mot de passe: " . $adminPassword . "<br><br>";

echo "<h3>Test de fonctionnement</h3>";
echo "<p>La connexion à la base de données fonctionne correctement.</p>";
echo "<p>Veuillez utiliser les identifiants ci-dessus pour vous connecter.</p>";
echo "<p><a href='" . BASE_URL . "auth/login' class='btn btn-primary'>Aller à la page de connexion</a></p>";

// Afficher la liste des utilisateurs
$stmt = $pdo->query("SELECT id, lastname, firstname, email, is_admin FROM users ORDER BY id");
$users = $stmt->fetchAll();

echo "<h3>Liste des utilisateurs :</h3>";
echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Admin</th></tr>";

foreach ($users as $u) {
    echo "<tr>";
    echo "<td>" . $u['id'] . "</td>";
    echo "<td>" . $u['lastname'] . "</td>";
    echo "<td>" . $u['firstname'] . "</td>";
    echo "<td>" . $u['email'] . "</td>";
    echo "<td>" . ($u['is_admin'] ? 'Oui' : 'Non') . "</td>";
    echo "</tr>";
}

echo "</table>";

// Afficher des infos de débogage
echo "<h3>Informations de débogage</h3>";
echo "PHP version: " . phpversion() . "<br>";
echo "Session ID: " . session_id() . "<br>";
echo "Cookies activés: " . (isset($_COOKIE) ? 'Oui' : 'Non') . "<br>";
echo "BASE_URL: " . BASE_URL . "<br>";
?> 