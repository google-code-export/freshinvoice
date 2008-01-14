<?
include_once('config.inc.php');

$fact = new factuur;

switch($_GET['p']){
	default:
		$fs = new FreshSmarty();
		$fs->assign("tpl_name", "home");
		$fs->assign("allowed", $_SESSION['usergroup']);
		$fs->display('index.tpl.php');
	break;
}
?>