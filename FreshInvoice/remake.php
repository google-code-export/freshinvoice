<?
include_once('config.inc.php');

/* MAKE THE INVOICES WITHOUT SENDING THE REMINDER MAILS */

$fact = new factuur;

if(date('d')=='1'){
        $fact->factuur_creator('Y');
}

$fact->factuur_creator('N');
?>