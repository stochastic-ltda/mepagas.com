<?php
if (!class_exists('Aviso')) { include( dirname(__FILE__) . '/../classes/Objects/Aviso.php'); }
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/AvisoMapper.php'); }

if(isset($_POST['id'])) {

	$aviso = new Aviso();
	$aviso->set("id_usuario", $_POST['id_usuario']);
	$aviso->set("tipo", $_POST['tipo']);
	$aviso->set("precio", $_POST['precio']);
	$aviso->set("titulo", $_POST['titulo']);
	$aviso->set("categoria", $_POST['categoria']);
	$aviso->set("subcategoria", $_POST['subcategoria']);
	$aviso->set("descripcion", $_POST['descripcion']);
	$aviso->set("localidades", $_POST['localidades']);
	$aviso->set("imagenes", $_POST['imagenes']);
	$aviso->set("publicado", 0);

	$avisoMapper = new AvisoMapper();
	$avisoMapper->update($_POST['id'], $aviso);

	$avisoMapper->updateImagenes($_POST['id'], $aviso);
	$avisoMapper->updateLocalidades($_POST['id'], $aviso);

}

?>