# forum

## Requis
- PHP 8.1
- Composer 2.1+
- Symfony CLI 5.4+

## Récupérer le projet
- Créer un nouveau dossier
```
  cd mon_nouveau_dossier
  git clone https://github.com/Darpen/forum.git forum
  cd forum
```

## Aller dans le dossier récupéré, puis lancer la commande
```
  composer install
```

# Mettre à jour la relation à la base de donnée
- Créer une base de donnée
- Dans le fichier .env => Modifier le nom de la base de donnée dans la variable DATABASE_URL
```
  DATABASE_URL="mysql://root:@127.0.0.1/metal_world"
```
## !!! Si vous n'avez pas la même configuration !!!
- Changer le système de gestion de base de donnée si vous n'êtes pas en "mysql"
- Changer le pseudo et mot de passe de connexion
- Changer l'adresse IP d'accès à phpmyadmin
- Changer le nom de la base, on utlise ici "metal_world"

## Lancer la migration dans la bdd
```
  symfony console make:migration 
  symfony console doctrine:migrations:migrate
```

## Lancer les fixtures
```
  symfony console doctrine:fixtures:load
```

## Lancer le projet
```
  symfony server:start
```
Se rendre sur l'url établi par le serveur pour accéder au projet

## Les utilisateurs disponibles
- ADMIN
  - Pseudo: mrak
  - Mot de passe: mrak
- USER
  - Pseudo: bulb
  - Mot de passe: bulb
