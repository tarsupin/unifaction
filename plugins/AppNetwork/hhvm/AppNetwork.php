<?hh if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

-----------------------------------------
------ About the AppNetwork Plugin ------
-----------------------------------------

This class provides extra details about each site on the network, such as information that can assist with targeting audiences and search engine results. Additionally, if someone's API key gets stolen, this will allow us to track down the person who officially owns the key.


-------------------------------
------ Methods Available ------
-------------------------------

$siteInfo = AppNetwork::get($siteHandle, [$columns]);

AppNetwork::set($siteHandle, $category, $subcategory, $description, $keywords, $contactName, $contactPhone, $locCountry, $locState, $locCity, $locZipcode);

AppNetwork::siteHandleTaken($siteHandle);

$uniID = AppNetwork::siteUniID($siteHandle);

*/

abstract class AppNetwork {
	
	
/****** Get Network Info ******/
	public static function get
	(
		string $siteHandle			// <str> The site handle to get network information about.
	,	string $columns = "*"		// <str> The columns to retrieve.
	): array <str, str>						// RETURNS <str:str> data about the site, empty array if nothing is present.
	
	// $siteInfo = AppNetwork::get($siteHandle, [$columns]);
	{
		return Database::selectOne("SELECT " . Sanitize::variable($columns, " ,*`") . " FROM network_info WHERE site_handle=? LIMIT 1", array($siteHandle));
	}
	
	
/****** Get a list of sites owned by a particular UniID ******/
	public static function getSitesByUniID
	(
		int $uniID		// <int> The UniID to get a list of sites of.
	): array <int, array<str, str>>				// RETURNS <int:[str:str]> list of site handles owned (or being registered) by the UniID.
	
	// $siteHandles = AppNetwork::getSitesByUniID($uniID);
	{
		return Database::selectMultiple("SELECT site_handle FROM network_registry WHERE uni_id=?", array($uniID));
	}
	
	
/****** Register a site ******/
	public static function register
	(
		string $siteHandle			// <str> The site handle to set the network information for.
	,	int $uniID				// <int> The UniID that is being registered with this site.
	,	int $clearance			// <int> The level of clearance to register with the site.
	,	string $siteName			// <str> The name of the site being registered.
	,	string $siteURL			// <str> The url that the site is being registered to.
	): bool						// RETURNS <bool> TRUE if registered properly, FALSE otherwise.
	
	// AppNetwork::register($siteHandle, $uniID, $clearance, $siteName, $siteURL);
	{
		// Check if the site has already been registered
		if($siteInfo = self::get($siteHandle))
		{
			// If the site hasn't been registered to the user in question, return false
			if($siteInfo['uni_id'] != $uniID)
			{
				return false;
			}
			
			return true;
		}
		
		// Register the Site
		Database::startTransaction();
		
		if($pass = Database::query("INSERT IGNORE INTO network_info (site_handle, uni_id, clearance, date_created, site_name, site_url) VALUES (?, ?, ?, ?, ?, ?)", array($siteHandle, $uniID, $clearance, time(), $siteName, $siteURL)))
		{
			$pass = Database::query("INSERT IGNORE INTO network_registry (uni_id, site_handle) VALUES (?, ?)", array($uniID, $siteHandle));
		}
		
		return Database::endTransaction($pass);
	}
	
	
/****** Confirm a site ******/
	public static function confirmSite
	(
		string $siteHandle			// <str> The site handle to confirm.
	,	int $uniID				// <int> The UniID that is confirming the site.
	): bool						// RETURNS <bool> TRUE if confirmed properly, FALSE otherwise.
	
	// AppNetwork::confirmSite($siteHandle, $uniID);
	{
		// Get the Site Info
		if(!$siteInfo = self::get($siteHandle))
		{
			return false;
		}
		
		$siteInfo['clearance'] = (int) $siteInfo['clearance'];
		
		// Run the confirmation
		Database::startTransaction();
		
		if($pass = Network::setData($siteInfo['site_handle'], $siteInfo['site_name'], $siteInfo['site_url'], "", false))
		{
			if($pass = Database::query("UPDATE network_info SET is_confirmed=? WHERE site_handle=? AND uni_id=? LIMIT 1", array(1, $siteHandle, $uniID)))
			{
				// Update the clearance of the site, if the user has clearance on Auth
				if($siteInfo['clearance'] > 0)
				{
					$pass = Network::setClearance($siteHandle, min(8, $siteInfo['clearance']));
				}
			}
		}
		
		return Database::endTransaction($pass);
	}
	
	
/****** Set Network Info ******/
	public static function set
	(
		string $siteHandle			// <str> The site handle to set the network information for.
	,	string $category = ""		// <str> The category to associate with the site.
	,	string $subcategory = ""	// <str> The subcategory to associate with the site.
	,	string $description = ""	// <str> The description of the site.
	,	string $keywords = ""		// <str> Keywords (separated by commas) to associate with the site.
	,	string $contactName = ""	// <str> The name of the contact of this site.
	,	string $contactPhone = ""	// <str> The phone number associated with the site.
	,	string $locCountry = ""	// <str> The country that this site is associated with.
	,	string $locState = ""		// <str> The state or province that this site is associated with.
	,	string $locCity = ""		// <str> The city that this site is associated with or located at.
	,	string $locZipcode = ""	// <str> The zipcode that this site is associated with and/or located in.
	): bool						// RETURNS <bool> TRUE if updated, FALSE otherwise.
	
	// AppNetwork::set($siteHandle, $category, $subcategory, $description, $keywords, $contactName, $contactPhone, $locCountry, $locState, $locCity, $locZipcode);
	{
		// This method needs to be rebuilt with: AuthID, UniID, and Clearance if it's going to be used.
		// Should probably only update, since otherwise it shouldn't exist at all.
		
		// This comment added on 7/6/2014, so keep that in mind for if/when we need to delete it.
		
		return false;
		return Database::query("REPLACE INTO network_info (site_handle, category, subcategory, description, keywords, contact_name, contact_phone, loc_country, loc_state, loc_city, loc_zipcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($siteHandle, $category, $subcategory, $description, $keywords, $contactName, $contactPhone, $locCountry, $locState, $locCity, $locZipcode));
	}
	
	
/****** Check if a site handle has already been taken ******/
	public static function siteHandleTaken
	(
		string $siteHandle			// <str> The site handle to check is available or not.
	): bool						// RETURNS <bool> TRUE if updated, FALSE otherwise.
	
	// AppNetwork::siteHandleTaken($siteHandle);
	{
		if(Database::selectValue("SELECT site_handle FROM network_data WHERE site_handle=? LIMIT 1", array($siteHandle)))
		{
			return true;
		}
		
		return false;
	}
	
	
/****** Get the UniID that owns a site ******/
	public static function siteUniID
	(
		string $siteHandle			// <str> The site handle to check for the owner.
	): int						// RETURNS <int> the UniID of the owner, or 0 if no owner was found.
	
	// $uniID = AppNetwork::siteUniID($siteHandle);
	{
		$uniID = (int) Database::selectValue("SELECT uni_id FROM network_info WHERE site_handle=? LIMIT 1", array($siteHandle));
		
		return $uniID !== false ? $uniID : 0;
	}
	
}
