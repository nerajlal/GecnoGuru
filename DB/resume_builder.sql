-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2025 at 01:43 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `resume_builder`
--

-- --------------------------------------------------------

--
-- Table structure for table `education_details`
--

CREATE TABLE IF NOT EXISTS `education_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `institute` varchar(255) NOT NULL,
  `year_of_passout` year(4) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `education_details`
--

INSERT INTO `education_details` (`id`, `user`, `qualification`, `institute`, `year_of_passout`, `percentage`, `created_at`) VALUES
(7, 'nerajnerajlal@gmail.com', 'Master''s', 'Snit', 2024, '78.00', '2025-03-28 11:51:12'),
(6, 'aparnavravi@gmail.com', 'Bachelor''s', 'IIT', 2023, '6.92', '2025-03-27 13:01:17'),
(8, 'syam@gmail.com', 'Master''s', 'Snit', 2024, '85.00', '2025-03-30 17:59:35');

-- --------------------------------------------------------

--
-- Table structure for table `experience_details`
--

CREATE TABLE IF NOT EXISTS `experience_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT '0',
  `job_description` text,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `experience_details`
--

INSERT INTO `experience_details` (`id`, `user`, `company_name`, `job_title`, `start_date`, `end_date`, `is_current`, `job_description`, `location`, `created_at`) VALUES
(4, 'nerajnerajlal@gmail.com', 'Serve Techno Research', 'Web Developer', '2022-09-25', '2024-09-25', 0, 'web developer who worked with web applications', 'Kollam', '2025-03-28 11:51:45'),
(3, 'aparnavravi@gmail.com', 'qspider', 'java developer', '2024-07-21', NULL, 0, 'java developer', 'kochi', '2025-03-27 13:02:15'),
(5, 'syam@gmail.com', 'Serve Techno Research', 'Web Developer', '2024-03-25', '2025-03-25', 0, 'dfsdfsd sdf sd  dsf', 'Kollam', '2025-03-30 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `hobbies_details`
--

CREATE TABLE IF NOT EXISTS `hobbies_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `hobby` varchar(255) NOT NULL,
  `hobby_description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `hobbies_details`
--

INSERT INTO `hobbies_details` (`id`, `user`, `hobby`, `hobby_description`) VALUES
(12, 'syam@gmail.com', 'Singinig', 'fg  f f sd f d fd sf sdf'),
(11, 'nerajnerajlal@gmail.com', 'Photography', 'Took photos of nature'),
(10, 'aparnavravi@gmail.com', 'Singinig', 'IM passonated in hearing music and collecting its details of ragaaaas.');

-- --------------------------------------------------------

--
-- Table structure for table `personal_details`
--

CREATE TABLE IF NOT EXISTS `personal_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text,
  `github` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `job_role` varchar(100) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `personal_details`
--

INSERT INTO `personal_details` (`id`, `user`, `name`, `email`, `phone`, `address`, `github`, `linkedin`, `job_role`, `description`, `created_at`) VALUES
(6, 'neraj@gmail.com', 'Aparna', 'aparnavravi@gmail.com', '9400281755', 'Arakkal tharavadu,nadhapuram,kannur', 'https://github.com/aparn4_v', 'https://linked.in/aparna', 'Java Developer', 'curently looking for java developer role,AS i was a btech graduate having 6 months of experience in java developing field.', '2025-03-27 13:00:49'),
(7, 'neraj@gmail.com', 'Neraj Lal S', 'nerajnerajlal@gmail.com', '08547470675', 'lal bhavan Mukkoodu p.o Mulavana', 'https://github.com/nerajlal', 'https://linked.in/nerajlal', 'Java Developer', 'Passionate java developer who have made the shills from online sources and documents', '2025-03-28 11:50:55'),
(8, 'neraj@gmail.com', 'Syam Lal', 'syam@gmail.com', '08547470675', 'lal bhavan Mukkoodu p.o Mulavana', 'https://github.com/nerajlal', 'https://linked.in/nerajlal', 'Java Developer', 'bw ck w cjk wc ewj cw', '2025-03-30 17:59:21');

-- --------------------------------------------------------

--
-- Table structure for table `projects_details`
--

CREATE TABLE IF NOT EXISTS `projects_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_description` text NOT NULL,
  `technologies` varchar(255) DEFAULT NULL,
  `project_link` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `projects_details`
--

INSERT INTO `projects_details` (`id`, `user`, `project_name`, `project_description`, `technologies`, `project_link`, `start_date`, `end_date`) VALUES
(4, 'nerajnerajlal@gmail.com', 'Serve The Needy', 'Which helps orphans and oldage homes to get their food', 'MongoDB, React, Express, Node', 'https://personalprofile.com', '2024-03-25', '2024-04-25'),
(3, 'aparnavravi@gmail.com', 'Hospital management', 'saving data of hospital', 'Java Spring Hibernate Html CSS', 'https://personalprofile.com', '2024-08-23', '2024-09-23'),
(5, 'syam@gmail.com', 'Serve The Needy', 'dcsdsd f sd f sdf sdf sd fsd', 'MongoDB, React, Express, Node', 'https://personalprofile.com', '2024-03-25', '2025-03-25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'neraj@gmail.com', 'Neraj123@', '2025-03-30 16:03:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_achievements`
--

CREATE TABLE IF NOT EXISTS `user_achievements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `achievement` varchar(255) NOT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `achievement_date` date DEFAULT NULL,
  `achievement_description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_achievements`
--

INSERT INTO `user_achievements` (`id`, `user`, `achievement`, `organization`, `achievement_date`, `achievement_description`, `created_at`) VALUES
(1, 'nerajnerajlal@gmail.com', 'IEDC Community Leadd', 'SNIT', '2024-02-29', 'IEDC Community Lead', '2025-03-30 08:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

CREATE TABLE IF NOT EXISTS `user_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `skill` varchar(255) NOT NULL,
  `proficiency` varchar(50) NOT NULL,
  `skill_description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_skills`
--

INSERT INTO `user_skills` (`id`, `user`, `skill`, `proficiency`, `skill_description`, `created_at`) VALUES
(1, 'nerajnerajlal@gmail.com', 'Java', 'Advanced', 'java full stack', '2025-03-28 12:37:46'),
(2, 'nerajnerajlal@gmail.com', 'Html', 'Expert', 'html online course', '2025-03-28 12:37:46');
