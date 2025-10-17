# Étape 1 : Utiliser une image PHP avec Apache intégré
FROM php:8.2-apache

# Étape 2 : Installer les extensions nécessaires pour PHP + MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Étape 3 : Copier les fichiers du projet dans le conteneur
WORKDIR /var/www/html
COPY . /var/www/html/

# Étape 4 : Donner les bons droits
RUN chown -R www-data:www-data /var/www/html

# Étape 5 : Activer mod_rewrite si besoin (utile pour certains frameworks)
RUN a2enmod rewrite

# Étape 6 : Exécuter le script d'initialisation de la base de données
# Attention : cette commande sera relancée à chaque démarrage du conteneur
# donc assure-toi que init_db.php est idempotent (ne recrée pas tout à chaque fois)
RUN docker-php-entrypoint php init_db.php || true

# Étape 7 : Exposer le port 80 (celui d’Apache)
EXPOSE 80

# Étape 8 : Lancer Apache en premier plan
CMD service apache2 start && php init_db.php && tail -f /var/log/apache2/access.log

