<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class TrackerAPI_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "api";
	public $pluginName = "TrackerAPI";
	public $title = "Site Tracker Synchronizer";
	public $version = 1.0;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "Returns the list of users registered on sites (in packets) for synchronizing purposes.";
	
	public $data = array();
	
}