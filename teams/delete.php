<?php
session_start();
$error = '';
// Vérification qu'un utilisateur est connecté
if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true){
  $idCaptain = $_SESSION['id_user'];
  // Vérification que l'équipe est bien renseignée et existe
  include_once '../config/fonctions.php';
  if(!empty($_GET["id_team"]) && verifyExistingTeamById($_GET["id_team"]) > 0){
    $idTeam = $_GET['id_team'];
    // Vérification que l'utilisateur essayant d'exclure un joueur fait partie de l'équipe et est bien le capitaine
    $captain = verifyPlayerInTeam($idTeam, $idCaptain);
    if($captain != false && $captain['role_in_team'] === 'captain'){
      // Vérification si le joueur à exclure a été renseigné
      if(!empty($_GET['id_player'])) {
        $idPlayer = $_GET['id_player'];
        $playerToKick = verifyPlayerInTeam($idTeam, $idPlayer);
        // Vérification si le jouer à exclure fait partie de l'équipe et n'est pas capitaine
        if($playerToKick != false && $playerToKick['role_in_team'] != 'captain'){
          $isKicked = kickPlayer($idTeam, $idPlayer);
          // Vérification si le joueur a bien été exclu 
          if($isKicked > 0){
            $error = '<p style="color:green;">Le joueur a bien été exclu</p>';
          } else {
            $error = '<p style="color:red;">Une erreur est survenu</p>';
          }
        } else {
          $error = '<p style="color:red;">Le joueur ne fait pas partie de l\'équipe ou en est un capitaine</p>';
        }
      } else {
        $error = '<p style="color:red;">L\'identité du joueur à exclure n\'a pas été renseignée</p>';
      }
    } else {
      $error = '<p style="color:red;">Vous ne faites pas partie de cette équipe ou vous n\'en êtes pas le capitaine</p>';
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
  <title>Exclusion d'un joueur</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1>Exclusion de joueur</h1>
    <div class="info">
      <?= $error ?>
      <a href="team.php?id=<?= $idTeam ?>">Revenir à la page de gestion d'équipe</a>
    </div>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>
</html>