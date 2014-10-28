<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/****** Page Configuration ******/
$config['canonical'] = "/";
$config['pageTitle'] = "UniFaction";		// Up to 70 characters. Use keywords.
Metadata::$index = false;
Metadata::$follow = true;

// Run Global Script
require(APP_PATH . "/includes/global.php");

/****** Display Header ******/
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Eliminate the side panel
require(SYS_PATH . "/controller/includes/side-panel-core-only.php");

// Styling for this page
echo '
<style>
	
	#content { padding:0px; background-color:transparent; }
	
	/****** Navigation Bar ******/
	#topuninav li { background-color:#dddddd; border:solid 1px #bbbbbb; border-radius:3px; height:32px; margin-bottom:10px; }
	#topuninav li { display:inline-block; list-style-type:none; height:32px; vertical-align:middle; line-height:32px; overflow:hidden; }
	#topuninav li a { display:block; text-align:center; padding-left:6px; padding-right:6px; color:#3BA3A1; font-weight:bold; }
	#topuninav li a:hover { background-color:white; }
	
	@media screen and (max-width:499px) {
		#topuninav li { display:inline-block; list-style-type:none; height:32px; vertical-align:middle; line-height:32px; width:31.5% }
		#topuninav li a { font-size:0.9em; }
	}
	
	/****** Main Headers ******/
	@media screen and (min-width:900px) {
		.uni-main { float:left; width:69.9%; }
		.uni-main-side { float:right; width:29.35%; }
		.uni-main-tri { float:left; width:50%; }
	}
	
	/****** Mobile Hiding ******/
	@media screen and (max-width:599px) {
		.uni-hidden { display:none !important; }
	}
	
</style>';

// Display the top header
echo '
<div id="top-uni-bar" style="padding:3px; margin:0 auto 0 auto;">
	<ul id="topuninav">
		<li><a href="' . URL::unn_today() . '">News</a></li>
		<li><a href="' . URL::entertainment_unifaction_com() . '">Entertainment</a></li>
		<li><a href="' . URL::sports_unifaction_com() . '">Sports</a></li>
		<li><a href="' . URL::entertainment_unifaction_com() . '/Gaming">Gaming</a></li>
		<li><a href="' . URL::tech_unifaction_com() . '">Tech</a></li>
		<li><a href="' . URL::fashion_unifaction_com() . '">Fashion</a></li>
		<li><a href="' . URL::design4_today() . '">Design4</a></li>
		<li><a href="' . URL::gotrek_today() . '">GoTrek</a></li>
		<li><a href="' . URL::thenooch_org() . '">The Nooch</a></li>
		
		<li><a href="' . URL::travel_unifaction_com() . '">Travel</a></li>
		<li><a href="' . URL::recipes_unifaction_com() . '">Recipes</a></li>
		<li><a href="' . URL::science_unifaction_com() . '">Science</a></li>
		<li><a href="#">More . . .</a></li>
	</ul>
</div>';

/*
		<li class="uni-hidden"><a href="' . URL::science_unifaction_com() . '">Science</a></li>
		
echo '
		<!-- Tech -->
		<li><a href="#">DIY</a></li>
		<li class="uni-hidden"><a href="' . URL::gotrek_com() . '/travel">Travel</a></li>
		<li class="uni-hidden"><a href="#">Art &amp; Photography</a></li>
		<li class="uni-hidden"><a href="#">Auto</a></li>';
*/

// Display Main Page
echo '
<div id="panel-right"></div>
<div id="content" style="overflow:hidden;">';

// Pull the necessary data
$content = Database::selectMultiple("SELECT * FROM home_page_content WHERE slot <= ? ORDER BY slot ASC", array(7));

// Display the main section
echo '
<div style="width:100%;">
	<div style="clear:both; float:left; width:70.3%;">
		<div><img src="' . $content[0]['image_url'] . '" style="width:100%; height:100%;" /></div>
		<div style="height:25px; overflow:hidden; font-size:0.9em; font-weight:bold;">' . $content[0]['short_blurb'] . '</div>
	</div>
	<div style="float:left; width:29.7%;">
		<div style="margin-left:12px;">
			<img src="' . $content[1]['image_url'] . '" style="width:100%; height:100%;" />
			<div style="height:48px; overflow:hidden; font-size:0.9em; font-weight:bold;">' . $content[1]['short_blurb'] . '</div>
		</div>
		<div style="margin-left:12px;">
			<img src="' . $content[2]['image_url'] . '" style="width:100%; height:100%;" />
			<div style="height:48px; overflow:hidden; font-size:0.9em; font-weight:bold;">' . $content[2]['short_blurb'] . '</div>
		</div>
	</div>
</div>';

// Cycle through each of the remaining content entries
for($i = 3;$i <= 7;$i++)
{
	// If we don't have an entry, break from the loop
	if(!isset($content[$i]))
	{
		break;
	}
	
	// Display the entry
	echo '
	<div style="clear:both; padding-top:8px;">
		<div style="float:left; width:40%;">
			<div style="overflow:hidden; margin-right:12px;"><img src="' . $content[$i]['image_url'] . '" style="width:100%; height:100%;" /></div>
		</div>
		<div style="float:left; width:60%;">
			<div><h3>' . $content[$i]['title'] . '</h3><p>' . $content[$i]['description'] . '</div>
		</div>
	</div>';
}

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");