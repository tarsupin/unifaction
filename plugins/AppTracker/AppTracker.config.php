<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class AppTracker_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "standard";
	public $pluginName = "AppTracker";
	public $title = "UniFaction Site Tracker";
	public $version = 1.0;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "This system tracks what sites each user has logged into, and their last visit time.";
	
	public $data = array();
	
	
/****** Install this plugin ******/
	public function install (
	)			// <bool> RETURNS TRUE on success, FALSE on failure.
	
	// $plugin->install();
	{
		Database::exec("
		CREATE TABLE IF NOT EXISTS `account_tracker`
		(
			`uni_id`				int(10)			unsigned	NOT NULL	DEFAULT '0',
			`site_handle`			varchar(22)					NOT NULL	DEFAULT '',
			
			`total_connections`		mediumint(8)	unsigned	NOT NULL	DEFAULT '0',
			
			`date_connected`		int(10)			unsigned	NOT NULL	DEFAULT '0',
			`date_lastLogin`		int(10)			unsigned	NOT NULL	DEFAULT '0',
			
			UNIQUE (`uni_id`, `site_handle`),
			INDEX (`date_connected`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 PARTITION BY KEY (`uni_id`) PARTITIONS 31;
		");
		
		return $this->isInstalled();
	}
	
	
/****** Check if the plugin was successfully installed ******/
	public static function isInstalled (
	)			// <bool> TRUE if successfully installed, FALSE if not.
	
	// $plugin->isInstalled();
	{
		// Make sure the newly installed tables exist
		return DatabaseAdmin::columnsExist("account_tracker", array("uni_id", "site_handle"));
	}
	
}