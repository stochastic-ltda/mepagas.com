<?php
class Cleaner {

	public static function makeUrl($string) {

		$string = strtolower($string);
		$string = str_replace("ñ","n",$string);
		$string = str_replace("á","a",$string);
		$string = str_replace("é","e",$string);
		$string = str_replace("í","i",$string);
		$string = str_replace("ó","o",$string);
		$string = str_replace("ú","u",$string);
		$string = str_replace("'","-",$string);
		$string = str_replace(",","-",$string);
		$string = str_replace(" ","-",$string);
		$string = str_replace("--","-",$string);

		return $string;
	}

}
?>