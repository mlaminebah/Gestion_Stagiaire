-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 25 nov. 2020 à 22:29
-- Version du serveur :  8.0.22-0ubuntu0.20.04.2
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `GestionStagiaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `Filiere`
--

CREATE TABLE `Filiere` (
  `IdFiliere` int NOT NULL,
  `nomFiliere` varchar(100) NOT NULL,
  `niveau` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Filiere`
--

INSERT INTO `Filiere` (`IdFiliere`, `nomFiliere`, `niveau`) VALUES
(26, 'INFORMATIQUE', 'L'),
(27, 'MATHS', 'M'),
(28, 'INFORMATIQUE', 'M'),
(29, 'MATHS', 'D'),
(30, 'BIO', 'D'),
(31, 'CHIMIE', 'ALL'),
(32, 'GEO', 'T'),
(33, 'GEO', 'Q'),
(34, 'GEO', 'TS'),
(35, 'ECO', 'L'),
(36, 'ECO', 'M'),
(37, 'ECO', 'D'),
(38, 'MECANIQUE', 'Q'),
(39, 'MECANIQUE', 'M'),
(40, 'MECANIQUE', 'T'),
(41, 'GENIE CIVILE', 'ALL');

-- --------------------------------------------------------

--
-- Structure de la table `Stagiaire`
--

CREATE TABLE `Stagiaire` (
  `IdStagiaire` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(150) NOT NULL,
  `civilite` varchar(1) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `IdFiliere` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Stagiaire`
--

INSERT INTO `Stagiaire` (`IdStagiaire`, `nom`, `prenom`, `civilite`, `photo`, `IdFiliere`) VALUES
(19, 'BAH', 'Mamadou', 'M', 'accueil.png', 35),
(20, 'BARRY', 'IMANE', 'M', 'adminFiliere.png', 35),
(21, 'BAH', 'LABBO', 'M', 'mpoublie.png', 26),
(22, 'DIALLO', 'MICHEL', 'M', 'IMG-20200915-WA0013.jpg', 30);

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `login` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `pwd` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`login`, `email`, `role`, `etat`, `pwd`) VALUES
('admin', 'laamine11@gmail.com', 'Admin', 1, '827ccb0eea8a706c4c34a16891f84e7b'),
('bahm', 'bahmine96@yahoo.fr', 'Visiteur', 1, 'e10adc3949ba59abbe56e057f20f883e'),
('rasta', 'rasta@yahoo.fr', 'Visiteur', 1, '25f423bce283a8d0cbb66252da5d3cdd'),
('user1', 'user1@etu.fr', 'Visiteur', 1, '24c9e15e52afc47c225b757e7bee1f9d'),
('user10', 'user10@etu.fr', 'Visiteur', 0, '990d67a9f94696b1abe2dccf06900322'),
('user11', 'user11@yahoo.fr', 'Visiteur', 0, '03aa1a0b0375b0461c1b8f35b234e67a'),
('user12', 'user12@outlook.fr', 'Visiteur', 0, 'd781eaae8248db6ce1a7b82e58e60435'),
('user13', 'user13@dom.fr', 'Visiteur', 0, 'd09979d794a6ee60d836f884739f7196'),
('user14', 'user14@am.fr', 'Visiteur', 0, 'ef06d5cbf35386ff2203d186eeff7923'),
('user15', 'user15@prof.fr', 'Visiteur', 0, '726dedc0d6788b05f486730edcc0e871'),
('user2', 'user2@yahoo.fr', 'Visiteur', 0, '7e58d63b60197ceb55a1c487989a3720'),
('user3', 'user3@etu.fr', 'Visiteur', 0, '92877af70a45fd6a2ed7fe81e1236b78'),
('user4', 'user4@dom.fr', 'Visiteur', 0, '3f02ebe3d7929b091e3d8ccfde2f3bc6'),
('user5', 'user5@gmail.com', 'Visiteur', 1, '668b7b002d75c16a5b265b54810d2155'),
('user6', 'user6@outlook.fr', 'Visiteur', 1, 'affec3b64cf90492377a8114c86fc093'),
('user7', 'user7@gmail.com', 'Visiteur', 1, '3e0469fb134991f8f75a2760e409c6ed'),
('user8', 'user8@gmail.com', 'Visiteur', 1, '7668f673d5669995175ef91b5d171945'),
('user9', 'user9@tu.fr', 'Visiteur', 1, '8808a13b854c2563da1a5f6cb2130868');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Filiere`
--
ALTER TABLE `Filiere`
  ADD PRIMARY KEY (`IdFiliere`);

--
-- Index pour la table `Stagiaire`
--
ALTER TABLE `Stagiaire`
  ADD PRIMARY KEY (`IdStagiaire`),
  ADD KEY `IdFiliere` (`IdFiliere`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Filiere`
--
ALTER TABLE `Filiere`
  MODIFY `IdFiliere` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `Stagiaire`
--
ALTER TABLE `Stagiaire`
  MODIFY `IdStagiaire` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Stagiaire`
--
ALTER TABLE `Stagiaire`
  ADD CONSTRAINT `Stagiaire_ibfk_1` FOREIGN KEY (`IdFiliere`) REFERENCES `Filiere` (`IdFiliere`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
