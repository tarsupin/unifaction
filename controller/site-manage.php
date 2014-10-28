<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// If you don't have a site selected, leave this page
if(!isset($_GET['site']))
{
	header("Location: /"); exit;
}

// Prepare Values
$siteHandle = Sanitize::variable($_GET['site']);

// If you're not logged in, leave this page
if(!Me::$loggedIn)
{
	Me::redirectLogin("/site-manage?site=" . $siteHandle);
}

// If you're not the owner of this site, leave the page
$ownerID = AppNetwork::siteUniID($_POST['site_handle']);

if($ownerID != Me::$id)
{
	Alert::saveError("Site Ownership", "Only the registered owner of a site can manage it.", 10);
	
	header("Location: /"); exit;
}

// Get Site Data
$siteData = Network::get($siteHandle);
$siteInfo = AppNetwork::get($siteHandle);

// Sanitized Values
$_POST['category'] = isset($_POST['category']) ? Sanitize::variable($_POST['category']) : $siteInfo['category'];
$_POST['subcategory'] = isset($_POST['subcategory']) ? Sanitize::variable($_POST['subcategory']) : $siteInfo['subcategory'];
$_POST['description'] = isset($_POST['description']) ? Sanitize::safeword($_POST['description']) : $siteInfo['description'];
$_POST['keywords'] = isset($_POST['keywords']) ? Sanitize::safeword($_POST['keywords']) : $siteInfo['keywords'];

$_POST['country'] = isset($_POST['country']) ? Sanitize::variable($_POST['country']) : $siteInfo['country'];
$_POST['state'] = isset($_POST['state']) ? Sanitize::variable($_POST['state']) : $siteInfo['state'];
$_POST['city'] = isset($_POST['city']) ? Sanitize::variable($_POST['city']) : $siteInfo['city'];
$_POST['zipcode'] = isset($_POST['zipcode']) ? Sanitize::variable($_POST['zipcode']) : $siteInfo['zipcode'];

$_POST['contact_name'] = isset($_POST['contact_name']) ? Sanitize::variable($_POST['contact_name']) : $siteInfo['contact_name'];
$_POST['phone'] = isset($_POST['phone']) ? Sanitize::variable($_POST['phone']) : $siteInfo['phone'];

// Check the form submission
if(Form::submitted("uni6-manage-site"))
{
	// Check if all of the input you sent is valid: 
	FormValidate::variable("Site Name", $_POST['site_name'], 3, 48, " -:',+");
	FormValidate::url("URL", $_POST['site_url'], 3, 48);
	
	// Parse the URL input to get the ['full'] value.
	$siteURL = URL::parse($_POST['site_url']);
	
	// Now check if the form has passed
	if(FormValidate::pass())
	{
		AppNetwork::set($siteHandle, $ownerID, $_POST['category'], $_POST['subcategory'], $_POST['description'], $_POST['keywords'], $_POST['contact_name'], $_POST['phone'], $_POST['country'], $_POST['state'], $_POST['city'], $_POST['zipcode']);
	}
}
else
{
	// Sanitize User Input
	$_POST['site_name'] = isset($_POST['site_name']) ? Sanitize::variable($_POST['site_name'], " -:',+") : "";
	$_POST['site_url'] = isset($_POST['site_url']) ? Sanitize::url($_POST['site_url']) : "";
}


/****** Page Configuration ******/
$config['pageTitle'] = "Site Management";		// Up to 70 characters. Use keywords.

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Display Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

// Display the Page
echo '
<div id="content">
' . Alert::display() . '

<h2>Manage Site</h2>

<form class="uniform" action="/site-manage?site=' . $siteHandle . '" method="post">' . Form::prepare("uni6-manage-site") . '

	<h3>Main Site Settings</h3>
	<p><input type="text" name="site_handle_disabled" value="' . $siteHandle . '" disabled /></p>
	<p><input type="text" name="site_name" value="' . $siteData['site_name'] . '" placeholder="Name of Site" autocomplete="off" /></p>
	<p><input type="text" name="site_url" value="' . $siteData['site_url'] . '" placeholder="Site URL" autocomplete="off" /></p>
	
	<h3>Improved Audience Targeting &amp; Search Engine Results (optional)</h3>
	<p>Note: This step isn\'t required, but information provided here will help the appropriate audiences find your site, as well as improve search engine results. In other words, it will help improve the quality and quantity of traffic to your site.</p>
	
	<p>
		<select name="category">' . str_replace('value="' . $_POST['category'] . '"', 'value="' . $_POST['category'] . '" selected', '
			<option value="">-- Select a Category --</option>
			<option value="academics">Academics</option>
			<option value="business">Business</option>
			<option value="community">Community</option>
			<option value="entertainment">Entertainment</option>
			<option value="gaming">Gaming</option>
			<option value="humor">Humor</option>
			<option value="miscellaneous">Miscellaneous</option>
			<option value="news">News</option>
			<option value="politics">Politics</option>
			<option value="science">Science</option>
			<option value="sports">Sports</option>
			<option value="technology">Technology</option>') . '
		</select>
	</p>
	
	<p><input type="text" name="subcategory" value="' . $_POST['subcategory'] . '" placeholder="Subcategory" autocomplete="off" /></p>
	<p>Brief Description of Site (max of 200 characters):<br /><textarea name="description" style="height: 80px; width:95%;" maxlength="200">' . $_POST['description'] . '</textarea></p>
	<p>Keywords (separate by commas):<br /><input type="text" name="keywords" value="' . $_POST['keywords'] . '" style="width:95%;" maxlength="120" /></p>
	
	<h4>Location of Organization (if applicable)</h4>
	<p>Country: <input type="text" name="country" value="' . $_POST['country'] . '" /></p>
	<p>State or Province: <input type="text" name="state" value="' . $_POST['state'] . '" /></p>
	<p>City: <input type="text" name="city" value="' . $_POST['city'] . '" /></p>
	<p>Zip or Area Code: <input type="text" name="zipcode" value="' . $_POST['zipcode'] . '" /></p>
	
	<h4>Contact Details</h4>
	<p>Note: The contact details won\'t help with search results - these values are only so you can prove ownership of a site in case you lose the necessary identification.</p>
	<p>Contact Name: <input type="text" name="contact_name" value="' . $_POST['contact_name'] . '" /></p>
	<p>Phone Number: <input type="text" name="phone" value="' . $_POST['phone'] . '" /></p>
	
	<p><input type="submit" name="submit" value="Update Site Settings" /></p>
</form>
';

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
