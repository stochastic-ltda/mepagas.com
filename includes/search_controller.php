<?php
if (!class_exists('ElasticSearch')) { include( dirname(__FILE__) . '/classes/Services/Elasticsearch/Elasticsearch.php'); }
// TODO: Configurar rutas en htaccess
// TODO: Configurar clase para manejo de queries segun busquedas

// Se genera busqueda simple que entregue ultimos 20 avisos ordenados del mas nuevo al mas antiguo
$elastic = new Elasticsearch("avisos");

$params['limit'] = 20;	
$params['sort'] = array(array('fecha_creacion' => array('order' => 'asc')));

$params['facets'][0] = array('field' => 'precio', 'order' => 'term');
$params['facets'][1] = array('field' => 'categoria', 'order' => 'term');

$elastic->doSearch(null, $params);
$results = $elastic->getResults();
$facets = $elastic->getFacets();

?>