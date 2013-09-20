<?php
if (!class_exists('Aviso')) { include( dirname(__FILE__) . '/../classes/Objects/Aviso.php'); }
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/AvisoMapper.php'); }

$aviso = new Aviso();
$avisoMapper = new AvisoMapper();

if(isset($_POST['id'])) {

	$id = $_POST['id'];
	$aviso->set('publicado', 0);
	$aviso->set('estado', 'inactivo');
	$avisoMapper->update($id, $aviso);

	echo "true";

}

?>