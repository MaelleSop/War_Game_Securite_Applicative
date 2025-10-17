#!/bin/bash
set -e

# Donner les droits à Apache pour le dossier uploads
chown -R www-data:www-data /var/www/html/uploads
chmod -R 775 /var/www/html/uploads

# Initialiser la base de données si elle n'existe pas
if [ ! -f /var/www/html/uploads/database.sqlite ]; then
    echo "Initialisation de la base de données..."
    php /var/www/html/init_db.php
fi

# Lancer Apache en avant-plan
apache2-foreground
