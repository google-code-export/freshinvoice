<?php
include_once(PATH."includes/class.Parser.php");
include_once(PATH."includes/class.Processor.php");

class Manager
{
	private $parser;
	private $processor;
	
	public function __construct ($bestand)
	{
		$this->parser = new Parser($bestand);
		$this->processor = new Processor($this->parser->__get("entries"));
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