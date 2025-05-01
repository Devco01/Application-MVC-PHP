<?php
/**
 * Script pour tester la connexion manuellement
 */

// Démarrer la session
session_start();

// Définir ROOT_PATH
define('ROOT_PATH', dirname(__DIR__));

// Inclure les fichiers de configuration
require_once ROOT_PATH . '/app/config/config.php';

// Message de statut
$status = '';
$error = '';

// Traiter le formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs";
    } else {
        // Connexion à la base de données
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            
            // Chercher l'utilisateur par email
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Authentification réussie
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_firstname'] = $user['firstname'];
                $_SESSION['user_lastname'] = $user['lastname'];
                $_SESSION['user_is_admin'] = ($user['is_admin'] == 1);
                
                $status = "Connexion réussie! Vous êtes maintenant connecté en tant que " . $user['firstname'] . " " . $user['lastname'];
                
                // Redirection vers la page d'accueil après 2 secondes
                header("Refresh: 2; URL=" . BASE_URL);
            } else {
                $error = "Email ou mot de passe incorrect";
            }
            
        } catch (PDOException $e) {
            $error = "Erreur de connexion à la base de données: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion manuelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f8fc;
            padding: 20px;
        }
        .login-container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #384050;
            color: white;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #0074c7;
            border-color: #0074c7;
        }
        .status {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .error {
            background-color: #f8d7da;
            color: #842029;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="header">
            <h3 class="mb-0">Connexion manuelle</h3>
        </div>
        
        <?php if ($status): ?>
            <div class="status">
                <?= $status ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="error">
                <?= $error ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
        </form>
        
        <div class="mt-4">
            <h5>Comptes de test</h5>
            <p><strong>Admin:</strong> admin@example.com / admin123</p>
            <p><strong>Utilisateur:</strong> simple@example.com / simple123</p>
            <p><small>Ces comptes sont créés par le script test_connection.php. Exécutez-le d'abord si nécessaire.</small></p>
            <a href="test_connection.php" class="btn btn-sm btn-secondary">Exécuter le script de création d'utilisateurs</a>
        </div>
    </div>
</body>
</html> 