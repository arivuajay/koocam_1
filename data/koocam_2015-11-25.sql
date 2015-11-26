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

/*Table structure for table `koo_cms` */

DROP TABLE IF EXISTS `koo_cms`;

CREATE TABLE `koo_cms` (
  `cms_id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `cms_title` varchar(255) NOT NULL,
  `cms_description` longtext NOT NULL,
  `cms_meta_keywords` text,
  `cms_meta_description` text,
  `cms_tag` varchar(255) DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `koo_cms` */

insert  into `koo_cms`(`cms_id`,`slug`,`cms_title`,`cms_description`,`cms_meta_keywords`,`cms_meta_description`,`cms_tag`,`status`,`created_at`,`modified_at`) values (1,'how-it-works','How it works','<div class=\"innerpage-cont\">\r\n    <div class=\"container\">\r\n      <div class=\"row\">\r\n        \r\n        <div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 course-details\">\r\n          \r\n         \r\n        <p>  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis orci vestibulum, ornare ante eget, tincidunt ante. Aenean pretium ipsum at nisl aliquet, molestie cursus eros sollicitudin. Aenean in vulputate sapien. Cras imperdiet magna urna, in malesuada elit eleifend a. Sed lobortis sem magna, et egestas odio suscipit quis. Nulla facilisi. Donec lacinia in dolor sed condimentum. Morbi bibendum posuere mauris, a accumsan leo placerat non. Nunc semper arcu eu placerat rhoncus. Duis et nulla mauris. Morbi ultricies condimentum diam.  </p>\r\n        \r\n  \r\n          \r\n           \r\n          <p> Donec nunc nisi, malesuada ut arcu ac, venenatis elementum sapien. Proin iaculis laoreet purus in pellentesque. Ut pellentesque, dui eu tristique porttitor, eros augue bibendum mi, vitae egestas nulla eros id diam.</p>\r\n          \r\n         \r\n          <p>Etiam scelerisque ut nunc a maximus. Curabitur at nunc sed mi feugiat elementum a in leo. Nulla non nisi sit amet lacus elementum porta quis in arcu. Quisque lorem velit, mattis tincidunt suscipit vitae, varius in sapien.</p>\r\n          \r\n         <p>   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis orci vestibulum, ornare ante eget, tincidunt ante. Aenean pretium ipsum at nisl aliquet, molestie cursus eros sollicitudin. Aenean in vulputate sapien. Cras imperdiet magna urna, in malesuada elit eleifend a. Sed lobortis sem magna, et egestas odio suscipit quis. Nulla facilisi. Donec lacinia in dolor sed condimentum. Morbi bibendum posuere mauris, a accumsan leo placerat non. Nunc semper arcu eu placerat rhoncus. Duis et nulla mauris. Morbi ultricies condimentum diam. </p>\r\n\r\n<p> Donec nunc nisi, malesuada ut arcu ac, venenatis elementum sapien. Proin iaculis laoreet purus in pellentesque. Ut pellentesque, dui eu tristique porttitor, eros augue bibendum mi, vitae egestas nulla eros id diam. Sed malesuada ultrices lectus, vulputate finibus nulla mattis quis. Duis vitae arcu aliquet, suscipit nibh ac, aliquam turpis. Fusce mollis convallis efficitur. Etiam lacus erat, sollicitudin id elementum sed, consequat sed ligula.</p>\r\n\r\n<p> Etiam scelerisque ut nunc a maximus. Curabitur at nunc sed mi feugiat elementum a in leo. Nulla non nisi sit amet lacus elementum porta quis in arcu. Quisque lorem velit, mattis tincidunt suscipit vitae, varius in sapien. Aenean pharetra bibendum ullamcorper. Praesent justo nulla, molestie in urna sed, laoreet porttitor neque. In et tellus vulputate, gravida quam vitae, condimentum justo. Praesent nunc nibh, interdum sed elementum feugiat, euismod in est. In hac habitasse platea dictumst. Proin ornare ipsum et ornare interdum. Nam non maximus arcu. Sed nec neque nulla. Proin dapibus tortor augue, ac feugiat tortor convallis sit amet. Praesent volutpat hendrerit condimentum. Aenean ac sagittis nunc. </p>\r\n          \r\n        </div>\r\n        \r\n        \r\n        \r\n        \r\n      </div>\r\n    </div>\r\n\r\n  </div>','How it works','How it works','','1','2015-11-25 11:02:34','2015-11-25 11:39:38'),(2,'about-us','About Us','<div class=\"innerpage-cont\">\r\n    <div class=\"container\">\r\n      <div class=\"row\">\r\n        \r\n        <div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 course-details\">\r\n          <h2> Our History  </h2>\r\n         \r\n        <p>  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis orci vestibulum, ornare ante eget, tincidunt ante. Aenean pretium ipsum at nisl aliquet, molestie cursus eros sollicitudin. Aenean in vulputate sapien. Cras imperdiet magna urna, in malesuada elit eleifend a. Sed lobortis sem magna, et egestas odio suscipit quis. Nulla facilisi. Donec lacinia in dolor sed condimentum. Morbi bibendum posuere mauris, a accumsan leo placerat non. Nunc semper arcu eu placerat rhoncus. Duis et nulla mauris. Morbi ultricies condimentum diam.  </p>\r\n        \r\n  \r\n          \r\n            <h4> Our Mission </h4>\r\n          <p> Donec nunc nisi, malesuada ut arcu ac, venenatis elementum sapien. Proin iaculis laoreet purus in pellentesque. Ut pellentesque, dui eu tristique porttitor, eros augue bibendum mi, vitae egestas nulla eros id diam.</p>\r\n          \r\n          <h4> Our Vision </h4>\r\n          <p>Etiam scelerisque ut nunc a maximus. Curabitur at nunc sed mi feugiat elementum a in leo. Nulla non nisi sit amet lacus elementum porta quis in arcu. Quisque lorem velit, mattis tincidunt suscipit vitae, varius in sapien.</p>\r\n          \r\n          \r\n        </div>\r\n        \r\n        \r\n        \r\n        \r\n      </div>\r\n    </div>\r\n\r\n  </div>','About Us','About Us','Who we are','1','2015-11-25 11:06:12','2015-11-25 11:39:01'),(3,'privacy-policy','Privacy Policy','<div class=\"innerpage-cont\">\r\n    <div class=\"container\">\r\n      <div class=\"row\">\r\n        \r\n        <div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 course-details\">\r\n          \r\n         \r\n        <p>  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis orci vestibulum, ornare ante eget, tincidunt ante. Aenean pretium ipsum at nisl aliquet, molestie cursus eros sollicitudin. Aenean in vulputate sapien. Cras imperdiet magna urna, in malesuada elit eleifend a. Sed lobortis sem magna, et egestas odio suscipit quis. Nulla facilisi. Donec lacinia in dolor sed condimentum. Morbi bibendum posuere mauris, a accumsan leo placerat non. Nunc semper arcu eu placerat rhoncus. Duis et nulla mauris. Morbi ultricies condimentum diam.  </p>\r\n        \r\n  \r\n          \r\n           \r\n          <p> Donec nunc nisi, malesuada ut arcu ac, venenatis elementum sapien. Proin iaculis laoreet purus in pellentesque. Ut pellentesque, dui eu tristique porttitor, eros augue bibendum mi, vitae egestas nulla eros id diam.</p>\r\n          \r\n         \r\n          <p>Etiam scelerisque ut nunc a maximus. Curabitur at nunc sed mi feugiat elementum a in leo. Nulla non nisi sit amet lacus elementum porta quis in arcu. Quisque lorem velit, mattis tincidunt suscipit vitae, varius in sapien.</p>\r\n          \r\n         <p>   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis orci vestibulum, ornare ante eget, tincidunt ante. Aenean pretium ipsum at nisl aliquet, molestie cursus eros sollicitudin. Aenean in vulputate sapien. Cras imperdiet magna urna, in malesuada elit eleifend a. Sed lobortis sem magna, et egestas odio suscipit quis. Nulla facilisi. Donec lacinia in dolor sed condimentum. Morbi bibendum posuere mauris, a accumsan leo placerat non. Nunc semper arcu eu placerat rhoncus. Duis et nulla mauris. Morbi ultricies condimentum diam. </p>\r\n\r\n<p> Donec nunc nisi, malesuada ut arcu ac, venenatis elementum sapien. Proin iaculis laoreet purus in pellentesque. Ut pellentesque, dui eu tristique porttitor, eros augue bibendum mi, vitae egestas nulla eros id diam. Sed malesuada ultrices lectus, vulputate finibus nulla mattis quis. Duis vitae arcu aliquet, suscipit nibh ac, aliquam turpis. Fusce mollis convallis efficitur. Etiam lacus erat, sollicitudin id elementum sed, consequat sed ligula.</p>\r\n\r\n<p> Etiam scelerisque ut nunc a maximus. Curabitur at nunc sed mi feugiat elementum a in leo. Nulla non nisi sit amet lacus elementum porta quis in arcu. Quisque lorem velit, mattis tincidunt suscipit vitae, varius in sapien. Aenean pharetra bibendum ullamcorper. Praesent justo nulla, molestie in urna sed, laoreet porttitor neque. In et tellus vulputate, gravida quam vitae, condimentum justo. Praesent nunc nibh, interdum sed elementum feugiat, euismod in est. In hac habitasse platea dictumst. Proin ornare ipsum et ornare interdum. Nam non maximus arcu. Sed nec neque nulla. Proin dapibus tortor augue, ac feugiat tortor convallis sit amet. Praesent volutpat hendrerit condimentum. Aenean ac sagittis nunc. </p>\r\n          \r\n        </div>\r\n        \r\n        \r\n        \r\n        \r\n      </div>\r\n    </div>\r\n\r\n  </div>','Privacy Policy','Privacy Policy','Terms & conditions','1','2015-11-25 11:07:58','2015-11-25 11:39:51'),(4,'terms-and-conditions','Terms and Conditions','<div class=\"innerpage-cont\">\r\n    <div class=\"container\">\r\n      <div class=\"row\">\r\n        \r\n        <div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 course-details\">\r\n          \r\n         \r\n        <p>  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis orci vestibulum, ornare ante eget, tincidunt ante. Aenean pretium ipsum at nisl aliquet, molestie cursus eros sollicitudin. Aenean in vulputate sapien. Cras imperdiet magna urna, in malesuada elit eleifend a. Sed lobortis sem magna, et egestas odio suscipit quis. Nulla facilisi. Donec lacinia in dolor sed condimentum. Morbi bibendum posuere mauris, a accumsan leo placerat non. Nunc semper arcu eu placerat rhoncus. Duis et nulla mauris. Morbi ultricies condimentum diam.  </p>\r\n        \r\n  \r\n          \r\n           \r\n          <p> Donec nunc nisi, malesuada ut arcu ac, venenatis elementum sapien. Proin iaculis laoreet purus in pellentesque. Ut pellentesque, dui eu tristique porttitor, eros augue bibendum mi, vitae egestas nulla eros id diam.</p>\r\n          \r\n         \r\n          <p>Etiam scelerisque ut nunc a maximus. Curabitur at nunc sed mi feugiat elementum a in leo. Nulla non nisi sit amet lacus elementum porta quis in arcu. Quisque lorem velit, mattis tincidunt suscipit vitae, varius in sapien.</p>\r\n          \r\n         <p>   Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis orci vestibulum, ornare ante eget, tincidunt ante. Aenean pretium ipsum at nisl aliquet, molestie cursus eros sollicitudin. Aenean in vulputate sapien. Cras imperdiet magna urna, in malesuada elit eleifend a. Sed lobortis sem magna, et egestas odio suscipit quis. Nulla facilisi. Donec lacinia in dolor sed condimentum. Morbi bibendum posuere mauris, a accumsan leo placerat non. Nunc semper arcu eu placerat rhoncus. Duis et nulla mauris. Morbi ultricies condimentum diam. </p>\r\n\r\n<p> Donec nunc nisi, malesuada ut arcu ac, venenatis elementum sapien. Proin iaculis laoreet purus in pellentesque. Ut pellentesque, dui eu tristique porttitor, eros augue bibendum mi, vitae egestas nulla eros id diam. Sed malesuada ultrices lectus, vulputate finibus nulla mattis quis. Duis vitae arcu aliquet, suscipit nibh ac, aliquam turpis. Fusce mollis convallis efficitur. Etiam lacus erat, sollicitudin id elementum sed, consequat sed ligula.</p>\r\n\r\n<p> Etiam scelerisque ut nunc a maximus. Curabitur at nunc sed mi feugiat elementum a in leo. Nulla non nisi sit amet lacus elementum porta quis in arcu. Quisque lorem velit, mattis tincidunt suscipit vitae, varius in sapien. Aenean pharetra bibendum ullamcorper. Praesent justo nulla, molestie in urna sed, laoreet porttitor neque. In et tellus vulputate, gravida quam vitae, condimentum justo. Praesent nunc nibh, interdum sed elementum feugiat, euismod in est. In hac habitasse platea dictumst. Proin ornare ipsum et ornare interdum. Nam non maximus arcu. Sed nec neque nulla. Proin dapibus tortor augue, ac feugiat tortor convallis sit amet. Praesent volutpat hendrerit condimentum. Aenean ac sagittis nunc. </p>\r\n          \r\n        </div>\r\n        \r\n        \r\n        \r\n        \r\n      </div>\r\n    </div>\r\n\r\n  </div>','Terms and Conditions','Terms and Conditions','','1','2015-11-25 15:24:40',NULL);

/*Table structure for table `koo_country` */

DROP TABLE IF EXISTS `koo_country`;

CREATE TABLE `koo_country` (
  `country_Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID:',
  `country_name` varchar(45) NOT NULL COMMENT 'Name:',
  `country_two_code` varchar(3) DEFAULT NULL COMMENT 'Two Code:',
  `country_three_code` varchar(5) DEFAULT NULL COMMENT 'Three Code:',
  `status` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT 'Status',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`country_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=latin1;

/*Data for the table `koo_country` */

insert  into `koo_country`(`country_Id`,`country_name`,`country_two_code`,`country_three_code`,`status`,`created_at`,`modified_at`) values (2,'NEPAL','NP','0524','1','2015-03-15 00:12:13','0000-00-00 00:00:00'),(5,'AFGHANISTAN','AF','0004','1','2015-04-10 21:28:14','0000-00-00 00:00:00'),(7,'ALBANIA','AL','0008','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(8,'ALGERIA','DZ','0012','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(9,'ANDORRA','AD','0020','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(10,'ANGOLA','AO','0024','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(11,'ANTIGUA AND BARBUDA','AG','0028','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(12,'AZERBAIJAN','AZ','0031','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(13,'ARGENTINA','AR','0032','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(14,'AUSTRALIA','AU','0036','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(15,'AUSTRIA','AT','0040','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(16,'BAHAMAS','BS','0044','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(17,'BAHRAIN','BH','0048','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(18,'BANGLADESH','BD','0050','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(19,'ARMENIA','AM','0051','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(20,'BARBADOS','BB','0052','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(21,'BELGIUM','BE','0056','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(22,'BHUTAN','BT','0064','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(23,'BOLIVIA','BO','0068','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(24,'BOSNIA AND HERZEGOVINA','BA','0070','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(25,'BOTSWANA','BW','0072','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(26,'BRAZIL','BR','0076','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(27,'BELIZE','BZ','0084','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(28,'SOLOMON ISLANDS','SB','0090','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(29,'BRUNEI DARUSSALAM','BN','0096','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(30,'BULGARIA','BG','0100','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(31,'BURMA','BU','0104','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(32,'MYANMAR','MM','0104','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(33,'BURUNDI','BI','0108','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(34,'BELARUS','BY','0112','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(35,'CAMBODIA','KH','0116','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(36,'CAMEROON','CM','0120','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(37,'CANADA','CA','0124','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(38,'CAPE VERDE','CV','0132','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(39,'CENTRAL AFRICAN REPUBLIC','CF','0140','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(40,'SRI LANKA','LK','0144','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(41,'CHAD','TD','0148','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(42,'CHILE','CL','0152','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(43,'CHINA','CN','0156','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(44,'TAIWAN, PROVINCE OF CHINA','TW','0158','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(45,'COLOMBIA','CO','0170','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(46,'COMOROS','KM','0174','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(47,'CONGO','CG','0178','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(48,'ZAIRE','ZR','0180','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(49,'CONGO, THE DEMOCRATIC REPUBLIC OF THE','CD','0180','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(50,'COSTA RICA','CR','0188','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(51,'CROATIA','HR','0191','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(52,'CUBA','CU','0192','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(53,'CYPRUS','CY','0196','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(54,'CZECHOSLOVAKIA','CS','0200','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(55,'CZECH REPUBLIC','CZ','0203','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(56,'BENIN','BJ','0204','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(57,'DENMARK','DK','0208','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(58,'DOMINICA','DM','0212','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(59,'DOMINICAN REPUBLIC','DO','0214','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(60,'ECUADOR','EC','0218','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(61,'EL SALVADOR','SV','0222','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(62,'EQUATORIAL GUINEA','GQ','0226','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(63,'ETHIOPIA','ET','0230','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(64,'ETHIOPIA','ET','0231','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(65,'ERITREA','ER','0232','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(66,'ESTONIA','EE','0233','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(67,'FIJI','FJ','0242','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(68,'FINLAND','FI','0246','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(69,'FRANCE','FR','0250','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(70,'FRENCH POLYNESIA','PF','0258','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(71,'DJIBOUTI','DJ','0262','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(72,'GABON','GA','0266','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(73,'GEORGIA','GE','0268','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(74,'GAMBIA','GM','0270','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(75,'GERMANY','DE','0276','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(76,'GERMAN DEMOCRATIC REPUBLIC','DD','0278','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(77,'GERMANY','DE','0280','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(78,'GHANA','GH','0288','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(79,'KIRIBATI','KI','0296','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(80,'GREECE','GR','0300','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(81,'GRENADA','GD','0308','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(82,'GUATEMALA','GT','0320','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(83,'GUINEA','GN','0324','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(84,'GUYANA','GY','0328','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(85,'HAITI','HT','0332','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(86,'HOLY SEE (VATICAN CITY STATE)','VA','0336','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(87,'HONDURAS','HN','0340','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(88,'HONG KONG','HK','0344','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(89,'HUNGARY','HU','0348','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(90,'ICELAND','IS','0352','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(91,'INDIA','IN','0356','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(92,'INDONESIA','ID','0360','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(93,'IRAN, ISLAMIC REPUBLIC OF','IR','0364','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(94,'IRAQ','IQ','0368','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(95,'IRELAND','IE','0372','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(96,'ISRAEL','IL','0376','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(97,'ITALY','IT','0380','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(98,'COTE D\'IVOIRE','CI','0384','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(99,'JAMAICA','JM','0388','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(100,'JAPAN','JP','0392','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(101,'KAZAKSTAN','KZ','0398','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(102,'JORDAN','JO','0400','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(103,'KENYA','KE','0404','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(104,'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF','KP','0408','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(105,'KOREA, REPUBLIC OF','KR','0410','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(106,'KUWAIT','KW','0414','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(107,'KYRGYZSTAN','KG','0417','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(108,'LAO PEOPLE\'S DEMOCRATIC REPUBLIC','LA','0418','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(109,'LEBANON','LB','0422','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(110,'LESOTHO','LS','0426','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(111,'LATVIA','LV','0428','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(112,'LIBERIA','LR','0430','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(113,'LIBYAN ARAB JAMAHIRIYA','LY','0434','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(114,'LIECHTENSTEIN','LI','0438','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(115,'LITHUANIA','LT','0440','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(116,'LUXEMBOURG','LU','0442','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(117,'MADAGASCAR','MG','0450','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(118,'MALAWI','MW','0454','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(119,'MALAYSIA','MY','0458','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(120,'MALDIVES','MV','0462','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(121,'MALI','ML','0466','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(122,'MALTA','MT','0470','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(123,'MAURITANIA','MR','0478','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(124,'MAURITIUS','MU','0480','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(125,'MEXICO','MX','0484','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(126,'MONACO','MC','0492','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(127,'MONGOLIA','MN','0496','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(128,'MOLDOVA, REPUBLIC OF','MD','0498','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(129,'MOROCCO','MA','0504','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(130,'MOZAMBIQUE','MZ','0508','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(131,'OMAN','OM','0512','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(132,'NAMIBIA','NA','0516','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(133,'NAURU','NR','0520','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(135,'NETHERLANDS','NL','0528','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(136,'VANUATU','VU','0548','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(137,'NEW ZEALAND','NZ','0554','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(138,'NICARAGUA','NI','0558','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(139,'NIGER','NE','0562','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(140,'NIGERIA','NG','0566','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(141,'NORWAY','NO','0578','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(142,'MICRONESIA, FEDERATED STATES OF','FM','0583','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(143,'MARSHALL ISLANDS','MH','0584','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(144,'PALAU','PW','0585','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(145,'PAKISTAN','PK','0586','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(146,'PANAMA','PA','0591','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(147,'PAPUA NEW GUINEA','PG','0598','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(148,'PARAGUAY','PY','0600','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(149,'PERU','PE','0604','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(150,'PHILIPPINES','PH','0608','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(151,'POLAND','PL','0616','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(152,'PORTUGAL','PT','0620','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(153,'GUINEA-BISSAU','GW','0624','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(154,'PUERTO RICO','PR','0630','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(155,'QATAR','QA','0634','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(156,'ROMANIA','RO','0642','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(157,'RUSSIAN FEDERATION','RU','0643','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(158,'RWANDA','RW','0646','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(159,'SAINT KITTS AND NEVIS','KN','0659','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(160,'SAINT LUCIA','LC','0662','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(161,'SAINT VINCENT AND THE GRENADINES','VC','0670','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(162,'SAN MARINO','SM','0674','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(163,'SAO TOME AND PRINCIPE','ST','0678','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(164,'SAUDI ARABIA','SA','0682','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(165,'SENEGAL','SN','0686','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(166,'SEYCHELLES','SC','0690','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(167,'SIERRA LEONE','SL','0694','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(168,'SINGAPORE','SG','0702','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(169,'SLOVAKIA','SK','0703','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(170,'VIET NAM','VN','0704','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(171,'SLOVENIA','SI','0705','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(172,'SOMALIA','SO','0706','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(173,'SOUTH AFRICA','ZA','0710','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(174,'ZIMBABWE','ZW','0716','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(175,'YEMEN, DEMOCRATIC','YD','0720','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(176,'SPAIN','ES','0724','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(177,'WESTERN SAHARA','EH','0732','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(178,'SUDAN','SD','0736','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(179,'SURINAME','SR','0740','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(180,'SWAZILAND','SZ','0748','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(181,'SWEDEN','SE','0752','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(182,'SWITZERLAND','CH','0756','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(183,'SYRIAN ARAB REPUBLIC','SY','0760','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(184,'TAJIKISTAN','TJ','0762','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(185,'THAILAND','TH','0764','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(186,'TOGO','TG','0768','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(187,'TONGA','TO','0776','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(188,'TRINIDAD AND TOBAGO','TT','0780','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(189,'UNITED ARAB EMIRATES','AE','0784','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(190,'TUNISIA','TN','0788','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(191,'TURKEY','TR','0792','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(192,'TURKMENISTAN','TM','0795','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(193,'TUVALU','TV','0798','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(194,'UGANDA','UG','0800','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(195,'UKRAINE','UA','0804','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(196,'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','MK','0807','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(197,'USSR','SU','0810','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(198,'EGYPT','EG','0818','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(199,'UNITED KINGDOM','GB','0826','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(200,'TANZANIA, UNITED REPUBLIC OF','TZ','0834','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(201,'UNITED STATES','US','0840','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(202,'BURKINA FASO','BF','0854','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(203,'URUGUAY','UY','0858','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(204,'UZBEKISTAN','UZ','0860','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(205,'VENEZUELA','VE','0862','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(206,'SAMOA','WS','0882','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(207,'YEMEN (0886)','YE','0886','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(208,'YEMEN (0887)','YE','0887','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(209,'YUGOSLAVIA (0890)','YU','0890','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(210,'YUGOSLAVIA (0891)','YU','0891','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(211,'ZAMBIA','ZM','0894','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(212,'AFRICA','2AF','2100','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(213,'AMERICA','2AM','2101','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(214,'AMERICAN CONTINENT','2AC','2102','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(215,'ANTILLES','2AN','2103','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(216,'APEC COUNTRIES','2AP','2104','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(217,'ASEAN COUNTRIES','2AE','2105','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(218,'ASIA','2AS','2106','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(219,'AUSTRALASIA','2AA','2107','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(220,'BALKANS','2BA','2108','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(221,'BALTIC STATES','2BS','2109','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(222,'BENELUX','2BE','2110','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(223,'BRITISH ISLES','2BI','2111','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(224,'BRITISH WEST INDIES','2BW','2112','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(225,'CENTRAL AMERICA','2CA','2113','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(226,'COMMONWEALTH','2CO','2114','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(227,'COMMONWEALTH AFRICAN TERRITORIES','2CF','2115','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(228,'COMMONWEALTH ASIAN TERRITORIES','2CS','2116','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(229,'COMMONWEALTH AUSTRALASIAN TERRITORIES','2CU','2117','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(230,'COMMONWEALTH OF INDEPENDENT STATES','2CI','2118','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(231,'EASTERN EUROPE','2EE','2119','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(232,'EUROPE','2EU','2120','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(233,'EUROPEAN ECONOMIC AREA','2EM','2121','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(234,'EUROPEAN CONTINENT','2EC','2122','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(235,'EUROPEAN ECONOMIC COMMUNITY','2EY','2123','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(236,'EUROPEAN UNION','2EN','2123','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(237,'GSA COUNTRIES','2GC','2124','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(238,'MIDDLE EAST','2ME','2125','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(239,'NAFTA COUNTRIES','2NT','2126','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(240,'NORDIC COUNTRIES','2NC','2127','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(241,'NORTH AFRICA','2NF','2128','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(242,'NORTH AMERICA','2NA','2129','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(243,'OCEANIA','2OC','2130','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(244,'SCANDINAVIA','2SC','2131','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(245,'SOUTH AMERICA','2SA','2132','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(246,'SOUTH EAST ASIA','2SE','2133','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(247,'WEST INDIES','2WI','2134','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(248,'WORLD','2WL','2136','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(249,'WEST AFRICA REGION','WAR','WA','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(250,'CENTRAL AFRICA REGION','CAR','CA','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(251,'EAST AFRICA REGION','EAR','EA','1','2015-06-02 11:58:36','0000-00-00 00:00:00'),(252,'SOUTH AFRICA REGION','SAR','SA','1','2015-06-02 11:58:36','0000-00-00 00:00:00');

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
  `is_extra` enum('Y','N') DEFAULT 'N',
  `gig_important` varchar(255) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '0',
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`gig_id`),
  KEY `FK_koo_gig_category` (`cat_id`),
  KEY `FK_koo_gig_user` (`tutor_id`),
  CONSTRAINT `FK_koo_gig_category` FOREIGN KEY (`cat_id`) REFERENCES `koo_gig_category` (`cat_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_koo_gig_user` FOREIGN KEY (`tutor_id`) REFERENCES `koo_user` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

/*Data for the table `koo_gig` */

insert  into `koo_gig`(`gig_id`,`tutor_id`,`gig_title`,`cat_id`,`gig_media`,`gig_tag`,`gig_description`,`gig_duration`,`gig_price`,`gig_avail_visual`,`is_extra`,`gig_important`,`status`,`slug`,`created_at`,`modified_at`,`created_by`,`modified_by`) values (36,7,'Learn English 22',1,'/gig/3d43fdc2184b8832b640f19f6e643e0b.jpg','learn english 122','English speaking 1122','00:45:00','60.00','Y','Y',NULL,'1','learn-english-22','2015-11-23 18:24:57','2015-11-25 12:34:32',NULL,NULL),(37,7,'Learn English',1,'/gig/6fe7091001d72cb8486b17a7ec3ded7f.jpg','test tag','adasd','00:50:00','10.00','Y','Y',NULL,'1','learn-english','2015-11-25 12:36:07','0000-00-00 00:00:00',NULL,NULL);

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
  CONSTRAINT `FK_koo_gig_booking_gig` FOREIGN KEY (`gig_id`) REFERENCES `koo_gig` (`gig_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_koo_gig_booking_user` FOREIGN KEY (`book_user_id`) REFERENCES `koo_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `koo_gig_category` */

insert  into `koo_gig_category`(`cat_id`,`cat_name`,`cat_description`,`cat_image`,`status`,`slug`,`created_at`,`modified_at`,`created_by`,`modified_by`) values (1,'Learn English Speaking','Category Descc','/gigcategory/2c05c74ee923d2d171fcc9dd94fe57dd.jpg','1','learn-english-speaking','2015-11-18 16:42:50','2015-11-23 18:18:31',NULL,NULL),(2,'Learn Violin','','/gigcategory/686d1c6a88b741429ace989a6b1aeb4f.jpg','1',NULL,'2015-11-18 16:42:52','2015-11-23 11:05:14',NULL,NULL),(3,'Learn Writing French','','/gigcategory/f1d54ea92ce4f67ed38fe4198d6d4d38.jpg','1',NULL,'2015-11-18 16:42:56','2015-11-23 11:05:29',NULL,NULL),(4,'Learn Spanish Speaking','','/gigcategory/70d3a7ea99f280c698ebf2ec2e034c22.jpg','1',NULL,'2015-11-23 11:07:24','0000-00-00 00:00:00',NULL,NULL),(5,'Programming Languages','','/gigcategory/ec5d4a16b8fdfb787dd77d34639dd2ad.jpg','1',NULL,'2015-11-23 11:07:51','0000-00-00 00:00:00',NULL,NULL),(6,'Film & Media','asdsdsdsd','/gigcategory/de740ce334d9e00211083607a982c781.jpg','1',NULL,'2015-11-23 11:08:09','2015-11-23 18:17:48',NULL,NULL),(7,'test test','',NULL,'1','test-test','2015-11-23 18:17:30','0000-00-00 00:00:00',NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `koo_gig_extra` */

insert  into `koo_gig_extra`(`extra_id`,`gig_id`,`extra_price`,`extra_description`,`extra_file`,`created_by`,`modified_by`) values (20,36,'25.00','Extra description','/gigextra/a9f2d0d9386c0f793127deac0115371e.png','2015-11-23 18:24:57','0000-00-00 00:00:00'),(21,36,'10.00','Extra description 1111','/gigextra/3d43fdc2184b8832b640f19f6e643e0b.png','2015-11-25 12:34:32','0000-00-00 00:00:00'),(22,37,'5.00','testtt','/gigextra/f866469adccabcd461025a85a5c94730.png','2015-11-25 12:36:08','0000-00-00 00:00:00');

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
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `koo_user` */

insert  into `koo_user`(`user_id`,`username`,`password_hash`,`password_reset_token`,`email`,`user_activation_key`,`user_login_ip`,`user_last_login`,`status`,`live_status`,`slug`,`created_at`,`modified_at`) values (1,'user_1','263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62',NULL,'user_1@gmail.com',NULL,NULL,'0000-00-00 00:00:00','1','O','','2015-11-13 12:37:25','0000-00-00 00:00:00'),(2,'user_2','be2ce3b45176df1d3e41e35d6aa0ea9a44b56b3575e15ebc6da0d3da7793489b9eb718dc2cfe7f5f2bc61151ad4ffc70ba4d234520ed51735fa98ec878ddc27b',NULL,'user_2@gmail.com',NULL,NULL,'0000-00-00 00:00:00','1','O','','2015-11-13 12:37:41','0000-00-00 00:00:00'),(3,'user_3','be2ce3b45176df1d3e41e35d6aa0ea9a44b56b3575e15ebc6da0d3da7793489b9eb718dc2cfe7f5f2bc61151ad4ffc70ba4d234520ed51735fa98ec878ddc27b',NULL,'user_3@gmail.com',NULL,NULL,'0000-00-00 00:00:00','1','O','','2015-11-13 12:37:55','0000-00-00 00:00:00'),(7,'prakash','263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62',NULL,'prakash.paramanandam@arkinfotec.com','Q6fF2AykT','127.0.0.1','2015-11-17 14:10:26','1','O','prakash','2015-11-17 12:52:20','2015-11-17 18:40:26'),(8,'Nadesh','6a49849ff76c57c85f923ae1ebabe503125637818ebc4effd3559351b93efb03ccde000ca472ac3b9e11ce532bb6e9de71037e37ba64b337ae877c3139b71534',NULL,'nadesh@arkinfotec.com','rXOkCUMUk','127.0.0.1','0000-00-00 00:00:00','1','O','','2015-11-17 14:01:54','2015-11-17 14:02:35'),(9,'user_4','263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62',NULL,'user4@gmail.com','1pQXQ4ZrP','127.0.0.1','0000-00-00 00:00:00','1','O','','2015-11-23 17:52:04','2015-11-23 17:52:19');

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
  `country_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`prof_id`),
  KEY `FK_koo_user_profile_user` (`user_id`),
  KEY `FK_koo_user_profile_country` (`country_id`),
  CONSTRAINT `FK_koo_user_profile_country` FOREIGN KEY (`country_id`) REFERENCES `koo_country` (`country_Id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_koo_user_profile_user` FOREIGN KEY (`user_id`) REFERENCES `koo_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `koo_user_profile` */

insert  into `koo_user_profile`(`prof_id`,`user_id`,`prof_firstname`,`prof_lastname`,`prof_tag`,`prof_address`,`prof_phone`,`prof_skype`,`prof_website`,`prof_about`,`prof_languages`,`prof_interests`,`prof_rating`,`prof_picture`,`prof_cover_photo`,`country_id`,`created_at`,`modified_at`,`created_by`,`modified_by`) values (1,7,'Prakash','Arul Mani','asdasd','sdadasdsda	','5112151201','ark.prakash','','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet dictum turpis, eu dictum enim fermentum lacinia. Nullam pulvinar vel eros nec finibus. Mauris eget magna eget justo vestibulum condimentum ut in felis. Praesent tincidunt fringilla quam, et euismod tortor ornare at. Etiam blandit sed nisi sit amet condimentum. Vivamus vestibulum eros ut orci molestie congue. Ut sodales lobortis maximus. In sit amet justo placerat, elementum orci ut, feugiat ','[\"5\",\"9\",\"11\"]','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet dictum turpis, eu dictum enim fermentum lacinia. Nullam pulvinar vel eros nec finibus. Mauris eget magna eget justo vestibulum condimentum ut in felis. Praesent tincidunt fringilla quam, et euismod tortor ornare at. Etiam blandit sed nisi sit amet condimentum. Vivamus vestibulum eros ut orci molestie congue. Ut sodales lobortis maximus. In sit amet justo placerat, elementum orci ut, feugiat ',0,NULL,'',2,'2015-11-18 18:58:14','2015-11-25 10:12:45',NULL,NULL),(2,9,'John','Tac',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,2,'2015-11-23 17:52:04','2015-11-23 17:52:19',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
