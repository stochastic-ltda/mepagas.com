<?php
if (!class_exists('MensajeMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/MensajeMapper.php'); }

$mensajeMapper = new MensajeMapper();
if(isset($_POST['id'])) {
	$mensajeMapper->delete($_POST['id']);
}

?>