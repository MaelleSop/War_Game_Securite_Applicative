#!/bin/bash
set -e

# Créer le dossier data si nécessaire et donner les droits
mkdir -p /var/www/html/data
chmod -R 775 /var/www/html/data
chown -R www-data:www-data /var/www/html/data

# Initialiser la base de données si elle n'existe pas
if [ ! -f /var/www/html/data/database.sqlite ]; then
    echo "Initialisation de la base de données..."
    php /var/www/html/init_db.php
    echo "Base de données initialisée ✅"
fi

# Lancer Apache en avant-plan
apache2-foreground