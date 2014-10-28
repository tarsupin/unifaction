<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class AutoUpdateAPI_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "api";
	public $pluginName = "AutoUpdateAPI";
	public $title = "AutoUpdater API";
	public $version = 1.0;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "Instructs sites what plugins they need to update, and facilitates the process.";
	
	public $data = array();
	
}
