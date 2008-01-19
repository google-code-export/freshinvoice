<?
include_once('config.inc.php');

$fact->auto_herhaal('jaar');
$fact->auto_herhaal('halfjaar');
$fact->auto_herhaal('kwartaal');
$fact->auto_herhaal('maand');

if(date("d")==date("t") && date("d") <> 31) // LAST DAY OF THE MONTH AND NOT 31st
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

if(date('D')=='Mon')
{
	$fact->late_facturen_notificatie();
}
?>
