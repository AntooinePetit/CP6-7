<?php
session_start();
if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true){
  include_once '../config/fonctions.php';
  $userConnected = getUser($_SESSION['id_user']);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournois</title>
  <link rel="stylesheet" href="../style/style.css">
</head>

<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1>Liste des tournois</h1>
    <div class="table_component" tabindex="0">
      <table>
        <thead>
          <tr>
            <th>Nom du tournoi</th>
            <th>Jeu</th>
            <th>Description</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include_once '../config/fonctions.php';
          $tournaments = getAllActiveTournaments();
          foreach ($tournaments as $tournament):
          ?>
            <tr>
              <td><?= $tournament['name'] ?></td>
              <td><?= $tournament['game'] ?></td>
              <td><?= $tournament['description'] ?></td>
              <td><?= date('d/m/Y', strtotime($tournament['start_date'])) ?></td>
              <td><?= date('d/m/Y', strtotime($tournament['end_date'])) ?></td>
              <td>
                <a href="../tournament/list.php?id=<?= $tournament['id'] ?>">Voir le tournoi</a>
                <?php if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true): ?>
                  |
                  <!-- Condition d'affichage et lien si l'utilisateur est le créateur du tournoi ou non -->
                  <a href="<?= $_SESSION['id_user'] === $tournament['organizer_id'] ? 'update.php?id='.$tournament['id'] : '../tournament/register.php?id='.$tournament['id'] ?> ?>"><?= $_SESSION['id_user'] === $tournament['organizer_id'] ? 'Modifier' : 'S\'inscrire' ?></a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true && $userConnected['role'] === 'organizer'): ?>
        <a href="create.php" class="ajout">Créer mon tournoi</a>
      <?php endif; ?>
    </div>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>

</html>