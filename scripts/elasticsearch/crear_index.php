<?php
if (!class_exists('ElasticSearch')) { include( dirname(__FILE__) . '/../../includes/classes/Services/Elasticsearch/Elasticsearch.php'); }

$elastic = new Elasticsearch("avisos");
// TODO: Mejorar la definicion del Index "avisos"
// TODO: Incluir mapping del tipo "aviso" dentro del index "avisos"
// Ejemplo: http://elastica.io/getting-started/storing-and-indexing-documents.html
try {

	$index = $elastic->createIndex(array());
	$mapping = array(
			'precio' => array('type' => 'integer'),
			'categoria' => array('type' => 'string', 'index' => 'not_analyzed')
		);
	$elastic->createType('aviso', $mapping);
	
} catch(Exception $e) {
	echo "<p>Ha ocurrido un error al crear el indice:</p>";
	echo "<pre>$e</pre>";
}


?>
