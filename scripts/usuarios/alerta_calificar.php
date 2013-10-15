<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../../includes/classes/Services/Database/Mysql.php'); }
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../../includes/classes/Mappers/UsuarioMapper.php'); }

$mysql = new Mysql();
$link = $mysql->connect();

$usuarioMapper = new UsuarioMapper();

// Obtengo mensajes unicos desde la ultima semana. La tupla que debe ser unica es la del desde, para
$sql = "SELECT * FROM mensaje WHERE DATE_ADD(date(fecha), INTERVAL 7 DAY) >= date(now())";
$res = mysql_query($sql) or die(mysql_error());

for($i=0; $i<mysql_num_rows($res); $i++) {
	// Obtengo informacion del desde (a quien enviare el email)
	$id_desde = mysql_result($res, $i, "desde");
	$userDesde = $usuarioMapper->findById($id_desde);

	// Obtengo informacion del para (a quien calificare)
	$id_para = mysql_result($res, $i, "para");
	$userPara = $usuarioMapper->findById($id_para);

	// Envio email
	$usuarioMapper->sendAlertCalificaEmail($userDesde->get('nombre'), $userDesde->get('email'), $userPara->get('nombre'), $userPara->get('id'));
}

?>