<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/****** Page Configuration ******/
$config['canonical'] = "/faqs";
$config['pageTitle'] = "Frequently Asked Questions";		// Up to 70 characters. Use keywords.
Metadata::$index = true;

// Run Global Script
require(APP_PATH . "/includes/global.php");

/****** Display Header ******/
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

require(SYS_PATH . "/controller/includes/side-panel.php");

/****** Run Content ******/
echo '
<!-- Content -->
<div id="content">
	
	<h3>Frequently Asked Questions</h3>
	<p>This is our FAQ page. It should probably be updated...</p>
	
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");