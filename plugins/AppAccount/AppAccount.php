<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

-----------------------------------------
------ About the AppAccount Plugin ------
-----------------------------------------

This plugin handles essential functionality for the core UniFaction handles for Auth.


-------------------------------
------ Methods Available ------
-------------------------------

// Check if a handle is already taken
AppAccount::handleTaken($handle);

*/

abstract class AppAccount {
	
	
/****** Retrieve a list of handle suggestions (during profile creation) ******/
	public static function getHandleSuggestions
	(
		$handle			// <str> The handle that was attempted.
	)					// RETURNS <int:str> list of handles that could be chosen.
	
	// $handleList = AppAccount::getHandleSuggestions($handle);
	{
		$handleList = array();
		$count = 0;
		
		// Make 25 attempts
		for($a = 0;$a < 25;$a++)
		{
			$pos = mt_rand(1, 10);
			$underscore = mt_rand(-1, 1) == 1 ? "_" : "";
			$type = mt_rand(0, 9);
			
			$result = "";
			$attempt = "";
			
			switch($type)
			{
				case 0:
				case 1:
				case 2:
					$attempt = date("Y"); break;
					
				case 3:
				case 4:
					$attempt = ""; $underscore = "_"; break;
					
				case 5:
				case 6:
					$underscore = "_";
					$array = array("a", "the", "one", "my", "i_am", "go", "for", "epic", "only", "is", "are", "big");
					$attempt = $array[rand(0, count($array) - 1)]; $pos = 1; break;
					
				case 7:
				case 8:
				case 9:
					$attempt = mt_rand(1, 99);
					if($attempt == 69) { $attempt = "0"; }
					break;
			}
			
			// If we're adding the attempt BEFORE the handle
			if($pos <= 2)
			{
				$result = $attempt . $underscore . $handle;
			}
			else
			{
				$result = $handle . $underscore . $attempt;
			}
			
			// Check if the resulting handle is available
			if(!$handleTaken = User::getIDByHandle($result))
			{
				if(!in_array($result, $handleList))
				{
					$handleList[] = $result;
					$count++;
					
					if($count >= 6)
					{
						break;
					}
				}
			}
		}
		
		// Return the list of suggestions
		return $handleList;
	}
	
	
/****** Check if a handle is already taken ******/
	public static function handleTaken
	(
		$handle			// <str> The handle that you want to check for availability.
	)					// RETURNS <bool> TRUE if taken, FALSE if not.
	
	// AppAccount::handleTaken($handle);
	{
		return (User::getIDByHandle($handle) ? true : false);
	}
	
	
/****** Check if the user is set to receive a new invite today (run during login) ******/
	public static function newInviteCheck
	(
		$uniID			// <int> The UniID of the person to test for an invite.
	)					// RETURNS <bool> TRUE if the user is granted an invite, FALSE if not.
	
	// $inviteCheck = AppAccount::newInviteCheck($uniID);
	{
		// Check how many invites they've had in total
		$count = (int) Database::selectValue("SELECT COUNT(*) as totalNum FROM invitation_codes WHERE uni_id=?", array($uniID));
		
		// Make sure they don't have any remaining empty invites.
		if($check = Database::selectValue("SELECT uni_id FROM invitation_codes WHERE uni_id=? AND redeemed_by=? LIMIT 1", array($uniID, 0)))
		{
			return false;
		}
		
		// Make sure they haven't gained an invite in the last 14 hours
		if($check = Database::selectValue("SELECT uni_id FROM invitation_codes WHERE uni_id=? AND date_acquired >= ? LIMIT 1", array($uniID, (time() - (3600 * 14)))))
		{
			return false;
		}
		
		// Prepare the random seed
		$seeder = (int) ($uniID . date("zy"));
		$srand = srand($seeder);
		
		$pass = ((rand(0, 100) <= 20 + min(25, $count * 3)) ? true : false);
		
		mt_srand();
		
		return $pass;
	}
	
	
/****** Create an invitation code  ******/
	public static function createInvitationCode
	(
		$uniID				// <int> The UniID to give an invitation code to.
	,	$inviteLevel = 1	// <int> The level of invitation (1 is standard, 3 is free invites, 5 is VIP)
	,	$numberInvites = 1	// <int> The number of invitations to create for this user.
	)						// RETURNS <bool> TRUE if there were invitation codes created, FALSE on failure.
	
	// AppAccount::createInvitationCode($uniID, [$inviteLevel], [$numberInvites]);
	{
		$pass = false;
		
		for($a = 1;$a <= $numberInvites;$a++)
		{
			// Prepare the invite code
			$inviteCode = Security::randHash(22, 62);
			
			// Check if the invite code is already taken
			if(!$check = Database::selectOne("SELECT uni_id FROM invitation_codes WHERE invite_code=? LIMIT 1", array($inviteCode)))
			{
				if(Database::query("INSERT INTO invitation_codes (uni_id, invite_code, invite_level, date_acquired) VALUES (?, ?, ?, ?)", array($uniID, $inviteCode, $inviteLevel, time())))
				{
					$pass = true;
				}
			}
		}
		
		return $pass;
	}
	
	
/****** Retrieve data about an invitation code ******/
	public static function getInviteData
	(
		$invitationCode		// <str> The invitation code to assign.
	)						// RETURNS <str:mixed> data about the invitation, array() on failure.
	
	// $inviteData = AppAccount::getInviteData($invitationCode);
	{
		return Database::selectOne("SELECT * FROM invitation_codes WHERE invite_code=? LIMIT 1", array($invitationCode));
	}
	
	
/****** Retrieve data about the invitation code that the user redeemed ******/
	public static function getUsersInviteData
	(
		$uniID		// <int> The UniID of the user to get their invite data from.
	)				// RETURNS <str:mixed> the invitation data.
	
	// $inviteData = AppAccount::getUsersInviteData($uniID);
	{
		return Database::selectOne("SELECT * FROM invitation_codes WHERE redeemed_by=? LIMIT 1", array($uniID));
	}
	
	
/****** Retrieve all of a user's invitation data ******/
	public static function getUserInviteList
	(
		$uniID		// <int> The invitation code to assign.
	)				// RETURNS <int:[str:mixed]> a list of invitations from the user.
	
	// $inviteList = AppAccount::getUserInviteList($uniID);
	{
		return Database::selectMultiple("SELECT * FROM invitation_codes WHERE uni_id=?", array($uniID));
	}
	
	
/****** Check if an invitation key is valid (you can redeem it) ******/
	public static function isInviteValid
	(
		$inviteCode		// <str> The invitation code to check for validity.
	)					// RETURNS <bool> TRUE if the invite code is valid, FALSE if not.
	
	// AppAccount::isInviteValid($inviteCode);
	{
		if(!$inviteData = Database::selectOne("SELECT * FROM invitation_codes WHERE invite_code=? LIMIT 1", array($inviteCode)))
		{
			return false;
		}
		
		// If the code was already redeemed
		if($inviteData['redeemed_by'])
		{
			return false;
		}
		
		return true;
	}
	
	
/****** Assign an invitation code  ******/
	public static function assignInviteCode
	(
		$uniID				// <int> The UniID that is being assigned to an invitation code.
	,	$invitationCode		// <str> The invitation code to assign.
	)						// RETURNS <bool> TRUE on successful assignment, FALSE on failure.
	
	// AppAccount::assignInviteCode($uniID, $invitationCode);
	{
		// Check if the invitation code exists
		if($inviteData = Database::selectOne("SELECT * FROM invitation_codes WHERE invite_code=? LIMIT 1", array($invitationCode)))
		{
			// Recognize Integers
			$inviteData['uni_id'] = (int) $inviteData['uni_id'];
			$inviteData['invite_level'] = (int) $inviteData['invite_level'];
			
			Database::startTransaction();
			
			// Assign the user
			if($pass = Database::query("UPDATE users SET referred_by=? WHERE uni_id=? LIMIT 1", array($inviteData['uni_id'], $uniID)))
			{
				$pass = Database::query("UPDATE invitation_codes SET redeemed_by=? WHERE uni_id=? AND invite_code=? LIMIT 1", array($uniID, $inviteData['uni_id'], $inviteData['invite_code']));
			}
			
			return Database::endTransaction($pass);
		}
		
		return false;
	}
	
}
