# Étape 1 : Image de base avec PHP + Apache
FROM php:8.2-apache

# Étape 2 : Installer les extensions nécessaires (SQLite, PDO, MySQL si besoin)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Étape 3 : Définir le dossier de travail et copier le projet
WORKDIR /var/www/html
COPY . /var/www/html/

# Étape 4 : Créer le dossier data (au cas où il n'existe pas)
RUN mkdir -p /var/www/html/data

# Étape 5 : Donner les bons droits à Apache (www-data)
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html

# Étape 6 : Activer mod_rewrite (si nécessaire pour ton appli)
RUN a2enmod rewrite

# Étape 7 : Initialiser la base SQLite (le script doit être idempotent)
RUN docker-php-entrypoint php init_db.php || true

# Étape 8 : Exposer le port d’Apache
EXPOSE 80

# Étape 9 : Lancer init_db.php à chaque démarrage, puis Apache
CMD ["bash", "-c", "php init_db.php && exec apache2-foreground"]
