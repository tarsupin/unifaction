<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Cannot be logged in
if(Me::$loggedIn)
{
	header("Location: /"); exit;
}

// Check if you're supposed to be on this page
if(!isset($_SESSION[SITE_HANDLE]['auth-login']))
{
	header("Location: /"); exit;
}

// Get the Security Question
$questionData = AppLoginSec::questionData($_SESSION[SITE_HANDLE]['auth-login']['uni_id']);

// Check the form submissions
if(Form::submitted("auth-login-second-uni"))
{
	$_SESSION[SITE_HANDLE]['auth-login']['answer'] = ((strtolower($_POST['answer']) == strtolower($questionData['answer'])) ? true : false);
	
	header("Location: /login-auth"); exit;
}

// Sanitize Data
$_POST['answer'] = isset($_POST['answer']) ? strtolower(Sanitize::safeword($_POST['answer'], " ")) : "";

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Display Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");


// Display the Page
echo '
<div id="content">' . Alert::display() . '

<h2>Answer Security Question</h2>
<p>This account has a security question associated with it.</p>
<p><strong>' . $questionData['question'] . '</strong></p>

<form class="uniform" action="/login-auth/security-question" method="post">' . Form::prepare("auth-login-second-uni") . '
	<p><input type="password" name="answer" value="' . $_POST['answer'] . '" placeholder="Answer . . ." maxlength="22" autocomplete="off" tabindex="10" autofocus /></p>
	<p><input class="button" type="submit" name="submit" value="Login" tabindex="20" /></p>
</form>

</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");