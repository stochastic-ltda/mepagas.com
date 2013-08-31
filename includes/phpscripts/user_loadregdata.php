<?php
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/UsuarioMapper.php'); }
if (!class_exists('Mustache')) { include( dirname(__FILE__) . '/../classes/Services/Mustache/Mustache.php'); }

if(!isset($_POST['email'])) echo "ERROR";
else {

	$email = $_POST['email'];

	
	$UsuarioMapper = new UsuarioMapper();
	$usuario = $UsuarioMapper->findByEmail($email);

	$template = 'publish_user_logged';
	$params = array(
			'avatar' => $usuario->get('avatar'),
			'nombre' => $usuario->get('nombre'),
			'email' => $usuario->get('email'),
			'nombre_empresa' => $usuario->get('nombre_empresa'),
			'telefono' => $usuario->get('telefono'),
			'avatar' => $usuario->get('avatar')
		);

	if($usuario->get('nombre_empresa') == '') $params['empresa'] = false;
	else $params['empresa'] = true;

	echo Mustache::paint($template, $params);

}

?>