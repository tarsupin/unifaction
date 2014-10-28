<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

----------------------------
------ About this API ------
----------------------------

This API returns a list of users that have registered on sites since the date provided. The only site that is allowed to use this API is "unifaction", because UniFaction needs to have this information for friend syncing.

This API will only return up to 10000 entries at once. To make sure you are collecting all of the necessary information, it will also send you the last date provided.

------------------------------
------ Calling this API ------
------------------------------
	
	$packet = array('last_date' => $dateToTrack);
	
	$response = Connect::to("unifaction", "TrackerAPI", $packet);
	
	
[ Possible Responses ]
	{Tracker Data since $dateToTrack (up to 10000 results), and the date of the last entry}

*/

class TrackerAPI extends API {
	
	
/****** API Variables ******/
	public $isPrivate = true;			// <bool> TRUE if this API is private (requires an API Key), FALSE if not.
	public $encryptType = "fast";		// <str> The encryption algorithm to use for response, or "" for no encryption.
	public $allowedSites = array("unifaction");		// <int:str> the sites to allow the API to connect with. Default is all sites.
	
	
/****** Run the API ******/
	public function runAPI (
	)					// RETURNS <int:[int:mixed]> an array of users and the site / connections count.
	
	// $this->runAPI()
	{
		// Make sure you sent the date
		if(!isset($this->data['last_date']))
		{
			return array();
		}
		
		// Prepare Values
		$resultData = array();
		
		// Retrieve the list of users and sites they've joined since the date provided
		$results = Database::selectMultiple("SELECT uni_id, site_handle, total_connections, date_connected FROM account_tracker WHERE date_connected >= ? ORDER BY date_connected ASC LIMIT 10000", array($this->data['last_date']));
		
		foreach($results as $res)
		{
			$resultData[(int) $res['uni_id']][] = array($res['site_handle'], (int) $res['total_connections']);
		}
		
		// Return the last date in the "0" value
		$this->meta['last_date'] = (int) $results[count($results) - 1]['date_connected'];
		
		return $resultData;
	}
	
}
