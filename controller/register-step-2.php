<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// If you're already logged in, leave this page
if(Me::$loggedIn)
{
	header("Location: /"); exit;
}

// Require Invitation Code
/*
if(isset($_SESSION[SITE_HANDLE]['invite-code']) and AppAccount::isInviteValid($_SESSION[SITE_HANDLE]['invite-code']))
{
	// You have a valid invite code
}
*/

// Make sure you've gone through the first registration step successfully
if(!isset($_SESSION[SITE_HANDLE]['register-username']) && !isset($_SESSION[SITE_HANDLE]['register-password']))
{
	header("Location: /register"); exit;
}

// Prepare Values
$runCaptcha = false;		// Set this to true if we're activating captcha

// Check the form submission
if(Form::submitted("uni-reg-step-fin"))
{
	FormValidate::email($_POST['email']);
	
	FormValidate::confirmation("Terms of Service", isset($_POST['tos']));
	
	if(Database::selectOne("SELECT email FROM users WHERE email=? LIMIT 1", array($_POST['email'])))
	{
		Alert::error("Email", "That email already exists.", 1);
	}
	
	// Check the Captcha value if we've passed everything else so far
	if(FormValidate::pass() and $runCaptcha)
	{
		Captcha::validate($_POST['image_val']);
	}
	
	// Final Validation Test
	if(FormValidate::pass())
	{
		Database::startTransaction();
		
		// Register the User
		if($pass = Database::query("INSERT INTO users (handle, email, display_name, password, date_joined, auth_token) VALUES (?, ?, ?, ?, ?, ?)", array($_SESSION[SITE_HANDLE]['register-username'], $_POST['email'], ucfirst($_SESSION[SITE_HANDLE]['register-username']), $_SESSION[SITE_HANDLE]['register-password'], time(), Security::randHash(22, 72))))
		{
			$uniID = (int) Database::$lastID;
			
			$pass = Database::query("INSERT INTO users_handles (handle, uni_id) VALUES (?, ?)", array($_SESSION[SITE_HANDLE]['register-username'], $uniID));
		}
		
		// If the transaction was successful, finish the registration
		if(Database::endTransaction($pass))
		{
			// Redeem the invitation used
			if(isset($_SESSION[SITE_HANDLE]['invite-code']))
			{
				if($inviteData = AppAccount::getInviteData($_SESSION[SITE_HANDLE]['invite-code']))
				{
					// Assign the invitation code to this user
					AppAccount::assignInviteCode($uniID, $inviteData['invite_code']);
					
					// Gain special advantages based on the level of the invitation code
					$inviteData['invite_level'] = (int) $inviteData['invite_level'];
					
					if($inviteData['invite_level'] >= 3)
					{
						AppAccount::createInvitationCode($uniID, 1, $inviteData['invite_level']);
					}
					
					unset($_SESSION[SITE_HANDLE]['invite-code']);
				}
			}
			
			// Email a verification letter
			AppVerification::sendVerification($uniID);
			
			Alert::saveSuccess("Email Sent", "You registered successfully! A verification email has been sent to " . $_POST['email'] . "!");
			
			// Assign a default image to the user
			$packet = array(
				"uni_id"		=> $uniID
			,	"title"			=> "@" . $_SESSION[SITE_HANDLE]['register-username']
			);
			
			$response = Connect::to("profile_picture", "SetDefaultPic", $packet);
			
			unset($_SESSION[SITE_HANDLE]['register-username']);
			unset($_SESSION[SITE_HANDLE]['register-password']);
			
			// Log in
			Me::login($uniID, true);
			
			// Redirect to the page in question
			header("Location: /"); exit;
		}
		else
		{
			Alert::error("Process Error", "An error has occurred while processing this registration.", 1);
		}
	}
}

// Prepare Default Form Entries
$_POST['email'] = (isset($_POST['email']) ? Sanitize::variable($_POST['email'], "@.-+s") : "");

/****** Page Configuration ******/
$config['canonical'] = "/register-step-2";
$config['pageTitle'] = "Join UniFaction";		// Up to 70 characters. Use keywords.
$config['description'] = "All of your online interests with one login. Join us today!";	// Overwrites engine: <160 char
// Metadata::openGraph($title, $image, $url, $desc, $type);		// Title = up to 95 chars.

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Display Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

// Display the Page
echo '
<div id="content">' . Alert::display() . '

<h2>Thank you for joining UniFaction, ' . $_SESSION[SITE_HANDLE]['register-username'] . '!</h2>

<form class="uniform" action="/register-step-2" method="post">' . Form::prepare("uni-reg-step-fin");

if($runCaptcha)
{
	echo '
	<h4 style="margin-top:35px;">Confirm that you are human</h4>
	<p><img id="captcha" src="/assets/captcha.php" alt="CAPTCHA Image" /></p>
	<p>
		<input type="text" name="image_val" size="30" maxlength="7" placeholder="Enter Captcha Code" tabindex="10" autofocus />
		<a href="/test" onclick="document.getElementById(\'captcha\').src = \'/assets/captcha.php?\' + Math.random(); return false;"><img src="/assets/icons/refresh.png" alt="Refresh CAPTCHA Image" style="height:18px;" /></a>
	</p>';
}

echo '
<h4 style="margin-top:35px;">Verify your email</h4>
	<p>Note: this helps prevent spam and allows password recovery. We won\'t spam you! (See our <a href="/docs/privacy">privacy policy</a>)</p>
	<p><input type="text" name="email" value="' . $_POST['email'] . '" placeholder="Email . . ." tabindex="20" style="min-width:250px;" /></p>
	<p><input type="checkbox" name="tos" ' . (isset($_POST['tos']) ? 'checked' : '') . '  tabindex="30" target="_new" /> I agree to the <a href="' . URL::unifaction_com() . '/tos">Terms of Service</a></p>
	<p><input type="submit" name="submit" value="Finish Registration" tabindex="40" /></p>';

echo '
</form>';

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
