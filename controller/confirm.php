<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Run the confirmation form
if(Form::submitted("confirmation-value"))
{
	FormValidate::variable("Confirmation Value", $_POST['confirmation_value'], 5, 22);
	
	if(FormValidate::pass())
	{
		// Get the confirm data
		$confirm = new Confirm($_POST['confirmation_value']);
		
		if($confirm->passed)
		{
			switch($confirm->type)
			{
				case "password-reset":
					$_SESSION[SITE_HANDLE]['confirm'] = $confirm->data;
					header("Location: /confirm/reset-password"); exit;
					break;
				
				case "email-change":
					
					// Update the Email
					if(Database::query("UPDATE users SET email=? WHERE uni_id=? LIMIT 1", array($confirm->data['new_email'], $confirm->data['uni_id'])))
					{
						// Move to the login page, with success message
						Alert::saveSuccess("Email Confirm", "Your email has been updated successfully!");
						
						// Return to the home page
						header("Location: /"); exit;
					}
					
					break;
				
				case "email-confirmation":
					
					// If the verification was successful, update your verification setting
					if(Database::query("UPDATE users SET verified=? WHERE uni_id=? LIMIT 1", array(1, $confirm->data['uni_id'])))
					{
						Alert::saveSuccess("Successful Confirmation", "You have successfully verified your email!");
						
						header("Location: /"); exit;
					}
					
					break;
				
				default:
					Alert::error("Invalid Confirmation", "That confirmation value appears to be invalid or expired.");
					break;
			}
		}
		else
		{
			Alert::error("Invalid Confirmation", "That confirmation value appears to be invalid or expired.");
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
<div id="content">' . Alert::display();

// Display the confirmation value
echo '
<p>Please check your email for a confirmation value.</p>

<form class="uniform" action="/confirm" method="post" />' . Form::prepare('confirmation-value') . '
	<p>
		<strong>Confirmation Value:</strong><br />
		<input type="text" name="confirmation_value" value="" placeholder="Enter your confirmation value . . ." maxlength="22" style="box-sizing:border-box; width:100%;" autocomplete="off" />
	</p>
	<p><input type="submit" name="submit" value="Run Confirmation" /></p>
</form>';

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");