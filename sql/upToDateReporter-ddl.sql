-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: version
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `applib`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applib` (
  `applib_id` int(11) NOT NULL AUTO_INCREMENT,
  `version_id` int(11) NOT NULL,
  `applib_description` varchar(255) DEFAULT NULL,
  `application_id` int(11) NOT NULL,
  PRIMARY KEY (`applib_id`),
  UNIQUE KEY `use_id_UNIQUE` (`applib_id`),
  KEY `fk_use_1_idx` (`version_id`),
  KEY `fk_use_application_idx` (`application_id`),
  CONSTRAINT `fk_applib_application` FOREIGN KEY (`application_id`) REFERENCES `application` (`application_id`),
  CONSTRAINT `fk_applib_version` FOREIGN KEY (`version_id`) REFERENCES `version` (`version_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `application`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application` (
  `application_id` int(11) NOT NULL AUTO_INCREMENT,
  `application_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `application_sample` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`application_id`),
  UNIQUE KEY `applicaiton_id_UNIQUE` (`application_id`),
  KEY `fk_application_user_idx` (`user_id`),
  CONSTRAINT `fk_application_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `library`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `library` (
  `library_id` int(11) NOT NULL AUTO_INCREMENT,
  `library_name` varchar(255) NOT NULL,
  `library_eol` tinyint(1) NOT NULL DEFAULT '0',
  `library_url` varchar(255) NOT NULL,
  `library_eol_date` date DEFAULT NULL,
  PRIMARY KEY (`library_id`),
  UNIQUE KEY `library_id_UNIQUE` (`library_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `library_queue`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `library_queue` (
  `library_queue_id` int(11) NOT NULL AUTO_INCREMENT,
  `library_queue_name` varchar(255) NOT NULL,
  `library_queue_eol` tinyint(1) NOT NULL DEFAULT '0',
  `library_queue_url` varchar(255) NOT NULL,
  `library_queue_eol_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`library_queue_id`),
  UNIQUE KEY `library_queue_id_UNIQUE` (`library_queue_id`),
  KEY `fk_library_queue_1_idx` (`user_id`),
  CONSTRAINT `fk_library_queue_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_failures`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_failures` (
  `password_failures_id` int(11) NOT NULL AUTO_INCREMENT,
  `password_failures_ip` varchar(46) NOT NULL,
  `password_failures_count` int(11) NOT NULL DEFAULT '1',
  `password_failures_last_datetime` datetime NOT NULL,
  PRIMARY KEY (`password_failures_id`),
  UNIQUE KEY `password_failures_id_UNIQUE` (`password_failures_id`),
  UNIQUE KEY `password_failures_ip_UNIQUE` (`password_failures_ip`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_confirmation_code` varchar(128) NOT NULL,
  `user_confirmation_code_datetime_sent` datetime NOT NULL,
  `user_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `user_libraries_added` int(11) NOT NULL DEFAULT '0',
  `user_versions_added` int(11) NOT NULL DEFAULT '0',
  `user_admin` tinyint(1) NOT NULL DEFAULT '0',
  `user_mod` tinyint(1) NOT NULL DEFAULT '0',
  `user_libraries_modded` int(11) NOT NULL DEFAULT '0',
  `user_versions_modded` int(11) NOT NULL DEFAULT '0',
  `user_password_failure_count` int(11) NOT NULL DEFAULT '0',
  `user_password_failure_last_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `user_email_UNIQUE` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `user_onInsert` BEFORE INSERT ON user FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
SET new.user_confirmation_code_datetime_sent = NOW() */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `version`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `version` (
  `version_id` int(11) NOT NULL AUTO_INCREMENT,
  `library_id` int(11) NOT NULL,
  `version_name` varchar(255) NOT NULL,
  `version_release_notes` varchar(255) DEFAULT NULL,
  `version_number_of_fixes` int(11) NOT NULL DEFAULT '0',
  `version_number_of_security_fixes` int(11) NOT NULL DEFAULT '0',
  `version_release_date` date NOT NULL,
  PRIMARY KEY (`version_id`),
  UNIQUE KEY `version_id_UNIQUE` (`version_id`),
  KEY `library_id_idx` (`library_id`),
  KEY `version_release_date` (`version_release_date`),
  CONSTRAINT `fK_version_library` FOREIGN KEY (`library_id`) REFERENCES `library` (`library_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `version_queue`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `version_queue` (
  `version_queue_id` int(11) NOT NULL AUTO_INCREMENT,
  `library_id` int(11) NOT NULL,
  `version_queue_name` varchar(255) NOT NULL,
  `version_queue_release_notes` varchar(255) DEFAULT NULL,
  `version_queue_number_of_fixes` int(11) NOT NULL DEFAULT '0',
  `version_queue_number_of_security_fixes` int(11) NOT NULL DEFAULT '0',
  `version_queue_release_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`version_queue_id`),
  UNIQUE KEY `version_queue_id_UNIQUE` (`version_queue_id`),
  KEY `library_id_idx` (`library_id`),
  KEY `fk_version_queue_user_idx` (`user_id`),
  CONSTRAINT `fK_version_queue_library` FOREIGN KEY (`library_id`) REFERENCES `library` (`library_id`),
  CONSTRAINT `fk_version_queue_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-12 11:06:09
