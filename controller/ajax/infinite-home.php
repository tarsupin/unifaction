<?php

// Make sure the appropriate data is sent
if(!isset($_GET['startPos']))
{
	exit;
}

// Pull the necessary data
$feedData = AppHomeFeed::getFeed((int) $_GET['startPos']);

// Display the Feed
AppHomeFeed::displayFeed($feedData, false, Me::$id);