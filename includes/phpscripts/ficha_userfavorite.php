<?php
if (!class_exists('GeneralMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/GeneralMapper.php'); }

$id_user = $_POST['id_user'];
$titulo = $_POST['titulo'];
$url = $_POST['url'];

GeneralMapper::insertFavorito($id_user, $titulo, $url)

?>