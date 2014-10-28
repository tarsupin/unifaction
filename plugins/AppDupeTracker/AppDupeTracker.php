<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

--------------------------------------------
------ About the AppDupeTracker Class ------
--------------------------------------------

This plugin is only used during Auth logins or in special instances (such as bots that accessed any honeypots). It is used to determine duplicate accounts and bots.


-------------------------------
------ Methods Available ------
-------------------------------

AppDupeTracker::runDupeTracker($authID, $passHash);
AppDupeTracker::setDupe($type, $hash, $authID);

$passHash = AppDupeTracker::passHash($password);
AppDupeTracker::genDupeTracks();

*/

abstract class AppDupeTracker {
	
	
/****** Find duplicate accounts ******/
	public static function findDupes
	(
		$uniID		// <int> The UniID of the user we're finding duplicate accounts of.
	)				// RETURNS <array> list of accounts and their dupe proximity.
	
	// $dupeAccounts = AppDupeTracker::findDupes($uniID);
	{
		return array();
	}
	
	
/****** Run the duplication tracker ******/
	public static function runDupeTracker
	(
		$uniID			// <int> The UniID of the user we're testing.
	,	$passHash		// <str> The password hash to dupe check.
	)					// RETURNS <void>
	
	// AppDupeTracker::runDupeTracker($uniID, $passHash);
	{
		$ipHash = md5($_SERVER['REMOTE_ADDR']);
		$browserHash = md5($_SERVER['HTTP_USER_AGENT']);
		
		self::setDupe("ip_hash", $ipHash, $uniID);
		self::setDupe("browser_hash", $browserHash, $uniID);
		self::setDupe("pass_hash", $passHash, $uniID);
		
		// Run the Session Dupe Tracker, if applicable
		if(isset($_SESSION[SITE_HANDLE]['dCSRF']))
		{
			$sessionHash = $_SESSION[SITE_HANDLE]['dCSRF'];
			self::setDupe("session_hash", $sessionHash, $uniID);
		}
		
		// Run the Cookie Dupe Tracker, if applicable
		if(isset($_COOKIE['dCSRF']))
		{
			$cookieHash = $_COOKIE["dCSRF"];
			self::setDupe("cookie_hash", $cookieHash, $uniID);
		}
	}
	
	
/****** Check if there any replicated dupe hashes ******/
	public static function setDupe
	(
		$type		// <str> The type of hash to check for.
	,	$hash		// <str> The hash to match.
	,	$uniID		// <int> The uniID that's being matched.
	)				// RETURNS <bool> TRUE if there was duplicate behavior, FALSE if not.
	
	// AppDupeTracker::setDupe($type, $hash, $uniID);
	{
		if($matchID = (int) Database::selectValue("SELECT uni_id FROM dupe_hash_checks WHERE hashVal=? AND type=? AND uni_id != ? LIMIT 1", array($hash, $type, $uniID)))
		{
			Database::startTransaction();
			
			$pass = Database::query("INSERT INTO dupe_acct_checks (uni_id, type, hashVal) VALUES (?, ?, ?)", array($uniID, $type, $hash));
			
			if(!$check = (int) Database::selectValue("SELECT uni_id FROM dupe_acct_checks WHERE uni_id=? AND type=? AND hashVal=? LIMIT 1", array($matchID, $type, $hash)))
			{
				$pass = Database::query("INSERT INTO dupe_acct_checks (uni_id, type, hashval) VALUES (?, ?, ?)", array($matchID, $type, $hash));
			}
			
			Database::endTransaction($pass);
			
			return true;
		}
		
		return false;
	}
	
	
/****** Do a passhash for duplicate account matching ******/
# Note: just because this is for reference matching doesn't mean it doesn't have to be secure. The reason we're running
# this through a heavy encryption algorithm is because it still has to eliminiate collisions (just in case). Do not
# weaken this algorithm for any reason. It's also algorithmically slow for a reason.
	public static function passHash
	(
		$password		// <str> The password to reference hash for dupe matching.
	)					// RETURNS <str> the pass hash, "" on failure.
	
	// $passHash = AppDupeTracker::passHash($password);
	{
		// Prepare Values
		$val1 = "";
		$val2 = "";
		$salt = SITE_SALT . 'VjdD*92';
		
		// I know this could be programmed to be faster, but it would involve a custom padding solution.
		// The number of potential combinations exceeds 1^e57, and each hash needs 20 checks.
		for($a = 0;$a < 21;$a++)
		{
			$val1 = Security::hash($password . $salt . $a, 38, 62);
			$val2 = Security::pad($val1, $val2, 62);
		}
		
		return substr($val2, 4, 32);
	}
	
	
/****** Create duplication tracks (session and cookie) ******/
	public static function genDupeTracks (
	)			// RETURNS <void>
	
	// AppDupeTracker::genDupeTracks();
	{
		// Set a dupe-tracking session hash
		if(!isset($_SESSION[SITE_HANDLE]['dCSRF']))
		{
			$_SESSION[SITE_HANDLE]['dCSRF'] = Time::unique() . substr(microtime(), 2, 5) . Security::randHash(22, 62);
		}
		
		// Set a dupe-tracking cookie hash
		if(!isset($_COOKIE["dCSRF"]))
		{
			$val = Security::randHash(32, 62);
			
			$_COOKIE['dCSRF'] = $val;
			
			setcookie("dCSRF", $val, time() + (3600 * 365), "/", $_SERVER['SERVER_NAME']);
		}
	}
	
}


