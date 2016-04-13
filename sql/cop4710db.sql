-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 14, 2016 at 03:59 AM
-- Server version: 5.5.44-0+deb8u1
-- PHP Version: 5.6.19-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cop4710db`
--

-- --------------------------------------------------------

--
-- Table structure for table `advisors`
--

CREATE TABLE `advisors` (
  `user_id` int(11) NOT NULL,
  `advisor_name` varchar(255) NOT NULL,
  `start_year` int(4) NOT NULL,
  `end_year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_desc` int(11) NOT NULL,
  `course_grade` varchar(255) NOT NULL,
  `course_credit_hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_taken`
--

CREATE TABLE `courses_taken` (
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nominees`
--

CREATE TABLE `nominees` (
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
  `verifiedNomination` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE `publications` (
  `session_id` int(11) NOT NULL,
  `nominee_user_id` int(11) NOT NULL,
  `publication_name_and_citations` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `description`) VALUES
(1, 'System Administrator'),
(2, 'GC Committee'),
(3, 'Nominator'),
(4, 'Nominee');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `session_id` int(11) NOT NULL,
  `nominee_user_id` int(11) NOT NULL,
  `gc_user_id` int(11) NOT NULL,
  `score` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `initiation_date` date NOT NULL,
  `verify_deadline_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `speak_test`
--

CREATE TABLE `speak_test` (
  `speak_test_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `speak_test`
--

INSERT INTO `speak_test` (`speak_test_id`, `status`) VALUES
(1, 'Yes'),
(2, 'No'),
(3, 'Graduated from a U.S. institution');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `pid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `phonenumber`, `pid`, `email`, `username`, `password`) VALUES
(1, 'System Admin', '', '', 'admin@test.com', 'admin', '098f6bcd4621d373cade4e832627b4f6');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `user_id`) VALUES
(1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advisors`
--
ALTER TABLE `advisors`
  ADD PRIMARY KEY (`user_id`,`advisor_name`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `courses_taken`
--
ALTER TABLE `courses_taken`
  ADD PRIMARY KEY (`course_id`,`user_id`),
  ADD KEY `courses_taken_fk2` (`user_id`);

--
-- Indexes for table `nominees`
--
ALTER TABLE `nominees`
  ADD PRIMARY KEY (`session_id`,`nominee_user_id`),
  ADD KEY `nominated_by_user_id` (`nominated_by_user_id`),
  ADD KEY `speak_test_id` (`speak_test_id`),
  ADD KEY `nominees_fk2` (`nominee_user_id`);

--
-- Indexes for table `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`session_id`,`nominee_user_id`),
  ADD KEY `publications_fk2` (`nominee_user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`session_id`,`nominee_user_id`,`gc_user_id`),
  ADD KEY `scores_fk2` (`nominee_user_id`),
  ADD KEY `scores_fk3` (`gc_user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `speak_test`
--
ALTER TABLE `speak_test`
  ADD PRIMARY KEY (`speak_test_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `user_roles_fk2` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `speak_test`
--
ALTER TABLE `speak_test`
  MODIFY `speak_test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `advisors`
--
ALTER TABLE `advisors`
  ADD CONSTRAINT `advisors_fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `courses_taken`
--
ALTER TABLE `courses_taken`
  ADD CONSTRAINT `courses_taken_fk1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_taken_fk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `nominees`
--
ALTER TABLE `nominees`
  ADD CONSTRAINT `nominees_fk1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`),
  ADD CONSTRAINT `nominees_fk2` FOREIGN KEY (`nominee_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `nominees_fk3` FOREIGN KEY (`nominated_by_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `nominees_fk4` FOREIGN KEY (`speak_test_id`) REFERENCES `speak_test` (`speak_test_id`);

--
-- Constraints for table `publications`
--
ALTER TABLE `publications`
  ADD CONSTRAINT `publications_fk1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`),
  ADD CONSTRAINT `publications_fk2` FOREIGN KEY (`nominee_user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_fk1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`),
  ADD CONSTRAINT `scores_fk2` FOREIGN KEY (`nominee_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `scores_fk3` FOREIGN KEY (`gc_user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_fk1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `user_roles_fk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
