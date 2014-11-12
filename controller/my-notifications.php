<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Require Login
if(!Me::$loggedIn)
{
	Me::redirectLogin("/my-notifications", "/");
}

/****** Page Configuration ******/
$config['canonical'] = "/my-notifications";
$config['pageTitle'] = "My Notifications - UniFaction";		// Up to 70 characters. Use keywords.
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
<style>
	p { margin-bottom:0px; padding:6px; }
	p:nth-child(even) { background-color:#d0d0d0; }
	p:nth-child(odd) { background-color:#eeeeee; }
</style>

<h2>My Notifications</h2>';

$notifications = Notifications::get(Me::$id, 1, 50);

foreach($notifications as $note)
{
	echo '
	<p><a href=""><span class="icon-arrow-right"></span> ' . $note['message'] . '</a> - ' . Time::fuzzy((int) $note['date_created']) . '</p>';
}

echo '
	<p></p>
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");