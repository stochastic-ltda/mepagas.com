<?php
if (!class_exists('MensajeMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/MensajeMapper.php'); }
if (!class_exists('Config')) { include( dirname(__FILE__) . '/../../config.php'); }

$mensajeMapper = new MensajeMapper();
$config = new Config();

if(isset($_POST['id'])) {

	$mensaje = $mensajeMapper->findById($_POST['id']);
	if(is_null($mensaje)) echo json_encode(array());
	else {
		$data = array(
				'to' => md5($mensaje[0]->get('para') . "-" . $config->salt) . "-" . $mensaje[0]->get('para'),
				'from' => $mensaje[0]->get('desde'),
				'avisoid' => $mensaje[0]->get('id_aviso'),
				'mensaje' => $mensaje[0]->get('mensaje')
			);
		echo json_encode($data);
	}

} else {
	echo json_encode(array());
}

?>