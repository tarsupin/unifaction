<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

----------------------------
------ About this API ------
----------------------------

This API retrieves public site information about a site that is registered to Auth.
	
------------------------------
------ Calling this API ------
------------------------------
	
	Connect::to("unifaction", "GetSiteInfo", $siteHandle);
	
	
[ Possible Responses ]
	{Data of the site} if the site was loaded.
	FALSE if the site wasn't connected to UniFaction.

*/

class GetSiteInfo extends API {
	
	
/****** API Variables ******/
	public $isPrivate = true;			// <bool> TRUE if this API is private (requires an API Key), FALSE if not.
	public $encryptType = "";			// <str> The encryption algorithm to use for response, or "" for no encryption.
	public $allowedSites = array();		// <int:str> the sites to allow the API to connect with. Default is all sites.
	public $microCredits = 20;			// <int> The cost in microcredits (1/10000 of a credit) to access this API.
	public $minClearance = 0;			// <int> The minimum clearance level required to use this API.
	
	
/****** Run the API ******/
	public function runAPI (
	)					// RETURNS <str:str> site info on success, array() on failure.
	
	// $this->runAPI()
	{
		// Make sure Auth has a connection to the recipient site
		if($siteData = Network::get(Sanitize::variable($this->data)))
		{
			return array(
				"site_handle"		=> $this->data
			,	"site_name"			=> $siteData['site_name']
			,	"site_clearance"	=> $siteData['site_clearance']
			,	"site_url"			=> $siteData['site_url']
			);
		}
		
		$this->alert = "The site wasn't registered with UniFaction.";
		return array();
	}
	
}
