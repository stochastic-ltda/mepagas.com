<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }
if (!class_exists('Subcategoria')) { include( dirname(__FILE__) . '/../Objects/Subcategoria.php'); }

class SubcategoriaMapper {

	public function getByIdCategoria($id_categoria) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM categoria_2 WHERE id_categoria = $id_categoria ORDER BY id";
		$res = mysql_query($sql) or die(mysql_error());

		return $this->processAllReturn($res, null);

	}

	public static function getPermalinkByNombre($nombre) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT permalink FROM categoria_2 WHERE nombre = '$nombre'";
		$res = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($res) == 0) return null;
		else return mysql_result($res,0,0);
	}

	public static function getNombreByPermalink($permalink) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT nombre FROM categoria_2 WHERE permalink = '$permalink'";
		$res = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($res) == 0) return null;
		else return mysql_result($res,0,0);
	}

	public function processAllReturn($res, $default) {

		if(mysql_num_rows($res) == 0) return $default;
		else {
			$categorias = array();
			for($i=0; $i<mysql_num_rows($res); $i++) {
				$categoria = new Subcategoria();
				$categoria->set('id', mysql_result($res, $i, "id"));
				$categoria->set('id_categoria', mysql_result($res, $i, "id_categoria"));
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
			$categoria = new Subcategoria();
			$categoria->set('id', mysql_result($res, 0, "id"));
			$categoria->set('id_categoria', mysql_result($res, $i, "id_categoria"));
			$categoria->set('nombre', mysql_result($res, 0, "nombre"));
			$categoria->set('permalink', mysql_result($res, 0, "permalink"));
			return $categoria;
		}

	}


}

?>