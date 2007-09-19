<?php

class CustomerStatement
{
	private $transactionReference;
	private $relatedReference;
	private $accountInformation;
	private $statementnr;
	private $openingBalance;
	private $closingBalance;
	private $closingAvailableBalance;
	private $forwardAvailableBalance;
	private $informationAccountOwner;
	
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