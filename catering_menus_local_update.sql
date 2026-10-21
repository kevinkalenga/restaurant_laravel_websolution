-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: restaurant_websolution
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.24.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `catering_menus`
--
-- WHERE:  id IN (1,2)

LOCK TABLES `catering_menus` WRITE;
/*!40000 ALTER TABLE `catering_menus` DISABLE KEYS */;
INSERT INTO `catering_menus` VALUES (1,'Menu gourmand classique','menu-gourmand-classique','Menu complet avec entrée, plat et dessert, préparé avec des produits frais.','catering-menus/kSJHpi5JQFSQrLas0rDkJA8MaoT1N0GNQzPcFZUq.jpg',50.00,2,'classique','classique',10,24,'Conserver au réfrigérateur entre 0 et 4 °C. À consommer rapidement après livraison.','Toute commande doit être passée au moins 24 heures à l\'avance.',1,'2026-10-11 22:45:31','2026-10-14 22:45:14'),(2,'Menu gourmand classique 2','menu-gourmand-classique-2','Easily generate Lorem Ipsum placeholder text in any number of characters, words sentences or paragraphs. Learn about the origins of the passage and its history, from the Roman era to today.Easily generate Lorem Ipsum placeholder text in any number of characters, words sentences or paragraphs. Learn about the origins of the passage and its history, from the Roman era to today.','catering-menus/xLnOv9lIRXoKMFjAyZiDslpNb1u21DPgaMBTxZT6.jpg',55.20,3,'classique','classique',15,24,'hot place','Easily generate Lorem Ipsum placeholder text in any number of characters, words sentences or paragraphs.',1,'2026-10-11 23:13:40','2026-10-11 23:13:40') ON DUPLICATE KEY UPDATE title=VALUES(title), slug=VALUES(slug), description=VALUES(description), image=VALUES(image), price=VALUES(price), minimum_persons=VALUES(minimum_persons), theme=VALUES(theme), diet=VALUES(diet), available_stock=VALUES(available_stock), advance_notice_hours=VALUES(advance_notice_hours), storage_conditions=VALUES(storage_conditions), order_conditions=VALUES(order_conditions), status=VALUES(status), created_at=VALUES(created_at), updated_at=VALUES(updated_at);
/*!40000 ALTER TABLE `catering_menus` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-20  2:28:43
