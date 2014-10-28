<?hh if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

----------------------------------------------
------ About the AppVerification Plugin ------
----------------------------------------------

This plugin allows you to verify your account.


-------------------------------
------ Methods Available ------
-------------------------------

AppVerification::sendVerification($uniID);

*/

abstract class AppVerification {
	
	
/****** Class Variables ******/
	const VERIFY_SALT = 'AuthVerify:H7Ws$fc)lAy#;,NbH$wa';
	
	
/****** Return a list of Account Types ******/
	public static function sendVerification
	(
		int $uniID		// <int> The UniID to send the verification to.
	): bool				// RETURNS <bool> TRUE on success, FALSE on failure.
	
	// AppVerification::sendVerification($uniID);
	{
		// Get the User's Email
		$authData = Database::selectOne("SELECT handle, email, verified FROM users WHERE uni_id=? LIMIT 1", array($uniID));
		
		if(isset($authData) && (int) $authData['verified'] == 0)
		{
			// Prepare the confirmation link
			$link = Confirm::createLink("email-confirmation", $authData['email'], array("uni_id" => $uniID), 10, self::VERIFY_SALT);
			
			// Prepare the Email
			$subject = "UniFaction Verification Email";
			$message = 'Hello ' . $authData['handle'] . '!,

Thank you for registering at UniFaction! Your account can be verified by visiting the following link:

' . $link . '

This email will only be used for password resets and emails settings that you have requested. You can change these settings at any time.

Thank you!
~ The UniFaction Staff';
			
			// Config
			global $config;
			
			// Send the Verification Email
			return Email::send($authData['email'], $subject, $message, $config['admin-email']);
		}
		
		return false;
	}
}

