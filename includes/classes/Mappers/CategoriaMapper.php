<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }
if (!class_exists('Categoria')) { include( dirname(__FILE__) . '/../Objects/Categoria.php'); }

class CategoriaMapper {

	public function getAll() {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM categoria ORDER BY nombre";
		$res = mysql_query($sql) or die(mysql_error());

		return $this->processAllReturn($res, null);

	}

	public function getByNombre($nombre) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM categoria WHERE nombre LIKE '$nombre'";
		$res = mysql_query($sql) or die(mysql_error());

		return $this->processReturn($res, null);		
	}

	public static function getPermalinkByNombre($nombre) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT permalink FROM categoria WHERE nombre = '$nombre'";
		$res = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($res) == 0) return null;
		else return mysql_result($res,0,0);
	}

	public static function getNombreByPermalink($permalink) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT nombre FROM categoria WHERE permalink = '$permalink'";
		$res = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($res) == 0) return null;
		else return mysql_result($res,0,0);
	}

	public function processAllReturn($res, $default) {

		if(mysql_num_rows($res) == 0) return $default;
		else {
			$categorias = array();
			for($i=0; $i<mysql_num_rows($res); $i++) {
				$categoria = new Categoria();
				$categoria->set('id', mysql_result($res, $i, "id"));
				$categoria->set('nombre', mysql_result($res, $i, "nombre"));
				$categoria->set('permalink', mysql_result($res, $i, "permalink"));
				$categorias[] = $categoria;
			}
			return $categorias;
		}

	}

	public function processReturn($res, $default) {

		if(mysql_num_rows($res) == 0) return $default;
		else {
			$categoria = new Categoria();
			$categoria->set('id', mysql_result($res, 0, "id"));
			$categoria->set('nombre', mysql_result($res, 0, "nombre"));
			$categoria->set('permalink', mysql_result($res, 0, "permalink"));
			return $categoria;
		}

	}


}
?>