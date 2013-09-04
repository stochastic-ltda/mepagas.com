<?php
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/UsuarioMapper.php'); }
if (!class_exists('Mustache')) { include( dirname(__FILE__) . '/../classes/Services/Mustache/Mustache.php'); }

if(!isset($_POST['id'])) echo "ERROR";
else {

	$id = $_POST['id'];
	$url = $_POST['url']; 
	$titulo = $_POST['titulo']; 

	$UsuarioMapper = new UsuarioMapper();
	$usuario = $UsuarioMapper->findById($id);

	$template = 'ficha_user_info';
	$params = array(
			'avatar' => $usuario->get('avatar'),
			'nombre' => $usuario->get('nombre'),
			'email' => $usuario->get('email'),
			'nombre_empresa' => $usuario->get('nombre_empresa'),
			'telefono' => $usuario->get('telefono'),
			'url' => $url,
			'titulo' => $titulo		
		);

	if($usuario->get('nombre_empresa') == '') $params['empresa'] = false;
	else $params['empresa'] = true;

	echo Mustache::paint($template, $params);

}

?>