<?hh if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

<<<<<<< HEAD
// Auth Installation
=======
// Installation
>>>>>>> origin/master
abstract class Install extends Installation {
	
	
/****** Plugin Variables ******/
	
	// These addon plugins will be selected for installation during the "addon" installation process:
	public static array <str, bool> $addonPlugins = array(	// <str:bool>
<<<<<<< HEAD
		"Analytics"			=> true
	,	"Email"				=> true
=======
	//	"Example"			=> true
>>>>>>> origin/master
	);
	
	
/****** App-Specific Installation Processes ******/
	public static function setup(
<<<<<<< HEAD
	): bool					// RETURNS <bool> TRUE on success, FALSE on failure.
=======
	): void					// RETURNS <void>
>>>>>>> origin/master
	
	{
		return true;
	}
}