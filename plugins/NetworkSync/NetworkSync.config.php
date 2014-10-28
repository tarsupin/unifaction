<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class NetworkSync_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "api";
	public $pluginName = "NetworkSync";
	public $title = "Network Site Synchronizer";
	public $version = 1.0;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "Creates and processes connections to other sites on the UniFaction network.";
	
	public $data = array();
	
}