# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: icase
# Generation Time: 2013-08-16 08:02:06 +0000
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
  `subscribe_content` text,
  `subscribe_schedule` varchar(32) NOT NULL DEFAULT 'daily',
  `active` int(11) NOT NULL DEFAULT '1',
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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
	('5209154a2178a','5209156bda4d1');

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
  `type` varchar(128) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `options`;

CREATE TABLE `options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `value` text,
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
  `deliver_guid` char(13) DEFAULT NULL,
  `bill_guid` char(13) DEFAULT NULL,
  `title` text,
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
  `seo_keywords` varchar(512) DEFAULT NULL,
  `seo_description` varchar(512) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `guid`, `user_guid`, `sku`, `name`, `slug`, `image`, `featured`, `description`, `price`, `tax`, `discount`, `quantity`, `is_special`, `special_price`, `special_start`, `special_end`, `type`, `status`, `active`, `is_featured`, `seo_keywords`, `seo_description`, `created`, `modified`)
VALUES
	(10,'520cbb87b2a25',NULL,NULL,'iphone5',NULL,'a:2:{s:10:\"foreground\";s:14:\"iphone5_fg.png\";s:10:\"background\";s:14:\"iphone5_bg.png\";}',NULL,'iphone5 case',34.99,0.00,0,65535,0,NULL,NULL,NULL,'template','published',1,0,NULL,NULL,1376566151,1376566151),
	(11,'520dcf9136374',NULL,NULL,'abcd','abcd','','a:1:{i:0;s:17:\"520dcf8caa3cf.png\";}','<p>abcd</p>',33.00,0.00,0,65535,0,NULL,NULL,NULL,'product','published',1,0,NULL,NULL,1376636817,1376636817);

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



# Dump of table user_bill_infos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_bill_infos`;

CREATE TABLE `user_bill_infos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
  `user_guid` char(13) DEFAULT NULL,
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
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(13) DEFAULT NULL,
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
  `address` varchar(1024) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `country` varchar(32) DEFAULT NULL,
  `state` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `orders` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
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
