<?php

// Création de compte 
function createAccount($usernameUser, $email, $password)
{
  include 'db.php';
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
  include 'db.php';
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
  include 'db.php';
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
  include 'db.php';
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
  include 'db.php';
  $stmt = $pdo->prepare('SELECT username, email FROM users WHERE id = :id');
  $stmt->execute(["id" => $id]);
  return $stmt->fetch();
}

// Fonction pour mettre à jour le pseudo utilisateur
function updateUsername($id, $newUsername)
{
  include 'db.php';
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
  include 'db.php';
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
  include 'db.php';
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
  include 'db.php';
  $stmt = $pdo->prepare('SELECT name FROM teams');
  $stmt->execute();
  return $stmt->fetchAll();
}
