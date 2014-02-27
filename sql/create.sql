-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.11 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.1.0.4545
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

USE RCD;

-- Dumping structure for table rcd.forgot_password
DROP TABLE IF EXISTS `forgot_password`;
CREATE TABLE IF NOT EXISTS `forgot_password` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(12) unsigned NOT NULL DEFAULT '0',
  `key` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  CONSTRAINT `user_forgot_pass` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table rcd.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `email_hash` varchar(32) NOT NULL,
  `privilege` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Parents interested
DROP TABLE IF EXISTS `interested_parents`;
CREATE TABLE IF NOT EXISTS `interested_parents` (
   `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   `email` varchar(255) NOT NULL,
   `phone_number` varchar(12) NULL DEFAULT,
   `employer` varchar(255) NOT NULL,
   `num_children` tinyint(2) NOT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Parent's children
DROP TABLE IF EXISTS `interested_children`;
CREATE TABLE IF NOT EXISTS `interested_children` (
   `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
   `parent` int(12) unsigned NOT NULL,
   `name` varchar(255) NOT NULL,
   `dob` varchar(12) NOT NULL,
   `gender` varchar(6) NOT NULL,
   PRIMARY KEY (`id`),
   CONSTRAINT `parent_id` FOREIGN KEY (`parent`) REFERENCES `interested_parents` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
