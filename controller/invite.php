<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Make sure there is an invitation link
if(!isset($url[1]))
{
	header("Location: /"); exit;
}

// Get the Invitation Data
if(!$inviteData = AppAccount::getInviteData($url[1]))
{
	Alert::saveError("Invalid Code", "That invitation code is invalid.");
	
	header("Location: /"); exit;
}

// Make sure the invite has not been redeemed already
if($inviteData['redeemed_by'])
{
	Alert::saveError("Invalid Code", "That invitation code has already been redeemed.");
	
	header("Location: /"); exit;
}

// Set the Invite Code Session
$_SESSION[SITE_HANDLE]['invite-code'] = $inviteData['invite_code'];
$_SESSION[SITE_HANDLE]['invite-level'] = $inviteData['invite_level'];

Alert::saveSuccess("Invite Code", "You have been invited to join UniFaction!");

// Return to Home
header("Location: /register"); exit;