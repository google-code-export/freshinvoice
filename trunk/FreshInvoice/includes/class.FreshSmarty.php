<?
class FreshSmarty extends Smarty
{
	public function FreshSmarty () 
	{
		$this->__construct();
	}
	
	public function __construct()
	{
		$this->template_dir = TPLDIR;
		$this->compile_dir = COMPILEDIR;
		$this->cache_dir = CACHEDIR;
		$this->config_dir = CONFIGSDIR;
		
		$this->compile_check = true;
		$this->debugging = false;
	}
}
?>