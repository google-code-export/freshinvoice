<?php

class Overige
{
	public function paymentTableHeader()
	{
		return '<table width="100%" border="0" cellspacing="0" cellpadding="1" id="information">
		  <tr>
		    <td><b>logID</b></td>
		    <td><b>Accountnr</b></td>
		    <td><b>Date</b></td>
		    <td><b>C/D</b></td>
		    <td><b>Amount</b></td>
		    <td><b>Statement</b></td>
		    <td><b>P-Type</b></td>
		    <td><b>Action</b></td>
		    <td><b>Aantal</b></td>
		    <td>&nbsp;</td>
		  </tr>';
	}
	
	public function paymentTableFooter()
	{
		return '</table>';
	}
	
	public function pageHeader ($title)
	{
		return '<table width="100%" border="0" cellspacing="0" cellpadding="1">
	  	  <tr>
            <td>'.$title.'</td>
          </tr>
		  <tr>
		    <td>&nbsp;</td>
		  </tr>
		</table>';
	}
	
	public function paymentTable ($logId, $accountnr, $date, $creditDebit, $amount, $statement, $ptype, $action, $tel, $aantal=0)
	{
		if($tel%2==0) $color = "FFFFFF"; else $color = "F4F4F4";
		$rows = count(explode("\n", trim($statement)));
		if($rows>4) $rows = 4;
		
		echo '<tr style="background: #'.$color.';">
		    <td>'.$logId.'</td>
		    <td>'.$accountnr.'</td>
		    <td>'.date("d-m-Y H:i", $date).'</td>
		    <td>'.$creditDebit.'</td>
		    <td>&euro; '.number_format($amount, 2, ",", ".").'</td>
		    <td><textarea rows="'.$rows.'" cols="50">'.htmlentities(trim($statement)).'</textarea></td>
		    <td>'.$ptype.'</td>
		    <td>'.$action.'</td>
		    <td>'.$aantal.'</td>
		    <td>[<a href="index.php?p=paymentchecked&logId='.$logId.'">checked</a>]</td>
		  </tr>';
	}
	
	public function printQueueToPrint ()
	{
		$printQueue = array();
		$query = "SELECT * FROM printQueue WHERE printed=0";
		$query = mysql_query($query) or die (mysql_error());
		while($record=mysql_fetch_assoc($query))
		{
			$printQueue[$record['queueId']] = new PrintQueue ();
			$printQueue[$record['queueId']]->__fill($record['queueId'], $record['print'], $record['times'], $record['printed']);
		}
		
		return $printQueue;
	}
}

?>