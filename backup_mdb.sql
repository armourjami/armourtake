-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: mdb
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

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
-- Table structure for table `Contacts`
--

DROP TABLE IF EXISTS `Contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Contacts` (
  `user` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contactName` varchar(45) NOT NULL,
  `phoneNumber` varchar(45) DEFAULT NULL,
  `cellNumber` varchar(45) DEFAULT NULL,
  `faxNumber` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `Address` varchar(45) DEFAULT NULL,
  `Suppliers_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Contacts_users` (`user`),
  KEY `fk_Contacts_Suppliers` (`Suppliers_id`),
  CONSTRAINT `fk_Contacts_Suppliers` FOREIGN KEY (`Suppliers_id`) REFERENCES `Suppliers` (`id`),
  CONSTRAINT `fk_Contacts_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Contacts`
--

LOCK TABLES `Contacts` WRITE;
/*!40000 ALTER TABLE `Contacts` DISABLE KEYS */;
INSERT INTO `Contacts` VALUES (1,1,'John Hancock','042372700','0212345678','042371223','john@bidvest.co.nz','Wellington',1);
/*!40000 ALTER TABLE `Contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Dietary`
--

DROP TABLE IF EXISTS `Dietary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Dietary` (
  `user` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `fk_Dietary_users` (`user`),
  CONSTRAINT `fk_Dietary_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Dietary`
--

LOCK TABLES `Dietary` WRITE;
/*!40000 ALTER TABLE `Dietary` DISABLE KEYS */;
INSERT INTO `Dietary` VALUES (1,1,'None','No dietary requirememnts'),(1,2,'Vegan','No animal products'),(1,3,'Vegetarian','No meat'),(1,4,'Gluten free','No Flour or products conducts containing gluten'),(1,5,'Dairy free','No Dairy products'),(1,6,'No Seafood',''),(1,7,'Nut free','Does not contain nuts');
/*!40000 ALTER TABLE `Dietary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DishDietary`
--

DROP TABLE IF EXISTS `DishDietary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DishDietary` (
  `user` int(11) NOT NULL,
  `Dietary_id` int(11) NOT NULL,
  `Dishes_id` int(11) NOT NULL,
  KEY `fk_DishDietary_Dietary` (`Dietary_id`),
  KEY `fk_DishDietary_Dishes` (`Dishes_id`),
  KEY `fk_DishDietary_users` (`user`),
  CONSTRAINT `fk_DishDietary_Dietary` FOREIGN KEY (`Dietary_id`) REFERENCES `Dietary` (`id`),
  CONSTRAINT `fk_DishDietary_Dishes` FOREIGN KEY (`Dishes_id`) REFERENCES `Dishes` (`id`),
  CONSTRAINT `fk_DishDietary_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DishDietary`
--

LOCK TABLES `DishDietary` WRITE;
/*!40000 ALTER TABLE `DishDietary` DISABLE KEYS */;
INSERT INTO `DishDietary` VALUES (1,1,1);
/*!40000 ALTER TABLE `DishDietary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DishProducts`
--

DROP TABLE IF EXISTS `DishProducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DishProducts` (
  `user` int(11) NOT NULL,
  `Products_id` int(11) NOT NULL,
  `Dishes_id` int(11) NOT NULL,
  KEY `fk_DishProducts_users` (`user`),
  KEY `fk_DishProducts_Products` (`Products_id`),
  KEY `fk_DishProducts_Dishes` (`Dishes_id`),
  CONSTRAINT `fk_DishProducts_Dishes` FOREIGN KEY (`Dishes_id`) REFERENCES `Recipes` (`id`),
  CONSTRAINT `fk_DishProducts_Products` FOREIGN KEY (`Products_id`) REFERENCES `Products` (`id`),
  CONSTRAINT `fk_DishProducts_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DishProducts`
--

LOCK TABLES `DishProducts` WRITE;
/*!40000 ALTER TABLE `DishProducts` DISABLE KEYS */;
/*!40000 ALTER TABLE `DishProducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DishRecipes`
--

DROP TABLE IF EXISTS `DishRecipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DishRecipes` (
  `user` int(11) NOT NULL,
  `Dishes_id` int(11) NOT NULL,
  `Recipes_id` int(11) NOT NULL,
  KEY `fk_DishRecipes_users` (`user`),
  KEY `fk_DishRecipes_Dishes` (`Dishes_id`),
  KEY `fk_DishRecipes_Recipes` (`Recipes_id`),
  CONSTRAINT `fk_DishRecipes_Dishes` FOREIGN KEY (`Dishes_id`) REFERENCES `Dishes` (`id`),
  CONSTRAINT `fk_DishRecipes_Recipes` FOREIGN KEY (`Recipes_id`) REFERENCES `Recipes` (`id`),
  CONSTRAINT `fk_DishRecipes_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DishRecipes`
--

LOCK TABLES `DishRecipes` WRITE;
/*!40000 ALTER TABLE `DishRecipes` DISABLE KEYS */;
INSERT INTO `DishRecipes` VALUES (1,1,1);
/*!40000 ALTER TABLE `DishRecipes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Dishes`
--

DROP TABLE IF EXISTS `Dishes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Dishes` (
  `user` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dishName` varchar(45) DEFAULT NULL,
  `dishPrice` decimal(13,2) NOT NULL COMMENT 'including GST\n',
  `costPrice` decimal(13,2) NOT NULL COMMENT 'cost price of food ex get\n',
  `margin` decimal(4,2) NOT NULL COMMENT 'as a percentage',
  `yeild` int(3) NOT NULL COMMENT 'number of dishes\n',
  `grossRevenue` decimal(13,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Dishes_users` (`user`),
  CONSTRAINT `fk_Dishes_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Dishes`
--

LOCK TABLES `Dishes` WRITE;
/*!40000 ALTER TABLE `Dishes` DISABLE KEYS */;
INSERT INTO `Dishes` VALUES (1,1,'Cupcakes with tomato sauce',6.00,2.00,65.00,12,4.00);
/*!40000 ALTER TABLE `Dishes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductRecipes`
--

DROP TABLE IF EXISTS `ProductRecipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductRecipes` (
  `user` int(11) NOT NULL,
  `Products_id` int(11) NOT NULL,
  `Recipes_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '1.00',
  `unit` varchar(45) DEFAULT NULL COMMENT 'Portion, Litre etc',
  KEY `fk_ProductRecipes_users` (`user`),
  KEY `fk_ProductRecipes_Products` (`Products_id`),
  KEY `fk_ProductRecipes_Recipes` (`Recipes_id`),
  CONSTRAINT `fk_ProductRecipes_Products` FOREIGN KEY (`Products_id`) REFERENCES `Products` (`id`),
  CONSTRAINT `fk_ProductRecipes_Recipes` FOREIGN KEY (`Recipes_id`) REFERENCES `Recipes` (`id`),
  CONSTRAINT `fk_ProductRecipes_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductRecipes`
--

LOCK TABLES `ProductRecipes` WRITE;
/*!40000 ALTER TABLE `ProductRecipes` DISABLE KEYS */;
INSERT INTO `ProductRecipes` VALUES (1,1,1,21.00,'Loaf'),(1,2,1,5.00,'Kilo');
/*!40000 ALTER TABLE `ProductRecipes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Products`
--

DROP TABLE IF EXISTS `Products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Products` (
  `user` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(45) NOT NULL,
  `purchaseUnit` varchar(45) NOT NULL,
  `purchaseUnitPrice` decimal(13,2) unsigned NOT NULL,
  `purchaseUnitWeight` decimal(13,2) unsigned NOT NULL,
  `yeild` int(3) unsigned NOT NULL DEFAULT '100',
  `costPerKiloUnit` decimal(13,2) unsigned NOT NULL,
  `density` float unsigned NOT NULL DEFAULT '1',
  `discount` decimal(10,0) unsigned NOT NULL DEFAULT '0',
  `Suppliers_id` int(11) NOT NULL,
  `unitName` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Products_users` (`user`),
  KEY `fk_Products_Suppliers` (`Suppliers_id`),
  KEY `fk_Products_Unit` (`unitName`),
  CONSTRAINT `fk_Products_Suppliers` FOREIGN KEY (`Suppliers_id`) REFERENCES `Suppliers` (`id`),
  CONSTRAINT `fk_Products_Unit` FOREIGN KEY (`unitName`) REFERENCES `Unit` (`Name`),
  CONSTRAINT `fk_Products_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Products`
--

LOCK TABLES `Products` WRITE;
/*!40000 ALTER TABLE `Products` DISABLE KEYS */;
INSERT INTO `Products` VALUES (1,1,'Bread','Loaf',2.00,1.00,100,2.00,1,0,1,'Loaf'),(1,2,'Milk','2L Bottle',3.95,2.00,100,2.00,1,0,1,'Litre');
/*!40000 ALTER TABLE `Products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recipes`
--

DROP TABLE IF EXISTS `Recipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recipes` (
  `user` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yeild` decimal(5,2) NOT NULL DEFAULT '1.00',
  `yeildUnit` varchar(20) NOT NULL,
  `method` mediumtext,
  `recipeName` varchar(45) DEFAULT NULL,
  `recipeCost` decimal(13,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Recipes_users` (`user`),
  KEY `fk_Recipes_Unit` (`yeildUnit`),
  CONSTRAINT `fk_Recipes_Unit` FOREIGN KEY (`yeildUnit`) REFERENCES `Unit` (`Name`),
  CONSTRAINT `fk_Recipes_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recipes`
--

LOCK TABLES `Recipes` WRITE;
/*!40000 ALTER TABLE `Recipes` DISABLE KEYS */;
INSERT INTO `Recipes` VALUES (1,1,12.00,'Portion','1.) Put and egg on it. &#13;&#10;2.) Roast it&#13;&#10;3.) Stick it in a stew','Eggy Cupcakes',52.00);
/*!40000 ALTER TABLE `Recipes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Suppliers`
--

DROP TABLE IF EXISTS `Suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Suppliers` (
  `user` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplierName` varchar(45) NOT NULL,
  `phoneNumber` varchar(45) DEFAULT NULL,
  `faxNumber` varchar(45) DEFAULT NULL,
  `emailAddress` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `cutOffOrderTime` time DEFAULT NULL,
  `turnAroundDeliveryTime` varchar(45) DEFAULT NULL,
  `dateOfEntry` date NOT NULL,
  `freightCharge` decimal(13,4) unsigned NOT NULL DEFAULT '0.0000',
  `reliability` int(2) unsigned DEFAULT NULL,
  `deliveryTime` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Suppliers_users` (`user`),
  CONSTRAINT `fk_Suppliers_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Suppliers`
--

LOCK TABLES `Suppliers` WRITE;
/*!40000 ALTER TABLE `Suppliers` DISABLE KEYS */;
INSERT INTO `Suppliers` VALUES (1,1,'Bidvest','042372700','042372701','bidvest@bidvest.co.nz','Palmerston North','24:00:00','6:30:00','2016-02-06',6.0000,90,'6:30:00');
/*!40000 ALTER TABLE `Suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Unit`
--

DROP TABLE IF EXISTS `Unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Unit` (
  `user` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Ratio` decimal(4,2) unsigned NOT NULL,
  `UnitType` varchar(5) NOT NULL,
  PRIMARY KEY (`Name`),
  UNIQUE KEY `Name` (`Name`),
  KEY `fk_Unit_users` (`user`),
  KEY `fk_Unit_UnitType` (`UnitType`),
  CONSTRAINT `fk_Unit_UnitType` FOREIGN KEY (`UnitType`) REFERENCES `UnitType` (`UnitName`),
  CONSTRAINT `fk_Unit_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Unit`
--

LOCK TABLES `Unit` WRITE;
/*!40000 ALTER TABLE `Unit` DISABLE KEYS */;
INSERT INTO `Unit` VALUES (1,'2L Bottle',2.00,'Litre'),(1,'Cup',0.25,'Litre'),(1,'Kilo',1.00,'Kilo'),(1,'Litre',1.00,'Litre'),(1,'Loaf',1.00,'Each'),(1,'Portion',1.00,'Each');
/*!40000 ALTER TABLE `Unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UnitType`
--

DROP TABLE IF EXISTS `UnitType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UnitType` (
  `UnitName` varchar(5) NOT NULL,
  PRIMARY KEY (`UnitName`),
  UNIQUE KEY `UnitName` (`UnitName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UnitType`
--

LOCK TABLES `UnitType` WRITE;
/*!40000 ALTER TABLE `UnitType` DISABLE KEYS */;
INSERT INTO `UnitType` VALUES ('Each'),('Kilo'),('Litre');
/*!40000 ALTER TABLE `UnitType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Standard user',''),(2,'Administrator','{\"admin\": 1}');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dateofbirth` date NOT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','?É¶‰EsŒˆ£¤Š©ã5Bkz@Ràª¥6ü§HË','íyÅ9HÒý‹A¨² Ûˆ)­Aï3-Ór>Lp†¸','admin','admin','jamie@jamie.com','1984-12-21','2016-02-06 00:00:00',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_session`
--

DROP TABLE IF EXISTS `users_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_session`
--

LOCK TABLES `users_session` WRITE;
/*!40000 ALTER TABLE `users_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_session` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-10  7:28:46
