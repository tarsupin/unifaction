<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Require Login
if(!Me::$loggedIn)
{
	Me::redirectLogin("/multi-accounts", "/");
}

// Run the Form
if(Form::submitted("dashboard-grant-account"))
{
	// Validation Checks
	FormValidate::username($_POST['username']);
	
	// Check if the user exists
	if(!$uniID = User::getIDByHandle($_POST['username']))
	{
		Alert::error("User Invalid", "That user was not found in the system.");
	}
	
	// Make sure it's not the active user
	if($uniID == Me::$id)
	{
		Alert::error("User Invalid", "You already have access to this account.");
	}
	
	if(FormValidate::pass())
	{
		// Grant the Multiple Access
		AppMultipleAcct::create($uniID, Me::$id);
		
		Alert::success("Account Added", "You have granted @" . $_POST['username'] . " access to this account.");
	}
}

// Remove a user from being able to access this account
else if($value = Link::getData("remove-granted"))
{
	AppMultipleAcct::delete((int) $value[0], Me::$id);
}

// Switch to a new account that you have access to
else if($value = Link::getData("access-user") and isset($value[0]))
{
	// Recognize Integers
	$value[0] = (int) $value[0];
	
	// Make sure that you have permission to access the designated account
	if(AppMultipleAcct::hasAccess(Me::$id, $value[0]))
	{
		// Log out of the existing user
		Me::logout();
		
		// Log in to the designated user
		Me::login($value[0], true);
		
		// Announce success of the account switch
		Alert::saveSuccess("Account Switch", "You have successfully logged into the @" . $handle . " account");
		
		// Redirect to the home page (logged in as the new user)
		header("Location: /");
	}
	else
	{
		Alert::error("Invalid Permissions", "You do not have permissions to that account.", 10);
	}
}

// Prepare Values
$accessList = AppMultipleAcct::getAccessList(Me::$id);
$grantedList = AppMultipleAcct::getGrantedList(Me::$id);

/****** Page Configuration ******/
$config['canonical'] = "/multi-accounts";
$config['pageTitle'] = "Multiple Accounts - UniFaction";		// Up to 70 characters. Use keywords.
Metadata::$index = false;
Metadata::$follow = false;
// Metadata::openGraph($title, $image, $url, $desc, $type);		// Title = up to 95 chars.

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");


/****** Run Content ******/
echo '
<div id="panel-right"></div>
<div id="content">' . Alert::display();

echo'
<h2 style="margin-bottom:0px;">Accounts I can Access</h2>
<div style="margin-top:10px; overflow:hidden;">';

// Show each user you can access
foreach($accessList as $access)
{
	echo '
	<div class="icon-block"><a href="/multi-accounts?' . Link::prepareData("access-user", (int) $access['access_to_id']) . '"><img class="circimg" src="' . ProfilePic::image((int) $access['access_to_id'], "medium") . '" /></a><br />@' . $access['handle'] . '</div>';
}

echo '
</div>';

echo'
<h2 style="margin-bottom:0px;">Accounts that can access me</h2>
<div style="margin-top:10px; overflow:hidden;">';

// Show each user you have granted access to
foreach($grantedList as $granted)
{
	echo '
	<div class="icon-block" style="margin-top:0px;"><img class="circimg" src="' . ProfilePic::image((int) $granted['granted_to_id'], "medium") . '" /><br />@' . $granted['handle'] . '<br /><a href="/multi-accounts?' . Link::prepareData("remove-granted", (int) $granted['granted_to_id']) . '" onclick="return confirm(\'Are you sure you want to remove @' . $granted['handle'] . '\\\'s access to this account?\');">Remove</a></div>';
}

echo '
</div>';

echo'
<h2>Grant someone access to this account</h2>
<p>Granting access to this account allows the recipient to instantly log in to this account with FULL permissions. Therefore, you should only grant this access to accounts that you absolutely trust.</p>

<form class="uniform" action="/multi-accounts" method="post">' . Form::prepare("dashboard-grant-account") . '
<p>
	<strong>Give someone full access to @' . Me::$vals['handle'] . '</strong><br />
	<input type="text" name="username" value="" placeholder="Enter a username . . ." tabindex="10" autofocus maxlength="22" style="width:95%" />
</p>
<p><input type="submit" name="submit" value="Grant Full Access" /></p>
</form>';

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");