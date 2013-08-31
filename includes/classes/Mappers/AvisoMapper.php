<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }
if (!class_exists('Aviso')) { include( dirname(__FILE__) . '/../Objects/Aviso.php'); }

class AvisoMapper {

	public function insert(Aviso $aviso) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		// Insert aviso
		$sql = "INSERT INTO aviso (id_usuario,tipo,precio,titulo,categoria,descripcion, publicado, fecha_creacion, fecha_modificacion) VALUES ('".$aviso->get('id_usuario')."','".$aviso->get('tipo')."','".$aviso->get('precio')."','".$aviso->get('titulo')."','".$aviso->get('categoria')."','".$aviso->get('descripcion')."', 0, now(), now())";
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


}
?>