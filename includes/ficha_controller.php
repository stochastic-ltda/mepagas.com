<?php
if (!class_exists('ElasticSearch')) { include( dirname(__FILE__) . '/classes/Services/Elasticsearch/Elasticsearch.php'); }
if (!class_exists('Cleaner')) { include( dirname(__FILE__) . '/classes/Services/General/Cleaner.php'); }

$elastic = new Elasticsearch();
$data = $elastic->getData('/avisos/aviso',$f1);
$data = get_object_vars($data->_source);

$precio = number_format($data['precio'], 0, ',', '.');
$title = $data['tipo'] . ' $' . $precio . ' y ' .  $data['titulo'];

$categoria_url = Cleaner::makeUrl($data['categoria']);
$subcategoria_url = Cleaner::makeUrl($data['subcategoria']);

// TODO: Obtener aviso en base a f1
// TODO: Cargar los datos de la ficha
// TODO: Cargar calificacion despues
// TODO: Cargar tabs despues
// TODO: agregar disqus
?>