<?
class FreshSmarty extends Smarty
{
	public function FreshSmarty ($fact) 
	{
		$this->__construct($fact);
	}
	
	public function __construct($fact)
	{
		/* STANDARD SMARTY VARS */
		$this->template_dir = TPLDIR;
		$this->compile_dir = COMPILEDIR;
		$this->cache_dir = CACHEDIR;
		$this->config_dir = CONFIGSDIR;
		
		$this->compile_check = true;
		$this->debugging = false;
		
		/* TEMPLATE LOGIN VALUES */
		$this->assign("allowed", $_SESSION['usergroup']);
		$this->assign("loggedIn", $fact->isLoggedIn());
		
		/* STANDARD SETTINGS */
		$this->assign("bedrijfsnaam", BEDRIJFSNAAM);
		
		/* LOCALIZATION */
		if(!$_SESSION['language']) $_SESSION['language'] = DEFAULTLANG;
		
		if(@file_exists("localization/".$_SESSION['language'].".lang.php"))
		{
			include_once("localization/".$_SESSION['language'].".lang.php");
		}else
		{
			include_once("localization/english.lang.php");
		}
		
		/* ASSIGN THE SMARTY LANG */
		$this->assign("lang", $lang); 
	}
}
?>