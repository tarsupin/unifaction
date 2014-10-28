<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Make sure user is logged in
if(!Me::$loggedIn)
{
	header("Location: /"); exit;
}

// Get Settings Data
$settingsData = Database::selectOne("SELECT email, password, timezone, verified FROM users WHERE uni_id=? LIMIT 1", array(Me::$id));

$timezones = Time::timezones();

// Check the Form
if(Form::submitted("auth-global-edit"))
{
	// If the email was changed
	if($_POST['email'] != $settingsData['email'])
	{
		FormValidate::email($_POST['email']);
		
		if(FormValidate::pass())
		{
			if($settingsData['verified'])
			{
				$link = Confirm::createLink("email-change", Me::$id, array("newEmail" => $_POST['email']), 10);
				
				// Prepare the message
				$message = 'Hello,

	Your UniFaction account has requested an email change to: ' . $_POST['email'] . '. You may confirm this update at the following link:

	<a href="' . $link . '">' . $link . '</a>

	Thank you!
	UniFaction';
				
				// Send an email
				Email::send($settingsData['email'], "UniFaction Email Change", $message);
				
				Alert::success("Email Sent", "Email sent to " . $settingsData['email'] . "!");
			}
			else
			{
				if(Database::query("UPDATE users SET email=? WHERE uni_id=? LIMIT 1", array($_POST['email'], Me::$id)))
				{
					Alert::success("Email Updated", "Your email has successfully been updated.");
				}
			}
		}
	}
	
	// If the password was changed
	if($_POST['password_current'] != "" or $_POST['password_new'] != "")
	{
		if($passCheck = Security::getPassword($_POST['password_current'], $settingsData['password']))
		{
			FormValidate::password($_POST['password_new']);
			
			if(FormValidate::pass())
			{
				// Update the new password
				$newPass = Security::setPassword($_POST['password_new']);
				
				Database::query("UPDATE users SET password=? WHERE uni_id=? LIMIT 1", array($newPass, Me::$id));
				
				Alert::success("Password", "Your password was updated successfully.");
			}
		}
		else
		{
			Alert::error("Password", "You did not enter the correct current password.", 4);
		}
	}
	
	// If the timezone was changed
	if($_POST['timezone'] != $settingsData['timezone'])
	{
		if(!isset($timezones[$_POST['timezone']]))
		{
			Alert::error("Timezone", "Please select a timezone from the options provided.");
		}
		
		if(FormValidate::pass())
		{
			Database::query("UPDATE users SET timezone=? WHERE uni_id=? LIMIT 1", array($_POST['timezone'], Me::$id));
			
			Alert::success("Timezone", "You have updated your timezone successfully.");
		}
	}
}

// Prepare Defaults
$_POST['email'] = (isset($_POST['email']) ? $_POST['email'] : $settingsData['email']);
$_POST['timezone'] = (isset($_POST['timezone']) ? $_POST['timezone'] : $settingsData['timezone']);

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

<h2>Edit Global Settings</h2>

<form class="uniform" action="/user-panel/account/master-edit" method="post">' . Form::prepare("auth-global-edit") . '
	
	<h4>Change Email</h4>
	<input type="text" name="email" value="' . $_POST['email'] . '" size="40" autocomplete="off" />
	
	<h4 style="margin-top:22px;">Change Password</h4>
	<input type="password" name="password_current" value="" placeholder="Current Password" size="40" /><br />
	<input type="password" name="password_new" value="" placeholder="New Password" size="40" />
	
	<h4 style="margin-top:22px;">Change Timezone</h4>';
	
	// Timezone
	echo '
	<select name="timezone">
		<option value="">-- Select a Timezone --</option>';
	
	foreach($timezones as $key => $value)
	{
		echo '
		<option value="' . $key . '"' . ($_POST['timezone'] == $key ? ' selected' : '') . '>' . $value . '</option>';
	}
	
	echo '
	</select>
	<br /><br />
	<input type="submit" name="submit" value="Update Preferences" />
</form>';

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");