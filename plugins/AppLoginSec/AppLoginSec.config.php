<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class AppLoginSec_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "standard";
	public $pluginName = "AppLoginSec";
	public $title = "Login Security";
	public $version = 0.6;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "Login Security System for UniFaction.";
	
	public $data = array();
	
	
/****** Install this plugin ******/
	public function install (
	)			// <bool> RETURNS TRUE on success, FALSE on failure.
	
	// $plugin->install();
	{
		Database::exec("
		CREATE TABLE IF NOT EXISTS `login_failures`
		(
			`uni_id`				int(10)			unsigned	NOT NULL	DEFAULT '0',
			
			`ip`					varchar(45)					NOT NULL	DEFAULT '',
			`fingerprint`			varchar(120)				NOT NULL	DEFAULT '',
			
			`date_attempt`			int(10)			unsigned	NOT NULL	DEFAULT '0',
			
			INDEX (`uni_id`, `date_attempt`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 PARTITION BY KEY(uni_id) PARTITIONS 5;
		");
		
		Database::exec("
		CREATE TABLE IF NOT EXISTS `login_security_questions`
		(
			`uni_id`				int(10)			unsigned	NOT NULL	DEFAULT '0',
			
			`question`				varchar(80)					NOT NULL	DEFAULT '',
			`answer`				varchar(22)					NOT NULL	DEFAULT '',
			
			UNIQUE (`uni_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 PARTITION BY KEY(uni_id) PARTITIONS 5;
		");
		
		return $this->isInstalled();
	}
	
	
/****** Check if the plugin was successfully installed ******/
	public static function isInstalled (
	)			// <bool> TRUE if successfully installed, FALSE if not.
	
	// $plugin->isInstalled();
	{
		// Make sure the newly installed tables exist
		$pass = DatabaseAdmin::columnsExist("login_failures", array("uni_id", "date_attempt"));
		$pass2 = DatabaseAdmin::columnsExist("login_security_questions", array("uni_id", "question", "answer"));
		
		return ($pass and $pass2);
	}
	
}