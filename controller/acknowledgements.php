<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/****** Page Configuration ******/
$config['canonical'] = "/acknowledgements";
$config['pageTitle'] = "Acknowledgements and Special Thanks";		// Up to 70 characters. Use keywords.

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
	
	<h3>Acknowledgements and Special Thanks</h3>
	
	<p>
		<strong>icomoon.com</strong><br />
		icomoon.com provided many of the icons used on this site.
	</p>
	
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");