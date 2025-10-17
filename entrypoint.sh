#!/bin/bash
set -e

# Le dossier /var/www/html/data est maintenant créé et a les bonnes permissions dans le Dockerfile.
# Nous conservons gosu pour garantir que l'exécution de PHP CLI se fasse avec www-data.

# Initialiser la base de données si elle n'existe pas
if [ ! -f /var/www/html/data/database.sqlite ]; then
    echo "Initialisation de la base de données..."
    # Lancement de l'initialisation par www-data pour garantir les permissions de lecture/écriture.
    gosu www-data php /var/www/html/init_db.php
    echo "Base de données initialisée ✅"
fi

# Lancer Apache en avant-plan (le processus principal du conteneur).
exec apache2-foreground