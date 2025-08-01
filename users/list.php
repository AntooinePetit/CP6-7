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
  <title>Membres</title>
  <link rel="stylesheet" href="../style/style.css">
</head>

<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1>Liste des membres</h1>
    <div class="table_component" tabindex="0">
      <table>
        <thead>
          <tr>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include_once '../config/fonctions.php';
          $members = getAllNonAdminMembers();
          foreach ($members as $member):
          ?>
            <tr>
              <td><?= $member['username'] ?></td>
              <td><?= $member['email'] ?></td>
              <td><?= $member['role'] === 'player' ? 'Membre' : 'Organisateur' ?></td>
              <td><a href="update-user.php?id=<?= $member['id'] ?>">Changer le rôle utilisateur</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>

</html>