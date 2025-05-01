<?php
/**
 * Vue pour la gestion des utilisateurs (administrateur)
 */

// Démarrer la mise en tampon
ob_start();
?>

<div class="container">
    <h1 class="mb-4">Gestion des utilisateurs</h1>
    
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Liste des utilisateurs</h5>
        </div>
        <div class="card-body">
            <?php if (empty($users)): ?>
                <div class="alert alert-info">
                    Aucun utilisateur n'a été créé pour le moment.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= htmlspecialchars($user['lastname']) ?></td>
                                    <td><?= htmlspecialchars($user['firstname']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <?php if ($user['is_admin']): ?>
                                            <span class="badge bg-success">Oui</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Non</span>
                                        <?php endif; ?>
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