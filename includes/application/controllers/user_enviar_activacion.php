<?php
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/UsuarioMapper.php'); }
$usuarioMapper = new UsuarioMapper();

// Si no esta seteado email
if(!isset($_GET['email'])) header("Location: /");
// Si esta seteado
else {

	$email = $_GET['email'];
	$action = null;

	// Reviso que sea un email valido
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $action = "1";
	else {

		// Obtengo informacion de usuario
		$usuario = $usuarioMapper->findByEmail($email);
		if($usuario->get('estado') == 1) $action = 2; // Si cuenta ya se encuentra activa
		else {

			$token = md5($email . "_" . date('l jS \of F Y h:i:s A')); // Genero nuevo token
			
			// Actualizo usuario
			$usuario->set('token', $token);			
			$usuarioMapper->update($usuario->get('id'), $usuario);			
			
			$usuarioMapper->sendActivationEmail($usuario->get('nombre'), $email, $token); // Envio email
			$action = 3;
		}
	}

}

?>