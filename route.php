<?php

if(isset($_GET['mod'])) {

	$mod = $_GET['mod'];
	switch ($mod) {
		
		case 'publica-tu-pituto':
			include("includes/publish.php");
			break;

		default:
			$term_precio = null;
			$term_categoria = null;			
			if(is_numeric($mod)) $term_precio = $mod;
			
			include("includes/search_controller.php");
			include("includes/search_view.php");
			break;
		
	}

} else {
	include("includes/search_controller.php");
	include("includes/search_view.php");
}

?>