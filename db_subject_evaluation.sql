-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 14, 2012 at 09:13 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_subject_evaluation`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courses`
--

CREATE TABLE IF NOT EXISTS `tbl_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `description` text NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_courses`
--

INSERT INTO `tbl_courses` (`id`, `code`, `description`, `year`) VALUES
(1, 'CS', 'Computer Science', 1),
(2, 'IT', 'Information Technology', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_curriculums`
--

CREATE TABLE IF NOT EXISTS `tbl_curriculums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curriculum` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_curriculums`
--

INSERT INTO `tbl_curriculums` (`id`, `curriculum`) VALUES
(1, '2010-2011'),
(2, '2011-2012'),
(4, '2012-2013');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_evaluated_students`
--

CREATE TABLE IF NOT EXISTS `tbl_evaluated_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_evaluated_students`
--

INSERT INTO `tbl_evaluated_students` (`id`, `student_id`, `date`) VALUES
(12, 1, '2012-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_evaluated_subjects`
--

CREATE TABLE IF NOT EXISTS `tbl_evaluated_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbl_evaluated_subjects`
--

INSERT INTO `tbl_evaluated_subjects` (`id`, `subject_id`, `student_id`, `date`) VALUES
(18, 48, 1, '2012-10-08'),
(19, 46, 1, '2012-10-08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE IF NOT EXISTS `tbl_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_messages`
--

INSERT INTO `tbl_messages` (`id`, `message`, `student_id`) VALUES
(6, 'SSSSSSSSSSSS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE IF NOT EXISTS `tbl_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` text NOT NULL,
  `password` text NOT NULL,
  `first_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `last_name` text NOT NULL,
  `course_id` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`id`, `student_id`, `password`, `first_name`, `middle_name`, `last_name`, `course_id`, `semester`, `year`, `level`) VALUES
(1, 'oliver', 'oliver', 'Oliver', 'Middle', 'Martinez', 2, 1, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_grades`
--

CREATE TABLE IF NOT EXISTS `tbl_student_grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `tbl_student_grades`
--

INSERT INTO `tbl_student_grades` (`id`, `grade`, `subject_id`, `student_id`) VALUES
(22, 90, 33, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_subjects`
--

CREATE TABLE IF NOT EXISTS `tbl_student_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subjects`
--

CREATE TABLE IF NOT EXISTS `tbl_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `description` text NOT NULL,
  `units` int(11) NOT NULL,
  `prereq_subject_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `curriculum_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `tbl_subjects`
--

INSERT INTO `tbl_subjects` (`id`, `code`, `description`, `units`, `prereq_subject_id`, `course_id`, `year`, `semester`, `curriculum_id`) VALUES
(23, 'SSci100', 'Rizal''s Life', 3, 0, 2, 1, 1, 1),
(24, 'Econ101', 'Principles of Econ', 3, 0, 2, 1, 1, 1),
(25, 'ITCO111', 'Fundamentals of Computer Programming', 3, 0, 2, 1, 1, 1),
(26, 'ITLE101', 'Computer Fundamentals', 3, 0, 2, 1, 1, 1),
(28, 'Math101', 'College Algebra', 3, 0, 2, 1, 2, 1),
(29, 'ITCO601', 'Office Productivity Tools', 3, 25, 2, 1, 2, 1),
(30, 'ITCO201', 'Computer Programming', 3, 25, 2, 1, 2, 1),
(31, 'Hist100', 'Philippine History', 3, 0, 2, 1, 2, 1),
(33, 'Math102', 'Modern Plane Triginometry', 3, 28, 2, 2, 1, 1),
(34, 'Acct300', 'Basic Concepts of Accounting', 3, 0, 2, 2, 1, 1),
(35, 'ITCO204', 'Presentation Skill in IT', 3, 29, 2, 2, 1, 1),
(36, 'ITCO600', 'Computer Architecture', 3, 30, 2, 2, 1, 1),
(38, 'Math315', 'Discrete Mathematics', 3, 33, 2, 2, 2, 1),
(39, 'Stat101', 'Statistics and Probability', 3, 33, 2, 2, 2, 1),
(40, 'Acct301', 'Bookkeeping', 6, 34, 2, 2, 2, 1),
(41, 'ITLE104', 'Principles of OS', 3, 36, 2, 2, 2, 1),
(42, 'Fili101', 'Sining ng Pakikipagtalastasan', 3, 0, 2, 3, 1, 1),
(43, 'Phil101', 'Logic', 3, 0, 2, 3, 1, 1),
(44, 'ITCO305', 'Introduction to Internet', 3, 25, 2, 3, 1, 1),
(45, 'Fili102', 'Pagbasa at Pagsulat', 3, 42, 2, 3, 2, 1),
(46, 'Huma101', 'Intro to Arts', 3, 0, 2, 3, 2, 1),
(47, 'Acct310', 'Management Acctg for IT', 3, 40, 2, 3, 2, 1),
(48, 'ITCO610', 'IT Free Elective', 3, 0, 2, 3, 2, 1),
(49, 'ITPR343', 'Practicum1', 6, 0, 2, 4, 1, 1),
(50, 'ITLE109', 'Professional Ethics', 3, 26, 2, 4, 1, 1),
(51, 'ITCO611', 'IT Free Elective2', 3, 48, 2, 4, 1, 1),
(52, 'ITPR344', 'Practicum2', 9, 49, 2, 4, 2, 1),
(53, 'ITCO612', 'IT Free Elective3', 3, 51, 2, 4, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `password`, `level`) VALUES
(3, 'Admin', 'admin', 'admin', 0),
(4, 'Evaluator', 'evaluator', 'evaluator', 1),
(5, 'Teacher', 'teacher', 'teacher', 2),
(7, 'Records', 'records', 'records', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
