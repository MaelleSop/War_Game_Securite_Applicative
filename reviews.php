<?php
require_once 'config.php';

//Ouverture base de données 
$db = new PDO('sqlite:' . DB_FILE);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Gestion ajout des avis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? 'Anonyme');
    $message = trim($_POST['message'] ?? '');

    $photo_filename = null;
    //Vérification pour l'upload de l'image
    if (!empty($_FILES['photo']['name'])) {
        $allowed = ['image/jpeg','image/png','image/gif'];
        if (in_array($_FILES['photo']['type'], $allowed) && $_FILES['photo']['size'] <= 2*1024*1024) {
            $photo_filename = $_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'], UPLOAD_DIR . '/' . $photo_filename);
        } else {
            $upload_error = "Photo non autorisée (type/size).";
        }
    }
    //Upload de l'image par URL
    if (!empty($_POST['image_url'])) {
        $url = trim($_POST['image_url']);
        $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        $photo_filename = bin2hex(random_bytes(8)) . '.' . $ext;
        file_put_contents(UPLOAD_DIR . '/' . $photo_filename, file_get_contents($url));
    }

    $stmt = $db->prepare("INSERT INTO reviews (name, message, photo) VALUES (:name, :message, :photo)");
    $stmt->execute([':name' => $name, ':message' => $message, ':photo' => $photo_filename]);

    header('Location: reviews.php#thanks');
    exit;
}

//Affichage de la page avis
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
            OU
            <br><br>
            URL de l'image : <input type="text" name="image_url" /><br><br>
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
                <a href= "uploads/<?= rawurlencode($r['photo']) ?>"><img src="uploads/<?= rawurlencode($r['photo']) ?>" alt="photo" style="max-width:200px;"></a>
              <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </section>
  </main>
  <footer><a href="index.php">Retour</a></footer>
</body>
</html>
