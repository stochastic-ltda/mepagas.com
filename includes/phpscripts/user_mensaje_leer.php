<?php
if (!class_exists('MensajeMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/MensajeMapper.php'); }
if (!class_exists('Mensaje')) { include( dirname(__FILE__) . '/../classes/Objects/Mensaje.php'); }

$mensajeMapper = new MensajeMapper();
if(isset($_POST['id'])) {
	$mensaje = new Mensaje();
	$mensaje->set('leido',1);
	$mensajeMapper->update($_POST['id'], $mensaje);
}

?>