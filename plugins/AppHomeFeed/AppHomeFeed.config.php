<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class AppHomeFeed_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "standard";
	public $pluginName = "AppHomeFeed";
	public $title = "Home Page Tools";
	public $version = 1.0;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "Provides tools for working with the home page of UniFaction.";
	
	public $data = array();
	
	
/****** Install this plugin ******/
	public function install (
	)			// <bool> RETURNS TRUE on success, FALSE on failure.
	
	// $plugin->install();
	{
		Database::exec("
		CREATE TABLE IF NOT EXISTS `home_content`
		(
			`id`					int(10)			unsigned	NOT NULL	AUTO_INCREMENT,
			`date_posted`			int(10)			unsigned	NOT NULL	DEFAULT '0',
			
			`uni_id`				int(10)			unsigned	NOT NULL	DEFAULT '0',
			`url`					varchar(100)				NOT NULL	DEFAULT '',
			`title`					varchar(72)					NOT NULL	DEFAULT '',
			`description`			varchar(250)				NOT NULL	DEFAULT '',
			
			`primary_hashtag`		varchar(22)					NOT NULL	DEFAULT '',
			`hashtags`				varchar(250)				NOT NULL	DEFAULT '',
			
			`thumbnail`				varchar(100)				NOT NULL	DEFAULT '',
			
			PRIMARY KEY (`id`),
			INDEX (`date_posted`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
		
		return $this->isInstalled();
	}
	
	
/****** Check if this plugin was successfully installed ******/
	public static function isInstalled (
	)			// <bool> RETURNS TRUE on success, FALSE on failure.
	
	// $plugin->isInstalled();
	{
		// Make sure the newly installed tables exist
		return DatabaseAdmin::columnsExist("home_content", array("id", "date_posted"));
	}
	
}
