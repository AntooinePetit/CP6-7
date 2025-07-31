<?php
session_start();

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
                |
                <a href="join.php?id=<?= $team['id'] ?>">Rejoindre l'équipe</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <a href="create.php" class="ajout">Créer mon équipe</a>
    </div>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>

</html>