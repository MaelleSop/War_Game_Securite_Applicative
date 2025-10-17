#!/bin/bash
set -e

# Initialiser la base de données si elle n'existe pas
if [ ! -f /var/www/html/uploads/database.sqlite ]; then
    echo "Initialisation de la base de données..."
    php /var/www/html/init_db.php
fi

# Lancer Apache en avant-plan
apache2-foreground
