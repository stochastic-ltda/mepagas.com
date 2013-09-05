<?php

//echo "<pre>"; print_r($_GET); die;
if(isset($_GET['f1'])) {

	$f1 = $_GET['f1'];
	if($f1 == 'publica-tu-pituto') {

		include("includes/publish.php");

	} elseif($f1 == 'usuario') {

		if(isset($_GET['f2'])) {

			$userid = $_GET['f2'];
			include("includes/user_controller.php");
			include("includes/user_view.php");

		} else {
			header("Location: /");
		}

	} elseif(is_numeric($f1) && isset($_GET['f2']) && (strpos($_GET['f2'], "me-pagas")!==false || strpos($_GET['f2'], "te-pago")!==false)) {

		include("includes/ficha_controller.php");
		include("includes/ficha_view.php");

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
		
		include("includes/search_controller.php");
			include("includes/search_view.php");
	}

} else {
	include("includes/search_controller.php");
	include("includes/search_view.php");
}

?>