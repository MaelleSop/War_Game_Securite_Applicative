#!/bin/bash
set -e

# --- Correction de l'erreur d'ouverture de fichier ---
# Exécuter les commandes de configuration en tant que www-data pour garantir les permissions.

# Créer le dossier data si nécessaire et donner les droits
gosu www-data mkdir -p /var/www/html/data
# Les permissions sont gérées ici car elles pourraient nécessiter www-data
gosu www-data chmod -R 775 /var/www/html/data
gosu www-data chown -R www-data:www-data /var/www/html/data

# Initialiser la base de données si elle n'existe pas
if [ ! -f /var/www/html/data/database.sqlite ]; then
    echo "Initialisation de la base de données..."
    # Lancement de l'initialisation par www-data pour résoudre l'erreur
    gosu www-data php /var/www/html/init_db.php
    echo "Base de données initialisée ✅"
fi

# Lancer Apache en avant-plan (s'exécutera automatiquement en tant que www-data)
exec apache2-foreground