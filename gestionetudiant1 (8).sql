-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 09 déc. 2024 à 00:37
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionetudiant1`
--

-- --------------------------------------------------------

--
-- Structure de la table `employes`
--

CREATE TABLE `employes` (
  `idEmploye` int(11) NOT NULL,
  `Nom` varchar(100) NOT NULL,
  `Prenom` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MotDePasse` varchar(255) NOT NULL,
  `Role` enum('gestion_etudiants','gestion_filieres','admin') NOT NULL DEFAULT 'gestion_etudiants'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employes`
--

INSERT INTO `employes` (`idEmploye`, `Nom`, `Prenom`, `Email`, `MotDePasse`, `Role`) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@example.com', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'gestion_etudiants'),
(3, 'Durand', 'Paul', 'paul.durand@example.com', 'c6ba91b90d922e159893f46c387e5dc1b3dc5c101a5a4522f03b987177a24a91', 'gestion_filieres');

-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

CREATE TABLE `enseignants` (
  `idEnseignant` int(11) NOT NULL,
  `Nom` varchar(100) NOT NULL,
  `Prenom` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Telephone` varchar(15) DEFAULT NULL,
  `Specialite` varchar(100) DEFAULT NULL,
  `accord` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `enseignants`
--

INSERT INTO `enseignants` (`idEnseignant`, `Nom`, `Prenom`, `Email`, `Telephone`, `Specialite`, `accord`) VALUES
(3, 'Martin', 'Claire', 'claire.martin@example.com', '0987654321', 'Mathématiques', 1),
(4, 'Durand', 'Paul', 'paul.durand@example.com', '0654321098', 'Réseaux', 1),
(5, 'Dupont', 'Jean', 'jean.dupont@example.com', '0123456789', 'Programmation', 1),
(6, 'ridet', 'jerom', 'ridet.jerom@uphf.fr', '0612457896', 'Réseau', 1),
(7, 'ranold', 'JEAN', 'JEAN.ranold@gmail.com', '0623569841', 'Architecture des ordinateurs ', 1);

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `idEtudiants` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Apogee` varchar(50) NOT NULL,
  `DateNaissance` date NOT NULL,
  `Ville` varchar(50) NOT NULL,
  `Pays` varchar(50) NOT NULL,
  `idFiliere` int(11) DEFAULT NULL,
  `idNiveau` int(11) DEFAULT NULL,
  `accord` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`idEtudiants`, `Nom`, `Prenom`, `Apogee`, `DateNaissance`, `Ville`, `Pays`, `idFiliere`, `idNiveau`, `accord`) VALUES
(1, 'Dupont', 'Jean', '20231001', '2003-10-15', 'Paris', 'Marocain(e)', 83, 83, 0),
(133, 'Sari', 'Rim', 'Abcde78', '2004-12-20', 'Casablanca', 'Marocain(e)', 84, 83, 1),
(134, 'Daren', 'Julliet ', 'AD789O', '2003-12-12', 'Valenciennes', 'Marocain(e)', 84, 84, 1);

-- --------------------------------------------------------

--
-- Structure de la table `etudiants_supprimes`
--

CREATE TABLE `etudiants_supprimes` (
  `Nom` varchar(100) NOT NULL,
  `Prenom` varchar(100) NOT NULL,
  `Apogee` varchar(100) NOT NULL,
  `DateNaissance` varchar(100) NOT NULL,
  `Pays` varchar(100) NOT NULL,
  `Ville` varchar(100) NOT NULL,
  `Nomfiliere` varchar(100) NOT NULL,
  `Niveau` varchar(50) NOT NULL,
  `idEtudiants` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants_supprimes`
--

INSERT INTO `etudiants_supprimes` (`Nom`, `Prenom`, `Apogee`, `DateNaissance`, `Pays`, `Ville`, `Nomfiliere`, `Niveau`, `idEtudiants`) VALUES
('mekhchani', 'hfhhfh', 'dhh789545kkk', '2023-05-04', 'Marocain(e)', 'fnefe', '>génie informatique', '>premiere année', NULL),
('fahmi', 'meriem', '12345', '2023-05-06', 'Marocain(e)', 'niece', '>génie informatique', '>premiere année', NULL),
('sanae', 'mmm', 'dhh789545kkkfdqzef', '2023-05-04', 'Marocain(e)', 'fefe', '>génie informatique', '>premiere année', NULL),
('mekhchani', 'malak', '12345jhhh', '2023-05-13', 'Marocain(e)', 'niec', 'Réseaux Informatiques', 'premiere année', NULL),
('mekhchani', 'hjctj', 'dhh789545jhuh', '2023-05-11', 'Marocain(e)', 'niece', 'Réseaux Informatiques', 'deuxieme année', NULL),
('sanae', 'mmm', 'dhh789kfdqzef', '2023-05-04', 'Marocain(e)', 'janavazhgd', 'Réseaux Informatiques', 'premiere année', NULL),
('sanae', 'mekhchani', '123456789cddd', '2023-05-04', 'Marocain(e)', 'rabat', '>génie logiciel', 'deuxieme année', NULL),
('sanae', 'mekhchani', '123456789', '2023-05-04', 'Marocain(e)', 'rabat', '>génie logiciel', '>premiere année', NULL),
('mekhchani', 'hjctj', 'dhh7895,,45kkk', '2023-05-11', 'étrangèr(e)', 'fnefe', 'génie logiciel', 'deuxieme année', NULL),
('fahmi', 'hjctj', '123456bg', '2023-05-19', 'Marocain(e)', 'niec', '>génie informatique', '>premiere année', NULL),
('maha', 'sabbar', 'aser789', '2004-06-15', 'Marocain(e)', 'sale', '>génie informatique', '>premiere année', NULL),
('sanae', 'sabr', '456', '2023-05-12', 'Marocain(e)', 'rabat', '>génie informatique', '>premiere année', NULL),
('jannat', 'farah', 'ad45888', '2023-05-13', 'Marocain(e)', 'rabat', 'génie informatique', 'deuxieme année', NULL),
('malak', 'amras', '7899', '2005-12-04', 'Marocain(e)', 'Valenciennes', '>génie informatique', '>deuxieme année', NULL),
('Meriem', 'Fahmi', '12345', '2004-10-18', 'Marocain(e)', 'valenciennes', '>Informatique', '>deuxieme année', NULL),
('malak', 'fahmi1', 'bcc', '2005-10-12', 'Etrangèr(e)', 'valenciennes', '', '', NULL),
('Meriem', 'Fahmi', '12345', '2004-11-01', 'Etrangèr(e)', 'valenciennes', '>Sciences humaines', '>troisième année', NULL),
('malak', 'amras', '44569', '2005-11-05', 'Marocain(e)', 'valenciennes', '>Mathèmatiques', '>deuxieme année', NULL),
('JULLIET', 'ROUEN', 'UI12345', '2005-11-15', 'Français(e)', 'Paris', 'Mathématiques', 'Troisième année', NULL),
('Mohammed', 'Fahmi', '78888', '2003-11-30', 'Français(e)', 'rabat', 'Mathématiques', 'Première année', NULL),
('nirmine', 'janet', '789pp', '2003-02-12', 'Marocain(e)', 'Bordeaux', 'Mathématiques Appliquées', 'Troisième année', NULL),
('Amras', 'Malak', '20231004', '2005-12-04', 'Marocain(e)', 'Rabat', 'Mathématiques Appliquées', 'Deuxième année', NULL),
('Fahmi', 'Meriem', '20231003', '2004-11-01', 'Marocain(e)', 'Casablanca', 'Génie Informatique', 'Première année', NULL),
('Durand', 'Claire', '20231002', '2002-06-20', 'Marocain(e)', 'Lyon', 'Génie Logiciel', 'Deuxième année', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

CREATE TABLE `filieres` (
  `idFiliere` int(11) NOT NULL,
  `Nomfiliere` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `filieres`
--

INSERT INTO `filieres` (`idFiliere`, `Nomfiliere`) VALUES
(83, 'Génie Informatique'),
(84, 'Génie Logiciel'),
(85, 'Mathématiques Appliquées'),
(87, 'Informatique'),
(88, 'Mathématiques');

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE `matieres` (
  `idMatiere` int(11) NOT NULL,
  `NomMatiere` varchar(100) NOT NULL,
  `Coefficient` double NOT NULL,
  `idFiliere` int(11) NOT NULL,
  `idEnseignant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`idMatiere`, `NomMatiere`, `Coefficient`, `idFiliere`, `idEnseignant`) VALUES
(1, 'Programmation C', 3, 83, 2),
(4, 'Bases de Données', 3.5, 83, 2),
(9, 'langage javascript', 6, 83, 5),
(11, 'base de données ', 5, 83, 3),
(12, 'anglais', 2, 84, 3);

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

CREATE TABLE `niveau` (
  `idNiveau` int(11) NOT NULL,
  `Niveau` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `niveau`
--

INSERT INTO `niveau` (`idNiveau`, `Niveau`) VALUES
(83, 'Première année'),
(84, 'Deuxième année'),
(85, 'Troisième année');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `employes`
--
ALTER TABLE `employes`
  ADD PRIMARY KEY (`idEmploye`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Email_2` (`Email`);

--
-- Index pour la table `enseignants`
--
ALTER TABLE `enseignants`
  ADD PRIMARY KEY (`idEnseignant`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`idEtudiants`),
  ADD UNIQUE KEY `Apogee` (`Apogee`),
  ADD UNIQUE KEY `Apogee_2` (`Apogee`),
  ADD UNIQUE KEY `Apogee_3` (`Apogee`),
  ADD KEY `FK_Etudiant_Filiere` (`idFiliere`),
  ADD KEY `FK_Etudiant_Niveau` (`idNiveau`);

--
-- Index pour la table `etudiants_supprimes`
--
ALTER TABLE `etudiants_supprimes`
  ADD KEY `FK_EtudiantsSupprimes_Etudiant` (`idEtudiants`);

--
-- Index pour la table `filieres`
--
ALTER TABLE `filieres`
  ADD PRIMARY KEY (`idFiliere`);

--
-- Index pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`idMatiere`),
  ADD KEY `idFiliere` (`idFiliere`),
  ADD KEY `idEnseignant` (`idEnseignant`);

--
-- Index pour la table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`idNiveau`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `employes`
--
ALTER TABLE `employes`
  MODIFY `idEmploye` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `enseignants`
--
ALTER TABLE `enseignants`
  MODIFY `idEnseignant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `idEtudiants` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT pour la table `filieres`
--
ALTER TABLE `filieres`
  MODIFY `idFiliere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT pour la table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `idMatiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `niveau`
--
ALTER TABLE `niveau`
  MODIFY `idNiveau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `FK_Etudiant_Filiere` FOREIGN KEY (`idFiliere`) REFERENCES `filieres` (`idFiliere`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Etudiant_Niveau` FOREIGN KEY (`idNiveau`) REFERENCES `niveau` (`idNiveau`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etudiants_supprimes`
--
ALTER TABLE `etudiants_supprimes`
  ADD CONSTRAINT `FK_EtudiantsSupprimes_Etudiant` FOREIGN KEY (`idEtudiants`) REFERENCES `etudiant` (`idEtudiants`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD CONSTRAINT `matieres_ibfk_1` FOREIGN KEY (`idFiliere`) REFERENCES `filieres` (`idFiliere`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `matieres_ibfk_2` FOREIGN KEY (`idEnseignant`) REFERENCES `enseignants` (`idEnseignant`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
