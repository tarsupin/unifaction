<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

----------------------------
------ About this API ------
----------------------------

This API prepares a SITE HANDLE for registration. Note that this does NOT register any API keys - this registers data that is exclusive to UniFaction (including: `network_info` and `network_registry`). It will confirm the site after the user has logged into UniFaction and accepted responsibility for it.

If the site is already registered, this API returns false.
	
	
------------------------------
------ Calling this API ------
------------------------------

	$packet = array(
		"site-handle"			// <str> The site handle to register.
	,	"uni-handle"			// <str> The UniFaction handle to set as the admin of the site.
	,	"site-name"				// <str> The name of the site to register.
	,	"site-url"				// <str> The URL to register the site with.
	);
	
	$response = Connect::call(URL::unifaction_com() . "/api/RegisterSiteHandle", $packet);
	
	
[ Possible Responses ]
	TRUE		// if the site was reserved successfully, or if you are in ownership of the reservation.
	FALSE		// if the site was already reserved and you're not the owner, or if an error occurred.

*/

class RegisterSiteHandle extends API {
	
	
/****** API Variables ******/
	public $isPrivate = false;			// <bool> TRUE if this API is private (requires an API Key), FALSE if not.
	public $encryptType = "";			// <str> The encryption algorithm to use for response, or "" for no encryption.
	public $allowedSites = array();		// <int:str> the sites to allow the API to connect with. Default is all sites.
	
	
/****** Run the API ******/
	public function runAPI (
	)					// RETURNS <bool> TRUE on success, FALSE on failure.
	
	// $this->runAPI()
	{
		// Tell the user what type of value they sent
		if(isset($this->data['site-handle']) and isset($this->data['uni-handle']) and isset($this->data['site-name']) and isset($this->data['site-url']))
		{
			// Sanitize Values
			$this->data['site-handle'] = Sanitize::variable($this->data['site-handle']);
			$this->data['uni-handle'] = Sanitize::variable($this->data['uni-handle']);
			$this->data['site-name'] = Sanitize::safeword($this->data['site-name']);
			$this->data['site-url'] = Sanitize::url($this->data['site-url']);
			
			// Get the UniID based on the user handle provided
			if(!$userData = User::getDataByHandle($this->data['uni-handle'], "uni_id, clearance"))
			{
				$this->alert = "Unable to locate the user handle provided.";
				return false;
			}
			
			// Make sure the User has appropriate clearance to register this site
			if(strlen($this->data['site-handle']) < 8 and $userData['clearance'] < 6)
			{
				$this->alert = "Your site handle must be at least eight characters in length.";
				return false;
			}
			
			// Prepare the site handle registration
			return AppNetwork::register($this->data['site-handle'], (int) $userData['uni_id'], (int) $userData['clearance'], $this->data['site-name'], $this->data['site-url']);
		}
		
		$this->alert = "The necessary data was not sent to the API.";
		return false;
	}
	
}
