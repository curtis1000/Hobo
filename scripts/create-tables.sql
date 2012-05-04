-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2012 at 02:10 AM
-- Server version: 5.1.58
-- PHP Version: 5.3.6-13ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `hobo`
--

-- --------------------------------------------------------

--
-- Table structure for table `hobo_content`
--

CREATE TABLE IF NOT EXISTS `hobo_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isGlobal` tinyint(4) NOT NULL DEFAULT '0',
  `routeName` varchar(128) DEFAULT NULL,
  `handle` varchar(255) NOT NULL,
  `contentType` VARCHAR( 64 ) NOT NULL,
  `content` text,
  `revision` int(11) NOT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `revision` (`revision`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;