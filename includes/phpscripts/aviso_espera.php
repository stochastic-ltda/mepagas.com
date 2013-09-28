<?php
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/AvisoMapper.php'); }
if (!class_exists('Mustache')) { include( dirname(__FILE__) . '/../classes/Services/Mustache/Mustache.php'); }
if (!class_exists('Config')) { include( dirname(__FILE__) . '/../../config.php'); }

$config = new Config();

$fromid = null;
if(isset($_POST['fromid'])) $fromid = $_POST['fromid'];

$avisoMapper = new AvisoMapper();
$avisos = $avisoMapper->getPendientes($fromid);

$template = 'aviso_pendiente';
if(!is_null($avisos)) {
	foreach($avisos as $aviso) {

		$params = array(
				'id' => $aviso->get('id'),
				'url' => '/' . $aviso->get('id') . '/' . $aviso->get('permalink'),
				'titulo' => $aviso->get('tipo') ." " . $aviso->get('precio') . " y " . $aviso->get('titulo'),
				'descripcion' => $aviso->get('descripcion')
			);

		//echo "<pre>"; print_r($aviso->get('imagenes')); echo "</pre>";

		foreach($aviso->get('imagenes') as $img) {
			$params['imagenes'][]['src'] = $config->imgsrc_path . "/thumb_" . $img;
		}

		foreach($aviso->get('localidades') as $loc) {
			$params['localidades'][]['nombre'] = $loc;
		}

		echo Mustache::paint($template, $params);	

		//unset($params['imagenes']);
		//unset($params['localidades']);
		//unset($params);
	}

} else {
	echo "<p>No hay avisos en espera de aprobación</p>";
}

?>