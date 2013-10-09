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

	public function deleteByIds($id_usuario, $id_califica) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "DELETE FROM calificacion WHERE id_califica = $id_califica AND id_usuario = $id_usuario";
		$res = mysql_query($sql) or die(mysql_error());		

	}

	public function getMedia($id_califica) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT AVG(r_recomendado) AS recomendado, AVG(r_confiable) AS confiable, AVG(r_responsable) AS responsable, AVG(r_calidad) AS calidad, AVG(r_experiencia) AS experiencia FROM calificacion WHERE id_usuario = $id_califica";

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

}
?>