<?php 

class Mensaje {

	// cambiar campos usuario
	protected $_fields = array(
			'id' => null,
			'id_aviso' => null,
			'desde' => null,
			'para' => null,
			'mensaje' => null,
			'fecha' => null,
			'leido' => 0,
			'_desde' => null,
			'_para' => null,
			'_aviso' => null
		);

	function __construct($id=null,$id_aviso=null, $desde=null,$para=null,$mensaje=null,$fecha=null,$leido=null) {
		$this->_fields['id'] = $id;
		$this->_fields['id_aviso'] = $id_aviso;
		$this->_fields['desde'] = $desde;
		$this->_fields['para'] = $para;
		$this->_fields['mensaje'] = $mensaje;
		$this->_fields['fecha'] = $fecha;
		$this->_fields['leido'] = $leido;
	}

	public function set($field, $value) {
		$this->_fields[$field] = $value;
	}

	public function get($field) {
		return $this->_fields[$field];
	}

}