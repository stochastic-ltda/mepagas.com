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

	public function updateLocalidades($id, Aviso $aviso) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "DELETE FROM aviso_localidad WHERE id_aviso = $id";
		$res = mysql_query($sql) or die(mysql_error());

		foreach($aviso->get('localidades') as $loc) {
			$sql = "INSERT INTO aviso_localidad (id_aviso,localidad) VALUES ($id,'".$loc."')";
			$res = mysql_query($sql) or die(mysql_error());
		}

	}

	public function updateImagenes($id, Aviso $aviso) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "DELETE FROM aviso_imagen WHERE id_aviso = $id";
		$res = mysql_query($sql) or die(mysql_error());

		foreach($aviso->get('imagenes') as $img) {
			$sql = "INSERT INTO aviso_imagen (id_aviso,imagen) VALUES ($id,'".$img."')";
			$res = mysql_query($sql) or die(mysql_error());
		}
	}

	public function update($id, Aviso $aviso) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		if(!is_null($aviso->get('tipo'))) {
			$s1 = "UPDATE aviso SET tipo = '" . $aviso->get('tipo') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}

		if(!is_null($aviso->get('precio'))) {
			$s1 = "UPDATE aviso SET precio = '" . $aviso->get('precio') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}

		if(!is_null($aviso->get('titulo'))) {
			$s1 = "UPDATE aviso SET titulo = '" . $aviso->get('titulo') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}

		if(!is_null($aviso->get('categoria'))) {
			$s1 = "UPDATE aviso SET categoria = '" . $aviso->get('categoria') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}

		if(!is_null($aviso->get('subcategoria'))) {
			$s1 = "UPDATE aviso SET subcategoria = '" . $aviso->get('subcategoria') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}

		if(!is_null($aviso->get('descripcion'))) {
			$s1 = "UPDATE aviso SET descripcion = '" . $aviso->get('descripcion') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}


		if(!is_null($aviso->get('publicado'))) {
			$s1 = "UPDATE aviso SET publicado = '" . $aviso->get('publicado') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}

		if(!is_null($aviso->get('estado'))) {
			$s1 = "UPDATE aviso SET estado = '" . $aviso->get('estado') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}

		
		$s1 = "UPDATE aviso SET fecha_modificacion = now() WHERE id = $id";
		mysql_query($s1) or die(mysql_error());
		
	}

	public function findByIdUsuario($userid) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		// Insert aviso
		$sql = "SELECT * FROM aviso WHERE id_usuario = $userid ORDER BY id DESC";
		$res = mysql_query($sql) or die(mysql_error());		
		
		return $this->processReturn($res, null);

	}

	public function findById($id) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		// Insert aviso
		$sql = "SELECT * FROM aviso WHERE id = $id";
		$res = mysql_query($sql) or die(mysql_error());		

		$aviso = $this->processReturn($res, null);
		if(!is_null($aviso) && count($aviso) > 0) $aviso = $aviso[0];
				
		$aviso->set('localidades', $this->findLocalidadesById($id));
		$aviso->set('imagenes', $this->findImagenesById($id));


		return $aviso;

	}

	public function findLocalidadesById($id) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM aviso_localidad WHERE id_aviso = $id";
		$res = mysql_query($sql) or die(mysql_error());

		$localidades = array();
		for($i=0; $i<mysql_num_rows($res); $i++) $localidades[] = mysql_result($res, $i, "localidad");

		return $localidades;
	}

	public function findImagenesById($id) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM aviso_imagen WHERE id_aviso = $id";
		$res = mysql_query($sql) or die(mysql_error());

		$imagenes = array();
		for($i=0; $i<mysql_num_rows($res); $i++) $imagenes[] = mysql_result($res, $i, "imagen");

		return $imagenes;

	}

	public function processReturn($res, $default=null) {

		if(mysql_num_rows($res) == 0) return $default;
		else {
			$avisos = array();
			for($i=0; $i<mysql_num_rows($res); $i++) {

				$aviso = new Aviso();
				$aviso->set('id', mysql_result($res, $i, "id"));
				$aviso->set('tipo', mysql_result($res, $i, "tipo"));
				$aviso->set('precio', mysql_result($res, $i, "precio"));
				$aviso->set('titulo', mysql_result($res, $i, "titulo"));
				$aviso->set('permalink', mysql_result($res, $i, "permalink"));
				$aviso->set('categoria', mysql_result($res, $i, "categoria"));
				$aviso->set('subcategoria', mysql_result($res, $i, "subcategoria"));
				$aviso->set('descripcion', mysql_result($res, $i, "descripcion"));
				$aviso->set('estado', mysql_result($res, $i, "estado"));
				$avisos[] = $aviso;

			}

			return $avisos;
		}

	}


}
?>