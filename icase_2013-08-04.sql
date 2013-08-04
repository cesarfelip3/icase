# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: icase
# Generation Time: 2013-08-04 12:05:08 +0000
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
  `seo_meta` varchar(1024) DEFAULT NULL,
  `seo_description` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `guid`, `parent_guid`, `group_guid`, `name`, `slug`, `description`, `level`, `children`, `order`, `seo_keywords`, `seo_meta`, `seo_description`)
VALUES
	(1,'51fa32042e486','','51fa32042e411','iphone','iphone','',0,2,0,NULL,NULL,NULL),
	(2,'51fa32098b08e','51fa32042e486','51fa32042e411','iphone4','iphone4','',1,0,0,NULL,NULL,NULL),
	(3,'51fa320c55f4a','51fa32042e486','51fa32042e411','iphone5','iphone5','',1,0,0,NULL,NULL,NULL);

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
	('51fa32042e486','51fe31b864bca'),
	('51fa32042e486','51fe366bece28'),
	('51fa32042e486','51fe36aca22de'),
	('51fa32042e486','51fe36e8f1346'),
	('51fa32042e486','51fe3763c5f73');

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
  `seo_meta` varchar(512) DEFAULT NULL,
  `seo_description` varchar(512) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
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
