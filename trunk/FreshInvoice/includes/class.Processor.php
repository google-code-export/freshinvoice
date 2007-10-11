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
		}
		
		if($entry->creditDebit == "C" && $entry->amount!="")
		{
			if(count($invoiceIds[1])==1)
			// SINGLE MATCH ON INVOICE ID
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
			// MULTIPLE MATCHES ON INVOICE IDS
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
				
				// TRY TO MATCH BY A ACCOUNTNUMBER
				$invoiceIds[1][0] = $this->matchByAccountNumber($entry->accountnr, $entry->amount);
				if(!$this->doPayment($invoiceIds[1][0])) $action = 12;
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
		$payment->__fill(NULL, NULL, $entry, $entry->accountnr, mktime(0,0,0,$entry->month,$entry->day,$entry->year), $entry->creditDebit, $entry->amount, $entry->transactionType, $entry->statement, $entry->original, $action, $invoiceIds);
		$payment->save();
	}
	
	public function matchSingleInvoice ($invoiceId, $amount)
	{
		$query = "SELECT factuurId, ROUND(bedrag,2) AS amount
		FROM factuur WHERE factuurId = '".mysql_real_escape_string($invoiceId)."' LIMIT 1";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)==0)
		{
			return false;
		}else
		{
			$record = mysql_fetch_array($query);
			
			if ($record['amount'] == $amount)
			{
				return true;
			}
			
			return false;
		}
	}
	
	public function matchMultipleInvoices ($invoiceIds = array(), $amount)
	{
		$query = "SELECT ROUND(SUM(bedrag),2) AS amount
		FROM factuur WHERE factuurId IN (".mysql_real_escape_string(implode(",", $invoiceIds)).")
		GROUP BY klantId LIMIT 1";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)==0)
		{
			return false;
		}else
		{
			$record = mysql_fetch_array($query);
			
			if ($record['amount'] == $amount)
			{
				return true;
			}
			
			return false;
		}
	}
	
	public function matchByAccountNumber ($accountNumber, $amount)
	{
		$query = "SELECT factuurId, ROUND(bedrag,2) AS amount FROM
		factuur f, klant_rekeningnummer k
		WHERE k.klantId=f.klantId AND
		k.nummer = '".mysql_real_escape_string($accountNumber)."' AND
		bedrag = '".mysql_real_escape_string($amount)."' AND betaald='C'
		ORDER BY factuurId ASC LIMIT 1";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)==1)
		{
			$record = mysql_fetch_array($query);
			return $record['factuurId'];
		}else
		{
			return false;
		}
	}
	
	public function doPayment ($invoiceID)
	{
		if($invoiceID=="") return false;
		
		$fact = new factuur();
		return $fact->factuur_betaald($invoiceID);
	}
	
	public function doStornation ($invoiceID)
	{
		if($invoiceID=="") return false;
		
		$fact = new factuur();
		return $fact->factuur_stornatie($invoiceID);
	}
}

?>