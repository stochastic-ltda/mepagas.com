<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../../includes/classes/Services/Database/Mysql.php'); }
if (!class_exists('ElasticSearch')) { include( dirname(__FILE__) . '/../../includes/classes/Services/Elasticsearch/Elasticsearch.php'); }

$mysql = new Mysql();
$link = $mysql->connect();

$elastic = new Elasticsearch("avisos");

// Obtengo avisos que no han sido publicados
$sql = "SELECT * FROM aviso WHERE publicado = 1";
$res = mysql_query($sql) or die(mysql_error());

// Si existen avisos no publicados
if(mysql_num_rows($res)) {

	// Por cada uno de los avisos no publicados
	for($i=0; $i<mysql_num_rows($res); $i++) {

		$idAviso = mysql_result($res, $i, "id");

		// Obtengo sus imagenes		
		$sql = "SELECT * FROM aviso_imagen WHERE id_aviso = $idAviso ORDER BY id ASC";
		$img = mysql_query($sql) or die(mysql_error());

		// Obtengo localidades
		$sql = "SELECT * FROM aviso_localidad WHERE id_aviso = $idAviso ORDER BY id ASC";
		$loc = mysql_query($sql) or die(mysql_error());

		// Genero el "documento"
		$doc = array(
				"id" => mysql_result($res, $i, "id"),
				"id_usuario" => mysql_result($res, $i, "id_usuario"),
				"tipo" => mysql_result($res, $i, "tipo"),
				"precio" => mysql_result($res, $i, "precio"),
				"titulo" => mysql_result($res, $i, "titulo"),
				"categoria" => mysql_result($res, $i, "categoria"),
				"subcategoria" => mysql_result($res, $i, "subcategoria"),
				"descripcion" => mysql_result($res, $i, "descripcion"),
				"fecha_creacion" => mysql_result($res, $i, "fecha_creacion"),
				"fecha_modificacion" => mysql_result($res, $i, "fecha_modificacion"),
				"permalink" => mysql_result($res, $i, "permalink"),
				"estado" => mysql_result($res, $i, "estado"),
				"comentarios" => mysql_result($res, $i, "comentarios")
			);

		// Reviso si ya tiene un thumbnail agregado
		$conThumb = false;
		if(mysql_result($res, $i, "thumbnail") != '') { 
			$doc['thumbnail'] = mysql_result($res, $i, "thumbnail");
			$conThumb = true;
		}

		// Cargo imagenes
		for($j=0; $j<mysql_num_rows($img); $j++) {
			if($j==0 && !$conThumb) $doc["thumbnail"] = "thumb_" . mysql_result($img, $j, "imagen");
			$doc["imagenes"][$j] = mysql_result($img, $j, "imagen");
		}		

		// Cargo localidad
		for($k=0; $k<mysql_num_rows($loc); $k++) {
			$doc["localidades"][$k] = mysql_result($loc, $k, "localidad");
		}	

		// Cargo "documento" en Elasticsearch
		$elastic->insertDocument("aviso", $idAviso, $doc);		

		// Actualizo registro en bd a publicado=1
		$sql = "UPDATE aviso SET publicado=1 WHERE id = $idAviso";
		$upd = mysql_query($sql) or die(mysql_error());

	}			

}

?>
