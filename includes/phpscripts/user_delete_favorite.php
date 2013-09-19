<?php
if (!class_exists('GeneralMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/GeneralMapper.php'); }

if(!isset($_POST['id'])) return "false";

$id = $_POST['id'];
$general = new GeneralMapper();

$general->deleteFavorito($id);
return "true";
?>