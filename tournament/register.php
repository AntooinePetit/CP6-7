<?php
session_start();
$error = '';
// Si l'utilisateur est connecté
if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true){
  include_once '../config/fonctions.php';
  // Récupérer la liste des équipes auxquelles il est inscrit et dont il est capitaine
  $userTeams = getTeamsWhereCaptain($_SESSION['id_user']);
}

if(!empty($_POST['submit'])){
  if(!empty($_POST['team'])){
    $userRole = verifyPlayerInTeam($_POST['team'], $_SESSION['id_user']);
    // Si l'utilisateur est bien le capitaine
    if($userRole['role_in_team'] === 'captain'){
      // Si l'équipe n'est pas déjà inscrite
      if(count(verifyTeamInTournament($_POST['team'], $_GET['id'])) <= 0){
        $isRegistered = registerTeamInTournament($_POST['team'], $_GET['id']);
        if($isRegistered > 0) {
          $error = '<p style="color:green;">Votre équipe a bien été inscrite à ce tournoi</p>';
        } else {
          $error = '<p style="color:red;">Erreur lors de l\'inscription de votre équipe au tournoi</p>';
        }
      } else {
        $error = '<p style="color:red;">Votre équipe est déjà inscrite à ce tournoi</p>';
      }
    } else {
      $error = '<p style="color:red;">Vous n\'êtes pas le capitaine de cette équipe</p>';
    }    
  } else {
    $error = '<p style="color:red;">Aucune équipe n\'a été renseignée</p>';
  }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscrire une équipe</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1>Inscrire une équipe</h1>
    <!-- Si l'utilisateur est connecté et est capitaine d'au moins une équipe -->
    <?php if (!empty($_SESSION['connected']) && $_SESSION['connected'] === true && count($userTeams) > 0): ?>
      <form action="" method="post">
        <label for="team">Équipe à Inscrire</label>
        <select name="team" id="team">
          <?php foreach($userTeams as $team): ?>
            <option value="<?= $team['id'] ?>"><?= $team['name'] ?></option>
          <?php endforeach; ?>
        </select>
        <input type="submit" name="submit" value="Inscrire l'équipe">
        <?= $error ?>
      </form>
    <?php endif;
    if (!empty($_SESSION['connected']) && $_SESSION['connected'] === true && count($userTeams) <= 0): ?>
      <div class="info">
        <p>Vous n'êtes capitaine d'aucune équipe !</p>
        <a href="../index.php">Revenir à l'accueil</a>
      </div>
    <?php endif;
    if (empty($_SESSION['connected'])): ?>
      <div class="info">
        <p>Vous n'êtes pas connecté !</p>
        <a href="../index.php">Revenir à l'accueil</a>
      </div>
    <?php endif; ?>
  </main>

  <?php include_once '../components/footer.php'; ?> 
</body>
</html>