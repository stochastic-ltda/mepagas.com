<?php 

class Subcategoria {

	protected $_fields = array(
			'id' => null,
			'id_categoria' => null,
			'nombre' => null,
			'permalink' => null
		);

	public function set($field, $value) {
		$this->_fields[$field] = $value;
	}

	public function get($field) {
		return $this->_fields[$field];
	}

}