<?php
require_once 'config.php';
session_start();

if (isset($_POST['user']) && isset($_POST['pass'])) {
    if ($_POST['user'] === ADMIN_USER && password_verify($_POST['pass'], ADMIN_PASS)) {
        $_SESSION['is_admin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = "Identifiants invalides";
    }
}

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    echo '<h2>Admin login</h2>';
    if (!empty($error)) echo "<p style='color:red;'>$error</p>";
    echo '<form method="post"><input name="user" placeholder="user"><input type="password" name="pass" placeholder="pass"><button>Login</button></form>';
    echo '<br><h3>Flag : l€Fl@gd€SSRFOu@IsOu@IsbI€nJou€ </h3>';
    exit;
}

// admin area (read-only)
$db = new PDO('sqlite:' . DB_FILE);
$rows = $db->query("SELECT id, name, message, photo, created_at FROM reviews ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html><html lang="fr"><head><meta charset="utf-8"><title>Admin</title></head><body>
<h3>Flag : l€Fl@gd€SqLiOu@IsOu@IsbI€nJou€</h3>
<h1>Admin - Avis</h1>
<p><a href="index.php">Front</a></p>
<?php foreach ($rows as $r): ?>
  <div style="border:1px solid #ccc; padding:8px; margin:8px;">
    <p><strong><?= htmlspecialchars($r['name']) ?></strong> — <?= $r['created_at'] ?></p>
    <p><?= nl2br(htmlspecialchars($r['message'])) ?></p>
    <?php if ($r['photo']): ?><img src="uploads/<?= rawurlencode($r['photo']) ?>" style="max-width:150px;"><?php endif; ?>
  </div>
<?php endforeach; ?>
</body></html>
