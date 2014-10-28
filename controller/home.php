<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/****** Page Configuration ******/
$config['canonical'] = "/";
$config['pageTitle'] = "UniFaction";		// Up to 70 characters. Use keywords.
$config['description'] = "All of your online interests with one login.";	// Overwrites engine: <160 char
<<<<<<< HEAD
Metadata::$index = true;
Metadata::$follow = true;
// Metadata::openGraph($title, $image, $url, $desc, $type);		// Title = up to 95 chars.

// Get the active account (if logged in)
if(Me::$loggedIn)
{
	// Make sure the account is yours
	$userData = Database::selectOne("SELECT uni_id, clearance, role, handle, display_name FROM users WHERE uni_id=? LIMIT 1", array(Me::$id));
	
	if(isset($userData['uni_id']))
	{
		// Recognize Integers
		$userData['uni_id'] = (int) $userData['uni_id'];
		$userData['clearance'] = (int) $userData['clearance'];
		
		// Set Values
		Me::$id = $userData['uni_id'];
		Me::$clearance = $userData['clearance'];
		$_SESSION[SITE_HANDLE]['uni_id'] = Me::$id;
	}
}

// If you're logged in but don't have a profile selected, force the user to choose
else
{
	// Require a login
	header("Location: /login-auth"); exit;
}

=======
Metadata::$index = false;
Metadata::$follow = true;
// Metadata::openGraph($title, $image, $url, $desc, $type);		// Title = up to 95 chars.

>>>>>>> origin/master
// Pull the necessary data
$feedData = AppHomeFeed::getFeed();

// Prepare Header Handling
Photo::prepareResponsivePage();

Metadata::addHeader('<link rel="stylesheet" href="' . CDN . '/css/content-system.css" /><script src="' . CDN . '/scripts/content-system.js"></script>');

// Run Global Script
<<<<<<< HEAD
require(APP_PATH . "/includes/global.php");

// Display Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Side Panel
=======
require(CONF_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Display Side Panel
>>>>>>> origin/master
require(SYS_PATH . "/controller/includes/side-panel.php");

echo '
<div id="panel-right"></div>
<div id="content">' . Alert::display();

<<<<<<< HEAD
// Display the page
if(Me::$vals['date_joined'] >= time() - 150000)
{
	echo '
	<h3>Welcome to UniFaction, @' . $userData['handle'] . '</h3>
	
	<style>
		.icon-block { vertical-align:top; padding:4px; }
		.icon-block span { font-size:64px; }
	</style>
	
	<div class="icon-block"><a href="' . URL::profilepic_unifaction_com() . Me::$slg . '"><img class="circimg" src="' . ProfilePic::image(Me::$id, "medium") . '" /></a><br />Update my<br />Profile Picture</div>
	<div class="icon-block"><a href="' . URL::unifaction_social() . Me::$slg . '"><span class="icon-group"></span></a><br />Go to my<br />Social Page</div>
	<div class="icon-block"><a href="' . URL::unifaction_me() . Me::$slg . '"><span class="icon-globe"></span></a><br />Go to my<br />Website</div>
	<div class="icon-block"><a href="' . URL::blogfrog_social() . Me::$slg . '"><span class="icon-pen"></span></a><br />Go to my<br />Blog</div>';
}

// Show Feed
AppHomeFeed::displayFeed($feedData, false, Me::$id);

// Show Feed
/*
echo '
<div class="main-hr"></div>
<h3>Welcome to UniFaction</h3>
<p>Hello everyone, and welcome to UniFaction!</p>
<p>This system is in beta right now, and we are working on many few features. Some functionality has been intentionally restricted, so you may not be able to access some of the sites that you were expecting to during the transition. This is because we have several things that we need to deal with before giving you access. Please be patient with us.</p>
<p>There are also several features of convenience that are yet to be added. Please keep in mind that these will be added soon as well. For example, finding friends is difficult right now, but it will improve later.</p>
<p>If you run into any bugs, feel free to message a moderator. We will try to deal with any and all bugs as quickly as possible, but there are some expected during our release.</p>
<p>Thank you, and have a great stay!</p>';
*/

echo '
	<div class="spacer-huge"></div>
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
=======
AppHomeFeed::displayFeed($feedData, false, Me::$id);

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
>>>>>>> origin/master
