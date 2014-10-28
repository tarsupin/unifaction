<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Log the user out
Me::logout();

// Remove all of the session values
unset($_SESSION['linkbackURL']);
unset($_SESSION['apiID']);
unset($_SESSION['handshake']);

header("Location: /");