<?php
session_start();
if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true && !empty($_SESSION['id_user'])){
  include_once '../config/fonctions.php';
  $userInfo = getUser($_SESSION['id_user']);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Équipes</title>
  <link rel="stylesheet" href="../style/style.css">
</head>

<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1>Liste des équipes</h1>
    <div class="table_component" tabindex="0">
      <table>
        <thead>
          <tr>
            <th>Nom de l'équipe</th>
            <th>Action</th>
            <?php if(!empty($userInfo) && $userInfo['role'] === 'admin'): ?>
              <th>Bannir</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php
          include_once '../config/fonctions.php';
          $teams = getAllTeams();
          foreach ($teams as $team):
          ?>
            <tr>
              <td><?= $team['name'] ?></td>
              <td>
                <a href="team.php?id=<?= $team['id'] ?>">Voir l'équipe</a>
                <?php if(!empty($_SESSION['id_user']) && verifyPlayerInTeam($team['id'], $_SESSION['id_user']) === false): ?>
                  |
                  <a href="join.php?id=<?= $team['id'] ?>">Rejoindre l'équipe</a>
                <?php endif; ?>
              </td>
              <?php if(!empty($userInfo) && $userInfo['role'] === 'admin'): ?>
                <td><a href="delete-team.php?id=<?= $team['id'] ?>">Bannir l'équipe</a></td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true): ?>
        <a href="create.php" class="ajout">Créer mon équipe</a>
      <?php endif; ?>
    </div>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>

</html>