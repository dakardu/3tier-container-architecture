/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.5.29-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: app_web
-- ------------------------------------------------------
-- Server version	10.5.29-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  `rol` varchar(20) DEFAULT 'usuario',
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Dakardu','Dagoberto Duran Montoya','unodago@gmail.com','$2y$10$fR8yYGMQPjaQ2WKFE04AxOT3r/9dfP1LR/Pns0Gwrxami5l5azQiu','2025-07-11 20:44:18','admin'),(2,'Carsan','Carlos Sanchez','unocarsan@gmail.com','$2y$10$kUjZuSyu8Dve97lKHuZ9C.P56BS8sr1eJvcaMUOye/Qs1NFelHRhy','2025-07-11 23:04:30','admin'),(6,'Juanes','Juan Esteban Duran','juanesduran@gmail.com','$2y$10$Dn1GzOBaLBGU.B8PHVUAPOf61woToleU6qGldUB2h93odhASsm7ju','2025-07-19 21:45:16','usuario'),(7,'Dani','Daniel Duran','micheldaniel@gmail.com','$2y$12$tNh0aKWlP0ezP8DK0gwBce5dwZHcKgs790p3DEzMps6jS3euOs6Ii','2025-07-19 23:29:08','usuario'),(8,'Luzmedu','Luz Mery Duran','luzmedu@gmail.com','$2y$10$Ka1/VnBFnku8XA9xAWeYHO58V/FJnYtgz.KuDRJvVDo3ynRWml/Ca','2025-07-26 17:16:29','usuario'),(9,'Maria','Maria del Carme Montoya Rodriguez','maricmontoya@gmail.com','$2y$10$PcJynByQqm1iyn70MHjHP.eYz6jCs1T7w91ve4c9TyHXCK6YLMCMu','2025-07-26 17:31:22','usuario'),(10,'Dago','Dagoberto Duran Lopez','dosdago@gmail.com','$2y$10$LapZOleA.xXzE3JFgZ8cPeORMZ7UVApJaExXXFu.VXpbhit38LkHu','2025-07-26 23:20:37','usuario');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-06 17:35:14
