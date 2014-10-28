<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Make sure user is logged in
if(!Me::$loggedIn)
{
	header("Location: /"); exit;
}

// Check if email exists in our database
$userData = Database::selectOne("SELECT uni_id, email, verified FROM users WHERE uni_id=? LIMIT 1", array(Me::$id));

// Recognize Integers
$userData['uni_id'] = (int) $userData['uni_id'];
$userData['verified'] = (int) $userData['verified'];

if($userData['verified'] == 1)
{
	Alert::saveSuccess("Verification Passed", "Your account is fully verified!");
	
	header("Location: /"); exit;
}

// Check the Form
if($link = Link::clicked() and $link == "send")
{
	if(AppVerification::sendVerification($userData['uni_id']))
	{
		Alert::saveSuccess("Verification Sent", "An email verification has been sent to " . $userData['email'] . "!");
		
		header("Location: /"); exit;
	}
	else
	{
		Alert::error("Verification Error", "There was an error with sending this verification. Please try again later.");
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
<h2>Email Verification</h2>
<p>Are you sure you want to resend email verification to <strong>' . $userData['email'] . '</strong>?</p>

<p><a class="button" href="/user-panel/resend-verification?' . Link::prepare("send") . '">Resend Verification Email</a></p>';

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");