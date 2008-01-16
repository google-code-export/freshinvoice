<?
include_once('config.inc.php');

switch($_GET['p']){
	default:
		$fs = new FreshSmarty($fact);
		
		if($fact->isLoggedIn())
		{
			$fs->assign("tpl_name", "home");
		}else
		{
			$fs->assign("tpl_name", "login");
		}
		
		$fs->display('index.tpl.php');
	break;
}
?>