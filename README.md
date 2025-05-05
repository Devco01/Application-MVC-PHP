# Touche Pas Au Klaxon

Application de covoiturage interne pour une entreprise multi-sites, permettant aux employés de partager leurs trajets entre différentes agences.

## Description

Cette application web développée en PHP avec une architecture MVC permet de faciliter le covoiturage entre les différents sites d'une entreprise. Elle vise à optimiser les déplacements en réduisant le nombre de véhicules circulant avec un faible taux d'occupation.

### Fonctionnalités principales

- **Page d'accueil** : Affichage des trajets disponibles (avec places restantes) par ordre chronologique
- **Utilisateurs connectés** :
  - Consultation des détails des trajets (contact, etc.)
  - Création de nouveaux trajets
  - Modification et suppression de leurs propres trajets
- **Administrateurs** :
  - Gestion des utilisateurs (consultation)
  - Gestion des agences (création, modification, suppression)
  - Gestion des trajets (consultation, suppression)

## Technologies utilisées

- **Backend** : PHP 8 avec architecture MVC
- **Base de données** : MySQL/MariaDB
- **Frontend** : HTML5, CSS3, JavaScript
- **Framework CSS** : Bootstrap 5
- **Documentation** : DocBlock

## Installation

### Prérequis

- Serveur web (Apache, Nginx, etc.)
- PHP 8.0 ou supérieur
- MySQL 5.7 ou MariaDB 10.5 ou supérieur
- Composer (pour les dépendances PHP)

### Étapes d'installation

1. Clonez ce dépôt sur votre serveur web :
```
git clone https://github.com/Devco01/Application-MVC-PHP.git
```

2. Créez une base de données MySQL/MariaDB pour l'application

3. Importez le schéma de base de données :
```
mysql -u utilisateur -p nom_base_de_donnees < database/database.sql
```

4. Importez les données de test :
```
mysql -u utilisateur -p nom_base_de_donnees < database/sample_data.sql
```

5. Configurez l'application en modifiant le fichier `app/config/config.php` avec vos paramètres de connexion à la base de données

6. Assurez-vous que le serveur web pointe vers le dossier `public` de l'application

7. Configurez un virtualhost pour que l'URL de base soit accessible (voir [Configuration du VirtualHost](docs/virtualhost.md) pour des instructions détaillées)

### IMPORTANT POUR LE CORRECTEUR

Pour lancer correctement ce projet sur votre machine, veuillez suivre attentivement les instructions détaillées dans le document [Configuration du VirtualHost](docs/virtualhost.md). Ce document explique pas à pas comment :

- Modifier le fichier hosts sur Windows
- Configurer le VirtualHost dans XAMPP
- Vérifier que la configuration fonctionne correctement
- Configurer la base de données

Ces étapes sont essentielles pour que l'application fonctionne avec son URL personnalisée `http://covoiturage.local`.

## Utilisation

### Comptes de démonstration

- **Administrateur** :
  - Email : admin@example.com
  - Mot de passe : admin123

- **Utilisateur** :
  - Email : simple@example.com
  - Mot de passe : simple123


© 2025 - MVC PHP
