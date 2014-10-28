<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Sanitize & Prepare Data
$_POST['home_url'] = isset($_POST['home_url']) ? Sanitize::url($_POST['home_url']) : "";

// Form Submission
if(Form::submitted("retrieve-article-uni"))
{
	FormValidate::url("Article URL", $_POST['home_url'], 5, 85);
	
	if(FormValidate::pass())
	{
		if(AppHomeFeed::pullArticleFromURL($_POST['home_url']))
		{
			Alert::saveSuccess("Pull Succeeded", "You have successfully added an article to the home page.");
			
			header("Location: /admin/AppHomeFeed"); exit;
		}
		else
		{
			Alert::saveError("Pull Failed", "The system was unable to scrape data from the URL you requested.");
		}
	}
}

// Run Header
require(SYS_PATH . "/controller/includes/admin_header.php");

// Display the Lookup Form
echo '
<h3>Retrieve Article Data for the Home Page</h3>
<form class="uniform" action="/admin/AppHomeFeed/Retrieve Articles" method="post">' . Form::prepare("retrieve-article-uni") . '
	<p>
		<strong>Enter the URL of the article that you want to post:</strong>
		<div style="margin-top:4px;"><input type="text" name="home_url" value="' . htmlspecialchars($_POST['home_url']) . '" maxlength="85" size="85" tabindex="20" /></div>
	</p>
	<p><input type="submit" name="submit" value="Pull Article Data from URL" /></p>
</form>';

// Display the Footer
require(SYS_PATH . "/controller/includes/admin_footer.php");
