<header class="container-1440">
  <a href="index.php">Esports</a>

  <nav>
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="teams/list.php">Equipes</a></li>
      <li><a href="tournaments/list.php">Tournois</a></li>
      <!-- Si l'utilisateur n'est pas connecté -->
      <?php if(empty($_SESSION['connected'])):?>
        <li><a href="users/login.php">Se connecter</a></li>
        <li><a href="users/signin.php">Créer un compte</a></li>
      <?php endif; 
      // Si l'utilisateur est connecté
      if(!empty($_SESSION['connected']) && $_SESSION['connected'] === true): ?>
        <li><a href="users/update.php">Profil</a></li>
        <li><a href="users/disconnect.php">Se déconnecter</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>