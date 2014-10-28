<<<<<<< HEAD
<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/*
	We need to track multiple values for logging into an external site:
	
	$_SESSION[SITE_HANDLE]['site_login']
		['site']					// The site var that sent us here
		['return-to-url']			// The page to redirect to on success
		['handshake']				// The handshake used between the sites (to verify return)
		['action']					// The type of login (soft, switch, etc)
		['mode']					// The mode of login (recommend 1 profile, standard, etc)
	
	If we're not logged into auth yet, we still need to keep these values, then apply them when we're here.
*/

// Need to retrieve Me::$id early (is normally called during global, but we need it sooner for logging purposes)
if(isset($_SESSION[SITE_HANDLE]['uni_id']))
{
	Me::$id = (int) $_SESSION[SITE_HANDLE]['uni_id'];
}

// Gather data for incoming requests
if(isset($_GET['ret']) && isset($_GET['shk']) && isset($_GET['site']) && isset($_GET['conf']))
{
	// Get the API Key for this setup
	if($key = Network::key($_GET['site']))
	{
		// Make sure the handshake ($_GET['shk']) and confirmation ($_GET['conf']) are valid
		if($_GET['conf'] == Security::hash($_GET['site'] . $_GET['shk'] . $key, 20, 62))
		{
			// Prepare Values
			$_GET['logMode'] = isset($_GET['logMode']) ? $_GET['logMode'] : '';
			$_GET['logAct'] = isset($_GET['logAct']) ? $_GET['logAct'] : '';
			
			// Track the login instructions
			$_SESSION[SITE_HANDLE]['site_login'] = array(
			
				'site'				=>	$_GET['site']
			,	'return-to-url'		=>	$_GET['ret']
			,	'handshake'			=>	$_GET['shk']
			
			,	'action'			=> (in_array($_GET['logAct'], array("soft", "switch")) ? $_GET['logAct'] : "standard")
			,	'mode'				=> (in_array($_GET['logMode'], array("1rec")) ? $_GET['logMode'] : "standard")
			
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
if($getUniAccount['verified'] == 0 and $_SESSION[SITE_HANDLE]['site_login']['site'] != "profile_picture")
{
	Alert::saveError("Not Verified", "You must verify your email, " . $getUniAccount['email'] . ".", 1);
	
	header("Location: /user-panel/resend-verification"); exit;
}

// Since we're returning $getUniAccount data to the site, we remove unnecessary values from the array.
unset($getUniAccount['email']);
unset($getUniAccount['verified']);

// Save certain values that we're about to remove from the session
$returnTo = $_SESSION[SITE_HANDLE]['site_login']['return-to-url'];
$site = $_SESSION[SITE_HANDLE]['site_login']['site'];

// Remove unecessary session values
unset($_SESSION[SITE_HANDLE]['site_login']['return-to-url']);
unset($_SESSION[SITE_HANDLE]['site_login']['site']);
unset($_SESSION[SITE_HANDLE]['site_login']['mode']);

// Get the API Key for this setup
if($key = Network::key($site))
{
	// Track this connection to the origin site
	AppTracker::connect($getUniAccount['uni_id'], $site);
	
	// Return the handshake value (prevents reuse of any exchange)
	$getUniAccount['handshake'] = $_SESSION[SITE_HANDLE]['site_login']['handshake'];
	
	// Drop the entire session for external logins
	unset($_SESSION[SITE_HANDLE]['site_login']);
	
	// Prepare the Encryption
	$enc = Encrypt::run($key, json_encode($getUniAccount));
	
	// Return to the original page
	header("Location: " . $returnTo . "?enc=" . rawurlencode($enc)); exit;
}

// Unable to find an appropriate site for login
Alert::saveError("Login Error", "The login system was not able to identify the site in question.");

header("Location: /logout"); exit;
=======
<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); } 

// Provide custom login details
// $loginResponse is provided here, which includes Auth's auth_id if this site requires it
/*
function custom_login($loginResponse)
{
	
}
*/

// Run the universal login script
require(SYS_PATH . "/controller/login.php");

// Return Home
header("Location: /");
>>>>>>> origin/master
