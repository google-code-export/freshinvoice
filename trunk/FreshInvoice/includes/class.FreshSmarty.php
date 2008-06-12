<?
class FreshSmarty extends Smarty
{
	public function FreshSmarty ($fact) 
	{
		$this->__construct($fact);
	}
	
	public function __construct($fact)
	{
		global $lang;
		
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
		
		/* ASSIGN THE SMARTY LANG */
		$this->assign("lang", $lang); 
	}
}
?>