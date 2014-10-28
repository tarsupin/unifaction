<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class AppAccount_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "standard";
	public $pluginName = "AppAccount";
	public $title = "Authentication Account System";
	public $version = 1.0;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "The account system for Auth.";
	public $dependencies = array("User");
	
	public $data = array();
	
	
/****** Install this plugin ******/
	public function install (
	)			// <bool> RETURNS TRUE on success, FALSE on failure.
	
	// $plugin->install();
	{
		// If already installed, don't run this section again
		if($this->isInstalled()) { return true; }
		
		# Remove the uni_id, partitions, and indexes that interfere with the updates
		DatabaseAdmin::dropIndex("users", "uni_id");
		DatabaseAdmin::removePartitions("users");
		DatabaseAdmin::dropColumn("users", "uni_id");
		
		# Prepare new columns for the users table
		DatabaseAdmin::addColumn("users", "uni_id", "int(10) unsigned not null auto_increment primary key first", "");
		DatabaseAdmin::addColumn("users", "email", "varchar(80) not null", "");
		DatabaseAdmin::addColumn("users", "password", "varchar(128) not null", "");
		DatabaseAdmin::addColumn("users", "verified", "tinyint(1) unsigned not null", "0");
		DatabaseAdmin::addColumn("users", "referred_by", "int(10) unsigned not null", "0");
		
		# Set the partition on the users table
		DatabaseAdmin::setPartitions("users", "key", "uni_id", 13);
		
		// Invitation Codes
		Database::exec("
		CREATE TABLE IF NOT EXISTS `invitation_codes`
		(
			`uni_id`				int(10)			unsigned	NOT NULL	DEFAULT '0',
			`redeemed_by`			int(10)			unsigned	NOT NULL	DEFAULT '0',
			
			`invite_code`			char(22)					NOT NULL	DEFAULT '',
			`invite_level`			tinyint(1)		unsigned	NOT NULL	DEFAULT '0',
			
			`date_acquired`			int(10)			unsigned	NOT NULL	DEFAULT '0',
			
			INDEX (`uni_id`, `redeemed_by`),
			UNIQUE (`invite_code`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
		
		return $this->isInstalled();
	}
	
	
/****** Check if the plugin was successfully installed ******/
	public static function isInstalled (
	)			// <bool> TRUE if successfully installed, FALSE if not.
	
	// $plugin->isInstalled();
	{
		// Make sure the newly installed tables exist
		$pass1 = DatabaseAdmin::columnsExist("users", array("uni_id", "email", "password", "referred_by"));
		$pass2 = DatabaseAdmin::columnsExist("invitation_codes", array("uni_id", "invite_code"));
		
		return ($pass1 and $pass2);
	}
	
}
