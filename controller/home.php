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

if(Me::$loggedIn)
{
	if(!isset($_GET['unifeed']))
	{
		// Prepare the packet
		$packet = array(
			"uni_id"			=> Me::$id		// The UniID to send a feed to.
		,	"page"				=> 1			// The page to return.
		,	"num_results"		=> 30			// The number of results to return.
		);
		
		$feedData = Connect::to("sync_feed", "MyFeedAPI", $packet);
		
		// Sort the data by newest results
		krsort($feedData);
		
		echo '
		<div style="display:inline-block; border:solid 1px #c0c0c0; padding:2px 8px 2px 8px;"><a href="javascript:void(0);">My Feed</a></div>
		<div style="display:inline-block;"><a href="/?unifeed=1" style="display:block; padding:2px 8px 2px 8px;">UniFaction Feed</a></div>';
	}
	else
	{
		echo '
		<div style="display:inline-block;"><a href="/" style="display:block; padding:2px 8px 2px 8px;">My Feed</a></div>
		<div style="display:inline-block; border:solid 1px #c0c0c0; padding:2px 8px 2px 8px;"><a href="javascript:void(0);">UniFaction Feed</a></div>';
	}
}

AppHomeFeed::displayFeed($feedData, false, Me::$id);

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
