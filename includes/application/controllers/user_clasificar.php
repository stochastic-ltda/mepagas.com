<?php
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/AvisoMapper.php'); }
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/UsuarioMapper.php'); }

$id = (isset($_GET['f3'])) ? $_GET['f3']:null;
$redirect = false;

if(is_null($id)) $redirect = true;
else {

	// TODO: Validar si ya se califico a este usuario
	// TODO: Si ya califico, permitir volver a hacerlo (esto elimina la anterior)
	// TODO: No debiera poder calificarme a mi mismo
	$avisoMapper = new AvisoMapper();
	$usuarioMapper = new UsuarioMapper();

	$usuario = $usuarioMapper->findById($id);
	$avisos = $avisoMapper->findByIdUsuario($id);
}

?>