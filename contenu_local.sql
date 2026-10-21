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
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` VALUES (5,'uploads/media_6965a3a150f95.png','50% off','Delicious Summer Menu','Fresh ingredients, bold flavors','Savor our chef’s special summer dishes, made from the freshest seasonal ingredients. Perfect for a family dinner or a romantic evening','http://127.0.0.1:8000/products',1,'2026-01-13 00:45:05','2026-10-05 22:46:21'),(6,'uploads/media_6965a40bba29f.png','70% off','Different spice for a Different taste','Fast Food & Restaurants','Savor our chef’s special summer dishes, made from the freshest seasonal ingredients. Perfect for a family dinner or a romantic evening.','http://127.0.0.1:8000/products',1,'2026-01-13 00:46:51','2026-10-05 22:46:39'),(7,'uploads/media_6965a6008d44c.png','60% off','Eat healthy. Stay healthy.','Fast Food & Restaurants','Savor our chef’s special summer dishes, made from the freshest seasonal ingredients. Perfect for a family dinner or a romantic evening','http://127.0.0.1:8000/products',1,'2026-01-13 00:55:12','2026-10-05 22:46:53');
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site_name','Vite&Gourmand','2026-04-16 07:48:03','2026-10-08 06:28:00'),(2,'site_default_currency','USD','2026-04-16 07:48:03','2026-04-17 07:05:39'),(3,'site_currency_icon','$','2026-04-16 07:48:03','2026-04-17 09:16:42'),(4,'site_currency_icon_position','left','2026-04-16 07:48:03','2026-04-17 08:41:28'),(5,'pusher_app_id','2188148','2026-08-21 21:22:06','2026-08-21 21:22:06'),(6,'pusher_key','2bb0533cd4ec34741b0a','2026-08-21 21:22:06','2026-08-21 21:22:06'),(7,'pusher_secret','c909cee85d5f7525da44','2026-08-21 21:22:06','2026-08-21 21:22:06'),(8,'pusher_cluster','eu','2026-08-21 21:22:06','2026-08-21 21:22:06'),(9,'mail_driver','smtp','2026-09-29 09:45:22','2026-09-29 10:27:06'),(10,'mail_host','smtp.gmail.com','2026-09-29 09:45:22','2026-09-29 10:27:06'),(11,'mail_port','587','2026-09-29 09:45:22','2026-09-29 10:27:06'),(12,'mail_username','kevinkalenga10@gmail.com','2026-09-29 09:45:22','2026-09-29 10:27:06'),(13,'mail_password','dbguyrtbiofvfatr','2026-09-29 09:45:22','2026-09-29 10:27:06'),(14,'mail_encryption','tls','2026-09-29 09:45:22','2026-09-29 10:27:06'),(15,'mail_from_address','kevinkalenga10@gmail.com','2026-09-29 09:45:22','2026-09-29 10:27:06'),(16,'mail_receive_address','kevinkalenga10@gmail.com','2026-09-29 09:45:22','2026-09-29 19:37:20'),(17,'logo','uploads/media_6ac5860292f2f.png','2026-10-06 21:36:34','2026-10-06 21:36:34'),(18,'footer_logo','uploads/media_6ac586029e360.png','2026-10-06 21:36:34','2026-10-06 21:36:34'),(19,'favicon','uploads/media_6ac58602a1b37.png','2026-10-06 21:36:34','2026-10-06 21:36:34'),(20,'breadcrumb','uploads/media_6ac598ff72968.jpg','2026-10-06 21:38:08','2026-10-06 22:57:35'),(21,'site_email','vite&gourmand0033@gmail.com','2026-10-07 21:15:47','2026-10-07 21:29:01'),(22,'site_phone','+96487452145214','2026-10-07 21:15:47','2026-10-07 21:15:47'),(23,'site_color','#f86f03','2026-10-07 22:13:18','2026-10-07 22:13:18'),(24,'seo_title','Vite&Gourmand','2026-10-08 06:42:37','2026-10-08 08:30:40'),(25,'seo_description','Restaurant','2026-10-08 06:42:37','2026-10-08 08:30:40'),(26,'seo_keyword','hello','2026-10-08 06:42:37','2026-10-08 08:19:20');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `counters`
--

LOCK TABLES `counters` WRITE;
/*!40000 ALTER TABLE `counters` DISABLE KEYS */;
INSERT INTO `counters` VALUES (1,'uploads/media_6ab31e19390c0.jpg','fas fa-align-justify','85,000','customer serve','fas fa-allergies','120','experience chef','fas fa-archway','72,000','happy customer','fas fa-birthday-cake','30','winning award','2026-09-22 21:55:16','2026-09-22 22:32:25');
/*!40000 ALTER TABLE `counters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `why_choose_us`
--

LOCK TABLES `why_choose_us` WRITE;
/*!40000 ALTER TABLE `why_choose_us` DISABLE KEYS */;
INSERT INTO `why_choose_us` VALUES (4,'fas fa-align-center','discount voucher','Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, debitis expedita .',1,'2026-03-10 13:53:38','2026-04-03 19:52:50'),(5,'fas fa-archive','fresh healthy foods','Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, debitis expedita .',1,'2026-03-10 13:57:25','2026-03-10 13:57:25'),(6,'fas fa-birthday-cake','fast serve on table','Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, debitis expedita .',1,'2026-03-10 13:58:10','2026-03-10 13:58:10');
/*!40000 ALTER TABLE `why_choose_us` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `section_titles`
--

LOCK TABLES `section_titles` WRITE;
/*!40000 ALTER TABLE `section_titles` DISABLE KEYS */;
INSERT INTO `section_titles` VALUES (4,'daily_offer_top_title','Daily offer','2026-09-16 09:30:47','2026-09-16 09:32:55'),(5,'daily_offer_main_title','up to 75% off for this day','2026-09-16 09:30:47','2026-09-16 09:30:47'),(6,'daily_offer_sub_title','Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.','2026-09-16 09:30:47','2026-09-16 09:30:47'),(7,'why_choose_top_title','why choose us','2026-09-16 09:38:44','2026-09-16 09:38:44'),(8,'why_choose_main_title','why choose us','2026-09-16 09:38:44','2026-09-16 09:38:44'),(9,'why_choose_sub_title','Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.','2026-09-16 09:38:44','2026-09-16 09:38:44'),(12,'chef_top_title','our team','2026-09-19 10:30:41','2026-09-19 10:30:41'),(13,'chef_main_title','meet our expert chefs','2026-09-19 10:30:41','2026-09-19 10:30:41'),(14,'chef_sub_title','Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.','2026-09-19 10:30:41','2026-09-19 10:30:41'),(15,'testimonial_top_title','testimonial','2026-09-21 06:55:55','2026-09-21 06:55:55'),(16,'testimonial_main_title','our customar feedbacks','2026-09-21 06:55:55','2026-09-21 06:55:55'),(17,'testimonial_sub_title','Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.','2026-09-21 06:55:55','2026-09-21 06:55:55');
/*!40000 ALTER TABLE `section_titles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `footer_infos`
--

LOCK TABLES `footer_infos` WRITE;
/*!40000 ALTER TABLE `footer_infos` DISABLE KEYS */;
INSERT INTO `footer_infos` VALUES (1,'There are many variations of Lorem Ipsum available, but the majority have suffered.','7232 Broadway Suite 308, Jackson Heights, 11372, NY, United States','+1347-430-9510','vite&gourmand0033@gmail.com','© 2026 Vite&Gourmand — Tous droits réservés.','2026-10-02 10:46:35','2026-10-03 06:58:52');
/*!40000 ALTER TABLE `footer_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `social_links`
--

LOCK TABLES `social_links` WRITE;
/*!40000 ALTER TABLE `social_links` DISABLE KEYS */;
INSERT INTO `social_links` VALUES (3,'fab fa-facebook-f','Facebook','https://facebook.com',1,'2026-10-02 07:36:49','2026-10-02 07:36:49'),(4,'fab fa-twitter','Twitter','https://x.com',1,'2026-10-02 07:37:30','2026-10-02 07:37:30'),(5,'fab fa-linkedin-in','Linkedin','https://linkedin.com',1,'2026-10-02 07:39:06','2026-10-02 07:39:06'),(6,'fab fa-instagram','Instagram','https://instagram.com',1,'2026-10-02 07:40:00','2026-10-02 07:40:00'),(7,'fab fa-behance','Behance','https://behance.com',1,'2026-10-02 07:52:02','2026-10-02 07:52:02');
/*!40000 ALTER TABLE `social_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `banner_sliders`
--

LOCK TABLES `banner_sliders` WRITE;
/*!40000 ALTER TABLE `banner_sliders` DISABLE KEYS */;
INSERT INTO `banner_sliders` VALUES (1,'Red Chicken','Lorem Ipsum dolor sit amet consectetur','http://127.0.0.1:8000/','uploads/media_6aac95027c625.png',1,'2026-09-17 22:19:06','2026-09-18 00:39:08'),(5,'Red Chicken','Lorem Ipsum dolor sit amet consectetur','http://127.0.0.1:8000/','uploads/media_6aac9fe1a23f7.png',1,'2026-09-18 00:20:17','2026-09-18 00:39:40'),(6,'Red Chicken','Lorem Ipsum dolor sit amet consectetur','http://127.0.0.1:8000/','uploads/media_6aaca003e8dd9.png',1,'2026-09-18 00:20:51','2026-09-18 00:39:49'),(7,'Red Chicken','Lorem Ipsum dolor sit amet consectetur','http://127.0.0.1:8000/','uploads/media_6aaca024b392d.png',1,'2026-09-18 00:21:24','2026-09-18 00:39:59');
/*!40000 ALTER TABLE `banner_sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES (1,'uploads/media_6aafeb79ebde7.png','Israt Jahan','NYC USA','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque assumenda tenetur, provident earum consequatur, ut voluptas laboriosam fuga error aut eaque architecto quo pariatur. Vel dolore omnis quisquam.',3,1,1,'2026-09-20 12:19:37','2026-09-20 12:19:37'),(2,'uploads/media_6aafec2659fbf.png','Jean Louis','Paris France','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque assumenda tenetur, provident earum consequatur, ut voluptas laboriosam fuga error aut eaque architecto quo pariatur. Vel dolore omnis quisquam. .',4,1,1,'2026-09-20 12:22:30','2026-09-20 12:22:30'),(3,'uploads/media_6aafed7f5b513.jpg','Cissoko Diallo','Bamako Malia','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque assumenda tenetur, provident earum consequatur, ut voluptas laboriosam fuga error aut eaque architecto quo pariatur. Vel dolore omnis quisquam.',5,1,1,'2026-09-20 12:28:15','2026-09-20 12:28:15'),(4,'uploads/media_6ab0e686b2683.jpg','Sofía García','Madrid Spain','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque assumenda tenetur, provident earum consequatur, ut voluptas laboriosam fuga error aut eaque architecto quo pariatur. Vel dolore omnis quisquam!.',4,1,1,'2026-09-20 12:33:34','2026-09-21 06:10:46'),(6,'uploads/media_6ab10fcaddf6b.jpg','Arno La Paix','Paris France','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque assumenda tenetur, provident earum consequatur, ut voluptas laboriosam fuga error aut eaque architecto quo pariatur. Vel dolore omnis quisquam.',4,1,1,'2026-09-21 09:06:50','2026-09-21 09:53:23'),(7,'uploads/media_6ab1102b8f61d.jpg','Ciara Clear','NYC USA','Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque assumenda tenetur, provident earum consequatur, ut voluptas laboriosam fuga error aut eaque architecto quo pariatur. Vel dolore omnis quisquam.',5,1,1,'2026-09-21 09:08:27','2026-09-21 09:53:07');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `chefs`
--

LOCK TABLES `chefs` WRITE;
/*!40000 ALTER TABLE `chefs` DISABLE KEYS */;
INSERT INTO `chefs` VALUES (1,'uploads/media_6aadbdd579be4.jpg','Naurin Nipu','Senior Chef','https://facebook.com','https://linkedin.com','https://twitter.com','https://website.com',1,1,'2026-09-18 20:40:21','2026-09-18 20:40:21'),(2,'uploads/media_6aadbe6addc1b.jpg','Arun Chandra','Senior Chef','https://facebook.com','https://linkedin.com','https://twitter.com','https://website.com',1,1,'2026-09-18 20:42:50','2026-09-18 20:42:50'),(3,'uploads/media_6aadbecd0e8ad.jpg','Khandakar Rashed','Senior Chef','https://facebook.com','https://linkedin.com','https://twitter.com','https://website.com',1,1,'2026-09-18 20:44:29','2026-09-18 20:44:29'),(4,'uploads/media_6aadbf308977d.jpg','Ismat Jhoa','Senior Chef','https://facebook.com','https://linkedin.com','https://twitter.com','https://website.com',1,1,'2026-09-18 20:46:08','2026-09-18 20:46:08'),(5,'uploads/media_6aadc828b2255.jpg','Isita Rahman','Senior Chef','https://facebook.com','https://linkedin.com','https://twitter.com','https://website.com',1,1,'2026-09-18 20:47:42','2026-09-18 21:24:24'),(6,'uploads/media_6aadc0620d7c1.jpeg','John Essien','Senior Chef','https://facebook.com','https://linkedin.com','https://twitter.com','https://website.com',1,1,'2026-09-18 20:51:14','2026-09-21 06:19:30');
/*!40000 ALTER TABLE `chefs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `abouts`
--

LOCK TABLES `abouts` WRITE;
/*!40000 ALTER TABLE `abouts` DISABLE KEYS */;
INSERT INTO `abouts` VALUES (1,'uploads/media_6ab9b8301e970.jpg','About Company','Helathy Foods Provider','Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cupiditate aspernatur molestiae minima pariatur consequatur voluptate sapiente deleniti soluta, animi ab necessitatibus optio similique quasi fuga impedit corrupti obcaecati neque consequatur sequi.\r\n\r\n<ul>\r\n    <li>Delicious & Healthy Foods</li>\r\n    <li>Spacific Family & Kids Zone</li>\r\n    <li>Best Price & Offers</li>\r\n    <li>Made By Fresh Ingredients</li>\r\n    <li>Music & Other Facilities</li>\r\n    <li>Delicious & Healthy Foods</li>\r\n    <li>Spacific Family & Kids Zone</li>\r\n    <li>Best Price & Offers</li>\r\n    <li>Made By Fresh Ingredients</li>\r\n    <li>Delicious & Healthy Foods</li>\r\n</ul>','https://www.youtube.com/watch?v=kRCH8kD1GD0','2026-09-27 22:43:28','2026-09-28 00:32:27');
/*!40000 ALTER TABLE `abouts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-19  0:48:08
