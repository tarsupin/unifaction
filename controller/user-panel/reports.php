<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Make sure you're logged in
if(!Me::$loggedIn)
{
	Me::redirectLogin("/user-panel/reports");
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

// Retrieve APP Reports
if(File::exists(APP_PATH . "/controller/user-panel/reports/_include.php"))
{
	require(APP_PATH . "/controller/user-panel/reports/_include.php");
}

echo '
<a href="/user-panel/reports/user">Report a User (Spam, Behavior, etc.)</a><br />
<a href="/user-panel/reports/bug">Create a Bug Report</a><br />
<a href="/user-panel/reports/contact-mods">Contact Site Moderators</a>
';

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
