<?php
if (!class_exists('Mysql')) { include( dirname(__FILE__) . '/../../includes/classes/Services/Database/Mysql.php'); }

$mysql = new Mysql();
$link = $mysql->connect();

$sql = "DELETE FROM usuario WHERE estado = 0 AND token!='' AND DATE_ADD(fecha_registro, INTERVAL 1 DAY) > CURDATE()";
$res = mysql_query($sql) or die(mysql_error());

?>