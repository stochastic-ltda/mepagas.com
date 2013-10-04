<?php

//echo "<pre>"; print_r($_GET); die;
if(isset($_GET['f1'])) {

	$f1 = $_GET['f1'];
	if($f1 == 'publica-tu-pituto') {

		include("includes/publish.php");

	} elseif($f1 == 'aviso') {

		if(isset($_GET['f2']) && isset($_GET['f3'])) {
			$avisoid = $_GET['f3'];
			if($_GET['f2'] == 'editar') {
				include("includes/publish_edit.php");				
			}
		}

	} elseif($f1 == 'usuario') {

		if(isset($_GET['f2'])) {

			if($_GET['f2'] == "editar") {
				$userid = $_GET['f3'];
				include("includes/application/controllers/user_edit.php");
				include("includes/application/views/user_edit.php");

			} elseif($_GET['f2'] == 'recuperar-clave') {
				include("includes/application/controllers/user_recover.php");
				include("includes/application/views/user_recover.php");

			} elseif($_GET['f2'] == 'enviar-activacion') {
				include("includes/application/controllers/user_enviar_activacion.php");
				include("includes/application/views/user_enviar_activacion.php");

			} elseif($_GET['f2'] == 'activar') {
				$token = $_GET['f3'];
				include("includes/application/controllers/user_activar.php");
				include("includes/application/views/user_activar.php");

			} else {
				$userid = $_GET['f2'];
				include("includes/application/controllers/user_account.php");
				include("includes/application/views/user_account.php");
			}

		} else {
			header("Location: /");
		}

	} elseif(is_numeric($f1) && isset($_GET['f2']) && (strpos($_GET['f2'], "me-pagas")!==false || strpos($_GET['f2'], "te-pago")!==false)) {

		include("includes/application/controllers/ficha.php");
		include("includes/application/views/ficha.php");

	} else {
		$term_precio = null;
		$term_categoria = null;		
		$term_subcategoria = null;

		if(is_numeric($f1)) $term_precio = $f1;
		else $term_categoria = $f1;

		if(isset($_GET['f2'])) {
			$f2 = $_GET['f2'];
			if(isset($_GET['f3'])) {
				$term_categoria = $f2;
				$term_subcategoria = $_GET['f3'];
			} else {
				if(is_null($term_categoria)) $term_categoria = $f2;
				else $term_subcategoria = $f2;
			}
		}
		
		include("includes/application/controllers/search.php");
			include("includes/application/views/search.php");
	}

} else {
	include("includes/application/controllers/search.php");
	include("includes/application/views/search.php");
}

?>