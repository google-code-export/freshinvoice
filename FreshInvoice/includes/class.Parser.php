<?php
include_once(PATH."includes/class.Heading.php");
include_once(PATH."includes/class.CustomerStatment.php");
include_once(PATH."includes/class.Entry.php");

class Parser
{
	private $content;
	private $heading;
	private $customerStatement;
	private $entries;
		
	public function __construct ($bestand)
	{
		$this->heading = new Heading();
		$this->customerStatement = new CustomerStatement();
		$this->entries = array();
		
		if($this->content = file_get_contents($bestand))
		{
			$this->parse();
		}
		
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
	
	public function parse ()
	{
		// GET THE HEADING
		$matches = $this->__singlemanualmatch("/([\d\w\s]+)\n([\d\w\s]+)\n([\d\w\s]+)\n/ise");
		
		$this->heading->__set("header1", $matches[1]);
		$this->heading->__set("header2", $matches[2]);
		$this->heading->__set("header3", $matches[3]);
		$this->__removeContent($matches[1]);
		$this->__removeContent($matches[2]);
		$this->__removeContent($matches[3]);
		unset($matches);
		
		// GET THE TRAILER
		$trailer = array_reverse(explode("\r\n", $this->content));
		foreach($trailer AS $rule)
		{
			if(preg_match("/([-X]+)/", $rule, $match))
			{
				$this->heading->__set("trailer", $match[1]);
				$this->__removeContent($match[0]);
				unset($match, $trailer);
				break;
			}
		}
		
		// GET THE TRANSACTION REFERENCE (:20:)
		$this->customerStatement->__set("transactionReference", $this->__match(20));
		
		// GET THE RELATED REFERENCE (:21:)
		$this->customerStatement->__set("relatedReference", $this->__match(21));
		
		// GET THE ACCOUNT IDENTIFICATION (:25:)
		$this->customerStatement->__set("accountInformation", $this->__match(25));
		
		// GET THE STATEMENT NR / SEQUENCE NR (:28[HEX]:)
		$this->customerStatement->__set("statementnr", $this->__match(28, "[A-Fa-f]{0,1}"));
		
		// GET THE OPENING BALANCE (:60[HEX]:) DOUBLE!
		$this->customerStatement->__set("openingBalance", $this->__match(60, "[A-Fa-f]{0,1}", "\,"));
		
		// GET THE CLOSING BALANCE (:62[HEX]:) DOUBLE!
		$this->customerStatement->__set("closingBalance", $this->__match(62, "[A-Fa-f]{0,1}", "\,"));
		
		// GET THE CLOSING AVAILABLE BALANCE (:64[HEX]:) DOUBLE!
		$this->customerStatement->__set("closingAvailableBalance", $this->__match(64, "[A-Fa-f]{0,1}", "\,"));
		
		// GET THE FORWARD AVAILABLE BALANCE (:65[HEX]:) DOUBLE!
		$this->customerStatement->__set("forwardAvailableBalance", $this->__match(65, "[A-Fa-f]{0,1}", "\,"));
		
		$this->removeEmptyLines($string);
		
		// GET THE ENTRIES
		$entries = explode(":61:", $this->content);
		unset($entries[0]); // NO USE IN AN EMPTY RECORD
		
		foreach($entries AS $key => $entry)
		{
			// REPAIR THE EXPLOSION
			$entry = ":61:".$entry;
			
			// ACCOUNT INFORMATION
			// :86: 11.11.11.111 A BLAAT OR :86:GIRO       11111 BLAAT.COM B.V.
			preg_match("/:86:\s*[A-Za-z]*\s*([\d\.]+)\s*([^$]+)/",$entry,$account);
			
			if($account[2]=="")
			{
				// WEIRD PAYMENT SYSTEMS AT SHOPS
				// :86:BEA   NR FN0806   13.09.07/17.57
				preg_match("/:86:([A-Za-z]+\s*NR\s*[A-Za-z\d]+)\s*([^$]+)/",$entry,$account);
			}
			
			// BOOKING INFORMATION
			preg_match("/:61:([\d]{2})([\d]{2})([\d]{2})([\d]{2})([\d]{2})([CDcd]{1})([0-9\,\.]+)([N0-9]{4})([A-Z]{6})/",$entry,$match);
			
			// STANDARDIZE NUMBERS FORMAT
			$match[7] = str_replace(".", "", $match[7]);
			$match[7] = str_replace(",", ".", $match[7]);
			
			// THE BANKS DON'T POST ZERO'S AS THE END, WE DON'T USE NUMBERS BEHIND THE COMMA'S IF ,00
			if(substr($match[7], -1)==".") $match[7] = substr($match[7], 0, -1);
			
			$this->entries[$key] = new Entry();
			$this->entries[$key]->__fill($account[1], $match[3], $match[2], $match[1], $match[6], $match[7], $match[8], $account[2], $entry);
		}
	}
	
	public function __match($messageInt, $hex='', $extra='')
	{
		// MATCH A RECORD
		preg_match("/\:".$messageInt.$hex."\:([\d\w\/".$extra."]+)/", $this->content, $match);
		
		// REMOVE THE MATCHED RECORDS
		$this->__removeContent($match[0]);
		
		return $match[1];
	}
	
	public function __manualmatch ($regEx)
	{
		preg_match_all($regEx, $this->content, $matches);
		return $matches;
	}
	
	public function __singlemanualmatch ($regEx)
	{
		preg_match($regEx, $this->content, $matches);
		return $matches;
	}
	
	public function __removeContent ($remove)
	{
		$this->content = str_replace($remove, "", $this->content);
	}
	
	public function removeEmptyLines($string)
	{
		$this->content = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $this->content);
	}
}

?>