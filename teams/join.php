<?php 
session_start();
if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true && !empty($_SESSION['id_user'])){
  if(!empty($_GET['id'])){
    include_once '../config/fonctions.php';
    $userJoin = addPlayerToTeam($_GET['id'], $_SESSION['id_user']);
    if($userJoin > 0){
      $info = '<p style="color: green; font-size: 24px;">Vous avez bien rejoint l\'équipe !</p>';
    } else {
      $info = '<p style="color: red; font-size: 24px;">Erreur lors de votre inscription à l\'équipe !</p>';
    }
  } else {
    $info = '<p style="color: red; font-size: 24px;">Aucune équipe trouvée !</p>';
  }
} else {
  $info = '<p style="color: red; font-size: 24px;">Vous n\'êtes pas connecté. Action impossible !</p>';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rejoindre une équipe</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1>Rejoindre une équipe</h1>
    <div class="info">
      <?= $info ?>
      <a href="list.php">Revenir à la liste des équipes</a>
    </div>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>
</html>