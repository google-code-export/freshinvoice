ALTER TABLE `artikelen` ADD `catId` INT NOT NULL AFTER `artikelId` ;

CREATE TABLE `categorie` (
  `catId` int(11) NOT NULL auto_increment,
  `catnaam` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`catId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;