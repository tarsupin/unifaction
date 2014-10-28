<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

class AppDupeTracker_config {
	
	
/****** Plugin Variables ******/
	public $pluginType = "standard";
	public $pluginName = "AppDupeTracker";
	public $title = "Account Duplication Tracker";
	public $version = 0.1;
	public $author = "Brint Paris";
	public $license = "UniFaction License";
	public $website = "http://unifaction.com";
	public $description = "Provides tools to track duplicate accounts (mules).";
	
	public $data = array();
	
	
/****** Install this plugin ******/
	public function install (
	)			// <bool> RETURNS TRUE on success, FALSE on failure.
	
	// $plugin->install();
	{
		/*
			Things to check for when determining duplicate entries:
				
				* Same IP, Password Hash, Browser Hash
				* Stored Sessions or Cookies when logging into another account
				* Similar grammar, language.
				* Similar key / mouse behavior.
				* Closely related auth ID's (registered in close proximity to each other)
				* Similar email endings (people tend to use the same email inboxes)
				* Closely related logins.
				* Javascript enabled / disabled.
				* Timezone of the user.
				* Similarity in pages visited, sites visited, people visited.
				* Superhuman login speed (bots).
				* Illegal character use (bots or hacking).
		*/
		
		/*
			These tables track UniID's and hashes that connect accounts as duplicates.
			
			There are a few types possible:
				* ip_hash			// The IP hash
				* browser_hash		// The md5 hash of the browser configuration
				* pass_hash			// The hash of password matching
				* session_hash		// A session hash that was stored between logins
				* cookie_hash		// A cookie hash that was stored between logins
		*/
		Database::exec("
		CREATE TABLE IF NOT EXISTS `dupe_hash_checks`
		(
			`hashVal`				varchar(32)					NOT NULL	DEFAULT '',
			`type`					varchar(16)					NOT NULL	DEFAULT '',
			`uni_id`				int(10)			unsigned	NOT NULL	DEFAULT '0',
			
			INDEX (`hashVal`, `type`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 PARTITION BY KEY(hashVal) PARTITIONS 61;
		");
		
		Database::exec("
		CREATE TABLE IF NOT EXISTS `dupe_acct_checks`
		(
			`uni_id`				int(10)			unsigned	NOT NULL	DEFAULT '0',
			`type`					varchar(16)					NOT NULL	DEFAULT '',
			`hashVal`				varchar(32)					NOT NULL	DEFAULT '',
			
			INDEX (`uni_id`, `type`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 PARTITION BY KEY(uni_id) PARTITIONS 13;
		");
		
		return $this->isInstalled();
	}
	
	
/****** Check if the plugin was successfully installed ******/
	public static function isInstalled (
	)			// <bool> TRUE if successfully installed, FALSE if not.
	
	// $plugin->isInstalled();
	{
		// Make sure the newly installed tables exist
		$pass = DatabaseAdmin::columnsExist("dupe_hash_checks", array("hashVal", "type", "uni_id"));
		$pass2 = DatabaseAdmin::columnsExist("dupe_acct_checks", array("uni_id", "type", "hashVal"));
		
		return ($pass and $pass2);
	}
	
}