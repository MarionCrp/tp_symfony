-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           10.2.3-MariaDB-log - mariadb.org binary distribution
-- SE du serveur:                Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour sil16
CREATE DATABASE IF NOT EXISTS `sil16` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sil16`;

-- Export de la structure de la table sil16. admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table sil16.admin : ~0 rows (environ)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
	(1, 'SuperAdmin', 'TropFort', 'admin@email.com', 'toto');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Export de la structure de la table sil16. commande
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6EEAA67D9395C3F3` (`customer_id`),
  CONSTRAINT `FK_6EEAA67D9395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table sil16.commande : ~34 rows (environ)
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` (`id`, `customer_id`, `created_at`, `state`) VALUES
	(51, 14, '2017-04-28 22:32:36', 'send');
/*!40000 ALTER TABLE `commande` ENABLE KEYS */;

-- Export de la structure de la table sil16. customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table sil16.customer : ~7 rows (environ)
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` (`id`, `firstname`, `lastname`, `email`, `password`, `is_admin`) VALUES
	(13, 'Toto', 'La Fripouille', 'user@email.com', '$2y$12$Ki6czqUX1Woes0jJy19tTuQEM7hFB8dWJPvAuPuAwHwyByFdDNcH6', 0),
	(14, 'Marion', 'Craipeau', 'admin@email.com', '$2y$12$Ki6czqUX1Woes0jJy19tTuQEM7hFB8dWJPvAuPuAwHwyByFdDNcH6', 1);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;

-- Export de la structure de la table sil16. order_line
CREATE TABLE IF NOT EXISTS `order_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9CE58EE14584665A` (`product_id`),
  KEY `IDX_9CE58EE182EA2E54` (`commande_id`),
  CONSTRAINT `FK_9CE58EE14584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_9CE58EE182EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table sil16.order_line : ~0 rows (environ)
/*!40000 ALTER TABLE `order_line` DISABLE KEYS */;
INSERT INTO `order_line` (`id`, `product_id`, `commande_id`, `quantity`, `unit_price`) VALUES
	(1, 8, 51, 1, 49.99),
	(2, 4, 51, 3, 49.99);
/*!40000 ALTER TABLE `order_line` ENABLE KEYS */;

-- Export de la structure de la table sil16. picture
CREATE TABLE IF NOT EXISTS `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `picture_category_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `alt` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_16DB4F894584665A` (`product_id`),
  KEY `IDX_16DB4F898C0ED801` (`picture_category_id`),
  CONSTRAINT `FK_16DB4F894584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_16DB4F898C0ED801` FOREIGN KEY (`picture_category_id`) REFERENCES `picture_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table sil16.picture : ~16 rows (environ)
/*!40000 ALTER TABLE `picture` DISABLE KEYS */;
INSERT INTO `picture` (`id`, `product_id`, `picture_category_id`, `name`, `alt`) VALUES
	(1, 1, 2, 'img_02_off', 'Mahara Noir'),
	(2, 1, 1, 'img_02_on', 'Mahara Noir'),
	(3, 2, 2, 'img_04_off', 'Mahara Blanc'),
	(4, 2, 1, 'img_04_on', 'Mahara Blanc'),
	(5, 3, 2, 'img_01_off', 'Kanur'),
	(6, 3, 1, 'img_01_on', 'Kanur'),
	(7, 4, 2, 'img_03_off', 'Sewal'),
	(8, 4, 1, 'img_03_on', 'Sewal'),
	(9, 5, 2, 'img_05_off', 'Mulshi'),
	(10, 5, 1, 'img_05_on', 'Mulshi'),
	(11, 6, 2, 'img_08_off', 'Alix'),
	(12, 6, 1, 'img_08_on', 'Alix'),
	(13, 7, 2, 'img_07_off', 'Pedro'),
	(14, 7, 1, 'img_07_on', 'Pedro'),
	(15, 8, 2, 'img_06_off', 'Soft'),
	(16, 8, 1, 'img_06_on', 'Soft');
/*!40000 ALTER TABLE `picture` ENABLE KEYS */;

-- Export de la structure de la table sil16. picture_category
CREATE TABLE IF NOT EXISTS `picture_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table sil16.picture_category : ~2 rows (environ)
/*!40000 ALTER TABLE `picture_category` DISABLE KEYS */;
INSERT INTO `picture_category` (`id`, `name`) VALUES
	(1, 'on'),
	(2, 'off');
/*!40000 ALTER TABLE `picture_category` ENABLE KEYS */;

-- Export de la structure de la table sil16. product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04ADBE6903FD` (`product_category_id`),
  CONSTRAINT `FK_D34A04ADBE6903FD` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table sil16.product : ~10 rows (environ)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `product_category_id`, `name`, `price`, `description`, `stock`, `active`) VALUES
	(1, 2, 'Mahara NoirT', 120.00, NULL, 0, 1),
	(2, 3, 'Mahara Blanc', 99.90, 'Forme originale et look tendance pour cette lampe avec abat-jour tout en chrome coloris argenté.', 39, 0),
	(3, 2, 'Kanur', 59.90, 'Pour un dépaysement garanti, invitez les lumières chaudes de l\'Orient dans votre intérieur avec cette belle lampe à poser.', 2, 1),
	(4, 2, 'Sewal', 49.99, 'Une très belle lampe à poser qui trouve son originalité dans ses 3 points lumineux et abats-jour de coloris différents, ainsi qu\'avec son pied en acier brossé !', 14, 1),
	(5, 2, 'Mulshi', 39.99, 'Forme originale et look tendance pour cette lampe avec abat-jour tout en noir et au coloris chromé.', 30, 1),
	(6, 3, 'Alix', 2.99, 'Cette boule japonaise en papier adopte un coloris neutre et un look romantique, pour décorer et éclairer en beauté la chambre de votre bout de chou. Ce luminaire fera sensation auprès de tous !', 8, 1),
	(7, 1, 'Pedro', 49.99, 'Avec son look intemporel, cette lampe de bureau en métal noir fera sensation dans toutes les pièces de votre maison, aussi bien dans votre salon que dans votre chambre ou votre bureau. Son bras articulé vous permettra d\'orienter la lumière avec précision vers l\'endroit que vous souhaitez.', 30, 0),
	(8, 1, 'Soft', 49.99, 'Cette lampe de bureau mêle bois et métal pour un effet industriel très tendance dans votre bureau.', 29, 1),
	(9, 3, 'Photo non trouvée', 35.99, 'Une lampe avec nom de picture pas trouvé', 15, 1),
	(10, 1, 'Produit actif', 20.00, NULL, 20, 1),
	(11, 1, 'test', 20.00, 'test', 19, 1),
	(12, 4, 'La Lampe à Derre', 150.00, 'La description de la lampe', 20, 1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Export de la structure de la table sil16. product_category
CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table sil16.product_category : ~4 rows (environ)
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` (`id`, `name`) VALUES
	(1, 'Lampe de Bureau'),
	(2, 'Lampe à poser'),
	(3, 'Lampe enfant'),
	(4, 'Lampadaire');
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
