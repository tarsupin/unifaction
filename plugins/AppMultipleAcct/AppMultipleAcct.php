<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

----------------------------------------------
------ About the AppMultipleAcct Plugin ------
----------------------------------------------

This plugin handles essential functionality for the core UniFaction handles for Auth.


-------------------------------
------ Methods Available ------
-------------------------------

// Grant a multi-account access to a user
AppMultipleAcct::create($uniID, $uniIDGranted);

// Remove a multi-account access to a user
AppMultipleAcct::delete($uniID, $uniIDRemoved);

*/

abstract class AppMultipleAcct {
	
	
/****** Check if a user has access to a specific account ******/
	public static function hasAccess
	(
		$uniID			// <int> The UniID to check if they have access.
	,	$accessID		// <int> The UniID that is being tested for access.
	)					// RETURNS <bool> TRUE if the user has access, FALSE if not.
	
	// AppMultipleAcct::hasAccess($uniID, $accessID);
	{
		if($check = Database::selectValue("SELECT uni_id FROM users_multi_accounts WHERE uni_id=? AND access_to_id=? LIMIT 1", array($uniID, $accessID)))
		{
			return true;
		}
		
		return false;
	}
	
	
/****** Retrieve a list of accounts that a user has access to ******/
	public static function getAccessList
	(
		$uniID			// <int> The UniID to find multiple access accounts of.
	)					// RETURNS <int:[str:mixed]> a list of accounts that the user has access to.
	
	// $accessList = AppMultipleAcct::getAccessList($uniID);
	{
		return Database::selectMultiple("SELECT a.access_to_id, u.handle FROM users_multi_accounts a INNER JOIN users u ON a.access_to_id=u.uni_id WHERE a.uni_id=?", array($uniID));
	}
	
	
/****** Retrieve a list of accounts that a user has granted to other accounts ******/
	public static function getGrantedList
	(
		$uniID			// <int> The UniID to find multiple access accounts of.
	)					// RETURNS <int:[str:mixed]> a list of accounts that the user has granted access to.
	
	// $grantedList = AppMultipleAcct::getGrantedList($uniID);
	{
		return Database::selectMultiple("SELECT g.granted_to_id, u.handle FROM users_multi_accounts_granted g INNER JOIN users u ON g.granted_to_id=u.uni_id WHERE g.uni_id=?", array($uniID));
	}
	
	
/****** Grant access to an account ******/
	public static function create
	(
		$uniID			// <int> The UniID that is receiving access to another account.
	,	$uniIDGranted	// <int> The UniID being granted to the target account.
	)					// RETURNS <bool> TRUE on success, FALSE on failure.
	
	// AppMultipleAcct::create($uniID, $uniIDGranted);
	{
		Database::startTransaction();
		
		if($pass = Database::query("INSERT INTO users_multi_accounts (uni_id, access_to_id) VALUES (?, ?)", array($uniID, $uniIDGranted)))
		{
			$pass = Database::query("INSERT INTO users_multi_accounts_granted (uni_id, granted_to_id) VALUES (?, ?)", array($uniIDGranted, $uniID));
		}
		
		return Database::endTransaction($pass);
	}
	
	
/****** Remove access from an account ******/
	public static function delete
	(
		$uniID			// <int> The UniID that is losing access to another account.
	,	$uniIDRemoved	// <int> The UniID being stripped from the target account.
	)					// RETURNS <bool> TRUE on success, FALSE on failure.
	
	// AppMultipleAcct::delete($uniID, $uniIDRemoved);
	{
		Database::startTransaction();
		
		if($pass = Database::query("DELETE FROM users_multi_accounts WHERE uni_id=? AND access_to_id=? LIMIT 1", array($uniID, $uniIDRemoved)))
		{
			$pass = Database::query("DELETE FROM users_multi_accounts_granted WHERE uni_id=? AND granted_to_id=? LIMIT 1", array($uniIDRemoved, $uniID));
		}
		
		return Database::endTransaction($pass);
	}
	
}
