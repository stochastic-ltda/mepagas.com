<?php
if (!class_exists('SubcategoriaMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/SubcategoriaMapper.php'); }

$id_categoria = $_POST['id_categoria'];

if($id_categoria != '') {
	$subcatMapper = new SubcategoriaMapper();
	$categorias = $subcatMapper->getByIdCategoria($id_categoria);
}

echo '<label for="categorias">Subtegorías </label>';
echo '<select name="subcategorias" id="subcategorias">';
echo '	<option value="">Selecciona una subcategoría</option>';

if($id_categoria != '') {
	foreach($categorias as $c) {
		echo '<option value="' . utf8_encode($c->get('nombre')) . '">' . utf8_encode($c->get('nombre')) . '</option>';
	}
}

echo '</select>';

?>