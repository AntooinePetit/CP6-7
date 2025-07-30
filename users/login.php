<?php 
session_start();
$error = '';
$isError = false;
// Vérification que le formulaire a été envoyé
if(!empty($_POST['submit'])){
  // Vérification que les champs sont tous remplis
  if(!empty($_POST['email']) && !empty($_POST['password'])){
    require_once '../config/fonctions.php';
    $email = htmlspecialchars(trim($_POST['email']));
    // Vérification que l'adresse mail est valide
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
      // Vérification de l'existence du compte
      if(!verifyExistingEmail( $email)){
        $isError = true;
        $errorEmail = ' ';
        $error = '<p style="color:red;">Aucun compte n\'est lié à cette email.</p>';
      }
    } else {
      $isError = true;
      $error = '<p style="color:red;">Cette adresse email est invalide !</p>';
    }
  } else {
    $isError = true;
    $error = '<p style="color:red;">Tous les champs doivent être remplis !</p>';
  }

  if($isError === false){
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    if(connectUser($email, $password) === false){
      $error = '<p style="color:red;">Mot de passe incorrect</p>';
    } else {
      $_SESSION['connected'] = true;
      $_SESSION['id_user'] = connectUser($email, $password);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Se connecter</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <!-- Si utilisateur pas encore connecté -->
    <?php if(empty($_SESSION['connected'])): ?>
      <h1>Créer un compte</h1>
      <form action="" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" name="submit" value="Se connecter">
        <?= $error ?>
      </form>
    <?php endif; 
    // Si utilisateur déjà connecté
    if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true): ?>
      <div style="text-align:center">
        <h1>Vous êtes connecté !</h1>
        <a href="../index.php">Revenir à l'accueil</a>
      </div>
    <?php endif; ?>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>
</html>