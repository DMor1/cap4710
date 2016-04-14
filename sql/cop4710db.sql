SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `cop4710db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cop4710db`;

CREATE TABLE IF NOT EXISTS `advisors` (
  `user_id` int(11) NOT NULL,
  `advisor_name` varchar(255) NOT NULL,
  `start_year` int(4) NOT NULL,
  `end_year` int(4) NOT NULL,
  PRIMARY KEY (`user_id`,`advisor_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) NOT NULL,
  `course_desc` int(11) NOT NULL,
  `course_grade` varchar(255) NOT NULL,
  `course_credit_hours` int(11) NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `courses_taken` (
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`,`user_id`),
  KEY `courses_taken_fk2` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `nominees` (
  `session_id` int(11) NOT NULL,
  `nominee_user_id` int(11) NOT NULL,
  `nominated_by_user_id` int(11) NOT NULL,
  `speak_test_id` int(11) DEFAULT NULL,
  `isverified` tinyint(1) DEFAULT NULL,
  `ranking` int(11) NOT NULL,
  `num_sem_as_grad` int(11) DEFAULT NULL,
  `num_sem_as_gta` int(11) DEFAULT NULL,
  `is_curr_phd` tinyint(1) NOT NULL,
  `is_new_phd` tinyint(1) NOT NULL,
  `cummulative_gpa` varchar(255) NOT NULL,
  `phd_advisor_name` varchar(255) NOT NULL,
  `receiveNomination` date DEFAULT NULL,
  `respondNomination` date DEFAULT NULL,
  `verifiedNomination` date DEFAULT NULL,
  PRIMARY KEY (`session_id`,`nominee_user_id`),
  KEY `nominated_by_user_id` (`nominated_by_user_id`),
  KEY `speak_test_id` (`speak_test_id`),
  KEY `nominees_fk2` (`nominee_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `publications` (
  `session_id` int(11) NOT NULL,
  `nominee_user_id` int(11) NOT NULL,
  `publication_name_and_citations` text NOT NULL,
  PRIMARY KEY (`session_id`,`nominee_user_id`),
  KEY `publications_fk2` (`nominee_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `roles` (`role_id`, `description`) VALUES
(1, 'System Administrator'),
(2, 'GC Committee'),
(3, 'Nominator'),
(4, 'Nominee');

CREATE TABLE IF NOT EXISTS `scores` (
  `session_id` int(11) NOT NULL,
  `nominee_user_id` int(11) NOT NULL,
  `gc_user_id` int(11) NOT NULL,
  `score` double NOT NULL DEFAULT '0',
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`session_id`,`nominee_user_id`,`gc_user_id`),
  KEY `scores_fk2` (`nominee_user_id`),
  KEY `scores_fk3` (`gc_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_name` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `initiation_date` datetime NOT NULL,
  `verify_deadline_date` datetime NOT NULL,
  PRIMARY KEY (`session_id`,`session_name`) USING BTREE,
  UNIQUE KEY `session_name` (`session_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `speak_test` (
  `speak_test_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`speak_test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `speak_test` (`speak_test_id`, `status`) VALUES
(1, 'Yes'),
(2, 'No'),
(3, 'Graduated from a U.S. institution');

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `pid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=latin1;

INSERT INTO `users` (`user_id`, `fname`, `lname`, `phonenumber`, `pid`, `email`, `username`, `password`) VALUES
(1, 'System Admin', '', '', '', 'admin@test.com', 'admin', '098f6bcd4621d373cade4e832627b4f6');

CREATE TABLE IF NOT EXISTS `user_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `user_roles_fk2` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `user_roles` (`role_id`, `user_id`) VALUES
(1, 1);


ALTER TABLE `advisors`
  ADD CONSTRAINT `advisors_fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `courses_taken`
  ADD CONSTRAINT `courses_taken_fk1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_taken_fk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `nominees`
  ADD CONSTRAINT `nominees_fk1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`),
  ADD CONSTRAINT `nominees_fk2` FOREIGN KEY (`nominee_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `nominees_fk3` FOREIGN KEY (`nominated_by_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `nominees_fk4` FOREIGN KEY (`speak_test_id`) REFERENCES `speak_test` (`speak_test_id`);

ALTER TABLE `publications`
  ADD CONSTRAINT `publications_fk1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`),
  ADD CONSTRAINT `publications_fk2` FOREIGN KEY (`nominee_user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `scores`
  ADD CONSTRAINT `scores_fk1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`),
  ADD CONSTRAINT `scores_fk2` FOREIGN KEY (`nominee_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `scores_fk3` FOREIGN KEY (`gc_user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_fk1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `user_roles_fk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
