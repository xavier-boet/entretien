
# Installation et Configuration du Projet Symfony

## Étapes à suivre après avoir cloné le projet

### 1. Appliquer les migrations de la base de données

Pour appliquer les migrations de la base de données, exécutez la commande suivante :

```bash
php bin/console doctrine:migrations:migrate
```

### 2. Appliquer les migrations de la base de données

Charger les fixtures

```bash
php bin/console doctrine:fixtures:load
```


### 3. Définir un utilisateur administrateur

Directement en base, modifier un utilisateur pour le mettre admin

```
["ROLE_ADMIN"]
```

Tous les mots de passe sont ```password123```


## Problématique des Catégories

Les catégories et leur hiérarchie (parent-enfant) ont été définies par les fixtures.

Lors de l'accès à l'accueil, un menu déroulant avec les niveaux des catégories s'affiche directement.


## Problématique des utilisateurs par départements

Cette fonctionnalité est une implémentation simple, avec une structure d'entités et uniquement l'affichage des utilisateurs par département.

Voici le comportement attendu :

* Utilisateur normal : Un utilisateur classique ne verra aucune information concernant les autres utilisateurs.

* Utilisateur administrateur : Un administrateur pourra voir tous les utilisateurs appartenant aux départements auxquels il appartient.

