# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: membership
# Generation Time: 2013-08-11 08:56:06 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table administrators
# ------------------------------------------------------------

DROP TABLE IF EXISTS `administrators`;

CREATE TABLE `administrators` (
  `admin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_guid` char(13) DEFAULT NULL,
  `admin_role` varchar(32) DEFAULT NULL,
  `admin_name` varchar(32) DEFAULT NULL,
  `admin_email` varchar(128) DEFAULT NULL,
  `admin_password` varchar(128) DEFAULT NULL,
  `admin_active` int(11) DEFAULT '1',
  `admin_verfied` int(11) DEFAULT '0',
  `admin_verificationcode` varchar(128) DEFAULT NULL,
  `admin_verificationexpire` int(11) DEFAULT NULL,
  `admin_question` varchar(64) DEFAULT NULL,
  `admin_answer` varchar(32) DEFAULT NULL,
  `admin_nickname` varchar(32) DEFAULT NULL,
  `admin_firstname` varchar(16) DEFAULT NULL,
  `admin_lastname` varchar(16) DEFAULT NULL,
  `admin_gender` varchar(16) DEFAULT NULL,
  `admin_age` int(11) DEFAULT NULL,
  `admin_birthyear` int(11) DEFAULT NULL,
  `admin_birthmonth` int(11) DEFAULT NULL,
  `admin_birthday` int(11) DEFAULT NULL,
  `admin_phone` varchar(32) DEFAULT NULL,
  `admin_country` varchar(32) DEFAULT NULL,
  `admin_state` varchar(32) DEFAULT NULL,
  `admin_city` varchar(32) DEFAULT NULL,
  `admin_address` varchar(128) DEFAULT NULL,
  `admin_lastip` char(128) DEFAULT NULL,
  `admin_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `administrators` WRITE;
/*!40000 ALTER TABLE `administrators` DISABLE KEYS */;

INSERT INTO `administrators` (`admin_id`, `admin_guid`, `admin_role`, `admin_name`, `admin_email`, `admin_password`, `admin_active`, `admin_verfied`, `admin_verificationcode`, `admin_verificationexpire`, `admin_question`, `admin_answer`, `admin_nickname`, `admin_firstname`, `admin_lastname`, `admin_gender`, `admin_age`, `admin_birthyear`, `admin_birthmonth`, `admin_birthday`, `admin_phone`, `admin_country`, `admin_state`, `admin_city`, `admin_address`, `admin_lastip`, `admin_created`)
VALUES
	(365,'51af73c642684','财务管理','tomc','tomc@gmail.com','kkkkkk',1,0,NULL,NULL,NULL,NULL,'tomc johnc','johnc','tomc','男',25,1988,1,1,'11111111111',NULL,NULL,NULL,NULL,NULL,1370452934),
	(366,'51af740bcf2a1','财务管理','tomd','tomd@gmail.com','kkkkkk',1,0,NULL,NULL,NULL,NULL,'tomd tomd','tomd','tomd','男',14,1999,1,1,'11111111111',NULL,NULL,NULL,NULL,NULL,1370453003),
	(369,'51b0e24d07d73','财务管理','tom','tom@gmail.com','$2a$10$5zzREasJ64keXzsYrpgfuutJFpgpFxh/Cga8MMXVibvrFjuIcCnru',1,0,NULL,NULL,NULL,NULL,'tom hanks','hanks','tom','男',25,1988,1,1,'88888888888',NULL,NULL,NULL,NULL,NULL,1370546765),
	(371,'51b2c8f064b33','人力资源管理','abc','abc@gmail.com','$2a$10$LMB99DdTTOl0Yixh82nFE.gwQCmgpBq4KZOu.VvZug9TMZyBr9cJK',1,0,NULL,NULL,NULL,NULL,'abc abc','abc','abc','男',113,1900,1,1,'11111111111',NULL,NULL,NULL,NULL,NULL,1370671344);

/*!40000 ALTER TABLE `administrators` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `location_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_guid` char(13) DEFAULT NULL,
  `location_parent` char(13) DEFAULT NULL,
  `location_level` int(11) DEFAULT NULL,
  `location_name` varchar(32) DEFAULT NULL,
  `location_description` varchar(128) DEFAULT NULL,
  `location_reference` varchar(512) DEFAULT NULL,
  `location_longtitude` decimal(10,2) DEFAULT NULL,
  `location_latitude` decimal(10,2) DEFAULT NULL,
  `location_timezone` int(11) DEFAULT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table group_to_object
# ------------------------------------------------------------

DROP TABLE IF EXISTS `group_to_object`;

CREATE TABLE `group_to_object` (
  `grp_guid` char(13) DEFAULT NULL,
  `object_guid` char(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `grp_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `grp_guid` char(13) DEFAULT NULL,
  `grp_parent` char(13) DEFAULT NULL,
  `grp_family` char(13) DEFAULT NULL,
  `grp_name` varchar(256) DEFAULT NULL,
  `grp_slug` varchar(512) DEFAULT NULL,
  `grp_seokeywords` varchar(512) DEFAULT NULL,
  `grp_seodesc` varchar(512) DEFAULT NULL,
  `grp_type` varchar(32) DEFAULT NULL,
  `grp_level` int(11) NOT NULL DEFAULT '0',
  `grp_order` int(11) NOT NULL DEFAULT '0',
  `grp_children` int(11) NOT NULL DEFAULT '0',
  `grp_created` int(11) DEFAULT NULL,
  `grp_modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`grp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`grp_id`, `grp_guid`, `grp_parent`, `grp_family`, `grp_name`, `grp_slug`, `grp_seokeywords`, `grp_seodesc`, `grp_type`, `grp_level`, `grp_order`, `grp_children`, `grp_created`, `grp_modified`)
VALUES
	(1,'5207503dd1bec','','5207503dd1a8c','hello','hello-5207503dd1bec',NULL,NULL,NULL,0,0,0,1376211005,NULL);

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table usermetas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usermetas`;

CREATE TABLE `usermetas` (
  `usermeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usermeta_guid` char(13) DEFAULT NULL,
  `user_guid` char(13) DEFAULT NULL,
  `usermeta_address` varchar(256) DEFAULT NULL,
  `usermeta_phone` varchar(256) DEFAULT '',
  `usermeta_im` varchar(256) DEFAULT NULL,
  `usermeta_icon` varchar(512) DEFAULT NULL,
  `usermeta_description` varchar(1024) DEFAULT NULL,
  `usermeta_signature` varchar(512) DEFAULT NULL,
  `usermeta_mood` varchar(32) DEFAULT NULL,
  `usermeta_status` varchar(128) DEFAULT NULL,
  `usermeta_type` varchar(32) DEFAULT NULL,
  `usermeta_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`usermeta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_guid` char(13) DEFAULT NULL,
  `user_role` varchar(32) DEFAULT NULL,
  `user_name` varchar(32) DEFAULT NULL,
  `user_email` varchar(128) DEFAULT NULL,
  `user_password` varchar(128) DEFAULT NULL,
  `user_active` int(11) DEFAULT '1',
  `user_verfied` int(11) DEFAULT '0',
  `user_verificationcode` varchar(128) DEFAULT NULL,
  `user_verificationexpire` int(11) DEFAULT NULL,
  `user_question` varchar(64) DEFAULT NULL,
  `user_answer` varchar(32) DEFAULT NULL,
  `user_nickname` varchar(32) DEFAULT NULL,
  `user_firstname` varchar(16) DEFAULT NULL,
  `user_lastname` varchar(16) DEFAULT NULL,
  `user_gender` varchar(16) DEFAULT NULL,
  `user_age` int(11) DEFAULT NULL,
  `user_birthyear` int(11) DEFAULT NULL,
  `user_birthmonth` int(11) DEFAULT NULL,
  `user_birthday` int(11) DEFAULT NULL,
  `user_phone` varchar(32) DEFAULT NULL,
  `user_country` varchar(32) DEFAULT NULL,
  `user_state` varchar(32) DEFAULT NULL,
  `user_city` varchar(32) DEFAULT NULL,
  `user_address` varchar(128) DEFAULT NULL,
  `user_lastip` char(128) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `user_guid`, `user_role`, `user_name`, `user_email`, `user_password`, `user_active`, `user_verfied`, `user_verificationcode`, `user_verificationexpire`, `user_question`, `user_answer`, `user_nickname`, `user_firstname`, `user_lastname`, `user_gender`, `user_age`, `user_birthyear`, `user_birthmonth`, `user_birthday`, `user_phone`, `user_country`, `user_state`, `user_city`, `user_address`, `user_lastip`, `user_created`)
VALUES
	(365,'51af73c642684','编辑','tomc','tomc@gmail.com','kkkkkk',1,0,NULL,NULL,NULL,NULL,'tomc johnc','johnc','tomc','男',25,1988,1,1,'11111111111',NULL,NULL,NULL,NULL,NULL,1370452934),
	(366,'51af740bcf2a1','编辑','tomd','tomd@gmail.com','kkkkkk',1,0,NULL,NULL,NULL,NULL,'tomd tomd','tomd','tomd','男',14,1999,1,1,'11111111111',NULL,NULL,NULL,NULL,NULL,1370453003),
	(369,'51b0e24d07d73','总编辑','tom','tom@gmail.com','$2a$10$5zzREasJ64keXzsYrpgfuutJFpgpFxh/Cga8MMXVibvrFjuIcCnru',1,0,NULL,NULL,NULL,NULL,'tom hanks','hanks','tom','男',25,1988,1,1,'88888888888',NULL,NULL,NULL,NULL,NULL,1370546765),
	(370,'51b2212441efd','总编辑','bbadf','kkk@gmail.com','$2a$10$OPZvKT1I9ibAGgfyFxnOj.jsTns9cX5skfswfCvhI3NgExeTFRydG',0,0,NULL,NULL,NULL,NULL,'ab cd','cd','ab','男',13,2000,1,1,'00000000000',NULL,NULL,NULL,NULL,NULL,1370628388),
	(371,'51b2c4fbe1a12','总编辑','hello','hello@gmail.com','$2a$10$qilEm0UGyplBrgkap9pnauvEYBUs8oKip7qD7fWl4SwX96qQXeFZa',1,0,NULL,NULL,NULL,NULL,'hello hello','hello','hello','男',13,2000,1,1,'11111111111',NULL,NULL,NULL,NULL,NULL,1370670332),
	(372,'51b2c5473ab61','总编辑','hello23','hello2@gmail.com','$2a$10$T0n4TkOvftWVVylIpPVqjucZI4XNHzSyCIVohflKaPqCRdjotu6k2',1,0,NULL,NULL,NULL,NULL,'hello2 hello2','hello2','hello2','男',12,2001,1,1,'11111111111',NULL,NULL,NULL,NULL,NULL,1370670407);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
