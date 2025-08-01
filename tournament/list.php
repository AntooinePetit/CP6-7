<?php
session_start();
if(!empty($_GET['id'])){
  include '../config/fonctions.php';
  $tournamentInfo = getTournamentById($_GET['id']);
  if(!empty($tournamentInfo)){
    $tournamentTeams = getTournamentTeams($_GET['id']);
  }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= !empty($tournamentInfo) ? $tournamentInfo['name'] : 'Tournoi introuvable' ?></title>
  <link rel="stylesheet" href="../style/style.css">
</head>

<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1><?= !empty($tournamentInfo) ? $tournamentInfo['name'] : 'Tournoi introuvable' ?></h1>
    <?php if(!empty($tournamentInfo)) : ?>
      <div class="info">
        <p>Jeu : <?= $tournamentInfo['game'] ?></p>
        <p><?= $tournamentInfo['description'] ?></p>
        <p>Période du tournoi : <?= date('d/m/Y', strtotime($tournamentInfo['start_date'])) ?> - <?= date('d/m/Y', strtotime($tournamentInfo['end_date'])) ?></p>
      </div>
      <div class="table_component" tabindex="0">
        <table>
          <caption>Liste des équipes inscrites</caption>
          <thead>
            <tr>
              <th>Nom de l'équipe</th>
              <th>Capitaine</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($tournamentTeams as $team): ?>
              <tr>
                <td><?= $team['team_name'] ?></td>
                <td><?= $team['team_captain'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <a href="register.php?id=<?= $_GET['id'] ?>" class="ajout">Rejoindre ce tournoi</a>
      </div>
    <?php endif; ?>
      <div class="info">
        <a href="list.php">Retourner à la liste des tournoi</a>
      </div>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>

</html>