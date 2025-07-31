<?php
session_start();
if (!empty($_GET['id'])) {
  include '../config/fonctions.php';
  $idTeam = $_GET['id'];
  $teamInfo = getTeamInfo($idTeam);
  $teamPlayers = getAllPlayersFromTeam($idTeam);
  if(!empty($_SESSION['id_user'])){
    $userInTeam = verifyPlayerInTeam($idTeam, $_SESSION['id_user']); 
  }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($teamInfo['name']) ? $teamInfo['name'] : 'Équipe introuvable' ?></title>
  <link rel="stylesheet" href="../style/style.css">
</head>

<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <div class="info">
      <h1><?= $teamInfo['name'] ?></h1>
      <p>Date de création : <?= date('d/m/Y', strtotime($teamInfo['created_at'])) ?></p>
      <?php foreach ($teamPlayers as $player):
        if ($player['role_in_team'] === 'captain'): ?>
          <p>Capitaine : <?= $player['username'] ?></p>
      <?php endif;
      endforeach; ?>
    </div>
    <div class="table_component" tabindex="0">
      <table>
        <caption>Liste des membres de l'équipe</caption>
        <thead>
          <tr>
            <th>Pseudo du joueur</th>
            <th>Rôle</th>
            <?php if($userInTeam['role_in_team'] === 'captain'): ?>
              <th>Actions</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($teamPlayers as $player): ?>
            <tr>
              <td><?= $player['username'] ?></td>
              <td><?= $player['role_in_team'] ?></td>
              <?php if($userInTeam['role_in_team'] === 'captain' && $player['role_in_team'] != 'captain'): ?>
                <td><a href="delete.php?id=<?= $player['id'] ?>">Exclure</a></td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php if($userInTeam === false): ?>
        <a href="join.php?id=<?= $idTeam ?>" class="ajout">Rejoindre cette équipe</a>
      <?php endif; ?>
    </div>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>

</html>