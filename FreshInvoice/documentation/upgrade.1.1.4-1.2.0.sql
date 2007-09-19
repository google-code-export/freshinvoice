-- phpMyAdmin SQL Dump
-- version 2.6.1-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 19, 2007 at 10:24 PM
-- Server version: 5.0.27
-- PHP Version: 5.1.6
-- 
-- Database: `interlize`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `paymentLog`
-- 

CREATE TABLE IF NOT EXISTS `paymentLog` (
  `logId` int(11) NOT NULL auto_increment,
  `time` int(11) NOT NULL,
  `entry` text NOT NULL,
  `eAccountnr` varchar(20) NOT NULL,
  `eDate` int(11) NOT NULL,
  `eCreditDebit` enum('C','D') NOT NULL,
  `eAmount` double NOT NULL,
  `eTransactionType` varchar(10) NOT NULL,
  `eStatement` text NOT NULL,
  `action` tinyint(1) NOT NULL,
  `invoiceIds` text NOT NULL,
  `checked` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`logId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `paymentLogActions`
-- 

CREATE TABLE IF NOT EXISTS `paymentLogActions` (
  `actionId` int(11) NOT NULL auto_increment,
  `action` varchar(255) NOT NULL,
  `positive` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`actionId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
        