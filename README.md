# La Cantine
War Game est un projet dans le cadre du développement sécurisé dans les applications Web.
Cette application Web est une application très basique d'un restaurant volontairement vulnérable.
A  utiliser seulement de manière isolée.

## Fonctionnalités 
L'application Web de La Cantine vous permet d'avoir le menu du jour ainsi que quelques informations sur le restaurant. Il est aussi possible d'ajouter un avis au restaurant, avec la possibilité de mettre une photo et de voir les avis précédents. Les photos peuvent être chargées depuis l'appareil ou importer depuis une URL. L'administrateur de l'application web a aussi la possibilité de se connecter et d'observer tout les avis postés sur le site.

## Architecture & technologies

Serveur HTTP : Apache

Langage : PHP 8.1

BDD : SQLite

Front : HTML / CSS

Orchestration locale : Docker + docker-compose

Outils de dev : Visual Studio Code

Volumes : code source monté en volume, volume persistant pour la base de données

Port exposé par défaut : 8080:80

## Installation et Utilisation
L'application est entièrement compilée pour être utilisée avec Docker en un seul conteneur. Pour lancer l'application, il suffit d'effectuer les étapes suivantes :

Cloner le projet depuis GitHub

```
git clone https://github.com/MaelleSop/War_Game_Securite_Applicative.git
cd War_Game_Securite_Applicative
```

Copier exempleconfig.php dans config.php (le nom de fichier doit être config.php, auquel cas l'application ne fonctionnera pas)

```
cp exempleconfig.php config.php
```

Lancer l'application avec Docker

```
docker compose up -d --build
```

Donner les droits nécessaires sur le host

```
sudo chmod -R 777 .
```

Vous pouvez ensuite accéder à l'application via [http://localhost:8080](http://localhost:8080)






