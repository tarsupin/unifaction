<?hh if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

----------------------------
------ About this API ------
----------------------------

This API verifies if the user handle exists on the site.

For example, if you wanted to know whether or not the user "JoeSmith" was registered on a site, you could test it here:
	
	Connect::call($siteURL . "/api/UserRegistered", "JoeSmith");
	
You can also check if a specific UniID is registered by passing the UniID value, like so:

	Connect::call($siteURL . "/api/UserRegistered", $uniID);
	
	
------------------------------
------ Calling this API ------
------------------------------
	
	$response = Connect::call(URL::unifaction_com() . "/api/UserRegistered", $userIDorHandle);
	
	
[ Possible Responses ]
	TRUE		// if the user is found
	FALSE		// if the user wasn't found

*/

class UserRegistered extends API {
	
	
/****** API Variables ******/
	public bool $isPrivate = false;			// <bool> TRUE if this API is private (requires an API Key), FALSE if not.
	public string $encryptType = "";			// <str> The encryption algorithm to use for response, or "" for no encryption.
	public array <int, str> $allowedSites = array();		// <int:str> the sites to allow the API to connect with. Default is all sites.
	public int $minClearance = 6;			// <int> The clearance level required to use this API.
	
	
/****** Run the API ******/
	public function runAPI (
	): bool					// RETURNS <bool> TRUE if the user exists, FALSE if not.
	
	// $this->runAPI()
	{
		// If a UniID was sent
		if(is_numeric($this->data))
		{
			return User::get((int) $this->data) ? true : false;
		}
		
		// If a User Handle was sent
		$uniID = User::getIDByHandle(Sanitize::variable($this->data));
		
		return $uniID ? true : false;
	}
	
}