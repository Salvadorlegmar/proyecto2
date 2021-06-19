-- MySQL dump 10.13  Distrib 5.7.34, for Linux (x86_64)
--
-- Host: localhost    Database: Cella2
-- ------------------------------------------------------
-- Server version	5.7.34-0ubuntu0.18.04.1

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
-- Table structure for table `casos`
--

DROP TABLE IF EXISTS `casos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `casos` (
  `ID_CASO` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Trazabilidad_hospital` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Fecha_hora_de_alta` datetime NOT NULL,
  PRIMARY KEY (`ID_CASO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `casos`
--

LOCK TABLES `casos` WRITE;
/*!40000 ALTER TABLE `casos` DISABLE KEYS */;
/*!40000 ALTER TABLE `casos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modelos`
--

DROP TABLE IF EXISTS `modelos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modelos` (
  `ID_MODELO` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_CASO` int(10) unsigned NOT NULL,
  `Nombre_del_modelo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tipo` enum('hepatico','pancreatico','colorrectal','tiroides','otro') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Fecha_hora_de_alta` datetime NOT NULL,
  PRIMARY KEY (`ID_MODELO`),
  KEY `ID_CASO` (`ID_CASO`),
  CONSTRAINT `modelos_ibfk_1` FOREIGN KEY (`ID_CASO`) REFERENCES `casos` (`ID_CASO`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modelos`
--

LOCK TABLES `modelos` WRITE;
/*!40000 ALTER TABLE `modelos` DISABLE KEYS */;
/*!40000 ALTER TABLE `modelos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stls`
--

DROP TABLE IF EXISTS `stls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stls` (
  `ID_STL` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_MODELO` int(10) unsigned NOT NULL,
  `ID_CASO` int(10) unsigned NOT NULL,
  `Nombre_del_elemento` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Color` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Visible` tinyint(1) NOT NULL,
  `Transparencia` int(10) unsigned NOT NULL,
  `Orden` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID_STL`),
  KEY `ID_CASO` (`ID_CASO`),
  KEY `ID_MODELO` (`ID_MODELO`),
  CONSTRAINT `stls_ibfk_1` FOREIGN KEY (`ID_CASO`) REFERENCES `casos` (`ID_CASO`),
  CONSTRAINT `stls_ibfk_2` FOREIGN KEY (`ID_MODELO`) REFERENCES `modelos` (`ID_MODELO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stls`
--

LOCK TABLES `stls` WRITE;
/*!40000 ALTER TABLE `stls` DISABLE KEYS */;
/*!40000 ALTER TABLE `stls` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-18 21:35:10
