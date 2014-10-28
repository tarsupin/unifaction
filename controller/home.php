<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/****** Page Configuration ******/
$config['canonical'] = "/";
$config['pageTitle'] = "UniFaction";		// Up to 70 characters. Use keywords.
$config['description'] = "All of your online interests with one login.";	// Overwrites engine: <160 char
Metadata::$index = false;
Metadata::$follow = true;
// Metadata::openGraph($title, $image, $url, $desc, $type);		// Title = up to 95 chars.

// Pull the necessary data
$feedData = AppHomeFeed::getFeed();

// Prepare Header Handling
Photo::prepareResponsivePage();

Metadata::addHeader('<link rel="stylesheet" href="' . CDN . '/css/content-system.css" /><script src="' . CDN . '/scripts/content-system.js"></script>');

// Run Global Script
require(CONF_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Display Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

echo '
<div id="panel-right"></div>
<div id="content">' . Alert::display();

AppHomeFeed::displayFeed($feedData, false, Me::$id);

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
