-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 22 avr. 2024 à 08:18
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
create database booktop;
use booktop;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `booktop`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `mdp` varchar(32) NOT NULL,
  `pays` varchar(255) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prenom`, `email`, `tel`, `mdp`, `pays`) VALUES
(1, 'Dubois', 'Marie', 'marie.dubois@email.com', '+33 6 12 34 56 78', 'toto', 'FR'),
(2, 'Martin', 'Jean', 'jean.martin@email.com', '+33 6 23 45 67 89', 'toto', 'FR'),
(3, 'Dupont', ' Pierre', 'pierre.dupont@email.com', '+33 6 34 56 78 90', 'toto', 'FR'),
(4, 'Lambert', 'Sophie', 'sophie.lambert@email.com', ' +33 6 45 67 89 01', 'toto', 'FR'),
(5, 'Leroux', 'Thomas', 'thomas.leroux@email.com', ' +33 6 56 78 90 12', 'toto', 'FR'),
(6, 'Garcia', 'Maria', 'maria.garcia@email.com', ' +33 6 67 89 01 23', 'toto', 'FR'),
(7, 'Dufour', 'Luc', 'luc.dufour@email.com', '+33 6 11 22 33 44', 'toto', 'FR'),
(8, 'Robert', 'Caroline', 'caroline.robert@email.com', '+33 6 22 33 44 55', 'toto', 'FR'),
(9, 'Fournier', 'David', 'david.fournier@email.com', '+33 6 33 44 55 66', 'toto', 'FR'),
(10, 'Lefevre', 'Isabelle', 'isabelle.lefevre@email.com', '+33 6 44 55 66 77', 'toto', 'FR'),
(11, 'Roux', 'Marc', 'marc.roux@email.com', '+33 6 55 66 77 88', 'toto', 'FR'),
(12, 'Legrand', 'Anne', 'anne.legrand@email.com', '+33 6 66 77 88 99', 'toto', 'FR'),
(13, 'Moreau', 'Philippe', 'philippe.moreau@email.com', '+33 6 77 88 99 00', 'toto', 'FR'),
(14, 'Girard', 'Catherine', 'catherine.girard@email.com', '+33 6 88 99 00 11', 'toto', 'FR'),
(15, 'Marchand', 'François', 'francois.marchand@email.com', '+33 6 99 00 11 22', 'toto', 'FR'),
(16, 'Lemoine', 'Sylvie', 'sylvie.lemoine@email.com', '+33 6 00 11 22 33', 'toto', 'FR'),
(54, 'Samir', 'Samir', 'samir@gmail.com', '+229 51209472', '2d0b5cd4180eef966e90218a5980f57f', 'AF'),
(58, 'Sadikou', 'Hamid', 'hamid@gmail.com', '+33 0923138538', 'f8374d06af750fd005866a15e4f9d76a', 'FR');

-- --------------------------------------------------------

--
-- Structure de la table `detail_commande`
--

DROP TABLE IF EXISTS `detail_commande`;
CREATE TABLE IF NOT EXISTS `detail_commande` (
  `id_detail_commande` int NOT NULL AUTO_INCREMENT,
  `quantite` int NOT NULL,
  `id_commande` int NOT NULL,
  `id_livre` int NOT NULL,
  PRIMARY KEY (`id_detail_commande`),
  KEY `detail_commande_commende_FK` (`id_commande`),
  KEY `detail_commande_livre0_FK` (`id_livre`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `edition`
--

DROP TABLE IF EXISTS `edition`;
CREATE TABLE IF NOT EXISTS `edition` (
  `id_edition` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id_edition`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `edition`
--

INSERT INTO `edition` (`id_edition`, `Nom`) VALUES
(1, ' Folio Classique'),
(2, 'Pocket'),
(3, 'Actes Sud'),
(4, 'Sonatine'),
(5, 'Robert Laffont'),
(6, 'JC Lattès'),
(7, 'Le Livre de Poche'),
(8, 'Gallimard Jeunesse'),
(9, 'Albin Michel'),
(10, 'Hachette'),
(11, 'Flammarion'),
(12, 'Grasset'),
(13, 'Gallimard'),
(14, 'Seuil'),
(15, 'Denoël'),
(16, 'Éditions du Seuil'),
(17, 'Le Cherche Midi'),
(18, 'Fayard'),
(19, 'Plon'),
(20, 'Larousse'),
(21, 'Belfond'),
(22, 'Éditions Stock'),
(23, 'Garnier-Flammarion'),
(24, 'Éditions du Rocher'),
(25, 'Ramsay'),
(26, 'Calmann-Lévy'),
(27, 'Le Livre de Demain'),
(28, 'Presses de la Cité');

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `id_favori` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_livre` int NOT NULL,
  PRIMARY KEY (`id_favori`)
) ENGINE=MyISAM AUTO_INCREMENT=157 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `favoris`
--

INSERT INTO `favoris` (`id_favori`, `id_client`, `id_livre`) VALUES
(123, 0, 11),
(122, 0, 5),
(121, 0, 1),
(120, 0, 9),
(117, 54, 11),
(124, 0, 15),
(108, 54, 32),
(115, 54, 5),
(106, 54, 22),
(110, 54, 9),
(109, 0, 21),
(125, 0, 22),
(129, 0, 10),
(128, 0, 4),
(127, 0, 3),
(126, 0, 2),
(107, 0, 12),
(118, 54, 15),
(116, 54, 12),
(130, 0, 8),
(131, 0, 7),
(132, 0, 20),
(133, 0, 19),
(134, 0, 18),
(135, 0, 17),
(136, 0, 16),
(137, 0, 14),
(138, 0, 13),
(139, 0, 6),
(143, 54, 3),
(144, 54, 4),
(145, 58, 35),
(146, 58, 10),
(150, 58, 47);

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id_genre`, `type`) VALUES
(1, 'Roman Classique '),
(2, 'Science-Fiction'),
(3, 'fantasy'),
(4, 'Poésie'),
(5, 'Historique'),
(6, 'Littérature Contemporaine '),
(7, 'thriller'),
(8, 'Mystère'),
(9, 'Biographie'),
(10, 'Littérature Classique'),
(11, 'Science'),
(12, 'romance'),
(13, 'horreur'),
(14, 'Aventure'),
(15, 'drame'),
(16, 'Science-Fiction'),
(17, 'humour'),
(18, 'Essai'),
(19, 'conte'),
(20, 'Thriller Psychologique'),
(21, 'Historique'),
(22, 'fantasy'),
(23, 'Poésie'),
(24, 'Non-Fiction'),
(25, 'Littérature Jeunesse');

-- --------------------------------------------------------

--
-- Structure de la table `hist_commande`
--

DROP TABLE IF EXISTS `hist_commande`;
CREATE TABLE IF NOT EXISTS `hist_commande` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `Date_de_commande` datetime NOT NULL,
  `id_client` int NOT NULL,
  `prix_total` float NOT NULL,
  `nombreLivresAchetes` float NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `codePostal` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `commende_client_FK` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `hist_commande`
--

INSERT INTO `hist_commande` (`id_commande`, `Date_de_commande`, `id_client`, `prix_total`, `nombreLivresAchetes`, `nom`, `prenom`, `tel`, `adresse`, `codePostal`, `ville`) VALUES
(74, '2024-03-25 08:24:10', 54, 641266, 10, 'Samir', 'Samir', '+229 51209472', '22rue des vignerons ', '94333', 'Vincennes'),
(75, '2024-04-02 08:04:32', 54, 80246900000, 2, 'Samir', 'Samir', '+229 51209472', '22rue des vignerons', '94333', 'Vincennes');

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

DROP TABLE IF EXISTS `livre`;
CREATE TABLE IF NOT EXISTS `livre` (
  `id_livre` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `prix` float NOT NULL,
  `auteur` varchar(50) NOT NULL,
  `id_genre` int NOT NULL,
  `id_edition` int NOT NULL,
  `description` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_client` int DEFAULT NULL,
  PRIMARY KEY (`id_livre`),
  KEY `livre_genre_FK` (`id_genre`),
  KEY `livre_edition0_FK` (`id_edition`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`id_livre`, `titre`, `prix`, `auteur`, `id_genre`, `id_edition`, `description`, `id_client`) VALUES
(1, 'Le gentil chat', 5, 'moi', 5, 8, 'Dans ce conte charmant, plongez dans les aventures d\'un chat adorable qui parcourt les rues de la ville à la recherche de nouvelles amitiés. L\'auteur nous emmène dans un voyage plein de douceur et de tendresse, capturant les moments simples de la vie quot', 1),
(2, 'le gros chien sympa qui dit bonjour', 12, 'encore moi', 1, 7, 'Plongez dans les aventures hilarantes d\'un chien au grand cœur qui aime saluer tout le monde avec un joyeux \'bonjour\'. À travers les rues animées de la ville, suivez les péripéties de ce compagnon attachant qui apporte le sourire à chacun qu\'il rencontre.', 54),
(3, 'Mystères du clair de lune', 10, 'Alice Dupont', 1, 2, 'Les mystères nocturnes prennent vie dans ce récit envoûtant où les secrets du clair de lune révèlent des vérités insoupçonnées. L\'auteur, Alice Dupont, tisse habilement une toile de suspense et d\'intrigue, invitant les lecteurs à explorer les mystères de ', 54),
(4, 'Voyage vers l inconnu', 15, 'John Martin', 2, 3, 'Embarquez pour un voyage épique vers l\'inconnu aux côtés de John Martin, un explorateur intrépide à la recherche de nouvelles frontières. À travers des paysages exotiques et des rencontres inattendues, l\'auteur nous transporte dans une aventure palpitante', 54),
(5, 'Au-delà des étoiles', 20, 'Sophie Tremblay', 3, 4, 'Plongez dans un univers fascinant où les étoiles deviennent le cadre d\'une histoire extraordinaire. Sophie Tremblay nous entraîne dans un voyage interstellaire rempli de mystères et de merveilles. Entre science-fiction et poésie, ce livre invite les lecte', 54),
(6, 'L île aux trésors perdus', 25, 'Alexandre Leclerc', 4, 5, 'Explorez les mystères de l\'île aux trésors perdus en compagnie d\'Alexandre Leclerc, un écrivain talentueux qui mêle aventure et magie dans un récit envoûtant. Entre ruines anciennes et secrets enfouis, chaque page révèle de nouveaux indices sur le destin ', 54),
(7, 'L enfant de la prophétie', 30, 'Isabelle Rocher', 5, 6, 'Dans ce récit envoûtant, Isabelle Rocher nous plonge dans un monde où les prophéties guident le destin des héros. Entre mystère et destinée, chaque page révèle de nouveaux rebondissements et des révélations surprenantes. Ce livre captivant promet une imme', 54),
(8, 'Secret des forêts magiques', 35, 'Martin Laroche', 1, 7, 'Plongez au cœur des mystères de la nature avec Martin Laroche dans ce récit envoûtant. À travers les profondeurs des forêts magiques, l\'auteur nous entraîne dans une quête pleine de mystère et de magie. Explorez les secrets cachés entre les arbres anciens', 54),
(9, 'Amour en mille couleurs', 40, 'Catherine Girard', 2, 8, 'Catherine Girard nous transporte dans un tourbillon d\'émotions avec cette histoire d\'amour riche en nuances. Explorez les mille facettes de l\'amour à travers les yeux de ses protagonistes, plongeant dans un voyage où chaque couleur représente une émotion ', 4),
(10, 'Ombre du passé', 45, 'Philippe Moreau', 3, 9, 'Philippe Moreau nous confronte aux démons du passé dans ce récit sombre et captivant. Alors que les ombres du passé ressurgissent, les personnages sont confrontés à des choix difficiles et à des secrets longtemps enfouis. Entre suspense et révélations, ce', 54),
(11, 'Destin de l humanité', 50, 'François Marchand', 4, 10, 'François Marchand nous offre une réflexion profonde sur le destin de l\'humanité dans ce récit visionnaire. À travers les épreuves et les défis auxquels font face les protagonistes, l\'auteur explore les thèmes de la survie, de l\'espoir et de la résilience.', 54),
(12, 'Ailes du temps', 55, 'Sylvie Lemoine', 5, 11, 'Sylvie Lemoine nous emporte dans un voyage à travers le temps et l\'espace avec ce récit envoûtant. Entre passé et futur, les personnages découvrent les secrets des ailes du temps, des artefacts mystérieux capables de manipuler la réalité.', 54),
(13, 'Rêves oubliés', 60, 'Jean Dufour', 1, 12, 'Jean Dufour nous plonge dans un monde de rêves oubliés où les frontières entre la réalité et l\'imaginaire s\'estompent. À travers les méandres de l\'esprit humain, les personnages découvrent des vérités cachées et des désirs enfouis. Ce livre promet une exp', 6),
(14, 'Jardin des illusions', 65, 'Caroline Robert', 2, 13, 'Caroline Robert nous transporte dans un jardin mystique où les illusions prennent vie. À travers les dédales de ce jardin enchanté, les personnages se perdent entre réalité et fantaisie, confrontés à des énigmes fascinantes. Entre magie et mystère, ce liv', 9),
(15, 'Chant des étoiles', 70, 'David Fournier', 3, 14, 'David Fournier nous entraîne dans une symphonie cosmique avec ce récit captivant. Entre les étoiles scintillantes de l\'univers, les personnages découvrent la musique de l\'âme et les secrets cachés dans les profondeurs de l\'espace. Ce livre promet un voyag', 5),
(16, 'Piège du silence', 75, 'Isabelle Lefevre', 4, 15, 'Isabelle Lefevre nous plonge dans un monde où le silence cache de sombres secrets. Entre les ombres de la nuit, les personnages luttent pour briser le piège du silence et révéler la vérité enfouie. Ce livre promet une immersion intense dans un suspense ha', 4),
(17, 'Royaume des chimères', 80, 'Marc Roux', 5, 16, 'Marc Roux nous invite à explorer le royaume des chimères, où les rêves deviennent réalité et les illusions prennent forme. Entre les recoins sombres de ce royaume fantastique, les personnages se retrouvent pris au piège des chimères de leur propre créatio', 9),
(18, 'Eclats de lumière', 85, 'Anne Legrand', 1, 17, 'Anne Legrand nous transporte dans un univers étincelant où la lumière révèle des vérités cachées. À travers les éclats de lumière qui percent les ténèbres, les personnages découvrent la beauté fragile de l\'existence et la force de l\'espoir. Ce livre prome', 7),
(19, 'Ombres du passé', 90, 'Philippe Moreau', 2, 18, 'Philippe Moreau explore les ombres du passé dans ce récit captivant où les fantômes des erreurs passées hantent les personnages. Entre les souvenirs douloureux et les regrets, les protagonistes cherchent à trouver la rédemption dans les méandres de leur h', 2),
(20, 'Mystères de l au-delà', 95, 'Catherine Girard', 3, 19, 'Catherine Girard nous plonge dans les mystères de l\'au-delà, où les frontières entre la vie et la mort s\'estompent. À travers les voiles de l\'inconnu, les personnages découvrent des vérités étonnantes sur l\'existence et le destin. Ce livre promet une expl', 54),
(21, 'Quête du Graal', 100, 'François Marchand', 4, 20, 'François Marchand nous entraîne dans une quête légendaire à la recherche du Graal, symbole de pouvoir et de savoir ultime. Entre les épreuves périlleuses et les dangers mortels, les personnages se lancent dans une aventure épique où chaque pas les rapproc', 14),
(22, 'Secret des fleurs enchantées', 105, 'Sylvie Lemoine', 5, 1, 'Sylvie Lemoine nous dévoile les secrets des fleurs enchantées dans ce conte magique où la nature révèle ses mystères les plus profonds. À travers les pétales scintillants et les parfums envoûtants, les personnages découvrent le pouvoir des fleurs et leur ', 16),
(34, 'Le destin immoblier', 123, 'David Davidson', 15, 15, 'Je ne pense pas qu\'il va s\'en sortir parce que c\'est vraiment grave ', 54),
(44, ' Boruto', 123, ' Akabustique  ', 14, 1, '\"Boruto: Naruto Next Generations\" est un manga écrit par Ukyo Kodachi et illustré par Mikio Ikemoto. Il s\'agit d\'une série dérivée de \"Naruto\" créée par Masashi Kishimoto. L\'histoire se déroule dans le même univers que \"Naruto\", mais elle se concentre sur la nouvelle génération de ninjas, en mettant en vedette les enfants des personnages principaux de la série précédente.\n\nL\'histoire suit Boruto Uzumaki, le fils de Naruto Uzumaki, qui est maintenant le Septième Hokage du village de Konoha. Boruto cherche à se démarquer de l\'ombre de son père et à trouver sa propre voie en tant que ninja. Il est accompagné de ses amis d\'enfance, Sarada Uchiha, la fille de Sasuke Uchiha, et Mitsuki, un mystérieux garçon avec des origines inhabituelles.\n\n\"Boruto\" explore les défis et les aventures auxquels sont confrontés les jeunes ninjas de la nouvelle génération, y compris les missions dangereuses, les rivalités entre amis, et les mystères qui entourent l\'apparition de nouveaux ennemis. La série aborde également des thèmes tels que l\'amitié, la famille, l\'héritage et la recherche de son propre chemin dans un monde en constante évolution.\n\n\"Boruto: Naruto Next Generations\" a été adapté en une série animée, ainsi qu\'en plusieurs films et romans. Il a connu un succès mondial auprès des fans de \"Naruto\" et continue d\'explorer et d\'élargir l\'univers établi par la série précédente.', 58),
(45, ' Naruto', 123457000, ' Ahambedi', 8, 11, '\"Naruto\" est un manga écrit et illustré par Masashi Kishimoto, qui a ensuite été adapté en une série animée à succès. L\'histoire se déroule dans un monde de ninjas où des villages cachés se disputent le pouvoir et la reconnaissance. Elle suit les aventures de Naruto Uzumaki, un jeune ninja bruyant, espiègle et plein de vie, qui cherche à devenir le plus grand ninja de son village, Konoha, et à être reconnu par ses pairs.\n\nNaruto porte en lui un lourd fardeau : il est le réceptacle d\'un démon renard à neuf queues qui a attaqué Konoha par le passé. À cause de cela, il a été ostracisé et méprisé par les habitants de son village depuis son enfance. Cependant, Naruto ne se laisse pas décourager et s\'efforce de prouver sa valeur en devenant un ninja accompli.\n\nAccompagné de ses camarades de classe, Sakura Haruno et Sasuke Uchiha, sous la tutelle de leur sensei, Kakashi Hatake, Naruto vit des aventures périlleuses, participe à des missions de ninja et affronte de redoutables ennemis, y compris des criminels notoires, des organisations ninja malveillantes et d\'autres villages cachés.\n\nTout au long de son voyage, Naruto apprend la valeur de l\'amitié, du travail acharné et de la persévérance. Il cherche également à comprendre et à surmonter ses propres démons intérieurs, tout en essayant de changer la perception des gens à son égard.\n\n\"Naruto\" est célèbre pour ses personnages profondément développés, ses combats épiques et son exploration de thèmes tels que la solitude, le sacrifice, le courage et le pouvoir de la volonté. La série est devenue l\'une des franchises de manga et d\'anime les plus populaires et les plus influentes à travers le monde.', 58),
(46, ' jujutsu kaisen', 98765400, ' Raisen', 16, 9, ' \\\"Jujutsu Kaisen\\\" est un manga écrit et illustré par Gege Akutami. L\\\'histoire suit Yuji Itadori, un lycéen ordinaire doté d\\\'une force physique remarquable. ', 58),
(47, ' Mashle', 3.40282e38, ' Habibafah', 6, 8, ' Mashle: Magic and Muscles est un shōnen manga écrit et dessiné par Hajime Komoto. Il est prépublié du 27 janvier 2020 au 3 juillet 2023 dans le Weekly Shōnen Jump, puis publié en volumes reliés par l\\\'éditeur japonais Shūeisha avec un total de 18 tomes.', 58);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `contenu` varchar(255) DEFAULT NULL,
  `id_user_recu` int DEFAULT NULL,
  `id_client` int DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_message`),
  KEY `id_user_recu` (`id_user_recu`),
  KEY `id_user_envoi` (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id_message`, `contenu`, `id_user_recu`, `id_client`, `date`) VALUES
(61, 'nique ta mere ', 54, 58, '2024-04-22 10:07:42'),
(60, 'okay', 1, 58, '2024-04-22 00:21:32'),
(59, 'OUAIS CA VAS ', 2, 58, '2024-04-22 00:21:14'),
(58, 'tu vas bien ?', 54, 58, '2024-04-22 00:07:13'),
(57, 'faz', 1, 58, '2024-04-22 00:03:32'),
(56, 'cc', 54, 58, '2024-04-22 00:03:01'),
(55, 'aaaaa', 2, 58, '2024-04-15 21:16:26'),
(54, 'tu vas bien ?', 4, 54, '2024-04-02 10:08:33'),
(53, 'je te tiens ', 5, 54, '2024-04-02 09:52:00'),
(52, 'd\'acccord', 2, 54, '2024-04-02 09:51:36');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id_panier` int NOT NULL AUTO_INCREMENT,
  `qte` int NOT NULL,
  `id_client` int NOT NULL,
  `id_livre` int NOT NULL,
  PRIMARY KEY (`id_panier`),
  KEY `panier_client_FK` (`id_client`),
  KEY `panier_livre0_FK` (`id_livre`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id_panier`, `qte`, `id_client`, `id_livre`) VALUES
(172, 98765432, 58, 44);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `detail_commande`
--
ALTER TABLE `detail_commande`
  ADD CONSTRAINT `detail_commande_commende_FK` FOREIGN KEY (`id_commande`) REFERENCES `hist_commande` (`id_commande`),
  ADD CONSTRAINT `detail_commande_livre0_FK` FOREIGN KEY (`id_livre`) REFERENCES `livre` (`id_livre`);

--
-- Contraintes pour la table `hist_commande`
--
ALTER TABLE `hist_commande`
  ADD CONSTRAINT `commende_client_FK` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `livre_edition0_FK` FOREIGN KEY (`id_edition`) REFERENCES `edition` (`id_edition`),
  ADD CONSTRAINT `livre_genre_FK` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_client_FK` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `panier_livre0_FK` FOREIGN KEY (`id_livre`) REFERENCES `livre` (`id_livre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
