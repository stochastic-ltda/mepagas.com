<?php
$mod = $_GET['mod'];
switch ($mod) {
	case 'publica-tu-pituto':
		include("includes/publish.php");
		break;

	case '':
		include("includes/search.php");
		break;
	
	default:
		// logica despliegue
		break;
}

?>