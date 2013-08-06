# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: icase
# Generation Time: 2013-08-06 12:28:56 +0000
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
	(1,'51ff653f910a5','','51ff653f9108e','iphone','iphone',NULL,0,3,0,'iphone','iphone'),
	(2,'51ff654998b94','51ff653f910a5','51ff653f9108e','iphone4','iphone4',NULL,1,0,0,'iphone4','iphone4'),
	(3,'51ff6550aa711','51ff653f910a5','51ff653f9108e','iphone4S','iphone4S',NULL,1,0,0,'iphone4S','iphone4S'),
	(4,'51ff6558d1dda','51ff653f910a5','51ff653f9108e','iphone5','iphone5',NULL,1,1,0,'iphone5','iphone5'),
	(5,'51ff657ed9e5d','','51ff657ed9e46','ipod touch','ipod touch',NULL,0,0,0,'ipod touch','ipod touch'),
	(7,'51ff77c84b846','51ff6558d1dda','51ff653f9108e','ipad 3','ipad-3',NULL,2,1,0,'ipad 3','ipad 3'),
	(8,'51ffe40fe461f','51ff77c84b846','51ff653f9108e','ipad4','ipad-4',NULL,3,0,0,'ipad 4','ipad 4');

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
	('51ff654998b94','51ffe43d49438'),
	('51ff6558d1dda','51ffe43d49438'),
	('51ff77c84b846','51ffe43d49438'),
	('51ffe40fe461f','51ffe43d49438'),
	('51ff654998b94','51ffe44d555f1'),
	('51ff6558d1dda','51ffe44d555f1'),
	('51ff77c84b846','51ffe44d555f1'),
	('51ffe40fe461f','51ffe44d555f1'),
	('51ff654998b94','51ffe44e68d03'),
	('51ff6558d1dda','51ffe44e68d03'),
	('51ff77c84b846','51ffe44e68d03'),
	('51ffe40fe461f','51ffe44e68d03'),
	('51ff654998b94','51ffe44f0b09b'),
	('51ff6558d1dda','51ffe44f0b09b'),
	('51ff77c84b846','51ffe44f0b09b'),
	('51ffe40fe461f','51ffe44f0b09b'),
	('51ff654998b94','51ffe44f7f8b6'),
	('51ff6558d1dda','51ffe44f7f8b6'),
	('51ff77c84b846','51ffe44f7f8b6'),
	('51ffe40fe461f','51ffe44f7f8b6');

/*!40000 ALTER TABLE `category_to_object` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table enquiries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `enquiries`;

CREATE TABLE `enquiries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_guid` char(13) DEFAULT NULL,
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
  `title` text,
  `description` varchar(1024) DEFAULT NULL,
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

INSERT INTO `orders` (`id`, `guid`, `product_guid`, `buyer_guid`, `seller_guid`, `deliver_guid`, `title`, `description`, `status`, `amount`, `quantity`, `tax`, `express_fee`, `payment`, `express`, `file`, `created`, `modified`)
VALUES
	(1,'51ff6a86b23d5','51ff6916e72f0',NULL,'0','51ff6a86c7837','iphone4-template',NULL,'paid',225.61,7,NULL,NULL,NULL,NULL,'51ff6a7e53366.jpeg',1375693446,1375701059),
	(2,'51ff6a9ee71c9','51ff6916e72f0',NULL,'0','51ff6a9eea6a0','iphone4-template',NULL,'paid',225.61,7,NULL,NULL,NULL,NULL,'51ff6a7e53366.jpeg',1375693470,1375693470),
	(3,'51ff6ada8d07c','51ff6916e72f0',NULL,'0','51ff6ada9332b','iphone4-template',NULL,'paid',225.61,7,NULL,NULL,NULL,NULL,'51ff6a7e53366.jpeg',1375693530,1375693530),
	(4,'51ff6b6bc57e6','51ff6916e72f0',NULL,'0','51ff6b6bc8e2a','iphone4-template',NULL,'paid',225.61,7,NULL,NULL,NULL,NULL,'51ff6a7e53366.jpeg',1375693675,1375693675),
	(5,'51ff6b9b672c6','51ff6916e72f0',NULL,'0','51ff6b9b6df58','iphone4-template',NULL,'paid',128.92,4,NULL,NULL,NULL,NULL,'51ff6b8d95ff9.jpeg',1375693723,1375693723),
	(6,'51ff6b9b67308','51ff6916e72f0',NULL,'0','51ff6b9b6df58','iphone4-template',NULL,'paid',32.23,1,NULL,NULL,NULL,NULL,'51ff6b9666acd.jpeg',1375693723,1375693723);

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
  `slug` varchar(1024) DEFAULT NULL,
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
  `seo_description` varchar(512) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `guid`, `user_guid`, `name`, `slug`, `image`, `featured`, `description`, `price`, `tax`, `discount`, `quantity`, `is_special`, `special_price`, `special_start`, `special_end`, `type`, `status`, `active`, `seo_keywords`, `seo_description`, `created`, `modified`)
VALUES
	(1,'51ffe43d49438',NULL,'hello world','hello-world-51ffe43d48f9d','','a:2:{i:0;s:17:\"51ffe438c0619.jpg\";i:1;s:17:\"51ffe4393cf14.jpg\";}','',23.23,0.00,0.00,65535,0,NULL,NULL,NULL,'product','published',1,NULL,NULL,1375724605,1375724605),
	(2,'51ffe44d555f1',NULL,'hello world','hello-world-51ffe44d555d3','','a:2:{i:0;s:17:\"51ffe438c0619.jpg\";i:1;s:17:\"51ffe4393cf14.jpg\";}','',23.23,0.00,0.00,65535,0,NULL,NULL,NULL,'product','published',1,NULL,NULL,1375724621,1375724621),
	(3,'51ffe44e68d03',NULL,'hello world','hello-world-51ffe44e68ce4','','a:2:{i:0;s:17:\"51ffe438c0619.jpg\";i:1;s:17:\"51ffe4393cf14.jpg\";}','',23.23,0.00,0.00,65535,0,NULL,NULL,NULL,'product','published',1,NULL,NULL,1375724622,1375724622),
	(4,'51ffe44f0b09b',NULL,'hello world','hello-world-51ffe44f0b07a','','a:2:{i:0;s:17:\"51ffe438c0619.jpg\";i:1;s:17:\"51ffe4393cf14.jpg\";}','',23.23,0.00,0.00,65535,0,NULL,NULL,NULL,'product','published',1,NULL,NULL,1375724623,1375724623),
	(5,'51ffe44f7f8b6',NULL,'hello world','hello-world-51ffe44f7f896','','a:2:{i:0;s:17:\"51ffe438c0619.jpg\";i:1;s:17:\"51ffe4393cf14.jpg\";}','',23.23,0.00,0.00,65535,0,NULL,NULL,NULL,'product','published',1,NULL,NULL,1375724623,1375724623);

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `templates`;

CREATE TABLE `templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `attributes` text,
  `content` text,
  `type` varchar(32) NOT NULL DEFAULT 'email',
  `usage` varchar(64) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_deliver_infos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_deliver_infos`;

CREATE TABLE `user_deliver_infos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `user_guid` char(13) DEFAULT NULL,
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

INSERT INTO `user_deliver_infos` (`id`, `guid`, `user_guid`, `firstname`, `lastname`, `address`, `phone`, `zipcode`, `country`, `state`, `city`, `created`, `modified`)
VALUES
	(1,'51ff6a86c7837',NULL,'','','','','','US','Utah','Salt Lake City',1375693446,1375693446),
	(2,'51ff6a9eea6a0',NULL,'addafadf','adfasdf','adfasdf','asdfasdf','adsfasdf','US','Utah','Salt Lake City',1375693470,1375693470),
	(3,'51ff6ada9332b',NULL,'','','','','','US','Utah','Salt Lake City',1375693530,1375693530),
	(4,'51ff6af485cb7',NULL,'','','','','','US','Utah','Salt Lake City',1375693556,1375693556),
	(5,'51ff6b6bc8e2a',NULL,'','','','','','US','Utah','Salt Lake City',1375693675,1375693675),
	(6,'51ff6b9b6df58',NULL,'','','','','','US','Utah','Salt Lake City',1375693723,1375693723);

/*!40000 ALTER TABLE `user_deliver_infos` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `email_verfied` int(11) NOT NULL DEFAULT '0',
  `verfied_code` varchar(128) DEFAULT NULL,
  `verfied_expire` int(11) DEFAULT NULL,
  `type` varchar(32) NOT NULL DEFAULT 'guest',
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `country` varchar(32) DEFAULT NULL,
  `state` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `orders` int(11) NOT NULL DEFAULT '0',
  `subscribe` int(11) NOT NULL DEFAULT '0',
  `subscription` text,
  `active` int(11) NOT NULL DEFAULT '1',
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `guid`, `name`, `email`, `password`, `email_verfied`, `verfied_code`, `verfied_expire`, `type`, `firstname`, `lastname`, `address`, `phone`, `country`, `state`, `city`, `orders`, `subscribe`, `subscription`, `active`, `created`, `modified`)
VALUES
	(1,'51fff4ecaeb8d','hello','hello@gmail.com','cad9747bad0af7fade2ff3fd841f48d566f5ef4e',0,NULL,NULL,'registered',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,1,1375728876,1375728876);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
