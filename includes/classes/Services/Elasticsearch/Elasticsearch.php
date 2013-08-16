<?php
include( dirname(__FILE__) . '/../../../vendor/autoload.php');

class Elasticsearch {

	protected $_client;
	protected $_index;

	protected $_results;
	protected $_facets;
	protected $_total;
	
	function __construct($index=null){

		if(!is_null($index)) {
			$this->_client = new \Elastica\Client( array('host' => 'mepagas.dev','port' => 9200) );
			$this->_index = $this->_client->getIndex($index);
		}
	}

	/**
	 * Retorna resultados de busqueda
	 * @return array results 
	 */
	function getResults() {
		return $this->_results;
	}

	/**
	 * Retorna facets de busqueda
	 * @return array facets 
	 */
	function getFacets() {
		return $this->_facets;
	}

	/**
	 * Retorna numero de resultados de busqueda
	 * @return array total 
	 */
	function getTotal() {
		return $this->_total;
	}

	/**
	* Busqueda orientada al texto (query_string)
	*
	* @param string $term Texto de busqueda
	* @param mixed $params Parametros de busqueda
	*/
	function doSearch($term, $params) {

		// echo "<p>freetext: $term</p>"; echo "<pre>"; print_r($params); echo "</pre>"; die;
		$bool = new Elastica\Query\Bool();

		// Query String
		if(!is_null($term)) {
			$term = new Elastica\Query\QueryString($term);
			$bool->addMust($term);
		}

		// Range 
		if(isset($params['range'])) {
			for($i=0; $i<count($params['range']); $i++) {
				$must = new Elastica\Query\Range($params['range'][$i]['field'], $params['range'][$i]['range']);
				$bool->addMust($must);
			}
		}

		// Terminos		
		if(isset($params['term'])) {
			for($i=0; $i<count($params['term']); $i++) {
				$must = new Elastica\Query\Term($params['term'][$i]);
				$bool->addMust($must);
			}		
		}

		$query = new Elastica\Query();
		if(count($bool->getParams()) > 0)
			$query->setQuery($bool);

		// Posicion inicial
		if(isset($params['page']) && isset($params['limit'])) {
			$query->setFrom($params['page']*$params['limit']);
		} else if(isset($params['page']) && !isset($params['limit'])) {
			$query->setFrom($params['page']*10);
		} else {
			$query->setFrom(0);  	
		}
		

		// Facets
		if(isset($params['facets'])) {
			for($i=0; $i<count($params['facets']); $i++) {
				$facet = new \Elastica\Facet\Terms($params['facets'][$i]['field']);				
				$facet->setField($params['facets'][$i]['field']);

				if(isset($params['facets'][$i]['size'])) $facet->setSize($params['facets'][$i]['size']);
				if(isset($params['facets'][$i]['order'])) $facet->setOrder($params['facets'][$i]['order']);
				$query->addFacet($facet);
			}	
		}		

		if(isset($params['limit'])) $query->setLimit($params['limit']); // numero resultados
		if(isset($params['sort']))	$query->setSort($params['sort']);	// orden resultados

		$params = $query->getParams();
		// echo "<pre>"; print_r($params); die;

		$resultSet = $this->_index->search($query);

		$this->_results = $resultSet->getResults();	// listado resultados
		$this->_total = $resultSet->getTotalHits();	// numero resultados
		$this->_facets = $resultSet->getFacets();	// facets
		
	}

	/**
	 * Descarga la data via http
	 *
	 * @param string path Ruta /Index/Type del aviso
	 * @param string id Identificador unico de aviso
	 * @return array data Array con datos del aviso
	 */
	function getData($path, $id) {

		$url = 'http://elasticsearch.mersap.com' . $path . "/" . $id;
		$data = file_get_contents($url);
		$data = json_decode($data);

		return $data;

	}

	/**
	 * Retorna el index
	 * @return Elastica\Index index 
	 */
	function getIndex() {
		return $this->_index;
	}


	/**
	 * Crear indice
	 *
	 * @param string name Nombre del indice
	 * @param mixed def Definicion del indice
	 * @return Elastica\Index index Indice creado
	 */
	function createIndex($indexDef) {
		$this->_index->create($indexDef);
		return $this->_index;
	}

	function insertDocument($typeName, $id,  $doc) {

		$type = $this->_index->getType($typeName);
		$newDoc = new Elastica\Document($id, $doc);
		$type->addDocument($newDoc);

		$this->_index->refresh();

	}

}
