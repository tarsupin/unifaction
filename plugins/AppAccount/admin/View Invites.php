<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }


if($link = Link::clicked())
{
	if($link == "admin-invite-flair")
	{		
		// Prepare the Packet
		$packet = array(
			"uni_id"		=> (int) $_GET['user']
		,	"site_handle"	=> ""
		,	"title"			=> $_GET['grant']
		,	"add_time"		=> 0
		);
		
		// Connect to this API from UniFaction
		$user = User::get((int) $_GET['user'], "handle");
		if($success = Connect::to("karma", "GrantFlairAPI", $packet))
		{
			Alert::success("Flair Added", $user['handle'] . " has received the " . $_GET['grant'] . " Flair!");
		}
		else
		{
			Alert::error("Flair Not Added", "An error occurred. " . $user['handle'] . " has not received the " . $_GET['grant'] . " Flair.");
		}
	}
}

// Run Header
require(SYS_PATH . "/controller/includes/admin_header.php");

// Display the Editing Form
echo '
<h3>View Redeemed Invites</h3>';

$byuser = array();
$redeemed = Database::selectMultiple("SELECT i.uni_id, redeemed_by, u.handle FROM invitation_codes i INNER JOIN users u ON i.uni_id=u.uni_id WHERE redeemed_by!=?", array(0));
foreach($redeemed as $r)
{
	$byuser[$r['uni_id']][] = $r['redeemed_by'];
	$byuser[$r['uni_id']]['handle'] = $r['handle'];
}

echo '
<style>
	table { border-right:solid 1px #e2e2e1; width:100%; text-align:left; }
	tr { }
	th { border-left:solid 1px #e2e2e1; color:white; background-color:#57c2c1; padding:6px 10px 6px 12px; }
	td { border-left:solid 1px #e2e2e1; color:#263a54; padding:6px 10px 6px 12px; }
	tr:nth-child(odd) { background-color:#f8f8f7; }
	tr td:nth-child(4) { font-size:0.8em; }
</style>
<table>
	<tr>
		<th>User</th>
		<th>Grant Flair</th>
		<th>Count</th>
		<th>Invited Users</th>
	</tr>';
foreach($byuser as $key => $b)
{
	echo '
	<tr>
		<td><a href="' . URL::karma_unifaction_com() . '/' . $b['handle'] . '">' . $b['handle'] . '</a></td>';
	unset($b['handle']);
	$flair = "Friendly";
	if(count($b) >= 3) $flair = "Charismatic";
	if(count($b) >= 10) $flair = "Charming";
	if(count($b) >= 25) $flair = "Life of the Party";
	echo '
		<td><a href="/admin/AppAccount/View Invites?user=' . $key . '&grant=' . $flair . '&' . Link::prepare("admin-invite-flair") . '">' . $flair . '</a></td>
		<td>' . count($b) . '</td>
		<td>';
	$invited = array();
	foreach($b as $i)
	{
		$user = User::get((int) $i, "handle");
		$invited[] = '<a href="' . URL::unifaction_social() . '/' . $user['handle'] . '">' . $user['handle'] . '</a>';
	}
	echo implode(", ", $invited) . '
		</td>
	</tr>';
}
echo '
</table>';

// Display the Footer
require(SYS_PATH . "/controller/includes/admin_footer.php");
