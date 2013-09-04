<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }

class GeneralMapper {

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