# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: icase
# Generation Time: 2013-08-23 14:48:29 +0000
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
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(128) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(512) DEFAULT NULL,
  `type` varchar(32) NOT NULL DEFAULT 'guest',
  `email_verfied` int(11) NOT NULL DEFAULT '0',
  `verfied_code` varchar(128) DEFAULT NULL,
  `verfied_expire` int(11) DEFAULT NULL,
  `subscribe` int(11) NOT NULL DEFAULT '0',
  `subscribe_content` text,
  `subscribe_schedule` varchar(32) NOT NULL DEFAULT 'daily',
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `country` varchar(32) DEFAULT NULL,
  `state` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `zipcode` varchar(32) DEFAULT NULL,
  `orders` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;

INSERT INTO `admins` (`id`, `guid`, `name`, `email`, `password`, `type`, `email_verfied`, `verfied_code`, `verfied_expire`, `subscribe`, `subscribe_content`, `subscribe_schedule`, `firstname`, `lastname`, `phone`, `country`, `state`, `city`, `address`, `zipcode`, `orders`, `active`, `created`, `modified`)
VALUES
	(3,'521416317b2c4','miller','admin@admin.com','5f4806e34c0f98a6a237f350a80e3a8c7759e24a','register',0,NULL,NULL,0,NULL,'daily',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,1377048113,1377048113);

/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(128) DEFAULT NULL,
  `parent_guid` char(128) DEFAULT NULL,
  `group_guid` char(128) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `slug` varchar(256) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `children` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `seo_keywords` varchar(1024) DEFAULT NULL,
  `seo_description` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `guid`, `parent_guid`, `group_guid`, `name`, `slug`, `description`, `level`, `children`, `order`, `seo_keywords`, `seo_description`)
VALUES
	(1,'520ec53a8b004','','520ec53a8aec1','Galaxy Cases','Galaxy-Cases',NULL,0,2,0,'','Galaxy Cases'),
	(2,'520ec67f5abda','','520ec67f5ab9f','iPhone Cases','iPhone-Cases',NULL,0,2,0,'','iPhone Cases'),
	(3,'520ec697ccbcc','','520ec697cc2a1','Aluminum Water Bottle','Aluminum-Water-Bottle',NULL,0,0,0,'','Aluminum Water Bottle'),
	(4,'520ec6ace78aa','','520ec6ace786f','Dog Tag','Dog-Tag',NULL,0,0,0,'','Dog Tag'),
	(5,'520ec6be5f584','','520ec6be5f54a','Key Chain','Key-Chain',NULL,0,0,0,'','Key Chain'),
	(6,'520ec6cae4ad0','','520ec6cae4a18','Mug','Mug',NULL,0,0,0,'','Mug'),
	(7,'520eca57e2d1a','520ec67f5abda','520ec67f5ab9f','Iphone 5','Iphone-5',NULL,1,0,0,'',''),
	(8,'520eca677cad0','520ec67f5abda','520ec67f5ab9f','Iphone 4','Iphone-4',NULL,1,0,0,'',''),
	(9,'520ecf501b55b','520ec53a8b004','520ec53a8aec1','GS3 ','GS3-',NULL,1,0,0,'',''),
	(10,'520ecf5b25a5b','520ec53a8b004','520ec53a8aec1','GS4','GS4',NULL,1,0,0,'','');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table category_to_object
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category_to_object`;

CREATE TABLE `category_to_object` (
  `category_guid` char(128) DEFAULT NULL,
  `object_guid` char(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `category_to_object` WRITE;
/*!40000 ALTER TABLE `category_to_object` DISABLE KEYS */;

INSERT INTO `category_to_object` (`category_guid`, `object_guid`)
VALUES
	('5209154a2178a','5209156bda4d1'),
	('520ec67f5abda','520ecab000480'),
	('520eca57e2d1a','520ecab000480'),
	('520ec67f5abda','520ecc708b29f'),
	('520eca677cad0','520ecc708b29f'),
	('520ec67f5abda','520ecce1b7ca5'),
	('520eca677cad0','520ecce1b7ca5'),
	('520ec53a8b004','520ecf9589731'),
	('520ecf501b55b','520ecf9589731'),
	('520ec53a8b004','520ed0723c86d'),
	('520ecf501b55b','520ed0723c86d'),
	('520ec67f5abda','520ed0abdfc90'),
	('520eca57e2d1a','520ed0abdfc90'),
	('520ec53a8b004','520ecfe3575eb'),
	('520ecf5b25a5b','520ecfe3575eb'),
	('520ec6be5f584','520ed10438b0a'),
	('520ec53a8b004','520f0f17d0e20'),
	('520ecf501b55b','520f0f17d0e20'),
	('520ecf5b25a5b','520f0f17d0e20'),
	('520ec53a8b004','520f0f671af97'),
	('520ecf501b55b','520f0f671af97'),
	('520ecf5b25a5b','520f0f671af97'),
	('520ec53a8b004','5214168078724'),
	('520ecf501b55b','5214168078724');

/*!40000 ALTER TABLE `category_to_object` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table creations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `creations`;

CREATE TABLE `creations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(128) DEFAULT NULL,
  `user_guid` char(128) DEFAULT NULL,
  `product_guid` char(128) DEFAULT NULL,
  `name` varchar(512) NOT NULL DEFAULT '',
  `data` text NOT NULL,
  `sample` text,
  `type` varchar(32) DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table enquiries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `enquiries`;

CREATE TABLE `enquiries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_guid` char(128) DEFAULT NULL,
  `title` varchar(512) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `phone` varchar(128) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `content` varchar(1024) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table invoices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(128) DEFAULT NULL,
  `order_guid` char(128) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table media_to_object
# ------------------------------------------------------------

DROP TABLE IF EXISTS `media_to_object`;

CREATE TABLE `media_to_object` (
  `object_guid` char(128) NOT NULL DEFAULT '',
  `media_guid` char(128) NOT NULL DEFAULT '',
  `type` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table medias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `medias`;

CREATE TABLE `medias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(128) DEFAULT NULL,
  `name` varchar(512) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `original` varchar(256) DEFAULT NULL,
  `filename` varchar(256) DEFAULT NULL,
  `extension` varchar(16) DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `type` varchar(128) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `options`;

CREATE TABLE `options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(128) DEFAULT NULL,
  `product_guid` char(128) DEFAULT NULL,
  `buyer_guid` char(128) DEFAULT NULL,
  `seller_guid` char(128) DEFAULT NULL,
  `deliver_guid` char(128) DEFAULT NULL,
  `bill_guid` char(13) DEFAULT NULL,
  `title` varchar(512) DEFAULT '',
  `description` varchar(1024) DEFAULT NULL,
  `type` varchar(32) NOT NULL DEFAULT 'product',
  `status` varchar(11) NOT NULL DEFAULT 'paid',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(11,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(11,2) NOT NULL DEFAULT '0.00',
  `express_fee` decimal(11,2) NOT NULL DEFAULT '0.00',
  `express_type` varchar(11) NOT NULL DEFAULT 'free',
  `payment_gateway` varchar(128) DEFAULT 'paypal',
  `transaction_type` varchar(11) DEFAULT NULL,
  `transaction_id` varchar(128) DEFAULT NULL,
  `cc_number` varchar(512) DEFAULT NULL,
  `cc_expired` varchar(128) DEFAULT NULL,
  `attachement` text,
  `notification` varchar(32) DEFAULT '',
  `notification_email` varchar(256) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `user_guid` char(13) DEFAULT NULL,
  `sku` char(64) DEFAULT NULL,
  `name` varchar(512) DEFAULT NULL,
  `slug` varchar(1024) DEFAULT NULL,
  `image` varchar(1024) DEFAULT NULL,
  `featured` text,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `is_special` int(11) NOT NULL DEFAULT '0',
  `special_price` decimal(10,2) DEFAULT NULL,
  `special_start` int(11) DEFAULT NULL,
  `special_end` int(11) DEFAULT NULL,
  `type` varchar(16) NOT NULL DEFAULT 'product',
  `status` varchar(11) NOT NULL DEFAULT 'draft',
  `active` int(11) NOT NULL DEFAULT '1',
  `is_featured` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `seo_keywords` varchar(512) DEFAULT NULL,
  `seo_description` varchar(512) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `guid`, `user_guid`, `sku`, `name`, `slug`, `image`, `featured`, `description`, `price`, `tax`, `discount`, `quantity`, `is_special`, `special_price`, `special_start`, `special_end`, `type`, `status`, `active`, `is_featured`, `order`, `seo_keywords`, `seo_description`, `created`, `modified`)
VALUES
	(13,'520ecab000480',NULL,NULL,'New York Yankees','New-York-Yankees','','a:2:{s:6:\"origin\";a:1:{i:0;s:17:\"520ecbfc6225a.png\";}s:4:\"150w\";a:1:{i:0;s:21:\"520ecbfc6225a_150.png\";}}','<p>New York Yankees</p>',34.99,0.00,0,65535,0,NULL,NULL,NULL,'product','draft',1,1,0,NULL,NULL,1376701104,1376722509),
	(14,'520ecc708b29f',NULL,NULL,'Army','Army','','a:2:{s:6:\"origin\";a:1:{i:0;s:17:\"520ecc5fba588.png\";}s:4:\"150w\";a:1:{i:0;s:21:\"520ecc5fba588_150.png\";}}','<p>Army</p>',34.99,0.00,0,65535,0,NULL,NULL,NULL,'product','draft',1,1,0,NULL,NULL,1376701552,1376722509),
	(17,'520ecce1b7ca5',NULL,NULL,'Ferrari','Ferrari','','a:2:{s:6:\"origin\";a:1:{i:0;s:17:\"520ecd1a4d51f.png\";}s:4:\"150w\";a:1:{i:0;s:21:\"520ecd1a4d51f_150.png\";}}','<p>Ferrari</p>',34.99,0.00,0,65535,0,NULL,NULL,NULL,'product','draft',1,1,0,NULL,NULL,1376701665,1376722509),
	(18,'520ecf9589731',NULL,NULL,'American Flag','American-Flag','','a:2:{s:6:\"origin\";a:1:{i:0;s:17:\"520ecf8662184.png\";}s:4:\"150w\";a:1:{i:0;s:21:\"520ecf8662184_150.png\";}}','<p>American Flag</p>',29.99,0.00,0,65535,0,NULL,NULL,NULL,'product','draft',1,1,0,NULL,NULL,1376702357,1376722509),
	(19,'520ecfe3575eb',NULL,NULL,'Utah Jazz','Utah-Jazz','','a:2:{s:6:\"origin\";a:1:{i:0;s:17:\"520ecfd962c18.png\";}s:4:\"150w\";a:1:{i:0;s:21:\"520ecfd962c18_150.png\";}}','<p>Utah Jazz</p>',29.99,0.00,0,65535,0,NULL,NULL,NULL,'product','draft',1,1,0,NULL,NULL,1376702435,1376722509),
	(20,'520ed0723c86d',NULL,NULL,'BYU','BYU','','a:2:{s:6:\"origin\";a:1:{i:0;s:17:\"520ed06880543.jpg\";}s:4:\"150w\";a:1:{i:0;s:21:\"520ed06880543_150.jpg\";}}','',29.99,0.00,0,65535,0,NULL,NULL,NULL,'product','draft',1,1,0,NULL,NULL,1376702578,1376722509),
	(21,'520ed0abdfc90',NULL,NULL,'case','case','','a:2:{s:6:\"origin\";a:1:{i:0;s:17:\"520ed09f2db21.png\";}s:4:\"150w\";a:1:{i:0;s:21:\"520ed09f2db21_150.png\";}}','<p>case</p>',29.99,0.00,0,65535,0,NULL,NULL,NULL,'product','draft',1,1,0,NULL,NULL,1376702635,1376722509),
	(22,'520ed10438b0a',NULL,NULL,'key chain test','key-chain-test','','a:2:{s:6:\"origin\";a:1:{i:0;s:17:\"520ed101069be.png\";}s:4:\"150w\";a:1:{i:0;s:21:\"520ed101069be_150.png\";}}','<p>key chain test</p>',7.99,0.00,0,65535,0,NULL,NULL,NULL,'product','draft',1,1,0,NULL,NULL,1376702724,1376722509),
	(49,'5214168078724',NULL,NULL,'teste','teste','','','<p>teste</p>',0.25,0.00,0,65535,0,NULL,NULL,NULL,'product','draft',1,0,0,NULL,NULL,1377048192,1377048192),
	(50,'5215b5a677790',NULL,NULL,'iphone5',NULL,'a:2:{s:10:\"foreground\";s:14:\"iphone5_fg.png\";s:10:\"background\";s:14:\"iphone5_bg.png\";}',NULL,'iphone5 case',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,0,NULL,NULL,1377154470,1377154470),
	(51,'5215b5a67d5d7',NULL,NULL,'iphone4',NULL,'a:2:{s:10:\"foreground\";s:14:\"iphone4_fg.png\";s:10:\"background\";s:14:\"iphone4_bg.png\";}',NULL,'iphone4 case',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,1,NULL,NULL,1377154470,1377154470),
	(52,'5215b5a67db8c',NULL,NULL,'samsung galaxy 3',NULL,'a:2:{s:10:\"foreground\";s:26:\"samsung galaxy 3-outer.png\";s:10:\"background\";s:26:\"samsung galaxy 3-inner.png\";}',NULL,'iphone5 case',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,2,NULL,NULL,1377154470,1377154470),
	(53,'5215b5a67e09e',NULL,NULL,'samsung galaxy 4',NULL,'a:2:{s:10:\"foreground\";s:26:\"samsung galaxy 4-outer.png\";s:10:\"background\";s:26:\"samsung galaxy 4-inner.png\";}',NULL,'samsung galaxy 4',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,3,NULL,NULL,1377154470,1377154470),
	(54,'5215b5a67e54e',NULL,NULL,'Bottle 17oz',NULL,'a:2:{s:10:\"foreground\";s:23:\"bottle17oz_steel_fg.png\";s:10:\"background\";s:23:\"bottle17oz_steel_bg.png\";}',NULL,'Bottle 17oz Steel',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,5,NULL,NULL,1377154470,1377154470),
	(55,'5215b5a67ea21',NULL,NULL,'Mug',NULL,'a:2:{s:10:\"foreground\";s:26:\"Mug 11oz Ceramic-outer.png\";s:10:\"background\";s:26:\"Mug 11oz Ceramic-inner.png\";}',NULL,'Mug 11oz Ceramic',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,6,NULL,NULL,1377154470,1377154470);

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_bill_infos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_bill_infos`;

CREATE TABLE `user_bill_infos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `cc_number` varchar(128) DEFAULT NULL,
  `cc_expire` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_bill_infos` WRITE;
/*!40000 ALTER TABLE `user_bill_infos` DISABLE KEYS */;

INSERT INTO `user_bill_infos` (`id`, `guid`, `name`, `phone`, `address`, `cc_number`, `cc_expire`, `country`, `state`, `city`, `created`)
VALUES
	(1,'52176c1729b8b','dddd','dddd','dddd','ddd',NULL,'US','AZ','dddd',1377266711),
	(2,'52176c75e83fa','dddd','ddd','dddd','ddd',NULL,'US','AZ','ddddd',1377266805),
	(3,'52176e1740edb','ddddd','dddd','ddddd','dddd',NULL,'US','AL','dddd',1377267223),
	(4,'52176f9488c7a','ddddd','ddddd','dddd','ddddd',NULL,'US','AR','dddddd',1377267604);

/*!40000 ALTER TABLE `user_bill_infos` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_deliver_infos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_deliver_infos`;

CREATE TABLE `user_deliver_infos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(128) DEFAULT NULL,
  `user_guid` char(128) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `zipcode` varchar(32) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `state` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `user_deliver_infos` WRITE;
/*!40000 ALTER TABLE `user_deliver_infos` DISABLE KEYS */;

INSERT INTO `user_deliver_infos` (`id`, `guid`, `user_guid`, `email`, `firstname`, `lastname`, `address`, `phone`, `zipcode`, `country`, `state`, `city`, `created`, `modified`)
VALUES
	(1,'52176c171a17a','52174779805e7','dddddd@gmail.com','dddd','ddd','    dddd','dddd','ddd','US','AK','ddd',1377266711,1377266711),
	(2,'52176c75e39af','52174779805e7','dddddd@gmail.com','dddd','ddd','    dddd','dddd','ddd','US','AZ','ddd',1377266805,1377266805),
	(3,'52176e173cb61','52174779805e7','dddddd@gmail.com','dddd','ddd','    dddd','dddd','ddd','US','AK','ddd',1377267223,1377267223),
	(4,'52176f947f945','52174779805e7','dddddd@gmail.com','dddd','ddd','    dddd','dddd','ddd','US','AZ','ddd',1377267604,1377267604);

/*!40000 ALTER TABLE `user_deliver_infos` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(128) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(512) DEFAULT NULL,
  `type` varchar(32) NOT NULL DEFAULT 'guest',
  `email_verfied` int(11) NOT NULL DEFAULT '0',
  `verfied_code` varchar(128) DEFAULT NULL,
  `verfied_expire` int(11) DEFAULT NULL,
  `subscribe` int(11) NOT NULL DEFAULT '0',
  `subscribe_content` text,
  `subscribe_schedule` varchar(32) NOT NULL DEFAULT 'daily',
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `email2` varchar(512) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `country` varchar(32) DEFAULT NULL,
  `state` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `zipcode` varchar(32) DEFAULT NULL,
  `orders` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `guid`, `name`, `email`, `password`, `type`, `email_verfied`, `verfied_code`, `verfied_expire`, `subscribe`, `subscribe_content`, `subscribe_schedule`, `firstname`, `lastname`, `email2`, `phone`, `country`, `state`, `city`, `address`, `zipcode`, `orders`, `active`, `created`, `modified`)
VALUES
	(1,'52174779805e7','kkkkkk','kkkkkk@gmail.com','3c9bf1830df9a92b94110d619948889851c95c69','registered',0,NULL,NULL,0,NULL,'daily','dddd','ddd','dddddd@gmail.com','dddd','US','','ddd','    dddd','ddd',2,0,1377257337,1377267604);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
