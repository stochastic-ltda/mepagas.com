<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }
if (!class_exists('Usuario')) { include( dirname(__FILE__) . '/../Objects/Usuario.php'); }

class UsuarioMapper {

	public function insert(Usuario $usuario) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		// Insert aviso
		$sql = "INSERT INTO usuario (id, facebook_id, usuario, nombre, nombre_empresa, email, telefono, password, avatar) VALUES ('','".$usuario->get('facebook_id')."','".$usuario->get('usuario')."','".$usuario->get('nombre')."','".$usuario->get('nombre_empresa')."','".$usuario->get('email')."','".$usuario->get('telefono')."','".$usuario->get('password')."','".$usuario->get('avatar')."')";
			
		$res = mysql_query($sql) or die(mysql_error());		
		$id = mysql_insert_id();

		mysql_close($link);

		return $id;

	}

	public function update($id, Usuario $usuario) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$s1 = "UPDATE usuario SET usuario = '" . $usuario->get('usuario') . "' WHERE id = $id";
		$s2 = "UPDATE usuario SET nombre = '" . $usuario->get('nombre') . "' WHERE id = $id";
		$s3 = "UPDATE usuario SET email = '" . $usuario->get('email') . "' WHERE id = $id";
		$s4 = "UPDATE usuario SET avatar = '" . $usuario->get('avatar') . "' WHERE id = $id";

		mysql_query($s1) or die(mysql_error());
		mysql_query($s2) or die(mysql_error());
		mysql_query($s3) or die(mysql_error());
		mysql_query($s4) or die(mysql_error());

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

			return $usuario;
		}

	}

}
?>