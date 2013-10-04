<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }
if (!class_exists('Mensaje')) { include( dirname(__FILE__) . '/../Objects/Mensaje.php'); }
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../Mappers/UsuarioMapper.php'); }
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/../Mappers/AvisoMapper.php'); }

class MensajeMapper {

	public function insert(Mensaje $mensaje) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		// Insert aviso
		$sql = "INSERT INTO mensaje (id, id_aviso, desde, para, mensaje) VALUES ('','".$mensaje->get('id_aviso')."','".$mensaje->get('desde')."','".$mensaje->get('para')."','".$mensaje->get('mensaje')."')";
			
		$res = mysql_query($sql) or die(mysql_error());		
		$id = mysql_insert_id();

		mysql_close($link);

		return $id;

	}

	public function delete($id) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "DELETE FROM mensaje WHERE id = $id";
		$res = mysql_query($sql) or die(mysql_error());

	}

	public function update($id, Mensaje $mensaje) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		if(!is_null($mensaje->get('desde'))) {
			$s1 = "UPDATE mensaje SET desde = '" . $mensaje->get('desde') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}

		if(!is_null($mensaje->get('para'))) {
			$s1 = "UPDATE mensaje SET para = '" . $mensaje->get('para') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}

		if(!is_null($mensaje->get('mensaje'))) {
			$s1 = "UPDATE mensaje SET mensaje = '" . $mensaje->get('mensaje') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}

		if(!is_null($mensaje->get('leido'))) {
			$s1 = "UPDATE mensaje SET leido = '" . $mensaje->get('leido') . "' WHERE id = $id";
			mysql_query($s1) or die(mysql_error());
		}
		
	}

	public function findById($id) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM mensaje WHERE id = '$id'";
		$res = mysql_query($sql) or die(mysql_error());

		return $this->processAllReturn($res, null);
	}

	public function findByDesde($desde) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM mensaje WHERE desde = '$desde' ORDER BY fecha DESC";
		$res = mysql_query($sql) or die(mysql_error());

		return $this->processAllReturn($res, null);
	}

	public function findByPara($para) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM mensaje WHERE para = '$para' ORDER BY fecha DESC";
		$res = mysql_query($sql) or die(mysql_error());

		return $this->processAllReturn($res, null);
	}

	public function getNumSinLeer($id) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT COUNT(*) FROM mensaje WHERE para = $id AND leido = 0";
		$res = mysql_query($sql) or die(mysql_error());

		return mysql_result($res,0,0);

	}

	public function processAllReturn($res, $default) {

		$usuarioMapper = new UsuarioMapper();
		$avisoMapper = new AvisoMapper();

		if(mysql_num_rows($res) == 0) return $default;
		else {
			$mensajes = array();
			for($i=0; $i<mysql_num_rows($res); $i++) {
				$mensaje = new Mensaje();
				$mensaje->set('id', mysql_result($res, $i, 'id'));
				$mensaje->set('id_aviso', mysql_result($res, $i, 'id_aviso'));
				$mensaje->set('desde', mysql_result($res, $i, 'desde'));
				$mensaje->set('para', mysql_result($res, $i, 'para'));
				$mensaje->set('mensaje', mysql_result($res, $i, 'mensaje'));
				$mensaje->set('fecha', mysql_result($res, $i, 'fecha'));
				$mensaje->set('leido', mysql_result($res, $i, 'leido'));

				// Extras
				$desde = $usuarioMapper->findById($mensaje->get('desde'));
				$mensaje->set('_desde',$desde->get('nombre'));

				$para = $usuarioMapper->findById($mensaje->get('para'));
				$mensaje->set('_para',$para->get('nombre'));

				$aviso = $avisoMapper->findById($mensaje->get('id_aviso'));
				$mensaje->set('_aviso',$aviso->get('tipo')." ".$aviso->get('precio')." y ".$aviso->get('titulo'));

				$mensajes[] = $mensaje;
			}

			return $mensajes;
		}

	}

}
?>