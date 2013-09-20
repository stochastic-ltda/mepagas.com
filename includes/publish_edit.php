<?php

if (!class_exists('LocalidadMapper')) { include( dirname(__FILE__) . '/classes/Mappers/LocalidadMapper.php'); }
if (!class_exists('PrecioMapper')) { include( dirname(__FILE__) . '/classes/Mappers/PrecioMapper.php'); }
if (!class_exists('CategoriaMapper')) { include( dirname(__FILE__) . '/classes/Mappers/CategoriaMapper.php'); }
if (!class_exists('SubcategoriaMapper')) { include( dirname(__FILE__) . '/classes/Mappers/SubcategoriaMapper.php'); }
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/classes/Mappers/AvisoMapper.php'); }

$avisoMapper = new AvisoMapper();
$aviso = $avisoMapper->findById($avisoid);
if(!is_null($aviso) && count($aviso) > 0) $aviso = $aviso[0];

$localidadMapper = new LocalidadMapper();
$localidades = $localidadMapper->getAll();

$precioMapper = new PrecioMapper;
$precios = $precioMapper->getAll();

$categoriaMapper = new CategoriaMapper;
$categorias = $categoriaMapper->getAll();

$categoria = $categoriaMapper->getByNombre(utf8_decode($aviso->get('categoria')));
$subcatMapper = new SubcategoriaMapper();
$subcats = $subcatMapper->getByIdCategoria($categoria->get('id'));

//echo "<pre>"; print_r($aviso); echo "</pre>";

?>

<script type="text/javascript" src="/includes/javascripts/wysihtml5/parser_rules/advanced.js"></script>
<script src="/includes/javascripts/wysihtml5/dist/wysihtml5-0.3.0.min.js"></script>
<script type="text/javascript" src="/includes/javascripts/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/functions.js"></script>

<link rel="stylesheet" type="text/css" href="/includes/javascripts/chosen/chosen.min.css">

<div class="publish">
	<h1>Publica tu pituto</h1>

	<form method="post" action="" onsubmit="return false;">

		<input type="hidden" id="avisoid" value="<?=$aviso->get('id')?>">

		<div class="aviso-wrapper">

			<div class="row">

				<!-- // Tipo de aviso -->
				<select name="tipo" id="tipo">
					<option value="Me pagas" <?=($aviso->get('tipo') == "Me pagas")?'selected':'';?>>Me pagas</option>
					<option value="Te pago" <?=($aviso->get('tipo') == "Te pago")?'selected':'';?>>Te pago</option>
				</select>

				<!-- // Precio -->
				<select name="precio" id="precio">
					<option value="">$ precio</option>
					<? foreach($precios as $p): ?>
						<option value="<?=$p->get('valor')?>" <?=($p->get('valor')==$aviso->get('precio'))?'selected':''?>><?=$p->get('nombre');?></option>
					<? endforeach; ?>				
				</select>

				<!-- // Titulo -->
				<label for="titulo"> y </label> 
				<input type="text" name="titulo" id="titulo" placeholder="Ej: te paseo el perro" value="<?=$aviso->get('titulo')?>">
			</div>

			<div class="row">
				<!-- // Listado de categorias -->
				<!-- TODO: Pasar las categorias a base de datos -->
				<label for="categorias">Categorías </label> 
				<select name="categorias" id="categorias">
					<option value="">Selecciona una categoría</option>
					<? foreach($categorias as $c): ?>
						<option value="<?=$c->get('id').'||'.utf8_encode($c->get('nombre'))?>" <?=($c->get('nombre')==utf8_decode($aviso->get('categoria')))?'selected':''?>>
							<?=utf8_encode($c->get('nombre'))?>
						</option>
					<? endforeach; ?>
				</select>
			</div>

			<div class="row" id="subcategorias-wrapper">
				<!-- // Listado de subcategorias -->
				<label for="categorias">Subtegorías </label> 
				<select name="subcategorias" id="subcategorias">
					<option value="">Selecciona una subcategoría</option>
					<? foreach($subcats as $sc): ?>
						<option value="<?=utf8_encode($sc->get('nombre'))?>" <?=($sc->get('nombre')==utf8_decode($aviso->get('subcategoria')))?'selected':''?>>
							<?=utf8_encode($sc->get('nombre'))?>
						</option>
					<? endforeach; ?>
				</select>
			</div>

			<div class="row">

				<!-- // Descripcion -->
				<label for="descripcion">Descripción</label>

				<!-- // Wysihtml5 Toolbar -->
				<div id="toolbar" style="display: none;">
					<a data-wysihtml5-command="bold" id="bold" class="btn"></a>
					<a data-wysihtml5-command="italic" id="italic" class="btn"></a>
					<a data-wysihtml5-command="underline" id="underline" class="btn"></a>
					<a data-wysihtml5-command="insertOrderedList" id="insertOrderedList" class="btn"></a>
					<a data-wysihtml5-command="insertUnorderedList" id="insertUnorderedList" class="btn last"></a>
				</div>

				<textarea name="descripcion" id="descripcion" placeholder="Ingresa una descripción ..."><?=$aviso->get('descripcion')?></textarea>
			</div>

			<div class="row"> 
				<!-- // Cobertura del servicio -->
				<!-- TODO: Agregar las regiones y todo chile al listado de localidades -->
				<!-- TODO: Agregar icono informativo con explicacion de regiones y todo chile -->
				<label for="cobertura">Cobertura de servicio</label> 
				<select name="cobertura" id="cobertura" multiple="multiple">
					<? foreach($localidades as $loc): ?>
						<option value="<?=utf8_encode($loc->get('nombre'))?>" <?=(in_array( utf8_encode($loc->get('nombre')) , $aviso->get('localidades')))?'selected':''?>><?=utf8_encode($loc->get('nombre'))?></option>
					<? endforeach; ?>
				</select>
			</div>

			<div class="row">
				<!-- // Imagenes -->
				<label for="imagenes">Imágenes</label> 
				<input type="file" name="imagenes[]" id="imagenes" multiple="multiple" onchange="imgselected();">

				<div class="imagenes-zone">

					<? foreach($aviso->get('imagenes') as $img): ?>
						<div class="image-thumb" id="<?=current(explode(".",$img))?>">
			                <div class="trash">
			                    <img src="/assets/img/delete.png" onclick="imgdelete('<?=$img?>', '<?=current(explode(".",$img))?>')">
			                </div>
			                <img src="<?=$config->imgsrc_path . "thumb_" . $img?>">                
			            </div>
			        <? endforeach; ?>
				</div>
			</div>
		</div>

		<div class="usuario-wrapper">

			<div class="row left" id="usuario-logged"></div>

			<div class="row left" id="usuario-login">

				<div class="midrow left">
					<h3>Inicia sesión</h3>

					<div class="form-row">					
						<label>Email</label><input type="text" id="login-email">
					</div>

					<div class="form-row">
						<label>Password</label><input type="password" id="login-pass">
					</div>

					<div class="form-row">
						<p><a href="#" class="butn green lu">Login</a></p>
					</div>

					<div class="smallfont">
						<p><a href="#">Olvidaste tu contraseña?</a></p>
						<p>¿Eres nuevo? <b><a href="#" id="sreg">Crea una cuenta</a></b></p>
					</div>
				</div>

				<div class="midrow left">
					<h4>O inicia sesión con</h4>
					<div class="fb-login-button" data-width="200" data-autologoutlink="true" data-size="large" data-onlogin="userdata()" data-scope="offline_access,user_birthday,user_likes,email"></div>
				</div>
			</div>

			<div class="row left" id="usuario-registro">

				<div class="midrow left">
					<h3>Crear una cuenta</h3>

					<div class="form-row">
						<label>Nombre (*)</label><input type="text" id="user-name">
					</div>

					<div class="form-row">
						<label>Teléfono</label><input type="text" id="user-phone">
					</div>

					<div class="form-row">
						<label>Email (*)</label><input type="text" id="user-email">
					</div>

					<div class="form-row">
						<label>Password (*)</label><input type="password" id="user-pass">
					</div>

					<div class="form-row">
						<p><input type="checkbox" id="soyempresa"> represento una empresa</p>
					</div>

					<div class="form-row" id="user-enterprise-group">
						<label>Nombre empresa (*)</label><input type="text" id="user-enterprise">
					</div>

					<p><a href="#" class="butn green cc">Crear nueva cuenta</a></p>

					<div class="smallfont">
						<p>¿Ya tienes una cuenta? <b><a href="#" id="slogin">Inicia sesión</a></b></p>
					</div>
				</div>

				<div class="midrow left">
					<h4>O registrate con</h4>
					<div class="fb-login-button" data-width="200" data-autologoutlink="true" data-size="large" data-onlogin="userdata()" data-scope="offline_access,user_birthday,user_likes,email"></div>
				</div>
			</div>


			<div class="row aright">
				<!-- // Terminos y condiciones de uso -->
				<input type="checkbox" name="acepto" id="acepto" checked="checked"> 
				<label for="acepto">Acepto los Términos y Condiciones de uso</label>
			</div>
		</div>

		<div class="row aright">
			<input type="submit" id="actualizar" name="subir" value="Editar pituto">
		</div>
	</form>
</div>

<div id="load-image-template" style="display:none;">
	<div id="load-image"><img src="/assets/img/loader.gif"> <p>Cargando imagen...</p></div>
</div>

<script>

$(document).ready(function(){

	// WYISHTML5 Editor
	var editor = new wysihtml5.Editor("descripcion", { // id of textarea element
		toolbar:      "toolbar", // id of toolbar element
		parserRules:  wysihtml5ParserRules, // defined in parser rules set 
		stylesheets: ["/includes/javascripts/wysihtml5/website/css/stylesheet.css", "/includes/javascripts/wysihtml5/website/css/editor.css"]
	});

	// CHOSEN List
	$('#cobertura').chosen({
		no_results_text: "Localidad no encontrada",
		placeholder_text_multiple: "Selecciona una localidad"
	});

	//$('#subir').on('click', function() { processAviso(); });
	checkul();

});
	
</script>

<script type="text/javascript" src="/assets/js/publish.js"></script>
<script> 
$('.publish').publish({});
</script>