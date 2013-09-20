<?php
include(dirname(__FILE__) . '/../../config.php'); 
if (!class_exists('Image')) { include( dirname(__FILE__) . '/../classes/Services/Image/Image.php'); }

$config = new Config();

foreach ($_FILES as $key) {

  if($key['error'] == UPLOAD_ERR_OK ){ // Verificamos si se subio correctamente

    //print_r($key);
    // Se valida que sea una imagen
    if(((strpos($key['type'], "gif") || strpos($key['type'], "jpeg") || strpos($key['type'],"jpg")) || strpos($key['type'],"png") )) {

        $nombre = $key['name'];
        $temporal = $key['tmp_name']; 
        $tamano= ($key['size'] / 1000)."Kb";

        // obtengo extension
        $aux = explode(".", $nombre);
        $ext = $aux[count($aux)-1];

        // nombre unico dependiendo del contenido
        $content = file_get_contents($temporal);
        
        $image_name = md5($content) . "." . $ext;
        $thumb_name = "thumb_" . md5($content) . "." . $ext;

        Image::scale($temporal, 640, 0, $config->imgupload_path . $image_name);
        Image::scale($temporal, 204, 0, $config->imgupload_path . $thumb_name);

        $html = '
            <div class="image-thumb" id="'.current(explode(".",$image_name)).'">
                <div class="trash">
                    <img src="/assets/img/delete.png" onclick="imgdelete(\'' . $image_name . '\',\'' . current(explode(".",$image_name)) . '\')">
                </div>
                <img src="'. $config->imgsrc_path . $thumb_name . '">                
            </div>';
        echo $html;

        
        // TODO: Guardar un registro de los avisos con sus imagenes
        // TODO: Generar proceso diario que tome archivos sin dueño y los elimine

        // move_uploaded_file($temporal, $config->imgupload_path . $newname); //Movemos el archivo temporal a la ruta especificada

        // TODO: Implementar preview de la imagen
        // echo "done";

    } else {
        echo "<script>alert('Formato no permitido');</script>";
    }

  } else {

    echo "<script>alert('Ha ocurrido un problema al procesar la imagen. Por favor inténtalo más tarde');</script>";

    // TODO: implementar registro y alerta del error
    echo $key['error'];

  }
}
?>