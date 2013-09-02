<?php
if (!class_exists('ElasticSearch')) { include( dirname(__FILE__) . '/classes/Services/Elasticsearch/Elasticsearch.php'); }
if (!class_exists('CategoriaMapper')) { include( dirname(__FILE__) . '/classes/Mappers/CategoriaMapper.php'); }
if (!class_exists('SubcategoriaMapper')) { include( dirname(__FILE__) . '/classes/Mappers/SubcategoriaMapper.php'); }
// TODO: Configurar rutas en htaccess
// TODO: Configurar clase para manejo de queries segun busquedas


// Se genera busqueda simple que entregue ultimos 20 avisos ordenados del mas nuevo al mas antiguo
$elastic = new Elasticsearch("avisos");

$params['limit'] = 20;	
$params['sort'] = array(array('fecha_creacion' => array('order' => 'desc')));

$tidx=$fidx=0; // term index, facet index

$params['facets'][$fidx++] = array('field' => 'precio', 'order' => 'term');
$params['facets'][$fidx++] = array('field' => 'categoria', 'order' => 'term');

if(isset($term_precio)) $params['term'][$tidx++]['precio'] = $term_precio;
if(isset($term_categoria)) {
	$params['term'][$tidx++]['categoria'] = CategoriaMapper::getNombreByPermalink($term_categoria);
	$params['facets'][$fidx++] = array('field' => 'subcategoria', 'order' => 'term');
}

if(isset($term_subcategoria)) $params['term'][$tidx++]['subcategoria'] = utf8_encode(SubcategoriaMapper::getNombreByPermalink(($term_subcategoria)));

//echo "<pre>"; print_r($params);

$elastic->doSearch(null, $params);
$results = $elastic->getResults();
$facets = $elastic->getFacets();

?>