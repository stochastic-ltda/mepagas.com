<?php
if(!isset($_POST['id'])) echo "";
else {

	if (!class_exists('Config')) { include( dirname(__FILE__) . '/../../config.php'); }
	$config = new Config();

	$id = $_POST['id'];
	$hash = md5($id . "-" . $config->salt);
	echo $hash;

}
?>