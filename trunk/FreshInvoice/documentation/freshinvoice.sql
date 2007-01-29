-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: 172.16.0.4
-- Generatie Tijd: 17 Oct 2005 om 21:44
-- Server versie: 4.1.10
-- PHP Versie: 5.0.4
-- 
-- Database: `freshinvoice`
-- 

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel `artikelen`
-- 

CREATE TABLE `artikelen` (
  `artikelId` int(11) NOT NULL auto_increment,
  `naam` varchar(255) NOT NULL default '',
  `periode` enum('jaar','halfjaar','kwartaal','maand','eenmalig') NOT NULL default 'jaar',
  `inkoop_prijs` varchar(15) NOT NULL default '',
  `verkoop_prijs` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`artikelId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel `factuur`
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=160 ;

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel `klant`
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
  `factuur_opsparen` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`klantId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel `koppel_factuur_artikelen`
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;
