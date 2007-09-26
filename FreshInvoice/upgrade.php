<?php
include_once('config.inc.php');

/* UPGRADE FUNCTIONS */

function field_exists ($field, $table)
{
	$query = "SHOW COLUMNS FROM ".mysql_real_escape_string($table);
	$query = mysql_query($query) or die (mysql_error());

	if (mysql_num_rows($query) > 0) {
    	while ($record = mysql_fetch_assoc($query)) {
        	if($record['Field']==$field)
        		return true;
    	}
	}
	
	return false;
}

function table_exists ($table)
{
	$query = "SHOW TABLES";
	$query = mysql_query($query) or die (mysql_error());

	if (mysql_num_rows($query) > 0) {
    	while ($record = mysql_fetch_row($query))
    	{    		
        	if($record[0]==$table)
        		return true;
    	}
	}
	
	return false;
}

/* UPGRADE INSTRUCTIONS */

if(!field_exists("catId","artikelen")) // version 1.1.3
{
	echo "Adding the category field<br />\n";
	$query = "ALTER TABLE `artikelen` ADD `catId` INT NOT NULL AFTER `artikelId`;";
	mysql_query($query) or die (mysql_error());
}

if(!table_exists("categorie")) // version 1.1.3
{
	echo "Creating the categorie table<br />\n";
	$query = "CREATE TABLE `categorie` (
	  `catId` int(11) NOT NULL auto_increment,
	  `catnaam` varchar(255) NOT NULL default '',
	  PRIMARY KEY  (`catId`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	mysql_query($query) or die (mysql_error());
}

if(!field_exists("bedrijfsvorm","klant")) // version 1.1.4
{
	echo "Adding the bedrijfsvorm field<br />\n";
	$query = "ALTER TABLE `klant` ADD `bedrijfsvorm` VARCHAR( 255 ) NOT NULL AFTER `KVKplaats` ;";
	mysql_query($query) or die (mysql_error());
}

if(!table_exists("paymentLog")) // version 1.2.0
{
	echo "Creating the paymentLog table<br />\n";
	$query = "CREATE TABLE IF NOT EXISTS `paymentLog` (
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
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	mysql_query($query) or die (mysql_error());
}

if(!table_exists("paymentLogActions")) // version 1.2.0
{
	echo "Creating the paymentLogActions table<br />\n";
	$query = "CREATE TABLE IF NOT EXISTS `paymentLogActions` (
	  `actionId` int(11) NOT NULL auto_increment,
	  `action` varchar(255) NOT NULL,
	  `positive` smallint(1) NOT NULL default '0',
	  PRIMARY KEY  (`actionId`)
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
	mysql_query($query) or die (mysql_error());
	
	echo "Adding standard paymentLogActions data<br />\n";
	$query = "INSERT INTO `paymentLogActions` (`actionId`, `action`, `positive`) VALUES 
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
	(12, 'Single payment by accountnumber', 1);";
	mysql_query($query) or die (mysql_error());
}

if(!table_exists("klant_rekeningnummer")) // version 1.2.0
{
	echo "Creating the klant_rekeningnummer table<br />\n";
	$query = "CREATE TABLE IF NOT EXISTS `klant_rekeningnummer` (
	`rekeningId` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`klantId` INT NOT NULL ,
	`nummer` VARCHAR( 30 ) NOT NULL
	) ENGINE = MYISAM ;";
	mysql_query($query) or die (mysql_error());
}

if(!table_exists("printQueue")) // version 1.2.0
{
	echo "Creating the printQueue table<br />\n";
	$query = "CREATE TABLE `printQueue` (
	  `queueId` int(11) NOT NULL auto_increment,
	  `print` text NOT NULL,
	  `times` smallint(6) NOT NULL,
	  `printed` smallint(1) NOT NULL default '0',
	  PRIMARY KEY  (`queueId`)
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
	mysql_query($query) or die (mysql_error());
}

echo '<h1>Upgrade done</h1><font color="red">Remove the upgrade.php file</font>';
?>