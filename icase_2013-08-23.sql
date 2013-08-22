# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: icase
# Generation Time: 2013-08-22 18:52:22 +0000
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
  `password` varchar(128) DEFAULT NULL,
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
	(1,'521324cdcae5d','beautahful007','admin@beautahfulcreations.com','3c9bf1830df9a92b94110d619948889851c95c69','register',0,NULL,NULL,0,NULL,'daily',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,1376986317,1376986317),
	(2,'521324e5a5676','kkkkkk','kkkkkk@gmail.com','beb00a69280583a9b67a6b9cc95cadcf3be11fa8','register',0,NULL,NULL,0,NULL,'daily',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,1376986341,1376986435);

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
	(1,'5212eda360719','','5212eda3606f7','iphone','iphone',NULL,0,2,0,'iphone','iphone'),
	(2,'5212f1cbee7b0','5212eda360719','5212eda3606f7','iphone4','iphone4',NULL,1,0,0,'iphone4','iphone4'),
	(3,'5212f51f7d3c3','5212eda360719','5212eda3606f7','iphone5','iphone5',NULL,1,0,0,'iphone5','iphone5');

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
	('5212eda360719','5212dc0edd949'),
	('5212f1cbee7b0','5212dc0edd949'),
	('5212f51f7d3c3','5212dc0edd949');

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
	(13,'5212dc0edd949',NULL,NULL,'test','test','','a:2:{s:6:\"origin\";a:4:{i:0;s:17:\"5212dc09f0c06.png\";i:1;s:17:\"5212dc0a89197.png\";i:2;s:17:\"5212dc0adb5a8.png\";i:3;s:17:\"5212dc0b31b75.png\";}s:4:\"150w\";a:4:{i:0;s:21:\"5212dc09f0c06_150.png\";i:1;s:21:\"5212dc0a89197_150.png\";i:2;s:21:\"5212dc0adb5a8_150.png\";i:3;s:21:\"5212dc0b31b75_150.png\";}}','<p>test</p>',22.00,0.00,0,65535,0,NULL,NULL,NULL,'product','published',1,1,0,NULL,NULL,1376967694,1376974191),
	(45,'5215b099dcac6',NULL,NULL,'iphone5','iphone5','a:2:{s:10:\"foreground\";s:14:\"iphone5_fg.png\";s:10:\"background\";s:14:\"iphone5_bg.png\";}','','<p>iphone5 case</p>',14.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,0,NULL,NULL,1377153177,1377157192),
	(46,'5215b099e92c7',NULL,NULL,'iphone4',NULL,'a:2:{s:10:\"foreground\";s:14:\"iphone4_fg.png\";s:10:\"background\";s:14:\"iphone4_bg.png\";}',NULL,'iphone4 case',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,1,NULL,NULL,1377153177,1377153177),
	(47,'5215b099eaca1',NULL,NULL,'samsung galaxy 3',NULL,'a:2:{s:10:\"foreground\";s:26:\"samsung galaxy 3-outer.png\";s:10:\"background\";s:26:\"samsung galaxy 3-inner.png\";}',NULL,'iphone5 case',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,2,NULL,NULL,1377153177,1377153177),
	(48,'5215b099ec2a6',NULL,NULL,'samsung galaxy 4',NULL,'a:2:{s:10:\"foreground\";s:26:\"samsung galaxy 4-outer.png\";s:10:\"background\";s:26:\"samsung galaxy 4-inner.png\";}',NULL,'samsung galaxy 4',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,3,NULL,NULL,1377153177,1377153177),
	(49,'5215b09a06b0c',NULL,NULL,'Bottle 17oz',NULL,'a:2:{s:10:\"foreground\";s:23:\"bottle17oz_steel_fg.png\";s:10:\"background\";s:23:\"bottle17oz_steel_bg.png\";}',NULL,'Bottle 17oz Steel',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,5,NULL,NULL,1377153178,1377153178),
	(50,'5215b09a0963a',NULL,NULL,'Mug',NULL,'a:2:{s:10:\"foreground\";s:26:\"Mug 11oz Ceramic-outer.png\";s:10:\"background\";s:26:\"Mug 11oz Ceramic-inner.png\";}',NULL,'Mug 11oz Ceramic',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,6,NULL,NULL,1377153178,1377153178);

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



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(128) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
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

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `guid`, `name`, `email`, `password`, `type`, `email_verfied`, `verfied_code`, `verfied_expire`, `subscribe`, `subscribe_content`, `subscribe_schedule`, `firstname`, `lastname`, `phone`, `country`, `state`, `city`, `address`, `zipcode`, `orders`, `active`, `created`, `modified`)
VALUES
	(2,'5213153457aad','kkkkkk','kkkkkk@gmail.com','','register',0,NULL,NULL,0,NULL,'daily','dddddd','dddddd','dddddd','US','dddddd','dddddd',' dddddd','dddddd',0,1,1376982324,1376982342);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
