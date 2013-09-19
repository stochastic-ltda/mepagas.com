<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }
if (!class_exists('Aviso')) { include( dirname(__FILE__) . '/../Objects/Aviso.php'); }

class AvisoMapper {

	public function insert(Aviso $aviso) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		// Insert aviso
		$sql = "INSERT INTO aviso (id_usuario,tipo,precio,titulo,categoria, subcategoria, descripcion, publicado, fecha_creacion, fecha_modificacion, permalink) VALUES ('".$aviso->get('id_usuario')."','".$aviso->get('tipo')."','".$aviso->get('precio')."','".$aviso->get('titulo')."','".$aviso->get('categoria')."','".$aviso->get('subcategoria')."','".$aviso->get('descripcion')."', 0, now(), now(),'".$aviso->get('permalink')."')";
		$res = mysql_query($sql) or die(mysql_error());		

		$id = mysql_insert_id();

		// Insert imagenes aviso
		foreach($aviso->get('imagenes') as $img) {
			$sql = "INSERT INTO aviso_imagen (id_aviso,imagen) VALUES ($id,'".$img."')";
			$res = mysql_query($sql) or die(mysql_error());
		}

		// Insert localidades
		foreach($aviso->get('localidades') as $loc) {
			$sql = "INSERT INTO aviso_localidad (id_aviso,localidad) VALUES ($id,'".$loc."')";
			$res = mysql_query($sql) or die(mysql_error());
		}

	}

	public function findByIdUsuario($userid) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		// Insert aviso
		$sql = "SELECT * FROM aviso WHERE id_usuario = $userid ORDER BY id DESC";
		$res = mysql_query($sql) or die(mysql_error());		

		$avisos = array();
		for($i=0; $i<mysql_num_rows($res); $i++) {

			$aviso = new Aviso();
			$aviso->set('id', mysql_result($res, $i, "id"));
			$aviso->set('titulo', mysql_result($res, $i, "titulo"));
			$aviso->set('permalink', mysql_result($res, $i, "permalink"));
			$avisos[] = $aviso;

		}

		return $avisos;

	}


}
?>