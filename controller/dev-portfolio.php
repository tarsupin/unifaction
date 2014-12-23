<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

echo '
<div id="panel-right"></div>
<div id="content" class="content-open">' . Alert::display();

echo '
<style>
.port-div { margin-bottom:18px; }
.port-header { font-size:1.3em; font-weight:bold; }
</style>

<h1>UniFaction Development Portfolio</h1>

<div class="port-div">
	<div class="port-header"><a href="http://unifaction.com">UniFaction</a> - <a href="http://unifaction.com">http://unifaction.com</a></div>
	UniFaction is a closely integrated multi-site network that hosts multiple sites through a single account.
</div>

<div class="port-div">
	<div class="port-header"><a href="http://entertainment.unifaction.com">Article System</a> - <a href="http://entertainment.unifaction.com">http://entertainment.unifaction.com</a></div>
	This system provides authors with an outlet to create articles. This is one of several article sites, including News, Entertainment, Sports, Tech, Science, Food, and more.
</div>

<div class="port-div">
	<div class="port-header"><a href="http://unifaction.social">Unity</a> - <a href="http://unifaction.social">http://unifaction.social</a></div>
	Unity is a combination of a private and public social network for sharing media content. It also handles all friend associations within the UniFaction network.
</div>

<div class="port-div">
	<div class="port-header"><a href="http://unijoule.com">UniJoule</a> - <a href="http://unijoule.com">http://unijoule.com</a></div>
	UniJoule is a virtual currency payment system that is integrated through all UniFaction sites for simplicity of payments.
</div>

<div class="port-div">
	<div class="port-header"><a href="http://unifaction.community">Communities</a> - <a href="http://unifaction.community">http://unifaction.community</a></div>
	"Communities" are a series of 30+ interconnected forums that are also closely integrated with the Avatar and FastChat systems.
</div>

<div class="port-div">
	<div class="port-header"><a href="http://hashtag.unifaction.com">Hashtags</a> - <a href="http://hashtag.unifaction.com">http://hashtag.unifaction.com</a></div>
	This site collects all related blogs, articles, and comments that are related to a specific hashtag. It then provides a method to filter by the type of media you were searching for, if desired.
</div>

<div class="port-div">
	<div class="port-header"><a href="http://avatar.unifaction.com">Avatar</a> - <a href="http://avatar.unifaction.com">http://avatar.unifaction.com</a></div>
	An image-manipulation site for people to dress up and equip characters for gaming avatars that they can use for games, community discussion, and more.
</div>

<div class="port-div">Others: BlogFrog, UniCreatures, Inbox, Support Systems (such as friend sync, widget sync, fastchat, asset cdn, karma, etc...)
';

/*
FastChat system (accessible through all UniFaction sites) – a chat system that allows real time discussion in public or private conversations.

http://unicreatures.com – An online virtual web game for virtual pets.
http://inbox.unifaction.com – A private inbox / messaging system for all UniFaction users.
http://blogfrog.social – a blogging system (like Tumblr), integrated with UF\'s network.
http://entertainment.unifaction.com – One of several article sites connected with UF\'s network.
Support Systems, including: notification sync, feed sync, messaging sync, friend sync, widget sync, profile picture system, asset CDN, karma system, and more.';
*/

/*
Services we offer:

*/

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
