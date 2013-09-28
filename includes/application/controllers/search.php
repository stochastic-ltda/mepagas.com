<?php
if (!class_exists('ElasticSearch')) { include( dirname(__FILE__) . '/../../classes/Services/Elasticsearch/Elasticsearch.php'); }
if (!class_exists('CategoriaMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/CategoriaMapper.php'); }
if (!class_exists('SubcategoriaMapper')) { include( dirname(__FILE__) . '/../../classes/Mappers/SubcategoriaMapper.php'); }

// Se genera busqueda simple que entregue ultimos 20 avisos ordenados del mas nuevo al mas antiguo
$elastic = new Elasticsearch("avisos");

$params['limit'] = 20;	
$params['sort'] = array(array('fecha_creacion' => array('order' => 'desc')));
if(isset($_REQUEST['p'])) $params['page'] = $_REQUEST['p'];

$tidx=$fidx=0; // term index, facet index
$params['facets'][$fidx++] = array('field' => 'precio', 'order' => 'term');
$params['facets'][$fidx++] = array('field' => 'categoria', 'order' => 'term');

if(isset($term_precio)) $params['term'][$tidx++]['precio'] = $term_precio;
if(isset($term_categoria)) {
	$params['term'][$tidx++]['categoria'] = CategoriaMapper::getNombreByPermalink($term_categoria);
	$params['facets'][$fidx++] = array('field' => 'subcategoria', 'order' => 'term');
}

$params['term'][$tidx++]['estado'] = 'activo'; // Muestra solo activos

if(isset($term_subcategoria)) $params['term'][$tidx++]['subcategoria'] = utf8_encode(SubcategoriaMapper::getNombreByPermalink(($term_subcategoria)));

//echo "<pre>"; print_r($params);

$elastic->doSearch(null, $params);
$results = $elastic->getResults();
$facets = $elastic->getFacets();
$total = $elastic->getTotal();

// Metadata
$h1 = "Últimos avisos";
$title = "Gana dinero publicando GRATIS tu pituto";
if(isset($term_precio)  && isset($term_subcategoria)) $title = "Pitutos en " . utf8_encode(SubcategoriaMapper::getNombreByPermalink(($term_subcategoria))) ." a $$term_precio pesos";
elseif(isset($term_precio)  && isset($term_categoria)) $title = "Pitutos en " . CategoriaMapper::getNombreByPermalink($term_categoria) . " a $$term_precio pesos";
elseif(isset($term_precio)) $title = "Pitutos a $$term_precio pesos";
elseif(isset($term_subcategoria)) $title = "Pitutos en " . utf8_encode(SubcategoriaMapper::getNombreByPermalink(($term_subcategoria)));
elseif(isset($term_categoria)) $title = "Pitutos en " . CategoriaMapper::getNombreByPermalink($term_categoria);

if(str_replace("GRATIS", "", $title) == $title) $h1 = $title;


$description = "Encuentra todos los pitutos";
if(isset($term_subcategoria)) $description .= " en " . utf8_encode(SubcategoriaMapper::getNombreByPermalink(($term_subcategoria)));
elseif(isset($term_categoria)) $description .= " en " . CategoriaMapper::getNombreByPermalink($term_categoria);

if(isset($term_precio)) $description .=" a sólo $$term_precio pesos";

?>