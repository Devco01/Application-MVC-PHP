# Modèle de données

## MCD (Modèle Conceptuel de Données)

Le MCD de l'application "Touche Pas Au Klaxon" comporte les entités suivantes :

### Entités

1. **USER** (Utilisateur)
   - id (identifiant)
   - lastname (nom)
   - firstname (prénom)
   - email
   - password (mot de passe)
   - phone (téléphone)
   - is_admin (statut administrateur)

2. **AGENCY** (Agence)
   - id (identifiant)
   - name (nom)

3. **RIDE** (Trajet)
   - id (identifiant)
   - departure_datetime (date et heure de départ)
   - arrival_datetime (date et heure d'arrivée)
   - total_seats (nombre total de places)
   - available_seats (nombre de places disponibles)

### Associations

1. **PROPOSES** (Propose) : Un utilisateur propose un trajet
   - Cardinalité : USER (1,N) -> RIDE (1,1)

2. **DEPARTURE** (Départ) : Un trajet part d'une agence
   - Cardinalité : AGENCY (1,N) -> RIDE (1,1)

3. **ARRIVAL** (Arrivée) : Un trajet arrive à une agence
   - Cardinalité : AGENCY (1,N) -> RIDE (1,1)

## MLD (Modèle Logique de Données)

Le MLD traduit le MCD en tables relationnelles :

```
USERS (id, lastname, firstname, email, password, phone, is_admin)
  Clé primaire : id
  
AGENCIES (id, name)
  Clé primaire : id
  
RIDES (id, departure_agency_id, arrival_agency_id, departure_datetime, arrival_datetime, total_seats, available_seats, user_id)
  Clé primaire : id
  Clés étrangères :
    - departure_agency_id -> AGENCIES(id)
    - arrival_agency_id -> AGENCIES(id)
    - user_id -> USERS(id)
```

## Explications

- La table `USERS` stocke les informations des utilisateurs qui peuvent proposer des trajets.
- La table `AGENCIES` contient les différentes agences (sites) de l'entreprise.
- La table `RIDES` enregistre les trajets proposés, avec des références vers l'utilisateur qui propose le trajet et les agences de départ et d'arrivée.

## Contraintes d'intégrité

- Un trajet doit obligatoirement avoir un utilisateur associé (qui propose le trajet).
- Un trajet doit obligatoirement avoir une agence de départ et une agence d'arrivée.
- Le nombre de places disponibles ne peut pas être supérieur au nombre total de places.
- Les agences de départ et d'arrivée d'un trajet doivent être différentes.
- La date d'arrivée doit être postérieure à la date de départ. 