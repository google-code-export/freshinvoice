<?
include_once('config.inc.php');
include_once(PATH.'includes/factuur.class.php');

$fact = new factuur;

$fact->auto_herhaal('jaar');
$fact->auto_herhaal('halfjaar');
$fact->auto_herhaal('kwartaal');
$fact->auto_herhaal('maand');

if(date("d")==date("t")) // LAST DAY OF THE MONTH
{
	$fact->auto_herhaal('jaar', '>');
	$fact->auto_herhaal('halfjaar', '>');
	$fact->auto_herhaal('kwartaal', '>');
	$fact->auto_herhaal('maand', '>');
}

if(date('d')=='1'){
	$fact->factuur_creator('Y');
}

$fact->factuur_creator('N');

$fact->late_facturen_notificatie();
?>
