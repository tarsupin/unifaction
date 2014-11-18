<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Display the Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

// Display the Main Page
echo '
<div id="content">' . Alert::display();


// List of Values to show
$array = array(
		"UniFaction"		=> URL::unifaction_com()
	,	"Dashboard"			=> URL::auth_unifaction_com()
	,	"My Feed"			=> URL::feed_unifaction_com()
	,	"My Uni"			=> URL::unifaction_me()
	,	"Social"			=> URL::unifaction_social()
	,	"FastChat"			=> URL::unifaction_social()
	,	"Hashtags"			=> URL::hashtag_unifaction_com()
	,	"BlogFrog"			=> URL::blogfrog_social()
	,	"UniJoule"			=> URL::unijoule_com()
);

// Cycle through the list of links
foreach($array as $keyName => $value)
{
	echo '
	<div style="display:inline-block; background-color:#dddddd; border:solid 1px #bbbbbb; margin:3px; padding:4px; border-radius:3px; "><a href="' . $value . '">' . $keyName . '</a></div>';
}

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");