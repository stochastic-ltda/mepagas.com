<?php 

class Usuario {

	// cambiar campos usuario
	protected $_fields = array(
			'id' => null,
			'facebook_id' => null,
			'usuario' => null,
			'nombre' => null,
			'nombre_empresa' => null,
			'email' => null,
			'telefono' => null,
			'password' => null,
			'avatar' => null,
			'acercade' => null,
			'token' => null,
			'estado' => 0,
			'r_recomendado' => 0,
			'r_confiable' => 0,
			'r_responsable' => 0,
			'r_calidad' => 0,
			'r_experiencia' => 0
		);

	function __construct($id=null,$facebook_id=null,$usuario=null,$nombre=null,$nombre_empresa=null,$email=null,$telefono=null,$password=null, $avatar=null, $acercade=null, $token=null) {
		$this->_fields['id'] = $id;
		$this->_fields['facebook_id'] = $facebook_id;
		$this->_fields['nombre'] = $nombre;
		$this->_fields['nombre_empresa'] = $nombre_empresa;
		$this->_fields['usuario'] = $usuario;
		$this->_fields['email'] = $email;
		$this->_fields['telefono'] = $telefono;
		$this->_fields['password'] = $password;
		$this->_fields['acercade'] = $acercade;
		$this->_fields['token'] = $token;

		if(is_null($avatar)) $this->_fields['avatar'] = '/upload/avatar/default.png';
		else $this->_fields['avatar'] = $avatar;

	}

	public function set($field, $value) {
		$this->_fields[$field] = $value;
	}

	public function get($field) {
		return $this->_fields[$field];
	}

}