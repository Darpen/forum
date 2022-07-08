# Processus de création
## Création du Symfony
- Création de la structure de symfony
```
  composer create-project symfony/skeleton:"6.1.*" forum
```
- installation du vendor avec composer install

# Données
- Création des entités
- Création des fixtures
- Création des différent fichiers fixtures liés aux entités
- Liaison entre les fixtures avec les dépendances
- Intégration des données dans la base

# Gestion de l'accès
- utilisation de "is_granted"
- utilisation de "denyAccessUnlessGranted"

# Application
- Création des Controllers
- Création des FormTypes pour afficher les formulaires de création et de modification
- Requête sur les entités avec les méthodes par défaut des Repository : findAll(), findBy(), count()

# Bonus
## Connexion utilisateur
- Création d'une table jointe à user ConnectionHistories
- Création d'un eventListener pour écouter l'action de connexion de l'utilisateur
- On récupère son adresse via l'event->request et on ajoute dans la table jointe à chaque connexion de l'utilisateur et lors de la création de compte

## Ajouter des réactions
- Création d'une table UserVote avec un champ action, user et message
- Création de 2 constantes de classe UP et DOWN qui permette de renseigner le champ action
- Gestion des ajouts de réaction en AJAX avec fetch et en javascript natif

