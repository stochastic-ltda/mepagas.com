<?php

if (!class_exists('Permalink')) { require_once( dirname(__FILE__) . '/Permalink.php'); }
if (!class_exists('Region')) { require_once( dirname(__FILE__) . '/Region.php'); }

class SearchRouter {

	protected $_request;
	protected $_mercado;
	protected $_region;

	protected $_data;

	protected $_permalink;

	function __construct($mercado, $request) {
		$this->_mercado = $mercado;
		$this->_request = $request;

		$this->_region = new Region();
		$this->_data = Array();

		$this->_permalink = new Permalink();
	}

	public function processRequest() {
		if($this->_mercado == 'productos') $this->_processProductos();
		if($this->_mercado == 'propiedades') $this->_processPropiedades();
		if($this->_mercado == 'servicios-y-empleo') $this->_processServicios();
		if($this->_mercado == 'vehiculos') $this->_processVehiculos();
		if($this->_mercado == 'remates') $this->_processRemates();

		$this->_data['limit'] = 20;	
		$this->_data['sort'] = array( array( 'fechaPrimeraPub' => array('order' => 'desc')));
	}

	public function _processServicios() {

		if( isset($this->_request['cat1']) ) {

			// region/categoria2/categoria3
			if(isset($this->_request['cat1']) && isset($this->_request['cat2']) && isset($this->_request['cat3'])) {

				$this->_data['term'][0]['mercado'] = 'Servicios y Empleo';
				$this->_data['term'][1]['region'] = utf8_encode($this->_permalink->getNameByPrettyname('region', $this->_request['cat1']));
				$this->_data['term'][2]['categoria2'] = utf8_encode($this->_permalink->getNameByPrettyname('categoria2', $this->_request['cat2']));
				$this->_data['term'][3]['categoria3'] = utf8_encode($this->_permalink->getNameByPrettyname('categoria3', $this->_request['cat3']));

				$this->_data['title'] = $this->_data['term'][3]['categoria3'].' en '.$this->_data['term'][1]['region'] ;
				$this->_data['breadcrumb'] = $this->genBreadcrumb('servicios y empleo',array($this->_request['cat1'],$this->_request['cat2'],$this->_request['cat3']));
			}

			// region/categoria2
			elseif(isset($this->_request['cat1']) && isset($this->_request['cat2'])) {

				$this->_data['term'][0]['mercado'] = 'Servicios y Empleo';
				$this->_data['term'][1]['region'] = utf8_encode($this->_permalink->getNameByPrettyname('region', $this->_request['cat1']));
				$this->_data['term'][2]['categoria2'] = utf8_encode($this->_permalink->getNameByPrettyname('categoria2', $this->_request['cat2']));
				$this->_data['facets'][0] = array('field' => 'categoria3', 'size' => '100', 'order' => 'term');

				$this->_data['title'] = $this->_data['term'][2]['categoria2'].' en '.$this->_data['term'][1]['region'] ;
				$this->_data['breadcrumb'] = $this->genBreadcrumb('servicios y empleo',array($this->_request['cat1'],$this->_request['cat2']));

			}

			// region/
			else {				
				$this->_data['term'][0]['mercado'] = 'Servicios y Empleo';
				$this->_data['term'][1]['region'] = utf8_encode($this->_permalink->getNameByPrettyname('region', $this->_request['cat1']));
				$this->_data['facets'][0] = array('field' => 'categoria2', 'size' => '200', 'order' => 'term');

				$this->_data['title'] = 'Servicios y Empleos en '.$this->_data['term'][1]['region'];
				$this->_data['breadcrumb'] = $this->genBreadcrumb('servicios y empleo',array($this->_request['cat1']));
			}

		}

		// --------------------------------------- //
		// DEFAULT 
		// --------------------------------------- //
		else {
			$this->_data['term'][0]['mercado'] = 'Servicios y Empleo';
			$this->_data['facets'][0] = array('field' => 'region', 'size' => '100', 'order' => 'term');

			$this->_data['title'] = 'Servicios y Empleos';
			$this->_data['description'] = '';
			$this->_data['breadcrumb'] = $this->genBreadcrumb('servicios y empleo',null);
		}

	}

	public function _processProductos() {

		if( isset($this->_request['cat1']) ) {

			// region/categoria2/categoria3
			if(isset($this->_request['cat1']) && isset($this->_request['cat2']) && isset($this->_request['cat3'])) {

				$this->_data['term'][0]['mercado'] = 'Productos';
				$this->_data['term'][1]['region'] = utf8_encode($this->_permalink->getNameByPrettyname('region', $this->_request['cat1']));
				$this->_data['term'][2]['categoria2'] = utf8_encode($this->_permalink->getNameByPrettyname('categoria2', $this->_request['cat2']));
				$this->_data['term'][3]['categoria3'] = utf8_encode($this->_permalink->getNameByPrettyname('categoria3', $this->_request['cat3']));

				$this->_data['title'] = $this->_data['term'][3]['categoria3'].' en '.$this->_data['term'][1]['region'];
				$this->_data['breadcrumb'] = $this->genBreadcrumb('productos',array($this->_request['cat1'],$this->_request['cat2'],$this->_request['cat3']));
			}

			// region/categoria2
			elseif(isset($this->_request['cat1']) && isset($this->_request['cat2'])) {

				$this->_data['term'][0]['mercado'] = 'Productos';
				$this->_data['term'][1]['region'] = utf8_encode($this->_permalink->getNameByPrettyname('region', $this->_request['cat1']));
				$this->_data['term'][2]['categoria2'] = utf8_encode($this->_permalink->getNameByPrettyname('categoria2', $this->_request['cat2']));
				$this->_data['facets'][0] = array('field' => 'categoria3', 'size' => '100', 'order' => 'term');

				$this->_data['title'] = $this->_data['term'][2]['categoria2'].' en '.$this->_data['term'][1]['region'];
				$this->_data['breadcrumb'] = $this->genBreadcrumb('productos',array($this->_request['cat1'],$this->_request['cat2']));

			}

			// region/
			else {				
				$this->_data['term'][0]['mercado'] = 'Productos';
				$this->_data['term'][1]['region'] = utf8_encode($this->_permalink->getNameByPrettyname('region', $this->_request['cat1']));
				$this->_data['facets'][0] = array('field' => 'categoria2', 'size' => '200', 'order' => 'term');

				$this->_data['title'] = 'Productos en '.$this->_data['term'][1]['region'];
				$this->_data['breadcrumb'] = $this->genBreadcrumb('productos',array($this->_request['cat1']));
			}

		}

		// --------------------------------------- //
		// DEFAULT 
		// --------------------------------------- //
		else {
			$this->_data['term'][0]['mercado'] = 'Productos';
			$this->_data['facets'][0] = array('field' => 'region', 'size' => '100', 'order' => 'term');

			$this->_data['title'] = 'Productos';
			$this->_data['breadcrumb'] = $this->genBreadcrumb('productos',null);
		}

	}

	private function _processPropiedades() {

		//echo "<pre>"; print_r($this->_request); echo "</pre>";

		if( isset($this->_request['cat1']) ) {

			// comuna/operacion/tipopropiedad
			if(isset($this->_request['cat1']) && isset($this->_request['cat2']) && isset($this->_request['cat3'])) {

				$this->_data['term'][0]['mercado'] = 'Propiedades';
				$this->_data['term'][1]['comuna'] = utf8_encode($this->_permalink->getNameByPrettyname('comuna', $this->_request['cat1']));
				$this->_data['term'][2]['operacion'] = utf8_encode($this->_permalink->getNameByPrettyname('operacion', $this->_request['cat2']));
				$this->_data['term'][3]['tipopropiedad'] = utf8_encode($this->_permalink->getNameByPrettyname('tipopropiedad', $this->_request['cat3']));

				$this->_data['title'] = $this->_data['term'][3]['tipopropiedad'].' en '.$this->_data['term'][2]['operacion'].' en '.$this->_data['term'][1]['comuna'];
				$this->_data['breadcrumb'] = $this->genBreadcrumb('propiedades',array($this->_request['cat1'],$this->_request['cat2'],$this->_request['cat3']));
			}

			// comuna/operacion
			elseif(isset($this->_request['cat1']) && isset($this->_request['cat2'])) {

				$this->_data['term'][0]['mercado'] = 'Propiedades';
				$this->_data['term'][1]['comuna'] = utf8_encode($this->_permalink->getNameByPrettyname('comuna', $this->_request['cat1']));
				$this->_data['term'][2]['operacion'] = utf8_encode($this->_permalink->getNameByPrettyname('operacion', $this->_request['cat2']));
				$this->_data['facets'][0] = array('field' => 'tipopropiedad', 'size' => '100', 'order' => 'term');

				$this->_data['title'] = $this->_data['term'][2]['operacion'].' de propiedades en '.$this->_data['term'][1]['comuna'] ;
				$this->_data['breadcrumb'] = $this->genBreadcrumb('propiedades',array($this->_request['cat1'],$this->_request['cat2']));

			}

			// comuna
			elseif(isset($this->_request['cat1']) && !$this->_region->isRegion($this->_request['cat1'])) {

				$this->_data['term'][0]['mercado'] = 'Propiedades';
				$this->_data['term'][1]['comuna'] = utf8_encode($this->_permalink->getNameByPrettyname('comuna', $this->_request['cat1']));
				$this->_data['facets'][0] = array('field' => 'operacion');

				$this->_data['title'] = 'Venta y arriendo de propiedades en '.$this->_data['term'][1]['comuna'];
				$this->_data['breadcrumb'] = $this->genBreadcrumb('propiedades',array($this->_request['cat1']));
			}

			// region
			else {				
				$this->_data['term'][0]['mercado'] = 'Propiedades';
				$this->_data['term'][1]['region'] = trim(utf8_encode($this->_permalink->getNameByPrettyname('region', $this->_request['cat1'])));
				$this->_data['facets'][0] = array('field' => 'comuna', 'size' => '200', 'order' => 'term');

				$this->_data['title'] = 'Venta y arriendo de propiedades en '.$this->_data['term'][1]['region'];
				$this->_data['breadcrumb'] = $this->genBreadcrumb('propiedades',array($this->_request['cat1']));

				//echo "<pre>"; print_r($this->_data); echo "</pre>";
			}

		}

		// --------------------------------------- //
		// DEFAULT 
		// --------------------------------------- //
		else {
			$this->_data['term'][0]['mercado'] = 'Propiedades';
			$this->_data['facets'][0] = array('field' => 'region', 'size' => '100', 'order' => 'term');

			$this->_data['title'] = 'Propiedades en venta y arriendo';
			$this->_data['breadcrumb'] = $this->genBreadcrumb('propiedades',null);
		}

	}

	private function _processVehiculos() {

		// --------------------------------------- //
		// ESTADO 
		// --------------------------------------- //
		if( isset($this->_request['cat1']) && in_array($this->_request['cat1'], array('usado','nuevo')) ) {

			// estado/tipo/marca/modelo
			if(isset($this->_request['cat1']) && isset($this->_request['cat2']) && isset($this->_request['cat3']) && isset($this->_request['cat4'])) {

				$this->_data['term'][0]['mercado'] = 'Vehiculos';
				$this->_data['term'][1]['estado'] = $this->_request['cat1'];
				$this->_data['term'][2]['categoria2'] = utf8_encode($this->_permalink->getNameByPrettyname('categoria2', $this->_request['cat2']));
				$this->_data['term'][3]['marca'] = utf8_encode($this->_permalink->getNameByPrettyname('marca', $this->_request['cat3']));
				$this->_data['term'][4]['modelo'] = utf8_encode($this->_permalink->getNameByPrettyname('modelo', $this->_request['cat4']));

				$this->_data['title'] = $this->_data['term'][3]['marca'].' '.$this->_data['term'][4]['modelo'].' '.$this->_data['term'][1]['estado'].'s';
				$this->_data['breadcrumb'] = $this->genBreadcrumb('vehiculos',array($this->_request['cat1'],$this->_request['cat2'],$this->_request['cat3'],$this->_request['cat4']));

			}

			// estado/tipo/marca
			elseif(isset($this->_request['cat1']) && isset($this->_request['cat2']) && isset($this->_request['cat3'])) {

				$this->_data['term'][0]['mercado'] = 'Vehiculos';
				$this->_data['term'][1]['estado'] = $this->_request['cat1'];
				$this->_data['term'][2]['categoria2'] = utf8_encode($this->_permalink->getNameByPrettyname('categoria2', $this->_request['cat2']));
				$this->_data['term'][3]['marca'] = utf8_encode($this->_permalink->getNameByPrettyname('marca', $this->_request['cat3']));
				$this->_data['facets'][0] = array('field' => 'modelo', 'size' => '100', 'order' => 'term');

				$this->_data['title'] = $this->_data['term'][3]['marca'].' '.$this->_data['term'][1]['estado'].'s';
				$this->_data['breadcrumb'] = $this->genBreadcrumb('vehiculos',array($this->_request['cat1'],$this->_request['cat2'],$this->_request['cat3']));

			}

			// estado/tipo
			elseif(isset($this->_request['cat1']) && isset($this->_request['cat2'])) {

				$this->_data['term'][0]['mercado'] = 'Vehiculos';
				$this->_data['term'][1]['estado'] = $this->_request['cat1'];
				$this->_data['term'][2]['categoria2'] = utf8_encode($this->_permalink->getNameByPrettyname('categoria2', $this->_request['cat2']));
				$this->_data['facets'][0] = array('field' => 'marca', 'size' => '100', 'order' => 'term');

				$this->_data['title'] = 'Venta de '.$this->_data['term'][2]['categoria2'].' '.$this->_data['term'][1]['estado'].'s';
				$this->_data['breadcrumb'] = $this->genBreadcrumb('vehiculos',array($this->_request['cat1'],$this->_request['cat2']));

			}

			// estado
			else {

				$this->_data['term'][0]['mercado'] = 'Vehiculos';
				$this->_data['term'][1]['estado'] = $this->_request['cat1'];
				$this->_data['facets'][0] = array('field' => 'categoria2', 'size' => '100', 'order' => 'term');

				$this->_data['title'] = 'Venta de autos '.$this->_data['term'][1]['estado'].'s';
				$this->_data['breadcrumb'] = $this->genBreadcrumb('vehiculos',array($this->_request['cat1']));

			}

		}

		// --------------------------------------- //
		// COMUNAS 
		// --------------------------------------- //
		else if( isset($this->_request['cat1']) ) {

			// comuna/estado/tipo
			if(isset($this->_request['cat1']) && isset($this->_request['cat2']) && isset($this->_request['cat3'])) {

				$this->_data['term'][0]['mercado'] = 'Vehiculos';
				$this->_data['term'][1]['comuna'] = utf8_encode($this->_permalink->getNameByPrettyname('comuna', $this->_request['cat1']));
				$this->_data['term'][2]['estado'] = $this->_request['cat2'];
				$this->_data['term'][3]['categoria2'] = utf8_encode($this->_permalink->getNameByPrettyname('categoria2', $this->_request['cat3']));

				$this->_data['title'] = 'Venta de '.$this->_data['term'][3]['categoria2'].' '.$this->_data['term'][2]['estado'].'s en '.$this->_data['term'][1]['comuna'];
				$this->_data['breadcrumb'] = $this->genBreadcrumb('vehiculos',array($this->_request['cat1'],$this->_request['cat2'],$this->_request['cat3']));
			}

			// comuna/estado
			elseif(isset($this->_request['cat1']) && isset($this->_request['cat2'])) {

				$this->_data['term'][0]['mercado'] = 'Vehiculos';
				$this->_data['term'][1]['comuna'] = utf8_encode($this->_permalink->getNameByPrettyname('comuna', $this->_request['cat1']));
				$this->_data['term'][2]['estado'] = $this->_request['cat2'];
				$this->_data['facets'][0] = array('field' => 'categoria2', 'size' => '100', 'order' => 'term');

				$this->_data['title'] = 'Venta de autos '.$this->_data['term'][2]['estado'].'s en '.$this->_data['term'][1]['comuna'];
				$this->_data['breadcrumb'] = $this->genBreadcrumb('vehiculos',array($this->_request['cat1'],$this->_request['cat2']));

			}

			// comuna
			elseif(isset($this->_request['cat1']) && !$this->_region->isRegion($this->_request['cat1'])) {

				$this->_data['term'][0]['mercado'] = 'Vehiculos';
				$this->_data['term'][1]['comuna'] = utf8_encode($this->_permalink->getNameByPrettyname('comuna', $this->_request['cat1']));
				$this->_data['facets'][0] = array('field' => 'estado');

				$this->_data['title'] = 'Venta de autos en '.$this->_data['term'][1]['comuna'];
				$this->_data['breadcrumb'] = $this->genBreadcrumb('vehiculos',array($this->_request['cat1']));
			}

			// region
			else {				
				$this->_data['term'][0]['mercado'] = 'Vehiculos';
				$this->_data['term'][1]['region'] = utf8_encode($this->_permalink->getNameByPrettyname('region', $this->_request['cat1']));
				$this->_data['facets'][0] = array('field' => 'comuna', 'size' => '200', 'order' => 'term');

				$this->_data['title'] = 'Venta de autos en '.$this->_data['term'][1]['region'];
				$this->_data['breadcrumb'] = $this->genBreadcrumb('vehiculos',array($this->_request['cat1']));
			}

		} 

		// --------------------------------------- //
		// DEFAULT 
		// --------------------------------------- //
		else {
			$this->_data['term'][0]['mercado'] = 'Vehiculos';
			$this->_data['facets'][0] = array('field' => 'region', 'size' => '100', 'order' => 'term');
			$this->_data['facets'][1] = array('field' => 'estado');

			$this->_data['title'] = 'Venta de autos';
			$this->_data['breadcrumb'] = $this->genBreadcrumb('vehiculos',null);
		}
	}

	public function getParams() {
		return $this->_data;
	}

	public function genBreadcrumb($mercado, $data) {

		$base = '/search/' . str_replace(" ","-",$mercado);
		$breadcrumb = '<li><a href="/search">Inicio</a><span class="divider">/</span></li><li><a href="' . $base . '">' . $mercado . '</a></li>';
		if(!is_null($data))	$breadcrumb = '<li><a href="/search">Inicio</a><span class="divider">/</span></li><li><a href="' . $base . '">' . $mercado . '</a> <span class="divider">/</span></li>';
		
		for($z=0; $z<count($data); $z++) {

			$base .= '/' . $data[$z];
			if($z != (count($data)-1)) {
				$breadcrumb .= '<li><a href="' . $base . '">' . utf8_encode($this->_permalink->getNameBySlug($data[$z])) . '</a> <span class="divider">/</span></li>';		
			} else {
				$breadcrumb .= '<li class="active">' . utf8_encode($this->_permalink->getNameBySlug($data[$z])) . '</li>';
			}
		}

		return $breadcrumb;

	}

	public function _processRemates() {

		if(isset($this->_request['cat1']) && isset($this->_request['cat2'])) {

			$this->_data['text'] = "remate";
			$this->_data['term'][0]['categoria2'] = "Legales";
			$this->_data['term'][1]['region'] = trim(utf8_encode($this->_permalink->getNameByPrettyname('region', $this->_request['cat1'])));
			$this->_data['term'][2]['comuna'] = trim(utf8_encode($this->_permalink->getNameByPrettyname('comuna', $this->_request['cat2'])));

			$this->_data['title'] = 'Remates en ' . $this->_data['term'][2]['comuna'];
			$this->_data['breadcrumb'] = $this->genBreadcrumb('remates',array($this->_request['cat1'], $this->_request['cat2']));

		} else if(isset($this->_request['cat1']) && $this->_region->isRegion($this->_request['cat1'])) {

			$this->_data['text'] = "remate";
			$this->_data['term'][0]['categoria2'] = "Legales";
			$this->_data['term'][1]['region'] = trim(utf8_encode($this->_permalink->getNameByPrettyname('region', $this->_request['cat1'])));
			$this->_data['facets'][0] = array('field' => 'comuna', 'size' => '100', 'order' => 'term');
			$this->_data['title'] = 'Remates en ' . $this->_data['term'][1]['region'];
			$this->_data['breadcrumb'] = $this->genBreadcrumb('remates',array($this->_request['cat1']));

		} else {

			$this->_data['text'] = "remate";
			$this->_data['term'][0]['categoria2'] = "Legales";
			$this->_data['facets'][0] = array('field' => 'glosaClasificacion', 'size' => '100', 'order' => 'term');
			$this->_data['title'] = 'Remates';
			$this->_data['breadcrumb'] = $this->genBreadcrumb('remates',null);
		}
	}
}