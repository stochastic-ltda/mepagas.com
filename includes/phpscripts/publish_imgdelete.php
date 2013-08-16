<?php
include(dirname(__FILE__) . '/../../config.php'); 
$config = new Config();

if(isset($_POST['img']) && !is_null($_POST['img'])) {

	$img = $_POST['img'];

	// TODO: Validar que estas imagenes no esten siendo utilizadas por alguna publicacion ya activa
	unlink($config->imgupload_path . $img);
	unlink($config->imgupload_path . "thumb_" . $img);

}

?>