<?php

// Création de compte 
function createAccount($username, $email, $password){
  include_once 'db.php';
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password);');
  $stmt->execute([
    "username" => $username,
    "email" => $email,
    "password" => $passwordHash
  ]);

  return $stmt->rowCount();
}

// Vérification de l'existence du compte
function verifyExistingAccount($username, $email){
  include_once 'db.php';
  $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email OR username = :username');
  $stmt->execute([
    "email" => $email,
    "username" => $username
  ]);
  $existingUsers = $stmt->fetchAll();
  return $existingUsers != [] ? 'true' : 'false';
}