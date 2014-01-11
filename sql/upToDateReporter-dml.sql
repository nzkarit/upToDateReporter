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
-- Dumping data for table `library`
--

LOCK TABLES `library` WRITE;
/*!40000 ALTER TABLE `library` DISABLE KEYS */;
INSERT INTO `library` (`library_id`, `library_name`, `library_eol`, `library_url`, `library_eol_date`) VALUES (1,'as<\'>\"df',0,'asdf',NULL),(2,'Java 5',1,'http://www.oracle.com/technetwork/java/javase/index-jsp-135232.html','2009-11-04'),(6,'Java 6',1,'http://www.oracle.com/technetwork/java/javase/overview/index-jsp-136246.html','2013-04-16'),(7,'Java 7',0,'http://www.oracle.com/technetwork/java/javase/index.html',NULL),(9,'sdf',0,'http://www.oracle.com/technetwork/java/javase/downloads/index.html',NULL),(10,'werqwer',0,'http://www.oracle.com/technetwork/java/javase/overview/index-jsp-136246.html',NULL),(11,'dsfsdf',0,'http://www.oracle.com/technetwork/java/javase/downloads/index.html',NULL),(12,'werqwerqwer',0,'http://www.oracle.com/technetwork/java/javase/downloads/index.html',NULL),(13,'sdafasdf',0,'http://www.oracle.com/technetwork/java/javase/overview/index-jsp-136246.html',NULL),(14,'1',0,'http://www.oracle.com/technetwork/java/javase/downloads/index.html',NULL),(15,'3',0,'http://www.oracle.com/technetwork/java/javase/overview/index-jsp-136246.html',NULL),(16,'2',0,'http://www.oracle.com/technetwork/java/javase/overview/index-jsp-136246.html',NULL),(17,'234234',0,'http://www.oracle.com/technetwork/java/javase/overview/index-jsp-136246.html',NULL),(18,'sdfwer',0,'http://www.oracle.com/technetwork/java/javase/downloads/index.html',NULL),(19,'345345',0,'http://www.oracle.com/technetwork/java/javase/overview/index-jsp-136246.html',NULL),(20,'v534534',0,'http://www.oracle.com/technetwork/java/javase/index-jsp-135232.html',NULL);
/*!40000 ALTER TABLE `library` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `version`
--

LOCK TABLES `version` WRITE;
/*!40000 ALTER TABLE `version` DISABLE KEYS */;
INSERT INTO `version` (`version_id`, `library_id`, `version_name`, `version_release_notes`, `version_number_of_fixes`, `version_number_of_security_fixes`, `version_release_date`) VALUES (1,1,'as<>\"df','http://example.com',1,1,'2013-12-30'),(2,6,'1.6.0_45','http://www.oracle.com/technetwork/java/javase/6u45-relnotes-1932876.html',42,42,'2013-04-16'),(3,6,'1.6.0_43','http://www.oracle.com/technetwork/java/javase/6u43-relnotes-1915290.html',2,2,'2013-03-04'),(4,6,'1.6.0_41','http://www.oracle.com/technetwork/java/javase/6u41-relnotes-1907743.html',5,5,'2013-03-04'),(5,6,'1.6.0_39','http://www.oracle.com/technetwork/java/javase/6u39-relnotes-1902886.html',50,50,'2013-02-01'),(6,2,'1.5.0_22','http://www.oracle.com/technetwork/java/javase/releasenotes-142123.html#150_22',28,4,'2009-11-04'),(7,6,'1.6.0_38','http://www.oracle.com/technetwork/java/javase/6u38-relnotes-1880997.html',0,0,'2012-12-11'),(8,6,'1.6.0_37','http://www.oracle.com/technetwork/java/javase/6u37-relnotes-1863283.html',30,30,'2012-10-16'),(9,6,'1.6.0_35','http://www.oracle.com/technetwork/java/javase/6u35-relnotes-1835788.html',0,0,'2012-08-30'),(10,6,'1.6.0_34','http://www.oracle.com/technetwork/java/javase/6u34-relnotes-1729733.html',0,0,'2012-08-14'),(11,6,'1.6.0_33','http://www.oracle.com/technetwork/java/javase/6u33-relnotes-1653258.html',14,14,'2012-06-12'),(12,6,'1.6.0_32','http://www.oracle.com/technetwork/java/javase/6u32-relnotes-1578471.html',0,0,'2012-04-26'),(13,6,'1.6.0_31','http://www.oracle.com/technetwork/java/javase/6u31-relnotes-1482342.html',15,14,'2012-02-14'),(14,6,'1.6.0_30','http://www.oracle.com/technetwork/java/javase/6u30-relnotes-1394870.html',0,0,'2011-12-12'),(15,6,'1.6.0_29','http://www.oracle.com/technetwork/java/javase/6u29-relnotes-507960.html',20,20,'2011-10-18'),(16,6,'1.6.0_27','http://www.oracle.com/technetwork/java/javase/6u27-relnotes-444147.html',0,0,'2011-08-16'),(17,6,'1.6.0_26','http://www.oracle.com/technetwork/java/javase/6u26releasenotes-401875.html',17,17,'2011-06-17'),(18,6,'1.6.0_25','http://www.oracle.com/technetwork/java/javase/6u25releasenotes-356444.html',0,0,'2011-03-21'),(19,7,'1.7.0_45','http://www.oracle.com/technetwork/java/javase/7u45-relnotes-2016950.html',51,51,'2013-10-15'),(20,7,'1.7.0_40','http://www.oracle.com/technetwork/java/javase/7u40-relnotes-2004172.html',621,0,'2013-09-10'),(21,7,'1.7.0_25','http://www.oracle.com/technetwork/java/javase/7u25-relnotes-1955741.html',40,40,'2013-06-18'),(22,7,'1.7.0_21','http://www.oracle.com/technetwork/java/javase/7u21-relnotes-1932873.html',42,42,'2013-04-16'),(23,7,'1.7.0_17','http://www.oracle.com/technetwork/java/javase/7u17-relnotes-1915289.html',2,2,'2013-03-04'),(24,1,'sdfasdf','http://www.oracle.com/technetwork/java/javase/6u25releasenotes-356444.html',0,0,'2014-01-02'),(25,1,'1.6.0_26','http://example.com',0,0,'2014-01-02'),(26,1,'34534','http://example.com',10,5,'2014-01-02'),(27,1,'wqerweqr','http://www.oracle.com/technetwork/java/javase/6u25releasenotes-356444.html',0,0,'2014-01-02'),(28,14,'4b 64ewb6','http://www.oracle.com/technetwork/java/javase/6u25releasenotes-356444.html',0,0,'2014-01-02'),(29,11,'4b5345','http://example.com',0,0,'2014-01-02');
/*!40000 ALTER TABLE `version` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-12 11:10:57
