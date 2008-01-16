<?
class FreshSmarty extends Smarty
{
	public function FreshSmarty ($fact) 
	{
		$this->__construct($fact);
	}
	
	public function __construct($fact)
	{
		$this->template_dir = TPLDIR;
		$this->compile_dir = COMPILEDIR;
		$this->cache_dir = CACHEDIR;
		$this->config_dir = CONFIGSDIR;
		
		$this->compile_check = true;
		$this->debugging = false;
		
		$this->assign("allowed", $_SESSION['usergroup']);
		$this->assign("loggedIn", $fact->isLoggedIn());
		$this->assign("bedrijfsnaam", BEDRIJFSNAAM);
	}
}
?>