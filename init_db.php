<?php
require_once 'config.php';

// Création du dossier data s’il n’existe pas
$dbdir = dirname(DB_FILE);
if (!is_dir($dbdir)) {
    if (!mkdir($dbdir, 0755, true)) {
        die("Erreur : impossible de créer le dossier $dbdir\n");
    }
}

try {
    $db = new PDO('sqlite:' . DB_FILE);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Table des avis clients
    $db->exec("CREATE TABLE IF NOT EXISTS reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        message TEXT,
        photo TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");

    // Table des utilisateurs (admin compris)
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE,
        passhash TEXT,
        role TEXT DEFAULT 'user'
    );");

    // Ajout d’un admin de base si inexistant
    $username = 'admin';
    $password_plain = 'monpass'; 

    $stmt = $db->prepare("INSERT OR IGNORE INTO users (username, passhash, role) VALUES (:u, :p, 'admin')");
    $stmt->execute([':u' => $username, ':p' => $password_plain]);

    echo "Base initialisée ✅\n";

} catch (PDOException $e) {
    echo "Erreur PDO : " . $e->getMessage() . "\n";
    exit(1);
}
