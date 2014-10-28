<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

<<<<<<< HEAD
// Prepare Site Modules
if(Me::$loggedIn)
{
	$html = '
	<div class="panel-box" style="position:relative;">
		<div style="display:table-cell; padding:4px 4px 0px 4px;"><img src="' . ProfilePic::image(Me::$id, "medium") . '" /></div>
		<div style="display:table-cell; vertical-align:top; padding:4px 4px 0px 0px;">' . Me::$vals['display_name'] . '<br />@' . Me::$vals['handle'] . '</div>
		<div style="position:absolute; top:50px; right:4px;"><a href="#"><span class="icon-undo"></span> Switch Account</a></div>';
	
	$html .= '
		<ul class="panel-slots" style="border-top:solid 1px #d5f0ef;">';
		
	if($url[0] != "")
	{
		$html .= '
			<li class="nav-slot nav-back"><a href="/">Home<span class="icon-arrow-left nav-arrow"></span></a></li>';
	}
	
	$html .= '
			<li class="nav-slot' . ($url[0] == "user-panel" ? " nav-active" : "") . '"><a href="/user-panel">My User Panel<span class="icon-circle-right nav-arrow"></span></a></li>
			' . (ENVIRONMENT == "local" ? '<li class="nav-slot' . ($url[0] == "test-local" ? " nav-active" : "") . '"><a href="/test-local">Test Page<span class="icon-circle-right nav-arrow"></span></a></li>' : '') . '
		</ul>
	</div>';
	
	// Main Navigation
	WidgetLoader::add("SidePanel", 10, $html);
}

// Main Navigation
WidgetLoader::add("SidePanel", 15, '
=======
// Main Navigation
$html = '
>>>>>>> origin/master
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
<<<<<<< HEAD
</div>');
=======
</div>';

WidgetLoader::add("SidePanel", 10, $html);
>>>>>>> origin/master
