# Construction de l'image
FROM php:8.1-apache

# Installation de SQLite et gosu
RUN apt-get update && apt-get install -y sqlite3 libsqlite3-dev gosu

# Activation du module Apache pour PHP
RUN docker-php-ext-install pdo pdo_sqlite

# Copie du code source dans le conteneur
COPY . /var/www/html/

# --- AJOUT: Créer le dossier data et définir les permissions ---
# Le dossier est créé ici par root, puis la propriété est donnée à www-data.
RUN mkdir -p /var/www/html/data

# Copier le script d'entrée
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Donner les droits à Apache sur le code source et le dossier data
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/

# Exposition du port 80
EXPOSE 80

# Utiliser ce script comme point d'entrée
ENTRYPOINT ["/entrypoint.sh"]