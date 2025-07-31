<?php
session_start();
$error = '';
if (!empty($_SESSION['connected']) && $_SESSION['connected'] === true){
  if(!empty($_GET['id'])){
    include '../config/fonctions.php';
    $tournament = getTournamentById($_GET['id']);
    // REPRENDRE D'ICI
  }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier [nom tournoi]</title>
  <link rel="stylesheet" href="../style/style.css">
</head>

<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1>Modifier [nom tournoi]</h1>
    <!-- Si utilisateur est connecté -->
    <?php if (!empty($_SESSION['connected']) && $_SESSION['connected'] === true): 
    // Si l'utilisateur a bien les droits d'organisateur ou plus
      if($userConnected['role'] != 'member'): ?>
        <form action="" method="post">
          <label for="tournament-name">Nom du tournoi</label>
          <input type="text" name="tournament-name" id="tournament-name" required>
          <?= $errorName ?>
          <label for="game">Jeu</label>
          <input type="text" name="game" id="game" required>
          <label for="description">Description</label>
          <input type="text" name="description" id="description" required>
          <label for="starting-date">Date de début</label>
          <input type="date" name="starting-date" id="starting-date" required>
          <label for="ending-date">Date de fin</label>
          <input type="date" name="ending-date" id="ending-date" required>
          <?= $errorDate ?>
          <input type="submit" name="submit" value="Créer une équipe">
          <?= $error ?>
        </form>
      <!-- Si l'utilisateur n'a pas les droits nécessaire -->
      <?php else: ?>
        <div class="info">
          <p>Vous n'êtes pas autorisé à effectuer cette action !</p>
          <a href="list.php">Revenir à la liste des tournois</a>
        </div>  
      <?php endif;
    endif;
    // Si utilisateur pas connecté
    if (empty($_SESSION['connected'])): ?>
      <div class="info">
        <p>Vous n'êtes pas connecté !</p>
        <a href="list.php">Revenir à la liste des tournois</a>
      </div>
    <?php endif; ?>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>

</html>