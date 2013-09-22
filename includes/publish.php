<?php

if (!class_exists('LocalidadMapper')) { include( dirname(__FILE__) . '/classes/Mappers/LocalidadMapper.php'); }
if (!class_exists('PrecioMapper')) { include( dirname(__FILE__) . '/classes/Mappers/PrecioMapper.php'); }
if (!class_exists('CategoriaMapper')) { include( dirname(__FILE__) . '/classes/Mappers/CategoriaMapper.php'); }

$localidadMapper = new LocalidadMapper();
$localidades = $localidadMapper->getAll();

$precioMapper = new PrecioMapper;
$precios = $precioMapper->getAll();

$categoriaMapper = new CategoriaMapper;
$categorias = $categoriaMapper->getAll();

?>

<script type="text/javascript" src="/includes/javascripts/wysihtml5/parser_rules/advanced.js"></script>
<script src="/includes/javascripts/wysihtml5/dist/wysihtml5-0.3.0.min.js"></script>
<script type="text/javascript" src="/includes/javascripts/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/functions.js"></script>

<link rel="stylesheet" type="text/css" href="/includes/javascripts/chosen/chosen.min.css">

<div class="publish">
	<h1>Publica tu pituto</h1>

	<form method="post" action="" onsubmit="return false;">

		<div class="aviso-wrapper">

			<div class="row">

				<h4>Título</h4>

				<!-- // Tipo de aviso -->
				<select name="tipo" id="tipo">
					<option value="Me pagas">Me pagas</option>
					<option value="Te pago">Te pago</option>
				</select>

				<!-- // Precio -->
				<select name="precio" id="precio">
					<option value="">$ precio</option>
					<? foreach($precios as $p): ?>
						<option value="<?=$p->get('valor')?>"><?=$p->get('nombre');?></option>
					<? endforeach; ?>				
				</select>

				<!-- // Titulo -->
				<label for="titulo"> y </label> 
				<input type="text" name="titulo" id="titulo" placeholder="Ej: te paseo el perro">

				<p class="mini-info">Completa el título de tu pituto, por ejemplo: <b>Me pagas $5.000 y paseo a tu perro por 1 hora</b></p>
			</div>

			<div class="row">
				<!-- // Listado de categorias -->
				<h4>Categorías</h4> 
				<select name="categorias" id="categorias">
					<option value="">Selecciona una categoría</option>
					<? foreach($categorias as $c): ?>
						<option value="<?=$c->get('id').'||'.$c->get('nombre')?>"><?=utf8_encode($c->get('nombre'))?></option>
					<? endforeach; ?>
				</select>
			</div>

			<div class="row" id="subcategorias-wrapper">
				<!-- // Listado de subcategorias -->
				<h4>Subcategorías</h4>
				<select name="subcategorias" id="subcategorias">
					<option value="">Selecciona una subcategoría</option>
				</select>
			</div>

			<div class="row">

				<!-- // Descripcion -->
				<h4>Describe tu pituto</h4>

				<!-- // Wysihtml5 Toolbar -->
				<div id="toolbar" style="display: none;">
					<a data-wysihtml5-command="bold" id="bold" class="btn"></a>
					<a data-wysihtml5-command="italic" id="italic" class="btn"></a>
					<a data-wysihtml5-command="underline" id="underline" class="btn"></a>
					<a data-wysihtml5-command="insertOrderedList" id="insertOrderedList" class="btn"></a>
					<a data-wysihtml5-command="insertUnorderedList" id="insertUnorderedList" class="btn last"></a>
				</div>

				<textarea name="descripcion" id="descripcion" placeholder="Ingresa una descripción ..."></textarea>

				<p class="mini-info">Cuéntamos más detalles acerca de tu pituto, por ejemplo: cuanto tiempo tarda, si es presencial o lo haces vía internet, que experiencia tienes, etc.</p>
			</div>

			<div class="row"> 
				<!-- // Cobertura del servicio -->
				<h4>Cobertura de pituto</h4> 
				<select name="cobertura" id="cobertura" multiple="multiple">
					<? foreach($localidades as $loc): ?>
						<option value="<?=utf8_encode($loc->get('nombre'))?>"><?=utf8_encode($loc->get('nombre'))?></option>
					<? endforeach; ?>
				</select>

				<p class="mini-info">Ingresa las localidades en donde puedes realizar tu pituto, puedes ser una o varias comunas e incluso <b>Todo Chile</b></p>
			</div>

			<div class="row">
				<!-- // Imagenes -->
				<h4>Imágenes</h4> 
				<input type="file" name="imagenes[]" id="imagenes" multiple="multiple" onchange="imgselected();">

				<div class="imagenes-zone"></div>
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
				<input type="checkbox" name="acepto" id="acepto"> 
				<label for="acepto">Acepto los Términos y Condiciones de uso</label>
			</div>
		</div>

		<div class="row aright">
			<input type="submit" id="subir" name="subir" value="Subir pituto">
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