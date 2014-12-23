<?php if(!defined("CONF_PATH")) { die("No direct script access allowed."); }

// Run Global Script
require(APP_PATH . "/includes/global.php");

// Display the Header
require(SYS_PATH . "/controller/includes/metaheader.php");
require(SYS_PATH . "/controller/includes/header.php");

// Side Panel
require(SYS_PATH . "/controller/includes/side-panel.php");

echo '
<div id="panel-right"></div>
<div id="content" class="content-open">' . Alert::display();

echo '
<h1>Encryption Test</h1>';

echo "<br /><br />";

$key = "m2UoRd6oax4NuXHgUN0ab/ZOq7R8FNxYBkMRPIx8NX3jdevFtwXqbW6kf6i5Q4lLBi8G5v6c6v0mtLjhD3sPctKhU+PlAMPx7BnTumJq6CA2NCl8nf0qIImbInerr20jPl5qP9J/RuTLRbl/UZBqHyw";

$encryptedData = Encrypt::infiniteTimePad($key, "The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.The data that needs to be encrypted.");
echo $encryptedData;

echo "<br /><br /><br />";
$originalData = Decrypt::run($key, $encryptedData);
echo $originalData;

echo '
</div>';

// Display the Footer
require(SYS_PATH . "/controller/includes/footer.php");
