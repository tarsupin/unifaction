<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Make sure there is a valid confirmation link
if(!isset($_GET['api']))
{
	die("This confirmation link appears to be invalid.");
}

// Get the confirmation data
if(!$confData = Confirm::validate($_GET['api']))
{
	die("This confirmation link appears to be invalid.");
}

// Get the user based off of the ID
if(!$userData = Database::selectOne("SELECT uni_id, username, email, password FROM users WHERE uni_id=? LIMIT 1", array($confData['id'] + 0)))
{
	die("This confirmation link appears to be invalid.");
}

// Recognize Integers
$userData['uni_id'] = (int) $userData['uni_id'];

// Make sure the "chk" value matches the current password hash slice
if(!isset($confData['newEmail']))
{
	die("This confirmation link appears to be invalid.");
}

Sanitize::variable($confData['newEmail'], ".+@_-");

// Check the Form
if(Form::submitted("change-email-uni"))
{
	FormValidate::email($confData['newEmail']);
	
	// Make sure that email isn't already used
	if(Database::selectValue("SELECT email FROM users WHERE email=? LIMIT 1", array($confData['newEmail'])))
	{
		Alert::error("Email Taken", "That email has already been taken!", 1);
	}
	
	if(FormValidate::pass())
	{
		// Update the Email
		if(Database::query("UPDATE users SET email=? WHERE uni_id=? LIMIT 1", array($confData['newEmail'], $userData['uni_id'])))
		{
			$link = Confirm::createLink("email-confirmation", $userData['uni_id'], array("email" => $confData['newEmail']), 10);
			
			// Set Verification to 0
			Database::query("UPDATE users SET verified=? WHERE uni_id=? LIMIT 1", array(0, $userData['uni_id']));
			
			// Alert the User (including by Email)
			$message = 'Hello,

Your UniFaction account has been associated with this email! Please verify your new email at this link:

<a href="' . $link . '">' . $link . '</a>

Thank You!
UniFaction';
			
			Email::send($userData['email'], "Email Confirmation for UniFaction", $message);
			
			// Move to the login page, with success message
			Alert::saveSuccess("Email Confirm", "Email updated successfully! Verification email has been sent!");
			header("Location: /"); exit;
		}
	}
}

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Display the Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

echo '
<div id="content">
' . Alert::display() . '

<h3>Change Email for "' . $userData['username'] . '"</h3>
<p>Note: You will have to verify this new email to use your account.</p>

<form class="uniform" action="/confirm/email-change" method="post">' . Form::prepare("change-email-uni") . '
	<p><input type="text" name="new_email" value="' . $confData['newEmail'] . '" style="width:300px;" readonly /></p>
	<p><input type="submit" name="submit" value="Update Email" /></p>
	
	<input type="hidden" name="enc" value="' . Sanitize::variable($_GET['api']) . '" />
</form>

</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");