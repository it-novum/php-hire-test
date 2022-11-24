/*
SQLyog Ultimate v13.1.8 (64 bit)
MySQL - 5.7.36-log : Database - cookbook
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cookbook` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `cookbook`;

/*Table structure for table `ingredient` */

DROP TABLE IF EXISTS `ingredient`;

CREATE TABLE `ingredient` (
  `ingredient_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'I am the ID of the ingredient.',
  `ingredient_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the creation timestamp.',
  `ingredient_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the timestmap of the last modification.',
  `ingredient_flags` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'I am the flags. 0x00001 = ingredient enabled',
  `ingredient_type_id` int(10) unsigned NOT NULL COMMENT 'I am the type of the ingredient.',
  `translation_name` varchar(64) NOT NULL COMMENT 'I am the specific name of the ingredient.',
  `ingredient_unit` enum('unit_gram','unit_milliliter','unit_count') DEFAULT NULL COMMENT 'I am the unit the ingredient is measured in.',
  PRIMARY KEY (`ingredient_id`),
  KEY `ingredient_to_ingredient_type` (`ingredient_type_id`),
  KEY `ingredient_to_translation` (`translation_name`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

/*Data for the table `ingredient` */

insert  into `ingredient`(`ingredient_id`,`ingredient_created`,`ingredient_modified`,`ingredient_flags`,`ingredient_type_id`,`translation_name`,`ingredient_unit`) values 
(1, NOW(),NOW(),1,1,'INGREDIENT_SALT','unit_gram'),
(2, NOW(),NOW(),1,1,'INGREDIENT_PEPPER','unit_gram'),
(3, NOW(),NOW(),1,5,'INGREDIENT_GROUND_BEEF','unit_gram'),
(4, NOW(),NOW(),1,4,'INGREDIENT_TOMATO','unit_gram'),
(5, NOW(),NOW(),0,3,'INGREDIENT_BEAN','unit_gram'),
(6, NOW(),NOW(),0,1,'INGREDIENT_CUMIN','unit_gram'),
(7, NOW(),NOW(),0,2,'INGREDIENT_PARSLEY','unit_gram'),
(8, NOW(),NOW(),0,3,'INGREDIENT_CORN','unit_gram'),
(9, NOW(),NOW(),0,7,'INGREDIENT_WINE_RED','unit_milliliter'),
(10,NOW(),NOW(),0,7,'INGREDIENT_COFFEE','unit_milliliter'),
(11,NOW(),NOW(),0,3,'INGREDIENT_CHOCOLATE','unit_gram'),
(12,NOW(),NOW(),0,7,'INGREDIENT_BEER','unit_milliliter'),
(13,NOW(),NOW(),0,6,'INGREDIENT_SUGAR','unit_gram'),
(14,NOW(),NOW(),0,6,'INGREDIENT_FLOUR','unit_gram'),
(15,NOW(),NOW(),0,6,'INGREDIENT_EGG','unit_count'),
(16,NOW(),NOW(),0,6,'INGREDIENT_MILK','unit_milliliter');

/*Table structure for table `ingredient_type` */

DROP TABLE IF EXISTS `ingredient_type`;

CREATE TABLE `ingredient_type` (
  `ingredient_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'I am the ID of the ingredient type.',
  `ingredient_type_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the creation timestamp of the ingredient type.',
  `ingredient_type_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the last modification of the ingredient.',
  `ingredient_type_flags` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'I am the flags collection. 0x00001=Ingredient enabled.',
  `translation_name` varchar(64) NOT NULL COMMENT 'I am the translation to use for the ingredient type.',
  PRIMARY KEY (`ingredient_type_id`),
  KEY `ingredient_type_to_translation` (`translation_name`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

/*Data for the table `ingredient_type` */

insert  into `ingredient_type`(`ingredient_type_id`,`ingredient_type_created`,`ingredient_type_modified`,`ingredient_type_flags`,`translation_name`) values 
(1,NOW(),NOW(),1,'INGREDIENT_TYPE_SPICE'),
(2,NOW(),NOW(),1,'INGREDIENT_TYPE_HERB'),
(3,NOW(),NOW(),1,'INGREDIENT_TYPE_VEGETABLE'),
(4,NOW(),NOW(),1,'INGREDIENT_TYPE_FRUIT'),
(5,NOW(),NOW(),1,'INGREDIENT_TYPE_MEAT'),
(7,NOW(),NOW(),1,'INGREDIENT_TYPE_FLUID'),
(8,NOW(),NOW(),1,'INGREDIENT_TYPE_SWEET');

/*Table structure for table `recipe` */

DROP TABLE IF EXISTS `recipe`;

CREATE TABLE `recipe` (
  `recipe_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'I am the ID of the recipe.',
  `recipe_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the creation of the recipe.',
  `recipe_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the timestamp of the last modification.',
  `recipe_flags` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'I am the flag collection of the recipe 0x00001=enabled 0x00010=vegetarian 0x00100=vegan',
  `recipe_time` int(5) unsigned NOT NULL COMMENT 'I am the estimated time consumption on the recipe',
  `recipe_skill` int(5) unsigned NOT NULL COMMENT 'I am the skill level required (0-10)',
  `translation_key` varchar(64) NOT NULL COMMENT 'I am the translation for the recipe name.',
  `description_key` varchar(64) NOT NULL COMMENT 'I am the translation for the recipe text.',
  PRIMARY KEY (`recipe_id`),
  KEY `recipe_name_to_translation` (`translation_key`),
  KEY `recipe_description_to_translation` (`description_key`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

/*Data for the table `recipe` */

insert  into `recipe`(`recipe_id`,`recipe_created`,`recipe_modified`,`recipe_flags`,`recipe_time`,`recipe_skill`,`translation_key`,`description_key`) values 
(1,NOW(),NOW(),1,500,3,'RECIPE_TITLE_CHILICONCARNE','RECIPE_DESCRIPTION_CHILICONCARNE'),
(2,NOW(),NOW(),0,42,2,'RECIPE_TITLE_SALZSUPPE!','RECIPE_DESCRIPTION_SALZSUPPE!');

/*Table structure for table `recipe_ingredient` */

DROP TABLE IF EXISTS `recipe_ingredient`;

CREATE TABLE `recipe_ingredient` (
  `recipe_ingredient_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'I am the ID of the recipe ingredient',
  `recipe_ingredient_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the creation datetime of the recipe ingredient.',
  `recipe_ingredient_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the modification of the recipe ingredient.',
  `recipe_ingredient_flags` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'I am the flags for the recipe ingredient. 0x00001=Ingredient is shown',
  `recipe_id` int(10) unsigned NOT NULL COMMENT 'I am the recipe this maps to.',
  `ingredient_id` int(10) unsigned NOT NULL COMMENT 'I am the ingredient this maps to.',
  `recipe_ingredient_amount` decimal(13,5) unsigned NOT NULL COMMENT 'I am the amount of the ingredient that goes into the recipe',
  PRIMARY KEY (`recipe_ingredient_id`),
  KEY `recipe_ingredient_to_recipe` (`recipe_id`),
  KEY `recipe_ingredient_to_ingredient` (`ingredient_id`),
  CONSTRAINT `recipe_ingredient_to_ingredient` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`ingredient_id`),
  CONSTRAINT `recipe_ingredient_to_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

/*Data for the table `recipe_ingredient` */

insert  into `recipe_ingredient`(`recipe_ingredient_id`,`recipe_ingredient_created`,`recipe_ingredient_modified`,`recipe_ingredient_flags`,`recipe_id`,`ingredient_id`,`recipe_ingredient_amount`) values 
(1, NOW(),NOW(),1,1,1,1.00000),
(2, NOW(),NOW(),1,1,2,1.00000),
(3, NOW(),NOW(),1,1,3,1.00000),
(4, NOW(),NOW(),1,1,4,1.00000),
(5, NOW(),NOW(),1,1,5,1.00000),
(6, NOW(),NOW(),1,1,6,1.00000),
(7, NOW(),NOW(),1,1,7,1.00000),
(8, NOW(),NOW(),1,1,8,1.00000),
(9, NOW(),NOW(),1,1,9,1.00000),
(10,NOW(),NOW(),1,1,10,1.00000),
(11,NOW(),NOW(),1,1,11,1.00000),
(12,NOW(),NOW(),1,1,12,1.00000),
(63,NOW(),NOW(),0,2,1,22.00000);

/*Table structure for table `recipe_rating` */

DROP TABLE IF EXISTS `recipe_rating`;

CREATE TABLE `recipe_rating` (
  `recipe_rating_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'I am the pk of the table.',
  `recipe_rating_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the datetime when the rating was given.',
  `recipe_rating_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the datetime when the rating was modified.',
  `recipe_rating_flags` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'I am the flags collection for ratings. 0x00001=rating enabled.',
  `recipe_id` int(10) unsigned NOT NULL COMMENT 'I am the ID of the recipe this rating is meant for.',
  `recipe_rating_rating` int(2) unsigned NOT NULL DEFAULT '0' COMMENT 'I am the amount of stars given for this rating (1-5)',
  `recipe_rating_comment` text NOT NULL COMMENT 'I am the comment the author gave.',
  PRIMARY KEY (`recipe_rating_id`,`recipe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

/*Data for the table `recipe_rating` */

insert  into `recipe_rating`(`recipe_rating_id`,`recipe_rating_created`,`recipe_rating_modified`,`recipe_rating_flags`,`recipe_id`,`recipe_rating_rating`,`recipe_rating_comment`) values 
(1,NOW(),NOW(),1,1,2,'Nice one!');

/*Table structure for table `recipe_view` */

DROP TABLE IF EXISTS `recipe_view`;

CREATE TABLE `recipe_view` (
  `recipe_view_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'I am the pk of this table.',
  `recipe_view_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the datetime of the entry creation.',
  `recipe_view_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'I am the datetime of the last modification.',
  `recipe_view_flags` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'I am the flags collection for the recipe view. 0x00001=Counts',
  `recipe_id` int(10) unsigned NOT NULL COMMENT 'I am the ID of the recipe this hit counts for.',
  PRIMARY KEY (`recipe_view_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `recipe_view` */

/*Table structure for table `translation` */

DROP TABLE IF EXISTS `translation`;

CREATE TABLE `translation` (
  `translation_name` varchar(64) NOT NULL COMMENT 'I am the unique key for a translation.',
  `translation_german` text NOT NULL COMMENT 'I am the German translation.',
  `translation_english` text COMMENT 'I am the English translation.',
  PRIMARY KEY (`translation_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `translation` */

insert  into `translation`(`translation_name`,`translation_german`,`translation_english`) values 
('ADD_INGREDIENT','Zutat hinzufügen','Add ingredient'),
('AMOUNT','Menge','Amount'),
('CREATE_RECIPE','Rezept Erstellen','Create Recipe'),
('CRUD.INGREDIENT_LIST','Zutaten Verwalten','Manage Ingredients'),
('CRUDCREATE','Erstellen','Create'),
('DURATION','Dauer','Duration'),
('INFO','Info','Info'),
('INGREDIENT','Zutat','Ingredient'),
('INGREDIENTS','Zutaten','Ingredients'),
('INGREDIENT_BEAN','Bohnen','beans'),
('INGREDIENT_BEER','Bier','beer'),
('INGREDIENT_CHOCOLATE','Schokolade','chocolate'),
('INGREDIENT_COFFEE','Kaffee','coffee'),
('INGREDIENT_CORN','Mais','corn'),
('INGREDIENT_CUMIN','Kreuzkümmel','cumin'),
('INGREDIENT_EGG','Ei','Egg'),
('INGREDIENT_FLOUR','Mehl','Flour'),
('INGREDIENT_GROUND_BEEF','Rindergehacktes','ground beef'),
('INGREDIENT_MILK','Milch','Milk'),
('INGREDIENT_PARSLEY','Petersilie','parsley'),
('INGREDIENT_PEPPER','Pfeffer','pepper'),
('INGREDIENT_SALT','Salz','salt'),
('INGREDIENT_SUGAR','Zucker','Sugar'),
('INGREDIENT_TOMATO','Tomaten','tomatoes'),
('INGREDIENT_TYPE_FISH','Fisch','fish'),
('INGREDIENT_TYPE_FLUID','Flüssigkeit','fluid'),
('INGREDIENT_TYPE_FRUIT','Frucht','fruit'),
('INGREDIENT_TYPE_HERB','Kräuter','herbs'),
('INGREDIENT_TYPE_MEAT','Fleisch','meat'),
('INGREDIENT_TYPE_SPICE','Gewürz','spice'),
('INGREDIENT_TYPE_VEGETABLE','Gemüse','vegetable'),
('INGREDIENT_WINE_RED','Rotwein','red wine'),
('PHOTO','Foto','Photo'),
('PORTIONS','Portionen','Portions'),
('PREPARATION','Zubereitung','Preparation'),
('RATING','Bewertung','Rating'),
('RECALCULATE','Berechnen','Recalculate'),
('RECIPE_DESCRIPTION','Beschreibung','Description'),
('RECIPE_DESCRIPTION_5','231231sdf sdf','231231sdf sdf'),
('RECIPE_DESCRIPTION_BIER','Bier. Mehr nicht.','Bier. Mehr nicht.'),
('RECIPE_DESCRIPTION_Bockwurst mit Brötchen','Ne Bockwurst, ein Brötchen. SO einfach.','Ne Bockwurst, ein Brötchen. SO einfach.'),
('RECIPE_DESCRIPTION_BOCKWURST UND KARTOFFELSALAT','Bockwurst und Kartoffelsalat.','Bockwurst und Kartoffelsalat.'),
('RECIPE_DESCRIPTION_CHILICONCARNE','lecker lecker','tasty tasty...'),
('RECIPE_DESCRIPTION_IT NOVUM CHOCOLATE CAKE','test','test'),
('RECIPE_DESCRIPTION_SALZSUPPE!','123','123'),
('RECIPE_SKILL','Schwierigkeitsgrad','Schwierigkeitsgrad'),
('RECIPE_TIME','Geschätzte Zeit','Estimated Time'),
('RECIPE_TITLE','Titel','Title'),
('RECIPE_TITLE_5','',''),
('RECIPE_TITLE_BIER','Bier','Bier'),
('RECIPE_TITLE_Bockwurst mit Brötchen','',''),
('RECIPE_TITLE_BOCKWURST UND KARTOFFELSALAT','Bockwurst und Kartoffelsalat','Bockwurst und Kartoffelsalat'),
('RECIPE_TITLE_CHILICONCARNE','Chili Con Carne','Chili Con Carne'),
('RECIPE_TITLE_IT NOVUM CHOCOLATE CAKE','IT Novum Chocolate Cake','IT Novum Chocolate Cake'),
('RECIPE_TITLE_SALZSUPPE!','Salzsuppe!','Salzsuppe!'),
('REMOVE_INGREDIENT','Zutat entfernen','Remove Ingredient'),
('SEARCH','Deine Suche nach \"{query}\" fand {count} Rezepte:','Your query for \"{query}\" found {count} recipes:'),
('SKILL','Schwierigkeitsgrad','Skill'),
('UNIT_COUNT','Stück','pieces'),
('UNIT_GRAM','Gramm','gram'),
('UNIT_MILLILITER','ml','ml'),
('VIEWS','Besucher','Views',
('LATEST', 'Neueste', 'Latest'),
('FASTEST', 'Schnellste', 'Fastest'),
('EASIEST', 'Einfachste', 'Easiest'),
('NAME', 'Name', 'Name');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
