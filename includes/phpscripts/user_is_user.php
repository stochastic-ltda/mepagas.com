<?php
if(!isset($_POST['code']) || !isset($_POST['userid'])) echo "false";
else {

	if (!class_exists('Config')) { include( dirname(__FILE__) . '/../../config.php'); }
	$config = new Config();

	$hash = md5($_POST['userid'] . "-" . $config->salt);

	if($hash == $_POST['code']) echo "true";
	else echo "false";

}

?>