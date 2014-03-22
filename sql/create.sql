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
  `position` int(12) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `header` varchar(600) DEFAULT '',
  `custom` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `position` (`position`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table rcd.pages: ~1 rows (approximately)
DELETE FROM `pages`;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `position`, `name`, `header`, `custom`) VALUES
    (1, 0, 'home', 'Quality Childcare in Radford<br><br>Opening 2015!', 0),
    (2, 4, 'interested', '', 1),
    (3, 1, 'donate', 'Help us to Make This New Facility a Reality!', 0),
    (4, 2, 'articles', 'Articles', 0),
    (5, 3, 'about', 'Future Location', 0);
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
    (1, 5, NULL, '<div id="right-column">\r\n    <h3>Let us know of your interest now!</h3>\r\n    <p>\r\n        Email: <a href="mailto:radfordchilddevelopment@gmail.com">radfordchilddevelopment@gmail.com</a><br>\r\n        Phone: (434) 227-7196\r\n    </p>\r\n</div>', 1),
    (3, 0, 'Community Foundation of the New River Valley', 'Radford Child Development, Inc. is pleased to accept donations through a partnership with the Community Foundation of the New River Valley, a public not-for-profit organization benefiting the New River Valley. \r\nFor more information on the Foundation, visit <a href="https://cfnrv.org">cfnrv.org</a>', 0),
    (3, 1, 'How to Contribute to Radford Child Development Inc.', 'The Community Foundation is classified as 501c3 by the Internal Revenue Service and all contributions are tax deductible as allowed by law. Please consult your tax advisor with questions regarding charitable gifts.', 0),
    (3, 2, NULL, '<table id="donate">\r\n    <tr>\r\n        <th><h3>Online Donation</h3></th>\r\n        <th><h3>Offline Donation</h3></th>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            One-time or ongoing contributions may be made via the Foundation’s website by clicking below\r\n        </td>\r\n        <td>\r\n            Contributions via check should be made out to the Community Foundation of the New River Valley with “Radford Child Development” in the notation line and sent to P.O. Box 6009, Christiansburg, VA 24068-6009. \r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td class="donate">\r\n            <a class="donate" target="_blank" href="https://cfnrv.givebig.org/c/NRV/a/cfnrv-013/">Donate</a></td>\r\n        <td>\r\n            Donors wishing to make non-cash gifts such as appreciated stock, or discuss a planned gift may contact the Foundation at 540-381-8999.    \r\n        </td>\r\n    </tr>    \r\n</table>', 1),
    (3, 3, 'Current Grant Activities', '<p>\r\n    Radford Child Development is currently applying for external funds to cover the following costs:\r\n    <ol>\r\n        <li>Tuition Discounts for our low-wealth families</li>\r\n        <li>Head Teacher and Teacher payments prior to opening</li>\r\n        <li>Director and Assistant directory payment prior to opening</li>\r\n        <li>Marketing</li>\r\n        <li>Accountant services</li>\r\n        <li>Teacher training expenses</li>\r\n        <li>Teacher sign-up bonuses</li>\r\n    </ol>\r\n</p>', 1),
    (4, 0, '2014', '<ul>\r\n    <li><a target="_blank" href="/docs/pressrelease.pdf">Press Release</a></li>\r\n</ul>', 1),
    (4, 1, '2013', '<ul>\r\n    <li><a target="_blank" href="http://blogs.roanoke.com/theburgs/news/2013/10/12/new-child-care-center-to-open-in-radford/">Roanoke Times - New Child Care</a></li>\r\n    <li><a target="_blank" href="http://www.southwesttimes.com/2013/08/radford-child-development-inc-bringing-accredited-child-care-to-nrv/">Southwest Times -  Accredited Child Care</a>\r\n    </li>\r\n    <li><a target="_blank" href="http://www.southwesttimes.com/2013/10/rcd-inc-receives-funds-and-location-for-child-care-facility/">Southwest Times - Recieves Funding</a>\r\n    </li>\r\n    <li><a target="_blank" href="http://wsls.membercenter.worldnow.com/story/23661590/radford-child-development-in-gets-money-location-for-facility">WSLS10 - Facility Location</a>\r\n    </li>\r\n    <li><a target="_blank" href="http://www.radford.edu/content/radfordcore/home/news/releases/2013/October/new-RU-child-care-facility.html">Radford University - Location Set</a>\r\n    </li>\r\n</ul>', 1),
    (5, 0, NULL, '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/?ie=UTF8&amp;t=h&amp;ll=37.12364,-80.535697&amp;spn=0.001497,0.00228&amp;z=18&amp;output=embed"></iframe><br /><small style="text-align:center;display:block;"><a href="https://maps.google.com/?ie=UTF8&amp;t=h&amp;ll=37.12364,-80.535697&amp;spn=0.001497,0.00228&amp;z=18&amp;source=embed" style="color:#0000FF">View Larger Map</a></small>', 1),
    (5, 1, 'Who are we?', '<p>\r\n    Radford Child Development, Inc. (RCD) is a grassroots, community-led, non-profit organization established in 2012 to develop a quality, certified child care facility in Radford. \r\n    It is run by a diverse board of directors who devote their time, expertise, and personal funds to support an organizational mission that is critical to the Radford community. \r\n    Based on an extensive needs assessment conducted last year, at least 9 out of 10 children in the City of Radford do not have access to state-licensed child care. \r\n    Working parents are struggling to find child care that even meets minimum state licensing standards.  \r\n    There is no option for quality certified child care in the community.  \r\n    Lack of access to child development facilities has a long-lasting negative impact on our community. \r\n    According to research, providing quality early childhood education is an effective strategy for moving people out of poverty. \r\n    Bringing a quality, education-based facility to Radford is a long term investment that will:\r\n    <ol>\r\n        <li>Enable Radford families to have access to the essential educational foundation of quality childcare</li>\r\n        <li>Provide necessary community facilities and infrastructure for working parents in order to improve their own lives and make contributions to our community</li>\r\n        <li>Bring fundamental and lasting change to the entire Radford community and our low-wealth community members. It also strengthens the community by supporting economic growth and making our area more attractive for new businesses and housing</li>\r\n    </ol>\r\n</p>\r\n<p>\r\n    Our Mission is to develop and/or support excellent, nationally accredited child development program(s) in Radford that embodies the best practices of early childhood care and education. \r\n    One of our fundamental goals is to make this accessible to all income levels in our community. \r\n    We believe that providing low-wealth families with access to a high level educational environment for their children will not only improve kid’s chances to succeed academically and move out of poverty, but will also have an immediate impact on the family finances by providing parents with time to work, knowing that children are in a safe and stimulating environment.\r\n</p>', 1),
    (5, 2, 'Major Strategies', '<p>\r\n    RCD is a non-profit organization that was established by members of the Radford community to address an immediate and essential need for all Radford community members. We understand that all working parents need to have access to a quality certified educational child development facility. Our major strategies include:\r\n    <ol>\r\n        <li>Attracting a quality nationally certified child care provider to Radford, VA</li>\r\n        <li>Providing external funds for pre-opening expenses to make operating a center financially feasible</li>\r\n        <li>Providing tuition discounts to low-wealth families</li>\r\n        <li>Creating awareness, disseminating information, and involving all community members</li>\r\n        <li>Recruiting and retaining highly qualified teachers</li>\r\n        <li>Working with United States and Commonwealth representatives to change local/state/federal policies related to child development facilities</li>\r\n    </ol>    \r\n</p>', 1),
    (5, 3, 'Benefits of a Radford Child Development Center', '<ul>\r\n    <li>A Radford resource available to all Radford area employers.</li>\r\n    <li>Internship opportunities for RU early education and other disciplines.</li>\r\n    <li>Highest quality NAEY-C childcare in Radford to serve our communities\'s children and families.</li>\r\n</ul>', 1),
    (5, 4, 'We are 501c3 pending', 'Although the 501c3 application process can take several months, we anticipate IRS approval for this nonprofit.', 0),
    (5, 5, 'What does this mean?', 'Radford Child Development, Inc. is a non-profit organization incorporated in the state of Virginia. Nonprofit organizations are given 27 months from the date of incorporation to fill out IRS form 1023 to apply for tax-exempt status. We completed and submitted our 1023 form to IRS.', 0),
    (5, 6, 'Why does this matter to you?', 'Once 1023 approved, it is inclusive of all donations taken in from the incorporation date to the date of 501c3 approval. Basically, this means that your donations are tax-deductible.', 0),
    (5, 7, 'Strategic Partners', '<p>\r\n    <ol>\r\n        <li>Community Foundation of New River Valley</li>\r\n        <li>Radford University Foundation</li>\r\n        <li>Price Williams Realtors</li>\r\n        <li>Radford City</li>\r\n        <li>Radford Public Schools</li>\r\n        <li>DIVAS</li>\r\n        <li>Rainbow Riders</li>\r\n        <li>Smart Beginnings</li>\r\n    </ol>\r\n</p>', 1),
    (5, 8, 'Contact Us', 'Email: <a href="mailto:radfordchilddevelopment@gmail.com">radfordchilddevelopment@gmail.com</a><br>Phone: (434) 227-7196', 0),
    (5, 9, 'Keep in mind...', 'No goods or services will be provided in exchange for your donation. Your donation is tax deductible to the extent allowed by law. ', 0);
/*!40000 ALTER TABLE `page_content` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
