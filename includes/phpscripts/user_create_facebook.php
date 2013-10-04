<?php
if (!class_exists('Usuario')) { include( dirname(__FILE__) . '/../classes/Objects/Usuario.php'); }
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/UsuarioMapper.php'); }

$usuario = new Usuario();
$usuario->set('facebook_id', $_POST['id']);
$usuario->set('usuario', $_POST['username']);
$usuario->set('nombre', $_POST['name']);
$usuario->set('email', $_POST['email']);
$usuario->set('avatar', 'http://graph.facebook.com/' . $_POST["id"] . '/picture');

$usuarioMapper = new UsuarioMapper();
if($usuarioMapper->findEmail($_POST['email'])) {
	
	// Actualizo informacion de usuario
	$usuarioOLD = $usuarioMapper->findByEmail($_POST['email']);
	$userID = $usuarioOLD->get('id');
	/*
	$usuario->set('nombre_empresa', $usuarioOLD->get('nombre_empresa'));
	$usuario->set('acercade', $usuarioOLD->get('acercade'));
	$usuario->set('telefono', $usuarioOLD->get('telefono'));
	$usuario->set('token', $usuarioOLD->get('token'));
	$usuario->set('estado', $usuarioOLD->get('estado'));
	$usuarioMapper->update($usuarioOLD->get('id'), $usuario);
	*/

} else {
	
	// Inserto nuevo usuario
	$userID = $usuarioMapper->insert($usuario);

}


if( !is_null($userID) ) echo json_encode(array("userid"=>$userID));
else echo json_encode(array("Ha ocurrido un problema, por favor inténtalo más tarde"));

?>