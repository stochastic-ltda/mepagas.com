<?php
class Mysql {
	
	protected $_host = 'localhost';
	protected $_user = 'root';
	protected $_pass = 'root';
	protected $_dbase = 'mepagas';

	protected $_link;

	/**
	 * Conexion a la base de datos
	 * @return (false: Error, dbLink Link conexion)
	 */
	public function connect() {

		try {

			$this->_link = mysql_connect($this->_host, $this->_user, $this->_pass);
			mysql_select_db($this->_dbase);			
			return $this->_link;

		} catch(Exception $e) {
			return false;
		}
		
	}

	/** 
	 * Desconexion base de datos
	 * @param dbLink Link conexion
	 * @return bool Disconnected or not
	 */
	public function disconnect($link) {
		return mysql_close($link);
	}
}
