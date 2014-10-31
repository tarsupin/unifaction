<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

Alert::saveSuccess("Connected", "You have successfully installed Auth!");

Database::query("REPLACE INTO network_data (site_handle, site_name, site_clearance, site_url, site_key) VALUES (?, ?, ?, ?, ?)", array(SITE_HANDLE, "UniFaction", 9, SITE_URL, Security::hash(70, 70)));

header("Location: /install/app-custom"); exit;