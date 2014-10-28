<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

-----------------------------------------
------ About the AppTracker Plugin ------
-----------------------------------------

This plugin tracks what sites an account has visited, and handles the site database.


-------------------------------
------ Methods Available ------
-------------------------------

$lastUniID = AppTracker::lastConnection(AuthMe::$id, $siteHandle);
$siteConns = AppTracker::getConnections($uniID);

// Track a site connection (when account connects to it)
AppTracker::connect($uniID, $siteHandle)

*/

abstract class AppTracker {
	
	
/****** Get the last connection to a Site ******/
	public static function lastConnection
	(
		$uniID		// <int> The user's Auth ID.
	,	$siteHandle	// <str> The site handle to identify the site in question.
	)				// RETURNS <int> the last UniID to access the site, 0 on failure.
	
	// $lastUniID = AppTracker::lastConnection($uniID, $siteHandle);
	{
		// This returns the last uni_id that the master account used to log into the site
		return (int) Database::selectOne("SELECT uni_id FROM account_tracker WHERE uni_id=? ORDER BY date_lastLogin DESC LIMIT 1", array($siteHandle, $uniID));
	}
	
	
/****** Get the list of connections that a Uni-Account has made ******/
	public static function getConnections
	(
		$uniID		// <int> The user's UniID.
	)				// RETURNS <int:[str:mixed]> data from sites connected to, array() on failure.
	
	// $siteConns = AppTracker::getConnections($uniID);
	{
		return Database::selectMultiple("SELECT a.site_handle, a.date_lastLogin, s.site_name, s.site_url FROM account_tracker a LEFT JOIN network_data s ON a.site_handle = s.site_handle WHERE a.uni_id=? ORDER BY a.date_lastLogin DESC", array($uniID));
	}
	
	
/****** Connect to a Site ******/
	public static function connect
	(
		$uniID		// <int> The Uni-Account that we're tracking.
	,	$siteHandle	// <str> The site var to identify the site.
	)				// RETURNS <bool> TRUE on success, FALSE on failure.
	
	// AppTracker::connect($uniID, $siteHandle);
	{
		$timestamp = time();
		
		// Check if the tracker exists already
		if($lastLogin = (int) Database::selectOne("SELECT date_lastLogin FROM account_tracker WHERE uni_id=? AND site_handle=? LIMIT 1", array($uniID, $siteHandle)))
		{
			return Database::query("UPDATE account_tracker SET " . ($lastLogin < $timestamp - (3600 * 3) ? 'total_connections=total_connections+1,' : '') . " date_lastLogin=? WHERE uni_id=? AND site_handle=? LIMIT 1", array($timestamp, $uniID, $siteHandle));
		}
		
		return Database::query("INSERT INTO account_tracker (uni_id, site_handle, total_connections, date_connected, date_lastLogin) VALUES (?, ?, ?, ?, ?)", array($uniID, $siteHandle, 1, $timestamp, $timestamp));
	}
}
