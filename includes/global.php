<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Load the Social Menu
// require(SYS_PATH . "/controller/includes/social-menu.php");

// UniFaction Dropdown Menu
require(SYS_PATH . "/controller/includes/uni-menu.php");

// Left Panel + Mobile Navigation
WidgetLoader::add("MobilePanel", 10, '
<div class="panel-box">
	<ul class="panel-slots">
		<li class="nav-slot"><a href="' . URL::unn_today() . Me::$slg . '">News<span class="icon-circle-right nav-arrow"></span></a></li>
		<li class="nav-slot"><a href="' . URL::entertainment_unifaction_com() . Me::$slg . '">Entertainment<span class="icon-circle-right nav-arrow"></span></a></li>
		<li class="nav-slot"><a href="' . URL::sports_unifaction_com() . Me::$slg . '">Sports<span class="icon-circle-right nav-arrow"></span></a></li>
		<li class="nav-slot"><a href="' . URL::entertainment_unifaction_com() . '/Gaming' . Me::$slg . '">Gaming<span class="icon-circle-right nav-arrow"></span></a></li>
		<li class="nav-slot"><a href="' . URL::tech_unifaction_com() . Me::$slg . '">Technology<span class="icon-circle-right nav-arrow"></span></a></li>
		<li class="nav-slot"><a href="' . URL::fashion_unifaction_com() . Me::$slg . '">Fashion<span class="icon-circle-right nav-arrow"></span></a></li>
		<li class="nav-slot"><a href="' . URL::design4_today() . Me::$slg . '">Design4<span class="icon-circle-right nav-arrow"></span></a></li>
		<li class="nav-slot"><a href="' . URL::gotrek_today() . Me::$slg . '">GoTrek<span class="icon-circle-right nav-arrow"></span></a></li>
		<li class="nav-slot"><a href="' . URL::thenooch_org() . Me::$slg . '">The Nooch<span class="icon-circle-right nav-arrow"></span></a></li>
		<li class="nav-slot"><a href="' . URL::travel_unifaction_com() . Me::$slg . '">Travel<span class="icon-circle-right nav-arrow"></span></a></li>
		<li class="nav-slot"><a href="' . URL::food_unifaction_com() . Me::$slg . '">Food &amp; Recipes<span class="icon-circle-right nav-arrow"></span></a></li>
		<li class="nav-slot"><a href="' . URL::science_unifaction_com() . Me::$slg . '">Science<span class="icon-circle-right nav-arrow"></span></a></li>
	</ul>
</div>');
