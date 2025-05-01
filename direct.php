<?php
/**
 * Accès direct à l'application (contourne les problèmes de réécriture d'URL)
 */

// Définir le chemin vers le dossier de l'application
define('ROOT_PATH', __DIR__);

// Démarrer la session
session_start();

// Inclure les fichiers de configuration
require_once ROOT_PATH . '/app/config/config.php';

// Inclure les classes de base
require_once ROOT_PATH . '/app/core/App.php';
require_once ROOT_PATH . '/app/core/Controller.php';
require_once ROOT_PATH . '/app/database/Database.php';

// Créer une instance de l'application
$app = new App();
?> 