<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Require Login
if(!Me::$loggedIn)
{
	Me::redirectLogin("/my-invites", "/");
}

/****** Page Configuration ******/
$config['canonical'] = "/my-invites";
$config['pageTitle'] = "My Invitations - UniFaction";		// Up to 70 characters. Use keywords.
Metadata::$index = false;
Metadata::$follow = false;
// Metadata::openGraph($title, $image, $url, $desc, $type);		// Title = up to 95 chars.

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");


/****** Run Content ******/
echo '
<div id="panel-right"></div>
<div id="content">' . Alert::display();

echo'
<h2>My Invitations</h2>
<p>This a list of your available invitation links that you can use to invite others to UniFaction.</p>';

$inviteList = AppAccount::getUserInviteList(Me::$id);

foreach($inviteList as $invite)
{
	echo '
	<div style="margin-bottom:12px;">';
	
	if($invite['redeemed_by'])
	{
		echo '<div style="color:red">Already Redeemed</div>';
	}
	else
	{
		echo '<div style="color:green">Invitation Link Available';
		
		// Display Invitation Level
		$invite['invite_level'] = (int) $invite['invite_level'];
		
		switch($invite['invite_level'])
		{
			case 1:
			case 2:
				echo " - Standard Invite";
				break;
			
			case 3:
			case 4:
				echo " - Boosted Invite";
				break;
			
			case 5:
			case 6:
				echo " - VIP Invite";
				break;
		}
		
		echo '</div>';
	}
	
	echo '<input type="text" value="' . URL::unifaction_com() . "/invite/" . $invite['invite_code'] . '" readonly style="width:95%;" />';
	
	echo '
	</div>';
}

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");