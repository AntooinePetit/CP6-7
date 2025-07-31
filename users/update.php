<?php
session_start();
if (isset($_SESSION['id_user'])) {
  include '../config/fonctions.php';
  $error = '';
  $isError = false;
  $userInfo = getUser($_SESSION['id_user']);
  $idUser = $_SESSION['id_user'];
  $usernameUser = $userInfo['username'];
  $messageUsername = '';
  $emailUser = $userInfo['email'];
  $messageEmail = '';
  $messageNewPass = '';
}

// Vérification que le formulaire a été envoyé
if (!empty($_POST['submit'])) {
  // Vérification que les champs sont tous remplis
  if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['old-password'])) {
    require_once '../config/fonctions.php';
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    // Vérification que l'adresse mail est valide
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      // Vérification de l'existence du compte
      if (verifyExistingEmail($email, $idUser) || verifyExistingUsername($username, $idUser)) {
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
    $password = trim($_POST['new-password']);

    $accountUpdated = 0;

    // Mise à jour du nom d'utilisateur
    if (!empty($username) && $username != $usernameUser) {
      $usernameUpdated = updateUsername($idUser, $username);
      if ($usernameUpdated > 0) {
        $messageUsername = '<p style="color:green;margin-top:-15px; margin-bottom:20px">Le nom d\'utilisateur a été mis à jour.</p>';
        $accountUpdated += 1;
      } else {
        $messageUsername = '<p style="color:red;margin-top:-15px; margin-bottom:20px">Erreur de mise à jour du nom d\'utilisateur.</p>';
      }
    }

    // Mise à jour de l'email
    if (!empty($email) && $email != $emailUser) {
      $emailUpdated = updateEmail($idUser, $email);
      if ($emailUpdated > 0) {
        $messageEmail = '<p style="color:green;margin-top:-15px; margin-bottom:20px">L\'email a été mis à jour.</p>';
        $accountUpdated += 1;
      } else {
        $messageEmail  = '<p style="color:red;margin-top:-15px; margin-bottom:20px">Erreur de mise à jour de l\'email.</p>';
      }
    }

    // Mise à jour du mot de passe 
    if (!empty($password)) {
      $passwordUpdated = updatePassword($idUser, $password);
      if ($passwordUpdated > 0) {
        $messageNewPass = '<p style="color:green;margin-top:-15px; margin-bottom:20px">Le mot de passe a été mis à jour.</p>';
        $accountUpdated += 1;
      } else {
        $messageNewPass = '<p style="color:red;margin-top:-15px; margin-bottom:20px">Erreur de mise à jour du mot de passe.</p>';
      }
    }

    if ($accountUpdated >= 1) {
      $error = '<p style="color:green">Votre compte a bien été mis à jour</p>';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier le profil</title>
  <link rel="stylesheet" href="../style/style.css">
</head>

<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <!-- Si l'utilisateur est connecté -->
    <?php if (!empty($_SESSION['connected']) && $_SESSION['connected'] === true): ?>
      <h1>Profil de <?= $usernameUser ?></h1>
      <form action="" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" value="<?= $usernameUser ?>">
        <?= $messageUsername ?>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= $emailUser ?>">
        <?= $messageEmail ?>
        <label for="old-password">Mot de passe</label>
        <input type="password" name="old-password" id="old-password">
        <p style="margin-bottom: 20px; margin-top: -15px; font-size: 14px;">Veuillez entrer le mot de passe pour toute modification</p>
        <label for="new-password">Nouveau mot de passe</label>
        <input type="password" name="new-password" id="new-password">
        <?= $messageNewPass ?>
        <input type="submit" name="submit" value="Mettre à jour">
        <?= $error ?>
      </form>
    <?php endif;
    // Si l'utilisateur n'est pas connecté
    if (empty($_SESSION['connected'])): ?>
      <h1>Vous n'êtes pas connecté !</h1>
      <a href="../index.php">Revenir à l'accueil</a>
    <?php endif; ?>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>

</html>