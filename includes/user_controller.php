<?php
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/classes/Mappers/UsuarioMapper.php'); }
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/classes/Mappers/AvisoMapper.php'); }

$usuarioMapper = new UsuarioMapper();
$avisoMapper = new AvisoMapper();

$user = $usuarioMapper->findById($userid);

// aviso find by id usuario
// favoritos find by id usuario
// imprimir informacion de usuario, listado favoritos, listado avisos
// check cookies para agregar links seguros de edicion de informacion
// si es de facebook solo permite modificar el telefono
// si no es de facebook permite modificar toda la informacion

?>