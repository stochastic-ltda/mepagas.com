<?php
include(dirname(__FILE__) . '/../../config.php'); 
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/UsuarioMapper.php'); }
if (!class_exists('Usuario')) { include( dirname(__FILE__) . '/../classes/Objects/Usuario.php'); }
if (!class_exists('Image')) { include( dirname(__FILE__) . '/../classes/Services/Image/Image.php'); }

$config = new Config();

if(!isset($_POST['id'])) die;

$usuarioMapper = new UsuarioMapper();

// TODO: Subir nuevos avatar

// Validacion
$isempresa = $usuario = $nombre = $telefono = $email = $password = $empresa = null;

if(isset($_POST['usuario'])) $nombre = $_POST['usuario'];
if(isset($_POST['nombre'])) $nombre = $_POST['nombre'];
if(isset($_POST['telefono'])) $telefono = $_POST['telefono'];
if(isset($_POST['email'])) $email = $_POST['email'];
if(isset($_POST['password'])) $password = $_POST['password'];
if(isset($_POST['nombre_empresa'])) $empresa = $_POST['nombre_empresa'];
if(isset($_POST['isempresa'])) $isempresa = $_POST['isempresa'];

$error = array();
if(!is_null($usuario) && $usuario == "") $error[] = "Debes ingresar un usuario";
if(!is_null($nombre) && $nombre == "") $error[] = "Debes ingresar un nombre";

if(!is_null($email) && $email != $_POST['oldemail'])
	if($email == "") $error[] = "Debes ingresar un email";
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $error[] = "Email incorrecto"; 
	else if($usuarioMapper->findEmail($email)) $error[] = "El email ingresado ya se encuentra registrado";


if($isempresa == "on")
	if($empresa == "") $error[] = "Debes ingresar un nombre de empresa"; 

// Validacion correcta
$usuario = new Usuario();

if(count($error) == 0) {

	// Procesamiento de imagen
	foreach ($_FILES as $key) {

		if($key['name'] != '') {

			if($key['error'] == UPLOAD_ERR_OK ) { // Verificamos si se subio correctamente

				// Se valida que sea una imagen
				if(((strpos($key['type'], "gif") || strpos($key['type'], "jpeg") || strpos($key['type'],"jpg")) || strpos($key['type'],"png") )) {

					$nombre = $key['name'];
					$temporal = $key['tmp_name']; 
					$tamano= ($key['size'] / 1000)."Kb";

					// obtengo extension
					$aux = explode(".", $nombre);
					$ext = $aux[count($aux)-1];

					// nombre unico dependiendo del contenido
					$content = file_get_contents($temporal);

					$image_name = md5($content) . "." . $ext;
					$thumb_name = "thumb_" . md5($content) . "." . $ext;

					Image::scale($temporal, 180, 0, $config->avatarupload_path . $image_name);
					$_POST['avatar'] = $config->avatarsrc_path . $image_name;

				} else {
					echo "<script>alert('Formato no permitido');</script>";
				}

			} else {

				echo "<script>alert('Ha ocurrido un problema al procesar la imagen. Por favor inténtalo más tarde');</script>";

				// TODO: implementar registro y alerta del error
				// echo $key['error'];

			}
		} else {
			unset($_POST['avatar']);
			$usuario->set('avatar', null);
		}
	}

	// Procesamiento de datos
	$fields = array('usuario','nombre','nombre_empresa','email','telefono','acercade','avatar');	

	foreach($_POST as $field => $value) {
		if(in_array($field, $fields)) {

			// Condicionamiento
			if($field == "acercade") $value = nl2br($value);

			// Seteo variable
			$usuario->set($field, $value);
		}
	}

	$usuarioMapper->update($_POST['id'], $usuario);
	header("Location: /usuario/".$_POST['id']);

}

// Con errores
else {

	foreach($error as $e) {
		echo '<script> alert("'.$e.'"); </script>';
		echo '<script> document.location="/usuario/editar/'.$_POST['id'].'"; </script>';
	}
}







?>