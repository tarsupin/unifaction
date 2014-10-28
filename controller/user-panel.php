<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Make sure you're logged in
if(!Me::$loggedIn)
{
	Me::redirectLogin("/user-panel");
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
<h4>Important Functions</h4>
<div><a href="' . URL::profilepic_unifaction_com() . Me::$slg . '">Update My Profile Picture</a></div>
<div><a href="/user-panel/account/master-edit">My Account Settings</a></div>';

echo '
<h4 style="margin-top:22px;">My Tools</h4>
<div><a href="/my-invites">My Invitations</a></div>
<div><a href="/my-notifications">My Notifications</a></div>';

echo '
<h4 style="margin-top:22px;">Site Documents</h4>
<div><a href="/tos">Terms of Service</a></div>
<div><a href="/privacy">Privacy Policy</a></div>
<div><a href="/acknowledgements">Acknowledgements</a></div>
<div><a href="/faqs">Frequently Asked Questions</a></div>';

echo '
<h4 style="margin-top:22px;">Other</h4>
<div><a href="/user-panel/reports">File a Report</a></div>
<div><a href="/contact-us">Contact Us</a></div>';

if(Me::$clearance >= 8)
{
	echo '
	<div><a href="/user-panel/my-sites">My Sites</a></div>';
}

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
