<?php 

class Calificacion {

	protected $_fields = array(
			'id' => null,
			'id_usuario' => null,
			'id_aviso' => null,
			'fecha' => null,
			'detalle' => null,
			'r_recomendado' => null,
			'r_confiable' => null,
			'r_responsable' => null,
			'r_calidad' => null,
			'r_experiencia' => null,
			'id_califica'
		);

	function __construct($id=null,$id_usuario=null,$id_aviso=null,$fecha=null,$detalle=null,$r_recomendado=null,$r_confiable=null,$r_responsable=null,$r_calidad=null,$r_experiencia=null, $id_califica=null) {

		$this->_fields['id'] = $id;
		$this->_fields['id_usuario'] = $id_usuario;
		$this->_fields['id_aviso'] = $id_aviso;
		$this->_fields['fecha'] = $fecha;
		$this->_fields['detalle'] = $detalle;
		$this->_fields['r_recomendado'] = $r_recomendado;
		$this->_fields['r_confiable'] = $r_confiable;
		$this->_fields['r_responsable'] = $r_responsable;
		$this->_fields['r_calidad'] = $r_calidad;
		$this->_fields['r_experiencia'] = $r_experiencia;
		$this->_fields['id_califica'] = $id_califica;

	}

	public function set($field, $value) {
		$this->_fields[$field] = $value;
	}

	public function get($field) {
		return $this->_fields[$field];
	}

}