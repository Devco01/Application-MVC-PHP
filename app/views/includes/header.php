<header>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3 border rounded my-2 px-3">
            <a href="<?= BASE_URL ?>home/index" class="text-decoration-none">
                <h5 class="mb-0 text-dark">Touche pas au klaxon</h5>
            </a>
            <div>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <?php if (isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin']) : ?>
                        <!-- Menu administrateur -->
                        <a href="<?= BASE_URL ?>admin/users" class="btn btn-secondary me-2">Utilisateurs</a>
                        <a href="<?= BASE_URL ?>admin/agencies" class="btn btn-secondary me-2">Agences</a>
                        <a href="<?= BASE_URL ?>admin/rides" class="btn btn-secondary me-2">Trajets</a>
                        <span class="me-2">Bonjour <?= htmlspecialchars($_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname']) ?></span>
                        <a href="<?= BASE_URL ?>auth/logout" class="btn btn-dark">Déconnexion</a>
                    <?php else : ?>
                        <!-- Menu utilisateur connecté -->
                        <a href="<?= BASE_URL ?>ride/create" class="btn btn-dark me-2">Créer un trajet</a>
                        <span class="me-2">Bonjour <?= htmlspecialchars($_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname']) ?></span>
                        <a href="<?= BASE_URL ?>auth/logout" class="btn btn-dark">Déconnexion</a>
                    <?php endif; ?>
                <?php else : ?>
                    <!-- Menu utilisateur non connecté -->
                    <a href="<?= BASE_URL ?>auth/login" class="btn btn-dark">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header> 