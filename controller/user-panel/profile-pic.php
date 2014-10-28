<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

if(!Me::$id)
{
	header("Location: /"); exit;
}

// Submit the Image to the API
if(Form::submitted("auth-avi-upload") && isset($_FILES['image']))
{
	if($_FILES['image']['tmp_name'] != "")
	{
		if(AppProfilePic::upload(You::$id, $_FILES['image']['tmp_name']))
		{
			Alert::success("Profile Pic Updated", "Your profile picture has been updated!");
		}
		else
		{
			Alert::error("Profile Pic Error", "An error has occurred while trying to upload this profile picture.");
		}
	}
}

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

echo '
<div id="panel-right"></div>
<div id="content">' . Alert::display();

// Display the Page
echo '
<h3>Update Your Profile Picture</h3>
<div style="text-align:center;width:200px;">
	<img src="' . ProfilePic::image(You::$id, "large") . '?' . time() . '" />
</div>';

// Prepare the Form
echo '
<div style="padding-top:32px;">
	<form class="uniform" action="/user-panel/profile-pic" method="post" enctype="multipart/form-data">' . Form::prepare("auth-avi-upload") . '
		<input type="file" name="image" />
		<br /><br />
		<input type="submit" name="submit" value="Update Profile Picture" />
	</form>
</div>';

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");