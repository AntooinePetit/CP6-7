<?php
session_start();
$loadError = false;
$error = '';
// Vérification que l'utilisateur est connecté
if (!empty($_SESSION['connected']) && $_SESSION['connected'] === true){
  if(!empty($_SESSION['id_user'])){
    include_once '../config/fonctions.php';
    $userConnected = getUser($_SESSION['id_user']);
    // Vérification que l'id est renseignée
    if(!empty($_GET['id'])){
      $tournament = getTournamentById($_GET['id']);
      // Vérification que le tournoi correspondant à l'id existe
      if($tournament === false){
        $loadError = true;
      }
    } else {
      $loadError = true;
    }
  } else {
    $loadError = true;
  }
}

if($loadError === false){
  if($_SESSION['id_user'] === $tournament['organizer_id'] && $userConnected['role'] != 'membre'){
    $isDeleted = deleteTournament($_GET['id']);
    if($isDeleted > 0){
      $error = '<p style="color:green;">Votre tournoi a bien été modifié !</p>';
    } else {
      $error = '<p style="color:red;">Une erreur est survenu lors de la suppression du tournoi</p>';
    }
  } else {
    $error = '<p style="color:red;">Vous n\'avez pas les autorisations nécessaires pour effectuer cette action</p>';
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suppression du tournoi</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1>Suppression du tournoi</h1>
    <div class="info">
      <?= $error ?>
      <a href="list.php">Revenir à la liste des tournois</a>
    </div>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>
</html>