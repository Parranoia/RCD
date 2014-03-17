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
   `phone_number` varchar(12) NULL,
   `employer` varchar(255) NULL,
   `num_children` tinyint(2) UNSIGNED NOT NULL,
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

-- Dumping structure for table rcd.pages
DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `header` varchar(600) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table rcd.pages: ~1 rows (approximately)
DELETE FROM `pages`;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `name`, `header`) VALUES
    (1, 'home', 'Quality Childcare in Radford<br><br>Opening 2015!');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;


-- Dumping structure for table rcd.page_content
DROP TABLE IF EXISTS `page_content`;
CREATE TABLE IF NOT EXISTS `page_content` (
  `page` int(12) unsigned NOT NULL,
  `position` int(12) unsigned NOT NULL DEFAULT '0',
  `header` varchar(600) DEFAULT NULL,
  `body` varchar(50000) NOT NULL,
  `isHTML` tinyint(1) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `page` (`page`,`position`),
  CONSTRAINT `content_page` FOREIGN KEY (`page`) REFERENCES `pages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rcd.page_content: ~6 rows (approximately)
DELETE FROM `page_content`;
/*!40000 ALTER TABLE `page_content` DISABLE KEYS */;
INSERT INTO `page_content` (`page`, `position`, `header`, `body`, `isHTML`) VALUES
    (1, 0, '', '<img src="images/child.jpg" align="middle" />', 1),
    (1, 1, 'Mission Statement', 'To develop and/or support excellent, nationally accredited child development program(s) in Radford that embodies the best practices of early childhood care and education. ', 0),
    (1, 2, 'Request for Proposals', 'RCD Issued a request for proposals (<a href="/docs/RFP.pdf">RFP</a>) from qualified local, regional and national child care providers to open a new facility in Radford. A grant of up to $210,000 will be awarded. Visit the online RFP for details and deadlines.', 0),
    (1, 3, 'Results of our Needs Assessment', 'In order to evaluate the need for a quality child care in Radford, we conducted a <a target="_blank" href="docs/NeedsAssessment.pdf">needs assessment</a> with members of the Radford community this year. We sought to measure the discrepancy between the current condition and the desired condition. We determined and documented a critical need in quality child care in Radford. Based on our research, 9 out of 10 children in Radford do not have access to a state-licensed child care.', 0),
    (1, 4, NULL, '<div id="left-column">\r\n     <h3>Future Goals</h3>\r\n      <ul>\r\n             <li><a target="_blank" href="docs/pressrelease.pdf">Press Release</a></li>\r\n              <li><a target="_blank" href="docs/RCDC.png">Future Building</a></li>\r\n        </ul> \r\n</div>', 1),
    (1, 5, NULL, '<div id="right-column">\r\n    <h3>Let us know of your interest now!</h3>\r\n    <p>\r\n        Email: <a href="mailto:radfordchilddevelopment@gmail.com">radfordchilddevelopment@gmail.com</a><br>\r\n        Phone: (434) 227-7196\r\n    </p>\r\n</div>', 1);
/*!40000 ALTER TABLE `page_content` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
