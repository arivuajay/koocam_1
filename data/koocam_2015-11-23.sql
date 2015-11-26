/*
SQLyog Ultimate v8.55 
MySQL - 5.6.14 : Database - koocam
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`koocam` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `koocam`;

/*Table structure for table `koo_admin` */

DROP TABLE IF EXISTS `koo_admin`;

CREATE TABLE `koo_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `koo_admin` */

insert  into `koo_admin`(`admin_id`,`username`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`) values (1,'admin','be2ce3b45176df1d3e41e35d6aa0ea9a44b56b3575e15ebc6da0d3da7793489b9eb718dc2cfe7f5f2bc61151ad4ffc70ba4d234520ed51735fa98ec878ddc27b',NULL,'admin@koocam.com','1','2015-11-13 11:06:21','0000-00-00 00:00:00');

/*Table structure for table `koo_gig` */

DROP TABLE IF EXISTS `koo_gig`;

CREATE TABLE `koo_gig` (
  `gig_id` int(11) NOT NULL AUTO_INCREMENT,
  `tutor_id` int(11) NOT NULL COMMENT 'User Id',
  `gig_title` varchar(100) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `gig_media` varchar(500) DEFAULT NULL,
  `gig_tag` varchar(255) DEFAULT NULL,
  `gig_description` text,
  `gig_duration` time DEFAULT NULL,
  `gig_price` decimal(10,2) DEFAULT NULL,
  `gig_avail_visual` enum('Y','N') DEFAULT 'N',
  `status` enum('0','1','2') DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`gig_id`),
  KEY `FK_koo_gig_category` (`cat_id`),
  KEY `FK_koo_gig_user` (`tutor_id`),
  CONSTRAINT `FK_koo_gig_category` FOREIGN KEY (`cat_id`) REFERENCES `koo_gig_category` (`cat_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_koo_gig_user` FOREIGN KEY (`tutor_id`) REFERENCES `koo_user` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `koo_gig` */

insert  into `koo_gig`(`gig_id`,`tutor_id`,`gig_title`,`cat_id`,`gig_media`,`gig_tag`,`gig_description`,`gig_duration`,`gig_price`,`gig_avail_visual`,`status`,`created_at`,`modified_at`,`created_by`,`modified_by`) values (1,7,'Course 1',2,'/gig/8a42813c666d58cb28698742e9b10b9a.jpg','course','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet dictum turpis, eu dictum enim fermentum lacinia. Nullam pulvinar vel eros nec finibus. Mauris eget magna eget justo vestibulum condimentum ut in felis. Praesent tincidunt fringilla quam, et euismod tortor ornare at. Etiam blandit sed nisi sit amet condimentum. Vivamus vestibulum eros ut orci molestie congue. Ut sodales lobortis maximus. In sit amet justo placerat, elementum orci ut, feugiat ','00:30:00','100.00','N','1','2015-11-21 11:38:13','0000-00-00 00:00:00',NULL,NULL),(2,7,'Test title',2,'/gig/e8025a81a9a242df858c4f664bc8710b.jpg','asdasd','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet dictum turpis, eu dictum enim fermentum lacinia. Nullam pulvinar vel eros nec finibus. Mauris eget magna eget justo vestibulum condimentum ut in felis. Praesent tincidunt fringilla quam, et euismod tortor ornare at. Etiam blandit sed nisi sit amet condimentum. Vivamus vestibulum eros ut orci molestie congue. Ut sodales lobortis maximus. In sit amet justo placerat, elementum orci ut, feugiat ','00:15:00','100.00','N','1','2015-11-21 12:59:25','0000-00-00 00:00:00',NULL,NULL),(3,7,'Course 12',3,'/gig/74656fc6d5f2c03b77611be542680d2f.jpg','English','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet dictum turpis, eu dictum enim fermentum lacinia. Nullam pulvinar vel eros nec finibus. Mauris eget magna eget justo vestibulum condimentum ut in felis. Praesent tincidunt fringilla quam, et euismod tortor ornare at. Etiam blandit sed nisi sit amet condimentum. Vivamus vestibulum eros ut orci molestie congue. Ut sodales lobortis maximus. In sit amet justo placerat, elementum orci ut, feugiat ','00:10:00','10.00','N','1','2015-11-21 13:03:48','0000-00-00 00:00:00',NULL,NULL),(4,7,'New',2,'/gig/74656fc6d5f2c03b77611be542680d2f.jpg','test tag','adasd','01:10:00','560.00','N','1','2015-11-21 15:50:16','0000-00-00 00:00:00',NULL,NULL);

/*Table structure for table `koo_gig_booking` */

DROP TABLE IF EXISTS `koo_gig_booking`;

CREATE TABLE `koo_gig_booking` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_guid` varchar(50) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `book_user_id` int(11) NOT NULL COMMENT 'User Id',
  `book_date` date NOT NULL,
  `book_start_time` time NOT NULL,
  `book_end_time` time NOT NULL,
  `book_is_extra` enum('Y','N') DEFAULT 'N',
  `book_gig_price` decimal(10,2) DEFAULT '0.00',
  `book_extra_price` decimal(10,2) DEFAULT '0.00',
  `book_total_price` decimal(10,2) DEFAULT '0.00',
  `book_approve` enum('0','1') DEFAULT '0',
  `book_approved_time` datetime DEFAULT NULL,
  `book_payment_status` char(1) DEFAULT 'P',
  `book_payment_info` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_At` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`book_id`),
  KEY `FK_koo_gig_booking_gig` (`gig_id`),
  KEY `FK_koo_gig_booking_user` (`book_user_id`),
  CONSTRAINT `FK_koo_gig_booking_user` FOREIGN KEY (`book_user_id`) REFERENCES `koo_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_koo_gig_booking_gig` FOREIGN KEY (`gig_id`) REFERENCES `koo_gig` (`gig_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `koo_gig_booking` */

/*Table structure for table `koo_gig_category` */

DROP TABLE IF EXISTS `koo_gig_category`;

CREATE TABLE `koo_gig_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) NOT NULL,
  `cat_description` text,
  `cat_image` varchar(500) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `koo_gig_category` */

insert  into `koo_gig_category`(`cat_id`,`cat_name`,`cat_description`,`cat_image`,`status`,`created_at`,`modified_at`,`created_by`,`modified_by`) values (1,'Learn English Speaking','Category Descc','/gigcategory/2c05c74ee923d2d171fcc9dd94fe57dd.jpg','1','2015-11-18 16:42:50','2015-11-23 11:04:57',NULL,NULL),(2,'Learn Violin','','/gigcategory/686d1c6a88b741429ace989a6b1aeb4f.jpg','1','2015-11-18 16:42:52','2015-11-23 11:05:14',NULL,NULL),(3,'Learn Writing French','','/gigcategory/f1d54ea92ce4f67ed38fe4198d6d4d38.jpg','1','2015-11-18 16:42:56','2015-11-23 11:05:29',NULL,NULL),(4,'Learn Spanish Speaking','','/gigcategory/70d3a7ea99f280c698ebf2ec2e034c22.jpg','1','2015-11-23 11:07:24','0000-00-00 00:00:00',NULL,NULL),(5,'Programming Languages','','/gigcategory/ec5d4a16b8fdfb787dd77d34639dd2ad.jpg','1','2015-11-23 11:07:51','0000-00-00 00:00:00',NULL,NULL),(6,'Film & Media','','/gigcategory/3066502356ce358e3f1c3bc575fe000e.jpg','1','2015-11-23 11:08:09','0000-00-00 00:00:00',NULL,NULL);

/*Table structure for table `koo_gig_comments` */

DROP TABLE IF EXISTS `koo_gig_comments`;

CREATE TABLE `koo_gig_comments` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `gig_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `com_comment` text NOT NULL,
  `com_rating` double DEFAULT '0',
  `status` enum('1','0','2') DEFAULT '0' COMMENT '0 -> In-Active, 1 -> Approved, 2 -> --',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`com_id`),
  KEY `FK_koo_gig_comments_users` (`user_id`),
  KEY `FK_koo_gig_comments_gig` (`gig_id`),
  CONSTRAINT `FK_koo_gig_comments_gig` FOREIGN KEY (`gig_id`) REFERENCES `koo_gig` (`gig_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_koo_gig_comments_users` FOREIGN KEY (`user_id`) REFERENCES `koo_user` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `koo_gig_comments` */

/*Table structure for table `koo_gig_extra` */

DROP TABLE IF EXISTS `koo_gig_extra`;

CREATE TABLE `koo_gig_extra` (
  `extra_id` int(11) NOT NULL AUTO_INCREMENT,
  `gig_id` int(11) NOT NULL,
  `extra_price` decimal(10,2) NOT NULL,
  `extra_description` text NOT NULL,
  `extra_file` varchar(500) DEFAULT NULL,
  `created_by` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`extra_id`),
  KEY `FK_koo_gig_extra_gig` (`gig_id`),
  CONSTRAINT `FK_koo_gig_extra_gig` FOREIGN KEY (`gig_id`) REFERENCES `koo_gig` (`gig_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `koo_gig_extra` */

/*Table structure for table `koo_gig_tokens` */

DROP TABLE IF EXISTS `koo_gig_tokens`;

CREATE TABLE `koo_gig_tokens` (
  `token_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL COMMENT 'Learner''s User id',
  `session_key` mediumtext,
  `token_key` mediumtext,
  `session_data` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `koo_gig_tokens` */

/*Table structure for table `koo_language` */

DROP TABLE IF EXISTS `koo_language`;

CREATE TABLE `koo_language` (
  `lang_Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID:',
  `lang_code` varchar(10) DEFAULT NULL,
  `lang_name` varchar(45) NOT NULL COMMENT 'Language:',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Status:',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`lang_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;

/*Data for the table `koo_language` */

insert  into `koo_language`(`lang_Id`,`lang_code`,`lang_name`,`status`,`created_at`,`modified_at`) values (1,'EN','English','1','2015-03-16 03:41:49','0000-00-00 00:00:00'),(5,'NE','Nepalese','1','2015-04-11 08:58:57','0000-00-00 00:00:00'),(9,'FR','French','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(11,'ES','Spanish','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(12,'DE','German','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(13,'RU','Russian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(14,'OA','(Afan) Oromo','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(15,'AB','Abkhasian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(16,'AA','Afar','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(17,'AF','Afrikaans','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(18,'SQ','Albanian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(19,'AM','Amharic','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(20,'AR','Arabic','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(21,'HY','Armenian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(22,'AS','Assamese','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(23,'AY','Aymara','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(24,'AZ','Azerbaijani','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(25,'BA','Bashkir','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(26,'EU','Basque','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(27,'BN','Bengali;Bangla','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(28,'DZ','Bhutani','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(29,'BH','Bihari','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(30,'BI','Bislama','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(31,'BR','Breton','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(32,'BG','Bulgarian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(33,'MY','Burmese','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(34,'BE','Byelorussian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(35,'KM','Cambodian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(36,'CA','Catalan','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(37,'ZH','Chinese','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(38,'CO','Corsican','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(39,'HR','Croatian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(40,'CS','Czech','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(41,'DA','Danish','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(42,'NL','Dutch','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(43,'EO','Esperanto','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(44,'ET','Estonian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(45,'FO','Faeroese','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(46,'FA','Farsi','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(47,'FJ','Fiji','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(48,'FI','Finnish','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(49,'FY','Frisian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(50,'GL','Galician','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(51,'KA','Georgian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(52,'EL','Greek','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(53,'KL','Greenlandic','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(54,'GN','Guarani','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(55,'GU','Gujarati','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(56,'HA','Hausa','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(57,'HW','Hawaii','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(58,'IW','Hebrew','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(59,'HI','Hindi','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(60,'HU','Hungarian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(61,'IS','Icelandic','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(62,'IN','Indonesian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(63,'IA','Interlingua','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(64,'IE','Interlingue','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(65,'IK','Inupiak','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(66,'GA','Irish','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(67,'IT','Italian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(68,'JA','Japanese','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(69,'JW','Javanese','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(70,'KN','Kannada','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(71,'KS','Kashmiri','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(72,'KK','Kazakh','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(73,'RW','Kinyarwanda','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(74,'KY','Kirghiz','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(75,'RN','Kirundi','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(76,'KO','Korean','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(77,'KU','Kurdish','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(78,'LO','Laothian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(79,'LA','Latin','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(80,'LV','Latvian;Lettish','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(81,'LN','Lingala','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(82,'LT','Lithuanian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(83,'MK','Macedonian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(84,'MG','Malagasy','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(85,'MS','Malay','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(86,'ML','Malayalam','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(87,'MT','Maltese','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(88,'MI','Maori','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(89,'MR','Marathi','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(90,'MO','Moldavian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(91,'MN','Mongolian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(92,'NA','Nauru','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(94,'NO','Norwegian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(95,'OC','Occitan','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(96,'OR','Oriya','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(97,'OM','Oromo','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(98,'PM','Papiamento','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(99,'PS','Pashto;Pushto','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(100,'FA','Persian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(101,'PL','Polish','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(102,'PT','Portuguese','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(103,'PA','Punjabi','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(104,'QU','Quechua','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(105,'RM','Rhaeto-Romance','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(106,'RO','Romanian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(107,'SM','Samoan','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(108,'SG','Sangro','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(109,'SA','Sanskrit','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(110,'GD','Scots Gaelic','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(111,'SR','Serbian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(112,'SH','Serbo-Croatian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(113,'ST','Sesotho','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(114,'TN','Setswana','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(115,'SN','Shona','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(116,'SD','Sindhi','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(117,'SI','Singhalese','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(118,'SS','Siswati','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(119,'SK','Slovak','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(120,'SL','Slovenian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(121,'SO','Somali','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(122,'SU','Sundanese','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(123,'SW','Swahili','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(124,'SV','Swedish','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(125,'TL','Tagalog','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(126,'TG','Tajik','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(127,'TA','Tamil','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(128,'TT','Tatar','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(129,'TE','Tegulu','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(130,'TH','Thai','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(131,'BO','Tibetan','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(132,'TI','Tigrinya','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(133,'TO','Tonga','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(134,'TS','Tsonga','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(135,'TR','Turkish','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(136,'TK','Turkmen','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(137,'TW','Twi','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(138,'UK','Ukrainian','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(139,'UR','Urdu','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(140,'UZ','Uzbek','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(141,'VI','Vietnamese','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(142,'VO','Volapuk','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(143,'CY','Welsh','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(144,'WO','Wolof','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(145,'XH','Xhosa','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(146,'JI','Yiddish','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(147,'YO','Yoruba','1','2015-05-31 14:06:06','0000-00-00 00:00:00'),(148,'ZU','Zulu','1','2015-05-31 14:06:06','0000-00-00 00:00:00');

/*Table structure for table `koo_user` */

DROP TABLE IF EXISTS `koo_user`;

CREATE TABLE `koo_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_activation_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_login_ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_last_login` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `live_status` enum('A','B','O') COLLATE utf8_unicode_ci DEFAULT 'O' COMMENT 'A -> Available, B -> Busy, O -> Offline',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `koo_user` */

insert  into `koo_user`(`user_id`,`username`,`password_hash`,`password_reset_token`,`email`,`user_activation_key`,`user_login_ip`,`user_last_login`,`status`,`live_status`,`created_at`,`modified_at`) values (1,'user_1','263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62',NULL,'user_1@gmail.com',NULL,NULL,'0000-00-00 00:00:00','1','O','2015-11-13 12:37:25','0000-00-00 00:00:00'),(2,'user_2','be2ce3b45176df1d3e41e35d6aa0ea9a44b56b3575e15ebc6da0d3da7793489b9eb718dc2cfe7f5f2bc61151ad4ffc70ba4d234520ed51735fa98ec878ddc27b',NULL,'user_2@gmail.com',NULL,NULL,'0000-00-00 00:00:00','1','O','2015-11-13 12:37:41','0000-00-00 00:00:00'),(3,'user_3','be2ce3b45176df1d3e41e35d6aa0ea9a44b56b3575e15ebc6da0d3da7793489b9eb718dc2cfe7f5f2bc61151ad4ffc70ba4d234520ed51735fa98ec878ddc27b',NULL,'user_3@gmail.com',NULL,NULL,'0000-00-00 00:00:00','1','O','2015-11-13 12:37:55','0000-00-00 00:00:00'),(7,'prakash','263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62',NULL,'prakash.paramanandam@arkinfotec.com','Q6fF2AykT','127.0.0.1','2015-11-17 14:10:26','1','O','2015-11-17 12:52:20','2015-11-17 18:40:26'),(8,'Nadesh','6a49849ff76c57c85f923ae1ebabe503125637818ebc4effd3559351b93efb03ccde000ca472ac3b9e11ce532bb6e9de71037e37ba64b337ae877c3139b71534',NULL,'nadesh@arkinfotec.com','rXOkCUMUk','127.0.0.1','0000-00-00 00:00:00','1','O','2015-11-17 14:01:54','2015-11-17 14:02:35');

/*Table structure for table `koo_user_profile` */

DROP TABLE IF EXISTS `koo_user_profile`;

CREATE TABLE `koo_user_profile` (
  `prof_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `prof_firstname` varchar(50) NOT NULL,
  `prof_lastname` varchar(50) DEFAULT NULL,
  `prof_tag` varchar(100) DEFAULT NULL,
  `prof_address` text,
  `prof_phone` varchar(30) DEFAULT NULL,
  `prof_skype` varchar(100) DEFAULT NULL,
  `prof_website` varchar(100) DEFAULT NULL,
  `prof_about` text,
  `prof_languages` varchar(100) DEFAULT NULL,
  `prof_interests` text,
  `prof_rating` double DEFAULT '0',
  `prof_picture` varchar(500) DEFAULT NULL,
  `prof_cover_photo` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`prof_id`),
  KEY `FK_koo_user_profile_user` (`user_id`),
  CONSTRAINT `FK_koo_user_profile_user` FOREIGN KEY (`user_id`) REFERENCES `koo_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `koo_user_profile` */

insert  into `koo_user_profile`(`prof_id`,`user_id`,`prof_firstname`,`prof_lastname`,`prof_tag`,`prof_address`,`prof_phone`,`prof_skype`,`prof_website`,`prof_about`,`prof_languages`,`prof_interests`,`prof_rating`,`prof_picture`,`prof_cover_photo`,`created_at`,`modified_at`,`created_by`,`modified_by`) values (1,7,'Prakash','Arul Mani','asdasd','sdadasdsda	','5112151201','ark.prakash',NULL,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet dictum turpis, eu dictum enim fermentum lacinia. Nullam pulvinar vel eros nec finibus. Mauris eget magna eget justo vestibulum condimentum ut in felis. Praesent tincidunt fringilla quam, et euismod tortor ornare at. Etiam blandit sed nisi sit amet condimentum. Vivamus vestibulum eros ut orci molestie congue. Ut sodales lobortis maximus. In sit amet justo placerat, elementum orci ut, feugiat ','[\"5\",\"9\"]','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet dictum turpis, eu dictum enim fermentum lacinia. Nullam pulvinar vel eros nec finibus. Mauris eget magna eget justo vestibulum condimentum ut in felis. Praesent tincidunt fringilla quam, et euismod tortor ornare at. Etiam blandit sed nisi sit amet condimentum. Vivamus vestibulum eros ut orci molestie congue. Ut sodales lobortis maximus. In sit amet justo placerat, elementum orci ut, feugiat ',0,NULL,NULL,'2015-11-18 18:58:14','0000-00-00 00:00:00',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
