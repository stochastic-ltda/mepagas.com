<?php
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/UsuarioMapper.php'); }

$usuarioMapper = new UsuarioMapper();
$user = $usuarioMapper->findById($userid);

$isFacebook = false;
if(!in_array($user->get('facebook_id'), array('', null))) $isFacebook = true;

?>