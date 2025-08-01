<header class="container-1440">
  <a href="/cp6-7/index.php">Esports</a>

  <nav>
    <ul>
      <li><a href="/cp6-7/index.php">Accueil</a></li>
      <li><a href="/cp6-7/teams/list.php">Equipes</a></li>
      <li><a href="/cp6-7/tournaments/list.php">Tournois</a></li>
      <!-- Si l'utilisateur connecté est un administrateur -->
      <?php if(!empty($userConnected) && $userConnected['role'] === 'admin'): ?>
        <li><a href="../users/list.php">Membres</a></li>
      <?php endif; ?>
      <!-- Si l'utilisateur n'est pas connecté -->
      <?php if (empty($_SESSION['connected'])): ?>
        <li><a href="/cp6-7/users/login.php">Se connecter</a></li>
        <li><a href="/cp6-7/users/signup.php">Créer un compte</a></li>
      <?php endif;
      // Si l'utilisateur est connecté
      if (!empty($_SESSION['connected']) && $_SESSION['connected'] === true): ?>
        <li><a href="/cp6-7/users/update.php">Profil</a></li>
        <li><a href="/cp6-7/users/disconnect.php">Se déconnecter</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>