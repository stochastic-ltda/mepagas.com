<?php
if (!class_exists('ElasticSearch')) { include( dirname(__FILE__) . '/classes/Services/Elasticsearch/Elasticsearch.php'); }
// TODO: Configurar rutas en htaccess
// TODO: Configurar clase para manejo de queries segun busquedas


// Se genera busqueda simple que entregue ultimos 20 avisos ordenados del mas nuevo al mas antiguo
$elastic = new Elasticsearch("avisos");

$params['limit'] = 20;	
$params['sort'] = array(array('fecha_creacion' => array('order' => 'desc')));

$params['facets'][0] = array('field' => 'precio', 'order' => 'term');
$params['facets'][1] = array('field' => 'categoria', 'order' => 'term');

$idx=0;
if(isset($term_precio)) $params['term'][$idx++]['precio'] = $term_precio;

$elastic->doSearch(null, $params);
$results = $elastic->getResults();
$facets = $elastic->getFacets();

?>