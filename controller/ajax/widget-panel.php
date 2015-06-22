<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Get the active hashtag for this page
$activeHashtag = isset($_POST['activeHashtag']) ? Sanitize::variable($_POST['activeHashtag']) : '';

// Prepare the Featured Widget Data
$categories = array("articles", "people");

// Create a new featured content widget
//$featuredWidget = new FeaturedWidget($activeHashtag, $categories);

// If you want to display the FeaturedWidget by itself:
//echo $featuredWidget->get();



// Display a Chat Widget
if($activeHashtag)
{
	$chatWidget = new ChatWidget($activeHashtag);
	echo $chatWidget->get();
}

// JS doesn't activate in the widget panel, so this is not the usual way to include a FB plugin.
echo '
<iframe src="http://www.facebook.com/v2.3/plugins/page.php?container_width=300&hide_cover=true&href=' . urlencode('https://www.facebook.com/unifaction') . '&locale=en_US&show_facepile=false&show_posts=true&small_header=true" style="border: none; width: 300px; height: 500px; overflow: hidden;" scrolling="no"></iframe>';


// Prepare the Trending Widget Data
//$trendingCount = 6;

// Create a new widget
//$trendingWidget = new TrendingWidget($trendingCount);

// If you want to display the widget by itself:
//echo $trendingWidget->get();