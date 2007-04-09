<?
include_once('config.inc.php');
include_once(PATH.'includes/factuur.class.php');

$fact = new factuur;

if($_GET['p']!='finish_factuur' &&
$_GET['p']!='' &&
$_GET['p']!='json_artikelen_per_cat' &&
$_GET['p']!='display_factuur')
{
	include_once('templates/header.tpl.php');
}

switch($_GET['p']){
	default:
	
	if($fact->isLoggedIn()){
		// FRAMESET
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Factuursysteem '.BEDRIJFSNAAM.'</title>
		<link rel="stylesheet" href="'.URL.'style.css" type="text/css" />
		<script type="text/javascript" language="JavaScript1.2" src="./js/prototype.js"> </script>
		<script type="text/javascript" language="JavaScript1.2" src="./js/funct.js"> </script>
		</head>
		
		<frameset rows="*" cols="137,*" frameborder="no" border="0" framespacing="0">
		<frame src="index.php?p=left_frame" name="leftFrame" scrolling="no" noresize="noresize" id="leftFrame" title="leftFrame" />
		  <frameset rows="40,*" frameborder="no" border="0" framespacing="0">
			<frame src="index.php?p=top_frame" name="topFrame" scrolling="no" noresize="noresize" id="topFrame" title="topFrame" />
			<frame src="index.php?p=home" name="mainFrame" id="mainFrame" title="mainFrame" />
		  </frameset>
		</frameset>
		
		</html>';
	}else{
		// LOGIN FORMULIER
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Factuursysteem '.BEDRIJFSNAAM.'</title>
		<link rel="stylesheet" href="'.URL.'style.css" type="text/css" />
		<script type="text/javascript" language="JavaScript1.2" src="./js/prototype.js"> </script>
		<script type="text/javascript" language="JavaScript1.2" src="./js/funct.js"> </script>
		</head>
		
		<frameset rows="40,*" frameborder="no" border="0" framespacing="0">
		  <frame src="index.php?p=top_frame" name="topFrame" scrolling="no" noresize="noresize" id="topFrame" title="topFrame" />
		  <frame src="index.php?p=login" name="mainFrame" id="mainFrame" title="mainFrame" />
		</frameset>
		
		</html>';
	}
	break;
	
	case "login":
		echo '<form name="form1" method="post" action="index.php?p=doLogin" target="_parent">
		<table width="100%"  border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td width="50%">Login</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>E-mail adres:</td>
			<td><input type="text" name="emailadres"></td>
		  </tr>
		  <tr>
			<td>Password:</td>
			<td><input type="password" name="password"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Login"></td>
		  </tr>
		</table>
		</form>';
	break;
	
	case "top_frame":
		$fact->nav();
	break;
	
	case "forgotmypass":
		echo '<form name="form1" method="post" action="index.php?p=doForgotPassword">
		<table width="100%"  border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td width="50%">Passwoord vergeten</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>E-mail adres:</td>
			<td><input type="text" name="emailadres"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Opvragen"></td>
		  </tr>
		</table>
		</form>';
	break;
	
	case "doForgotPassword":
		if($fact->forgotmypassword($_POST['emailadres']))
		{
			echo '<table width="100%"  border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Passwoord vergeten</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Er is een nieuw wachtwoord naar uw e-mail adres verstuurd.</td>
			  </tr>
			</table>';
		}
	break;
	
	case "doLogin":
		if($fact->login($_POST['emailadres'], $_POST['password'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Ingelogd</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Welkom terug '.$_SESSION['naam'].'.<br />Een moment graag. U wordt naar ons hoofdmenu geleid...
				<script language="javascript">
				setTimeout("window.location.href=\'index.php\'", 4000);
				</script></td>
			  </tr>
			</table>';
		}
	break;
	
	case "nieuwe_klant":
	
	echo '<form name="nieuwe_klant" method="post" action="index.php?p=do_nieuwe_klant">
	<table width="100%" border="0" cellspacing="0" cellpadding="1">
	  <tr>
		<td width="50%">Nieuwe klant</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>E-mail adres*</td>
		<td><input type="text" name="emailadres"></td>
	  </tr>
	  <tr>
		<td>Password*</td>
		<td><input type="password" name="password1"></td>
	  </tr>
	  <tr>
		<td>Password check* </td>
		<td><input type="password" name="password2"></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>Voornaam*</td>
		<td><input type="text" name="voornaam"></td>
	  </tr>
	  <tr>
		<td>Tussenvoegsel</td>
		<td><input type="text" name="tussenvoegsel"></td>
	  </tr>
	  <tr>
		<td>Achternaam*</td>
		<td><input type="text" name="achternaam"></td>
	  </tr>
	  <tr>
		<td>Geslacht*</td>
		<td><input name="geslacht" type="radio" value="M"> Man 
		  <input name="geslacht" type="radio" value="V"> Vrouw</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>Bedrijfsnaam</td>
		<td><input type="text" name="bedrijfsnaam"></td>
	  </tr>
	  <tr>
		<td>Straat*</td>
		<td><input type="text" name="straat"></td>
	  </tr>
	  <tr>
		<td>Huisnummer*</td>
		<td><input name="huisnummer" type="text" size="9"></td>
	  </tr>
	  <tr>
		<td>Postcode en Plaats*</td>
		<td><input name="postcode" type="text" size="9" maxlength="7">
		  <input type="text" name="plaats"></td>
	  </tr>
	  <tr>
		<td>Land*</td>
		<td><select name="land">';
			
			foreach ($landen AS $land)
			{
				echo '<option>'.$land.'</option>';
			}
			
			echo '</select></td>
	  </tr>
	  <tr>
		<td>Telefoonnummer*</td>
		<td><input type="text" name="telefoon"></td>
	  </tr>
	  <tr>
		<td>Faxnummer</td>
		<td><input type="text" name="fax"></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>BTW nummer (alleen voor bedrijven)</td>
		<td><input type="text" name="BTWnummer"></td>
	  </tr>
	  <tr>
		<td>Kamer van Koophandel nummer (alleen voor bedrijven)</td>
		<td><input type="text" name="KVKnummer"> in <select name="KVKplaats">';
			foreach($KVKplaatsen AS $plaats){
				echo'<option>'.$plaats.'</option>'."\n";
			}
			echo'</select></td>
	  </tr>
	  <tr>
		<td>Bedrijfsvorm (alleen voor bedrijven)</td>
		<td><select name="bedrijfsvorm">';
		    foreach($bedrijfsvormen AS $vorm){
				echo'<option>'.$vorm.'</option>'."\n";
			}
			echo'</select></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="Submit" value="Aanmelden"></td>
	  </tr>
	</table>
	</form>';
	
	break;
	
	case "do_nieuwe_klant":
	
		if($fact->klant_invoegen ($_POST['emailadres'],$_POST['password1'],$_POST['password2'],$_POST['voornaam'],$_POST['tussenvoegsel'],$_POST['achternaam'],$_POST['geslacht'],$_POST['bedrijfsnaam'],$_POST['straat'],$_POST['huisnummer'],$_POST['postcode'],$_POST['plaats'],$_POST['land'],$_POST['telefoon'],$_POST['fax'],$_POST['BTWnummer'],$_POST['KVKnummer'],$_POST['KVKplaats'],$_POST['bedrijfsvorm'])){
			echo '<table width="100%"  border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Nieuwe klant</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Welkom als nieuwe klant bij '.BEDRIJFSNAAM.',<br>
				  <br>
				  Op het door uw opgegeven e-mail adres vindt u uw login gegevens. Daarmee kunt u <a href="index.php">hier</a> inloggen.<br>
				  <br>'.nl2br(AFSLUITING).'
				  </td>
			  </tr>
			</table>';
		}
	
	break;
	
	//**************************************************************//
	//			NEED TO BE LOGGED IN UNDERNEAT THIS LINE			//
	//**************************************************************//
	
	case "left_frame":
		$fact->notAllowed();
		
		echo '<table width="99%"  border="0" cellspacing="0" cellpadding="0" align="center">
		  <tr bgcolor="#CCCCCC">
			<td class="big">Menu</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td><a href="index.php?p=home" target="mainFrame">home</a></td>
		  </tr>';
		
		// KLANT FUNCTIONS
		if($fact->allowed('1')){
			echo '<tr>
				<td><a href="index.php?p=bekijk_facturen" target="mainFrame">facturen bekijken</a></td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=persoonsgegevens" target="mainFrame">persoonsgegevens</a></td>
			  </tr>';
		}
		
		echo '<tr>
			<td><a href="index.php?p=logout" target="mainFrame">logout</a></td>
		  </tr>';
		
		// ADMIN FUNCTIONS
		if($fact->allowed('99')){
			echo '<tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr bgcolor="#CCCCCC">
				<td class="big">Admin functies</td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=beheer_categorieen" target="mainFrame">categorieen beheren</a></td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=add_categorie" target="mainFrame">categorie invoegen</a></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=beheer_artikelen" target="mainFrame">artikelen beheren</a></td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=add_artikel" target="mainFrame">artikel invoegen</a></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=klantenlijst" target="mainFrame">klantenlijst</a></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=facturen" target="mainFrame">facturen</a></td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=incasso_overzicht" target="mainFrame">incasso overzicht</a></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=factuur_vorig_kwartaal" target="mainFrame">vorig kwartaal</a></td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=factuur_alles" target="mainFrame">alle facturen</a></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=binnenkort_verlopen" target="mainFrame">binnenkort verlopen</a></td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=maak_factuur" target="mainFrame">factuur maken</a></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><a href="index.php?p=version" target="mainFrame">versie</a></td>
			  </tr>';
		}
		  
		  echo'</table>';
	break;
	
	case "home":
		$fact->notAllowed('1');
	break;
	
	case "bekijk_facturen":
		$fact->notAllowed('1');
		
		$query = "SELECT * FROM factuur WHERE klantId='".$_SESSION['klantId']."' ORDER BY factuurId DESC";
		$query = mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($query)==0){
			$fact->error('Er komen geen facturen in het systeem voor op uw naam.');
		}
		
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td>Overzicht van facturen</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr bgcolor="#CCCCCC">
			<td class="big">Nog te voldoen</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>';
		
		$query = "SELECT * FROM factuur WHERE klantId='".$_SESSION['klantId']."' AND betaald='C' ORDER BY factuurId DESC";
		$query = mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($query)==0){
			echo '<tr>
				<td>U heeft momenteel geen openstaande facturen</td>
			  </tr>';
		}else{
			echo '<tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="1">
				<tr>
				  <td><b>FactuurId</b></td>
				  <td><b>Betalings status</b></td>
				  <td><b>Factuur datum</b></td>
				  <td><b>Bedrag</b></td>
				</tr>';
			
			while($record=mysql_fetch_array($query)){
				$time = mktime(date('H',$record['datum']),date('i',$record['datum']),date('s',$record['datum']),date('m',$record['datum']),date('d',$record['datum'])+BETALINGS_TERMIJN,date('Y',$record['datum']));
				
				if($time<time()){
					$status = 'Over tijd, openstaand';
				}else{
					$status = 'Openstaand';
				}
				
				echo '<tr>
				  <td><a href="index.php?p=display_factuur&factuurId='.$record['factuurId'].'">'.$record['factuurId'].'</a></td>
				  <td>'.$status.'</td>
				  <td>'.date('d/m/Y',$record['datum']).'</td>
				  <td>'.$fact->displayMoney($record['bedrag']).'</td>
				</tr>';
			}
			
			echo '</table></td>
			  </tr>';
		}
		
		echo '<tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr bgcolor="#CCCCCC">
			<td class="big">Voldaan</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>';
		
		$query = "SELECT * FROM factuur WHERE klantId='".$_SESSION['klantId']."' AND betaald='Y'";
		$query = mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($query)==0){
			echo '<tr>
				<td>U heeft momenteel geen voldane facturen bij ons</td>
			  </tr>';
		}else{
			echo '<tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="1">
				<tr>
				  <td><b>FactuurId</b></td>
				  <td><b>Betalings status</b></td>
				  <td><b>Factuur datum</b></td>
				  <td><b>Bedrag</b></td>
				</tr>';
			
			while($record=mysql_fetch_array($query)){				
				echo '<tr>
				  <td><a href="index.php?p=display_factuur&factuurId='.$record['factuurId'].'">'.$record['factuurId'].'</a></td>
				  <td>Voldaan op '.date('d/m/Y',$record['betaald_datum']).'</td>
				  <td>'.date('d/m/Y',$record['datum']).'</td>
				  <td>&#8364; '.$record['bedrag'].'</td>
				</tr>';
			}
			
			echo '</table></td>
			  </tr>';
		}
		
		echo '</table>';
		
	break;
	
	case "display_factuur":
		$fact->notAllowed('1');
	
		if($fact->allowed('99')){
			$fact->finish_factuur($_GET['factuurId'], 'DISP');
		}else{
			$fact->finish_factuur($_GET['factuurId'], 'DISP', $_SESSION['klantId']);
		}
	break;
	
	case "persoonsgegevens":
		$fact->notAllowed('1');
		
		if($_GET['klantId'] AND $fact->allowed('99')){
			$query 	= "SELECT * FROM klant WHERE klantId='".$_GET['klantId']."'";
		}else{
			$query 	= "SELECT * FROM klant WHERE klantId='".$_SESSION['klantId']."'";
		}
		
		$query 	= mysql_query($query) or die (mysql_error());
		$record = mysql_fetch_array($query);
		
		echo '<form name="nieuwe_klant" method="post" action="index.php?p=do_persoonsgegevens">
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td width="50%">Nieuwe klant</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>E-mail adres*</td>
			<td><input type="text" name="emailadres" value="'.$record['mail'].'"></td>
		  </tr>
		  <tr>
			<td>Password (alleen als je hem wilt veranderen)</td>
			<td><input type="password" name="password1"></td>
		  </tr>
		  <tr>
			<td>Password check (alleen als je hem wilt veranderen)</td>
			<td><input type="password" name="password2"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Voornaam*</td>
			<td><input type="text" name="voornaam" value="'.$record['voornaam'].'"></td>
		  </tr>
		  <tr>
			<td>Tussenvoegsel</td>
			<td><input type="text" name="tussenvoegsel" value="'.$record['tussenvoegsel'].'"></td>
		  </tr>
		  <tr>
			<td>Achternaam*</td>
			<td><input type="text" name="achternaam" value="'.$record['achternaam'].'"></td>
		  </tr>
		  <tr>
			<td>Geslacht*</td>
			<td><input name="geslacht" type="radio" value="M"'; if($record['geslacht']=='M'){echo ' checked="checked"';} echo'> Man 
			  <input name="geslacht" type="radio" value="V"'; if($record['geslacht']=='V'){echo ' checked="checked"';} echo'> Vrouw</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Bedrijfsnaam</td>
			<td><input type="text" name="bedrijfsnaam" value="'.$record['bedrijfsnaam'].'"></td>
		  </tr>
		  <tr>
			<td>Straat*</td>
			<td><input type="text" name="straat" value="'.$record['straatnaam'].'"></td>
		  </tr>
		  <tr>
			<td>Huisnummer*</td>
			<td><input name="huisnummer" type="text" size="9" value="'.$record['huisnummer'].'"></td>
		  </tr>
		  <tr>
			<td>Postcode en Plaats*</td>
			<td><input name="postcode" type="text" size="9" maxlength="7" value="'.$record['postcode'].'">
			  <input type="text" name="plaats" value="'.$record['plaatsnaam'].'"></td>
		  </tr>
		  <tr>
			<td>Land*</td>
			<td><select name="land">';
			
			foreach ($landen AS $land)
			{
				echo '<option';
				
				if($record['land']==$land)
				{
					echo' selected="selected"';
				}
				
				echo'>'.$land.'</option>';
			}
			
			echo '</select></td>
		  </tr>
		  <tr>
			<td>Telefoonnummer*</td>
			<td><input type="text" name="telefoon" value="'.$record['telefoon'].'"></td>
		  </tr>
		  <tr>
			<td>Faxnummer</td>
			<td><input type="text" name="fax" value="'.$record['fax'].'"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>BTW nummer (alleen voor bedrijven)</td>
			<td><input type="text" name="BTWnummer" value="'.$record['BTWnummer'].'"></td>
		  </tr>
		  <tr>
			<td>Kamer van Koophandel nummer (alleen voor bedrijven)</td>
			<td><input type="text" name="KVKnummer" value="'.$record['KVKnummer'].'"> in <select name="KVKplaats">';
			foreach($KVKplaatsen AS $plaats){
				echo'<option'; if($record['KVKplaats']==$plaats){ echo ' selected="selected"'; } echo'>'.$plaats.'</option>'."\n";
			}
			echo'</select></td>
		  </tr>
		  <tr>
			<td>Bedrijfsvorm (alleen voor bedrijven)</td>
		    <td><select name="bedrijfsvorm">';
		    foreach($bedrijfsvormen AS $vorm){
				echo'<option'; if($record['bedrijfsvorm']==$vorm){ echo ' selected="selected"'; } echo'>'.$vorm.'</option>'."\n";
			}
			echo'</select></td>
	  	  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>';
		  
			if(!$fact->allowed('99')){
				echo'<tr>
					<td>Huidige wachtwoord</td>
					<td><input type="password" name="huidige_pass"></td>
				  </tr>';
			}else{
				echo '<tr>
					<td>Usergroup</td>
					<td><input type="hidden" name="klantId" value="'.$_GET['klantId'].'">
					<select name="usergroup">';
					foreach($usergroups AS $nr => $group){
						echo '<option value="'.$nr.'"';
						if($record['usergroup']==$nr){echo' selected="selected"';}
						echo'>'.$group.'</option>';
					}
					echo'</select></td>
				  </tr>
				  <tr>
					<td>BTW-tarrief</td>
					<td><select name="BTWtarrief">';
					foreach($btwTarrieven AS $tarrief){
						echo '<option';
						if($record['BTWtarrief']==$tarrief){echo' selected="selected"';}
						echo'>'.$tarrief.'</option>';
					}
					echo'</select></td>
				  </tr>
				  <tr>
					<td>Factuur opsparen</td>
					<td><select name="factuur_opsparen">
					<option value="N"'; if($record['factuur_opsparen']=='N'){echo' selected="selected"';} echo'>Nee</option>
					<option value="Y"'; if($record['factuur_opsparen']=='Y'){echo' selected="selected"';} echo'>Ja</option>
					</select></td>
				  </tr>';
			}
		  
		  echo'<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Aanpassen"></td>
		  </tr>
		</table>
		</form>';
	break;
	
	case "do_persoonsgegevens":
		$fact->notAllowed('1');
		
		if($fact->allowed('99') AND $_POST['klantId']){
			$klantId	= $_POST['klantId'];
		}else{
			$klantId	= $_SESSION['klantId'];
		}
	
		if($fact->change_persoonsgegevens($klantId,$_POST['emailadres'],$_POST['voornaam'],$_POST['tussenvoegsel'],$_POST['achternaam'],$_POST['geslacht'],$_POST['bedrijfsnaam'],$_POST['straat'],$_POST['huisnummer'],$_POST['postcode'],$_POST['plaats'],$_POST['land'],$_POST['telefoon'],$_POST['fax'],$_POST['BTWnummer'],$_POST['KVKnummer'],$_POST['KVKplaats'],$_POST['bedrijfsvorm'],$_POST['huidige_pass'],$_POST['password1'],$_POST['password2'],$_POST['usergroup'],$_POST['factuur_opsparen'],$_POST['BTWtarrief'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Gegevens gewijzigd</td>
				<td align="right">&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Uw gegevens zijn succesvol gewijzigd.<br /><br />
				Klik <a href="index.php?p=persoonsgegevens';
				if($fact->allowed('99') AND $_POST['klantId']){
					echo '&klantId='.$_POST['klantId'];
				}
				echo'">hier</a> om uw persoonsgegevens te controleren.<br />
				Klik <a href="index.php?p=home">hier</a> om terug te gaan naar de index.</td>
			  </tr>
			</table>';
		}
	break;
	
	//**************************************************************//
	//						ADMIN FUNCTIONS							//
	//**************************************************************//
	
	case "version":
	$fact->notAllowed('99');
	
	$current = file_get_contents('http://www.freshway.biz/files/freshinvoice.current.txt');
	
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
	  <tr>
            <td>Huidige versie</td>
          </tr>
		  <tr>
		    <td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td>Uw versie is: '.VERSION.'<br />
		    De nieuwste versie is: '.$current.'<br /><br />
		    U vind de laatste versie via de volgende url: <a href="http://code.google.com/p/freshinvoice/" target="_blank">http://code.google.com/p/freshinvoice/</a></td>
		  </tr>
	</table>';
	
	break;
	
	case "binnenkort_verlopen":
        $fact->notAllowed('99');
        
        $periode = 'maand';
        
        $time     = mktime(0,0,1,date("m")-1,date("d"),date("Y"));

        $query="SELECT k.artikelId, k.opmerking, k.aantal, f.klantId, a.naam, a.verkoop_prijs ,k.dag, k.maand, k.jaar, k.datum, cl.achternaam, cl.bedrijfsnaam, cl.voornaam 
        FROM koppel_factuur_artikelen k, artikelen a, factuur f, klant cl
        WHERE k.artikelId = a.artikelId
        AND k.factuurId = f.factuurId
		AND cl.klantId = f.klantId
        AND a.periode = 'maand' AND
        k.maand='".date("m",$time)."' AND
        k.jaar='".date("Y",$time)."' 
        AND k.opgezegd = 'N'
        AND k.artikelID
        IN (
        SELECT k.artikelId
        FROM koppel_factuur_artikelen k
        WHERE k.dag >0
        AND k.dag <32
        ) order by k.dag";


        //echo $query;
        $query     = mysql_query($query) or die (mysql_error());
        if(mysql_num_rows($query)==0){
            //$fact->error('Er zijn momenteel nog geen items die deze maand verlengd worden');
        }
		
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td>Binnenkort verlopen</td>
		  </tr>
		  <tr>
		    <td>&nbsp;</td>
		  </tr>';
        
        echo '<tr bgcolor="#CCCCCC">
            <td class="big">Facturen per Maand</td>
          </tr>
		  <tr>
		    <td>&nbsp;</td>
		  </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td><b>datum</b></td>
			<td><b>Naam</b></td>
            <td><b>te factureren object</b></td>
            <td><b>aantal</b></td>
            <td><b>per stuk</b></td>
            <td><b>totaal</b></td>
          </tr>';
        $totaal=0;
        
        while($record=mysql_fetch_array($query)){
			if($record['bedrijfsnaam']!="")
			{
				$naam = substr($record['bedrijfsnaam'], 0, 40);
			}else
			{
				$naam = substr($record['achternaam'], 0, 20);
				$naam.= ', ' ;
				$naam.= substr($record['voornaam'], 0, 20);
			}
			
            echo'<tr>
            <td>'.date(FACTUUR_DATUM_FORMAT,$record['datum']).'</td>
			<td>'.$naam.'</td>
            <td>'.$record['naam'].': '.$record['opmerking'].'</td>
            <td>'.$record['aantal'].'</td>
            <td>'.$fact->displayMoney($record['verkoop_prijs']).'</td>
            <td>'.$fact->displayMoney($record['verkoop_prijs']*$record['aantal']).'</td>
          </tr>';
            $totaal+=$record['verkoop_prijs']*$record['aantal'];
        }
        
        echo '</table></td>
		</tr>
		<tr>
		  <td>Totaal ex btw: ' . $fact->displayMoney($totaal) .'</td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		</tr>';

        ////////////////////////////////

        $periode = 'kwartaal';
        
        $time     = mktime(0,0,1,date("m")-3,date("d"),date("Y"));

        $query="SELECT k.artikelId, k.opmerking, k.aantal, f.klantId, a.naam, a.verkoop_prijs , k.dag, k.maand, k.jaar, k.datum, cl.achternaam, cl.bedrijfsnaam, cl.voornaam 
        FROM koppel_factuur_artikelen k, artikelen a, factuur f, klant cl
        WHERE k.artikelId = a.artikelId
        AND k.factuurId = f.factuurId
		AND cl.klantId = f.klantId
        AND a.periode = 'kwartaal' AND
        k.maand='".date("m",$time)."' AND
        k.jaar='".date("Y",$time)."' 
        AND k.opgezegd = 'N'
        AND k.artikelID
        IN (
        SELECT k.artikelId
        FROM koppel_factuur_artikelen k
        WHERE k.dag >0
        AND k.dag <32
        )";


        //echo $query;
        $query     = mysql_query($query) or die (mysql_error());
        if(mysql_num_rows($query)==0){
            //$fact->error('Er zijn momenteel nog geen items die deze maand verlengd worden');
        }
        
        echo '<tr bgcolor="#CCCCCC">
            <td class="big">Facturen per Kwartaal</td>
          </tr>
		  <tr>
		    <td>&nbsp;</td>
		  </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td><b>datum</b></td>
			<td><b>Naam</b></td>
            <td><b>te factureren object</b></td>
            <td><b>aantal</b></td>
            <td><b>per stuk</b></td>
            <td><b>totaal</b></td>
          </tr>';
        $totaal=0;
        
        while($record=mysql_fetch_array($query))
		{	
			if($record['bedrijfsnaam']!="")
			{
				$naam = substr($record['bedrijfsnaam'], 0, 40);
			}else
			{
				$naam = substr($record['achternaam'], 0, 20);
				$naam.= ', ' ;
				$naam.= substr($record['voornaam'], 0, 20);
			}
            echo'<tr>
            <td>'.date(FACTUUR_DATUM_FORMAT,$record['datum']).'</td>
			<td>'.$naam.'</td>
            <td>'.$record['naam'].': '.$record['opmerking'].'</td>
            <td>'.$record['aantal'].'</td>
            <td>'.$fact->displayMoney($record['verkoop_prijs']).'</td>
            <td>'.$fact->displayMoney($record['verkoop_prijs']*$record['aantal']).'</td>
          </tr>';
            $totaal+=$record['verkoop_prijs']*$record['aantal'];
        }
        
        echo '</table></td>
		  </tr>
		  <tr>
			<td>Totaal ex btw: ' . $fact->displayMoney($totaal) .'</td>
		  </tr>
		  <tr>
            <td>&nbsp;</td>
          </tr>';
        //////////////

        ////////////////////////////////

        $periode = 'jaar';
        
        $time     = mktime(0,0,1,date("m"),date("d"),date("Y")-1);

		$query="SELECT k.artikelId, k.opmerking, k.aantal, f.klantId, a.naam, a.verkoop_prijs , k.dag, k.maand, k.jaar, k.datum, 	cl.achternaam, cl.bedrijfsnaam, cl.voornaam 
        FROM koppel_factuur_artikelen k, artikelen a, factuur f, klant cl
        WHERE k.artikelId = a.artikelId
        AND k.factuurId = f.factuurId
		AND cl.klantId = f.klantId
        AND a.periode = 'jaar' AND
        k.maand='".date("m",$time)."' AND
        k.jaar='".date("Y",$time)."' 
        AND k.opgezegd = 'N'
        AND k.artikelID
        IN (
        SELECT k.artikelId
        FROM koppel_factuur_artikelen k
        WHERE k.dag >0
        AND k.dag <32
        )";
		
        $query     = mysql_query($query) or die (mysql_error());
        if(mysql_num_rows($query)==0){
            //$fact->error('Er zijn momenteel nog geen items die deze maand verlengd worden');
        }
        
        echo '<tr bgcolor="#CCCCCC">
            <td class="big">Facturen per Jaar</td>
          </tr>
		  <tr>
		    <td>&nbsp;</td>
		  </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td><b>datum</b></td>
			<td><b>Naam</b></td>
            <td><b>te factureren object</b></td>
            <td><b>aantal</b></td>
            <td><b>per stuk</b></td>
            <td><b>totaal</b></td>
          </tr>';
        $totaal=0;
        
        while($record=mysql_fetch_array($query))
		{
			if($record['bedrijfsnaam']!="")
			{
				$naam = substr($record['bedrijfsnaam'], 0, 40);
			}else
			{
				$naam = substr($record['achternaam'], 0, 20);
				$naam.= ', ' ;
				$naam.= substr($record['voornaam'], 0, 20);
			}
			
            echo'<tr>
            <td>'.date(FACTUUR_DATUM_FORMAT,$record['datum']).'</td>
			<td>'.$naam.'</td>
            <td>'.$record['naam'].': '.$record['opmerking'].'</td>
            <td>'.$record['aantal'].'</td>
            <td>'.$fact->displayMoney($record['verkoop_prijs']).'</td>
            <td>'.$fact->displayMoney($record['verkoop_prijs']*$record['aantal']).'</td>
          </tr>';
            $totaal+=$record['verkoop_prijs']*$record['aantal'];
        }
        
        echo '</table></td>
		  </tr>
		  <tr>
			<td>Totaal ex btw: '.$fact->displayMoney($totaal).'</td>
		  </tr>
		</table>';
		
		///////////////////// DISPLAY ALL CURRENT SENDED STUFF THIS MONTH THAT IS MONTHLY
        
        $periode = 'Huidige maand verzonden';
          
        $time     = mktime(0,0,1,date("m"),date("d"),date("Y"));
        
        $query="SELECT k.artikelId, k.opmerking, k.aantal, f.klantId, a.naam, a.verkoop_prijs ,k.dag, k.maand, k.jaar, k.datum, cl.achternaam, cl.bedrijfsnaam, cl.voornaam 
        FROM koppel_factuur_artikelen k, artikelen a, factuur f, klant cl
        WHERE k.artikelId = a.artikelId
        AND k.factuurId = f.factuurId
		AND cl.klantId = f.klantId
        AND a.periode = 'maand' AND
        k.maand='".date("m",$time)."' AND
        k.jaar='".date("Y",$time)."'
        AND k.opgezegd = 'N'
        AND k.artikelID
        IN (  
            
        SELECT k.artikelId
        FROM koppel_factuur_artikelen k
        WHERE k.dag >0
        AND k.dag <32
        ) order by k.dag";
		
		$query     = mysql_query($query) or die (mysql_error());
        if(mysql_num_rows($query)==0){
            //$fact->error('Er zijn momenteel nog geen items die deze maand verlengd worden');
        }
        
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">';
		
		echo '<tr bgcolor="#CCCCCC">
            <td class="big">Facturen reeds verzonden</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td><b>datum</b></td>
			<td><b>Naam</b></td>
            <td><b>te factureren object</b></td>
            <td><b>aantal</b></td>
            <td><b>per stuk</b></td>
            <td><b>totaal</b></td>
          </tr>';
        $totaal=0;
        
        while($record=mysql_fetch_array($query)){
		
			if($record['bedrijfsnaam']!="")
			{
				$naam = substr($record['bedrijfsnaam'], 0, 40);
			}else
			{
				$naam = substr($record['achternaam'], 0, 20);
				$naam.= ', ' ;
				$naam.= substr($record['voornaam'], 0, 20);
			}
            echo'<tr>
            <td>'.date(FACTUUR_DATUM_FORMAT,$record['datum']).'</td>
			<td>'.$naam.'</td>
            <td>'.$record['naam'].': '.$record['opmerking'].'</td>
            <td>'.$record['aantal'].'</td>
            <td>'.$fact->displayMoney($record['verkoop_prijs']).'</td>
            <td>'.$fact->displayMoney($record['verkoop_prijs']*$record['aantal']).'</td>
          </tr>';
            $totaal+=$record['verkoop_prijs']*$record['aantal'];
        }
          
        echo '</table></td>
        </tr>
        <tr>
          <td>Totaal ex btw: '.$fact->displayMoney($totaal).'</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>';
        
        ////////////////////////////////
    break;
	
	case "facturen":
		$fact->notAllowed('99');	
	
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td>Overzicht van facturen</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr bgcolor="#CCCCCC">
			<td class="big">Nog te versturen</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>';
	
		$query = "SELECT * FROM factuur f, klant k
		WHERE f.klantId = k.klantId AND
		betaald='N' ORDER BY factuurId DESC";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)==0){
			echo '<tr>
				<td>Er zijn momenteel geen facturen die nog moeten worden verstuurd</td>
			  </tr>';
		}else{
			echo '<tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="1">
				<tr>
				  <td><b>FactuurId</b></td>
				  <td><b>Klant</b></td>
				  <td><b>Betalings status</b></td>
				  <td><b>Factuur datum</b></td>
				  <td>&nbsp;</td>
				</tr>';
			
			while($record=mysql_fetch_array($query)){
				$time = mktime(date('H',$record['datum']),date('i',$record['datum']),date('s',$record['datum']),date('m',$record['datum']),date('d',$record['datum'])+BETALINGS_TERMIJN,date('Y',$record['datum']));
				
				if($time<time()){
					$status = 'Over tijd, openstaand';
				}else{
					$status = 'Openstaand';
				}
				
				if($record['bedrijfsnaam']!="")
				{
					$naam = substr($record['bedrijfsnaam'], 0, 40);
				}else
				{
					$naam = substr($record['achternaam'], 0, 20);
					$naam.= ', ' ;
					$naam.= substr($record['voornaam'], 0, 20);
				}
				
				echo '<tr>
				  <td><a href="index.php?p=display_factuur&factuurId='.$record['factuurId'].'">'.$record['factuurId'].'</a></td>
				  <td>'.$naam.'</td>
				  <td>'.$status.'</td>
				  <td>'.date(FACTUUR_DATUM_FORMAT,$record['datum']).'</td>
				  <td>[<a href="index.php?p=beheer_factuur&factuurId='.$record['factuurId'].'">edit</a>]
				  [<a href="index.php?p=factuur_delete&factuurId='.$record['factuurId'].'">delete</a>]</td>
				</tr>';
			}
			
			echo '</table></td>
			  </tr>';
		}
		
		$query = "SELECT SUM( bedrag ) AS openstaand FROM `factuur` WHERE betaald = 'C'";
		$query = mysql_query($query) or die (mysql_error());
		$record=mysql_fetch_array($query);
		
		$query19 = "SELECT SUM( bedrag ) AS openstaand
		FROM factuur f, klant k
		WHERE f.klantId = k.klantId AND
		f.betaald = 'C' AND
		k.BTWtarrief = '19.0';";
		$query19 = mysql_query($query19) or die (mysql_error());
		$record19=mysql_fetch_array($query19);
                        
		$query10 = "SELECT SUM( bedrag ) AS openstaand
		FROM factuur f, klant k
		WHERE f.klantId = k.klantId AND
		f.betaald = 'C' AND
		k.BTWtarrief = '0.0';";
		$query10 = mysql_query($query10) or die (mysql_error());
		$record10=mysql_fetch_array($query10);
		
		if(mysql_num_rows($query)==1)
        {
            echo'<tr>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#CCCCCC">
            <td class="big">Nog te voldoen: 19%: '.$fact->displayMoney($record19['openstaand']).' 0%: '.$fact->displayMoney($record10['openstaand']).'
	    totaal: '.$fact->displayMoney($record['openstaand']).'</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>';
        }else
		{
			echo'<tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr bgcolor="#CCCCCC">
				<td class="big">Nog te voldoen</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>';
		}
	
		$query = "SELECT * FROM factuur f, klant k
		WHERE f.klantId = k.klantId AND
		betaald='C' ORDER BY factuurId DESC";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)==0){
			echo '<tr>
				<td>Er zijn momenteel geen openstaande facturen</td>
			  </tr>';
		}else{
			echo '<tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="1">
				<tr>
				  <td><b>FactuurId</b></td>
				  <td><b>Klant</b></td>
				  <td><b>Betalings status</b></td>
				  <td><b>Factuur datum</b></td>
				  <td><b>Incl. btw</b></td>
                  <td><b>Excl. btw</b></td>
                  <td><b>BTW</b></td>
				  <td width="15%">&nbsp;</td>
				</tr>';
			
			while($record=mysql_fetch_array($query)){
				$excl = $record['bedrag']/(($record['BTWtarrief']/100)+1);
				$btw = $record['bedrag']-$excl;
				$time = mktime(date('H',$record['datum']),date('i',$record['datum']),date('s',$record['datum']),date('m',$record['datum']),date('d',$record['datum'])+BETALINGS_TERMIJN,date('Y',$record['datum']));
				
				if($record['bedrijfsnaam']!="")
				{
					$naam = substr($record['bedrijfsnaam'], 0, 40);
				}else
				{
					$naam = substr($record['achternaam'], 0, 20);
					$naam.= ', ' ;
					$naam.= substr($record['voornaam'], 0, 20);
				}
				
				if($time<time()){
					$status = 'Over tijd, openstaand';
				}else{
					$status = 'Openstaand';
				}
				
				echo '<tr>
				  <td><a href="index.php?p=display_factuur&factuurId='.$record['factuurId'].'">'.$record['factuurId'].'</a></td>
				  <td>'.$naam.'</td>
				  <td>'.$status.'</td>
				  <td>'.date('d/m/Y',$record['datum']).'</td>
				  <td>'.$fact->displayMoney($record['bedrag']).'</td>
				  <td>'.$fact->displayMoney($excl).'</td>
				  <td>'.$fact->displayMoney($btw).'</td>
				  <td>[<a href="index.php?p=factuur_resend&factuurId='.$record['factuurId'].'">resend factuur</a>] [<a href="index.php?p=factuur_betaal&factuurId='.$record['factuurId'].'">betaald</a>] [<a href="index.php?p=beheer_factuur&factuurId='.$record['factuurId'].'">edit</a>]</td>
				</tr>';
			}
			
			echo '</table></td>
			  </tr>';
		}
		
		$query19 = "SELECT SUM( bedrag ) AS voldaan
        FROM factuur f, klant k
        WHERE f.klantId = k.klantId AND
        f.betaald = 'Y' AND
        datum >= '".$fact->vorige_kwartaaldatum()."' AND
        k.BTWtarrief = '19.0';";
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
		
		if(mysql_num_rows($query)==1)
        {
	        echo '<tr>
	            <td>&nbsp;</td>
	          </tr>
	          <tr bgcolor="#CCCCCC">
	            <td class="big">Voldaan dit kwartaal: 19%: '.$fact->displayMoney($record19['voldaan']).' 0%: '.$fact->displayMoney($record10['voldaan']).'
		    totaal: '.$fact->displayMoney($record['voldaan']).'</td>
	          </tr>
	          <tr>
	            <td>&nbsp;</td>
	          </tr>';
        }else
		{	
			echo '<tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr bgcolor="#CCCCCC">
				<td class="big">Voldaan dit kwartaal</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>';
		}
		
		$query 	= "SELECT factuurId, betaald_datum, datum, bedrag, BTWtarrief, bedrijfsnaam, achternaam
		FROM factuur f, klant k
		WHERE f.klantId=k.klantId AND
		betaald='Y' AND datum >= '".$fact->vorige_kwartaaldatum()."' ORDER BY factuurId DESC";
		$query 	= mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($query)==0){
			echo '<tr>
				<td>Er zijn momenteel geen voldane facturen</td>
			  </tr>';
		}else{
			echo '<tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="1">
				<tr>
				  <td><b>FactuurId</b></td>
				  <td><b>Klant</b></td>
				  <td><b>Betalings status</b></td>
				  <td><b>Factuur datum</b></td>
				  <td><b>Incl. btw</b></td>
				  <td><b>Excl. btw</b></td>
				  <td><b>BTW</b></td>
				  <td>&nbsp;</td>
				</tr>';
			
			while($record=mysql_fetch_array($query)){
				$excl = $record['bedrag']/(($record['BTWtarrief']/100)+1);
				$btw = $record['bedrag']-$excl;
				
				if($record['bedrijfsnaam']!="")
				{
					$naam = substr($record['bedrijfsnaam'], 0, 40);
				}else
				{
					$naam = substr($record['achternaam'], 0, 20);
					$naam.= ', ' ;
					$naam.= substr($record['voornaam'], 0, 20);
				}
				
				echo '<tr>
				  <td><a href="index.php?p=display_factuur&factuurId='.$record['factuurId'].'">'.$record['factuurId'].'</a></td>
				  <td>'.$naam.'</td>
				  <td>Voldaan op '.date('d/m/Y',$record['betaald_datum']).'</td>
				  <td>'.date('d/m/Y',$record['datum']).'</td>
				  <td>'.$fact->DisplayMoney($record['bedrag']).'</td>
				  <td>'.$fact->DisplayMoney($excl).'</td>
				  <td>'.$fact->DisplayMoney($btw).'</td>
				  <td>[<a href="index.php?p=beheer_factuur&factuurId='.$record['factuurId'].'">edit</a>]</td>
				</tr>';
			}
			
			echo '</table><br />
			  <a href="index.php?p=factuur_vorig_kwartaal">Overzicht van het vorige kwartaal</a><br />
			  <a href="index.php?p=factuur_alles">Overzicht van alle betaalde facturen</a></td>
			  </tr>';
		}
		
		echo '</table>';
	break;
	
	case "factuur_vorig_kwartaal":
		$fact->notAllowed('99');	
		
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td>Overzicht van het vorige kwartaal</td>
		  </tr>';
		
		$query = "SELECT SUM( bedrag ) AS voldaan FROM `factuur` WHERE betaald = 'Y' AND datum BETWEEN '".$fact->vorige_kwartaaldatum(3)."' AND '".$fact->vorige_kwartaaldatum()."'";
        $query = mysql_query($query) or die (mysql_error());
        $record=mysql_fetch_array($query);

		$query19 = "SELECT SUM( bedrag ) AS voldaan
		FROM factuur f, klant k
		WHERE f.klantId = k.klantId AND
		f.betaald = 'Y' AND
		datum BETWEEN '".$fact->vorige_kwartaaldatum(3)."' AND '".$fact->vorige_kwartaaldatum()."' AND
		k.BTWtarrief = '19.0';";
		$query19 = mysql_query($query19) or die (mysql_error());
       	$record19=mysql_fetch_array($query19);

		$query10 = "SELECT SUM( bedrag ) AS voldaan
        FROM factuur f, klant k
        WHERE f.klantId = k.klantId AND
        f.betaald = 'Y' AND
        datum BETWEEN '".$fact->vorige_kwartaaldatum(3)."' AND '".$fact->vorige_kwartaaldatum()."' AND
        k.BTWtarrief = '0.0';";
        $query10 = mysql_query($query10) or die (mysql_error());
        $record10=mysql_fetch_array($query10);
		
		if(mysql_num_rows($query)==1)
        {
	        echo '<tr>
	            <td>&nbsp;</td>
	          </tr>
	          <tr bgcolor="#CCCCCC">
	            <td class="big">Voldaan dit kwartaal: 19%: '.$fact->displayMoney($record19['voldaan']).'
		    0%: '.$fact->displayMoney($record10['voldaan']).' totaal: '.$fact->displayMoney($record['voldaan']).'</td>
	          </tr>
	          <tr>
	            <td>&nbsp;</td>
	          </tr>';
        }else
		{	
			echo '<tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr bgcolor="#CCCCCC">
				<td class="big">Voldaan dit kwartaal</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>';
		}
		
		$query 	= "SELECT factuurId, betaald_datum, datum, bedrag, BTWtarrief, bedrijfsnaam, achternaam, voornaam
		FROM factuur f, klant k
		WHERE f.klantId=k.klantId AND
		betaald='Y' AND datum BETWEEN '".$fact->vorige_kwartaaldatum(3)."' AND '".$fact->vorige_kwartaaldatum()."' ORDER BY factuurId DESC";
		$query 	= mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($query)==0){
			echo '<tr>
				<td>Er zijn momenteel geen voldane facturen</td>
			  </tr>';
		}else{
			echo '<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="1">
			<tr>
			  <td><b>FactuurId</b></td>
			  <td><b>Naam</b></td>
			  <td><b>Betalings status</b></td>
			  <td><b>Factuur datum</b></td>
			  <td><b>Incl. btw</b></td>
			  <td><b>Excl. btw</b></td>
			  <td><b>BTW</b></td>
			  <td>&nbsp;</td>
			</tr>';
			
			while($record=mysql_fetch_array($query)){
				$excl = $record['bedrag']/(($record['BTWtarrief']/100)+1);
				$btw = $record['bedrag']-$excl;
				
				if($record['bedrijfsnaam']!="")
				{
					$naam = substr($record['bedrijfsnaam'], 0, 40);
				}else
				{
					$naam = substr($record['achternaam'], 0, 20);
					$naam.= ', ' ;
					$naam.= substr($record['voornaam'], 0, 20);
				}								
				
				echo '<tr>
				  <td><a href="index.php?p=display_factuur&factuurId='.$record['factuurId'].'">'.$record['factuurId'].'</a></td>
				  <td>'.$naam.'</td>
				  <td>Voldaan op '.date('d/m/Y',$record['betaald_datum']).'</td>
				  <td>'.date('d/m/Y',$record['datum']).'</td>
				  <td>'.$fact->DisplayMoney($record['bedrag']).'</td>
				  <td>'.$fact->DisplayMoney($excl).'</td>
				  <td>'.$fact->DisplayMoney($btw).'</td>
				  <td>[<a href="index.php?p=beheer_factuur&factuurId='.$record['factuurId'].'">edit</a>]</td>
				</tr>';
			}
			
			echo '</table><br />
			  <a href="index.php?p=factuur_alles">Overzicht van alle betaalde facturen</a></td>
			  </tr>';
		}
		
		echo '</table>';
	break;
	
	case "factuur_alles":
		$fact->notAllowed('99');	
		
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td>Overzicht van alle facturen</td>
		  </tr>';
		
		$query = "SELECT SUM( bedrag ) AS openstaand FROM `factuur` WHERE betaald = 'Y'";
		$query = mysql_query($query) or die (mysql_error());
		$record=mysql_fetch_array($query);
							
		$query19 = "SELECT SUM( bedrag ) AS openstaand
		FROM factuur f, klant k
		WHERE f.klantId = k.klantId AND
		f.betaald = 'Y' AND
		k.BTWtarrief = '19.0';";
		$query19 = mysql_query($query19) or die (mysql_error());
		$record19=mysql_fetch_array($query19);
						  
		$query10 = "SELECT SUM( bedrag ) AS openstaand
		FROM factuur f, klant k
		WHERE f.klantId = k.klantId AND
		f.betaald = 'Y' AND
		k.BTWtarrief = '0.0';";
		$query10 = mysql_query($query10) or die (mysql_error());
		$record10=mysql_fetch_array($query10);
				  
		if(mysql_num_rows($query)==1)
		{       
			echo'<tr>
			<td>&nbsp;</td>
          	  </tr>
          	  <tr bgcolor="#CCCCCC">
              <td class="big">Voldaan: 19%: '.$fact->displayMoney($record19['openstaand']).' 0%: '.$fact->displayMoney($record10['openstaand']).'
              totaal: '.$fact->displayMoney($record['openstaand']).'</td>
			  </tr>
	          <tr>
	            <td>&nbsp;</td>
	          </tr>';
        	}else
		{	
			echo '<tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr bgcolor="#CCCCCC">
				<td class="big">Voldaan</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>';
		}
		
		$query 	= "SELECT factuurId, betaald_datum, datum, bedrag, BTWtarrief, bedrijfsnaam, voornaam, achternaam
		FROM factuur f, klant k
		WHERE f.klantId=k.klantId AND
		betaald='Y' ORDER BY factuurId DESC";
		$query 	= mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($query)==0){
			echo '<tr>
				<td>Er zijn momenteel geen voldane facturen</td>
			  </tr>';
		}else{
			echo '<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="1">
			<tr>
			  <td><b>FactuurId</b></td>
			  <td><b>Naam</b></td>
			  <td><b>Betalings status</b></td>
			  <td><b>Factuur datum</b></td>
			  <td><b>Incl. btw</b></td>
			  <td><b>Excl. btw</b></td>
			  <td><b>BTW</b></td>
			  <td>&nbsp;</td>
			</tr>';
        
			while($record=mysql_fetch_array($query)){
					$excl = $record['bedrag']/(($record['BTWtarrief']/100)+1);
					$btw = $record['bedrag']-$excl;
					
					if($record['bedrijfsnaam']!="")
					{
						$naam = substr($record['bedrijfsnaam'], 0, 40);
					}
					else
					{
						$naam = substr($record['achternaam'], 0, 20);
						$naam.= ', ' ;
						$naam.= substr($record['voornaam'], 0, 20);
					}
		
					echo '<tr>
					  <td><a href="index.php?p=display_factuur&factuurId='.$record['factuurId'].'">'.$record['factuurId'].'</a></td>
					  <td>'.$naam.'</td>
					  <td>Voldaan op '.date('d/m/Y',$record['betaald_datum']).'</td>
					  <td>'.date('d/m/Y',$record['datum']).'</td>
					  <td>'.$fact->DisplayMoney($record['bedrag']).'</td>
					  <td>'.$fact->DisplayMoney($excl).'</td>
					  <td>'.$fact->DisplayMoney($btw).'</td>
					  <td>[<a href="index.php?p=beheer_factuur&factuurId='.$record['factuurId'].'">edit</a>]</td>
					</tr>';
			}
			
			echo '</table><br />
			  <a href="index.php?p=factuur_vorig_kwartaal">Overzicht van het vorige kwartaal</a></td>
			  </tr>';
		}
		
		echo '</table>';
	break;
	
	case "factuur_resend":
		$fact->notAllowed('99');
		
		if($fact->resend_factuur($_GET['factuurId'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Factuur herverzonden</td>
				<td align="right">&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">De factuur is herverzonden.<br /><br />
				Klik <a href="index.php?p=facturen">hier</a> om naar het overzicht van de facturen terug te gaan.</td>
			  </tr>
			</table>';
		}
	break;
	
	case "factuur_betaal":
		$fact->notAllowed('99');
	
		if($fact->factuur_betaald($_GET['factuurId'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Factuur voldaan</td>
				<td align="right">&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">De factuur is voldaan.<br /><br />
				Klik <a href="index.php?p=facturen">hier</a> om naar het overzicht van de facturen terug te gaan.</td>
			  </tr>
			</table>';
		}
	break;
	
	case "factuur_delete":
		$fact->notAllowed('99');
		
		if($fact->delete_factuur($_GET['factuurId'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Artikel gedelete</td>
				<td align="right">&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">De factuur is succesvol gedelete.<br /><br />
				Klik <a href="index.php?p=facturen">hier</a> om naar het overzicht van de facturen terug te gaan.</td>
			  </tr>
			</table>';
		}else{
			$fact->error('De factuur is al gecreerd en verzonden. Het is te laat om de factuur te deleten');
		}
	break;
	
	case "beheer_factuur":
		$query = "SELECT k.koppelId, k.artikelId, a.periode, a.naam, k.aantal, k.opmerking, k.opgezegd, k.datum, f.betaald
		FROM koppel_factuur_artikelen k, artikelen a, factuur f
		WHERE k.artikelId=a.artikelId AND
		k.factuurId=f.factuurId AND
		k.factuurId='".$_GET['factuurId']."'";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)==0){
			$fact->error('Er zijn geen artikelen gevonden die bij deze factuur horen.');
		}
		
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td>Overzicht inhoud factuur</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td><table width="100%"  border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td><b>artikelId</b></td>
				<td><b>naam</b></td>
				<td><b>periode</b></td>
				<td><b>opmerking</b></td>
				<td><b>aantal</b></td>
				<td><b>datum</b></td>
				<td><b>opgezegd?</b></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr><td colspan="8">&nbsp;</td></tr>';
		
		while($record=mysql_fetch_array($query)){
			echo '<tr>
				<td>'.$record['artikelId'].'</td>
				<td>'.$record['naam'].'</td>
				<td>'.$record['periode'].'</td>
				<td>'.$record['opmerking'].'</td>
				<td>'.$record['aantal'].'</td>
				<td>'.date(FACTUUR_DATUM_FORMAT,$record['datum']).'</td>
				<td>'.$record['opgezegd'].'</td>
				<td>[<a href="index.php?p=artikel_opzeggen&koppelId='.$record['koppelId'].'&factuurId='.$_GET['factuurId'].'">opzeggen</a>]';
				if($record['betaald']=='N'){
					echo' [<a href="index.php?p=artikel_delete&koppelId='.$record['koppelId'].'&factuurId='.$_GET['factuurId'].'">delete</a>]';
				}
				echo'</td>
			  </tr>';
		}
		
		echo '</table></td>
		  </tr>';
	break;
	
	case "artikel_opzeggen":
		$fact->notAllowed('99');
		
		if($fact->artikel_opzeggen($_GET['koppelId'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Artikel opgezegd</td>
				<td align="right">&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Het artikel is succesvol opgezegd.<br /><br />';
				if($_GET['factuurId']){
					echo 'Klik <a href="index.php?p=beheer_factuur&factuurId='.$_GET['factuurId'].'">hier</a> om naar het overzicht van de inhoud van de factuur.<br />';
				}else{
					echo 'Klik <a href="index.php?p=binnenkort_verlopen">hier</a> om naar het overzicht van verlopende artikelen te gaan.<br />';
				}
				echo'Klik <a href="index.php?p=facturen">hier</a> om naar het overzicht van de facturen terug te gaan.</td>
			  </tr>
			</table>';
		}
	break;
	
	case "artikel_delete":
		$fact->notAllowed('99');
		
		if($fact->artikel_delete($_GET['koppelId'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Artikel gedelete</td>
				<td align="right">&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Het artikel is succesvol gedelete.<br /><br />
				Klik <a href="index.php?p=beheer_factuur&factuurId='.$_GET['factuurId'].'">hier</a> om naar het overzicht van de inhoud van de factuur.<br />
				Klik <a href="index.php?p=facturen">hier</a> om naar het overzicht van de facturen terug te gaan.</td>
			  </tr>
			</table>';
		}
	break;
	
	case "klantenlijst":
		$fact->notAllowed('99');
		
		if(!$_GET['from']){
			$from = 0;
		}else{
			$from = $_GET['from']*LIJST_KLANTEN_PER_PAGINA;
		}
		
		if(!$_GET['zoekop'] OR !$_GET['term']){
			$query = "SELECT klantId, mail, voornaam, tussenvoegsel, achternaam, geslacht, bedrijfsnaam, telefoon, fax
			FROM klant ORDER BY achternaam";
		}else{
			$_GET['term'] = str_replace(' ', '%', $_GET['term']);
			$query = "SELECT klantId, mail, voornaam, tussenvoegsel, achternaam, geslacht, bedrijfsnaam, telefoon, fax
			FROM klant
			WHERE ".$_GET['zoekop']." LIKE '%".$_GET['term']."%' ".$_GET['extra']."
			ORDER BY achternaam";
		}
		if($_GET['extra']) $quer = $query;
		$query = mysql_query($query) or die (mysql_error());
		
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td colspan="7">Klantenlijst</td>
		  </tr>';
		if($_GET['extra']){
			echo '<tr>
			<td colspan="7">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="7"><b>Query:</b><br />'.$quer.'</td>
		  </tr>';
		}
		echo'<tr>
			<td colspan="7">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="7"><form name="form1" method="get">
			<input type="hidden" name="p" value="klantenlijst">
			  <table width="100%" border="0" cellspacing="0" cellpadding="1">
				<tr>
				  <td>Zoek op</td>
				  <td><select name="zoekop">';
					foreach($zoekop AS $table => $tekst){
						echo '<option value="'.$table.'"';
						if($table==$_GET['zoekop']){
						  echo ' selected="selected"';
						}
						echo '>'.ucfirst($tekst).'</option>';
					}
				  echo'</select></td>
				  <td>term</td>
				  <td><input type="text" name="term" value="'.$_GET['term'].'"></td>
				  <td>extra (SQL voor experts)</td>
				  <td><input type="text" name="extra" value="'.$_GET['extra'].'"></td>
				  <td><input type="submit" name="Submit" value="Zoek"></td>
				</tr>
			  </table>
			</form></td>
		  </tr>
		  <tr>
			<td colspan="7">&nbsp;</td>
		  </tr>
		  <tr>
			<td><b>KID</b></td>
			<td><b>e-mail</b></td>
			<td><b>naam</b></td>
			<td><b>bedrijfsnaam</b></td>
			<td><b>telefoon</b></td>
			<td><b>fax</b></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="7">&nbsp;</td>
		  </tr>';
		
		while($record=mysql_fetch_array($query)){
			echo '<tr>
				<td>'.$record['klantId'].'</td>
				<td><a href="mailto:'.$record['mail'].'">'.$record['mail'].'</a></td>
				<td><a href="index.php?p=persoonsgegevens&klantId='.$record['klantId'].'">
				'.$record['voornaam'].' '.$record['tussenvoegsel'].' '.$record['achternaam'].'</a> ('.$record['geslacht'].')</td>
				<td>'.$record['bedrijfsnaam'].'</td>
				<td>'.$record['telefoon'].'</td>
				<td>'.$record['fax'].'</td>
				<td>[<a href="index.php?p=persoonsgegevens&klantId='.$record['klantId'].'">edit</a>]</td>
			  </tr>';
		}
		
		echo'</table>';
	break;
	
	case "beheer_artikelen":
		$fact->notAllowed('99');
	
		$query = "SELECT * FROM artikelen";
		$query = mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($query)==0){
			$fact->error('Er zijn nog geen artikelen toegevoegd. Klik <a href="index.php?p=add_artikel">hier</a> om artikelen toe te voegen');
		}
		
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td>Overzicht van artikelen</td>
			<td align="right"><a href="index.php?p=add_artikel">nieuw artikel toevoegen</a></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="1">';
		
		while($record=mysql_fetch_array($query)){
			if($color=='#FFFFFF'){
				$color = '';
			}else{
				$color = '#FFFFFF';
			}
			
			echo '<tr>
				<td width="3%">'.$record['artikelId'].'</td>
				<td width="2%">'.$record['catId'].'</td>
				<td width="60%">'.$record['naam'].'</td>
				<td width="10%">'.$record['periode'].'</td>
				<td width="10%">'.$fact->DisplayMoney($record['inkoop_prijs']).'</td>
				<td width="10%">'.$fact->DisplayMoney($record['verkoop_prijs']).'</td>
				<td width="2%">[<a href="index.php?p=edit_artikel&artikelId='.$record['artikelId'].'">edit</a>]</td>
				<td width="3%">[<a href="javascript:shure(\'index.php?p=delete_artikel&artikelId='.$record['artikelId'].'\');">delete</a>]</td>
			  </tr>';
		}
		
		echo '</table></td>
		  </tr>';
	break;
	
	case "edit_artikel":
		$fact->notAllowed('99');
		
		if(!$_GET['artikelId']){
			$fact->error('Er is geen artikelId opgegeven');
		}
		
		$query = "SELECT * FROM artikelen WHERE artikelId='".$_GET['artikelId']."'";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)!=1){
			$fact->error('Er is geen artikel gevonden met het opgegeven artikelId');
		}
		
		$record = mysql_fetch_array($query);
		
		echo '<form name="form1" method="post" action="index.php?p=do_edit_artikel">
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td width="50%">Artikel aanpassen</td>
			<td align="right">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Naam van het artikel</td>
			<td><input name="naam" type="text" size="50" value="'.$record['naam'].'">
			<input type="hidden" name="artikelId" value="'.$record['artikelId'].'"></td>
		  </tr>
		  <tr>
			<td>Categorie</td>
			<td><select name="catId">';
			
			$queryc = "SELECT * FROM categorie ORDER BY catnaam";
			$queryc = mysql_query($queryc) or die (mysql_error());
			
			while($recordc=mysql_fetch_array($queryc))
			{
				if($recordc['catId']==$record['catId'])
				{
					$sel = ' selected="selected"';
				}else
				{
					$sel = '';
				}
				
				echo '<option value="'.$recordc['catId'].'"'.$sel.'>'.$recordc['catnaam'].'</option>';
			}
			
		echo '</select></td>
		  </tr>
		  <tr>
			<td>Periode van terugkering </td>
			<td><select name="periode">
			  <option value="jaar"'; 	 if($record['periode']=="jaar"){echo' selected="selected"';} echo'>Jaarlijks</option>
			  <option value="halfjaar"'; if($record['periode']=="halfjaar"){echo' selected="selected"';} echo'>Halfjaarlijks</option>
			  <option value="kwartaal"'; if($record['periode']=="kwartaal"){echo' selected="selected"';} echo'>Kwartaallijks</option>
			  <option value="maand"'; 	 if($record['periode']=="maand"){echo' selected="selected"';} echo'>Maandelijks</option>
			  <option value="eenmalig"'; if($record['periode']=="eenmalig"){echo' selected="selected"';} echo'>Eenmalig</option>
			</select></td>
		  </tr>
		  <tr>
			<td>Inkoop prijs </td>
			<td><input type="text" name="inkoop_prijs" value="'.$record['inkoop_prijs'].'"></td>
		  </tr>
		  <tr>
			<td>Verkoop prijs </td>
			<td><input type="text" name="verkoop_prijs" value="'.$record['verkoop_prijs'].'"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Aanpassen"></td>
		  </tr>
		</table>
		</form>';
	break;
	
	case "do_edit_artikel":
		$fact->notAllowed('99');
	
		if($fact->edit_artikel($_POST['artikelId'], $_POST['naam'], $_POST['catId'], $_POST['periode'], $_POST['inkoop_prijs'], $_POST['verkoop_prijs'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Artikel bewerkt</td>
				<td align="right">&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Het artikel is succesvol bewerkt.<br /><br />
				Klik <a href="index.php?p=add_artikel">hier</a> om een artikel toe te voegen.<br />
				Klik <a href="index.php?p=beheer_artikelen">hier</a> voor een overzicht van alle artikelen</td>
			  </tr>
			</table>';
		}
	
	break;
	
	case "delete_artikel":
		$fact->notAllowed('99');
	
		if($fact->delete_artikel($_GET['artikelId'], $_GET['shure'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Artikel verwijderd</td>
				<td align="right">&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Het artikel is succesvol verwijderd.<br /><br />
				Klik <a href="index.php?p=add_artikel">hier</a> om een artikel toe te voegen.<br />
				Klik <a href="index.php?p=beheer_artikelen">hier</a> voor een overzicht van alle artikelen</td>
			  </tr>
			</table>';
		}
	break;
	
	case "add_artikel":
		$fact->notAllowed('99');
		
		echo '<form name="form1" method="post" action="index.php?p=do_add_artikel">
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td width="50%">Artikel toevoegen</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Naam van het artikel</td>
			<td><input name="naam" type="text" size="50"></td>
		  </tr>
		  <tr>
			<td>Categorie</td>
			<td><select name="catId">';
			
			$queryc = "SELECT * FROM categorie ORDER BY catnaam";
			$queryc = mysql_query($queryc) or die (mysql_error());
			
			while($recordc=mysql_fetch_array($queryc))
			{
				echo '<option value="'.$recordc['catId'].'">'.$recordc['catnaam'].'</option>';
			}
			
		echo '</select></td>
		  </tr>
		  <tr>
			<td>Periode van terugkering </td>
			<td><select name="periode">
			  <option value="jaar">Jaarlijks</option>
			  <option value="halfjaar">Halfjaarlijks</option>
			  <option value="kwartaal">Kwartaallijks</option>
			  <option value="maand">Maandelijks</option>
			  <option value="eenmalig">Eenmalig</option>
			</select></td>
		  </tr>
		  <tr>
			<td>Inkoop prijs </td>
			<td><input type="text" name="inkoop_prijs"></td>
		  </tr>
		  <tr>
			<td>Verkoop prijs </td>
			<td><input type="text" name="verkoop_prijs"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Invoegen"></td>
		  </tr>
		</table>
		</form>';
	break;
	
	case "do_add_artikel":
		$fact->notAllowed('99');
		
		if($fact->artikel_invoegen($_POST['naam'], $_POST['catId'], $_POST['periode'], $_POST['inkoop_prijs'], $_POST['verkoop_prijs'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Artikel toegevoegd</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Het artikel is succesvol toegevoegd.<br /><br />
				Klik <a href="index.php?p=add_artikel">hier</a> om nog een artikel toe te voegen.<br />
				Klik <a href="index.php?p=beheer_artikelen">hier</a> voor een overzicht van alle artikelen</td>
			  </tr>
			</table>';
		}
	break;
	
	case "add_categorie":
		$fact->notAllowed('99');
		
		echo '<form name="form1" method="post" action="index.php?p=do_add_categorie">
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td width="50%">Categorie toevoegen</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Naam van de categorie</td>
			<td><input name="naam" type="text" size="50"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Invoegen"></td>
		  </tr>
		</table>
		</form>';
	break;
	
	case "do_add_categorie":
		$fact->notAllowed('99');
		
		if($fact->categorie_invoegen($_POST['naam'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Categorie toegevoegd</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">De categorie is succesvol toegevoegd.<br /><br />
				Klik <a href="index.php?p=add_categorie">hier</a> om nog een categorie toe te voegen.<br />
				Klik <a href="index.php?p=beheer_categorieen">hier</a> voor een overzicht van alle categorieën</td>
			  </tr>
			</table>';
		}
	break;
	
	case "beheer_categorieen":
		$fact->notAllowed('99');
	
		$query = "SELECT * FROM categorie";
		$query = mysql_query($query) or die (mysql_error());
		if(mysql_num_rows($query)==0){
			$fact->error('Er zijn nog geen categorie toegevoegd. Klik <a href="index.php?p=add_categorie">hier</a> om categorie toe te voegen');
		}
		
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td>Overzicht van categorieën</td>
			<td align="right"><a href="index.php?p=add_categorie">nieuwe categorie toevoegen</a></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="1">';
		
		while($record=mysql_fetch_array($query)){
			if($color=='#FFFFFF'){
				$color = '';
			}else{
				$color = '#FFFFFF';
			}
			
			echo '<tr color="'.$color.'">
				<td width="5%">'.$record['catId'].'</td>
				<td width="90%">'.$record['catnaam'].'</td>
				<td width="2%">[<a href="index.php?p=edit_categorie&catId='.$record['catId'].'">edit</a>]</td>
				<td width="3%">[<a href="javascript:shure(\'index.php?p=delete_categorie&catId='.$record['catId'].'\');">delete</a>]</td>
			  </tr>';
		}
		
		echo '</table></td>
		  </tr>';
	break;
	
	case "delete_categorie":
		$fact->notAllowed('99');
	
		if($fact->delete_categorie($_GET['catId'], $_GET['shure'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Categorie verwijderd</td>
				<td align="right">&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Het artikel is succesvol verwijderd.<br /><br />
				Klik <a href="index.php?p=add_categorie">hier</a> om nog een categorie toe te voegen.<br />
				Klik <a href="index.php?p=beheer_categorieen">hier</a> voor een overzicht van alle categorieën</td>
			  </tr>
			</table>';
		}
	break;
	
	case "edit_categorie":
		$fact->notAllowed('99');
		
		if(!$_GET['catId']){
			$fact->error('Er is geen catId opgegeven');
		}
		
		$query = "SELECT * FROM categorie WHERE catId='".$_GET['catId']."'";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)!=1){
			$fact->error('Er is geen categorie gevonden met het opgegeven catId');
		}
		
		$record = mysql_fetch_array($query);
		
		echo '<form name="form1" method="post" action="index.php?p=do_edit_categorie">
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td width="50%">Categorie aanpassen</td>
			<td align="right">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Naam van de categorie</td>
			<td><input name="naam" type="text" size="50" value="'.$record['catnaam'].'">
			<input type="hidden" name="catId" value="'.$record['catId'].'"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Aanpassen"></td>
		  </tr>
		</table>
		</form>';
	break;
	
	case "do_edit_categorie":
		$fact->notAllowed('99');
	
		if($fact->edit_categorie($_POST['catId'], $_POST['naam'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Categorie bewerkt</td>
				<td align="right">&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">De categorie is succesvol bewerkt.<br /><br />
				Klik <a href="index.php?p=add_categorie">hier</a> om nog een categorie toe te voegen.<br />
				Klik <a href="index.php?p=beheer_categorieen">hier</a> voor een overzicht van alle categorieën</td>
			  </tr>
			</table>';
		}
	break;
	
	case "incasso_overzicht":
		$fact->notAllowed('99');
		
		$query = "SELECT k.bedrijfsnaam, k.voornaam, k.achternaam, f.klantId, SUM(bedrag) as totaal, k.mail, k.telefoon
		FROM factuur f, klant k
		WHERE betaald ='c' and k.klantId = f.klantId
		GROUP BY f.klantId
		ORDER BY totaal DESC";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)==0){
			$fact->error('Er is zijn geen openstaande facturen');
		}
		
		echo '<table width="100%">
		<tr>
		  <td><b>Bedrijfsnaam</b></td>
		  <td><b>Voornaam</b></td>
		  <td><b>Achternaam</b></td>
		  <td><b>klantId</b></td>
		  <td><b>Totaal</b></td>
		  <td><b>E-mail</b></td>
		  <td><b>Telefoon</b></td>
		</tr>';
		
		while($record = mysql_fetch_array($query))
		{
			echo '<tr>
		  	  <td>'.$record['bedrijfsnaam'].'</td>
		  	  <td>'.$record['voornaam'].'</td>
		  	  <td>'.$record['achternaam'].'</td>
		  	  <td>'.$record['klantId'].'</td>
		  	  <td>'.$record['totaal'].'</td>
		  	  <td>'.$record['mail'].'</td>
		  	  <td>'.$record['telefoon'].'</td>
			</tr>';
		}
		
		echo '</table>';
	break;
	
	case "maak_factuur":
		$fact->notAllowed('99');
	
		$zoekop = array('mail','voornaam','tussenvoegsel','achternaam','bedrijfsnaam');
		
		echo '<form name="form1" method="get" action="index.php" target="mainFrame">
		<input type="hidden" name="p" value="maak_factuur">
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td width="50%">Factuur maken</td>
			<td align="right">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td>Zoek op</td>
		    <td><select name="zoek_op">';
		
		if(!$_GET['zoek_op']) $_GET['zoek_op'] = 'achternaam';
		foreach($zoekop AS $Z){
			echo '<option value="'.$Z.'"';
			if($Z==$_GET['zoek_op']){
				echo ' selected="selected"';
			}
			echo '>'.ucfirst($Z).'</option>';
		}
		
		echo'</select></td>
		  </tr>
		  <tr>
		    <td>Zoekterm</td>
		    <td><input type="text" name="term" value="'.$_GET['term'].'"> <input type="submit" name="Submit" value="Zoek"></td>
		  </tr>
		</table>
		</form>
		<form name="form1" method="get" action="index.php?p=maak_factuur_stap2">
		<input type="hidden" name="p" value="maak_factuur_stap2">
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td valign="top">Selecteer de desbetreffende klant </td>
			<td><select name="klantId" size="'.LENGTE_KLANTEN_SELECT_BOX.'">';
		
		$query = "SELECT klantId, voornaam, tussenvoegsel, achternaam, bedrijfsnaam FROM klant";
		
		if($_GET['term'] AND $_GET['zoek_op']){
			$_GET['term'] = str_replace(' ', '%', $_GET['term']);
			$query .= " WHERE ".$_GET['zoek_op']." LIKE '%".$_GET['term']."%'";
		}
		
		$query .= " ORDER BY achternaam;";
		
		$query = mysql_query($query) or die (mysql_error());
		while($record=mysql_fetch_array($query)){
			if($record['bedrijfsnaam']) $bedrijfsnaam = ' ('.stripslashes($record['bedrijfsnaam']).')';
			echo '<option value="'.$record['klantId'].'">'.stripslashes($record['achternaam']).' '.stripslashes($record['tussenvoegsel']).', '.stripslashes($record['voornaam']).$bedrijfsnaam.'</option>';
			unset($bedrijfsnaam);
		}
		
			echo'</select></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Verder"></td>
		  </tr>
		</table>
		</form>';
	
	break;
	
	case "maak_factuur_stap2":
		$fact->notAllowed('99');
		
		$query = "SELECT voornaam, tussenvoegsel, achternaam FROM klant WHERE klantId='".$_GET['klantId']."'";
		$query = mysql_query($query) or die (mysql_error());
		
		if(mysql_num_rows($query)!=1){
			$fact->error('Er komt geen klant voor met het opgegeven klantId');
		}
		
		$klant = mysql_fetch_array($query);
		
		echo '<form name="form1" method="post" action="index.php?p=maak_factuur_stap3">
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr>
			<td width="50%">Factuur maken</td>
			<td align="right">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Klant</td>
			<td>'.$klant['voornaam'].' '.$klant['tussenvoegsel'].' '.$klant['achternaam'].' ('.$_GET['klantId'].')
			<input type="hidden" name="klantId" value="'.$_GET['klantId'].'"></td>
		  </tr>';
		  
		$queryf = "SELECT factuurId, datum FROM factuur WHERE klantId='".$_GET['klantId']."' AND betaald='N'";
		$queryf = mysql_query($queryf) or die (mysql_error());
		if(mysql_num_rows($queryf)==0){
			echo '<input type="hidden" name="factuurId" value="new">';
		}else{
			echo '<tr>
			<td>Openstaande facturen</td>
			<td><select name="factuurId" size="'.LENGTE_OPEN_FACTUREN_SELECT_BOX.'">
			<option value="new">Nieuwe factuur maken</option>';
			
			while($factuur=mysql_fetch_array($queryf)){
				echo '<option value="'.$factuur['factuurId'].'"';
				if($_GET['factuurId']==$factuur['factuurId']){
					echo ' selected="selected"';
				}				
				echo'>'.$factuur['factuurId'].' - '.date('d/m/Y',$factuur['datum']).'</option>';
			}
			
			echo '</select></td>
			</tr>';
		}
		
		echo '<tr>
			<td>Categorie</td>
			<td><select name="catId" onchange="catChange(this.form.catId.value);" size="'.LENGTE_CATEGORIEEN_SELECT_BOX.'">';
			
			$queryc = "SELECT * FROM categorie ORDER BY catnaam";
			$queryc = mysql_query($queryc) or die (mysql_error());
			
			while($recordc=mysql_fetch_array($queryc))
			{
				if($recordc['catId']==$record['catId'])
				{
					$sel = ' selected="selected"';
				}else
				{
					$sel = '';
				}
				
				echo '<option value="'.$recordc['catId'].'"'.$sel.'>'.$recordc['catnaam'].'</option>';
			}
			
		echo '</select></td>
			</tr>
			<tr>
				<td valign="top">Artikel</td>
				<td><select name="artikelId" id="artikelId" size="'.LENGTE_ARTIKELEN_SELECT_BOX.'"></select></td>
			  </tr>
			  <tr>
				<td valign="top">Opmerking</td>
				<td><textarea name="opmerking"></textarea></td>
			  </tr>
			  <tr>
				<td valign="top">Aantal</td>
				<td><input name="aantal" type="text" size="8"></td>
			  </tr>
			  <tr>
				<td valign="top">&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td valign="top">&nbsp;</td>
				<td><input type="submit" name="Submit" value="Voeg toe"></td>
			  </tr>';
		
		echo '</table>';
	break;
	
	case "maak_factuur_stap3":
		$fact->notAllowed('99');
	
		if($_POST['factuurId']=='new'){
			$factuurId = $fact->nieuwe_factuur($_POST['klantId']);
			if(!$factuurId){
				$fact->error('Er kon geen nieuwe factuur aangemaakt worden');
			}
		}else{
			$factuurId = $_POST['factuurId'];
		}
		
		if($fact->insert_factuur_artikel($factuurId,$_POST['artikelId'],$_POST['opmerking'],$_POST['aantal'])){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Artikel toegevoegd</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Het artikel is succesvol toegevoegd.<br /><br />
				Klik <a href="index.php?p=maak_factuur_stap2&factuurId='.$factuurId.'&klantId='.$_POST['klantId'].'">hier</a> om nog een artikel toe te voegen.<br />
				Klik <a href="index.php?p=finish_factuur&factuurId='.$factuurId.'">hier</a> om de factuur af te maken.</td>
			  </tr>
			</table>';
		}
	
	break;
	
	case "finish_factuur":
		$fact->finish_factuur($_GET['factuurId'], 'DISP');
	break;
	
	case "json_artikelen_per_cat":
		$return = array();
		$query = "SELECT artikelId, naam FROM artikelen WHERE catId='".$_GET['catId']."' ORDER BY naam;";
		$query = mysql_query($query) or die (mysql_error());
		while($record=mysql_fetch_array($query)){
			$return[] = array('artikelId' => $record['artikelId'], 'naam' => $record['naam']);
		}
		
		$json = new Services_JSON();
		echo $json->encode($return);
		unset($json);
	break;
	
	case "logout":
		if($fact->logout()){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				<td width="50%">Uitgelogd</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2">Tot ziens. U wordt nu terug naar de index geleid.
				<script language="javascript">
				setTimeout("parent.window.location.href=\'index.php\'", 4000);
				</script></td>
			  </tr>
			</table>';
		}
	
	break;
}

if($_GET['p']!='finish_factuur' &&
$_GET['p']!='' &&
$_GET['p']!='json_artikelen_per_cat' &&
$_GET['p']!='display_factuur') {
	include_once('templates/footer.tpl.php');
}
?>
