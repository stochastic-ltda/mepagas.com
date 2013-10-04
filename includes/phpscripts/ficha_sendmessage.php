<?php
if (!class_exists('Mensaje')) { include( dirname(__FILE__) . '/../classes/Objects/Mensaje.php'); }
if (!class_exists('MensajeMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/MensajeMapper.php'); }
if (!class_exists('Config')) { include( dirname(__FILE__) . '/../../config.php'); }

$config = new Config();
$mensajeMapper = new MensajeMapper();

// Obtencion de datos
$from=$to=$body=$id_aviso=null;

if(isset($_POST['from'])) $from = $_POST['from'];
if(isset($_POST['to'])) $to = $_POST['to'];
if(isset($_POST['body'])) $body = $_POST['body'];
if(isset($_POST['id_aviso'])) $id_aviso = $_POST['id_aviso'];

// Validacion de campos
$error = array();

	if(is_null($body) || $body == "") $error[] = "Debes ingresar un mensaje";
	if(is_null($to) || $to == "") $error[] = "Destinatario desconocido";
	if(is_null($id_aviso) || $id_aviso == "") $error[] = "Pituto desconocido";

	if(is_null($from) || $from == "") $error[] = "Eres un desconocido!";
	else {
		$from = explode("-", $from);
		if(!isset($from[1])) $error[] = "Eres un desconocido!";
		else {
			$hash1 = $from[0];
			$hash2 = md5($from[1] . "-" . $config->salt);
			if($hash1!=$hash2) $error[] = "Eres un desconocido!";
		}
	}


// Validacion CORRECTA
if(count($error) == 0) {

	$mensaje = new Mensaje("", $id_aviso, $from[1], $to, strip_tags(nl2br($body), "<br>"));
	$ack = $mensajeMapper->insert($mensaje);

	if($ack) echo "true";
	else echo json_encode(array("Ha ocurrido un problema, por favor inténtalo más tarde"));

}

// Validacion INCORRECTA
else {

	// RETORNO ERRORES
	echo json_encode($error);
}

?>