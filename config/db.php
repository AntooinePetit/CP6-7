<?php

$host = 'localhost';
$db = 'esports';
$username = 'esportAdmin';
$password = 'esport1234';
try{
  $pdo = new PDO(
    "mysql:host=$host;dbname=$db;charset=utf8",
    $username,
    $password,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );
} catch (PDOException $e){
  die('Erreur de connexion : '.$e->getMessage());
}