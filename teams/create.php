<?php
session_start();
$error = '';
$isError = false;
// Vérification que le formulaire a été envoyé
if (!empty($_POST['submit'])) {
  // Vérification que les champs sont tous remplis
  if (!empty($_POST['team-name'])) {
    require_once '../config/fonctions.php';
    $teamName = htmlspecialchars(trim($_POST['team-name']));
    // Vérification que le nom d'équipe est disponible
    if (verifyExistingTeam($teamName) > 0) {
      $isError = true;
      $error = '<p style="color:red;">Ce nom d\'équipe est déjà utilisé !</p>';
    }
  } else {
    $isError = true;
    $error = '<p style="color:red;">Tous les champs doivent être remplis !</p>';
  }

  if ($isError === false) {
    $teamName = htmlspecialchars(trim($_POST['team-name']));

    $teamCreated = createTeam($teamName, $_SESSION['id_user']);
    if ($teamCreated > 0) {
      $error = '<p style="color:green">Votre équipe a bien été créé</p>';
    } else {
      $error = '<p style="color:red;">Une erreur est survenue lors de la création de votre équipe</p>';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Créer une équipe</title>
  <link rel="stylesheet" href="../style/style.css">
</head>

<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <!-- Si utilisateur est connecté -->
    <?php if (!empty($_SESSION['connected']) && $_SESSION['connected'] === true): ?>
      <h1>Créer une équipe</h1>
      <form action="" method="post">
        <label for="team-name">Nom d'équipe</label>
        <input type="text" name="team-name" id="team-name" required>
        <input type="submit" name="submit" value="Créer une équipe">
        <?= $error ?>
      </form>
    <?php endif;
    // Si utilisateur pas connecté
    if (empty($_SESSION['connected'])): ?>
      <div style="text-align:center">
        <h1>Vous n'êtes pas connecté !</h1>
        <a href="../index.php">Revenir à l'accueil</a>
      </div>
    <?php endif; ?>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>

</html>