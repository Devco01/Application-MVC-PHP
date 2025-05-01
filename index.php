<?php
/**
 * Point d'entrée de l'application (redirection vers public/index.php)
 */

// Définir le chemin vers le dossier de l'application
define('ROOT_PATH', __DIR__);

// Rediriger toutes les requêtes vers le dossier public
require_once ROOT_PATH . '/public/index.php'; 