# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: card
# Generation Time: 2013-09-27 20:06:28 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table pwd_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pwd_categories`;

CREATE TABLE `pwd_categories` (
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



# Dump of table pwd_industries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pwd_industries`;

CREATE TABLE `pwd_industries` (
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



# Dump of table pwd_templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pwd_templates`;

CREATE TABLE `pwd_templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(128) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_email` varchar(256) DEFAULT NULL,
  `user_ip` varchar(256) DEFAULT NULL,
  `cart_id` varchar(256) DEFAULT NULL,
  `category_guid` char(128) DEFAULT NULL,
  `industry_guid` char(128) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `description` text,
  `type` varchar(32) NOT NULL DEFAULT 'admin',
  `status` varchar(32) NOT NULL DEFAULT 'draft',
  `content_json` longtext,
  `content_svg` longtext,
  `thumbnails` text,
  `featured` text,
  `width` int(11) NOT NULL DEFAULT '0',
  `height` int(11) NOT NULL DEFAULT '0',
  `output` text,
  `is_featured` int(11) NOT NULL DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
