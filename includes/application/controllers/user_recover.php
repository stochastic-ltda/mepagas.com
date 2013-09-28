<?php
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/UsuarioMapper.php'); }
$usuarioMapper = new UsuarioMapper();

if(!isset($_GET['f3'])) $action = 1;
else $action = 2;

// Si se envia formulario de nuevo password
if(isset($_POST['actualizar'])) {

	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];

	// Valido password
	$error = array();
	if($pass1 == '') $error[] = "Debes ingresar una contraseña";
	elseif($pass2 == '') $error[] = "Debes confirmar tu contraseña";
	elseif($pass1 != $pass2) $error[] = "Las contraseñas ingresadas no son iguales";

	if(count($error) > 0) {
		foreach($error as $e) echo '<script>alert("'.$e.'");</script>';
	} else {

		// Obtengo usuario
		$token = $_GET['f3'];
		$usuario = $usuarioMapper->findByToken($token);

		// Actualizo usuario (token y password)
		$usuario->set('password', md5($pass1));
		$usuario->set('token', '');
		$usuarioMapper->update($usuario->get('id'), $usuario);

		// Aviso usuario
		echo '<script>alert("Tu contraseña ha sido actualizada.\nYa puedes iniciar sesión con tu cuenta");</script>';
		echo '<script>document.location="/";</script>';
	}

}

?>