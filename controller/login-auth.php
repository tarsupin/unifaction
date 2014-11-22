<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/*
	We need to track multiple values for logging into the dashboard:
	
	$_SESSION[SITE_HANDLE]['auth-login']		// Stores essential data for second authentication
		['uni_id']
		['password']		// TRUE if the password was successful, FALSE if not
		['answer']
		['step']
*/

// Unset any invalid auth-logins
if(isset($_SESSION[SITE_HANDLE]['auth-login']) and !$_SESSION[SITE_HANDLE]['auth-login']['uni_id'])
{
	unset($_SESSION[SITE_HANDLE]['auth-login']);
}

/****** Form Submission ******/
// This section requires some complexity. Some users will have secondary authentication, which means that we need to
// track that authentication between multiple pages. We do this with $_SESSION[SITE_HANDLE]['auth-login']. This stores
// whether or not the user has correctly answered the password and the security question.
// 
// On some page loads, we are not actually submitting the form, since we're returning from the other security page.
// We also need to know if the credentials failed and we need to retry.
if(Form::submitted("auth-login-uni") or isset($_SESSION[SITE_HANDLE]['auth-login']))
{
	// Gather user data and password after a security credential check from another page
	if(isset($_SESSION[SITE_HANDLE]['auth-login']))
	{
		if($userData = Database::selectOne("SELECT uni_id, handle, password FROM users WHERE uni_id=? LIMIT 1", array($_SESSION[SITE_HANDLE]['auth-login']['uni_id'])))
		{
			$_POST['handle'] = $userData['handle'];
			
			$success = $_SESSION[SITE_HANDLE]['auth-login']['password'];
		}
	}
	
	// Gather user data and password from submission
	else
	{
		$userData = Database::selectOne("SELECT uni_id, handle, password FROM users WHERE handle=? LIMIT 1", array($_POST['handle']));
	}
	
	// Make sure the user is located
	if($userData)
	{
		// Recognize Integers
		$userData['uni_id'] = $userData ? (int) $userData['uni_id'] : 0;
		
		// Check if the password was successful
		if(isset($_POST['password']))
		{
			// Check if the user's password was successful
			if(!$success = Security::getPassword($_POST['password'], (isset($userData['password']) ? $userData['password'] : "")))
			{
				AppLoginSec::loginFailure($userData['uni_id']);		// Password failed. Track it.
			}
			
			if(isset($_SESSION[SITE_HANDLE]['auth-login']))
			{
				$_SESSION[SITE_HANDLE]['auth-login']['password'] = $success;
			}
		}
		
		// Check if logins are restricted right now due to multiple failures over the last 10 minutes.
		$failedLogins = AppLoginSec::failedLogins($userData['uni_id']);
		
		// Check if the user has secondary authentication
		$hasSecAuth = AppLoginSec::hasSecondAuth($userData['uni_id']);
		
		// Check if the user has any special login protection
		if($userData && $hasSecAuth && $failedLogins < 15)
		{
			// Track the login for security authentication if we haven't yet
			if(!isset($_SESSION[SITE_HANDLE]['auth-login']))
			{
				$_SESSION[SITE_HANDLE]['auth-login'] = array(
					"password"	=>	$success
				,	"uni_id"	=>	$userData['uni_id']
				,	"answer"	=>	false
				,	"step"		=>	"login"
				);
			}
			
			// Don't allow the login to pass if we haven't answered the security question correctly
			if($_SESSION[SITE_HANDLE]['auth-login']['answer'] == false)
			{
				$success = false;
			}
			
			// Switch to the next login type
			switch($_SESSION[SITE_HANDLE]['auth-login']['step'])
			{
				case "login":
					if($success == false)
					{
						$_SESSION[SITE_HANDLE]['auth-login']['step'] = "security-question";
						header("Location: /login-auth/security-question"); exit;
					}
				break;
				
				case "security-question":
					$_SESSION[SITE_HANDLE]['auth-login']['step'] = "login";
				break;
			}
		}
		
		// If the user has more than 15 password failures in the last 10 minutes, restrict login access
		if($failedLogins >= 15)
		{
			Alert::error("Too Many Logins", "Too many failed logins in the last 10 minutes. Please try again later.", 5);
		}
		else if(!$success or !$userData)
		{
			Alert::error("Password", "Your username or your security credentials are invalid.", 2);
		}
	}
	else
	{
		Alert::error("Invalid User", "That user was not found in our system.");
	}
	
	// Now check if the form has passed
	if(FormValidate::pass())
	{
		unset($_SESSION[SITE_HANDLE]['auth-login']);
		
		// You've logged in
		Me::login($userData['uni_id'], true);
	}
}

// If you're logged in
if(Me::$loggedIn)
{
	// Occasionally grant a new invite to the user
	if($inviteCheck = AppAccount::newInviteCheck(Me::$id))
	{
		AppAccount::createInvitationCode(Me::$id, 1);
	}
	
	// If the user is supposed to redirect to an external site, return to the external login page.
	if(isset($_SESSION[SITE_HANDLE]['site_login']))
	{
		header("Location: /login"); exit;
	}
	
	// Check if the user should be adding second authentication
	if(isset($hasSecAuth) && $hasSecAuth == false)
	{
		$joinDate = (int) Database::selectValue("SELECT date_joined FROM users WHERE uni_id=? LIMIT 1", array(Me::$id));
		
		// If the user has visited this site for three days, request second authentication
		if($joinDate < time() - (60 * 60 * 24 * 3))
		{
			header("Location: /user-panel/second-auth"); exit;
		}
	}
	
	// Return to home page after logging in (or if already logged in)
	header("Location: /"); exit;
}

// Prepare Values
$_POST['handle'] = isset($_POST['handle']) ? Sanitize::variable($_POST['handle']) : "";

// If the user has an external site that they're trying to connect to
if(isset($_SESSION[SITE_HANDLE]['site_login']))
{
	$logSiteData = Network::get($_SESSION[SITE_HANDLE]['site_login']['site']);
	
	$loginHead = '
	<h2>Login to "' . $logSiteData['site_name'] . '"</h2>
	<h3>Will return you to: ' . $logSiteData['site_url'] . '</h3>';
}
else
{
	// Main Navigation
	WidgetLoader::add("MobilePanel", 10, '
	<div class="panel-box">
		<ul class="panel-slots">
			<li class="nav-slot"><a href="/register">Join UniFaction<span class="icon-circle-right nav-arrow"></span></a></li>
		</ul>
	</div>');
	
	$loginHead = "<h2>Login to UniFaction's Dashboard</h2>";
}

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Display Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

// Display the Page
echo '
<div id="content">' . Alert::display() . '

' . $loginHead . '

<form class="uniform" action="/login-auth" method="post">' . Form::prepare("auth-login-uni") . '
	<p><input type="text" name="handle" value="' . $_POST['handle'] . '" placeholder="Username . . ." autocomplete="off" tabindex="10" autofocus /></p>
	<p><input type="password" name="password" value="" placeholder="Password . . ." autocomplete="off" tabindex="20" /></p>
	<p><input class="button" type="submit" name="submit" value="Login" tabindex="30" /></p>
</form>

<div style="margin-top:50px;">
	<p><a href="/user-panel/password-reset">Forgot Your Password?</a></p>
	<p><a href="/register">Join UniFaction</a></p>
</div>

</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");