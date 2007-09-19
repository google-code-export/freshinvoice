<?php

class Heading
{
	private $header1;
	private $header2;
	private $header3;
	private $trailer;

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