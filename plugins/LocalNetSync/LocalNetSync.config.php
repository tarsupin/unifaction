<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class LocalNetSync_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "api";
	public $pluginName = "LocalNetSync";
	public $title = "Local Panel Sync";
	public $version = 1.0;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "Authenticates and validates sites for the local development control panel.";
	
	public $data = array();
	
}