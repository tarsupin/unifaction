<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class AppMultipleAcct_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "standard";
	public $pluginName = "AppMultipleAcct";
	public $title = "Multiple Account Handler";
	public $version = 1.0;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "The multiple account handler for Auth.";
	
	public $data = array();
	
	
/****** Install this plugin ******/
	public function install (
	)			// <bool> RETURNS TRUE on success, FALSE on failure.
	
	// $plugin->install();
	{
		Database::exec("
		CREATE TABLE IF NOT EXISTS `users_multi_accounts`
		(
			`uni_id`				int(10)			unsigned	NOT NULL	DEFAULT '0',
			`access_to_id`			int(10)			unsigned	NOT NULL	DEFAULT '0',
			
			UNIQUE (`uni_id`, `access_to_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 PARTITION BY KEY (`uni_id`) PARTITIONS 31;
		");
		
		Database::exec("
		CREATE TABLE IF NOT EXISTS `users_multi_accounts_granted`
		(
			`uni_id`				int(10)			unsigned	NOT NULL	DEFAULT '0',
			`granted_to_id`			int(10)			unsigned	NOT NULL	DEFAULT '0',
			
			UNIQUE (`uni_id`, `granted_to_id`)
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
		$pass1 = DatabaseAdmin::columnsExist("users_multi_accounts", array("uni_id", "access_to_id"));
		$pass2 = DatabaseAdmin::columnsExist("users_multi_accounts_granted", array("uni_id", "granted_to_id"));
		
		return ($pass1 and $pass2);
	}
	
}
