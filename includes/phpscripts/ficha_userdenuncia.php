<?php
if (!class_exists('GeneralMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/GeneralMapper.php'); }

$id_user = $_POST['id_user'];
$url = $_POST['url'];

GeneralMapper::insertDenuncia($id_user, $url)

?>