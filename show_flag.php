<?php

$file = __DIR__ . '/proteger/.passwd';

if (!is_readable($file)) {
    http_response_code(404);
    exit('Fichier introuvable');
}

// Pour forcer l'encodage pour le navigateur
header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: inline; filename=".passwd"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');

readfile($file);
exit;

?>

