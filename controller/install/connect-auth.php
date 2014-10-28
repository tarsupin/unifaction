<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

Alert::saveSuccess("Connected", "You have successfully installed Auth!");

header("Location: /install/app-custom"); exit;