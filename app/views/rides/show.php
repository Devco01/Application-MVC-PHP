<?php
/**
 * Vue pour afficher les détails d'un trajet
 */

// Démarrer la mise en tampon
ob_start();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Détails du trajet</h5>
                    <button type="button" class="btn-close" aria-label="Close" onclick="window.history.back()"></button>
                </div>
                <div class="card-body">
                    <p><strong>Auteur :</strong> <?= htmlspecialchars($ride['firstname'] . ' ' . $ride['lastname']) ?></p>
                    <p><strong>Téléphone :</strong> <?= htmlspecialchars($ride['phone']) ?></p>
                    <p><strong>Email :</strong> <?= htmlspecialchars($ride['email']) ?></p>
                    <p><strong>Nombre total de places :</strong> <?= $ride['total_seats'] ?></p>
                </div>
                <div class="card-footer text-end">
                    <a href="<?= BASE_URL ?>home/index" class="btn btn-secondary">Fermer</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Récupérer le contenu mis en tampon
$content = ob_get_clean();

// Inclure le layout
require_once ROOT_PATH . '/app/views/layouts/default.php';
?> 