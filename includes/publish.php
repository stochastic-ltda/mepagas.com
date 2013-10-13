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

<script type="text/javascript" src="/includes/javascripts/wysihtml5/parser_rules/simple.js"></script>
<script src="/includes/javascripts/wysihtml5/dist/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/includes/javascripts/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="/assets/js/functions.js"></script>

<link rel="stylesheet" type="text/css" href="/includes/javascripts/chosen/chosen.min.css">

<div class="publish">
	<h1>Publica tu pituto</h1>

	<form method="post" action="" onsubmit="return false;" id="form-publicar">

		<div class="aviso-wrapper">

			<div class="row">

				<h4>Título</h4>

				<!-- // Tipo de aviso -->
				<select name="tipo" id="tipo" data-progression data-helper="¿Buscas u ofreces? Selecciona si <b>Me pagas</b> o <b>Te pago</b> por un pituto">
					<option value="Me pagas">Me pagas</option>
					<option value="Te pago">Te pago</option>
				</select>

				<!-- // Precio -->
				<select name="precio" id="precio" data-progression data-helper="Ingresa el <b>precio</b> de tu pituto">
					<option value="">$ precio</option>
					<? foreach($precios as $p): ?>
						<option value="<?=$p->get('valor')?>"><?=$p->get('nombre');?></option>
					<? endforeach; ?>				
				</select>

				<!-- // Titulo -->
				<label for="titulo"> y </label> 
				<input type="text" name="titulo" id="titulo" placeholder="Ej: te paseo el perro" data-progression data-helper="¡Completa la oración! Por ejemplo: <br>Me pagas $5.000 y <b>paseo a tu perro por 1 hora</b>">

			</div>

			<div class="row">
				<!-- // Listado de categorias -->
				<h4>Categorías</h4> 
				<select name="categorias" id="categorias" data-progression data-helper="Ingresa la <b>categoría</b> en la que podemos clasificar tu pituto">
					<option value="">Selecciona una categoría</option>
					<? foreach($categorias as $c): ?>
						<option value="<?=$c->get('id').'||'.$c->get('nombre')?>"><?=utf8_encode($c->get('nombre'))?></option>
					<? endforeach; ?>
				</select>
			</div>

			<div class="row" id="subcategorias-wrapper">
				<!-- // Listado de subcategorias -->
				<h4>Subcategorías</h4>
				<select name="subcategorias" id="subcategorias" data-progression data-helper="Ingresa la <b>subcategoría</b> en la que podemos clasificar tu pituto">
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

				<textarea name="descripcion" id="descripcion" placeholder="Ingresa una descripción ..." data-progression data-helper="Cuéntamos <b>más detalles</b> acerca de tu pituto, por ejemplo: <ul><li>¿Cuanto tiempo toma?</li><li>¿Presencial o vía Internet?</li><li>Experiencia en el rubro</li><li>etc.</li></ul>"></textarea>
			</div>

			<div class="row"> 
				<!-- // Cobertura del servicio -->
				<h4>Cobertura de pituto</h4> 
				<select name="cobertura" id="cobertura" multiple="multiple" data-progression data-helper="¿Y donde? Ingresa <b>una o más comunas</b> donde puedes realizar tu pituto, incluso puedes seleccionar <b>Todo Chile</b>">
					<? foreach($localidades as $loc): ?>
						<option value="<?=utf8_encode($loc->get('nombre'))?>"><?=utf8_encode($loc->get('nombre'))?></option>
					<? endforeach; ?>
				</select>

			</div>

			<div class="row">
				<!-- // Imagenes -->
				<h4>Imágenes</h4> 
				<input type="file" name="imagenes[]" id="imagenes" multiple="multiple" onchange="imgselected();" data-progression data-helper="Ingresa una <b>imagen</b> para tu aviso">

				<div class="imagenes-zone"></div>
			</div>

			<div class="row">
				<h4>Comentarios</h4>
				<input type="checkbox" checked="checked" id="comentarios"> Permitir que usuarios dejen comentarios
			</div>
		</div>

		<div class="usuario-wrapper">

			<h3>Información de usuario</h3>

			<div class="row left" id="usuario-login">
				<p>Debes <b>ingresar con tu cuenta de usuario</b> para poder publicar tu pituto</p>
				<br>
				<a class="btn btn-register" href="#" data-reveal-id="regmodal">Registrar</a>
				<a class="btn btn-login" href="#" data-reveal-id="logmodal">Login</a>
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

$(document).ready(function($){

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

	// Progression
	$('.wysihtml5-sandbox').on('mouseover', function() { 
		$('#descripcion').focus() 
		$('.syco_tooltip').css('top', '380px');
	});

	$('.chosen-choices input[type=text]').on('focus', function(){
		$('#cobertura').focus();
		$('.syco_tooltip').css('top', '525px');
	});

	$('#imagenes').on('click', function(){
		$('.syco_tooltip').css('top', '600px');
	})

	//thistooltip.find('p').html('<span class="tooltip_helper"><span data-index="1" >6</span>/8</span> Hola').parent().find('.percentagebarinner').css( "width",'70%').next().html('70%');

	//$('#subir').on('click', function() { processAviso(); });
	checkul();

	$('#tipo').focus();

	$("#form-publicar").progression({
		tooltipWidth: '200',
		tooltipPosition: 'right',
		tooltipOffset: '50',
		showProgressBar: true,
		showHelper: true,
		tooltipFontSize: '13',
		tooltipFontColor: 'fff',
		progressBarBackground: 'fff',
		progressBarColor: '6EA5E1',
		tooltipBackgroundColor:'76A933',
		tooltipPadding: '10',
		tooltipAnimate: true
	});

});
	
</script>

<script type="text/javascript" src="/assets/js/publish.js"></script>
<script> 
$('.publish').publish({});
</script>