<?php
class Image {
	
	public static function scale($src, $width, $height, $path) {

		$img = new Imagick($src);
		$imgWidth = $img->getImageWidth();
		$imgHeight = $img->getImageHeight();

		//if($imgWidth < $width) $width = $imgWidth;
		//if($imgHeight < $height) $height = $imgHeight;

		$img->scaleImage($width, $height);
		$img->writeImage($path);

	}	

}
?>