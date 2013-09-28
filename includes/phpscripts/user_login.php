<?php
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/UsuarioMapper.php'); }
$usuarioMapper = new UsuarioMapper();

$email = $_POST['email'];
$pass = $_POST['pass'];

$usuario = $usuarioMapper->validateLogin(addslashes($email), md5($pass));

if(!is_null($usuario)) {

	$user = array(
			'email' => $usuario->get('email'),
			'nombre' => $usuario->get('nombre'),
			'userid' => $usuario->get('id'),
			'avatar' => $usuario->get('avatar')
		);
	echo json_encode($user);

} else {
	echo json_encode(array());
}