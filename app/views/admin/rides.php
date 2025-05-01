<?php
/**
 * Vue pour la gestion des trajets (administrateur)
 */

// Démarrer la mise en tampon
ob_start();
?>

<div class="container">
    <h1 class="mb-4">Gestion des trajets</h1>
    
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Liste des trajets</h5>
        </div>
        <div class="card-body">
            <?php if (empty($rides)): ?>
                <div class="alert alert-info">
                    Aucun trajet n'a été créé pour le moment.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>De</th>
                                <th>À</th>
                                <th>Départ</th>
                                <th>Arrivée</th>
                                <th>Places</th>
                                <th>Conducteur</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rides as $ride): ?>
                                <tr>
                                    <td><?= $ride['id'] ?></td>
                                    <td><?= htmlspecialchars($ride['departure_agency_name']) ?></td>
                                    <td><?= htmlspecialchars($ride['arrival_agency_name']) ?></td>
                                    <td>
                                        <?= date('d/m/Y à H:i', strtotime($ride['departure_datetime'])) ?>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y à H:i', strtotime($ride['arrival_datetime'])) ?>
                                    </td>
                                    <td>
                                        <?= $ride['available_seats'] ?> / <?= $ride['total_seats'] ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($ride['firstname'] . ' ' . $ride['lastname']) ?>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL ?>admin/editRide/<?= $ride['id'] ?>" class="btn btn-sm btn-primary">Modifier</a>
                                        <a href="<?= BASE_URL ?>admin/deleteRide/<?= $ride['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?')">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="<?= BASE_URL ?>admin/index" class="btn btn-secondary">Retour au tableau de bord</a>
    </div>
</div>

<?php
// Récupérer le contenu mis en tampon
$content = ob_get_clean();

// Inclure le layout
require_once ROOT_PATH . '/app/views/layouts/default.php';
?> 