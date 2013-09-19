<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }

class GeneralMapper {

	/**
	/* FAVORITOS
	*/

	public static function insertFavorito($id_user=null, $titulo=null, $url=null) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		if($id_user==null || $titulo==null || $url==null) return false;

		$sql = "SELECT * FROM usuario_favoritos WHERE id_usuario = $id_user AND url = '$url'";
		$res = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($res) > 0) return true;

		$sql = "INSERT INTO usuario_favoritos (id_usuario, titulo, url) VALUES ($id_user, '$titulo', '$url')";
		$res = mysql_query($sql) or die(mysql_error());
		return true;

	}

	public function deleteFavorito($id) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "DELETE FROM usuario_favoritos WHERE id = $id";
		$res = mysql_query($sql) or die(mysql_error());

	}

	public function getFavoritos($id_user) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM usuario_favoritos WHERE id_usuario = $id_user ORDER BY id DESC";
		$res = mysql_query($sql) or die(mysql_error());

		$favoritos = array();
		for($i=0; $i<mysql_num_rows($res); $i++) {
			$favorito = array();
			$favorito['id'] = mysql_result($res, $i, "id");
			$favorito['url'] = mysql_result($res, $i, "url");
			$favorito['titulo'] = mysql_result($res, $i, "titulo");
			$favoritos[] = $favorito;
		}

		return $favoritos;
	}


	/**
	/* DENUNCIAS
	*/ 
	public static function insertDenuncia($id_user=null, $url=null) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		if($id_user==null || $url==null) return false;

		$sql = "SELECT * FROM usuario_denuncias WHERE id_usuario = $id_user AND url = '$url'";
		$res = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($res) > 0) return true;

		$sql = "INSERT INTO usuario_denuncias (id_usuario, url) VALUES ($id_user, '$url')";
		$res = mysql_query($sql) or die(mysql_error());
		return true;

	}

}
?>