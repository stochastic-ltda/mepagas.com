<?php 

class Aviso {

	protected $_fields = array(
			'id' => null,
			'id_usuario' => null,
			'tipo' => null,
			'precio' => null,
			'titulo' => null,
			'categoria' => null,
			'subcategoria' => null,
			'descripcion' => null,
			'localidades' => null,
			'imagenes' => null
		);

	public function set($field, $value) {
		$this->_fields[$field] = $value;
	}

	public function get($field) {
		return $this->_fields[$field];
	}

}