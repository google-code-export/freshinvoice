<?php

class FIMailer Extends PHPMailer
{
	function FIMailer ()
	{
		$this->__construct();
	}
	
	function __construct ()
	{
		switch(MAILER){
			case "qmail":
				$this->IsQmail(); // we're sending with qmail
			break;

			case "mail":
				$this->IsMail(); // we're sending with mail();
			break;

			case "sendmail":
				$this->IsSendmail(); // we're sending with qmail
			break;
				
			case "smtp":
				$this->IsSMTP(); // telling the class to use SMTP
				$this->Host = SMTP_HOST; // SMTP server
			break;
		}
	
		$this->WordWrap = 75;		// set the wordwrap
		
		$this->From     = MAILADDR;
		$this->FromName = FROMNAME;
	}
}

?>