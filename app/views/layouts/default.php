<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? APP_NAME ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Styles personnalisés avec les variables de couleur -->
    <style>
        :root {
            --color-white: <?= COLOR_WHITE ?>;
            --color-blue: <?= COLOR_BLUE ?>;
            --color-dark-blue: <?= COLOR_DARK_BLUE ?>;
            --color-dark-grey: <?= COLOR_DARK_GREY ?>;
            --color-red: <?= COLOR_RED ?>;
            --color-green: <?= COLOR_GREEN ?>;
        }
        
        html, body {
            height: 100%;
            margin: 0;
        }
        
        body {
            background-color: var(--color-white);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1 0 auto;
        }
        
        .table-dark {
            background-color: var(--color-dark-blue);
        }
        
        /* Surcharger les classes de Bootstrap pour les entêtes de tableau */
        .table-dark th, 
        .table-dark td, 
        .table-dark thead th {
            background-color: var(--color-dark-blue);
            border-color: var(--color-dark-blue);
        }
        
        /* Style pour les en-têtes de cartes */
        .card-header.bg-dark {
            background-color: var(--color-dark-blue) !important;
            border-color: var(--color-dark-blue);
        }
        
        .btn-dark {
            background-color: var(--color-dark-grey);
            border-color: var(--color-dark-grey);
        }
        
        .btn-primary {
            background-color: var(--color-blue);
            border-color: var(--color-blue);
        }
        
        .btn-primary:hover {
            background-color: var(--color-dark-blue);
            border-color: var(--color-dark-blue);
        }
        
        .btn-success {
            background-color: var(--color-green);
            border-color: var(--color-green);
        }
        
        .btn-danger {
            background-color: var(--color-red);
            border-color: var(--color-red);
        }
        
        footer {
            background-color: var(--color-dark-grey);
            color: var(--color-white);
            padding: 1rem 0;
            margin-top: auto;
            flex-shrink: 0;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php require_once ROOT_PATH . '/app/views/includes/header.php'; ?>
    
    <!-- Contenu principal -->
    <main class="py-4">
        <?= $content ?>
    </main>
    
    <!-- Footer -->
    <?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 