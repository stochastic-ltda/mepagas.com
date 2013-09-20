<?php
include( dirname(__FILE__) . '/../../../vendor/autoload.php');

class Mustache {
	
	public static function paint($template, $params) {

		$mustache = new Mustache_Engine(array(
		    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/../../../templates'),
		));

		return $mustache->render($template, $params);

	}

}
