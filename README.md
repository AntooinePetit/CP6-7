# Projet Esports

## Informations nécessaires au projet

Ce projet nécessite l'utilisation d'un serveur WAMP (ou XAMP etc..). 
Les données SQL suivantes doivent être renseignées dans le serveur pour le bon fonctionnement du projet. 
```sql
-- Base de données pour un système de gestion de compétitions e-sport

DROP DATABASE IF EXISTS esports;
CREATE DATABASE esports;
USE esports;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('player', 'organizer', 'admin') NOT NULL DEFAULT 'player',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB;

-- Table des équipes
CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB;

-- Table de liaison entre utilisateurs et équipes
CREATE TABLE team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    team_id INT NOT NULL,
    role_in_team ENUM('member', 'captain') NOT NULL DEFAULT 'member',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE
)ENGINE=InnoDB;

-- Table des tournois
CREATE TABLE tournaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    game VARCHAR(100) NOT NULL,
    description TEXT,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    organizer_id INT NOT NULL,
    FOREIGN KEY (organizer_id) REFERENCES users(id) ON DELETE CASCADE
)ENGINE=InnoDB;

-- Table d’inscription des équipes à un tournoi
CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT NOT NULL,
    tournament_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (team_id, tournament_id),
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE
)ENGINE=InnoDB;

-- Données de test : utilisateurs
INSERT INTO users (username, email, password_hash, role) VALUES
('admin_master', 'admin@esports.com', 'hashed_pwd_1', 'admin'),
('orga_jane', 'jane@orga.com', 'hashed_pwd_2', 'organizer'),
('player_tom', 'tom@players.com', 'hashed_pwd_3', 'player'),
('player_ana', 'ana@players.com', 'hashed_pwd_4', 'player'),
('player_max', 'max@players.com', 'hashed_pwd_5', 'player');

-- Données de test : équipes
INSERT INTO teams (name) VALUES
('Red Dragons'),
('Blue Phoenix'),
('Cyber Ninjas');

-- Données de test : membres d’équipes
INSERT INTO team_members (user_id, team_id, role_in_team) VALUES
(3, 1, 'captain'), -- Tom dans Red Dragons
(4, 1, 'member'),  -- Ana dans Red Dragons
(5, 2, 'captain'); -- Max dans Blue Phoenix

-- Données de test : tournois
INSERT INTO tournaments (name, game, description, start_date, end_date, organizer_id) VALUES
('Spring Smash Cup', 'Super Smash Bros', 'Tournoi printanier avec lots à gagner.', '2025-07-10', '2025-07-12', 2),
('League Ultimate', 'League of Legends', 'Tournoi 5v5 ouvert à tous.', '2025-08-01', '2025-08-03', 2);

-- Données de test : inscriptions
INSERT INTO registrations (team_id, tournament_id) VALUES
(1, 1),
(2, 1);

```

Une fois les bases de données créées, le dossier de projet doit être placé dans le dossier "www" de votre serveur. Le site sera accessible depuis l'adresse 'localhost/cp6-7'.

## Lien GitHub du projet

[https://github.com/AntooinePetit/CP6-7]