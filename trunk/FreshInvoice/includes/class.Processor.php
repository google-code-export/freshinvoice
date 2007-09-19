<?php
include_once(PATH."includes/class.PaymentLog.php");

class Processor
{
	private $entries;
	
	public function __construct ($entries)
	{
		$this->entries = $entries;
		
		foreach($this->entries AS $entry)
		{
			$this->match($entry);
		}
	}
	
	public function __destruct ()
	{
		
	}
	
	public function match ($entry)
	{
		if($entry->statement!="")
		{
			// MATCH FACTUURNUM(M)ER(S) FRE2968
			preg_match_all("/".INVOICEPREPEND."([0-9]{2,})/", $entry->statement, $invoiceIds);
			echo '<pre>';
			print_r($invoiceIds);
			echo '</pre>';
		}
		
		/*if($entry->creditDebit == "C" && $entry->amount!="")
		{	
			if(count($invoiceIds[1])==1)
			// SINGLE MATCH
			{
				$action = 2;
				if(!$this->matchSingleInvoice ($invoiceIds[1][0], $entry->amount))
				{
					$action = 5;
				}else
				{
					if(!$this->doPayment ($invoiceIds[1][0])) $action = 6;
				}
			}else if(count($invoiceIds[1]) > 1)
			// MULTIPLE MATCHES
			{
				$action = 3;
				if(!$this->matchMultipleInvoices ($invoiceIds[1], $entry->amount))
				{
					$action = 7;
				}else
				{
					foreach($invoiceIds[1] AS $invoiceID)
					{
						if(!$this->doPayment($invoiceID)) $action = 8;
					}
				}
			}else if (count($invoiceIds[1])==0)
			// NO MATCHES
			{
				$action = 1;
			}
		}else if ($entry->creditDebit == "D" && $entry->amount!="" && preg_match("/(STORNO)/", $entry->statement))
		{
			$action = 10;
			if(!$this->doStornation($invoiceIds[1][0])) $action = 11;
		}else
		{
			// NON PAYMENT / EMPTY
			$action = 9;
		}
		
		$payment = new PaymentLog();
		$payment->__fill(NULL, NULL, $entry, $entry->accountnr, mktime(0,0,0,$entry->month,$entry->day,$entry->year), $entry->creditDebit, $entry->amount, $entry->transactionType, $entry->statement, $action, $invoiceIds);
		$payment->save();*/
	}
	
	public function matchSingleInvoice ($invoiceId, $amount)
	{
		/*$query = "SELECT invoiceID, vatPercentage, totalPrice, ROUND(SUM(totalPrice * (1+(vatPercentage/100))),2) AS incl
		FROM invoice 
		WHERE invoiceID = '".mysql_real_escape_string($invoiceId)."' 
		GROUP BY invoiceID
		LIMIT 1";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)==0)
		{
			return false;
		}else
		{
			$record = mysql_fetch_array($query);
			
			if ($record['incl'] == $amount)
			{
				return true;
			}
			
			return false;
		}*/
	}
	
	public function matchMultipleInvoices ($invoiceIds = array(), $amount)
	{
		/*$query = "SELECT vatPercentage, totalPrice, ROUND(SUM(totalPrice * (1+(vatPercentage/100))),2) AS incl
		FROM invoice 
		WHERE invoiceID IN (".mysql_real_escape_string(implode(",", $invoiceIds)).")
		GROUP BY customerID
		LIMIT 1";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)==0)
		{
			return false;
		}else
		{
			$record = mysql_fetch_array($query);
			
			if ($record['incl'] == $amount)
			{
				return true;
			}
			
			return false;
		}*/
	}
	
	public function doPayment ($invoiceID)
	{
		/*if($invoiceID=="") return false;
		
		$query = "UPDATE `invoice` SET `payedDate` = NOW( ), `payed` = 'y' WHERE `invoiceID` = ".mysql_real_escape_string($invoiceID).";";
		if(!mysql_query($query))
		{
			return false;
		}else
		{
			return true;
		}*/
	}
	
	public function doStornation ($invoiceID)
	{
		/*if($invoiceID=="") return false;
		
		$query = "UPDATE `invoice` SET `payedDate` = '0000-00-00', `payed` = 'n' WHERE `invoiceID` = ".mysql_real_escape_string($invoiceID).";";
		if(!mysql_query($query))
		{
			return false;
		}else
		{
			return true;
		}*/
	}
}

?>