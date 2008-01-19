<?
define("PATH",			"/data/httpd/www.freshway.biz/HTML/freshinvoice/");
define("DOMAIN",        "freshway.biz");
define("URL",			"http://www.freshway.biz/freshinvoice/");
define("MAILADDR",		"sales@example.org");
define("FROMNAME",		"Henk Smits");
define("BEDRIJFSNAAM",	"Example.org");
define("AFSLUITING",	"Met vriendelijke groet,\n\nHenk Smits\nExample.org");
define("INVOICEPREPEND","FRE"); // INVOICE NUMBER WILL BE FRE1001 OR ABC1001
define("DB_HOSTNAME", 	"localhost"); // LIKE localhost OR 192.168.1.2
define("DB_USERNAME", 	"username"); // LIKE freshinvoice OR adminstration
define("DB_PASSWORD", 	"password"); // LIKE ds8J2xj7
define("DB_DATABASE", 	"database"); // LIKE freshinvoice OR adminstration

define("MAILER","sendmail"); // qmail | mail | sendmail | smtp

if(MAILER=='smtp'){
	define ("SMTP_HOST", "172.16.0.2");
}

ini_set("include_path", ".:".PATH);

// OPTIES
define("BETALINGS_TERMIJN", 					"14"); // DAGEN
define("BETALINGS_NOTIFICATIE", 				"20"); // DAGEN

// DESIGN OPTIES
define("LENGTE_KLANTEN_SELECT_BOX", 			"20");
define("LENGTE_ARTIKELEN_SELECT_BOX", 			"20");
define("LENGTE_OPEN_FACTUREN_SELECT_BOX", 		"5");
define("LENGTE_CATEGORIEEN_SELECT_BOX", 		"5");
define("LIJST_KLANTEN_PER_PAGINA", 				"40");

// FACTUUR OPTIES
define("FACTUUR_LOGO", 			'<a href="http://www.freshway.biz"><img src="http://www.freshway.biz/logo.jpg" width="257" height="88" border="0"></a>');
define("FACTUUR_DATUM_FORMAT",  'd/m/Y'); //www.php.net/date
define("VERSION", '1.2.2');

// SMARTY
define("TPLDIR",		PATH."templates/");
define("COMPILEDIR",	PATH."templates_c/");
define("CACHEDIR",		PATH."cache/");
define("CONFIGSDIR",	PATH."configs/");

/* LOCALIZATION */
define("DEFAULTLANG",	"english");

$btwTarrieven	= array('19.0','20.0','6.0','0.0');

$KVKplaatsen	= array(
'Amsterdam',
'Centraal Gelderland',
'Drenthe',
'Flevoland',
'Friesland',
'Gooi-en Eemland',
'Groningen',
'Haaglanden',
'Leiden (Rijnland)',
'Limburg-Noord',
'Midden-Brabant',
'Noordwest-Holland',
'Oost-Brabant',
'Regio Zwolle',
'Rivierenland',
'Rotterdam',
'Utrecht',
'Veluwe en Twente',
'West-Brabant',
'Zeeland',
'Zuid-Limburg');

$bedrijfsvormen	= array(
"Besloten Vennootschap",
"BV in oprichting",
"Cooperatie",
"Commanditaire Vennotschap",
"Eenmanszaak",
"Kerkgenootschap",
"Naamloze Vennootschap",
"Onderlinge Waarborg Maatschappij",
"Rederij",
"Stichting",
"Vereniging",
"Vennootschap onder firma",
"Buitenlandse EG  Vennootschap",
"Buitenlandse rechtsvorm/onderneming",
"Europees Economisch Samenwerkingsverband",
"Anders of onbekend");

$usergroups	= array('1'=>'klant', '99' => 'admin');

$zoekop		= array(
'mail'	=>	'e-mail adres',
'usergroup'	=>	'usergroup',
'voornaam' => 'voornaam',
'tussenvoegsel' => 'tussenvoegsel',
'achternaam' => 'achternaam',
'geslacht' => 'geslacht',
'bedrijfsnaam' => 'bedrijfsnaam',
'straatnaam' => 'straatnaam',
'huisnummer' => 'huisnummer',
'postcode' => 'postcode',
'plaatsnaam' => 'plaatsnaam',
'land' => 'land',
'telefoon' => 'telefoonnummer',
'fax' => 'faxnummer',
'BTWnummer' => 'BTW nummer',
'BTWtarrief' => 'BTW tarrief',
'KVKnummer' => 'KVK nummer',
'KVKplaats' => 'KVK plaats');

$landen = array('Afghanistan','Albania','Algeria','Andorra',
'Angola','Anguilla','Antarctica','Antigua and Barbuda',
'Argentina','Armenia','Aruba','Australia',
'Austria','Azerbaijan','Bahrain','Bangladesh',
'Barbados','Belarus','Belgium','Belize',
'Benin','Bermuda','Bhutan','Bolivia',
'Bosnia','Herzegovina','Botswana','Brazil',
'British Virgin Islands','Bulgaria','Burkina Faso','Burma',
'Burundi','Cambodia','Cameroon','Canada',
'Cape Verde','Cayman Islands','Central African Republic','Chad',
'Chile','China','Christmas Island','Colombia',
'Comoros','Cook Islands','Costa Rica','Cote D\' Ivoire',
'Croatia','Cuba','Cyprus','Czech Republic',
'Democratic Republic of The Congo','Denmark','Djibouti','Dominica',
'Dominican Republic','Ecuador','Egypt','El Salvador',
'Equatorial Guinea','Eritrea','Estonia','Ethiopia',
'Falkland Islands','Fiji','Finland','Former Yugoslav Rep. of Macedonia',
'France','French Guiana','French Polynesia','Gabon',
'Georgia','Germany','Ghana','Gibraltar',
'Greece','Greenland','Grenada','Guadeloupe',
'Guatemala','Guinea','Guinea-bissau','Guyana',
'Haiti','Honduras','Hungary','Iceland',
'India','Indonesia','Iran','Iraq',
'Ireland','Isle of Man','Israel','Italy',
'Jamaica','Jordan','Kazakhstan','Kenya',
'Kiribati','Kuwait','Kyrgyzstan','Laos',
'Latvia','Lebanon','Lesotho','Liberia',
'Libya','Liechtenstein','Lithuania','Luxembourg',
'Madagascar','Malawi','Malaysia','Maldives',
'Mali','Malta','Martinique','Mauritania',
'Mauritius','Mayotte','Mexico','Moldova',
'Monaco','Morocco','Mozambique','Namibia',
'Nauru','Nepal','Netherlands','Netherlands Antilles',
'New Caledonia','New Zealand','Nicaragua','Niger',
'Nigeria','Norway','Oman','Pakistan',
'Panama','Papua New Guinea','Paraguay','Peru',
'Philippines','Poland','Portugal','Qatar',
'Republic of The Congo','Reunion','Romania','Russia',
'Rwanda','S. Georgia and S. Sandwich Islands','Saint Lucia','San Marino',
'Sao Tome and Principe','Saudi Arabia','Senegal','Seychelles',
'Sierra Leone','Slovakia','Slovenia','Solomon Islands',
'Somalia','South Africa','Spain','Sri Lanka',
'St. Helena','St. Kitts and Nevis','Sudan','Suriname',
'Swaziland','Sweden','Switzerland','Syria',
'Taiwan','Tajikistan','Thailand','The Bahamas',
'The Gambia','Togo','Tonga','Trinidad and Tobago',
'Tunisia','Turkey','Turkmenistan','Turks and Caicos Islands',
'Tuvalu','Uganda','Ukraine','United Arab Emirates',
'United Kingdo','United Kingdom','United Republic of Tanzania','United States',
'Uruguay','Uzbekistan','Vanuatu','Venezuela',
'Vietnam','West Bank','Western Sahara','Yemen',
'Yugoslavia','Zambia','Zimbabwe');

mysql_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
mysql_select_db(DB_DATABASE);

function __autoload($class_name)
{
	if (file_exists(PATH.'includes/class.'.$class_name.'.php'))
	{
		require_once PATH.'includes/class.'.$class_name.'.php';
	}
}

if(!class_exists('PHPmailer')) include_once(PATH.'includes/class.phpmailer.php');
if(!class_exists('SMTP')) include_once(PATH.'includes/class.smtp.php');
if(!class_exists('FIMailer')) include_once(PATH.'includes/class.fimailer.php');
if(!class_exists('Services_JSON')) include_once(PATH.'includes/class.JSON.php');
if(!class_exists('Manager')) include_once(PATH.'includes/class.Manager.php');
if(!class_exists('Smarty')) include_once(PATH.'includes/Smarty/Smarty.class.php');
if(!class_exists('factuur')) include_once(PATH.'includes/class.factuur.php');

$fact = new factuur();

session_set_cookie_params(time()+(60*60*24*365), '/', '.'.DOMAIN);
session_start();
?>