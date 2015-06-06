<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/****** Page Configuration ******/
$config['canonical'] = "/";
$config['pageTitle'] = "UniFaction";		// Up to 70 characters. Use keywords.
$config['description'] = "All of your online interests with one login.";	// Overwrites engine: <160 char
Metadata::$index = true;
Metadata::$follow = true;

// Run Global Script
require(CONF_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Display Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

echo '
<div id="panel-right"></div>
<div id="content">' . Alert::display() . '
<h1>Welcome to UniFaction!</h1>
This page is currently under construction. While we\'re working on it, please take a look around the site using the links on the left. There\'s a lot to discover! :)';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
