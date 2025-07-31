<?php
session_start();
$error = '';
$isError = false;
// Vérification que le formulaire a été envoyé
if (!empty($_POST['submit'])) {
  // Vérification que les champs sont tous remplis
  if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    require_once '../config/fonctions.php';
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    // Vérification que l'adresse mail est valide
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      // Vérification de l'existence du compte
      if (verifyExistingEmail($email) || verifyExistingUsername($username)) {
        $isError = true;
        $errorEmail = '';
        $errorUsername = '';
        if (verifyExistingEmail($email)) {
          $errorEmail = 'L\'email est déjà pris. ';
        }
        if (verifyExistingUsername($username)) {
          $errorUsername = 'Le nom d\'utilisateur est déjà pris.';
        }
        $error = '<p style="color:red;">' . $errorEmail . $errorUsername . '</p>';
      }
    } else {
      $isError = true;
      $error = '<p style="color:red;">Cette adresse email est invalide !</p>';
    }
  } else {
    $isError = true;
    $error = '<p style="color:red;">Tous les champs doivent être remplis !</p>';
  }

  if ($isError === false) {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    $accountCreated = createAccount($username, $email, $password);
    if ($accountCreated >= 1) {
      $error = '<p style="color:green">Votre compte a bien été créé</p>
      <a href="/cp6-7/users/login.php">Vous connecter à votre compte</a>';
    } else {
      $error = '<p style="color:red;">Une erreur est survenue lors de la création de votre compte</p>';
    }
  }
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
    <?php if (empty($_SESSION['connected'])): ?>
      <h1>Créer un compte</h1>
      <form action="" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" name="submit" value="Créer un compte">
        <?= $error ?>
      </form>
    <?php endif;
    // Si utilisateur déjà connecté
    if (!empty($_SESSION['connected']) && $_SESSION['connected'] === true): ?>
      <div style="text-align:center">
        <h1>Vous êtes connecté !</h1>
        <a href="../index.php">Revenir à l'accueil</a>
      </div>
    <?php endif; ?>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>

</html>