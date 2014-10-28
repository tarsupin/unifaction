<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

----------------------------
------ About this API ------
----------------------------

This API will authenticate and synchronize sites together. This is used primarily during installation when the site 	being installed need to establish it's connections to other sites. However, it can also be used to update site information and keys automatically. After this API is run successfully, both affected sites should be able to communicate with each other properly using the standard UniFaction APIs.
	
	There are two ways to use this API.
		1. The SOURCE site tells the DESTINATION site to update itself.
		2. The SOURCE site tells UniFaction to update BOTH the SOURCE and the DESTINATION.
	
	The shared key between SOURCE and DESTINATION will be affected in the following ways:
		1. If the SOURCE provides a shared key, DESTINATION will sync to the key that SOURCE provides.
		2. If the SOURCE does not provide a key, BOTH sites will get a new key if sync_both is set to TRUE
			* Otherwise, neither site will have their key updated.
	
------------------------------
------ Calling this API ------
------------------------------
	
	$packet = array(
		"site_handle"	=> $siteHandle		// The site handle for the DESTINATION site
	,	"shared_key"	=> $sharedKey		// The shared key to apply
	,	"sync_both"		=> true				// [optional] If TRUE, sync both sites - not just the destination
	);
	
	Connect::call("unifaction", "NetworkSync", $packet);
	
	
[ Possible Responses ]
	TRUE if the site(s) were properly synchronized according to the instructions.
	FALSE if the expected synchronizations did not occur.

*/

class NetworkSync extends API {
	
	
/****** API Variables ******/
	public $isPrivate = true;			// <bool> TRUE if this API is private (requires an API Key), FALSE if not.
	public $encryptType = "";			// <str> The encryption algorithm to use for response, or "" for no encryption.
	public $allowedSites = array();		// <int:str> the sites to allow the API to connect with. Default is all sites.
	public $microCredits = 120;			// <int> The cost in microcredits (1/10000 of a credit) to access this API.
	public $minClearance = 0;			// <int> The minimum clearance level required to use this API.
	
	
/****** Run the API ******/
	public function runAPI (
	)					// RETURNS <bool> TRUE on success, FALSE on failure.
	
	// $this->runAPI()
	{
		// Process the API & Call Data
		if(isset($this->data["site_handle"]) and isset($this->data["shared_key"]))
		{
			// Get the site data of both sites; if the sites aren't both connected with Auth, no change will occur
			if($site1Data = Network::get($_GET['site']) and $site2Data = Network::get($this->data["site_handle"]))
			{
				// Prepare Values
				$success1 = true;
				$this->data['sync_both'] = !isset($this->data['sync_both']) ? false : $this->data['sync_both'];
				
				// If syncing both sites, update the SOURCE site
				if($this->data['sync_both'] == true)
				{
					// Prepare the API packet for SOURCE
					$packet = array(
						"handle"		=> $this->data["site_handle"]
					,	"name"			=> $site2Data["site_name"]
					,	"url"			=> $site2Data["site_url"]
					,	"clearance"		=> $site2Data["site_clearance"]
					,	"key"			=> $this->data['shared_key']
					);
					
					// Run the SOURCE API
					$success1 = Connect::call($site1Data['site_url'] . "/api/AuthSync", $packet, $site1Data['site_key']);
				}
				
				// Prepare the API packet for DESTINATION
				$packet = array(
					"handle"		=> $_GET['site']
				,	"name"			=> $site1Data['site_name']
				,	"url"			=> $site1Data["site_url"]
				,	"clearance"		=> $site1Data["site_clearance"]
				,	"key"			=> $this->data['shared_key']
				);
				
				// Update the DESTINATION site
				$success2 = Connect::call($site2Data['site_url'] . "/api/AuthSync", $packet, $site2Data['site_key']);
				
				// Return if successful
				return ($success1 and $success2) ? true : false;
			}
			
			$this->alert = "That site doesn't have a registered connection to UniFaction.";
			return false;
		}
		
		$this->alert = "The proper information was not provided.";
		return false;
	}
	
}
