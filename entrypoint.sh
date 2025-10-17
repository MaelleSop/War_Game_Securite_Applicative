#!/bin/bash
set -e


# Les permissions sont gérées ici car elles pourraient nécessiter www-data
gosu www-data mkdir -p /var/www/html/data
gosu www-data chmod -R 775 /var/www/html/data
gosu www-data chown -R www-data:www-data /var/www/html/data

# Initialiser la base de données si elle n'existe pas
if [ ! -f /var/www/html/data/database.sqlite ]; then
    echo "Initialisation de la base de données..."
    # Lancement de l'initialisation par www-data pour garantir les permissions de lecture/écriture.
    gosu www-data php /var/www/html/init_db.php
    echo "Base de données initialisée "
fi

# Lancer Apache en avant-plan (le processus principal du conteneur).
exec apache2-foreground