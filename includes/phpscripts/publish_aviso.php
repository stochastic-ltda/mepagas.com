<?php
if (!class_exists('Aviso')) { include( dirname(__FILE__) . '/../classes/Objects/Aviso.php'); }
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/AvisoMapper.php'); }

$aviso = new Aviso();
$aviso->set("tipo", $_POST['tipo']);
$aviso->set("precio", $_POST['precio']);
$aviso->set("titulo", $_POST['titulo']);
$aviso->set("categoria", $_POST['categoria']);
$aviso->set("descripcion", $_POST['descripcion']);
$aviso->set("localidades", $_POST['localidades']);
$aviso->set("imagenes", $_POST['imagenes']);

$avisoMapper = new AvisoMapper();
$avisoMapper->insert($aviso);

?>