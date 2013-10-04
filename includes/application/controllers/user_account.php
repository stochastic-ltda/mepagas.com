<?php
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/UsuarioMapper.php'); }
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/AvisoMapper.php'); }
if (!class_exists('MensajeMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/MensajeMapper.php'); }
if (!class_exists('GeneralMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/GeneralMapper.php'); }

$usuarioMapper = new UsuarioMapper();
$avisoMapper = new AvisoMapper();
$generalMapper = new GeneralMapper();
$mensajeMapper = new MensajeMapper();

$user = $usuarioMapper->findById($userid);

// Flag facebook user
$isFacebook = false;
if(!in_array($user->get('facebook_id'), array('', null))) $isFacebook = true;

// si es de facebook solo permite modificar el telefono
// si no es de facebook permite modificar toda la informacion

// Metadata
$title = $user->get('nombre') . " | Mepagas.com";

// Informacion dependiendo la seccion
if(!isset($_GET['s'])) $s = null;
else $s = $_GET['s'];

switch ($s) {

	case 'pit':
		$h1 = "Pitutos";	
		$avisos = $avisoMapper->findByIdUsuario($userid);	
		break;

	case 'fav':
		$h1 = "Favoritos";		
		$favoritos = $generalMapper->getFavoritos($userid);
		break;

	case 'cal':
		$h1 = "Calificaciones";		
		break;

	case 'msj':
		$h1 = "Mensajes";		
		$msjrec = $mensajeMapper->findByPara($user->get('id'));
		$msjenv = $mensajeMapper->findByDesde($user->get('id'));
		break;
	
	default:
		$h1 = "Perfil";
		break;
}

?>