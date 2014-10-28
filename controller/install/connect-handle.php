<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

Cookie::set("admin-handle", "admin", "", 3);

Alert::saveSuccess("Admin Chosen", "You have designated @admin as the admin of this site.");

Alert::saveSuccess("Config Updated", "You performed a manual update.");

header("Location: /install/setup-database"); exit;