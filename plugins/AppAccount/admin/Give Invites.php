<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Prepare Values
$_POST['handle'] = isset($_POST['handle']) ? Sanitize::variable($_POST['handle']) : "";
$_POST['invite_level'] = isset($_POST['invite_level']) ? (int) $_POST['invite_level'] : 1;
$_POST['invite_count'] = isset($_POST['invite_count']) ? (int) $_POST['invite_count'] : 1;

// Form Submission
if(Form::submitted("grant-invites-u6"))
{
	// Check if the user is legitimate
	if($userData = User::getDataByHandle($_POST['handle'], "uni_id"))
	{
		$uniID = (int) $userData['uni_id'];
	}
	else
	{
		Alert::error("Invalid User", "That user could not be found.");
	}
	
	// Final Validation Test
	if(FormValidate::pass())
	{
		AppAccount::createInvitationCode($uniID, $_POST['invite_level'], $_POST['invite_count']);
		
		Alert::success("Invites Created", "You have successfully created invites for that user.");
	}
}

// Run Header
require(SYS_PATH . "/controller/includes/admin_header.php");

// Display the Editing Form
echo '
<h3>Grant Invites to User</h3>
<form class="uniform" action="/admin/AppAccount/Give Invites" method="post">' . Form::prepare("grant-invites-u6") . '

<p>
	<strong>User\'s Handle:</strong><br />
	<input type="text" name="handle" value="' . $_POST['handle'] . '" style="width:95%;" maxlength="22" />
</p>

<p>
	<strong>Invite Type:</strong><br />
	<select name="invite_level">' . str_replace('value="' . $_POST['invite_level'] . '"', 'value="' . $_POST['invite_level'] . '" selected', '
		<option value="1">Basic Invitation</option>
		<option value="3">User gets invited, plus three new invites</option>
		<option value="5">User gets a VIP handle, plus five new invites</option>
	</select>') . '
</p>

<p>
	<strong>Number of Invites:</strong><br />
	<input type="text" name="invite_count" value="' . $_POST['invite_count'] . '" style="width:95%;" maxlength="3" />
</p>

<p><input type="submit" name="submit" value="Grant Invites to User" /></p>
</form>';

// Display the Footer
require(SYS_PATH . "/controller/includes/admin_footer.php");
