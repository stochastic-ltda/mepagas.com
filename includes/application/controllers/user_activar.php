<?php
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/UsuarioMapper.php'); }

$usuarioMapper = new UsuarioMapper();
$action = null;


// Valido token
if(!isset($token)) $action = 1;
else {
	
	$usuario = $usuarioMapper->findByToken($token); // Obtengo usuario
	if(!is_null($usuario)) {

		// Actualizo campos	
		$usuario->set('estado', 1);
		$usuario->set('token', '');
		$usuarioMapper->update($usuario->get('id'), $usuario);
		$action = 2;

	} else {
		$action = 3;
	}
}
