<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class AppVerification_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "standard";
	public $pluginName = "AppVerification";
	public $title = "User Verification";
	public $version = 0.8;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "Allows users to verify their accounts through a confirmation link in their email.";
	
	public $data = array();
	
}