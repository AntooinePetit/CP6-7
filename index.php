<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Esports</title>
  <link rel="stylesheet" href="style/style.css">
</head>
<body>
  <?php include_once 'components/header.php'; ?>

  <main>
    <h1>Bienvenue sur le site Esports</h1>
    <div class="info">
      <a href="teams/list.php">Découvrez nos équipe</a><br>
      <a href="tournaments/list.php">Découvrez nos tournois</a><br>
      <a href="users/signup.php">Créer un compte</a><br>
      <a href="users/login.php">Se connecter</a>
    </div>
  </main>

  <?php include_once 'components/footer.php'; ?>
</body>
</html>