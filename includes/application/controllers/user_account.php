<?php
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/UsuarioMapper.php'); }
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/AvisoMapper.php'); }
if (!class_exists('GeneralMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/GeneralMapper.php'); }

$usuarioMapper = new UsuarioMapper();
$avisoMapper = new AvisoMapper();
$generalMapper = new GeneralMapper();

$user = $usuarioMapper->findById($userid);
$avisos = $avisoMapper->findByIdUsuario($userid);
$favoritos = $generalMapper->getFavoritos($userid);

// Flag facebook user
$isFacebook = false;
if(!in_array($user->get('facebook_id'), array('', null))) $isFacebook = true;

// si es de facebook solo permite modificar el telefono
// si no es de facebook permite modificar toda la informacion

// Metadata
$title = $user->get('nombre') . " | Mepagas.com";

?>