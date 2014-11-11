<?php

/****** Preparation ******/
define("CONF_PATH",		dirname(__FILE__));
define("SYS_PATH", 		dirname(CONF_PATH) . "/system");

// Load phpTesla
require(SYS_PATH . "/phpTesla.php");

// Initialize and Test Active User's Behavior
Me::$getColumns = "uni_id, role, clearance, handle, display_name";

Me::initialize();

if(isset($_GET['u6access']))
{
	$_SESSION['u6access'] = true;
}

if(time() < 1415747471 and !isset($_SESSION['u6access']) and $url[0] != "ajax")
{
	die("Welcome! UniFaction will be officially available " . Time::fuzzy(1415747471) . "! (Tuesday, November 11th).");
}

// Determine which page you should point to, then load it
require(SYS_PATH . "/routes.php");


/****** Dynamic URLs ******/
// If a page hasn't loaded yet, check if there is a dynamic load
/*
if($url[0] != '')
{
	if(!$userData = User::getDataByHandle($url[0], "uni_id, display_name, handle"))
	{
		$userData = User::silentRegister($url[0]);
	}
	
	if($userData)
	{
		// Prepare "You"
		You::$id = $userData['uni_id'];
		You::$name = $userData['display_name'];
		You::$handle = $userData['handle'];
		
		require(APP_PATH . '/controller/chat.php'); exit;
	}
}
//*/

/****** 404 Page ******/
// If the routes.php file or dynamic URLs didn't load a page (and thus exit the scripts), run a 404 page.
require(SYS_PATH . "/controller/404.php");