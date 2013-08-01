# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: icase
# Generation Time: 2013-08-01 14:19:46 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table admins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` int(11) DEFAULT NULL,
  `email` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `parent_guid` char(13) DEFAULT NULL,
  `group_guid` char(13) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `children` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `guid`, `parent_guid`, `group_guid`, `name`, `description`, `level`, `children`, `order`)
VALUES
	(1,'51fa32042e486','','51fa32042e411','iphone','',0,2,0),
	(2,'51fa32098b08e','51fa32042e486','51fa32042e411','iphone4','',1,0,0),
	(3,'51fa320c55f4a','51fa32042e486','51fa32042e411','iphone5','',1,0,0);

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table category_to_object
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category_to_object`;

CREATE TABLE `category_to_object` (
  `category_guid` char(13) DEFAULT NULL,
  `object_guid` char(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `category_to_object` WRITE;
/*!40000 ALTER TABLE `category_to_object` DISABLE KEYS */;

INSERT INTO `category_to_object` (`category_guid`, `object_guid`)
VALUES
	('51fa32042e486','51fa6a502b35c'),
	('51fa32098b08e','51fa6a502b35c'),
	('51fa320c55f4a','51fa6a502b35c'),
	('51fa32042e486','51fa6a565fc04'),
	('51fa32098b08e','51fa6a565fc04'),
	('51fa320c55f4a','51fa6a565fc04'),
	('51fa32042e486','51fa6a5761188'),
	('51fa32098b08e','51fa6a5761188'),
	('51fa320c55f4a','51fa6a5761188'),
	('51fa32042e486','51fa6a5851ba7'),
	('51fa32098b08e','51fa6a5851ba7'),
	('51fa320c55f4a','51fa6a5851ba7'),
	('51fa32042e486','51fa6a593ed90'),
	('51fa32098b08e','51fa6a593ed90'),
	('51fa320c55f4a','51fa6a593ed90'),
	('51fa32042e486','51fa6c1d6bdd2'),
	('51fa32098b08e','51fa6c1d6bdd2'),
	('51fa320c55f4a','51fa6c1d6bdd2'),
	('51fa32042e486','51fa6c1dd1989'),
	('51fa32098b08e','51fa6c1dd1989'),
	('51fa320c55f4a','51fa6c1dd1989'),
	('51fa32042e486','51fa6c1e771a6'),
	('51fa32098b08e','51fa6c1e771a6'),
	('51fa320c55f4a','51fa6c1e771a6'),
	('51fa32042e486','51fa6c1eba190'),
	('51fa32098b08e','51fa6c1eba190'),
	('51fa320c55f4a','51fa6c1eba190'),
	('51fa32042e486','51fa6c1f0aa2e'),
	('51fa32098b08e','51fa6c1f0aa2e'),
	('51fa320c55f4a','51fa6c1f0aa2e'),
	('51fa32042e486','51fa6c1f44dac'),
	('51fa32098b08e','51fa6c1f44dac'),
	('51fa320c55f4a','51fa6c1f44dac'),
	('51fa32042e486','51fa6c1f7b8db'),
	('51fa32098b08e','51fa6c1f7b8db'),
	('51fa320c55f4a','51fa6c1f7b8db'),
	('51fa32042e486','51fa6c1faec90'),
	('51fa32098b08e','51fa6c1faec90'),
	('51fa320c55f4a','51fa6c1faec90'),
	('51fa32042e486','51fa6c1fdd0dc'),
	('51fa32098b08e','51fa6c1fdd0dc'),
	('51fa320c55f4a','51fa6c1fdd0dc'),
	('51fa32042e486','51fa6c2018bfa'),
	('51fa32098b08e','51fa6c2018bfa'),
	('51fa320c55f4a','51fa6c2018bfa'),
	('51fa32042e486','51fa6c204ca4d'),
	('51fa32098b08e','51fa6c204ca4d'),
	('51fa320c55f4a','51fa6c204ca4d'),
	('51fa32042e486','51fa6c207b641'),
	('51fa32098b08e','51fa6c207b641'),
	('51fa320c55f4a','51fa6c207b641'),
	('51fa32042e486','51fa6c20a9a91'),
	('51fa32098b08e','51fa6c20a9a91'),
	('51fa320c55f4a','51fa6c20a9a91'),
	('51fa32042e486','51fa6c20d5390'),
	('51fa32098b08e','51fa6c20d5390'),
	('51fa320c55f4a','51fa6c20d5390'),
	('51fa32042e486','51fa6c210e60f'),
	('51fa32098b08e','51fa6c210e60f'),
	('51fa320c55f4a','51fa6c210e60f'),
	('51fa32042e486','51fa6c213e8b4'),
	('51fa32098b08e','51fa6c213e8b4'),
	('51fa320c55f4a','51fa6c213e8b4'),
	('51fa32042e486','51fa6c216f8a4'),
	('51fa32098b08e','51fa6c216f8a4'),
	('51fa320c55f4a','51fa6c216f8a4'),
	('51fa32042e486','51fa6c219b34f'),
	('51fa32098b08e','51fa6c219b34f'),
	('51fa320c55f4a','51fa6c219b34f'),
	('51fa32042e486','51fa6c21c8b65'),
	('51fa32098b08e','51fa6c21c8b65'),
	('51fa320c55f4a','51fa6c21c8b65'),
	('51fa32042e486','51fa6c22022e7'),
	('51fa32098b08e','51fa6c22022e7'),
	('51fa320c55f4a','51fa6c22022e7'),
	('51fa32042e486','51fa6c2232a26'),
	('51fa32098b08e','51fa6c2232a26'),
	('51fa320c55f4a','51fa6c2232a26'),
	('51fa32042e486','51fa6c2262016'),
	('51fa32098b08e','51fa6c2262016'),
	('51fa320c55f4a','51fa6c2262016'),
	('51fa32042e486','51fa6c22922a4'),
	('51fa32098b08e','51fa6c22922a4'),
	('51fa320c55f4a','51fa6c22922a4'),
	('51fa32042e486','51fa6c22c076e'),
	('51fa32098b08e','51fa6c22c076e'),
	('51fa320c55f4a','51fa6c22c076e'),
	('51fa32042e486','51fa6c22ee7fc'),
	('51fa32098b08e','51fa6c22ee7fc'),
	('51fa320c55f4a','51fa6c22ee7fc'),
	('51fa32042e486','51fa6c232af93'),
	('51fa32098b08e','51fa6c232af93'),
	('51fa320c55f4a','51fa6c232af93'),
	('51fa32042e486','51fa6c235b9d9'),
	('51fa32098b08e','51fa6c235b9d9'),
	('51fa320c55f4a','51fa6c235b9d9'),
	('51fa32042e486','51fa6c238cc1d'),
	('51fa32098b08e','51fa6c238cc1d'),
	('51fa320c55f4a','51fa6c238cc1d'),
	('51fa32042e486','51fa6c23be261'),
	('51fa32098b08e','51fa6c23be261'),
	('51fa320c55f4a','51fa6c23be261'),
	('51fa32042e486','51fa6c23eba42'),
	('51fa32098b08e','51fa6c23eba42'),
	('51fa320c55f4a','51fa6c23eba42'),
	('51fa32042e486','51fa6c242561f'),
	('51fa32098b08e','51fa6c242561f'),
	('51fa320c55f4a','51fa6c242561f'),
	('51fa32042e486','51fa6c245622e'),
	('51fa32098b08e','51fa6c245622e'),
	('51fa320c55f4a','51fa6c245622e'),
	('51fa32042e486','51fa6c2489c7c'),
	('51fa32098b08e','51fa6c2489c7c'),
	('51fa320c55f4a','51fa6c2489c7c'),
	('51fa32042e486','51fa6c24badd8'),
	('51fa32098b08e','51fa6c24badd8'),
	('51fa320c55f4a','51fa6c24badd8'),
	('51fa32042e486','51fa6c24ed18f'),
	('51fa32098b08e','51fa6c24ed18f'),
	('51fa320c55f4a','51fa6c24ed18f'),
	('51fa32042e486','51fa6c252aa47'),
	('51fa32098b08e','51fa6c252aa47'),
	('51fa320c55f4a','51fa6c252aa47'),
	('51fa32042e486','51fa6c255985b'),
	('51fa32098b08e','51fa6c255985b'),
	('51fa320c55f4a','51fa6c255985b'),
	('51fa32042e486','51fa6c2589e8a'),
	('51fa32098b08e','51fa6c2589e8a'),
	('51fa320c55f4a','51fa6c2589e8a'),
	('51fa32042e486','51fa6c25ba016'),
	('51fa32098b08e','51fa6c25ba016'),
	('51fa320c55f4a','51fa6c25ba016');

/*!40000 ALTER TABLE `category_to_object` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table coupons
# ------------------------------------------------------------

DROP TABLE IF EXISTS `coupons`;

CREATE TABLE `coupons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `end` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table express
# ------------------------------------------------------------

DROP TABLE IF EXISTS `express`;

CREATE TABLE `express` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `price` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table invoices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `order_guid` char(13) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table keywords
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keywords`;

CREATE TABLE `keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table media_to_object
# ------------------------------------------------------------

DROP TABLE IF EXISTS `media_to_object`;

CREATE TABLE `media_to_object` (
  `object_guid` char(13) NOT NULL DEFAULT '',
  `media_guid` char(13) NOT NULL DEFAULT '',
  `type` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table medias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `medias`;

CREATE TABLE `medias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `original` varchar(256) DEFAULT NULL,
  `filename` varchar(256) DEFAULT NULL,
  `extension` varchar(16) DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `product_guid` char(13) DEFAULT NULL,
  `buyer_guid` char(13) DEFAULT NULL,
  `seller_guid` char(13) NOT NULL DEFAULT '0',
  `deliver_guid` char(13) DEFAULT NULL,
  `description` text,
  `status` varchar(11) NOT NULL DEFAULT 'pending',
  `amount` decimal(11,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `tax` decimal(11,2) DEFAULT NULL,
  `express_fee` decimal(11,2) DEFAULT NULL,
  `payment` varchar(11) DEFAULT NULL,
  `express` varchar(11) DEFAULT NULL,
  `file` varchar(1024) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;

INSERT INTO `orders` (`id`, `guid`, `product_guid`, `buyer_guid`, `seller_guid`, `deliver_guid`, `description`, `status`, `amount`, `quantity`, `tax`, `express_fee`, `payment`, `express`, `file`, `created`, `modified`)
VALUES
	(1,NULL,NULL,NULL,'0',NULL,NULL,'pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1374678489,1374678489),
	(2,NULL,NULL,NULL,'0',NULL,NULL,'pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1374678777,1374678777),
	(3,NULL,NULL,NULL,'0',NULL,NULL,'pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1374678811,1374678811),
	(4,NULL,NULL,NULL,'0',NULL,NULL,'pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1374678961,1374678961),
	(5,NULL,NULL,NULL,'0',NULL,NULL,'pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1374679171,1374679171),
	(6,NULL,NULL,NULL,'0',NULL,NULL,'pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1374679222,1374679222),
	(7,NULL,NULL,NULL,'0',NULL,NULL,'pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1374679332,1374679332),
	(8,'51eff2010bbbb',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374679553,1374679553),
	(9,'51eff23cdd8b2',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374679612,1374679612),
	(10,'51eff25a181f4',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374679642,1374679642),
	(11,'51eff28d69e7b',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374679693,1374679693),
	(12,'51eff2aa7d9ca',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374679722,1374679722),
	(13,'51eff2bfaeace',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374679743,1374679743),
	(14,'51eff324ad2e6',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374679844,1374679844),
	(15,'51eff38279984',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374679938,1374679938),
	(16,'51eff39ce3809',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374679964,1374679964),
	(17,'51eff3df11c80',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680031,1374680031),
	(18,'51eff41270294',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680082,1374680082),
	(19,'51eff424a5c9f',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680100,1374680100),
	(20,'51eff46dd0b19',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680173,1374680173),
	(21,'51eff4ee1df6d',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680302,1374680302),
	(22,'51eff53634a54',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680374,1374680374),
	(23,'51eff5665b13d',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680422,1374680422),
	(24,'51eff5cdb3480',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680525,1374680525),
	(25,'51eff5f020b2c',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680560,1374680560),
	(26,'51eff5fb12ebb',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680571,1374680571),
	(27,'51eff61d7870e',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680605,1374680605),
	(28,'51eff652baf95',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680658,1374680658),
	(29,'51eff665581ee',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680677,1374680677),
	(30,'51eff694947af',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680724,1374680724),
	(31,'51eff6b15c1fd',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680753,1374680753),
	(32,'51eff6d03e410',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680784,1374680784),
	(33,'51eff6e42c360',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680804,1374680804),
	(34,'51eff6f383358',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680819,1374680819),
	(35,'51eff730c7c58',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680880,1374680880),
	(36,'51eff74ece8e7',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680910,1374680910),
	(37,'51eff76d8206a',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680941,1374680941),
	(38,'51eff789942ee',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374680969,1374680969),
	(39,'51eff7e822516',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681064,1374681064),
	(40,'51eff81f9a312',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681119,1374681119),
	(41,'51eff845421cf',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681157,1374681157),
	(42,'51eff85273ca7',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681170,1374681170),
	(43,'51eff868b3ada',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681192,1374681192),
	(44,'51eff87adce4b',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681210,1374681210),
	(45,'51eff8b5f3039',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681269,1374681269),
	(46,'51eff8d8d43f0',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681304,1374681304),
	(47,'51eff947e7cb4',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681415,1374681415),
	(48,'51eff96865cee',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681448,1374681448),
	(49,'51eff98d2a891',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681485,1374681485),
	(50,'51eff9a83c8ab',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681512,1374681512),
	(51,'51eff9dc54c68',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681564,1374681564),
	(52,'51eff9e997e6a',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681577,1374681577),
	(53,'51effa15b495e',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681621,1374681621),
	(54,'51effa3736b3a',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681655,1374681655),
	(55,'51effa4a73e17',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681674,1374681674),
	(56,'51effa6de5bc1',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681709,1374681709),
	(57,'51effab32c28c',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681779,1374681779),
	(58,'51effac140876',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681793,1374681793),
	(59,'51effaf6d84d7',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681846,1374681846),
	(60,'51effb1b4f276',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681883,1374681883),
	(61,'51effb2e43d84',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681902,1374681902),
	(62,'51effb56d69d0',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681942,1374681942),
	(63,'51effb730495f',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374681971,1374681971),
	(64,'51effbaff2acb',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374682031,1374682031),
	(65,'51effbc0489e3',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374682048,1374682048),
	(66,'51effbd3b539e',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374682067,1374682067),
	(67,'51effbeecb1e7',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374682094,1374682094),
	(68,'51effc190242d',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374682137,1374682137),
	(69,'51effc411254e',NULL,'51eff1f1c8a4f','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51eff1f5ae789.jpeg',1374682177,1374682177),
	(70,'51f0015ca6899',NULL,'51f0013f6eb5e','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51f001595b6af.jpeg',1374683484,1374683484),
	(71,'51f001d886448',NULL,'51f0013f6eb5e','0',NULL,NULL,'pending',59.32,1,NULL,NULL,NULL,NULL,'51f001d0b290c.jpeg',1374683608,1374683608);

/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `user_guid` char(13) DEFAULT NULL,
  `name` varchar(512) DEFAULT NULL,
  `image` varchar(1024) DEFAULT NULL,
  `featured` text,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(2,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `is_special` int(11) NOT NULL DEFAULT '0',
  `special_price` decimal(10,2) DEFAULT NULL,
  `special_start` int(11) DEFAULT NULL,
  `special_end` int(11) DEFAULT NULL,
  `type` varchar(16) NOT NULL DEFAULT 'product',
  `status` varchar(11) NOT NULL DEFAULT 'draft',
  `active` int(11) NOT NULL DEFAULT '1',
  `seo_keywords` varchar(512) DEFAULT NULL,
  `seo_meta` varchar(512) DEFAULT NULL,
  `seo_description` varchar(512) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `guid`, `user_guid`, `name`, `image`, `featured`, `description`, `price`, `tax`, `discount`, `quantity`, `is_special`, `special_price`, `special_start`, `special_end`, `type`, `status`, `active`, `seo_keywords`, `seo_meta`, `seo_description`, `created`, `modified`)
VALUES
	(1,'51fa6a502b35c',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375365712,1375365712),
	(2,'51fa6a565fc04',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375365718,1375365718),
	(3,'51fa6a5761188',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375365719,1375365719),
	(4,'51fa6a5851ba7',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375365720,1375365720),
	(5,'51fa6a593ed90',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375365721,1375365721),
	(6,'51fa6c1d6bdd2',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366173,1375366173),
	(7,'51fa6c1dd1989',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366173,1375366173),
	(8,'51fa6c1e771a6',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366174,1375366174),
	(9,'51fa6c1eba190',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366174,1375366174),
	(10,'51fa6c1f0aa2e',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366175,1375366175),
	(11,'51fa6c1f44dac',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366175,1375366175),
	(12,'51fa6c1f7b8db',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366175,1375366175),
	(13,'51fa6c1faec90',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366175,1375366175),
	(14,'51fa6c1fdd0dc',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366175,1375366175),
	(15,'51fa6c2018bfa',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366176,1375366176),
	(16,'51fa6c204ca4d',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366176,1375366176),
	(17,'51fa6c207b641',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366176,1375366176),
	(18,'51fa6c20a9a91',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366176,1375366176),
	(19,'51fa6c20d5390',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366176,1375366176),
	(20,'51fa6c210e60f',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366177,1375366177),
	(21,'51fa6c213e8b4',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366177,1375366177),
	(22,'51fa6c216f8a4',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366177,1375366177),
	(23,'51fa6c219b34f',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366177,1375366177),
	(24,'51fa6c21c8b65',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366177,1375366177),
	(25,'51fa6c22022e7',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366178,1375366178),
	(26,'51fa6c2232a26',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366178,1375366178),
	(27,'51fa6c2262016',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366178,1375366178),
	(28,'51fa6c22922a4',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366178,1375366178),
	(29,'51fa6c22c076e',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366178,1375366178),
	(30,'51fa6c22ee7fc',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366178,1375366178),
	(31,'51fa6c232af93',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366179,1375366179),
	(32,'51fa6c235b9d9',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366179,1375366179),
	(33,'51fa6c238cc1d',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366179,1375366179),
	(34,'51fa6c23be261',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366179,1375366179),
	(35,'51fa6c23eba42',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366179,1375366179),
	(36,'51fa6c242561f',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366180,1375366180),
	(37,'51fa6c245622e',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366180,1375366180),
	(38,'51fa6c2489c7c',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366180,1375366180),
	(39,'51fa6c24badd8',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366180,1375366180),
	(40,'51fa6c24ed18f',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366180,1375366180),
	(41,'51fa6c252aa47',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366181,1375366181),
	(42,'51fa6c255985b',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366181,1375366181),
	(43,'51fa6c2589e8a',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366181,1375366181),
	(44,'51fa6c25ba016',NULL,'iphone case sample','51fa6a3c6e4bd.png','a:4:{i:0;s:17:\"51fa6a465e528.png\";i:1;s:17:\"51fa6a4675f27.png\";i:2;s:17:\"51fa6a4696429.png\";i:3;s:17:\"51fa6a46b1b49.png\";}','',23.22,3.33,0.00,2032,1,33.23,1375567200,1377295200,'template','draft',1,NULL,NULL,NULL,1375366181,1375366181);

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_deliver_infos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_deliver_infos`;

CREATE TABLE `user_deliver_infos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `user_guid` char(13) DEFAULT NULL,
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `address1` varchar(1024) DEFAULT NULL,
  `address2` varchar(1024) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `zipcode` varchar(32) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `state` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `email_verfied` int(11) DEFAULT NULL,
  `verfied_code` varchar(128) DEFAULT NULL,
  `verfied_expire` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
