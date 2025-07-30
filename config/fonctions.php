<?php

// Création de compte 
function createAccount($usernameUser, $email, $password){
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
function verifyExistingEmail($email){
  include 'db.php';
  $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
  $stmt->execute(["email" => $email]);
  $existingUsers = $stmt->rowCount();
  return $existingUsers;
}

// Vérification de l'existence du nom d'utilisateur
function verifyExistingUsername($usernameUser){
  include 'db.php';
  $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username');
  $stmt->execute(["username" => $usernameUser]);
  $existingUsers = $stmt->rowCount();
  return $existingUsers;
}