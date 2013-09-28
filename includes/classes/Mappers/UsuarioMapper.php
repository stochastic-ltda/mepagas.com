<?php
if (!class_exists('Mailer')) { include( dirname(__FILE__) . '/../Services/Mustache/Mustache.php'); }
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }
if (!class_exists('Mailer')) { include( dirname(__FILE__) . '/../Services/Email/Mailer.php'); }
if (!class_exists('Usuario')) { include( dirname(__FILE__) . '/../Objects/Usuario.php'); }

class UsuarioMapper {

	public function insert(Usuario $usuario) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		// Insert aviso
		$sql = "INSERT INTO usuario (id, facebook_id, usuario, nombre, nombre_empresa, email, telefono, password, avatar, token) VALUES ('','".$usuario->get('facebook_id')."','".$usuario->get('usuario')."','".$usuario->get('nombre')."','".$usuario->get('nombre_empresa')."','".$usuario->get('email')."','".$usuario->get('telefono')."','".$usuario->get('password')."','".$usuario->get('avatar')."', '".$usuario->get('token')."')";
			
		$res = mysql_query($sql) or die(mysql_error());		
		$id = mysql_insert_id();

		mysql_close($link);

		return $id;

	}

	public function update($id, Usuario $usuario) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		if(!is_null($usuario->get('usuario'))) {
			$s1 = "UPDATE usuario SET usuario = '" . $usuario->get('usuario') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}

		if(!is_null($usuario->get('nombre'))) {
			$s2 = "UPDATE usuario SET nombre = '" . $usuario->get('nombre') . "' WHERE id = $id";
			mysql_query($s2) or die(mysql_error());
		}

		if(!is_null($usuario->get('email'))) {
			$s3 = "UPDATE usuario SET email = '" . $usuario->get('email') . "' WHERE id = $id";
			mysql_query($s3) or die(mysql_error());
		}

		if(!is_null($usuario->get('avatar'))) {
			$s4 = "UPDATE usuario SET avatar = '" . $usuario->get('avatar') . "' WHERE id = $id";
			mysql_query($s4) or die(mysql_error());
		}

		if(!is_null($usuario->get('acercade'))) {
			$s5 = "UPDATE usuario SET acercade = '" . $usuario->get('acercade') . "' WHERE id = $id";
			mysql_query($s5) or die(mysql_error());
		}

		if(!is_null($usuario->get('nombre_empresa'))) {
			$s6 = "UPDATE usuario SET nombre_empresa = '" . $usuario->get('nombre_empresa') . "' WHERE id = $id";
			mysql_query($s6) or die(mysql_error());
		}

		if(!is_null($usuario->get('telefono'))) {
			$s7 = "UPDATE usuario SET telefono = '" . $usuario->get('telefono') . "' WHERE id = $id";
			mysql_query($s7) or die(mysql_error());
		}

		if(!is_null($usuario->get('token'))) {
			$s7 = "UPDATE usuario SET token = '" . $usuario->get('token') . "' WHERE id = $id";
			mysql_query($s7) or die(mysql_error());
		}

		if(!is_null($usuario->get('estado'))) {
			$s7 = "UPDATE usuario SET estado = '" . $usuario->get('estado') . "' WHERE id = $id";
			mysql_query($s7) or die(mysql_error());
		}

		if(!is_null($usuario->get('password'))) {
			$s7 = "UPDATE usuario SET password = '" . $usuario->get('password') . "' WHERE id = $id";
			mysql_query($s7) or die(mysql_error());
		}

	}

	public function findByEmail($email) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM usuario WHERE email = '$email'";
		$res = mysql_query($sql) or die(mysql_error());

		return $this->processReturn($res, null);
	}

	public function findById($id) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM usuario WHERE id = '$id'";
		$res = mysql_query($sql) or die(mysql_error());

		return $this->processReturn($res, null);
	}

	public function findByToken($token) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM usuario WHERE token = '$token'";
		$res = mysql_query($sql) or die(mysql_error());

		return $this->processReturn($res, null);
	}

	public function findEmail($email) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM usuario WHERE email = '$email'";
		$res = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($res) == 0) return false;
		else return true;

	}

	public function validateLogin($email, $pass) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM usuario WHERE email ='$email' AND password='$pass'";
		$res = mysql_query($sql) or die(mysql_error());

		return $this->processReturn($res, null);

	}

	public function processReturn($res, $default) {

		if(mysql_num_rows($res) == 0) return $default;
		else {
			$usuario = new Usuario();
			$usuario->set('id', mysql_result($res, 0, "id"));
			$usuario->set('facebook_id', mysql_result($res, 0, "facebook_id"));
			$usuario->set('nombre', mysql_result($res, 0, "nombre"));
			$usuario->set('nombre_empresa', mysql_result($res, 0, "nombre_empresa"));
			$usuario->set('usuario', mysql_result($res, 0, "usuario"));
			$usuario->set('email', mysql_result($res, 0, "email"));
			$usuario->set('telefono', mysql_result($res, 0, "telefono"));
			$usuario->set('avatar', mysql_result($res, 0, "avatar"));
			$usuario->set('acercade', mysql_result($res, 0, "acercade"));
			$usuario->set('token', mysql_result($res, 0, "token"));
			$usuario->set('estado', mysql_result($res, 0, "estado"));
			$usuario->set('password', mysql_result($res, 0, "password"));

			return $usuario;
		}

	}

	public function sendActivationEmail($nombre, $email, $token) {

		$template = "user_activation";
		$params = array("nombre"=>$nombre, "token"=>$token);
		$html = Mustache::paint($template, $params);

		$mail = new Mailer();
		if(!$mail->send($email, $nombre, "Activa tu cuenta de usuario", $html))
			return "Ha ocurrido un error al enviar el email";

		return true;
	}

	public function sendRecoverEmail($nombre, $email, $token) {

		$template = "user_recover";
		$params = array("nombre"=>$nombre, "token"=>$token);
		$html = Mustache::paint($template, $params);

		$mail = new Mailer();
		if(!$mail->send($email, $nombre, "Recupera tu password", $html))
			return "Ha ocurrido un error al enviar el email";

		return true;
	}

}
?>