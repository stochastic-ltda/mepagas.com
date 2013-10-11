<?php
if (!class_exists('Calificacion')) { include( dirname(__FILE__) . '/../classes/Objects/Calificacion.php'); }
if (!class_exists('CalificacionMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/CalificacionMapper.php'); }

if (!class_exists('Usuario')) { include( dirname(__FILE__) . '/../classes/Objects/Usuario.php'); }
if (!class_exists('UsuarioMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/UsuarioMapper.php'); }


// Obtengo datos
$calificacionMapper = new CalificacionMapper();
$calificacion = new Calificacion(null, $_POST['id_usuario'], $_POST['pituto'], null, $_POST['descripcion'], $_POST['recomendar'], $_POST['confiable'], $_POST['responsable'], $_POST['calidad'], $_POST['experiencia'], $_POST['id_califica']);

// Elimino calificacion ya existente para id_califica
$calificacionMapper->deleteByIds($_POST['id_usuario'], $_POST['id_califica'], $_POST['pituto']);

// Inserto nueva calificacion
$calificacionMapper->insert($calificacion);

// Actualizo calificaciones de usuario
// obtengo sumas de usuario
$medias = $calificacionMapper->getMedia($_POST['id_usuario']);

if($medias['recomendado']==0) {

	// creo objeto usuario
	$usuario = new Usuario();
	$usuario->set('r_recomendado', $_POST['recomendar']);
	$usuario->set('r_confiable', $_POST['confiable']);
	$usuario->set('r_responsable', $_POST['responsable']);
	$usuario->set('r_calidad', $_POST['calidad']);
	$usuario->set('r_experiencia', $_POST['experiencia']);
	$usuario->set('avatar', null);

} else {
	// creo objeto usuario
	$usuario = new Usuario();
	$usuario->set('r_recomendado', $medias['recomendado']);
	$usuario->set('r_confiable', $medias['confiable']);
	$usuario->set('r_responsable', $medias['responsable']);
	$usuario->set('r_calidad', $medias['calidad']);
	$usuario->set('r_experiencia', $medias['experiencia']);
	$usuario->set('avatar', null);
}

// actualizo registro de usuario
$usuarioMapper = new UsuarioMapper();
$usuarioMapper->update($_POST['id_usuario'], $usuario);

?>