-- phpMyAdmin SQL Dump
-- version 2.9.1.1-Debian-4
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 26, 2007 at 06:18 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.3-0.dotdeb.1
-- 
-- Database: `freshinvoice`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `artikelen`
-- 

CREATE TABLE `artikelen` (
  `artikelId` int(11) NOT NULL auto_increment,
  `catId` int(11) NOT NULL default '0',
  `naam` varchar(255) NOT NULL default '',
  `periode` enum('jaar','halfjaar','kwartaal','maand','eenmalig') NOT NULL default 'jaar',
  `inkoop_prijs` varchar(15) NOT NULL default '',
  `verkoop_prijs` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`artikelId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

-- 
-- Table structure for table `categorie`
-- 

CREATE TABLE `categorie` (
  `catId` int(11) NOT NULL auto_increment,
  `catnaam` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`catId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `factuur`
-- 

CREATE TABLE `factuur` (
  `factuurId` int(11) NOT NULL auto_increment,
  `klantId` int(11) NOT NULL default '0',
  `bedrag` varchar(25) NOT NULL default '',
  `betaald` enum('Y','C','N') NOT NULL default 'N',
  `betaald_datum` int(11) NOT NULL default '0',
  `datum` int(11) NOT NULL default '0',
  `dag` int(2) NOT NULL default '0',
  `maand` int(2) NOT NULL default '0',
  `jaar` int(4) NOT NULL default '0',
  PRIMARY KEY  (`factuurId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- --------------------------------------------------------

-- 
-- Table structure for table `klant`
-- 

CREATE TABLE `klant` (
  `klantId` int(11) NOT NULL auto_increment,
  `mail` varchar(100) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `usergroup` smallint(2) NOT NULL default '1',
  `voornaam` varchar(50) NOT NULL default '',
  `tussenvoegsel` varchar(100) NOT NULL default '',
  `achternaam` varchar(75) NOT NULL default '',
  `geslacht` enum('M','V') NOT NULL default 'M',
  `bedrijfsnaam` varchar(100) NOT NULL default '',
  `straatnaam` varchar(150) NOT NULL default '',
  `huisnummer` varchar(10) NOT NULL default '',
  `postcode` varchar(7) NOT NULL default '',
  `plaatsnaam` varchar(100) NOT NULL default '',
  `land` varchar(50) NOT NULL default '',
  `telefoon` varchar(15) NOT NULL default '',
  `fax` varchar(15) NOT NULL default '',
  `BTWnummer` varchar(30) NOT NULL default '',
  `BTWtarrief` varchar(5) NOT NULL default '19.0',
  `KVKnummer` varchar(25) NOT NULL default '',
  `KVKplaats` varchar(255) NOT NULL default '',
  `bedrijfsvorm` varchar(255) NOT NULL,
  `factuur_opsparen` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`klantId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `klant_rekeningnummer`
-- 

CREATE TABLE `klant_rekeningnummer` (
  `rekeningId` int(11) NOT NULL auto_increment,
  `klantId` int(11) NOT NULL,
  `nummer` varchar(30) NOT NULL,
  PRIMARY KEY  (`rekeningId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `koppel_factuur_artikelen`
-- 

CREATE TABLE `koppel_factuur_artikelen` (
  `koppelId` int(11) NOT NULL auto_increment,
  `factuurId` int(11) NOT NULL default '0',
  `artikelId` int(11) NOT NULL default '0',
  `datum` int(11) NOT NULL default '0',
  `dag` smallint(2) NOT NULL default '0',
  `maand` smallint(2) NOT NULL default '0',
  `jaar` smallint(4) NOT NULL default '0',
  `opmerking` text NOT NULL,
  `opgezegd` enum('N','Y') NOT NULL default 'N',
  `aantal` varchar(5) NOT NULL default '0',
  PRIMARY KEY  (`koppelId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `paymentLog`
-- 

CREATE TABLE `paymentLog` (
  `logId` int(11) NOT NULL auto_increment,
  `time` int(11) NOT NULL,
  `entry` text NOT NULL,
  `eAccountnr` varchar(20) NOT NULL,
  `eDate` int(11) NOT NULL,
  `eCreditDebit` enum('C','D') NOT NULL,
  `eAmount` double NOT NULL,
  `eTransactionType` varchar(10) NOT NULL,
  `eStatement` text NOT NULL,
  `eOriginal` text NOT NULL,
  `action` tinyint(1) NOT NULL,
  `invoiceIds` text NOT NULL,
  `checked` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`logId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `paymentLogActions`
-- 

CREATE TABLE `paymentLogActions` (
  `actionId` int(11) NOT NULL auto_increment,
  `action` varchar(255) NOT NULL,
  `positive` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`actionId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `paymentLogActions`
-- 

INSERT INTO `paymentLogActions` (`actionId`, `action`, `positive`) VALUES 
(1, 'No match', 0),
(2, 'Single payment', 1),
(3, 'Multiple payments', 1),
(4, 'Complete failure', 0),
(5, 'Single payment failure', 0),
(6, 'Single payment update failure', 0),
(7, 'Multiple payments failure', 0),
(8, 'Multiple payments update failure', 0),
(9, 'Non credit / empty', 0),
(10, 'Stornation', 2),
(11, 'Stornation failure', 0),
(12, 'Single payment by accountnumber', 1);

-- 
-- Table structure for table `printQueue`
-- 

CREATE TABLE `printQueue` (
  `queueId` int(11) NOT NULL auto_increment,
  `print` text NOT NULL,
  `times` smallint(6) NOT NULL,
  `printed` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`queueId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;