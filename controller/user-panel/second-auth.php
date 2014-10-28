<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Force the user to be logged in
if(!Me::$loggedIn)
{
	Me::redirectLogin("/user-panel/second-auth");
}

/****** Page Configuration ******/
$config['pageTitle'] = "Second Authentication";		// Up to 70 characters. Use keywords.

// Prepare Values
$newAuth = false;
$hasSecondAuth = AppLoginSec::hasSecondAuth(Me::$id);

// Run the form
if(Form::submitted("uni-second-auth-gen"))
{
	FormValidate::text("Question", $_POST['question'], 1, 80);
	FormValidate::variable("Answer", $_POST['answer'], 1, 22, " ");
	
	if(FormValidate::pass())
	{
		AppLoginSec::setSecurityQuestion(Me::$id, $_POST['question'], strtolower($_POST['answer']));
		
		Alert::saveSuccess("Second Auth", "You have successfully set your security question.");
		
		header("Location: /"); exit;
	}
}

// Prepare Values
$_POST['question'] = isset($_POST['question']) ? Sanitize::safeword($_POST['question'], " ") : "";
$_POST['answer'] = isset($_POST['answer']) ? Sanitize::variable($_POST['answer'], " ") : "";

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

/****** Run Content ******/
echo '
<h2>Second Authentication</h2>';

if($hasSecondAuth)
{
	echo'
	<p>Awesome! Your account is already protected with second authentication, which greatly improves its security.</p>';
}

if(!$hasSecondAuth or $newAuth)
{
	echo'
	<p>Please provide a security question for your login. This will greatly improve the security of your account. It can also help you recover your account if you lose your password.</p>
	
	<form class="uniform" action="/user-panel/second-auth" method="post">' . Form::prepare("uni-second-auth-gen") . '
	
	<h2>Choose a Security Question</h2>
	<p><input type="text" name="question" value="' . $_POST['question'] . '" maxlength="80" style="width:300px;" placeholder="Question . . ." /></p>
	<p>Choose a question that only you can answer, such as a memory of yours that nobody else would know about or be able to guess.</p>
	
	<p><input type="text" name="answer" value="' . $_POST['answer'] . '" maxlength="22" placeholder="Answer . . ." /></p>
	<p>Max of 22 characters, and uses lowercase.</p>
	
	<p><input type="submit" name="submit" value="Submit" /></p>
	
	</form>';
}

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");