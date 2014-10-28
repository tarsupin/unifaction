<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

$validLink = false;

// Make sure there is a valid confirmation link
if(isset($_GET['enc']))
{
	// Get the confirmation data
	if($confData = Confirm::validate($_GET['enc'], AppVerification::VERIFY_SALT))
	{
		// Get the user based off of the ID
		if($userData = Database::selectOne("SELECT uni_id, email FROM users WHERE uni_id=? LIMIT 1", array($confData['uni_id'] + 0)))
		{
			// Recognize Integers
			$userData['uni_id'] = (int) $userData['uni_id'];
			
			// Make sure the "chk" value matches the current password hash slice
			if($confData['id'] == $userData['email'])
			{
				$validLink = true;
			}
		}
	}
}

// If the verification was successful, update your verification setting
if($validLink == true)
{
	Database::query("UPDATE users SET verified=? WHERE uni_id=? LIMIT 1", array(1, $userData['uni_id']));
}
else
{
	Alert::saveError("Invalid Confirmation", "That confirmation link is expired or invalid.");
	
	header("Location: /user-panel/resend-verification"); exit;
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
' . Alert::display() .'
	
	<h3>Email Confirmed!</h3>
	<p>You now have full functionality with your accounts!</p>
	
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");