<?php

class Precio {

	protected $_fields = array(
			"valor" => null,
			"nombre" => null
		);

	public function set($field, $value) {
		$this->_fields[$field] = $value;
	}

	public function get($field) {
		return $this->_fields[$field];
	}

}