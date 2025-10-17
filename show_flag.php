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

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Avis - Chez Demo</title>
</head>
<body>
    <div> 
        <p>l€Fl@gd€SSRFOu@IsOu@IsbI€nJou€</p>
    </div>
</body>
</html>