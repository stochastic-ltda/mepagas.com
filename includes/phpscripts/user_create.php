<?php
if (!class_exists('Usuario')) { include( dirname(__FILE__) . '/../classes/Objects/Usuario.php'); }
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/UsuarioMapper.php'); }

$usuarioMapper = new UsuarioMapper();

// Obtencion de datos
$nombre = $telefono = $email = $password = $terms = null;

if(isset($_POST['nombre'])) $nombre = $_POST['nombre'];
if(isset($_POST['email'])) $email = $_POST['email'];
if(isset($_POST['password'])) $password = $_POST['password'];
if(isset($_POST['terms'])) $terms = $_POST['terms'];

// Validacion de campos
$error = array();

	// Nombre
	if(is_null($nombre) || $nombre == "") $error[] = "Debes ingresar un nombre";

	// Email
	if(is_null($email) || $email == "") $error[] = "Debes ingresar un email";
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $error[] = "Email incorrecto"; 
	else if($usuarioMapper->findEmail($email)) $error[] = "El email ingresado ya se encuentra registrado";

	// Password
	if(is_null($password) || $password == "") $error[] = "Debes ingresar un password";

	// Terminos de Servicio
	if(is_null($terms) || $terms == 'false') $error[] = "Debes aceptar los 'Términos de Servicio'";

// Validacion CORRECTA
if(count($error) == 0) {

	// Creacion de TOKEN
	$token = md5($email . "_" . date('l jS \of F Y h:i:s A'));

	// Registro nuevo usuario
	$usuario = new Usuario(null, null, current(explode(" ",$nombre)), $nombre, null, $email, null, md5($password), null, null, $token);	
	$userID = $usuarioMapper->insert($usuario);

	if( !is_null($userID) ) {

		$act = $usuarioMapper->sendActivationEmail($nombre, $email, $token); // Envio email de activacion
		if($act !== true) {
			$error[] = $act;
			echo json_encode($error);
		} else
			echo json_encode(array("userid"=>$userID));

	} else 
		echo json_encode(array("Ha ocurrido un problema, por favor inténtalo más tarde"));
}

// Validacion INCORRECTA
else {

	// RETORNO ERRORES
	echo json_encode($error);
}

?>