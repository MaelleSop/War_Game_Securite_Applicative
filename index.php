<?php
require_once 'config.php';
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Chez Demo - Restaurant</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header><h1>Chez Demo</h1></header>
  <main>
    <section id="description">
      <h2>Bienvenue</h2>
      <p>Chez Demo est un restaurant familial proposant cuisine française de saison.</p>
      <p>Adresse : 10 Rue Exemple, 75000 Paris</p>
    </section>

    <section id="menu">
      <h2>La carte</h2>
      <ul>
        <li>Entrée: Soupe à l'oignon — 8€</li>
        <li>Plat: Confit de canard — 18€</li>
        <li>Dessert: Tarte Tatin — 7€</li>
      </ul>
    </section>

    <section id="reviews-link">
      <a href="reviews.php">Laisser un avis / Voir les avis</a>
    </section>
  </main>

  <footer>
    <p>&copy; Chez Demo</p>
  </footer>
</body>
</html>
