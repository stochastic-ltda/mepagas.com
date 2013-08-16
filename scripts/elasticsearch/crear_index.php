<?php
if (!class_exists('ElasticSearch')) { include( dirname(__FILE__) . '/../../includes/classes/Services/Elasticsearch/Elasticsearch.php'); }

$elastic = new Elasticsearch("avisos");
// TODO: Mejorar la definicion del Index "avisos"
// Ejemplo: http://elastica.io/getting-started/storing-and-indexing-documents.html
try {
	$elastic->createIndex(array());
} catch(Exception $e) {
	echo "<p>Ha ocurrido un error al crear el indice:</p>";
	echo "<pre>$e</pre>";
}

// TODO: Incluir mapping del tipo "aviso" dentro del index "avisos"
// Ejemplo: http://elastica.io/getting-started/storing-and-indexing-documents.html

?>