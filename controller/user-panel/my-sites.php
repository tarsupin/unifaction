<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Require Login
if(!Me::$loggedIn)
{
	header("Location: /"); exit;
}

// Attempt to confirm a site that you own
if(isset($_GET['confirm']) and $value = Link::clicked() and $value == "confirm-site")
{
	// Sanitize Data
	$siteHandle = Sanitize::variable($_GET['confirm']);
	
	// Get the site details
	if($siteInfo = AppNetwork::get($siteHandle))
	{
		// Make sure you own the site
		if($siteInfo['uni_id'] == Me::$id)
		{
			// Make sure the site is currently unconfirmed
			if($siteInfo['is_confirmed'] == 0)
			{
				if(AppNetwork::confirmSite($siteInfo['site_handle'], (int) $siteInfo['uni_id']))
				{
					Alert::success("Confirm Site", "You have confirmed the site `" . $siteInfo['site_name'] . "`!");
				}
				else
				{
					Alert::error("Confirm Site", "There was an error trying to confirm this site.");
				}
			}
		}
		else
		{
			Alert::error("Confirm Site", "You don't own this site.", 9);
		}
	}
}

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

echo '
<div id="panel-right"></div>
<div id="content">' . Alert::display();

echo '
<h2>My UniFaction Sites</h2>';

$siteHandles = AppNetwork::getSitesByUniID(Me::$id);

if(count($siteHandles) == 0)
{
	echo '
	<p>You do not have any UniFaction sites. If you would like to create your own UniFaction site, please visit phptesla.com</p>';
}
else
{
	// Cycle through your sites
	foreach($siteHandles as $handle)
	{
		// Get the site info
		$siteInfo = AppNetwork::get($handle['site_handle']);
		
		// Get the owner's info
		$userData = User::get((int) $siteInfo['uni_id'], "handle, display_name");
		
		// Display the Site Info
		echo '
		<h3>' . $siteInfo['site_name'] . '</h3>
		<p>
			URL: ' . $siteInfo['site_url'] . '<br />
			Owner: ' . $userData['display_name'] . ' (@' . $userData['handle'] . ')';
		
		if($siteInfo['is_confirmed'] == 0)
		{
			echo '
			<br /><span style="color:red;">This site has not yet been confirmed.</span>
			<br /><a class="button" href="/user-panel/my-sites?confirm=' . $siteInfo['site_handle'] . "&" . Link::prepare("confirm-site") . '">Confirm ' . $siteInfo['site_name'] . '</a>';
		}
		else
		{
			// Get Site Data
			$siteData = Network::get($handle['site_handle']);
			
			echo '
			<br /><br />UniFaction API Key:
			<br /><textarea name="api-key" style="width:95%; height:80px;">' . $siteData['site_key'] . '</textarea>';
		}
		
		echo '
		</p>';
		
	}
}

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");