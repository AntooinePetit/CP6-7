<?php
session_start();
$error = '';
if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true){
  include_once '../config/fonctions.php';
  $userConnected = getUser($_SESSION['id_user']);
}
// Vérification de l'envoie du formulaire
if(!empty($_POST['submit'])){
  // Vérification que le champ est rempli et qu'il correspond à une donnée possible
  if(!empty($_POST['role'])){
    // Vérification que le champs correspond à une donnée possible
    if($_POST['role'] === 'player' || $_POST['role'] === 'organizer' || $_POST['role'] === 'admin'){
      // Vérification que l'utilisateur connecté est bien admin
      if(!empty($userConnected) && $userConnected['role'] === 'admin'){
        // Vérification que l'utilisateur à modifier est bien renseigné
        if(!empty($_GET['id'])){
          // Vérification que l'utilisateur à modifier existe bien ET n'est pas admin
          $userToUpdate = getUser($_GET['id']);
          if(!empty($userToUpdate) && $userToUpdate != false && $userToUpdate['role'] != 'admin'){
            $userUpdated = updateUserRole($_GET['id'], $_POST['role']);
            // Vérification si la mise à jour a réussi
            if($userUpdated > 0) {
              $error = '<p style="color:green;">Mise à jour réussie</p>';
            } else {
              $error = '<p style="color:red;">Erreur lors de la mise à jour du rôle</p>';
            }
          } else {
            $error = '<p style="color:red;">Utilisateur introuvable OU administrateur</p>';
          }
        } else {
          $error = '<p style="color:red;">Aucun utilisateur à modifier n\'a été renseigné</p>';
        }
      } else {
        $error = '<p style="color:red;">Vous n\'avez pas le droit d\'être ici !</p>';
      }
    } else {
      $error = '<p style="color:red;">La valeur du champ est incorrect !</p>';
    }
  } else {
    $error = '<p style="color:red;">Le champ n\'as pas été correctement rempli !</p>';
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mise à jour du rôle utilisateur</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
  <?php include_once '../components/header.php'; ?>

  <main>
    <h1>Mise à jour du rôle utilisateur</h1>
    <form action="" method="post">
      <label for="role">Rôle</label>
      <select name="role" id="role">
        <option value="player">Membre</option>
        <option value="organizer">Organisateur</option>
        <option value="admin">Administrateur</option>
      </select>
      <input type="submit" name="submit" value="Mettre à jour le rôle">
      <?= $error ?>
    </form>
    <div class="info">
      <a href="list.php">Revenir à la liste des membres</a>
    </div>
  </main>

  <?php include_once '../components/footer.php'; ?>
</body>
</html>