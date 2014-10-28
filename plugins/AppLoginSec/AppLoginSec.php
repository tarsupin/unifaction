<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

------------------------------------------
------ About the AppLoginSec Plugin ------
------------------------------------------

This plugin provides additional login security for Auth.


-------------------------------
------ Methods Available ------
-------------------------------

AppLoginSec::hasSecondAuth($uniID);
AppLoginSec::setSecurityQuestion($uniID, $question, $answer);

$questionData = AppLoginSec::questionData($uniID);

AppLoginSec::loginFailure($uniID);
$failedLogins = AppLoginSec::failedLogins($uniID, $duration = 600);

*/

abstract class AppLoginSec {
	
	
/****** Check if the user has secondary authentication ******/
	public static function hasSecondAuth
	(
		$uniID			// <int> The AuthID of the user to test for second authentication.
	)					// RETURNS <bool> TRUE if second authentication exists, FALSE if not.
	
	// AppLoginSec::hasSecondAuth($uniID);
	{
		if(Database::selectValue("SELECT uni_id FROM login_security_questions WHERE uni_id=? LIMIT 1", array($uniID)))
		{
			return true;
		}
		
		return false;
	}
	
	
/****** Create a Security Question ******/
	public static function setSecurityQuestion
	(
		$uniID			// <int> The AuthID of the user to prepare the security question for.
	,	$question		// <str> The security question to ask.
	,	$answer			// <str> The answer to the security question.
	)					// RETURNS <bool> TRUE on success, FALSE on failure.
	
	// AppLoginSec::setSecurityQuestion($uniID, $question, $answer);
	{
		// Check if the user already has a security question set
		if(Database::selectValue("SELECT uni_id FROM login_security_questions WHERE uni_id=? LIMIT 1", array($uniID)))
		{
			return Database::query("UPDATE login_security_questions SET question=?, answer=? WHERE uni_id=? LIMIT 1", array($question, $answer, $uniID));
		}
		
		return Database::query("INSERT INTO login_security_questions (uni_id, question, answer) VALUES (?, ?, ?)", array($uniID, $question, $answer));
	}
	
	
/****** Retrieve security question data ******/
	public static function questionData
	(
		$uniID			// <int> The UniID of the user to get the question data for.
	)					// RETURNS <str:str> data of the security question.
	
	// $questionData = AppLoginSec::questionData($uniID);
	{
		return Database::selectOne("SELECT question, answer FROM login_security_questions WHERE uni_id=? LIMIT 1", array($uniID));
	}
	
	
/****** Track a failed login ******/
	public static function loginFailure
	(
		$uniID			// <int> The UniID of the login that failed.
	)					// RETURNS <bool> TRUE if failure was tracked, FALSE on error.
	
	// AppLoginSec::loginFailure($uniID);
	{
		return Database::query("INSERT INTO login_failures (uni_id, ip, fingerprint, date_attempt) VALUES (?, ?, ?, ?)", array($uniID, $_SERVER['REMOTE_ADDR'], Sanitize::safeword($_SERVER['HTTP_USER_AGENT'], ' '), time()));
	}
	
	
/****** Checking number of failed logins ******/
	public static function failedLogins
	(
		$uniID			// <int> The UniID to check number of failed logins for.
	,	$duration = 600	// <int> The duration of time for which to detect failed logins over.
	)					// RETURNS <int> the number of failed logins within the $duration, 0 on error.
	
	// $failedLogins = AppLoginSec::failedLogins($uniID, $duration = 600);
	{
		return (int) Database::selectValue("SELECT COUNT(*) as totalNum FROM login_failures WHERE uni_id=? AND date_attempt > ?", array($uniID, time() - $duration));
	}
	
}

