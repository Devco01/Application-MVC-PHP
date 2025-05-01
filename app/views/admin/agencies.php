<?php
/**
 * Vue pour la gestion des agences (administrateur)
 */

// Démarrer la mise en tampon
ob_start();
?>

<div class="container">
    <h1 class="mb-4">Gestion des agences</h1>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif; ?>
    
    <div class="mb-3">
        <a href="<?= BASE_URL ?>admin/createAgency" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Créer une nouvelle agence
        </a>
    </div>
    
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Liste des agences</h5>
        </div>
        <div class="card-body">
            <?php if (empty($agencies)): ?>
                <div class="alert alert-info">
                    Aucune agence n'a été créée pour le moment.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($agencies as $agency): ?>
                                <tr>
                                    <td><?= $agency['id'] ?></td>
                                    <td><?= htmlspecialchars($agency['name']) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>admin/editAgency/<?= $agency['id'] ?>" class="btn btn-sm btn-primary">Modifier</a>
                                        <a href="<?= BASE_URL ?>admin/deleteAgency/<?= $agency['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette agence ?')">Supprimer</a>
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