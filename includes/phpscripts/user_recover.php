<?php
if (!class_exists('Usuario')) { include( dirname(__FILE__) . '/../classes/Objects/Usuario.php'); }
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/UsuarioMapper.php'); }

$usuarioMapper = new UsuarioMapper();

if(!isset($_POST['email'])) echo "0";
else {

	$email = $_POST['email'];
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) echo "1"; // Email invalido
	else {

		$usuario = $usuarioMapper->findByEmail($email);
		if(is_null($usuario)) echo "3"; // Usuario no encontrado
		else {
			
			if($usuario->get('estado') == 0) echo "2"; // Usuario inactivo
			else {

				// Genero token
				$token = md5($email . "_" . date('l jS \of F Y h:i:s A'));

				// Actualizo cuenta de usuario con nuevo token
				$usuario->set('token', $token);
				$usuarioMapper->update($usuario->get('id'), $usuario);

				// Envio email con link para crear una nueva contraseña
				$usuarioMapper->sendRecoverEmail($usuario->get('nombre'), $usuario->get('email'), $token);

				echo "4";

			}
		}
	}

}