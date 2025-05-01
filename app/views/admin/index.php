<?php
/**
 * Vue du tableau de bord administrateur
 */

// Démarrer la mise en tampon
ob_start();
?>

<div class="container">
    <h1 class="mb-4">Tableau de bord administrateur</h1>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Gestion des utilisateurs</h5>
                    <p class="card-text">Consulter la liste des utilisateurs de l'application.</p>
                    <a href="<?= BASE_URL ?>admin/users" class="btn btn-light">Voir les utilisateurs</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Gestion des agences</h5>
                    <p class="card-text">Gérer les agences (création, modification, suppression).</p>
                    <a href="<?= BASE_URL ?>admin/agencies" class="btn btn-light">Gérer les agences</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Gestion des trajets</h5>
                    <p class="card-text">Consulter et gérer tous les trajets de l'application.</p>
                    <a href="<?= BASE_URL ?>admin/rides" class="btn btn-light">Gérer les trajets</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="<?= BASE_URL ?>home/index" class="btn btn-secondary">Retourner à l'accueil</a>
    </div>
</div>

<?php
// Récupérer le contenu mis en tampon
$content = ob_get_clean();

// Inclure le layout
require_once ROOT_PATH . '/app/views/layouts/default.php';
?> 