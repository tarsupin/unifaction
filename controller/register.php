<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// If you're already logged in, leave this page
if(Me::$loggedIn)
{
	header("Location: /"); exit;
}

// Check if the user has an Invitation Code
$charLength = 6;

if(isset($_SESSION[SITE_HANDLE]['invite-code']) and AppAccount::isInviteValid($_SESSION[SITE_HANDLE]['invite-code']))
{
	$charLength = 4;
}

// Check the form submission
if(Form::submitted("uni6-register-auth"))
{
	// Check if all of the input you sent is valid: 
	FormValidate::username($_POST['handle'], $charLength, 22);
	FormValidate::password($_POST['password']);
	
	// Get User Data
	if(Database::selectOne("SELECT handle FROM users WHERE handle=? LIMIT 1", array($_POST['handle'])))
	{
		Alert::error("Username", "That username already exists.");
	}
	
	// Now check if the form has passed
	if(FormValidate::pass())
	{
		$_SESSION[SITE_HANDLE]['register-username'] = $_POST['handle'];
		$_SESSION[SITE_HANDLE]['register-password'] = Security::setPassword($_POST['password']);
	}
}

// If you've done the first step of registration
if(isset($_SESSION[SITE_HANDLE]['register-username']) && isset($_SESSION[SITE_HANDLE]['register-password']))
{
	header("Location: /register-step-2"); exit;
}

/****** Page Configuration ******/
$config['canonical'] = "/register";
$config['pageTitle'] = "Join UniFaction";		// Up to 70 characters. Use keywords.
$config['description'] = "All of your online interests with one login. Join us today!";	// Overwrites engine: <160 char
Metadata::$index = true;
Metadata::$follow = true;
// Metadata::openGraph($title, $image, $url, $desc, $type);		// Title = up to 95 chars.

// Main Navigation
$html = '
<div class="panel-box">
	<ul class="panel-slots">
		<li class="nav-slot nav-back"><a href="/login-auth">Login to UniFaction<span class="icon-arrow-left nav-arrow"></span></a></li>
	</ul>
</div>';

WidgetLoader::add("SidePanel", 10, $html);

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

<h2>Sign Up</h2>

<form class="uniform" action="/register" method="post">' . Form::prepare("uni6-register-auth") . '
	<p>
		<strong>Username</strong><br />
		<input type="text" name="handle" value="' .(isset($_GET['handle']) ? Sanitize::variable($_GET['handle']) : (isset($_POST['handle']) ? Sanitize::variable($_POST['handle']) : '')) . '" placeholder="Desired username . . ." autocomplete="off" tabindex="10" autofocus /> (' . $charLength . '+ Characters)
	</p>
	<p>
		<strong>Password</strong><br />
		<input id="getpass" type="password" name="password" value="" placeholder="My password . . ." tabindex="20" /> (8+ Characters)
	</p>
	<p><input class="button" type="submit" name="submit" value="Sign Up" tabindex="30" /></p>
</form>';

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
