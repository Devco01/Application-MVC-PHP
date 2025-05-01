<?php
/**
 * Vue du formulaire de connexion
 */

// Démarrer la mise en tampon
ob_start();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header bg-dark text-white">
                    <h3 class="mb-0">Connexion</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($errors['login'])): ?>
                        <div class="alert alert-danger bg-danger-subtle text-dark border-0">
                            Email ou mot de passe incorrect
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?= BASE_URL ?>auth/login" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" style="background-color: <?= COLOR_BLUE ?>; border-color: <?= COLOR_BLUE ?>;">Se connecter</button>
                        </div>
                    </form>
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