<?php

// Création de compte 
function createAccount($usernameUser, $email, $password)
{
  require 'db.php';
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password);');
  $stmt->execute([
    "username" => $usernameUser,
    "email" => $email,
    "password" => $passwordHash
  ]);

  return $stmt->rowCount();
}

// Vérification de l'existence du mail
function verifyExistingEmail($email, $id = 0)
{
  require 'db.php';
  $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email AND id != :id');
  $stmt->execute([
    "email" => $email,
    "id" => $id
  ]);
  $existingUsers = $stmt->rowCount();
  return $existingUsers;
}

// Vérification de l'existence du nom d'utilisateur
function verifyExistingUsername($usernameUser, $id = 0)
{
  require 'db.php';
  $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username AND id != :id');
  $stmt->execute([
    "username" => $usernameUser,
    "id" => $id
  ]);
  $existingUsers = $stmt->rowCount();
  return $existingUsers;
}

// Fonction de connexion
function connectUser($email, $password)
{
  require 'db.php';
  $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE email = :email');
  $stmt->execute(["email" => $email]);
  $user = $stmt->fetch();

  if (password_verify($password, $user['password_hash'])) {
    return $user['id'];
  } else {
    return false;
  }
}

// Fonction pour récupérer les informations d'un utilisateur
function getUser($id)
{
  require 'db.php';
  $stmt = $pdo->prepare('SELECT username, email, role FROM users WHERE id = :id');
  $stmt->execute(["id" => $id]);
  return $stmt->fetch();
}

// Fonction pour mettre à jour le pseudo utilisateur
function updateUsername($id, $newUsername)
{
  require 'db.php';
  $stmt = $pdo->prepare('UPDATE users SET username = :username WHERE id = :id');
  $stmt->execute([
    "username" => $newUsername,
    "id" => $id
  ]);

  return $stmt->rowCount();
}

// Fonction pour mettre à jour l'email utilisateur
function updateEmail($id, $newEmail)
{
  require 'db.php';
  $stmt = $pdo->prepare('UPDATE users SET email = :email WHERE id = :id');
  $stmt->execute([
    "email" => $newEmail,
    "id" => $id
  ]);

  return $stmt->rowCount();
}

// Fonction pour mettre à jour le mot de passe utilisateur
function updatePassword($id, $newPassword)
{
  $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
  require 'db.php';
  $stmt = $pdo->prepare('UPDATE users SET password_hash = :pass WHERE id = :id');
  $stmt->execute([
    "pass" =>  $passwordHash,
    "id" => $id
  ]);

  return $stmt->rowCount();
}

// Fonction pour récupérer toutes les équipes créées
function getAllTeams()
{
  require 'db.php';
  $stmt = $pdo->prepare('SELECT id, name FROM teams');
  $stmt->execute();
  return $stmt->fetchAll();
}

// Fonction pour vérifier l'existence d'une équipe grâce au nom
function verifyExistingTeam($teamName){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT * FROM teams WHERE name = :name');
  $stmt->execute(["name" => $teamName]);

  return $stmt->rowCount();
}

// Fonction pour vérifier l'existence d'une équipe grâce à l'id
function verifyExistingTeamById($idTeam){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT * FROM teams WHERE id = :id');
  $stmt->execute(["id" => $idTeam]);

  return $stmt->rowCount();
}

// Fonction pour créer une équipe et y ajouter le créateur en tant que capitaine
function createTeam($teamName, $idUser){
  require 'db.php';
  $stmt = $pdo->prepare('INSERT INTO teams (name) VALUES (:name)');
  $stmt->execute(["name" => $teamName]);

  if($stmt->rowCount() > 0){
    $stmt2 = $pdo->prepare('SELECT id FROM teams WHERE name = :name');
    $stmt2->execute(["name" => $teamName]);
    $team = $stmt2->fetch();
    
    if(isset($team['id'])){
      addPlayerToTeam($team['id'], $idUser, 'captain');
    }
  }

  return $stmt->rowCount();
}

// Fonction pour ajouter un joueur à une équipe
function addPlayerToTeam($idTeam, $idUser, $role = 'member'){
  require 'db.php';
  $stmt = $pdo->prepare('INSERT INTO team_members (user_id, team_id, role_in_team) VALUES (:user, :team, :role)');
  $stmt->execute([
    "user" => $idUser,
    "team" => $idTeam,
    "role" => $role
  ]);

  return $stmt->rowCount();
}

// Fonction pour récupérer les informations d'une équipe
function getTeamInfo($idTeam){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT name, created_at FROM teams WHERE id = :id');
  $stmt->execute(["id" => $idTeam]);

  return $stmt->fetch();
}

// Fonction pour récupérer tous les joueurs d'une équipe
function getAllPlayersFromTeam($idTeam){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT u.id, u.username, tm.role_in_team FROM team_members as tm INNER JOIN users as u ON tm.user_id = u.id WHERE tm.team_id = :id ORDER BY tm.role_in_team DESC');
  $stmt->execute(["id" => $idTeam]);

  return $stmt->fetchAll();
}

// Fonction pour vérifier la présence d'un joueur dans une équipe
function verifyPlayerInTeam($idTeam, $idUser){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT role_in_team FROM team_members WHERE user_id = :user_id AND team_id = :team_id');
  $stmt->execute([
    "user_id" => $idUser,
    "team_id" => $idTeam
  ]);

  return $stmt->fetch();
}

// Fonction pour exclure un joueur d'une équipe
function kickPlayer($idTeam, $idPlayer){
  require 'db.php';
  $stmt = $pdo->prepare('DELETE FROM team_members WHERE user_id = :user_id AND team_id = :team_id');
  $stmt->execute([
    "user_id" => $idPlayer,
    "team_id" => $idTeam
  ]);

  return $stmt->rowCount();
}

// Fonction pour récupérer tous les tournois actifs
function getAllActiveTournaments(){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT * FROM tournaments WHERE start_date >= CURRENT_TIMESTAMP;');
  $stmt->execute();

  return $stmt->fetchAll();
}

// Fonction pour vérifier l'existence d'un tournoi actif grâce au nom
function verifyExistingTournamentByName($name, $id = 0){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT * FROM tournaments WHERE name = :name AND start_date >= CURRENT_TIMESTAMP AND id != :id');
  $stmt->execute([
    "name" => $name,
    "id" => $id
  ]);

  return $stmt->fetch();
}

// Fonction de création de tournoi
function createTournament($name, $game, $description, $start, $end, $userId){
  require 'db.php';
  $stmt = $pdo->prepare('INSERT INTO tournaments(name, game, description, start_date, end_date, organizer_id) VALUES (:tournament_name , :game , :tournament_description , :starting , :ending , :id)');
  $stmt->execute([
    "tournament_name" => $name,
    "game" => $game,
    "tournament_description" => $description,
    "starting" => $start,
    "ending" => $end,
    "id" => $userId
  ]);

  return $stmt->rowCount();
}

// Fonction pour récupérer les données d'un tournoi spécifique
function getTournamentById($id){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT name, game, description, start_date, end_date, organizer_id FROM tournaments WHERE id = :id');
  $stmt->execute(["id" => $id]);

  return $stmt->fetch();
}

// Fonction pour mettre à jour un tournoi
function updateTournament($id, $name, $game, $description, $start, $end){
  require 'db.php';
  $stmt = $pdo->prepare('UPDATE tournaments SET name = :name, game = :game, description = :description, start_date = :start, end_date = :end WHERE id = :id');
  $stmt->execute([
    "name" => $name,
    "game" => $game,
    "description" => $description,
    "start" => $start,
    "end" => $end,
    "id" => $id
  ]);

  return $stmt->rowCount();
}

// Fonction pour supprimer un tournoi
function deleteTournament($id){
  require 'db.php';
  $stmt = $pdo->prepare('DELETE FROM tournaments WHERE id = :id');
  $stmt->execute(["id" => $id]);

  return $stmt->rowCount();
}

// Fonction pour récupérer les équipes dont le joueur fait partie et dont il est le capitaine
function getTeamsWhereCaptain($idUser){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT t.id, t.name FROM team_members as tm INNER JOIN teams as t ON tm.team_id = t.id WHERE tm.user_id = :id AND tm.role_in_team = "captain"');
  $stmt->execute(['id' => $idUser]);

  return $stmt->fetchAll();
}

// Fonction pour vérifier si une équipe est inscrite à un tournoi
function verifyTeamInTournament($idTeam, $idTournament){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT id from registrations WHERE team_id = :team_id AND tournament_id = :tournament_id');
  $stmt->execute([
    "team_id" => $idTeam,
    "tournament_id" => $idTournament
  ]);

  return $stmt->fetchAll();
}

// Fonction pour inscrire une équipe
function registerTeamInTournament($idTeam, $idTournament){
  require 'db.php';
  $stmt = $pdo->prepare('INSERT INTO registrations (team_id, tournament_id) VALUES (:team_id, :tournament_id)');
  $stmt->execute([
    "team_id" => $idTeam,
    "tournament_id" => $idTournament
  ]);

  return $stmt->rowCount();
}

// Fonction pour récupérer toutes les équipes inscrites à un tournoi
function getTournamentTeams($id){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT t.name as team_name, u.username as team_captain from registrations as r INNER JOIN teams as t ON r.team_id = t.id INNER JOIN team_members as tm ON t.id = tm.team_id INNER JOIN users as u ON tm.user_id = u.id WHERE r.tournament_id = :id AND tm.role_in_team = "captain"');
  $stmt->execute(['id' => $id]);

  return $stmt->fetchAll();
}

// Fonction pour supprimer une équipe
function deleteTeam($id){
  require 'db.php';
  $stmt = $pdo->prepare('DELETE FROM teams WHERE id = :id');
  $stmt->execute(['id' => $id]);

  return $stmt->rowCount();
}

// Fonction pour récupérer tous les tournois et compter les équipes inscrites
function getAllTournaments(){
  require 'db.php';
  $stmt = $pdo->prepare('SELECT t.id as id, t.name as name, t.game as game, t.description as description, t.start_date as start_date, t.end_date as end_date, t.organizer_id as organizer_id, COUNT(*) as inscrits FROM registrations as r INNER JOIN tournaments as t ON r.tournament_id = t.id GROUP BY t.name ORDER BY COUNT(*) DESC;');
  $stmt->execute();

  return $stmt->fetchAll();
}
