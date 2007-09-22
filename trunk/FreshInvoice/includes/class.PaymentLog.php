<?php

class PaymentLog
{
	private $logId;
	private $time;
	private $entry;
	private $eAccountnr;
	private $eDate;
	private $eCreditDebit;
	private $eAmount;
	private $eTransactionType;
	private $eStatement;
	private $eOriginal;
	private $action;
	private $invoiceIds;
	
	public function __construct()
	{
	}
	
	public function __get ($name)
	{
		return $this->$name;
	}
	
	public function __set ($name, $value)
	{
		$this->$name = $value;
	}
	
	public function __fill ($logId, $time, $entry, $eAccountnr, $eDate, $eCreditDebit, $eAmount, $eTransactionType, $eStatement, $eOriginal, $action, $invoiceIds)
	{
		$this->logId = $logId;
		$this->time = $time;
		$this->entry = $entry;
		$this->eAccountnr = $eAccountnr;
		$this->eDate = $eDate;
		$this->eCreditDebit = $eCreditDebit;
		$this->eAmount = $eAmount;
		$this->eTransactionType = $eTransactionType;
		$this->eStatement = $eStatement;
		$this->eOriginal = $eOriginal;
		$this->action = $action;
		$this->invoiceIds = $invoiceIds;
	}
	
	public function load ($logId)
	{
		$query 	= "SELECT * FROM `paymentLog` WHERE `logId` = ".mysql_real_escape_string($logId)." LIMIT 1";
		$query 	= mysql_query($query) or die (mysql_error());
		$record = mysql_fetch_array($query);
		
		foreach ($record AS $name => $value)
		{
			$this->$name = $value;
		}
		
		$this->entry = unserialize($this->entry);
		$this->invoiceIds = unserialize($this->invoiceIds);
	}
	
	public function update ()
	{
		$query = "UPDATE `paymentLog` SET `time` = '".mysql_real_escape_string($this->time)."',
		`entry` = '".mysql_real_escape_string(serialize($this->entry))."',
		`eAccountnr` = '".mysql_real_escape_string($this->eAccountnr)."',
		`eDate` = '".mysql_real_escape_string($this->eDate)."',
		`eCreditDebit` = '".mysql_real_escape_string($this->eCreditDebit)."',
		`eAmount` = '".mysql_real_escape_string($this->eAmount)."',
		`eTransactionType` = '".mysql_real_escape_string($this->eTransactionType)."',
		`eStatement` = '".mysql_real_escape_string($this->eStatement)."',
		`eOriginal` = '".mysql_real_escape_string($this->eOriginal)."',
		`action` = '".mysql_real_escape_string($this->action)."',
		`invoiceIds` = '".mysql_real_escape_string(serialize($this->invoiceIds))."'
		WHERE `logId` =".mysql_real_escape_string($this->logId)." LIMIT 1;";
		return @mysql_query($query);
	}
	
	public function newSave ()
	{
		$query = "INSERT INTO `paymentLog` ( `logId` , `time` , `entry` , `eAccountnr` , `eDate` , `eCreditDebit` , `eAmount` , `eTransactionType` , `eStatement` , `eOriginal` , `action`, `invoiceIds`)
		VALUES ('', UNIX_TIMESTAMP( ) , '".mysql_real_escape_string(serialize($this->entry))."', '".mysql_real_escape_string($this->eAccountnr)."', '".mysql_real_escape_string($this->eDate)."',
		'".mysql_real_escape_string($this->eCreditDebit)."', '".mysql_real_escape_string($this->eAmount)."', '".mysql_real_escape_string($this->eTransactionType)."', 
		'".mysql_real_escape_string($this->eStatement)."', '".mysql_real_escape_string($this->eOriginal)."', '".mysql_real_escape_string($this->action)."', '".mysql_real_escape_string(serialize($this->invoiceIds))."');";
		mysql_query($query) or die (mysql_error());
		$this->logId = mysql_insert_id();
	}
	
	public function save ()
	{
		if(!$this->update())
		{
			$this->newSave();
		}
	}
}

?>