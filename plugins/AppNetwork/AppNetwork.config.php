<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class AppNetwork_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "standard";
	public $pluginName = "AppNetwork";
	public $title = "Network Information System";
	public $version = 1.0;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "Tracks information related to each site on the network.";
	
	public $data = array();
	
	
/****** Install this plugin ******/
	public function install (
	)			// <bool> RETURNS TRUE on success, FALSE on failure.
	
	// $plugin->install();
	{
		Database::exec("
		CREATE TABLE IF NOT EXISTS `network_info`
		(
			`site_handle`			varchar(22)					NOT NULL	DEFAULT '',
			
			`uni_id`				int(10)			unsigned	NOT NULL	DEFAULT '0',
			`clearance`				tinyint(1)		unsigned	NOT NULL	DEFAULT '0',
			
			`date_created`			int(10)			unsigned	NOT NULL	DEFAULT '0',
			`is_confirmed`			tinyint(1)		unsigned	NOT NULL	DEFAULT '0',
			
			`site_name`				varchar(48)					NOT NULL	DEFAULT '',
			`site_url`				varchar(48)					NOT NULL	DEFAULT '',
			
			`category`				varchar(22)					NOT NULL	DEFAULT '',
			`subcategory`			varchar(22)					NOT NULL	DEFAULT '',
			
			`description`			varchar(100)				NOT NULL	DEFAULT '',
			`keywords`				varchar(120)				NOT NULL	DEFAULT '',
			
			`contact_name`			varchar(42)					NOT NULL	DEFAULT '',
			`contact_phone`			varchar(36)					NOT NULL	DEFAULT '',
			
			`loc_country`			varchar(36)					NOT NULL	DEFAULT '',
			`loc_state`				varchar(36)					NOT NULL	DEFAULT '',
			`loc_city`				varchar(36)					NOT NULL	DEFAULT '',
			`loc_zipcode`			varchar(36)					NOT NULL	DEFAULT '',
			
			PRIMARY KEY (`site_handle`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 PARTITION BY KEY (`site_handle`) PARTITIONS 7;
		");
		
		Database::exec("
		CREATE TABLE IF NOT EXISTS `network_registry`
		(
			`uni_id`				int(10)			unsigned	NOT NULL	DEFAULT '0',
			`site_handle`			varchar(22)					NOT NULL	DEFAULT '',
			
			UNIQUE (`uni_id`, `site_handle`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 PARTITION BY KEY (`uni_id`) PARTITIONS 7;
		");
		
		return $this->isInstalled();
	}
	
	
/****** Check if the plugin was successfully installed ******/
	public static function isInstalled (
	)			// <bool> TRUE if successfully installed, FALSE if not.
	
	// $plugin->isInstalled();
	{
		// Make sure the newly installed tables exist
		$pass1 = DatabaseAdmin::columnsExist("network_info", array("site_handle", "uni_id", "category", "description"));
		$pass2 = DatabaseAdmin::columnsExist("network_registry", array("uni_id", "site_handle"));
		
		return ($pass1 and $pass2);
	}
	
}