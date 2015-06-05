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
<style>
	.mm-button { background-color:#99dbff; border:solid 1px #79bbff; margin:3px; padding:4px; border-radius:3px; text-align:center; font-weight:bold; }
	.mm-button>a { display:block; }
</style>

<div id="content" style="background:none; padding:2px;">' . Alert::display();

// List of Values to show
$array = array(
		"Universe"			=> URL::unifaction_com()
	,	"Unity"				=> URL::unifaction_social()
	,	"Communities"		=> URL::unifaction_community()
	,	"Hashtags"			=> URL::hashtag_unifaction_com()
	,	"BlogFrog"			=> URL::blogfrog_social()
	,	"UniJoule"			=> URL::unijoule_com()
	,	"Avatar"			=> URL::avatar_unifaction_com()
	,	"UniCreatures"		=> URL::unicreatures_com()
);

// Cycle through the list of links
foreach($array as $keyName => $value)
{
	echo '
	<div class="mm-button"><a href="' . $value . '">' . $keyName . '</a></div>';
}

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");