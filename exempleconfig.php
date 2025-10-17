<?php
//Path to the SQLite database
define('DB_FILE', __DIR__ . '/data/db.sqlite');

//Directory for uploaded files
define('UPLOAD_DIR', __DIR__ . '/uploads');

//Application base URL
define('BASE_URL', '/');

// Basic admin credential
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', password_hash('change_me', PASSWORD_DEFAULT));

// Ensure upload dir exists
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}
?>