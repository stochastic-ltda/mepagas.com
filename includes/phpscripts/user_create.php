<?php
if (!class_exists('Usuario')) { include( dirname(__FILE__) . '/../classes/Objects/Usuario.php'); }
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/UsuarioMapper.php'); }

$usuarioMapper = new UsuarioMapper();

// OBTENCION DE DATOS
$nombre = $telefono = $email = $password = $empresa = null;

if(isset($_POST['nombre'])) $nombre = $_POST['nombre'];
if(isset($_POST['telefono'])) $telefono = $_POST['telefono'];
if(isset($_POST['email'])) $email = $_POST['email'];
if(isset($_POST['password'])) $password = $_POST['password'];
if(isset($_POST['empresa'])) $empresa = $_POST['empresa'];
$isempresa = $_POST['isempresa'];

// VALIDACION
$error = array();
if(is_null($nombre) || $nombre == "") $error[] = "Debes ingresar un nombre";

// TODO: Validar que el email no se encuentre registrado
if(is_null($email) || $email == "") $error[] = "Debes ingresar un email";
else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $error[] = "Email incorrecto"; 
else if($usuarioMapper->findEmail($email)) $error[] = "El email ingresado ya se encuentra registrado";


if(is_null($password) || $password == "") $error[] = "Debes ingresar un password";

if($isempresa == "true")
	if(is_null($empresa) || $empresa == "") $error[] = "Debes ingresar un nombre de empresa"; 

// VALIDACION CORRECTA
if(count($error) == 0) {

	// PROCESAMIENTO DE DATOS
	$usuario = new Usuario(null, null, current(explode(" ",$nombre)), $nombre, $empresa, $email, $telefono, md5($password));	
	$userID = $usuarioMapper->insert($usuario);

	if( !is_null($userID) ) echo json_encode(array("userid"=>$userID));
	else echo json_encode(array("Ha ocurrido un problema, por favor inténtalo más tarde"));

}

// VALIDACION INCORRECTA
else {

	// RETORNO ERRORES
	echo json_encode($error);
}

?>