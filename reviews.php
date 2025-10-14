<?php
require_once 'config.php';

// open DB
$db = new PDO('sqlite:' . DB_FILE);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// handle POST : submit review
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? 'Anonyme');
    $message = trim($_POST['message'] ?? '');

    $photo_filename = null;
    // Handle upload safely: allow only jpg/png/gif, limit size
    if (!empty($_FILES['photo']['name'])) {
        $allowed = ['image/jpeg','image/png','image/gif'];
        if (in_array($_FILES['photo']['type'], $allowed) && $_FILES['photo']['size'] <= 2*1024*1024) {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo_filename = bin2hex(random_bytes(8)) . '.' . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], UPLOAD_DIR . '/' . $photo_filename);
            // Note: in prod, ensure UPLOAD_DIR is not web-executable or is served via safe handler
        } else {
            $upload_error = "Photo non autorisée (type/size).";
        }
    }

    // Use prepared statement to avoid SQLi (SAFE)
    $stmt = $db->prepare("INSERT INTO reviews (name, message, photo) VALUES (:name, :message, :photo)");
    $stmt->execute([':name' => $name, ':message' => $message, ':photo' => $photo_filename]);

    header('Location: reviews.php#thanks');
    exit;
}

// fetch reviews (most recent first)
$rows = $db->query("SELECT id, name, message, photo, created_at FROM reviews ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Avis - Chez Demo</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header><h1>Avis des clients</h1></header>
  <main>
    <section id="leave-review">
      <h2>Laisser un avis</h2>
      <form method="post" enctype="multipart/form-data" action="reviews.php">
        <label>Nom<br><input type="text" name="name"></label><br><br>
        <label>Avis<br><textarea name="message" rows="5" cols="50"></textarea></label><br><br>
        <label>Photo (optionnelle)<br><input type="file" name="photo" accept="image/*"></label><br><br>
        <button type="submit">Envoyer</button>
      </form>
    </section>

    <section id="list-reviews">
      <h2>Derniers avis</h2>
      <?php foreach ($rows as $r): ?>
        <article class="review">
          <p><strong><?= htmlspecialchars($r['name'], ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8') ?></strong> — <em><?= $r['created_at'] ?></em></p>
          <p><?= nl2br(htmlspecialchars($r['message'], ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8')) ?></p>
          <?php if ($r['photo']): ?>
            <p><img src="uploads/<?= rawurlencode($r['photo']) ?>" alt="photo" style="max-width:200px;"></p>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </section>
  </main>
  <footer><a href="index.php">Retour</a></footer>
</body>
</html>
