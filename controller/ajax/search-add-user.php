<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Prepare a response
header('Access-Control-Allow-Origin: *');

$search = (isset($_POST['search']) ? Sanitize::variable($_POST['search']) : "");
$socialURL = URL::unifaction_social();

// Gather the results for this search
$handles = Database::selectMultiple("SELECT handle FROM users_handles WHERE handle LIKE ? ORDER BY uni_id LIMIT 5", array($search . "%"));

echo '
<ul>';

foreach($handles as $handle)
{
	echo '
	<li><a class="searchSel" href="' . $socialURL . "/friends/send-request?handle=" . $handle['handle'] . '">@' . $handle['handle'] .  '</a></li>';
}

echo '</ul>';