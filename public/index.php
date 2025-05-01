<?php
/**
 * Point d'entrée de l'application
 */

// Démarrer la session
session_start();

// Définir ROOT_PATH s'il n'est pas déjà défini
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

// Inclure les fichiers de configuration
require_once ROOT_PATH . '/app/config/config.php';

// Inclure les classes de base
require_once ROOT_PATH . '/app/core/App.php';
require_once ROOT_PATH . '/app/core/Controller.php';
require_once ROOT_PATH . '/app/database/Database.php';

// Créer une instance de l'application
$app = new App(); 