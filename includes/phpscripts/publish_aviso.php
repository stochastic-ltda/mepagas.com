<?php
if (!class_exists('Aviso')) { include( dirname(__FILE__) . '/../classes/Objects/Aviso.php'); }
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/AvisoMapper.php'); }

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

// Genero permalink
$titulo = strtolower($_POST['tipo'] . "-" . $_POST['precio'] . "-" . $_POST['titulo']);
$titulo = str_replace("ñ","n",$titulo);
$titulo = str_replace("á","a",$titulo);
$titulo = str_replace("é","e",$titulo);
$titulo = str_replace("í","i",$titulo);
$titulo = str_replace("ó","o",$titulo);
$titulo = str_replace("ú","u",$titulo);
$titulo = str_replace("'","-",$titulo);
$string = str_replace(",","-",$string);
$titulo = str_replace(" ","-",$titulo);
$titulo = str_replace("--","-",$titulo);
$titulo = str_replace("(","",$titulo);
$titulo = str_replace(")","",$titulo);
$titulo = ereg_replace("[^A-Za-z0-9\-]", "", $titulo);

$aviso->set("permalink", $titulo);

$avisoMapper = new AvisoMapper();
$avisoMapper->insert($aviso);

?>