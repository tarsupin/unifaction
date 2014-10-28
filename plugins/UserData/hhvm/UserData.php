<?hh if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

----------------------------
------ About this API ------
----------------------------

This returns user data on a specific user, identified with their handle or their uni_id.
	
	
------------------------------
------ Calling this API ------
------------------------------
	
	$packet = array(
		'user'			// The user's handle or uni_id
	,	'columns'		// The columns to retrieve from the user
	);
	
	Connect::to("unifaction", "/user-data", $packet, true, true);
	
	
[ Possible Responses ]
	TRUE		// if the user is found
	FALSE		// if the user wasn't found

*/

class UserData extends API {
	
	
/****** API Variables ******/
	public bool $isPrivate = true;			// <bool> TRUE if this API is private (requires an API Key), FALSE if not.
	public string $encryptType = "default";	// <str> The encryption algorithm to use for response, or "" for no encryption.
	public array <int, str> $allowedSites = array();		// <int:str> the sites to allow the API to connect with. Default is all sites.
	public int $minClearance = 6;			// <int> The clearance level required to use this API.
	
	
/****** Run the API ******/
	public function runAPI (
	): array <str, mixed>					// RETURNS <str:mixed> user data if they exist, array() if not.
	
	// $this->runAPI()
	{
		if(!isset($this->data['user']) or !isset($this->data['columns']))
		{
			return array();
		}
		
		// Get the Data by UniID
		if(is_numeric($this->data['user']))
		{
			if($userData = User::get((int) $this->data['user'], $this->data['columns']))
			{
				return $userData;
			}
		}
		
		// Get the Data by Handle
		return User::getDataByHandle($this->data['user'], $this->data['columns']);
	}
	
}