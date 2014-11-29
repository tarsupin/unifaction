<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/*
	We need to track multiple values for logging into an external site:
	
	$_SESSION[SITE_HANDLE]['site_login']
		['site']					// The site var that sent us here
		['handshake']				// The handshake used between the sites (to verify return)
	
	If we're not logged into UniFaction yet, we still need to keep these values, then apply them when we're here.
*/

// Need to retrieve Me::$id early (is normally called during global, but we need it sooner for logging purposes)
if(isset($_SESSION[SITE_HANDLE]['auth-login']['uni_id']))
{
	Me::$id = (int) $_SESSION[SITE_HANDLE]['auth-login']['uni_id'];
}

// Gather data for incoming requests
if(isset($_GET['shk']) && isset($_GET['site']) && isset($_GET['conf']))
{
	// Get the API Key for this setup
	if($key = Network::key($_GET['site']))
	{
		// Make sure the handshake ($_GET['shk']) and confirmation ($_GET['conf']) are valid
		if($_GET['conf'] == Security::hash($_GET['site'] . $_GET['shk'] . $key, 20, 62))
		{
			// Track the login instructions
			$_SESSION[SITE_HANDLE]['site_login'] = array(
				'site'				=>	$_GET['site']
			,	'handshake'			=>	$_GET['shk']
			);
		}
	}
}

// Check if the user has any login instructions from an external site.
// This shouldn't happen unless someone is trying to break the system or when logging into auth's dashboard.
if(!isset($_SESSION[SITE_HANDLE]['site_login']))
{
	header("Location: /login-auth"); exit;
}

// You must be logged into Auth to proceed. If you're not, force the user to log into Auth.
if(!Me::$loggedIn)
{
	// Note that this redirection should include instructions that you're logging into that site.
	header("Location: /login-auth"); exit;
}

// If you've reached this point, you're logged into Auth already.
if(!$getUniAccount = Database::selectOne("SELECT uni_id, handle, clearance, display_name, timezone, email, verified FROM users WHERE uni_id=?", array(Me::$id)))
{
	header("Location: /logout"); exit;
}

// Recognize Integers
$getUniAccount['uni_id'] = (int) $getUniAccount['uni_id'];
$getUniAccount['verified'] = (int) $getUniAccount['verified'];

// If your account isn't verified, you'll have to enter it now
/*
if($getUniAccount['verified'] == 0 and $_SESSION[SITE_HANDLE]['site_login']['site'] != "profile_picture")
{
	Alert::saveError("Not Verified", "You must verify your email, " . $getUniAccount['email'] . ".", 1);
	
	header("Location: /confirm"); exit;
}
*/

// Since we're returning $getUniAccount data to the site, we remove unnecessary values from the array.
unset($getUniAccount['email']);
unset($getUniAccount['verified']);

// Save certain values that we're about to remove from the session
$site = $_SESSION[SITE_HANDLE]['site_login']['site'];
$handshake = $_SESSION[SITE_HANDLE]['site_login']['handshake'];

// Remove unnecessary session values
unset($_SESSION[SITE_HANDLE]['site_login']['site']);

// Get the API Key for this setup
if($siteData = Network::get($site))
{
	// Track this connection to the origin site
	AppTracker::connect($getUniAccount['uni_id'], $site);
	
	// Return the handshake value (prevents reuse of any exchange)
	$getUniAccount['handshake'] = $handshake;
	
	// Drop the entire session for external logins
	unset($_SESSION[SITE_HANDLE]['site_login']);
	
	// Prepare the Encryption
	$enc = Encrypt::run($siteData['site_key'], json_encode($getUniAccount));
	
	// Return to the original page
	header("Location: " . $siteData['site_url'] . "/login?enc=" . rawurlencode($enc)); exit;
}

// Unable to find an appropriate site for login
Alert::saveError("Login Error", "The login system was not able to identify the site in question.");

header("Location: /logout"); exit;