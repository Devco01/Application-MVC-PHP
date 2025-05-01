<?php
/**
 * Vue de la page d'accueil
 */

// Démarrer la mise en tampon
ob_start();
?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="container">
        <div class="alert alert-success">
            <?= $_SESSION['success'] ?>
        </div>
    </div>
<?php endif; ?>

<div class="container">
    <?php if (!isset($_SESSION['user_id'])): ?>
        <h3 class="mb-4">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</h3>
    <?php else: ?>
        <h3 class="mb-4">Trajets proposés</h3>
    <?php endif; ?>
    
    <?php if (empty($rides)): ?>
        <div class="alert alert-info">
            Aucun trajet disponible pour le moment.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Départ</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Destination</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Places</th>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <th></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rides as $ride): ?>
                        <tr>
                            <td><?= htmlspecialchars($ride['departure_agency_name']) ?></td>
                            <td><?= (new DateTime($ride['departure_datetime']))->format('d/m/Y') ?></td>
                            <td><?= (new DateTime($ride['departure_datetime']))->format('H:i') ?></td>
                            <td><?= htmlspecialchars($ride['arrival_agency_name']) ?></td>
                            <td><?= (new DateTime($ride['arrival_datetime']))->format('d/m/Y') ?></td>
                            <td><?= (new DateTime($ride['arrival_datetime']))->format('H:i') ?></td>
                            <td class="text-center"><?= $ride['available_seats'] ?></td>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <td class="text-center">
                                    <a href="<?= BASE_URL ?>ride/show/<?= $ride['id'] ?>" class="text-dark" title="Voir les détails"><i class="bi bi-eye"></i></a>
                                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $ride['user_id']): ?>
                                        <a href="<?= BASE_URL ?>ride/edit/<?= $ride['id'] ?>" class="text-dark mx-2" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                                        <a href="<?= BASE_URL ?>ride/delete/<?= $ride['id'] ?>" class="text-dark" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?')"><i class="bi bi-trash"></i></a>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php
// Récupérer le contenu mis en tampon
$content = ob_get_clean();

// Inclure le layout
require_once ROOT_PATH . '/app/views/layouts/default.php';
?> 