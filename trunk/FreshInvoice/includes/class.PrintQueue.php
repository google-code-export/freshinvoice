<?php

class PrintQueue
{
	private $queueId;
	private $print;
	private $times;
	private $printed;
	
	public function __get ($name)
	{
		return $this->$name;
	}
	
	public function __set ($name, $value)
	{
		$this->$name = $value;
	}
	
	public function __fill ($queueId, $print, $times, $printed)
	{
		$this->queueId = $queueId;
		$this->print = $print;
		$this->times = $times;
		$this->printed = $printed;
	}
	
	public function load ($queueId)
	{
		$query 	= "SELECT * FROM `printQueue` WHERE `queueId` = ".mysql_real_escape_string($queueId)." LIMIT 1";
		$query 	= mysql_query($query) or die (mysql_error());
		$record = mysql_fetch_assoc($query);
		
		foreach ($record AS $name => $value)
		{
			$this->$name = $value;
		}
	}
	
	public function update ()
	{
		$query = "UPDATE `printQueue` SET `print` = '".mysql_real_escape_string($this->print)."',
		`times` = '".mysql_real_escape_string($this->times)."',
		`printed` = '".mysql_real_escape_string($this->printed)."'
		WHERE `queueId` = ".mysql_real_escape_string($this->queueId)." LIMIT 1;";
		return @mysql_query($query);
	}
	
	public function newSave ()
	{
		$query = "INSERT INTO `printQueue` ( `queueId` , `print` , `times` , `printed` )
		VALUES ('', '".mysql_real_escape_string($this->print)."', '".mysql_real_escape_string($this->times)."', '".mysql_real_escape_string($this->printed)."');";
		mysql_query($query) or die (mysql_error());
		$this->queueId = mysql_insert_id();
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