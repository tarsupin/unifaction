<?hh if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

----------------------------
------ About this API ------
----------------------------

This API helps other sites identify what plugins or code snippets they need to update and then facilitates the process.

For this API to be helpful, the site must send a list of plugins that it has and the versions that it's currently set at.

------------------------------
------ Calling this API ------
------------------------------
	
	// Prepare a list of plugins and their current versions
	$packet = array(
		"Debug"				=> 1.01
	,	"StringUtils"		=> 1.00
	,	"Benchmark"			=> 1.45
	,	"OtherPlugin.."		=> $version
	);
	
	$updateData = Connect::to("unifaction", "AutoUpdateAPI", $packet);
	
	
[ Possible Responses ]
	
	$pluginData = array(
		"PluginName"	=> array("version" => $version, "hash" => $hash, "type" => $type)
	,	"PluginName2"	=> array("version" => $version, "hash" => $hash, "type" => $type)
	,	...
	);

*/

class AutoUpdateAPI extends API {
	
	
/****** API Variables ******/
	public bool $isPrivate = true;			// <bool> TRUE if this API is private (requires an API Key), FALSE if not.
	public string $encryptType = "";			// <str> The encryption algorithm to use for response, or "" for no encryption.
	public array <int, str> $allowedSites = array();		// <int:str> the sites to allow the API to connect with. Default is all sites.
	public int $microCredits = 100;			// <int> The cost in microcredits (1/10000 of a credit) to access this API.
	public int $minClearance = 0;			// <int> The clearance level required to use this API.
	
	
/****** Run the API ******/
	public function runAPI (
	): array <str, mixed>					// RETURNS <str:mixed> user data if they exist, array() if not.
	
	// $this->runAPI()
	{
		// Prepare Values
		$pluginsToUpdate = array();
		
		// Cycle through the list of plugins the site provided
		foreach($this->data as $plugin => $version)
		{
			// Get the plugin configuration class
			if(!$pluginConfig = Plugin::getConfig($plugin))
			{
				continue;
			}
			
			// Make sure the plugin is up to date
			if($pluginConfig->version <= $version)
			{
				continue;
			}
			
			// Prepare the plugin package name
			$packageName = $plugin . "_v" . number_format($version, 2) . ".zip";
			
			// Make sure the plugin package is available
			if(!is_file(CONF_PATH . AutoUpdate::PACKAGE_PLUGINS . "/" . $packageName))
			{
				// The plugin package is not available - attempt to create it
				Zip::package($pluginConfig->data['path'] . "/", CONF_PATH . AutoUpdate::PACKAGE_PLUGINS . "/" . $packageName);
				
				// If the file still doesn't exist, there was an error creating this package
				if(!is_file(CONF_PATH . AutoUpdate::PACKAGE_PLUGINS . "/" . $packageName))
				{
					Alert::error("Package Failure", "Was not able to zip the `" . $plugin . "` package.", 8);
					continue;
				}
			}
			
			// Add this plugin to the list of required updates
			$pluginsToUpdate[$plugin] = array(
				"version" => $pluginConfig->version
			,	"hash" => Security::filehash(CONF_PATH . AutoUpdate::PACKAGE_PLUGINS . "/" . $packageName)
			,	"type" => $pluginConfig->data['type']
			);
		}
		
		return $pluginsToUpdate;
	}
	
}