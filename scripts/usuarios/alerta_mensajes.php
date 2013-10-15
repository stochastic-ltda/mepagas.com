<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../../includes/classes/Services/Database/Mysql.php'); }
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../../includes/classes/Mappers/UsuarioMapper.php'); }

$mysql = new Mysql();
$link = $mysql->connect();

$sql = "SELECT count(*) as unread, para, nombre, email FROM mensaje, usuario WHERE mensaje.para = usuario.id AND leido = 0 GROUP BY para";
$res = mysql_query($sql) or die(mysql_error());

$usuarioMapper = new UsuarioMapper();
for($i=0; $i<mysql_num_rows($res); $i++) {
	$usuarioMapper->sendAlertMensajeEmail(mysql_result($res, $i, "nombre"), mysql_result($res, $i, "email"), mysql_result($res, $i, "unread"));
}


?>