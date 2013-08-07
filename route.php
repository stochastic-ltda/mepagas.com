<?php
$uri = $_SERVER['REQUEST_URI'];

switch ($uri) {
	case '/publica-tu-pituto':
		include("includes/publish.php");
		break;

	case '/':
		include("includes/search.php");
		break;
	
	default:
		// logica despliegue
		break;
}

?>