<?php

class Statement
{
	private $tag;
	private $date;
	private $creditDebit;
	private $amount;
	private $transactionType;
	private $paymentRef;
	private $cs2;
	
	public function __construct ()
	{
		
	}
	
	public function __destruct ()
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
}

?>