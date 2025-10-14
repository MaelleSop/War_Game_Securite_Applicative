<?php
require_once 'config.php';

if (!file_exists(DB_FILE)) {
    $db = new PDO('sqlite:' . DB_FILE);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("CREATE TABLE reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        message TEXT,
        photo TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");
    echo "DB initialized.\n";
} else {
    echo "DB already exists.\n";
}

?>
