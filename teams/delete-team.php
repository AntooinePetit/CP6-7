<?php
session_start();
$error = '';
// Vérification qu'un utilisateur est connecté
if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true){
  include_once '../config/fonctions.php';
  $userInfo = getUser($_SESSION['id_user']);
  // Vérification que l'équipe est bien renseignée et existe
  if(!empty($_GET["id"]) && verifyExistingTeamById($_GET["id"]) > 0){
    $idTeam = $_GET['id'];
    // Vérification que l'utilisateur essayant de supprimer l'équipe est bien administrateur
    if($userInfo['role'] === 'admin'){
      // Vérification si le joueur à exclure a été renseigné
      $isDeleted = deleteTeam($_GET['id']);
      if($isDeleted > 0){
        $error = '<p style="color:green;">L\'équipe a bien été supprimé</p>';
      } else {
        $error = '<p style="color:red;">Une erreur est survenu lors de la suppresion de l\'équipe</p>';
      }
      
    } else {
      $error = '<p style="color:red;">Vous n\'avez pas les droits d\'administrateur</p>';
    }
  } else {
    $error = '<p style="color:red;">L\'équipe n\'a pas été renseignée ou n\'existe pas </p>';
  }
} else {
  $error = '<p style="color:red;">Vous n\'êtes pas connecté.</p>';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suppression d'équipe</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1>Suppression d'équipe</h1>
    <div class="info">
      <?= $error ?>
      <a href="list.php">Revenir à la liste des équipe</a>
    </div>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>
</html>