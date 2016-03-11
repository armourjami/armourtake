
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mdb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mdb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mdb` ;

-- --------------------------------------------------
-- -----login tables---------------------------------
-- --------------------------------------------------
-- -----------------------------------------------------
-- Table `mdb`.`groups`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mdb`.`groups`;

CREATE TABLE IF NOT EXISTS `mdb`.`groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(20) NOT NULL,
  `permissions` text NOT NULL
);

--
-- Dumping data for table `groups`
--

INSERT INTO `mdb`.`groups` (`name`, `permissions`) VALUES
('Standard user', ''),
('Administrator', '{"admin": 1}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- -----------------------------------------------------
-- Table `mdb`.`users`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mdb`.`users`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL UNIQUE,
  `dateofbirth` date NOT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL 
);

-- -------INSERT USERS-------------------------------------
INSERT INTO `users` (`id`, `username`, `password`, `salt`, `name`, `surname`, `email`, `dateofbirth`, `joined`,`group`) VALUES
(1, 'admin', '?É¶‰EsŒˆ£¤Š©ã5Bkz@Ràª¥6ü§HË', 'íyÅ9HÒý‹A¨² Ûˆ)­Aï3-Ór>Lp†¸', 'admin', 'admin', 'jamie@jamie.com', '1984-12-21', CURDATE(), 1);


-- -----------------------------------------------------
-- Table `mdb`.`users_session`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mdb`.`users_session`;

CREATE TABLE IF NOT EXISTS `users_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL
);


-- -----------------------------------------------------
-- Table `mdb`.`Suppliers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdb`.`Suppliers` ;

CREATE TABLE IF NOT EXISTS `mdb`.`Suppliers` (
  `user` INT(11) NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `supplierName` VARCHAR(45) NOT NULL,
  `phoneNumber` VARCHAR(45) NULL,
  `faxNumber` VARCHAR(45) NULL,
  `emailAddress` VARCHAR(45) NULL,
  `address` VARCHAR(45) NULL,
  `cutOffOrderTime` TIME NULL,
  `turnAroundDeliveryTime` VARCHAR(45) NULL,
  `dateOfEntry` DATE NOT NULL,
  `freightCharge` DECIMAL(13,4) UNSIGNED NOT NULL DEFAULT 0,
  `reliability` INT(2) UNSIGNED NULL,
  `deliveryTime` VARCHAR(45) NULL,
   CONSTRAINT fk_Suppliers_users FOREIGN KEY (`user`)
   REFERENCES users(`id`),
   CONSTRAINT chk_percentage CHECK (`reliability` >= 0 AND `reliability` <= 100)
);

-- -----------------------------------------------------
-- Insert Default suppliers
-- -----------------------------------------------------

INSERT INTO `Suppliers` (`user`, `supplierName`, `phoneNumber`, `faxNumber`, `emailAddress`, `address`, `cutOffOrderTime`, `turnAroundDeliveryTime`, `dateOfEntry`, `freightCharge`, `reliability`, `deliveryTime`) VALUES
(1, 'Bidvest', '042372700', '042372701', 'bidvest@bidvest.co.nz', 'Palmerston North', '24:00:00', '6:30:00', CURDATE(), 6.00, 90, '6:30:00'); 
-- -----------------------------------------------------
-- Table `mdb`.`UnitType`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdb`.`UnitType` ;

CREATE TABLE IF NOT EXISTS `mdb`.`UnitType` (
  `UnitName` VARCHAR(5) NOT NULL UNIQUE PRIMARY KEY
);

-- INSERT DEFAULT VALUES-------------------------------
INSERT INTO `UnitType` (`UnitName`) VALUES 
('Kilo'),
('Litre'),
('Each'); 


-- -----------------------------------------------------
-- Table `mdb`.`Unit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdb`.`Unit` ;

CREATE TABLE IF NOT EXISTS `mdb`.`Unit` (
  `user` INT(11) NOT NULL,
  `Name` VARCHAR(20) NOT NULL UNIQUE PRIMARY KEY,
  `Ratio` DECIMAL(4,2) UNSIGNED NOT NULL,
  `UnitType` VARCHAR(5) NOT NULL,
  CONSTRAINT fk_Unit_users FOREIGN KEY (`user`)
  REFERENCES users(`id`),
  CONSTRAINT fk_Unit_UnitType FOREIGN KEY (`UnitType`)
  REFERENCES UnitType(`UnitName`),
  CONSTRAINT chk_ratio CHECK (`Ratio` > 0)
);
-- -----------------------------------------------------
-- Insert default values
-- -----------------------------------------------------
INSERT INTO `Unit`(`user`, `Name`, `Ratio`, `UnitType`) VALUES 
( 1, '2L Bottle', 2.0, 'Litre'),
( 1, 'Loaf', 1, 'Each'),
( 1, 'Cup', 0.25, 'Litre'),
( 1, 'Litre', 1, 'Litre'),
( 1, 'Kilo', 1, 'Kilo'),
( 1, 'Portion', 1.0, 'Each');

-- -----------------------------------------------------
-- Table `mdb`.`Products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdb`.`Products` ;

CREATE TABLE IF NOT EXISTS `mdb`.`Products` (
  `user` INT(11) NOT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `productName` VARCHAR(45) NOT NULL,
  `purchaseUnit` VARCHAR(45) NOT NULL,
  `purchaseUnitPrice` DECIMAL(13,2) UNSIGNED NOT NULL,
  `purchaseUnitWeight` DECIMAL(13,2) UNSIGNED NOT NULL,
  `yeild` INT(3) UNSIGNED NOT NULL DEFAULT 100,
  `costPerKiloUnit` DECIMAL(13,2) UNSIGNED NOT NULL,
  `density` FLOAT UNSIGNED NOT NULL DEFAULT 1,
  `discount` DECIMAL(10,0) UNSIGNED NOT NULL DEFAULT 0,
  `Suppliers_id` INT(11) NOT NULL,
  `unitName` VARCHAR(20) NOT NULL,
  CONSTRAINT fk_Products_users FOREIGN KEY (`user`)
  REFERENCES users(`id`),
  CONSTRAINT fk_Products_Suppliers FOREIGN KEY (`Suppliers_id`)
  REFERENCES Suppliers(`id`),
  CONSTRAINT fk_Products_Unit FOREIGN KEY (`unitName`)
  REFERENCES `Unit`(`Name`)
);
-- -----------------------------------------------------
-- Inserts default products
-- -----------------------------------------------------

INSERT INTO `Products`(`user`, `productName`, `purchaseUnit`, `purchaseUnitPrice`, `purchaseUnitWeight`, `yeild`, `costPerKiloUnit`, `Suppliers_id`, `UnitName`) VALUES
(1, 'Bread', 'Loaf', 2.00, 1.00, 100, 2.00, 1, 'Loaf'),
(1, 'Milk', '2L Bottle', 3.95, 2.00, 100, 2.00, 1, 'Litre'),
(1, 'Cereal', '400G bag', 2.95, 0.40, 100, 7.37, 1, 'Kilo'); 

-- -----------------------------------------------------
-- Table `mdb`.`Contacts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdb`.`Contacts` ;

CREATE TABLE IF NOT EXISTS `mdb`.`Contacts` (
  `user` INT(11) NOT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `contactName` VARCHAR(45) NOT NULL,
  `phoneNumber` VARCHAR(45) NULL,
  `cellNumber` VARCHAR(45) NULL,
  `faxNumber` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `Address` VARCHAR(45) NULL,
  `Suppliers_id` INT(11) NOT NULL,
  CONSTRAINT fk_Contacts_users FOREIGN KEY (`user`)
  REFERENCES users(`id`),
  CONSTRAINT fk_Contacts_Suppliers FOREIGN KEY (`Suppliers_id`)
  REFERENCES Suppliers(`id`)

);

INSERT INTO `Contacts` (`user`, `contactName`, `phoneNumber`, `cellNumber`, `faxNumber`, `email`, `address`, `Suppliers_id`) VALUES
( 1, 'John Hancock', '042372700', '0212345678', '042371223', 'john@bidvest.co.nz', 'Wellington', 1);
-- -----------------------------------------------------
-- Table `mdb`.`Recipes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdb`.`Recipes` ;

CREATE TABLE IF NOT EXISTS `mdb`.`Recipes` (
  `user` INT(11) NOT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `yeild` DECIMAL(5,2) NOT NULL DEFAULT 1.00,
  `yeildUnit` VARCHAR(20) NOT NULL,
  `method` MEDIUMTEXT NULL,
  `recipeName` VARCHAR(45) NULL,
  `recipeCost` DECIMAL(13,2) NOT NULL,
  CONSTRAINT fk_Recipes_users FOREIGN KEY (`user`)
  REFERENCES users(`id`),
  CONSTRAINT fk_Recipes_Unit FOREIGN KEY(`yeildUnit`)
  REFERENCES Unit(`Name`)
);

-- -----------------------------------------------------
-- Insert default entry
-- -----------------------------------------------------

INSERT INTO `Recipes` (`user`, `yeild`, `yeildUnit`, `method`, `recipeName`, `recipeCost`) VALUES
( 1, 12, 'Portion', 'Put and egg on it', 'Eggy Cupcakes', 5);

-- -----------------------------------------------------
-- Table `mdb`.`ProductRecipes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdb`.`ProductRecipes` ;

CREATE TABLE IF NOT EXISTS `mdb`.`ProductRecipes` (
  `user` INT(11) NOT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Products_id` INT(11) NOT NULL,
  `Recipes_id` INT(11) NOT NULL,
  `quantity` DECIMAL(10,2) NOT NULL DEFAULT 1.00,
  `unit` VARCHAR(45) NULL COMMENT 'Portion, Litre etc',
  CONSTRAINT fk_ProductRecipes_users FOREIGN KEY (`user`)
  REFERENCES users(`id`),
  CONSTRAINT fk_ProductRecipes_Products FOREIGN KEY (`Products_id`)
  REFERENCES Products(`id`),
  CONSTRAINT fk_ProductRecipes_Recipes FOREIGN KEY (`Recipes_id`)
  REFERENCES Recipes(`id`),
  CONSTRAINT fk_ProductRecipes_Unit FOREIGN KEY (`unit`)
  REFERENCES Unit(`Name`)

);

-- -----------------------------------------------------
-- Insert default Product/Recipes
-- -----------------------------------------------------

INSERT INTO `ProductRecipes`( `user`, `Products_id`, `Recipes_id`, `quantity`, `unit`) VALUES
( 1, 1, 1, 3, 'Loaf'),
( 1, 2, 1, 12, 'Litre');

-- -----------------------------------------------------
-- Table `mdb`.`Dietary`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mdb`.`Dietary` ;

CREATE TABLE IF NOT EXISTS `mdb`.`Dietary` (
  `user` INT(11) NOT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(20) NOT NULL UNIQUE,
  `description` TEXT NOT NULL,
  CONSTRAINT fk_Dietary_users FOREIGN KEY (`user`)
  REFERENCES users(`id`)
);

-- -----------------------------------------------------
-- Insert default values
-- -----------------------------------------------------

INSERT INTO `Dietary` ( `user`, `name`, `description`) VALUES
( 1, 'None', 'No dietary requirememnts'),
( 1, 'Vegan', 'No animal products'),
( 1, 'Vegetarian', 'No meat'),
( 1, 'Gluten free', 'No Flour or products conducts containing gluten'),
( 1, 'Dairy free', 'No Dairy products'),
( 1, 'No Seafood', ''),
( 1, 'Nut free', 'Does not contain nuts');

-- -----------------------------------------------------
-- Table `mdb`.`DishDietary`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mdb`.`DishDietary` ;

CREATE TABLE IF NOT EXISTS `mdb`.`DishDietary` (
  `user` INT(11) NOT NULL,
  `Dietary_id` INT(11) NOT NULL,
  `Dishes_id` INT(11) NOT NULL,
  CONSTRAINT fk_DishDietary_Dietary FOREIGN KEY (`Dietary_id`)
  REFERENCES Dietary(`id`),
  CONSTRAINT fk_DishDietary_Dishes FOREIGN KEY (`Dishes_id`)
  REFERENCES Dishes(`id`),
  CONSTRAINT fk_DishDietary_users FOREIGN KEY (`user`)
  REFERENCES users(`id`)
);

-- -----------------------------------------------------
-- Insert default values
-- -----------------------------------------------------

INSERT INTO `DishDietary` ( `user`, `Dietary_id`, `Dishes_id`) VALUES 
( 1, 1, 1);

-- -----------------------------------------------------
-- table `mdb`.`Dishes`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mdb`.`Dishes` ;

CREATE TABLE IF NOT EXISTS `mdb`.`Dishes` (
  `user` INT(11) NOT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `dishName` VARCHAR(45) NULL,
  `salePrice` DECIMAL(13,2) NOT NULL COMMENT 'including GST\n',
  `costPrice` DECIMAL(13,2) NOT NULL COMMENT 'cost price of food ex get\n',
  `yeild` INT(3) NOT NULL COMMENT 'number of dishes\n',
  CONSTRAINT fk_Dishes_users FOREIGN KEY (`user`)
  REFERENCES users(`id`)
);

-- -----------------------------------------------------
-- Insert default Dishes
-- -----------------------------------------------------

INSERT INTO `Dishes` (`user`, `dishName`, `salePrice`, `costPrice`, `yeild`) VALUES
( 1, 'Cupcakes with tomato sauce', 6, 2, 4); 

-- -----------------------------------------------------
-- Table `mdb`.`DishProducts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdb`.`DishProducts` ;

CREATE TABLE IF NOT EXISTS `mdb`.`DishProducts` (
  `user` INT(11) NOT NULL,
  `Products_id` INT(11) NOT NULL,
  `Dishes_id` INT(11) NOT NULL,
  `quantity` DECIMAL(10,2) NOT NULL DEFAULT 1.00,
  `unit` VARCHAR(45) NULL COMMENT 'Portion, Litre etc',

  CONSTRAINT fk_DishProducts_users FOREIGN KEY (`user`)
  REFERENCES users(`id`),
  CONSTRAINT fk_DishProducts_Products FOREIGN KEY (`Products_id`)
  REFERENCES Products(`id`),
  CONSTRAINT fk_DishProducts_Dishes FOREIGN KEY (`Dishes_id`)
  REFERENCES Recipes(`id`),
  CONSTRAINT fk_DishProducts_Unit FOREIGN KEY (`unit`)
  REFERENCES Unit(`Name`)

);


-- -----------------------------------------------------
-- Table `mdb`.`DishRecipe`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `mdb`.`DishRecipes` ;

CREATE TABLE IF NOT EXISTS `mdb`.`DishRecipes` (
  `user` INT(11) NOT NULL,
  `Dishes_id` INT(11) NOT NULL,
  `Recipes_id` INT(11) NOT NULL,
  `quantity` DECIMAL(10,2) NOT NULL DEFAULT 1.00,
  `unit` VARCHAR(45) NULL COMMENT 'Portion, Litre etc',

  CONSTRAINT fk_DishRecipes_users FOREIGN KEY (`user`)
  REFERENCES users(`id`),
  CONSTRAINT fk_DishRecipes_Dishes FOREIGN KEY (`Dishes_id`)
  REFERENCES Dishes(`id`),
  CONSTRAINT fk_DishRecipes_Recipes FOREIGN KEY (`Recipes_id`)
  REFERENCES Recipes(`id`),
  CONSTRAINT fk_DishRecipes_Unit FOREIGN KEY (`unit`)
  REFERENCES Unit(`Name`)
);

-- -----------------------------------------------------
-- Insert default values
-- -----------------------------------------------------

INSERT INTO `DishRecipes`( `user`, `Dishes_id`, `Recipes_id`, `unit`) VALUES
( 1, 1, 1, 'Portion');
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
