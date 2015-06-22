<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

/****** Page Configuration ******/
$config['canonical'] = "/";
$config['pageTitle'] = "UniFaction";		// Up to 70 characters. Use keywords.
$config['description'] = "All of your online interests with one login.";	// Overwrites engine: <160 char
Metadata::$index = true;
Metadata::$follow = true;

// Run Global Script
require(CONF_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Display Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

echo '
<style>
	#content { background:none; position:relative; background-size:contain; background-repeat:no-repeat; padding:0px; }
	@media screen and (min-width:901px) { #content { background-image:url(/assets/img/header_large.png); } }
	@media screen and (min-width:451px) and (max-width:900px) { #content { background-image:url(/assets/img/header_medium.png); } }
	@media screen and (max-width:450px) { #content { background-image:url(/assets/img/header_small.png); } }
	.table { display:table; border-collapse:separate; border-spacing:12px; width:100%; }
	.transparent { background-color:rgba(255,255,255,0.5); padding:12px; margin-bottom:12px; }
	.row { display:table-row; }
	.left, .right { display:table-cell; text-align:center; }
	@media screen and (min-width:601px) { .left { width:50%; } }
	@media screen and (max-width:600px) { .left, .right { display:block; } .row { display:block; } }
</style>
<div id="panel-right"></div>
<div id="content">' . Alert::display() . '
	<div class="transparent">
		<h2>Welcome to UniFaction!</h2>
		<p>UniFaction is an online community of friends, family, and complete strangers. If you\'re excited to share your experiences in life, talk with friendly people, or just enjoy building up some avatars and playing fun games, you\'ll fit right in.</p>
		<p>Our staff makes sure that the environment here is much more pleasant and enjoyable than other places, so you won\'t run into a lot of the bitterness you\'ll find elsewhere. This site is safe, well-maintained and has a very welcoming userbase. We hope you enjoy it!</p>
		<p>UniFaction\'s various sites are connected, so you can log into all of them with only one account. Below we\'ll give a short introduction to some of our main features.</p>
	</div>
	<div class="table">
		<div class="row">
			<div class="transparent left">
				<h4><span class="icon-group"></span> Unity</h4>
				<p>under construction</p>
			</div>
			<div class="transparent right">
				<h4><span class="icon-earth"></span> Community</h4>
				<p>under construction</p>
			</div>
		</div>
		<div class="row">
			<div class="transparent left">
				<h4><span class="icon-envelope"></span> Inbox</h4>
				<p>under construction</p>
			</div>
			<div class="transparent right">
				<h4><span class="icon-comments"></span> Friends & Chat</h4>
				<p>under construction</p>
			</div>
		</div>
		<div class="row">
			<div class="transparent left">
				<h4><span class="icon-coin"></span> UniJoule</h4>
				<p>under construction</p>
			</div>
			<div class="transparent right">
				<h4><span class="icon-signup"></span> Karma</h4>
				<p>under construction</p>
			</div>
		</div>
		<div class="row">
			<div class="transparent left">
				<h4><span class="icon-user"></span> Avatar</h4>
				<p>under construction</p>
			</div>
			<div class="transparent right">
				<h4><span class="icon-gamepad"></span> UniCreatures</h4>
				<p>under construction</p>
			</div>
		</div>
	</div>
</div>';

// Display the Footer
$imagesF = Dir::getFiles(APP_PATH . '/assets/img/slide-f');
foreach($imagesF as $key => $val)
	$imagesF[$key] = '/assets/img/slide-f/' . $val;
shuffle($imagesF);
$imagesM = Dir::getFiles(APP_PATH . '/assets/img/slide-m');
foreach($imagesM as $key => $val)
	$imagesM[$key] = '/assets/img/slide-m/' . $val;
shuffle($imagesM);
$images = array("m" => $imagesM, "f" => $imagesF);
echo '
<script>var slideSrc = ' . json_encode($images) . ';</script>';
Metadata::addFooter('<script src="/assets/scripts/slideshow.js"></script>');
require(SYS_PATH . "/controller/includes/footer.php");
