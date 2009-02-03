<?
include_once('config.inc.php');

class factuur {
	
	function klant_invoegen ($mail,$password1,$password2,$voornaam,$tussenvoegsel,$achternaam,$geslacht,$bedrijfsnaam,$straatnaam,$huisnummer,$postcode,$plaatsnaam,$land,$telefoon,$fax,$BTWnummer,$KVKnummer,$KVKplaats,$bedrijfsvorm){
		if(!preg_match('/([A-Za-z0-9_.]+)@([A-Za-z0-9.]+)/',$mail)){
			$this->error('Er is geen e-mail adres opgegeven');
		}elseif(!isset($voornaam)){
			$this->error('Er is geen voornaam opgegeven');
		}elseif(!isset($achternaam)){
			$this->error('Er is geen achternaam opgegeven');
		}elseif(!isset($geslacht)){
			$this->error('Er is geen geslacht opgegeven');
		}elseif(!isset($straatnaam)){
			$this->error('Er is geen straatnaam opgegeven');
		}elseif(!isset($postcode)){
			$this->error('Er is geen postcode opgegeven');
		}elseif(!isset($plaatsnaam)){
			$this->error('Er is geen plaatsnaam opgegeven');
		}elseif(!isset($land)){
			$this->error('Er is geen land opgegeven');
		}elseif(!isset($telefoon)){
			$this->error('Er is geen telefoonnummer opgegeven');
		}elseif(!isset($password1)){
			$this->error('Er is geen password opgegeven');
		}elseif($password1!=$password2){
			$this->error('De opgegeven passwoorden komen niet overeen.');
		}elseif(!isset($BTWnummer) AND isset($bedrijfsnaam)){
			$this->error('Er is geen BTW nummer opgegeven');
		}elseif(!isset($KVKnummer) AND isset($bedrijfsnaam)){
			$this->error('Er is geen KVK nummer opgegeven');
		}elseif(!isset($KVKplaats) AND isset($bedrijfsnaam)){
			$this->error('Er is geen KVK plaats opgegeven');
		}elseif(!isset($bedrijfsvorm) AND isset($bedrijfsnaam)){
			$this->error('Er is geen bedrijfsvorm opgegeven');
		}else{
			$query = "SELECT klantId FROM klant WHERE mail=''";
			$query = mysql_query($query) or die (mysql_error());
			if(mysql_num_rows($query)>0){
				$this->error('Er komt al een klant voor met het opgegeven wachtwoord.<br />Indien u uw wachtwoord bent vergeten kunt u die via "Forgot password" terug halen.');
			}
			
			$query = "INSERT INTO klant (mail,password,voornaam,tussenvoegsel,achternaam,geslacht,bedrijfsnaam,straatnaam,huisnummer,postcode,plaatsnaam,land,telefoon,fax,BTWnummer,KVKnummer,KVKplaats,bedrijfsvorm)
			VALUES
			('".$mail."','".md5($password1)."','".addslashes($voornaam)."','".addslashes($tussenvoegsel)."','".addslashes($achternaam)."','".$geslacht."','".addslashes($bedrijfsnaam)."','".addslashes($straatnaam)."','".addslashes($huisnummer)."','".addslashes($postcode)."','".addslashes($plaatsnaam)."','".addslashes($land)."','".addslashes($telefoon)."','".addslashes($fax)."','".addslashes($BTWnummer)."','".addslashes($KVKnummer)."','".$KVKplaats."','".addslashes($bedrijfsvorm)."')";
			mysql_query($query) or die (mysql_error());
			
			$mailcontent  = "Geachte Heer/Mevrouw,\n\n";
			$mailcontent .= "Bij deze uw inlog gegevens voor het factuursysteem van ".BEDRIJFSNAAM.".\n";
			$mailcontent .= "Login:		".$mail."\n";
			$mailcontent .= "Password: 	".$password1."\n\n";
			$mailcontent .= AFSLUITING;
			
			mail($mail, 'Uw login gegevens', $mailcontent, 'From: '.MAILADDR);
			
			return TRUE;
		}
	}
	
	function change_persoonsgegevens($klantId,$mail,$voornaam,$tussenvoegsel,$achternaam,$geslacht,$bedrijfsnaam,$straatnaam,$huisnummer,$postcode,$plaatsnaam,$land,$telefoon,$fax,$BTWnummer,$KVKnummer,$KVKplaats,$bedrijfsvorm,$huidige_pass,$password1='',$password2='',$usergroup='',$factuur_opsparen='',$BTWtarrief=''){
		if(!preg_match('/([A-Za-z0-9_.]+)@([A-Za-z0-9.]+)/',$mail)){
			$this->error('Er is geen e-mail adres opgegeven');
		}elseif(!isset($voornaam)){
			$this->error('Er is geen voornaam opgegeven');
		}elseif(!isset($achternaam)){
			$this->error('Er is geen achternaam opgegeven');
		}elseif(!isset($geslacht)){
			$this->error('Er is geen geslacht opgegeven');
		}elseif(!isset($straatnaam)){
			$this->error('Er is geen straatnaam opgegeven');
		}elseif(!isset($postcode)){
			$this->error('Er is geen postcode opgegeven');
		}elseif(!isset($plaatsnaam)){
			$this->error('Er is geen plaatsnaam opgegeven');
		}elseif(!isset($land)){
			$this->error('Er is geen land opgegeven');
		}elseif(!isset($telefoon)){
			$this->error('Er is geen telefoonnummer opgegeven');
		}elseif(!isset($huidige_pass) AND !$this->allowed('99')){
			$this->error('Er is geen password opgegeven');
		}elseif(!isset($BTWnummer) AND isset($bedrijfsnaam)){
			$this->error('Er is geen BTW nummer opgegeven');
		}elseif(!isset($KVKnummer) AND isset($bedrijfsnaam)){
			$this->error('Er is geen KVK nummer opgegeven');
		}elseif(!isset($KVKplaats) AND isset($bedrijfsnaam)){
			$this->error('Er is geen KVK plaats opgegeven');
		}elseif(!isset($bedrijfsvorm) AND isset($bedrijfsnaam)){
			$this->error('Er is geen bedrijfsvorm opgegeven');
		}else{
			$query 	= "SELECT password FROM klant WHERE klantId='".$klantId."'";
			$query 	= mysql_query($query) or die (mysql_error());
			
			if(mysql_num_rows($query)==0){
				$this->error('Er is geen klant gevonden met het opgegeven klantId');
			}
			
			$extra = '';
			$record = mysql_fetch_array($query);
			
			if($record['password']!=md5($huidige_pass) AND !$this->allowed('99')){
				$this->error('Het opgegeven wachtwoord is incorrect.');
			}
			
			if(isset($password1) AND isset($password2) AND $password1!=''){
				if($password1!=$password2){
					$this->error('De opgegeven passwoorden komen niet overeen.');
				}else{
					$extra .= " ,password='".md5($password1)."'";
				}
			}
			
			if(isset($usergroup) AND $usergroup!='' AND $this->allowed('99')){
				$extra .= " ,usergroup='".addslashes($usergroup)."'";
			}
			
			if(isset($factuur_opsparen) AND $factuur_opsparen!='' AND $this->allowed('99')){
				$extra .= " ,factuur_opsparen='".addslashes($factuur_opsparen)."'";
			}
			
			if(isset($BTWtarrief) AND $BTWtarrief!='' AND $this->allowed('99')){
				$extra .= " ,BTWtarrief='".addslashes($BTWtarrief)."'";
			}
			
			$query = "UPDATE klant
			SET mail='".$mail."',voornaam='".addslashes($voornaam)."',tussenvoegsel='".addslashes($tussenvoegsel)."',achternaam='".addslashes($achternaam)."',
			geslacht='".addslashes($geslacht)."',bedrijfsnaam='".addslashes($bedrijfsnaam)."',straatnaam='".addslashes($straatnaam)."',huisnummer='".addslashes($huisnummer)."',
			postcode='".addslashes($postcode)."',plaatsnaam='".addslashes($plaatsnaam)."',land='".addslashes($land)."',telefoon='".addslashes($telefoon)."',fax='".addslashes($fax)."',
			BTWnummer='".addslashes($BTWnummer)."',KVKnummer='".addslashes($KVKnummer)."',KVKplaats='".addslashes($KVKplaats)."',bedrijfsvorm='".addslashes($bedrijfsvorm)."'
			".$extra." WHERE klantId='".$klantId."'";
			mysql_query($query) or die (mysql_error());
			
			return TRUE;
		}
	}
	
	function artikel_invoegen($naam, $catId, $periode, $inkoop_prijs, $verkoop_prijs) {
		if(!isset($naam)){
			$this->error('Er is geen artikel naam opgegeven');
		}elseif(!isset($catId)){
			$this->error('Er is geen categorie naam opgegeven');
		}elseif(!preg_match('/(jaar|maand|eenmalig|kwartaal|halfjaar)/',$periode)){
			$this->error('Er is geen periode opgegeven');
		}elseif(!isset($inkoop_prijs)){
			$this->error('Er is geen inkoop prijs opgegeven');
		}elseif(!isset($verkoop_prijs)){
			$this->error('Er is geen verkoop prijs opgegeven');
		}else{
			// VERPLAATS COMMA'S DOOR PUNTEN
			$inkoop_prijs	= str_replace(',','.',$inkoop_prijs);
			$verkoop_prijs	= str_replace(',','.',$verkoop_prijs);
			
			$query = "INSERT INTO artikelen (catId,naam,periode,inkoop_prijs,verkoop_prijs) VALUES ('".$catId."','".addslashes($naam)."','".$periode."','".$inkoop_prijs."','".$verkoop_prijs."')";
			mysql_query($query) or die (mysql_error());
			
			return TRUE;
		}
	}
	
	function edit_artikel($artikelId, $naam, $catId, $periode, $inkoop_prijs, $verkoop_prijs){
		if(!isset($artikelId)){
			$this->error('Er is geen artikelId opgegeven');
		}elseif(!isset($naam)){
			$this->error('Er is geen artikel naam opgegeven');
		}elseif(!isset($catId)){
			$this->error('Er is geen categorie opgegeven');
		}elseif(!preg_match('/(jaar|maand|eenmalig|kwartaal|halfjaar)/',$periode)){
			$this->error('Er is geen periode opgegeven');
		}elseif(!isset($inkoop_prijs)){
			$this->error('Er is geen inkoop prijs opgegeven');
		}elseif(!isset($verkoop_prijs)){
			$this->error('Er is geen verkoop prijs opgegeven');
		}else{
			// VERPLAATS COMMA'S DOOR PUNTEN
			$inkoop_prijs	= str_replace(',','.',$inkoop_prijs);
			$verkoop_prijs	= str_replace(',','.',$verkoop_prijs);
			
			$query = "UPDATE artikelen SET catId='".$catId."',naam='".addslashes($naam)."',periode='".$periode."',inkoop_prijs='".$inkoop_prijs."',verkoop_prijs='".$verkoop_prijs."' WHERE artikelId='".$artikelId."'";
			mysql_query($query) or die (mysql_error());
			
			return TRUE;
		}
	}
	
	function delete_artikel($artikelId, $shure)
	{
		if(!isset($shure) OR $shure!='yes'){
			$this->error('Er is geen confirmatie gegeven');
		}elseif(!isset($artikelId)){
			$this->error('Er is geen artikelId opgegeven');
		}else{
			$query = "DELETE FROM artikelen WHERE artikelId='".$artikelId."' LIMIT 1";
			mysql_query($query) or die (mysql_error());
			
			return TRUE;
		}
	}
	
	function categorie_invoegen ($naam)
	{
		if(!isset($naam)){
			$this->error('Er is geen naam opgegeven');
		}else{
			$query = "INSERT INTO categorie (catnaam) VALUES ('".addslashes($naam)."')";
			mysql_query($query) or die (mysql_error());
			
			return TRUE;
		}
	}
	
	function delete_categorie($catId, $shure)
	{
		if(!isset($shure) OR $shure!='yes'){
			$this->error('Er is geen confirmatie gegeven');
		}elseif(!isset($catId)){
			$this->error('Er is geen catId opgegeven');
		}else{
			$query = "DELETE FROM categorieen WHERE catId='".$catId."' LIMIT 1";
			mysql_query($query) or die (mysql_error());
			
			return TRUE;
		}
	}
	
	function edit_categorie ($catId, $naam)
	{
		if(!isset($catId)){
			$this->error('Er is geen catId opgegeven');
		}elseif(!isset($naam)){
			$this->error('Er is geen artikel naam opgegeven');
		}else{			
			$query = "UPDATE categorie SET catnaam='".addslashes($naam)."' WHERE catId='".$catId."'";
			mysql_query($query) or die (mysql_error());
			
			return TRUE;
		}
	}
	
	function nieuwe_factuur($klantId){
		if(!isset($klantId)){
			$this->error('Er is geen klantId opgegeven');
		}else{
			$query = "SELECT max(factuurId) AS factuurId FROM factuur";
			$query = mysql_query($query) or die (mysql_error());
			$record = mysql_fetch_assoc($query);
			$factuurId = $record['factuurId']+1;
			
			$query = "INSERT INTO factuur (factuurId,klantId,datum,dag,maand,jaar) VALUES ('".$factuurId."','".$klantId."','".time()."','".date('d')."','".date('m')."','".date('Y')."')";
			mysql_query($query) or die (mysql_error());
			
			return mysql_insert_id();
		}
	}
	
	function insert_factuur_artikel($factuurId,$artikelId,$opmerking,$aantal) {
		if(!isset($factuurId)){
			$this->error('Er is geen factuurId opgegeven');
		}elseif(!isset($artikelId)){
			$this->error('Er is geen artikelId opgegeven');
		}elseif(!isset($aantal) OR !preg_match("/([0-9]+)/", $aantal)){ // ALLEEN GETALLEN
			$this->error('Er is geen aantal opgegeven');
		}else{
			$query = "INSERT INTO koppel_factuur_artikelen (factuurId,artikelId,datum,dag,maand,jaar,opmerking,aantal) VALUES ('".$factuurId."','".$artikelId."','".time()."','".date("d")."','".date("m")."','".date("Y")."','".addslashes($opmerking)."','".$aantal."')";
			mysql_query($query) or die (mysql_error());
			
			return TRUE;
		}
	}
	
	function finish_factuur ($factuurId, $writedispl, $klantId=''){
		
		$queryk	= "SELECT f.klantId, f.datum, voornaam, tussenvoegsel, achternaam, bedrijfsnaam, straatnaam, huisnummer, postcode, plaatsnaam, land, BTWtarrief
		FROM factuur f, klant k
		WHERE f.klantId=k.klantId
		AND factuurId='".$factuurId."'";
		if($klantId!='') $queryk .= " AND f.klantId='".$klantId."'";
		$queryk	= mysql_query($queryk) or die (mysql_error());
		
		if(mysql_num_rows($queryk)==0){
			$this->error('Er is geen factuur gevonden die aan deze eisen voldoet.');
		}
		
		$klant  = mysql_fetch_array($queryk) or die (mysql_error());
		
		$fp 		= fopen(PATH.'templates/factuur.tpl.php', 'r');
		$factuurTPL = fread($fp, filesize(PATH.'templates/factuur.tpl.php'));
		$display	= $factuurTPL;
		fclose($fp);
		
		// TEMPLATES DEFINES
		$rep['LOGO']						= FACTUUR_LOGO;
		$rep['FACTUURID'] 					= $factuurId;
		$rep['FACTUURDATUM']				= date(FACTUUR_DATUM_FORMAT, $klant['datum']);
		$rep['KLANTID']						= $klant['klantId'];
		$rep['KLANTNAAM']					= stripslashes($klant['voornaam'].' '.$klant['tussenvoegsel'].' '.$klant['achternaam']);
		$rep['KLANTADRES']					= stripslashes($klant['straatnaam'].' '.$klant['huisnummer'].'<br />'.$klant['postcode'].' '.$klant['plaatsnaam'].'<br />'.$klant['land']);
		$rep['BTWTARRIEF']					= $klant['BTWtarrief'];
		$rep['FACTUURINHOUD']				= '';
		$rep['SUBTOTAAL']					= '';
		$rep['BTWBEDRAG']					= '';
		$rep['FACTUURTOTAAL']				= '';
		$rep['INVOICEPREPEND']				= INVOICEPREPEND;
		$rep['INVOICEEXPIREDATE']			= date(FACTUUR_DATUM_FORMAT, mktime(0,0,0,date("m",$klant['datum']),date("d",$klant['datum'])+BETALINGS_TERMIJN,date("Y",$klant['datum'])));
		
		if($klant['bedrijfsnaam']){
			$rep['KLANTBEDRIJFSNAAM'] 		= $klant['bedrijfsnaam'].'<br />';
		}else{
			$rep['KLANTBEDRIJFSNAAM']		= '';
		}
		
		$query = "SELECT k.artikelId, datum, opmerking, aantal, naam, periode, verkoop_prijs, aantal*verkoop_prijs AS totaal
		FROM koppel_factuur_artikelen k, artikelen a
		WHERE k.artikelId=a.artikelId AND
		k.factuurId='".$factuurId."'";
		$query = mysql_query($query) or die (mysql_error());
		while($record=mysql_fetch_array($query)){
			$rep['SUBTOTAAL'] = $rep['SUBTOTAAL']+$record['totaal'];
			$rep['FACTUURINHOUD'] .= '<tr>
				<td width="50%" valign="top">'.$record['naam'];
				if(isset($record['opmerking'])){
					$rep['FACTUURINHOUD'] .= ' '.nl2br($record['opmerking']);
				}
				$rep['FACTUURINHOUD'] .= '</td>
				<td width="10%" valign="top">'.date(FACTUUR_DATUM_FORMAT, $record['datum']).'</td>
				<td width="10%" valign="top">'.$record['periode'].'</td>
				<td width="10%" valign="top">'.$record['aantal'].'</td>
				<td width="10%" valign="top" align="right">'.$this->displayMoney($record['verkoop_prijs']).'</td>
				<td width="10%" valign="top" align="right">'.$this->displayMoney($record['totaal']).'</td>
			  </tr>'."\n";
		}
		
		$rep['BTWBEDRAG'] 		= $rep['SUBTOTAAL']*($klant['BTWtarrief']/100);
		$rep['FACTUURTOTAAL'] 	= $rep['SUBTOTAAL']*(1+($klant['BTWtarrief']/100));
		$saveTOTAAL				= $rep['FACTUURTOTAAL'];
		
		$rep['SUBTOTAAL'] 		= $this->displayMoney($rep['SUBTOTAAL']);
		$rep['BTWBEDRAG'] 		= $this->displayMoney($rep['BTWBEDRAG']);
		$rep['FACTUURTOTAAL'] 	= $this->displayMoney($rep['FACTUURTOTAAL']);
		
		$regEx = '/{#([A-Za-z0-9]+)#}/';
		preg_match_all($regEx, $factuurTPL, $matches);
		
		foreach($matches[0] AS $key => $REPL){
			$display = str_replace($REPL, $rep[$matches[1][$key]], $display);
		}
		  
		if($writedispl=='DISP'){
			echo $display;
		}elseif($writedispl=='WRITE'){
			$query = "UPDATE factuur SET bedrag='".$saveTOTAAL."' WHERE factuurId='".$factuurId."'";
			mysql_query($query) or die (mysql_error());
			
			return $display;
		}
	}
	
	function mail_factuur ($factuurId, $content, $resend=''){
		$query = "SELECT f.datum, k.mail, k.geslacht, k.tussenvoegsel, k.achternaam, k.bedrijfsnaam, k.factuur_opsparen
		FROM factuur f, klant k
		WHERE f.klantId=k.klantId AND
		f.factuurId='".$factuurId."'";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)==0){
			exit;
		}
		
		$record = mysql_fetch_array($query);
		
		$aanhef = $this->aanhef($record['geslacht']);
		$klantnaam = $this->klantnaam ($aanhef, $record['tussenvoegsel'], $record['achternaam']);
		
		$text  	= "Geachte ".$klantnaam.",\n\n";
		$text  .= "Bij deze uw openstaande factuur.\n";
		$text  .= "Gelieve deze factuur binnen ".BETALINGS_TERMIJN." dagen na de factuurdatum (".date(FACTUUR_DATUM_FORMAT, $record['datum']).") te voldoen.\n\n";
		$text  .= AFSLUITING."\n\n";
		$text  .= "PS. Deze mail en de factuur zijn automatisch gegenereerd.\n";
		$text  .= "Indien u fouten constateert, gelieven contact op te nemen met: ".MAILADDR;
		
		$mail = new FIMailer();
		$mail->Subject  = 'Factuur '.INVOICEPREPEND.$factuurId.' '.BEDRIJFSNAAM;
		$mail->Body    	= $text;
		$mail->AddAddress(MAILADDR, FROMNAME);
		$mail->AddAddress($record['mail'], $klantnaam);
		if($record['bedrijfsnaam']!=''){
			$mail->AddStringAttachment($content, INVOICEPREPEND.$factuurId."-".urlencode($record['bedrijfsnaam']).".html");
		}else{
			$mail->AddStringAttachment($content, INVOICEPREPEND.$factuurId."-".urlencode($record['achternaam']).".html");
		}
		
		if(!$mail->Send()){
		   echo "Mailer Error: ".$record['mail']." => ".$mail->ErrorInfo."\n";
		}
		
		$mail->ClearAddresses();
		$mail->ClearAttachments();
		
		$extra = "";
		if($record['factuur_opsparen']=='Y' AND $resend!='RESEND'){
			$extra .= ", datum='".time()."', dag='".date('d')."', maand='".date("m")."', jaar='".date("Y")."'";
		}
		
		$query = "UPDATE factuur SET betaald='C'$extra WHERE factuurId='".$factuurId."'";
		mysql_query($query) or die (mysql_error());
	}
	
	function factuur_creator ($sumfactuur){
		$query = "SELECT factuurId FROM factuur f, klant k 
		WHERE f.klantId=k.klantId AND
		f.betaald='N' AND k.factuur_opsparen='".$sumfactuur."'";
		$query = mysql_query($query) or die (mysql_error());
		$count = 0;
		if(mysql_num_rows($query)>0){
			while($record=mysql_fetch_array($query)){
				if($sumfactuur=='Y') $this->reset_invoice_date($record['factuurId']);
				
				// CREATE THE INVOICE
				$content = $this->finish_factuur($record['factuurId'], 'WRITE');
				
				// MAIL THE INVOICE
				$this->mail_factuur($record['factuurId'],$content);
				
				// ADD THE INVOICE TO THE PRINTQUEUE
				$printQueue = new PrintQueue();
				$printQueue->__fill (NULL, $content, 2, 0);
				$printQueue->save();
				
				$count++;
			}
		}
	}
	
	function reset_invoice_date ($factuurId)
	{
		$query = "UPDATE `factuur` SET `datum` = UNIX_TIMESTAMP() ,
		`dag` = '".date("d")."', `maand` = '".date("m")."', `jaar` = '".date("Y")."'
		WHERE `factuur`.`factuurId` = '".mysql_real_escape_string($factuurId)."' LIMIT 1 ;";
		mysql_query($query) or die (mysql_error());
	}
	
	function sendnow_factuur ($factuurId){
		$this->resend_factuur($factuurId);
		return true;
	}	
	
	function resend_factuur ($factuurId){
		$content = $this->finish_factuur($factuurId, 'WRITE');
		$this->mail_factuur($factuurId,$content,'RESEND');
		
		return true;
	}
	
	function reprint_factuur ($factuurId)
	{
		// CREATE THE INVOICE
		$content = $this->finish_factuur($factuurId, 'WRITE');
		
		// ADD THE INVOICE TO THE PRINTQUEUE
		$printQueue = new PrintQueue();
		$printQueue->__fill (NULL, $content, 1, 0);
		$printQueue->save();
		
		return true;
	}
	
	function auto_herhaal ($periode, $sign='='){
		switch($periode){
			case "jaar":
				$time 	= mktime(0,0,0,date("m"),date("d"),date("Y")-1);
			break;

			case "halfjaar":
				$time 	= mktime(0,0,0,date("m")-6,date("d"),date("Y"));
			break;

			case "kwartaal":
				$time 	= mktime(0,0,0,date("m")-3,date("d"),date("Y"));
			break;
			
			case "maand":
				$time 	= mktime(0,0,0,date("m")-1,date("d"),date("Y"));
			break;
		}

		$query 	= "SELECT k.artikelId, k.opmerking, k.aantal, f.klantId
		FROM koppel_factuur_artikelen k, artikelen a, factuur f
		WHERE k.artikelId=a.artikelId AND
		k.factuurId=f.factuurId AND
		a.periode='".$periode."' AND
		k.dag ".$sign." '".date("d",$time)."' AND
		k.maand='".date("m",$time)."' AND
		k.jaar='".date("Y",$time)."' AND
		k.opgezegd='N'";
		$query 	= mysql_query($query) or die (mysql_error());
		while($record=mysql_fetch_array($query)){
			$querys = "SELECT factuurId FROM factuur WHERE klantId='".$record['klantId']."' AND betaald='N'";
			$querys = mysql_query($querys) or die (mysql_error());
			if(mysql_num_rows($querys)==0){
				$queryi = "INSERT INTO factuur (klantId, datum, dag, maand, jaar) VALUES ('".$record['klantId']."','".time()."','".date('d')."','".date('m')."','".date("Y")."')";
				mysql_query($queryi) or die (mysql_error());
				$factuurId = mysql_insert_id();
			}else{
				$factuur = mysql_fetch_array($querys);
				$factuurId = $factuur['factuurId'];
			}
			
			$queryi = "INSERT INTO koppel_factuur_artikelen (factuurId,artikelId,datum,dag,maand,jaar,opmerking,aantal)
			VALUES ('".$factuurId."','".$record['artikelId']."','".time()."','".date("d")."','".date("m")."','".date("Y")."','".addslashes($record['opmerking'])."','".$record['aantal']."')";
			mysql_query($queryi) or die (mysql_error());
		}
	}
	
	function late_facturen_notificatie (){
		$time = mktime(0,0,1,date('m'),date('d')-BETALINGS_NOTIFICATIE,date('Y'));
		$query = "SELECT f.factuurId, f.datum, f.bedrag, k.geslacht, k.tussenvoegsel, k.achternaam, k.mail, k.bedrijfsnaam
		FROM factuur f, klant k
		WHERE f.klantId=k.klantId AND
		datum <= '".$time."' AND
		betaald='C'";
		$query = mysql_query($query) or die (mysql_error());
		while($record=mysql_fetch_array($query)){
			$aanhef = $this->aanhef($record['geslacht']);
			$klantnaam = $this->klantnaam ($aanhef, $record['tussenvoegsel'], $record['achternaam']);
			
			$verloop = date(FACTUUR_DATUM_FORMAT,$record['datum']+(BETALINGS_TERMIJN*(60*60*24)));
			
			$text  	 = "Geachte ".$klantnaam.",\n\n";
			$text   .= "Bij deze wijs ik u op de nog openstaande factuur met het ID: ".$record['factuurId']." van ".date(FACTUUR_DATUM_FORMAT,$record['datum']).". ";
			$text   .= "Deze verloopt op ".$verloop.". Nadat de betalingstermijn verlopen is, zullen wij contact met u opnemen en indien nodig passende acties ondernemen.\n\n";
			$text   .= "U kunt uw factuur opzoeken via ons factuursysteem, dat te vinden is op het volgende adres: ";
			$text   .= URL."\n\nIk hoop u hierbij voldoende te hebben geinformeerd.\n\n";
			$text   .= AFSLUITING;
			
			$mail = new FIMailer();
			$mail->Subject  = 'Factuur '.INVOICEPREPEND.$record['factuurId'].' '.BEDRIJFSNAAM;
			$mail->Body    	= $text;
			$mail->AddAddress(MAILADDR, FROMNAME);
			$mail->AddAddress($record['mail'], $klantnaam);
			
			if(date('D')=='Mon'){
				$content = $this->finish_factuur($record['factuurId'], 'WRITE');
				if($record['bedrijfsnaam']!=''){
					$mail->AddStringAttachment($content, INVOICEPREPEND.$record['factuurId']."-".urlencode($record['bedrijfsnaam']).".html");
				}else{
					$mail->AddStringAttachment($content, INVOICEPREPEND.$record['factuurId']."-".urlencode($record['achternaam']).".html");
				}
			}
			
			if(!$mail->Send()){
			   echo "Mailer Error: ".$record['mail']." => ".$mail->ErrorInfo."\n";
			}
			
			$mail->ClearAddresses();
		}
	}
	
	function factuur_stornatie ($factuurId){
		$query = "UPDATE factuur SET betaald='Y', betaald_datum='".time()."' WHERE factuurId='".$factuurId."'";
		mysql_query($query) or die (mysql_error());
		
		$query = "SELECT factuurId, f.klantId, f.datum, k.mail, k.geslacht, k.tussenvoegsel, k.achternaam
		FROM factuur f, klant k
		WHERE f.klantId=k.klantId
		AND f.factuurId='".$factuurId."'";
		$query = mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($query)==0){
			$this->error('Factuur niet gevonden.');
		}
		
		$record = mysql_fetch_array($query);
		
		$aanhef = $this->aanhef($record['geslacht']);
		$klantnaam = $this->klantnaam ($aanhef, $record['tussenvoegsel'], $record['achternaam']);
		
		$text  	= "Geachte ".$klantnaam.",\n\n";
		$text  .= "Via deze weg wil ik u graag op de hoogte stellen, dat we een stornatie hebben ontvangen ";
		$text  .= "op de door ons geincasseerde factuur, met het nummer ".INVOICEPREPEND.$factuurId.".\n";
		$text  .= "Ik wil u verzoeken om contact met onze administratie afdeling op te nemen.\n\nAlvast bedankt.\n\n";
		$text  .= AFSLUITING;
		
		$mail = new FIMailer();
		$mail->Subject  = 'Stornatie factuur '.INVOICEPREPEND.$record['factuurId'].' '.BEDRIJFSNAAM;
		$mail->Body    	= $text;
		$mail->AddAddress(MAILADDR, FROMNAME); // CC TO ME
		$mail->AddAddress($record['mail'], $klantnaam);
		
		if(!$mail->Send()){
		   echo "Mailer Error: ".$record['mail']." => ".$mail->ErrorInfo."\n";
		}
		
		$mail->ClearAddresses();
		
		return TRUE;
	}
	
	function isFactuurBetaald ($factuurId)
	{
		$query = "SELECT betaald FROM factuur WHERE factuurId='".mysql_real_escape_string($factuurId)."'";
		$query = mysql_query($query) or die (mysql_error());
		$record = mysql_fetch_array($query);
		
		if($record['betaald']=='Y')
		{
			return true;
		}
		
		return false;
	}
	
	function factuur_betaald ($factuurId){
		$query = "UPDATE factuur SET betaald='Y', betaald_datum='".time()."' WHERE factuurId='".$factuurId."'";
		mysql_query($query) or die (mysql_error());
		
		$query = "SELECT factuurId, f.klantId, f.datum, k.mail, k.geslacht, k.tussenvoegsel, k.achternaam
		FROM factuur f, klant k
		WHERE f.klantId=k.klantId
		AND f.factuurId='".$factuurId."'";
		$query = mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($query)==0){
			$this->error('Factuur niet gevonden.');
		}
		
		$record = mysql_fetch_array($query);
		
		$aanhef = $this->aanhef($record['geslacht']);
		$klantnaam = $this->klantnaam ($aanhef, $record['tussenvoegsel'], $record['achternaam']);
		
		$text  	= "Geachte ".$klantnaam.",\n\n";
		$text  .= "Bij deze wil ik u graag op de hoogte stellen dat de betaling van de factuur met het nummer: ".INVOICEPREPEND.$factuurId." is ontvangen.\n\n";
		$text  .= AFSLUITING;
		
		$mail = new FIMailer();
		$mail->Subject  = 'Factuur '.INVOICEPREPEND.$record['factuurId'].' '.BEDRIJFSNAAM;
		$mail->Body    	= $text;
		$mail->AddAddress(MAILADDR, FROMNAME); // CC TO ME
		$mail->AddAddress($record['mail'], $klantnaam); // SEND TO CLIENT
		
		if(!$mail->Send()){
		   echo "Mailer Error: ".$record['mail']." => ".$mail->ErrorInfo."\n";
		}
		
		$mail->ClearAddresses();
		
		return TRUE;
	}
	
	function artikel_opzeggen($koppelId){
		$query = "UPDATE koppel_factuur_artikelen SET opgezegd='Y' WHERE koppelId='".$koppelId."'";
		mysql_query($query) or die (mysql_error());
		
		return TRUE;
	}
	
	function artikel_delete($koppelId){
		$query = "DELETE FROM koppel_factuur_artikelen WHERE koppelId='".$koppelId."'";
		mysql_query($query) or die (mysql_error());
		
		return TRUE;
	}
	
	function rekening_toevoegen ($klantId, $nummer)
	{
		if($klantId!="" && $nummer!="")
		{
			$query = "INSERT INTO `klant_rekeningnummer` ( `rekeningId` , `klantId` , `nummer` ) VALUES 
			(NULL , '".mysql_real_escape_string($klantId)."', '".mysql_real_escape_string($nummer)."');";
			mysql_query($query) or die (mysql_error());
		
			return true;
		}else
		{
			return false;
		}
	}
	
	function rekening_verwijderen ($rekeningId)
	{
		if($rekeningId!="")
		{
			$query = "DELETE FROM `klant_rekeningnummer` WHERE rekeningId=".$rekeningId." LIMIT 1;";
			mysql_query($query) or die (mysql_error());
		
			return true;
		}else
		{
			return false;
		}
	}
	
	function delete_factuur($factuurId){
		$query = "SELECT factuurId FROM factuur WHERE betaald='N' AND factuurId='".$factuurId."'";
        $query = mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($query)==1){
			$queryd = "DELETE FROM factuur WHERE betaald='N' AND factuurId='".$factuurId."'";
			mysql_query($queryd) or die (mysql_error());

			$queryd = "DELETE FROM koppel_factuur_artikelen WHERE factuurId=$factuurId";
			mysql_query($queryd) or die (mysql_error());

			//factuur nummer aanpassen na delete factuur (prosolit.nl)
			$queryd = "SELECT MAX(factuurId)+1 AS factuurId FROM factuur";
			$queryd = mysql_query($queryd) or die (mysql_error());
			$record = mysql_fetch_array($queryd) or die (mysql_error());
			$queryd = "ALTER TABLE factuur AUTO_INCREMENT=".$record['factuurId'];
			mysql_query($queryd) or die (mysql_error());
			//factuur nummer aanpassen na delete factuur
			return true;
		}
                
		return false;
	} 
	
	function DisplayMoney ($kosten){
		return '&euro; '.number_format($kosten, 2, ",", ".");
	}
	
	function DisplayMoneySelect ($kosten){
		return ' [ '.number_format($kosten, 2, ",", ".").' ] ';
	}
	
	function login($mail, $password, $language){
		if(!isset($mail)){
			$this->error('Er is geen e-mail adres opgegeven');
		}elseif(!isset($password)){
			$this->error('Er is geen password opgegeven');
		}elseif(!isset($language)){
			$this->error('Er is geen taal opgegeven');
		}else{
			$query 	= "SELECT klantId, mail, password, usergroup, voornaam, tussenvoegsel, achternaam, factuur_opsparen
			FROM klant WHERE mail='".$mail."'";
			$query 	= mysql_query($query) or die (mysql_error());
			
			if(mysql_num_rows($query)!=1){
				$this->error('Er is geen klant gevonden met het opgegeven password');
			}
			
			$record = mysql_fetch_array($query);
			
			if($record['password']!=md5($password)){
				$this->error('Het opgegeven wachtwoord is incorrect.');
			}
			
			$_SESSION['klantId']	= $record['klantId'];
			$_SESSION['mail']		= $record['mail'];
			$_SESSION['usergroup']	= $record['usergroup'];
			$_SESSION['language']	= $language;
			if($record['tussenvoegsel']==''){
				$_SESSION['naam'] 	= $record['voornaam'].' '.$record['achternaam'];
			}else{
				$_SESSION['naam'] 	= $record['voornaam'].' '.$record['tussenvoegsel'].' '.$record['achternaam'];
			}
			$_SESSION['opsparen'] 	= $record['factuur_opsparen'];
			
			return TRUE;
		}
	}
	
	function isLoggedIn(){
		if(isset($_SESSION['naam']) AND isset($_SESSION['klantId']) AND isset($_SESSION['mail']) AND isset($_SESSION['usergroup'])){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function nav (){
		if(!$this->isLoggedIn()){
			echo'<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr bgcolor="#CCCCCC">
				<td class="big">Factuursysteem</td>
				<td align="right"><a href="index.php" target="mainFrame" class="bold">login</a> |
				<a href="index.php?p=nieuwe_klant" target="mainFrame" class="bold">klant worden</a> |
				<a href="index.php?p=forgotmypass" target="mainFrame" class="bold">wachtwoord vergeten</a></td>
			  </tr>
			</table>';
		}else{
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr bgcolor="#CCCCCC">
				<td class="big">Factuursysteem</td>
				<td align="right"><a href="index.php?p=home" target="mainFrame" class="bold">home</a> | <a href="index.php?p=logout" class="bold">logout</a></td>
			  </tr>
			</table>';
		}
	}
	
	function notAllowed ($neededLevel=''){
		if(!$this->isLoggedIn()){
			$notAllowed = 1;
		}
		
		if(isset($neededLevel) AND !$this->allowed($neededLevel)){
			$notAllowed = 1;
		}
		
		if(isset($notAllowed) AND $notAllowed=='1'){
			echo '<script language="javascript">
			document.write("Geen ristrictie...");
			setTimeout("window.location.href=\'index.php\'", 4000);
			</script>';
			exit;
		}
	}
	
	function allowed($neededLevel){
		if($neededLevel==$_SESSION['usergroup']){
			return TRUE;
		}elseif($neededLevel<$_SESSION['usergroup']){
			return TRUE;
		}
		return FALSE;
	}
	
	function logout(){
		session_destroy();
		
		return TRUE;
	}
	
	function error($text){
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td width="50%">Probleem</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>'.$text.'</td>
		  </tr>
		</table>';
		include('templates/footer.tpl.php');
		exit;
	}
	
	function random_pass($length) {
        $letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
        'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
        '0','1','2','3','4','5','6','7','8','9');
        srand((double) microtime() * 1000000);
        for ($c = 0; $c < $length; $c++)
        $validation .= $letters[rand(0,count($letters))];
        return $validation;
	}
	
	function forgotmypassword ($emailadres)
	{
		$query = "SELECT klantId, voornaam, tussenvoegsel, achternaam FROM klant WHERE mail='".$emailadres."'";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)!=1)
		{
			$this->error('Er komt geen klant voor met het opgegeven adres.');
		}else
		{
			$record = mysql_fetch_array($query);
			$passwd = $this->random_pass(7);
			
			$queryu = "UPDATE klant SET password='".md5($passwd)."' WHERE klantId='".$record['klantId']."'";
			mysql_query($queryu) or die (mysql_error());
			
			if(strlen($record['tussenvoegsel'])==0){
				$naam = $record['voornaam'].' '.$record['achternaam'];
			}else{
				$naam = $record['voornaam'].' '.$record['tussenvoegsel'].' '.$record['achternaam'];
			}
			
			$text  = "Beste ".$naam.",\n\n";
			$text .= "U heeft via ".URL." aangegeven uw wachtwoord te zijn vergeten.\n";
			$text .= "Indien dit niet het geval is, kunt u contact opnemen met ".MAILADDR."\n\n";
			$text .= "Uw nieuwe inlog gegevens:\n";
			$text .= "Uw e-mail adres: ".$emailadres."\n";
			$text .= "Uw nieuwe wachtwoord: ".$passwd."\n\n".AFSLUITING;
			
			$mail = new FIMailer();
			$mail->Subject  = 'Uw wachtwoord';
			$mail->Body = $text;
			$mail->AddAddress($emailadres, $naam);
			
			if(!$mail->Send()){
			   echo "Mailer Error: ".$emailadres." => ".$mail->ErrorInfo."\n";
			}
			
			$mail->ClearAddresses();
			
			return TRUE;
		}
	}
	
	function vorige_kwartaaldatum ($min=0)
	{
		if(date("m")>=1 && date("m")<=3)
		{
			return mktime(0,0,0,1-$min,1,date("Y"));
		}else if (date("m")>=4 && date("m")<=6)
		{
			return mktime(0,0,0,4-$min,1,date("Y"));
		}else if (date("m")>=7 && date("m")<=9)
		{
			return mktime(0,0,0,7-$min,1,date("Y"));
		}else if (date("m")>=10 && date("m")<=12)
		{
			return mktime(0,0,0,10-$min,1,date("Y"));
		}
	}
	
	function aanhef ($sex)
	{
		if($sex=='M'){
			return 'Heer';
		}else{
			return 'Mevrouw';
		}
	}
	
	function klantnaam ($aanhef, $tussenvoegsel, $achternaam)
	{
		if($tussenvoegsel!=''){
			return $aanhef." ".$tussenvoegsel." ".$achternaam;
		}else{
			return $aanhef." ".$achternaam;
		}
	}
	
	function invoices_get_open_vat ()
	{
		global $btwTarrieven;
		
		/* GET VAT SPECIFIC OPEN */
		foreach($btwTarrieven AS $perc)
		{
			$query 	= "SELECT SUM( bedrag ) AS openstaand FROM factuur f, klant k WHERE f.klantId = k.klantId AND f.betaald = 'C' AND k.BTWtarrief = '".$perc."';";
			$query 	= mysql_query($query) or die (mysql_error());
			$record = mysql_fetch_array($query);
				
			$open_vat[$perc] = $this->displayMoney($record['openstaand']);
		}

		/* GET THE TOTAL OPEN */
		$query 	= "SELECT SUM( bedrag ) AS openstaand FROM `factuur` WHERE betaald = 'C'";
		$query 	= mysql_query($query) or die (mysql_error());
		$record	= mysql_fetch_array($query);
		$open_vat['total'] = $this->displayMoney($record['openstaand']);
		
		return $open_vat;
	}
	
	function invoices_get_vat_last_quarter ()
	{
		global $btwTarrieven;
		
		/* GET VAT SPECIFIC OPEN */
		foreach($btwTarrieven AS $perc)
		{
			$query 	= "SELECT SUM( bedrag ) AS voldaan
			FROM factuur f, klant k
			WHERE f.klantId = k.klantId AND
			f.betaald = 'Y' AND
			datum >= '".$fact->vorige_kwartaaldatum()."' AND
			k.BTWtarrief = '".$perc."'";
			$query 	= mysql_query($query) or die (mysql_error());
			$record = mysql_fetch_array($query);
				
			$open_vat[$perc] = $this->displayMoney($record['openstaand']);
		}

		$query19 = "";
			$query19 = mysql_query($query19) or die (mysql_error());
			$record19=mysql_fetch_array($query19);

			$query10 = "SELECT SUM( bedrag ) AS voldaan
			FROM factuur f, klant k
			WHERE f.klantId = k.klantId AND
			f.betaald = 'Y' AND
			datum >= '".$fact->vorige_kwartaaldatum()."' AND
			k.BTWtarrief = '0.0';";
			$query10 = mysql_query($query10) or die (mysql_error());
			$record10=mysql_fetch_array($query10);

			$query = "SELECT SUM( bedrag ) AS voldaan FROM `factuur` WHERE betaald = 'Y' AND datum >= '".$fact->vorige_kwartaaldatum()."'";
			$query = mysql_query($query) or die (mysql_error());
			$record=mysql_fetch_array($query);
		
		return $open_vat;
	}
	
	function get_open_invoices()
	{
		$query = "SELECT * FROM factuur f, klant k
		WHERE f.klantId = k.klantId AND
		betaald='C' ORDER BY factuurId DESC";
		$query = mysql_query($query) or die (mysql_error());
		while($record=mysql_fetch_array($query))
		{
			$time = mktime(date('H',$record['datum']),date('i',$record['datum']),date('s',$record['datum']),date('m',$record['datum']),date('d',$record['datum'])+BETALINGS_TERMIJN,date('Y',$record['datum']));

			if($time<time()){
				$record['status'] = 'Over tijd, openstaand';
			}else{
				$record['status'] = 'Openstaand';
			}

			$record['name'] = $this->get_name($record['bedrijfsnaam'], $record['achternaam'], $record['voornaam']);
			
			$record['disp_date'] = date(FACTUUR_DATUM_FORMAT,$record['datum']);
			
			$record['excl'] = $record['bedrag']/(($record['BTWtarrief']/100)+1);
			$record['vat'] = $this->displayMoney($record['bedrag']-$record['excl']);
			$record['excl'] = $this->displayMoney($record['excl']);
			$record['bedrag'] = $this->displayMoney($record['bedrag']);
			
			$open_invoices[] = $record;
		}
		
		return $open_invoices;
	}
	
	function get_name($companyname, $lastname, $sirname)
	{
		if($companyname != "")
			{
				$name = substr($companyname, 0, 40);
			}else
			{
				$name   = substr($lastname, 0, 20);
				$name  .= ', ' ;
				$name  .= substr($sirname, 0, 20);
			}
			
		return $name;
	}
}
?>
