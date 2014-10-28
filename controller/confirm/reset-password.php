<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Make sure there is a valid confirmation link
$enc = "";

if(isset($_POST['enc']))
{
	$enc = $_POST['enc'];
}
else if(isset($_GET['enc']))
{
	$enc = $_GET['enc'];
}

// Get the confirmation data
if(!$enc or !$confData = Confirm::validate($enc))
{
	die("This confirmation link appears to be invalid.");
}

// Get the user based off of the ID
if(!$userData = Database::selectOne("SELECT uni_id, email, password FROM users WHERE uni_id=? LIMIT 1", array($confData['id'] + 0)))
{
	die("This confirmation link appears to be invalid.");
}

// Recognize Integers
$userData['uni_id'] = (int) $userData['uni_id'];

// Make sure the "chk" value matches the current password hash slice
if($confData['chk'] != Security::hash(substr($userData['password'], 20, 20), 15, 62))
{
	die("This confirmation link appears to be invalid.");
}

// Get the login security question and answer
if(!$security = Database::selectOne("SELECT question, answer FROM login_security_questions WHERE uni_id=? LIMIT 1", array($userData['uni_id'])))
{
	$security['question'] = "";
	$security['answer'] = "";
}

// Prepare Values
$_POST['security_question'] = isset($_POST['security_question']) ? $_POST['security_question'] : $security['question'];
$_POST['security_answer'] = isset($_POST['security_answer']) ? $_POST['security_answer'] : $security['answer'];

// Check the Form
if(Form::submitted("reset-uni6-pass"))
{
	// Prepare the Validation
	FormValidate::password($_POST['password']);
	Sanitize::text($_POST['security_question']);
	FormValidate::variable("Security Answer", $_POST['security_answer'], 3, 22, " ");
	
	// Check the Security Question Length
	if(strlen($_POST['security_question']) < 3)
	{
		Alert::error("Question Short", "Your security question is too short.");
	}
	
	if(!$uniID = (int) Database::selectValue("SELECT uni_id FROM users WHERE uni_id=? LIMIT 1", array($confData['id'])))
	{
		Alert::error("Invalid User", "The user you are trying to reset the password for is invalid.", 1);
	}
	
	if(FormValidate::pass())
	{
		// Update the Password
		$passHash = Security::setPassword($_POST['password']);
		
		Database::startTransaction();
		
		if($pass = Database::query("UPDATE users SET password=? WHERE uni_id=? LIMIT 1", array($passHash, $uniID)))
		{
			$pass = Database::query("UPDATE login_security_questions SET question=?, answer=? WHERE uni_id=? LIMIT 1", array($_POST['security_question'], $_POST['security_answer'], $uniID));
		}
		
		if(Database::endTransaction($pass))
		{
			// Alert the User (including by Email)
			$message = "Hello,

The UniFaction account associated with this email has had its password reset successfully! You may now begin using your new password.

Sincerely,
UniFaction";
			
			Email::send($userData['email'], "Password Reset for UniFaction", $message);
			
			// Move to the login page, with success message
			Alert::saveSuccess("Reset Password", "Your password was updated successfully.");
			header("Location: /login"); exit;
		}
		else
		{
			Alert::error("Reset Error", "There was an error trying to update your security credentials.");
		}
	}
}

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

echo '
<div id="content">' . Alert::display() . '

<h3>Reset Password</h3>
<form class="uniform" action="/confirm/reset-password" method="post">' . Form::prepare("reset-uni6-pass") . '
	
	<p>
		<strong>New Password</strong><br />
		<input type="password" name="password" value="" maxlength="72" style="width:95%;" />
	</p>
	
	<p>
		<strong>Security Question</strong><br />
		<input type="text" name="security_question" value="' . $_POST['security_question'] . '" placeholder="e.g. What is my alter-ego superhero name?" maxlength="65" style="width:95%;" />
	</p>
	
	<p>
		<strong>Answer to Security Question</strong><br />
		<input type="text" name="security_answer" value="' . $_POST['security_answer'] . '" placeholder="e.g. The One" maxlength="22" style="width:95%;" />
	</p>
	
	<p><input type="submit" name="submit" value="Update Login Security" /></p>
	<input type="hidden" name="enc" value="' . Sanitize::safeword($enc, "+=/|") . '" />
</form>

</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");