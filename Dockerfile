# Étape 1 : Construction de l'image
FROM php:8.1-apache

# Étape 2 : Installation de SQLite
RUN apt-get update && apt-get install -y sqlite3 libsqlite3-dev

# Étape 3 : Activation du module Apache pour PHP
RUN docker-php-ext-install pdo pdo_sqlite

# Étape 4 : Copie du code source dans le conteneur
COPY . /var/www/html/

# Etape 5 : Copier le script d'entrée
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Étape 6 : Attribution des droits appropriés
RUN chown -R www-data:www-data /var/www/html/

# Étape 7 : Exposition du port 80
EXPOSE 80

# Etape 8 : Utiliser ce script comme point d'entrée
ENTRYPOINT ["/entrypoint.sh"]