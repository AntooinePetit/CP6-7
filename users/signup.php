<?php
session_start();
$error = '';
if(!empty($_POST['submit'])){
  $error = 'Submit detected';
}
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
    <!-- Si utilisateur pas encore connecté -->
    <?php if(empty($_SESSION['connected'])): ?>
      <h1>Créer un compte</h1>
      <form action="" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        <input type="submit" name="submit" value="Créer un compte">
        <?= $error ?>
      </form>
    <?php endif; 
    // Si utilisateur déjà connecté
    if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true): ?>
      <h1>Vous êtes connecté !</h1>
      <a href="../index.php">Revenir à l'accueil</a>
    <?php endif; ?>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>
</html>