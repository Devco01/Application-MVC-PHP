# Configuration du VirtualHost

Ce document explique comment configurer un "virtualhost" (hôte virtuel) pour l'application "Touche Pas Au Klaxon". Un virtualhost permet d'accéder à l'application via une adresse personnalisée comme `http://covoiturage.local` plutôt que `http://localhost/dossier-du-projet`.

## Configuration avec XAMPP (Windows)

### Étape 1: Modifier le fichier hosts

Le fichier "hosts" permet à votre ordinateur de rediriger certaines adresses web vers votre propre machine.

1. Ouvrez l'Explorateur de fichiers Windows
2. Accédez au dossier: `C:\Windows\System32\drivers\etc\`
3. Faites un clic droit sur le fichier `hosts` et choisissez "Ouvrir avec" → "Bloc-notes" (ou Notepad++)
   > **Note**: Vous devrez peut-être exécuter votre éditeur de texte en tant qu'administrateur. Pour cela, faites un clic droit sur l'icône de l'éditeur et choisissez "Exécuter en tant qu'administrateur"
4. Ajoutez la ligne suivante à la fin du fichier:
   ```
   127.0.0.1    covoiturage.local
   ```
5. Enregistrez le fichier

### Étape 2: Configurer le VirtualHost dans XAMPP

1. Ouvrez le Panneau de contrôle XAMPP
2. Cliquez sur le bouton "Config" à côté d'Apache
3. Sélectionnez "Apache (httpd-vhosts.conf)"
4. Ajoutez les lignes suivantes à la fin du fichier:

   ```apache
   # Configuration par défaut pour localhost
   <VirtualHost *:80>
       DocumentRoot "C:/xampp/htdocs"
       ServerName localhost
   </VirtualHost>
   
   # Configuration pour notre application de covoiturage
   <VirtualHost *:80>
       ServerName covoiturage.local
       DocumentRoot "C:/Users/UTILISATEUR/applicationMVC en PHP/public"
       
       <Directory "C:/Users/UTILISATEUR/applicationMVC en PHP/public">
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
       
       ErrorLog "logs/covoiturage-error.log"
       CustomLog "logs/covoiturage-access.log" combined
   </VirtualHost>
   ```
   
   > **IMPORTANT**: Remplacez `C:/Users/UTILISATEUR/applicationMVC en PHP/public` par le chemin complet vers le dossier `public` de votre application sur votre ordinateur.

5. Enregistrez le fichier
6. Redémarrez Apache en cliquant sur "Stop" puis "Start" dans le Panneau de contrôle XAMPP

### Étape 3: Vérifier la configuration

1. Ouvrez votre navigateur web (Chrome, Firefox, Edge...)
2. Tapez l'adresse: `http://covoiturage.local`
3. Vous devriez voir la page d'accueil de l'application

Si vous voyez une erreur, vérifiez les points suivants:
- Apache est bien démarré dans XAMPP
- Le fichier hosts a bien été modifié et enregistré
- Le chemin vers le dossier public est correct dans la configuration du virtualhost

## Explication des termes techniques

- **VirtualHost**: Permet à un seul serveur web de gérer plusieurs sites web avec des noms différents
- **DocumentRoot**: Le dossier racine où se trouvent les fichiers du site web
- **ServerName**: Le nom que l'utilisateur saisira dans son navigateur
- **AllowOverride All**: Permet l'utilisation de fichiers .htaccess pour des configurations spécifiques
- **Require all granted**: Autorise tout le monde à accéder au site

## Configuration de la base de données

N'oubliez pas de configurer correctement le fichier `app/config/config.php` pour qu'il utilise les bons paramètres de connexion à la base de données:

```php
// Configuration de la base de données
define('DB_HOST', 'localhost');     // Adresse du serveur MySQL (généralement localhost)
define('DB_USER', 'root');          // Nom d'utilisateur MySQL (root par défaut dans XAMPP)
define('DB_PASS', '');              // Mot de passe MySQL (vide par défaut dans XAMPP)
define('DB_NAME', 'covoiturage');   // Nom de la base de données que vous avez créée
```

Modifiez ces valeurs selon votre configuration MySQL/MariaDB. 