<?hh if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

----------------------------
------ About this API ------
----------------------------

This API will authenticate and synchronize sites for the local development control panel.


------------------------------
------ Calling this API ------
------------------------------
	
	// Prepare the packet to generate a key
	$packet = array(
		"site"		=> $siteHandle
	,	"env"		=> $environment
	);
	
	// Run the API
	$response = Connect::to("unifaction", "LocalNetSync", $packet);
	
	
[ Possible Responses ]
	{RESPONSE}

*/

class LocalNetSync extends API {
	
	
/****** API Variables ******/
	public bool $isPrivate = true;			// <bool> TRUE if this API is private (requires an API Key), FALSE if not.
	public string $encryptType = "default";	// <str> The encryption algorithm to use for response, or "" for no encryption.
	public array <int, str> $allowedSites = array("syspanel");		// <int:str> the sites to allow the API to connect with. Default is all sites.
	public int $microCredits = 15000;		// <int> The cost in microcredits (1/10000 of a credit) to access this API.
	public int $minClearance = 8;			// <int> The minimum clearance level required to use this API.
	
	
/****** Run the API ******/
	public function runAPI (
	): array					// RETURNS <array> generated key and other data about the site; array() on failure.
	
	// $this->runAPI()
	{
		// Process the API & Call Data
		if(!isset($this->data["site"]) or !isset($this->data["env"]))
		{
			$this->alert = "The proper information was not provided.";
			return array();
		}
		
		// Get the site data of both sites; if the sites aren't both connected with Auth, no change will occur
		if($siteData = Network::get($this->data["site"]))
		{
			// Prepare Values
			$key = Security::randHash(mt_rand(96, 100), 72);
			
			// Prepare the API packet for the site being updated
			$packet = array(
				"handle"		=> "syspanel"
			,	"name"			=> "UniFaction SysPanel"
			,	"url"			=> ""
			,	"clearance"		=> 8
			,	"key"			=> $key
			);
			
			if($this->data["env"] == "local")
			{
				$packet['url'] = "http://syspanel.test";
			}
			
			// Run the API
			if($response = Connect::call($siteData['site_url'] . "/api/AuthSync", $packet, $siteData['site_key']))
			{
				return array(
					"key"		=> $key
				,	"url"		=> $siteData['site_url']
				,	"name"		=> $siteData['site_name']
				);
			}
			
			$this->alert = "There was an error trying to connect with this sync value.";
			return array();
		}
		
		$this->alert = "That site doesn't have a registered connection to UniFaction.";
		return array();
	}
	
}