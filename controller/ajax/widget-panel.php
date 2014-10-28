<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Prepare the Featured Widget Data
$hashtag = "";
$categories = array("articles", "people");

// Create a new featured content widget
$featuredWidget = new FeaturedWidget($hashtag, $categories);

// If you want to display the FeaturedWidget by itself:
echo $featuredWidget->get();


<<<<<<< HEAD
=======

>>>>>>> origin/master
// Prepare the Trending Widget Data
$trendingCount = 6;

// Create a new widget
$trendingWidget = new TrendingWidget($trendingCount);

// If you want to display the widget by itself:
echo $trendingWidget->get();