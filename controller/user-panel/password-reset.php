<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Make sure user is logged in
if(Me::$loggedIn)
{
	header("Location: /"); exit;
}

// Check the Form
if(Form::submitted("auth-pass-reset"))
{
	FormValidate::email($_POST['email']);
	
	// Check if email exists in our database
	if(!$userData = Database::selectOne("SELECT uni_id, email, password FROM users WHERE email=? LIMIT 1", array($_POST['email'])))
	{
		Alert::error("Invalid Email", "That email has not been registered with us.");
	}
	else if(FormValidate::pass())
	{
		// Create the appropriate confirmation value
		$confValue = Security::randHash(14, 62);
		
		if(Confirm::create($confValue, array("type" => "password-reset", "uni_id" => (int) $userData['uni_id'])))
		{
			// Prepare the message
			$message = 'Hello,

A password request has been requested for your UniFaction account.

Your confirmation value is: ' . $confValue . '

Thank You!
UniFaction';
			
			// Send an Email
			Email::send($userData['email'], "Password Reset for UniFaction", $message);
			
			Alert::success("Email Sent", "Success! A confirmation value has been sent to " . $userData['email'] . "!");
			
			header("Location: /confirm"); exit;
		}
		else
		{
			Alert::error("Email Failed", "There was an error creating the confirmation for this. Please try again later.");
		}
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
<style>
	.uniform>input { margin-top:8px; }
</style>

<h2>Reset Password</h2>

<form class="uniform" action="/user-panel/password-reset" method="post">' . Form::prepare("auth-pass-reset") . '
	<p><input type="text" name="email" value="" placeholder="Email . . ." size="40" autocomplete="off" /></p>
	<p><input type="submit" name="submit" value="Send Password Reset" /></p>
</form>';

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");