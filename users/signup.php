<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Créer un compte</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <?php if(empty($_SESSION['connected'])): ?>
      <h1>Créer un compte</h1>
      <form action="#" method="post">
        <label for="email">Nom d'utilisateur</label>
        <input type="email" name="email" id="email">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Créer un compte">
      </form>
    <?php endif; 
    if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true): ?>
      <h1>Vous êtes connecté !</h1>
      <a href="../index.php">Revenir à l'accueil</a>
    <?php endif; ?>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>
</html>