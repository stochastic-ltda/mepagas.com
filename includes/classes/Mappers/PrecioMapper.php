<?php 
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../Services/Database/Mysql.php'); }
if (!class_exists('Precio')) { include( dirname(__FILE__) . '/../Objects/Precio.php'); }

class PrecioMapper {

	function getAll($order=null) {

		$mysql = new Mysql();
		$link = $mysql->connect();

		$sql = "SELECT * FROM precio ORDER BY valor ASC";
		$res = mysql_query($sql) or die(mysql_error());

		$precios = array();
		for($i=0; $i<mysql_num_rows($res); $i++) {
			$precio = new Precio();
			$precio->set("valor", mysql_result($res,$i,"valor"));
			$precio->set("nombre", mysql_result($res,$i,"nombre"));
			$precios[$i] = $precio;
		}

		return $precios;

	}

}
