# Construction de l'image
FROM php:8.1-apache

# Installation de SQLite
RUN apt-get update && apt-get install -y sqlite3 libsqlite3-dev

# Activation du module Apache pour PHP
RUN docker-php-ext-install pdo pdo_sqlite

# Copie du code source dans le conteneur
COPY . /var/www/html/

# Créer le dossier data et donner les droits à www-data
RUN mkdir -p /var/www/html/data \
    && chown -R www-data:www-data /var/www/html/data \
    && chmod -R 775 /var/www/html/data

# Copier le script d'entrée
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Attribution des droits appropriés
RUN chown -R www-data:www-data /var/www/html/

# Exposition du port 80
EXPOSE 80

# Utiliser ce script comme point d'entrée
ENTRYPOINT ["/entrypoint.sh"]