<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Sanitize & Prepare Data
$_GET['id'] = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Pull the content
$entryData = AppHomeFeed::get($_GET['id']);

// Form Submission
if(Form::submitted("edit-home-content-uni"))
{
	if(!$entryData)
	{
		Alert::saveError("Content Failed", "Unable to process this content.");
	}
	
	// Prepare Values
	$_POST['description'] = Sanitize::safeword($_POST['description']);
	
	FormValidate::url("Article URL", $_POST['url'], 5, 100);
	FormValidate::safeword("Article Title", $_POST['title'], 0, 72);
	FormValidate::safeword("Article Description", $_POST['description'], 10, 250);
	
	if(FormValidate::pass())
	{
		// Update the content
		if(Database::query("UPDATE home_content SET url=?, title=?, description=? WHERE id=? LIMIT 1", array($_POST['url'], $_POST['title'], $_POST['description'], $entryData['id'])))
		{
			Alert::saveSuccess("Updated Content", "You have updated the home page content entry.");
			
			$entryData = AppHomeFeed::get($entryData['id']);
		}
		else
		{
			Alert::saveError("Content Failed", "An error occurred while trying to update this entry.");
		}
	}
}

// Run Header
require(SYS_PATH . "/controller/includes/admin_header.php");

// Show the list of entries that are available for editing
if(!$entryData)
{
	$allContent = Database::selectMultiple("SELECT * FROM home_content ORDER BY date_posted DESC LIMIT 0, 20", array());
	
	echo '
	<div style="padding-bottom:22px; font-weight:bold; color:#ff6666;">Click on the entry that you want to edit or add to the home page.</div>';
	
	foreach($allContent as $content)
	{
		echo '
		<div style="overflow:hidden;">
			<div style="float:left; width:200px;">
				<a href="/admin/AppHomeFeed/Edit Home Content?id=' . $content['id'] . '"><img src="' . $content['thumbnail'] . '" style="width:100%;" /></a>
			</div>
			<div style="margin-left:210px;">
				<strong>' . $content['title'] . '</strong><br />' . $content['description'] . '
			</div>
		</div>';
	}
}

// Display the Editing Form
else
{
	echo '
	<h3>Manage the Home Page Content</h3>
	<form class="uniform" action="/admin/AppHomeFeed/Edit Home Content?id=' . $entryData['id'] . '" method="post">' . Form::prepare("edit-home-content-uni") . '
	
	<p>
		<strong>Image:</strong><br />
		<img src="' . $entryData['thumbnail'] . '" style="width:50%;">
	</p>
	
	<p>
		<strong>URL:</strong><br />
		<input type="text" name="url" value="' . $entryData['url'] . '" style="width:90%;" maxlength="100" />
	</p>
	
	<p>
		<strong>Title:</strong><br />
		<input type="text" name="title" value="' . $entryData['title'] . '" style="width:90%;" maxlength="72" />
	</p>
	
	<p>
		<strong>Full Description:</strong><br />
		<textarea maxlength="250" style="height:100px; width:90%;" name="description">' . $entryData['description'] . '</textarea>
	</p>
	
	<p><input type="submit" name="submit" value="Update" /></p>
	</form>';
}

// Display the Footer
require(SYS_PATH . "/controller/includes/admin_footer.php");
