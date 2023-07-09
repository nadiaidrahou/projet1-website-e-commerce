-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 21 juin 2022 à 00:50
-- Version du serveur :  10.4.6-MariaDB
-- Version de PHP :  7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `cat_ID` int(11) NOT NULL COMMENT 'L''identifiant de la catégorie',
  `cat_name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Nom de la catégorie',
  `cat_description` text CHARACTER SET utf8 NOT NULL COMMENT 'Description de la catégorie',
  `cat_icon` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`cat_ID`, `cat_name`, `cat_description`, `cat_icon`) VALUES
(7, 'Accessoires', 'Lunettes, casquettes, montres...', 'diamond'),
(46, 'Robes', '\r\nACHETER PAR TENDANCE\r\nRobes-chemises\r\nRobes bohèmes\r\nRobes froncées\r\nRobes à fleurs\r\n\r\n', NULL),
(47, 'T-Shirts', 'court\r\nclassique\r\nlong', NULL),
(48, 'Jeans', 'coupe mom\r\npattes d\'éléphant\r\ncoupe jogger\r\ncoupe droite', NULL),
(49, 'ma shoes', 'chaussures femme', NULL),
(50, 'Ma bags', 'Sacs femme\r\nSac à dos\r\n', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id_panier` int(11) NOT NULL,
  `img_pr` varchar(255) DEFAULT NULL,
  `nom_pr` varchar(255) DEFAULT NULL,
  `prix` double DEFAULT NULL,
  `id_pr` int(11) NOT NULL,
  `id_us` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id_panier`, `img_pr`, `nom_pr`, `prix`, `id_pr`, `id_us`) VALUES
(75, 'admin/upload/img_produits/508_7.webp', 'Fille Sac fantaisie en tissu duveteux design cœur à chaîne', 60, 72, 58),
(76, 'admin/upload/img_produits/580_100.webp', 'Jean droit ourlet effiloché déchiré', 200, 67, 58),
(77, 'admin/upload/img_produits/394_4.webp', 'Robe trapèze fleurie à manches évasées', 200, 58, 60),
(78, 'admin/upload/img_produits/876_10.webp', 'Sac à dos à boucle à lettres à blocs de couleurs', 180, 73, 60),
(79, 'admin/upload/img_produits/5024_lenette1.png', 'Lunettes de mode à monture octogonale métallique', 100, 46, 60),
(80, 'admin/upload/img_produits/460_7.webp', 'DAZY T-shirts pour femmes Casual Lettres', 100, 59, 60),
(81, 'admin/upload/img_produits/386_2.webp', 'Pantoufles avec perles', 60, 61, 60),
(82, 'admin/upload/img_produits/171_1.webp', 'Robe chemise à bouton ceinturée', 300, 52, 60);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `prod_ID` int(11) NOT NULL COMMENT 'L''identifiant du produit',
  `prod_name` varchar(255) NOT NULL COMMENT 'Nom du produit',
  `prod_description` text NOT NULL COMMENT 'Description dproduit',
  `prod_price` double NOT NULL COMMENT 'Prix du produit',
  `prod_marque` varchar(255) NOT NULL COMMENT 'La marque du produit',
  `id_cat_et` int(11) NOT NULL,
  `prod_date` date NOT NULL COMMENT 'Date d''ajout de produit',
  `main_image` varchar(255) NOT NULL,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`prod_ID`, `prod_name`, `prod_description`, `prod_price`, `prod_marque`, `id_cat_et`, `prod_date`, `main_image`, `img1`, `img2`, `id_user`) VALUES
(45, 'Lunettes de mode à verres ombre', 'Couleur des verres:	Multicolore\r\nForme:	Autre Forme\r\nStyle:	Bohème\r\nQuantité:	1 paire', 150, 'ARON', 7, '2020-08-29', '9434_1.png', '5522_2.png', '5262_3.png', 0),
(46, 'Lunettes de mode à monture octogonale métallique', 'Couleur des verres:	Noir\r\nForme:	Autre Forme\r\nStyle:	Casual', 100, 'Magic Vision', 7, '2020-08-29', '5024_lenette1.png', '2666_l2.pnj.webp', '4030_l3.png', 0),
(47, '3 pièces Collier à fausse perle à breloque ronde', 'détails:	Géométrique, Perle\r\nSexe:	Femme\r\nType:	Colliers avec pendentif, Multicouche\r\nTissu/matériel:	Alliage\r\nCouleur:	Doré\r\nQuantité:	3 pièces\r\nStyle:	À la mode\r\n', 50, 'Mode', 7, '2020-08-29', '5312_img.png', '5404_image3.png', '3481_image4.png', 0),
(48, '3 pièces Bracelet rond', 'Sexe:	Femme\r\nCouleur Métallique:	Doré\r\nTissu/matériel:	plastique\r\nCouleur:	Doré\r\nType:	Chaîne\r\nQuantité:	3 pièces', 90, 'gold', 7, '0000-00-00', '37_b1.png', '234_b2.png', '33_b3.png', 0),
(49, 'Montre à quartz à pointeur rond avec strass', 'détails:	Strass\r\nSexe:	Femme\r\nStyle:	Glamour\r\nType:	Montres-bracelets\r\nType d\'affichage:	Aiguille\r\nForme de montre:	Rond\r\nMouvement:	Quartz\r\nMatériel de boîtier:	Alliage\r\nMatériel de bracelet:	Alliage\r\nCouleur de bracelet:	Doré\r\nRésistant à l\'eau:	Pas étanche\r\nCaractéristiques:	D’Autre\r\nQuantité:	1 pièce\r\nPiles inclues:	OUI', 105, 'gold', 7, '0000-00-00', '1000_1.png', '702_2.png', '859_3.png', 0),
(52, 'Robe chemise à bouton ceinturée', 'Couleur:	Rouge foncé\r\nStyle:	Élégant\r\nType de motif:	Unicolore\r\ndétails:	Ceinture, Boutons\r\nType:	Chemise\r\nType du col:	Col chemise\r\nLongueur des manches:	Manches longues\r\nType de manches:	Classiques\r\nTour de taille:	Taille haute\r\nOurlet/finition:	Évasé\r\nLongueur:	Long\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Polyester\r\nComposition:	100% Polyester\r\nInstructions d\'entretien:	Lavage en machine ou nettoyage à sec professionnel\r\nceinture:	OUI\r\nTransparent:	Non', 300, 'marwa', 46, '0000-00-00', '171_1.webp', '555_2.webp', '668_3.webp', 0),
(53, 'Robe trapèze plissée fleurie avec nœud', 'Couleur:	Multicolore\r\nStyle:	Simple, Élégant\r\nType de motif:	Floral, Tout Imprimé\r\ndétails:	Plissé\r\nType:	Chemise\r\nType du col:	Nœud à l\'encolure\r\nLongueur des manches:	Manches longues\r\nType de manches:	Manches bishop\r\nTour de taille:	Taille haute\r\nOurlet/finition:	Plissé\r\nLongueur:	Maxi\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Polyester\r\nComposition:	100% Polyester\r\nInstructions d\'entretien:	Lavage en machine ou nettoyage à sec professionnel\r\nTransparent:	Non', 250, 'zara', 46, '0000-00-00', '56_4.webp', '771_5.webp', '984_6.webp', 0),
(54, 'Robe longue fleurie avec nœud', 'Couleur:	Multicolore\r\nStyle:	Simple, Élégant\r\nType de motif:	Floral\r\ndétails:	Ceinture\r\nType:	Trapèze\r\nType du col:	Col montant\r\nLongueur des manches:	Manches longues\r\nType de manches:	Manches bishop\r\nTour de taille:	Taille haute\r\nOurlet/finition:	Évasé\r\nLongueur:	Maxi\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Polyester\r\nComposition:	100% Polyester\r\nInstructions d\'entretien:	Lavage en machine ou nettoyage à sec professionnel\r\nDoublure:	Avec doublure\r\nceinture:	OUI\r\nTransparent:	Non\r\nVêtements traditionnels arabes:	OUI', 280, 'zara', 46, '0000-00-00', '336_7.webp', '734_8.webp', '588_9.webp', 0),
(55, 'Robe chemise à imprimé géométrique à nœud', 'Couleur:	Multicolore\r\nStyle:	Bohème\r\nType de motif:	Géométrique, Tout Imprimé\r\ndétails:	Ceinture\r\nType:	Chemise\r\nType du col:	Revers\r\nLongueur des manches:	Manches courtes\r\nType de manches:	Classiques\r\nTour de taille:	Taille haute\r\nOurlet/finition:	Évasé\r\nLongueur:	Long\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Polyester\r\nComposition:	100% Polyester\r\nInstructions d\'entretien:	Lavage en machine ou nettoyage à sec professionnel\r\nceinture:	Non\r\nTransparent:	Non', 180, 'h&m', 46, '0000-00-00', '681_11.webp', '209_22.webp', '925_33.webp', 0),
(56, 'DAZY Robe chemise à rayures ceinturé', 'Couleur:	Camel\r\nStyle:	Casual\r\nType de motif:	Rayé\r\ndétails:	Ceinture, Poche, Avec boutons devant\r\nType:	Chemise\r\nType du col:	Col chemise\r\nLongueur des manches:	Manches mi-longues\r\nType de manches:	Épaules Tombantes\r\nTour de taille:	Taille haute\r\nOurlet/finition:	Évasé\r\nLongueur:	Long\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Coton\r\nComposition:	50% Coton, 50% Rayonne\r\nInstructions d\'entretien:	Lavage à la main ou nettoyage à sec professionnel\r\nceinture:	OUI\r\nTransparent:	Non', 170, 'DAZY', 46, '0000-00-00', '668_12.webp', '107_24.webp', '507_15.webp', 0),
(57, 'Robe léopard manches bouffantes à volants', 'Couleur:	Bleu et Blanc\r\nStyle:	Bohème\r\nType de motif:	Léopard\r\ndétails:	Ourlet à volants\r\nType:	Robe à smocks\r\nType du col:	Découpe V\r\nLongueur des manches:	Manches longues\r\nType de manches:	Manches bishop\r\nTour de taille:	Taille haute\r\nOurlet/finition:	Volants\r\nLongueur:	Long\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Polyester\r\nComposition:	100% Polyester\r\nInstructions d\'entretien:	Lavage en machine ou nettoyage à sec professionnel\r\nTransparent:	Non', 250, 'bershka', 46, '0000-00-00', '488_1.webp', '624_2.webp', '748_3.webp', 0),
(58, 'Robe trapèze fleurie à manches évasées', 'Couleur:	Vert céladon\r\nStyle:	Bohème\r\nType de motif:	imprimé floral\r\ndétails:	Froncé\r\nType:	Trapèze\r\nType du col:	Col carré\r\nLongueur des manches:	Manches longues\r\nType de manches:	Manches évasées\r\nTour de taille:	Taille haute\r\nOurlet/finition:	Évasé\r\nLongueur:	Long\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Extensibilité légère\r\nTissu/matériel:	Polyester\r\nComposition:	100% Polyester\r\nInstructions d\'entretien:	Lavage en machine ou nettoyage à sec professionnel\r\nDoublure:	Non\r\nTransparent:	Non', 200, 'LC waikiki', 46, '0000-00-00', '394_4.webp', '505_5.webp', '991_6.webp', 0),
(59, 'DAZY T-shirts pour femmes Casual Lettres', 'Couleur:	Blanc\r\nStyle:	Casual\r\nType de motif:	Lettres\r\nType du col:	Col rond\r\nLongueur des manches:	Manches mi-longues\r\nType de manches:	Épaules Tombantes\r\nLongueur:	Long\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Coton\r\nComposition:	100% Coton\r\nInstructions d\'entretien:	Lavage en machine ou nettoyage à sec professionnel\r\nTransparent:	Non', 100, 'DAZY', 47, '0000-00-00', '460_7.webp', '168_8.webp', '441_9.webp', 0),
(60, 'DAZY T-shirt à broderie', 'Couleur:	Rose pâle\r\nStyle:	Casual\r\nType de motif:	Slogan\r\nType du col:	Col rond\r\ndétails:	Broderie\r\nLongueur des manches:	Manches courtes\r\nType de manches:	Épaules Tombantes\r\nLongueur:	Long\r\nType de fermeture:	À enfiler\r\nType d\'ajustement:	Oversize\r\nTissu:	Extensibilité légère\r\nTissu/matériel:	Coton\r\nComposition:	100% Coton\r\nInstructions d\'entretien:	Lavage en machine ou nettoyage à sec professionnel\r\nTransparent:	Non', 80, 'DAZY', 47, '0000-00-00', '249_11.webp', '137_53.webp', '154_33.webp', 0),
(61, 'Pantoufles avec perles', 'Couleur:	Tabac\r\nStyle:	À la mode\r\nQuantité:	1 paire\r\nMatière semelle extérieure:	Caoutchouc\r\nType de motif:	Unicolore\r\nTissu de doublure:	Cuir PU\r\nBout:	Orteil ouvert\r\nMatière extérieure:	Cuir PU\r\ndétails:	Perle\r\nMatière Semelle Intérieure:	Cuir PU\r\nTaille appropriée:	Fidèle à la pointure', 60, 'HERMES', 49, '0000-00-00', '386_2.webp', '89_3.webp', '373_1.webp', 0),
(62, 'Sandales gladiateur plates croisé sangle', 'Couleur:	Vert\r\nStyle:	À la mode\r\nQuantité:	1 paire\r\nMatière semelle extérieure:	Caoutchouc\r\nType de motif:	Unicolore\r\nTissu de doublure:	Cuir PU\r\nBout:	Orteil ouvert\r\nMatière extérieure:	Cuir PU\r\nMatière Semelle Intérieure:	Cuir PU\r\nType:	Sandales style gladiateur', 90, 'bershka', 49, '0000-00-00', '897_4.webp', '600_5.webp', '726_6.webp', 0),
(63, 'Chaussures skateboard à lacets à foulard', 'Style:	BCBG\r\nCouleur:	Blanc\r\nQuantité:	1 paire\r\nType de brides (cm):	Lacets\r\nType de motif:	Blocs de couleur\r\nHauteur supérieure:	Chaussures basses\r\nType:	Chaussures de skate-board\r\nTaille appropriée:	Fidèle à la pointure\r\nTissu de doublure:	Cuir PU\r\nMatière Semelle Intérieure:	EVA\r\nMatière semelle extérieure:	PVC\r\nMatière extérieure:	Cuir PU', 200, 'LC waikiki', 49, '0000-00-00', '849_7.webp', '628_8.webp', '940_9.webp', 0),
(64, 'Cuccoo Sandales plates à blocs de couleurs', 'Couleur:	Multicolore\r\nStyle:	À la mode\r\nQuantité:	1 paire\r\nMatière semelle extérieure:	Caoutchouc\r\nType de motif:	Blocs de couleur\r\nTissu de doublure:	Polyester\r\nBout:	Orteil ouvert\r\nMatière extérieure:	Étoffe\r\nMatière Semelle Intérieure:	Cuir PU\r\nType:	Pantoufle', 100, 'Cuccoo', 49, '0000-00-00', '563_11.webp', '597_22.webp', '392_66.webp', 0),
(65, 'DAZY Jean taille haute ample', 'Couleur:	Jean bleu\r\nType de motif:	Unicolore\r\nType:	ample\r\nType de fermeture:	Zippé\r\ndétails:	Boutons, Poche, Fermeture éclair\r\nTour de taille:	Taille haute\r\nLongueur:	Long\r\nType d\'ajustement:	Large\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Jean\r\nComposition:	90% Coton, 6% Polyester, 4% Viscose\r\nInstructions d\'entretien:	Lavage à la main ou nettoyage à sec professionnel\r\nDoublure:	Sans doublure\r\nTransparent:	Non', 200, 'DAZY', 48, '0000-00-00', '236_3.webp', '270_12.webp', '940_1.webp', 0),
(66, 'DAZY Jean droit fendu', 'Couleur:	Jean brut\r\nType de motif:	Unicolore\r\nType:	Coupe droite\r\nType de fermeture:	Zippé\r\ndétails:	Fendu, Ourlet effiloché, Poche\r\nTour de taille:	Taille haute\r\nLongueur:	Long\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Jean\r\nComposition:	85% Coton, 12% Polyester, 3% Élasthanne\r\nInstructions d\'entretien:	Lavage en machine, ne pas laver à sec\r\nDoublure:	Sans doublure\r\nTransparent:	Non', 180, 'DAZY', 48, '0000-00-00', '632_2.webp', '972_256.webp', '97_33.webp', 0),
(67, 'Jean droit ourlet effiloché déchiré', 'Couleur:	Jean clair\r\nType de motif:	Unicolore\r\nType:	Coupe droite\r\nType de fermeture:	Zippé\r\ndétails:	Déchiré, Poche\r\nTour de taille:	Naturel\r\nLongueur:	Long\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Jean\r\nComposition:	84.2% Coton, 10.4% Polyester, 5.4% Viscose\r\nInstructions d\'entretien:	Lavage en machine ou nettoyage à sec professionnel\r\nDoublure:	Sans doublure\r\nTransparent:	Non', 200, 'leftis', 48, '0000-00-00', '580_100.webp', '311_200.webp', '500_300.webp', 0),
(68, 'SHEIN PETITE Jean cargo à imprimé camouflage à poche à rabat', 'Couleur:	Multicolore\r\nType de motif:	Militaire\r\nStyle de jean:	Pantalons cargo\r\nType:	Carotte\r\nType de fermeture:	Zippé\r\ndétails:	Boutons, Poche, Fermeture éclair\r\nTour de taille:	Taille haute\r\nLongueur:	Long\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Jean\r\nComposition:	85% Coton, 15% Polyester\r\nInstructions d\'entretien:	Lavage en machine, ne pas laver à sec\r\nDoublure:	Sans doublure\r\nTransparent:	Non', 170, 'mango', 48, '0000-00-00', '162_55.webp', '149_305.webp', '756_500.webp', 0),
(69, 'Pantalon de survêtement à poche à cordon', 'Couleur:	Gris pâle\r\nType de motif:	Unicolore\r\ndétails:	Poche, Cordon\r\nType de fermeture:	Cordon à la taille\r\nTour de taille:	Taille haute\r\nLongueur:	Long\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Pas de l\'extensibilité\r\nTissu/matériel:	Polyester\r\nComposition:	100% Polyester\r\nInstructions d\'entretien:	Lavage en machine ou nettoyage à sec professionnel\r\nDoublure:	Sans doublure\r\nTransparent:	Non', 150, 'bershka', 48, '0000-00-00', '559_123.webp', '512_456.webp', '1_789.webp', 0),
(70, 'Sac de baguette en relief de crocodile', 'Couleur:	Vert\r\nType de motif:	Crocodile\r\nStyle:	À la mode\r\nTaille du sac:	Petit\r\nQuantité:	1 pièce\r\nMagnétique:	Non\r\nType:	Sac baguette\r\nRevêtement:	100% Polyuréthane\r\nComposition:	100% Polyester\r\nTissu/matériel:	Cuir PU', 80, 'parfois', 50, '0000-00-00', '803_1.webp', '369_2.webp', '70_3.webp', 0),
(71, 'Fille Sac carré à lettres à bouton à rabat chaîne', 'Couleur:	Blanc\r\nSexe:	Filles\r\nQuantité:	1 pièce\r\nType de brides (cm):	Chaîne\r\nType de motif:	Lettres\r\nTaille du sac:	Petit\r\nTissu/matériel:	Cuir PU\r\nComposition:	100% Polyuréthane', 94, 'parfois', 50, '0000-00-00', '654_4.webp', '640_5.webp', '846_6.webp', 0),
(72, 'Fille Sac fantaisie en tissu duveteux design cœur à chaîne', 'Couleur:	Noir\r\nSexe:	Filles\r\nQuantité:	1 pièce\r\nTissu/matériel:	Polyester\r\nComposition:	100% Polyester', 60, 'primark', 50, '0000-00-00', '508_7.webp', '30_8.webp', '338_9.webp', 0),
(73, 'Sac à dos à boucle à lettres à blocs de couleurs', 'Couleur:	Black azur\r\nType de brides (cm):	Ajustable\r\nType de motif:	Cartoon, Lettres\r\nStyle:	BCBG\r\nTaille du sac:	Grand\r\nQuantité:	1 pièce\r\nType:	Sac à dos fonctionnel\r\nComposition:	100% Nylon\r\nTissu/matériel:	Nylon', 180, 'mango', 50, '0000-00-00', '876_10.webp', '721_20.webp', '977_30.webp', 0),
(74, 'DAZY T-shirt unicolore', 'Couleur:	Bleu ciel\r\nStyle:	Casual\r\nType de motif:	Unicolore\r\nType du col:	Col rond\r\nLongueur des manches:	Manches mi-longues\r\nType de manches:	Épaules Tombantes\r\nLongueur:	Long\r\nType de fermeture:	À enfiler\r\nType d\'ajustement:	Coupe régulière\r\nTissu:	Extensibilité légère\r\nTissu/matériel:	Coton\r\nComposition:	100% Coton\r\nInstructions d\'entretien:	Lavage en machine ou nettoyage à sec professionnel\r\nTransparent:	Non', 70, 'DAZY', 47, '0000-00-00', '255_123.webp', '544_456.webp', '872_789.webp', 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Nom` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Prenom` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Adresse` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Ville` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Telephone` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `grpID` int(11) NOT NULL DEFAULT 0,
  `datecreation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`userID`, `password`, `email`, `Nom`, `Prenom`, `Adresse`, `Ville`, `Telephone`, `grpID`, `datecreation`) VALUES
(56, 'ef029adc368318156eef86e32d3b146c7f6c4e6e', 'lamyaa2022@gmail.com', 'fatih', 'lamyaa', NULL, NULL, '', 1, '2022-02-28 15:54:37'),
(58, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'lamyaa@gmail.com', 'fatih', 'lamyaa', '', '', '', 0, '2022-03-03 21:59:10'),
(59, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'ikram@gmail.com', 'mouchtahi', 'ikram', NULL, NULL, NULL, 0, '2022-03-03 22:00:13'),
(60, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'nadia@gmail.com', 'idrahou', 'nadia', NULL, NULL, '', 0, '2022-06-15 18:03:27');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_ID`),
  ADD UNIQUE KEY `cat_name` (`cat_name`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id_panier`),
  ADD KEY `id_pr` (`id_pr`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`prod_ID`),
  ADD KEY `cat_1` (`id_cat_et`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'L''identifiant de la catégorie', AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id_panier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `prod_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'L''identifiant du produit', AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`id_pr`) REFERENCES `produits` (`prod_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`id_cat_et`) REFERENCES `categories` (`cat_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
