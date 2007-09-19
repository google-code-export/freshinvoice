<?php
include_once(PATH."includes/class.Statement.php");

class Entry
{
	private $accountnr;
	private $day;
	private $month;
	private $year;
	private $creditDebit;
	private $amount;
	private $transactionType;
	private $statement;
	
	public function __construct ()
	{
		
	}
	
	public function __fill ($accountnr, $day, $month, $year, $creditDebit, $amount, $transactionType, $statement)
	{
		
		$this->statement 				= $statement;
		$this->day 						= $day;
		$this->month 					= $month;
		$this->year 					= $year;
		$this->creditDebit 				= $creditDebit;
		$this->amount 					= $amount;
		$this->transactionType 			= $transactionType;
		$this->accountnr 				= $accountnr;
	}
	
	public function __get ($name)
	{
		return $this->$name;
	}
	
	public function __set ($name, $value)
	{
		$this->$name = $value;
	}
}

?>