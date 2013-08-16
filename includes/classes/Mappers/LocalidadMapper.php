<?php 
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }
if (!class_exists('Localidad')) { include( dirname(__FILE__) . '/../Objects/Localidad.php'); }

class LocalidadMapper {

	function getAll($order=null) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM localidad ORDER BY nombre ASC";
		$res = mysql_query($sql) or die(mysql_error());

		$localidads = array();
		for($i=0; $i<mysql_num_rows($res); $i++) {
			$localidad = new Localidad();
			$localidad->set("id", mysql_result($res,$i,"id"));
			$localidad->set("nombre", mysql_result($res,$i,"nombre"));
			$localidad->set("permalink", mysql_result($res,$i,"permalink"));
			$localidads[$i] = $localidad;
		}

		return $localidads;

	}

}
