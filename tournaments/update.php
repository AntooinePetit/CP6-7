<?php
session_start();
$error = '';
$errorName = '';
$errorDate = '';
$loadError = false;
$isError = false;
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

if (!empty($_POST['submit'])) {
  // Vérification que les champs sont tous remplis
  if (!empty($_POST['tournament-name']) && !empty($_POST['description']) && !empty($_POST['game']) && !empty('starting-date') && !empty('ending-date')) {
    $name = $_POST['tournament-name'];
    $game = $_POST['game'];
    $description = $_POST['description'];
    $startingDate = date("Y-m-d", strtotime($_POST['starting-date']));
    $endingDate = date("Y-m-d", strtotime($_POST['ending-date']));
    include_once '../config/fonctions.php';
    // Vérification si le tournoi existe
    if(verifyExistingTournamentByName($name, $_GET['id']) != false){
      $isError = true;
      $errorName = '<p style="color:red; margin-top: -15px; margin-bottom:15px;">Ce nom de tournoi n\'est pas disponible !</p>';
    }
    // Vérification que les dates sont bien égales ou ultérieures à la date actuelle
    if(strtotime($startingDate) < strtotime(date('Y-m-d')) || strtotime($endingDate) < strtotime(date('Y-m-d'))){
      $isError = true;
      $errorDate = '<p style="color:red; margin-top: -15px; margin-bottom:15px;">Veuillez choisir une date ultérieure à la date actuelle</p>';
    }
    // Vérification que la date de début est bien antérieure à la date de fin
    if($isError != true && strtotime($startingDate) > strtotime($endingDate)) {
      $isError = true;
      $errorDate = '<p style="color:red; margin-top: -15px; margin-bottom:15px;">La date de fin ne peut pas être antérieure à la date de début.</p>';
    }
  } else {
    $isError = true;
    $error = '<p style="color:red;">Tous les champs doivent être remplis !</p>';
  }

  if ($isError === false) {
    $isCreated = updateTournament($_GET['id'], $name, $game, $description, $startingDate, $endingDate);
    if($isCreated > 0){
      $error = '<p style="color:green;">Votre tournoi a bien été modifié !</p>
      <a href="list.php">Revenir à la liste des tournois</a>';
    } else {
      $error = '<p style="color:red;">Une erreur est survenu lors de la mise à jour des données de votre tournoi !</p>';

    }
  }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier un tournoi</title>
  <link rel="stylesheet" href="../style/style.css">
</head>

<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1>Modifier un tournoi</h1>
    <!-- Si utilisateur est connecté -->
    <?php if (!empty($_SESSION['connected']) && $_SESSION['connected'] === true && $loadError === false): 
    // Si l'utilisateur a bien les droits d'organisateur ou plus
      if($userConnected['role'] != 'member' && $_SESSION['id_user'] === $tournament['organizer_id']): ?>
        <form action="" method="post">
          <label for="tournament-name">Nom du tournoi</label>
          <input type="text" name="tournament-name" id="tournament-name" value="<?= $tournament['name'] ?>" required>
          <?= $errorName ?>
          <label for="game">Jeu</label>
          <input type="text" name="game" id="game" value="<?= $tournament['game'] ?>" required>
          <label for="description">Description</label>
          <input type="text" name="description" id="description" value="<?= $tournament['description'] ?>" required>
          <label for="starting-date">Date de début</label>
          <input type="date" name="starting-date" id="starting-date" value="<?= $tournament['start_date'] ?>" required>
          <label for="ending-date">Date de fin</label>
          <input type="date" name="ending-date" id="ending-date" value="<?= $tournament['end_date'] ?>" required>
          <?= $errorDate ?>
          <input type="submit" name="submit" value="Modifier votre tournoi">
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
    <?php endif;
    // Si le tournoi n'a pas pu être chargé
    if ($loadError === true): ?>
      <div class="info">
        <p>Les informations de votre tournoi n'ont pas pu être chargées !</p>
        <a href="list.php">Revenir à la liste des tournois</a>
      </div>
    <?php endif; ?>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>

</html>