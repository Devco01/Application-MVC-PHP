<?php
/**
 * Script de débogage pour inspecter les sessions et les cookies
 */

// Démarrer la session
session_start();

// Définir ROOT_PATH
define('ROOT_PATH', dirname(__DIR__));

// Inclure les fichiers de configuration
require_once ROOT_PATH . '/app/config/config.php';

// Afficher les informations PHP
echo "<h1>Page de débogage</h1>";

echo "<h2>Informations PHP</h2>";
echo "<ul>";
echo "<li>Version PHP: " . phpversion() . "</li>";
echo "<li>Extensions chargées: " . count(get_loaded_extensions()) . "</li>";
echo "<li>Session activée: " . (session_status() === PHP_SESSION_ACTIVE ? 'Oui' : 'Non') . "</li>";
echo "<li>Session ID: " . session_id() . "</li>";
echo "</ul>";

// Afficher les informations sur les cookies
echo "<h2>Cookies</h2>";
if (empty($_COOKIE)) {
    echo "<p>Aucun cookie défini</p>";
} else {
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr><th>Nom</th><th>Valeur</th></tr>";
    foreach ($_COOKIE as $name => $value) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($name) . "</td>";
        echo "<td>" . htmlspecialchars($value) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Afficher les informations de session
echo "<h2>Variables de session</h2>";
if (empty($_SESSION)) {
    echo "<p>Aucune variable de session définie</p>";
} else {
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr><th>Nom</th><th>Valeur</th></tr>";
    foreach ($_SESSION as $name => $value) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($name) . "</td>";
        echo "<td>" . htmlspecialchars(is_array($value) ? 'ARRAY' : (is_object($value) ? 'OBJECT' : $value)) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Options de test de session
echo "<h2>Actions</h2>";
echo "<form method='post'>";

// Si un bouton est cliqué
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['set_session'])) {
        // Définir des variables de session de test
        $_SESSION['test_var'] = 'Test de session OK';
        $_SESSION['test_time'] = date('Y-m-d H:i:s');
        echo "<p style='color: green;'>Variables de session de test définies.</p>";
    } elseif (isset($_POST['clear_session'])) {
        // Effacer les variables de session
        session_unset();
        echo "<p style='color: orange;'>Variables de session effacées.</p>";
    } elseif (isset($_POST['destroy_session'])) {
        // Détruire la session
        session_destroy();
        echo "<p style='color: red;'>Session détruite. Veuillez actualiser la page.</p>";
    } elseif (isset($_POST['test_login'])) {
        // Simuler une connexion réussie
        $_SESSION['user_id'] = 999;
        $_SESSION['user_email'] = 'test@example.com';
        $_SESSION['user_firstname'] = 'Test';
        $_SESSION['user_lastname'] = 'User';
        $_SESSION['user_is_admin'] = false;
        echo "<p style='color: green;'>Simulation de connexion réussie.</p>";
    }
    
    // Actualiser la page pour montrer les changements
    echo "<script>window.location.reload();</script>";
}

echo "<button type='submit' name='set_session' style='margin-right: 10px;'>Définir des variables de session de test</button>";
echo "<button type='submit' name='test_login' style='margin-right: 10px;'>Simuler une connexion</button>";
echo "<button type='submit' name='clear_session' style='margin-right: 10px;'>Effacer les variables de session</button>";
echo "<button type='submit' name='destroy_session'>Détruire la session</button>";
echo "</form>";

// Lien vers d'autres outils
echo "<h2>Liens utiles</h2>";
echo "<ul>";
echo "<li><a href='test_connection.php'>Test de connexion à la base de données et création d'utilisateurs</a></li>";
echo "<li><a href='login_manual.php'>Formulaire de connexion manuel</a></li>";
echo "<li><a href='" . BASE_URL . "auth/login'>Formulaire de connexion MVC</a></li>";
echo "<li><a href='" . BASE_URL . "'>Page d'accueil</a></li>";
echo "</ul>";

// Afficher phpinfo simplifié
echo "<h2>Configuration PHP</h2>";
echo "<div style='height: 300px; overflow: auto; border: 1px solid #ccc; padding: 10px;'>";
ob_start();
phpinfo(INFO_CONFIGURATION);
$phpinfo = ob_get_clean();

// Nettoyer le HTML pour afficher uniquement le contenu
$phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%s', '$1', $phpinfo);
$phpinfo = str_replace('<table', '<table class="phpinfo" style="width:100%; border-collapse: collapse;"', $phpinfo);
$phpinfo = str_replace('<td class="e"', '<td style="background-color:#f0f0f0; padding:5px; border:1px solid #ccc;"', $phpinfo);
$phpinfo = str_replace('<td class="v"', '<td style="padding:5px; border:1px solid #ccc;"', $phpinfo);
$phpinfo = str_replace('<h1', '<h3', $phpinfo);
$phpinfo = str_replace('</h1', '</h3', $phpinfo);
$phpinfo = str_replace('<h2', '<h4', $phpinfo);
$phpinfo = str_replace('</h2', '</h4', $phpinfo);
echo $phpinfo;
echo "</div>";
?> 