<?php
require_once 'config.php';
session_start();


//Connexion DB
try {
    $db = new PDO('sqlite:' . DB_FILE);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de base de données : " . htmlspecialchars($e->getMessage()));
}

//Gestion de la connexion
if (isset($_POST['user']) && isset($_POST['pass'])) {
    $stmt = $db->query("SELECT passhash, role FROM users WHERE username = $_POST['user']");
    //$stmt->execute([':u' => $_POST['user']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST['pass'], $user['passhash']) && $user['role'] === 'admin') {
        $_SESSION['is_admin'] = true;
        $_SESSION['username'] = $_POST['user'];
        header('Location: admin.php');
        exit;
    } else {
        $error = "Identifiants invalides";
    }
}

// Déconnexion
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}


//Affichage admin non-connecté
if (empty($_SESSION['is_admin'])):
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Admin - Connexion</title>
</head>
<body>
    <h1>Connexion admin</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Nom d'utilisateur : <input name="user" required></label><br><br>
        <label>Mot de passe : <input type="password" name="pass" required></label><br><br>
        <button type="submit">Connexion</button>
    </form>
    <br>
    <h3>Flag : l€Fl@gd€SSRFOu@IsOu@IsbI€nJou€ </h3>
</body>
</html>
<?php
exit;
endif;


//Affichage admin connecté
$rows = $db->query("SELECT id, name, message, photo, created_at FROM reviews ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Panneau d'administration</title>
</head>
<body>
    <h1>Panneau d'administration</h1>
    <p>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?> | <a href="?logout=1">Déconnexion</a></p>
    <h3>Flag : l€Fl@gd€SqLiOu@IsOu@IsbI€nJou€</h3>
    <hr>
    <h2>Avis reçus</h2>
    <?php foreach ($rows as $r): ?>
        <div style="border:1px solid #ccc; padding:8px; margin:8px;">
            <p><strong><?= htmlspecialchars($r['name']) ?></strong> — <?= htmlspecialchars($r['created_at']) ?></p>
            <p><?= nl2br(htmlspecialchars($r['message'])) ?></p>
            <?php if ($r['photo']): ?>
                <img src="uploads/<?= rawurlencode($r['photo']) ?>" style="max-width:150px;">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>

