# forum

## Requis
- PHP 8.1

## Récupérer le projet
```
  git clone https://github.com/Darpen/forum.git
```

## Aller dans le dossier récupéré, puis lancer la commande
```
  composer install
```

## Mettre à jour la relation à la base de donnée
Dans le fichier .env => Modifier le nom de la base de donnée dans la variable DATABASE_URL
```
  DATABASE_URL="mysql://root:@127.0.0.1/ma_bdd"
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
