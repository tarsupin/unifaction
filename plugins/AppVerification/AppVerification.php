<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

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
	
	
/****** Return a list of Account Types ******/
	public static function sendVerification
	(
		$uniID		// <int> The UniID to send the verification to.
	)				// RETURNS <bool> TRUE on success, FALSE on failure.
	
	// AppVerification::sendVerification($uniID);
	{
		// Get the User's Email
		$authData = Database::selectOne("SELECT handle, email, verified FROM users WHERE uni_id=? LIMIT 1", array($uniID));
		
		if(isset($authData) && (int) $authData['verified'] == 0)
		{
			// Create the appropriate confirmation value
			$confValue = Security::randHash(14, 62);
			
			if(Confirm::create($confValue, array("type" => "email-confirmation", "uni_id" => $uniID)))
			{
				// Prepare the Email
				$subject = "UniFaction Verification Email";
				$message = 'Hello ' . $authData['handle'] . '!,

Thank you for registering at UniFaction!

Your confirmation value is: ' . $confValue . '

Thank you!
~ UniFaction';
				
				// Config
				global $config;
				
				// Send the Verification Email
				if(Email::send($authData['email'], $subject, $message, $config['admin-email']))
				{
					return true;
				}
			}
			else
			{
				return false;
			}
		}
		
		return false;
	}
}


