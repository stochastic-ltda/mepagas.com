<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }
if (!class_exists('Calificacion')) { include( dirname(__FILE__) . '/../Objects/Calificacion.php'); }

class CalificacionMapper {

	public function insert(Calificacion $c) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "INSERT INTO calificacion (id,id_usuario,id_aviso,detalle,r_recomendado,r_confiable,r_responsable,r_calidad,r_experiencia, id_califica) VALUES ('', ".$c->get('id_usuario').",".$c->get('id_aviso').",'".$c->get('detalle')."',".$c->get('r_recomendado').",".$c->get('r_confiable').",".$c->get('r_responsable').",".$c->get('r_calidad').",".$c->get('r_experiencia').", ".$c->get('id_califica').")";

		$res = mysql_query($sql) or die(mysql_error());		
		$id = mysql_insert_id();

		mysql_close($link);

	}

	public function deleteByIds($id_usuario, $id_califica, $id_aviso) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "DELETE FROM calificacion WHERE id_califica = $id_califica AND id_usuario = $id_usuario AND id_aviso = $id_aviso";
		$res = mysql_query($sql) or die(mysql_error());		

	}

	public function getMedia($id_usuario) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT AVG(r_recomendado) AS recomendado, AVG(r_confiable) AS confiable, AVG(r_responsable) AS responsable, AVG(r_calidad) AS calidad, AVG(r_experiencia) AS experiencia FROM calificacion WHERE id_usuario = $id_usuario";

		$res = mysql_query($sql) or die(mysql_error());
		$data = array(
				'recomendado' => mysql_result($res,0,"recomendado"),
				'confiable' => mysql_result($res,0,"confiable"),
				'responsable' => mysql_result($res,0,"responsable"),
				'calidad' => mysql_result($res,0,"calidad"),
				'experiencia' => mysql_result($res,0,"experiencia"),
			);

		return $data;
	}

	public function getCountByIdUser($id_user) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT count(*) as cantidad FROM calificacion WHERE id_usuario = $id_user";
		$res = mysql_query($sql) or die(mysql_error());

		return mysql_result($res, 0, "cantidad");

	}

	public function getByIdUser($id_user) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM calificacion WHERE id_usuario = $id_user ORDER BY fecha desc";
		$res = mysql_query($sql) or die(mysql_error());

		return $this->processReturn($res, null);

	}

	public function processReturn($res, $default) {

		if(mysql_num_rows($res) == 0) return $default;

		$calificaciones = array();
		$idx = 0;
		for($i=0; $i<mysql_num_rows($res); $i++) {

			$c = new Calificacion();
			$c->set('r_recomendado', mysql_result($res, $i, "r_recomendado"));
			$c->set('r_confiable', mysql_result($res, $i, "r_confiable"));
			$c->set('r_responsable', mysql_result($res, $i, "r_responsable"));
			$c->set('r_calidad', mysql_result($res, $i, "r_calidad"));
			$c->set('r_experiencia', mysql_result($res, $i, "r_experiencia"));
			$c->set('detalle', mysql_result($res, $i, "detalle"));
			$c->set('id_usuario', mysql_result($res, $i, "id_usuario"));
			$c->set('id_aviso', mysql_result($res, $i, "id_aviso"));
			$c->set('fecha', mysql_result($res, $i, "fecha"));
			$c->set('id_califica', mysql_result($res, $i, "id_califica"));

			// obtengo info del usuario
			if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../Mappers/UsuarioMapper.php'); }
			$usuarioMapper = new UsuarioMapper();
			$usuario = $usuarioMapper->findById(mysql_result($res, $i, "id_califica"));

			// obtengo info del aviso
			if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/../Mappers/AvisoMapper.php'); }
			$avisoMapper = new AvisoMapper();
			$aviso = $avisoMapper->findById(mysql_result($res, $i, "id_aviso"));

			$calificaciones[$idx]['calificacion'] = $c;
			$calificaciones[$idx]['usuario'] = $usuario;
			$calificaciones[$idx]['aviso'] = $aviso;
			$idx++;
		}

		return $calificaciones;

	}

}
?>