<?php

if (!class_exists('LocalidadMapper')) { include( dirname(__FILE__) . '/classes/Mappers/LocalidadMapper.php'); }
if (!class_exists('PrecioMapper')) { include( dirname(__FILE__) . '/classes/Mappers/PrecioMapper.php'); }

$localidadMapper = new LocalidadMapper();
$localidades = $localidadMapper->getAll();

$precioMapper = new PrecioMapper;
$precios = $precioMapper->getAll();

?>

<script type="text/javascript" src="/includes/javascripts/wysihtml5/parser_rules/advanced.js"></script>
<script src="/includes/javascripts/wysihtml5/dist/wysihtml5-0.3.0.min.js"></script>
<script type="text/javascript" src="/includes/javascripts/chosen/chosen.jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="/includes/javascripts/chosen/chosen.min.css">

<div class="publish">
	<h1>Publica tu pituto</h1>

	<form method="post" action="" onsubmit="return false;">
		<div class="row">

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
		</div>

		<div class="row">
			<!-- // Listado de categorias -->
			<!-- TODO: Pasar las categorias a base de datos -->
			<label for="categorias">Categorías </label> 
			<select name="categorias" id="categorias">
				<option value="">Selecciona una categoría</option>

				<optgroup label="Belleza">
					<option value="Cosmetología">Cosmetología</option>
					<option value="Depilación">Depilación</option>
					<option value="Manicuría y Pedicuría">Manicuría y Pedicuría</option>
					<option value="Maquillaje">Maquillaje</option>
					<option value="Peluquería">Peluquería</option>
					<option value="Spa">Spa</option>
					<option value="Otros">Otros</option>
				 </optgroup>

				<optgroup label="Clases,Cursos y Capacitaciones">
					<option value="Apoyo Escolar">Apoyo Escolar</option>
					<option value="Apoyo Universitario">Apoyo Universitario</option>
					<option value="Bailes y Danzas">Bailes y Danzas</option>
					<option value="Deportes">Deportes</option>
					<option value="Idiomas">Idiomas</option>
					<option value="Informática">Informática</option>
					<option value="Instrumentos Musicales">Instrumentos Musicales</option>
					<option value="Otros">Otros</option>
				 </optgroup>

				<optgroup label="Fiestas y Eventos">
					<option value="Arriendos">Arriendos</option>
					<option value="Banquetería">Banquetería</option>
					<option value="Decoración con Globos">Decoración con Globos</option>
					<option value="DJ, Audio e Iluminación">DJ, Audio e Iluminación</option>
					<option value="Elaboración de Tortas">Elaboración de Tortas</option>
					<option value="Personal de Contratación">Personal de Contratación</option>
					<option value="Salones y Parcelas">Salones y Parcelas</option>
					<option value="Shows y Animaciones">Shows y Animaciones</option>
					<option value="Otros">Otros</option>
				 </optgroup>

				<optgroup label="Mantenimiento de Vehículos">
					<option value="Reparación Cajas Automá.">Reparación Cajas Automá.</option>
					<option value="Otros">Otros</option>
				 </optgroup>

				<optgroup label="Mantenimiento del Hogar">
					<option value="Albañilería">Albañilería</option>
					<option value="Carpintería">Carpintería</option>
					<option value="Cerrajería">Cerrajería</option>
					<option value="Electricidad">Electricidad</option>
					<option value="Gas">Gas</option>
					<option value="Jardinería">Jardinería</option>
					<option value="Piletas">Piletas</option>
					<option value="Pintura">Pintura</option>
					<option value="Pisos">Pisos</option>
					<option value="Plomería">Plomería</option>
					<option value="Tapicería">Tapicería</option>
					<option value="Techados">Techados</option>
					<option value="Otros">Otros</option>
				 </optgroup>

				<optgroup label="Otros Servicios">
					<option value="Diseño y Hosting">Diseño y Hosting</option>
					<option value="Imprenta">Imprenta</option>
					<option value="Instalación Antena Sate...">Instalación Antena Sate...</option>
					<option value="Lavado y Limpieza">Lavado y Limpieza</option>
					<option value="Seguridad">Seguridad</option>
					<option value="Servicios para Mascotas">Servicios para Mascotas</option>
					<option value="Otros">Otros</option>
				 </optgroup>

				<optgroup label="Profesionales">
					<option value="Administración">Administración</option>
					<option value="Auditorías">Auditorías</option>
					<option value="Comercio">Comercio</option>
					<option value="Comunicación">Comunicación</option>
					<option value="Construcción">Construcción</option>
					<option value="Consultorías y Asesorías">Consultorías y Asesorías</option>
					<option value="Contabilidad">Contabilidad</option>
					<option value="Derecho">Derecho</option>
					<option value="Diseño">Diseño</option>
					<option value="Educación">Educación</option>
					<option value="Informática">Informática</option>
					<option value="Ingeniería">Ingeniería</option>
					<option value="Investigación">Investigación</option>
					<option value="Salud">Salud</option>
					<option value="Traductores">Traductores</option>
					<option value="Otros">Otros</option>
				 </optgroup>

				<optgroup label="Recreación y Ocio">
					<option value="Centros Vacacionales">Centros Vacacionales</option>
					<option value="Otros">Otros</option>
				 </optgroup>

				<optgroup label="Servicio Técnico">
					<option value="Aires Acondicionados">Aires Acondicionados</option>
					<option value="Audio y Video">Audio y Video</option>
					<option value="Cámaras Digitales">Cámaras Digitales</option>
					<option value="Celulares">Celulares</option>
					<option value="Consolas y Video Juegos">Consolas y Video Juegos</option>
					<option value="Fotocopiadoras">Fotocopiadoras</option>
					<option value="Informática">Informática</option>
					<option value="Sistemas de Alarma">Sistemas de Alarma</option>
					<option value="Telefonía">Telefonía</option>
					<option value="Otros">Otros</option>
				 </optgroup>

				<optgroup label="Servicios de Traslado">
					<option value="Mensajerías">Mensajerías</option>
					<option value="Minivan y Buses">Minivan y Buses</option>
					<option value="Mudanzas y Fletes">Mudanzas y Fletes</option>
					<option value="Otros">Otros</option>
				 </optgroup>

				<optgroup label="Viajes y Turismo">
					<option value="Arriendo de Autos">Arriendo de Autos</option>
					<option value="Hospedaje">Hospedaje</option>
					<option value="Paquetes">Paquetes</option>
					<option value="Pasajes">Pasajes</option>
					<option value="Viajes Especiales">Viajes Especiales</option>
					<option value="Otros">Otros</option>
				</optgroup>
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

			<textarea name="descripcion" id="descripcion" placeholder="Ingresa una descripción ..."></textarea>
		</div>

		<div class="row"> 
			<!-- // Cobertura del servicio -->
			<!-- TODO: Agregar las regiones y todo chile al listado de localidades -->
			<!-- TODO: Agregar icono informativo con explicacion de regiones y todo chile -->
			<label for="cobertura">Cobertura de servicio</label> 
			<select name="cobertura" id="cobertura" multiple="multiple">
				<? foreach($localidades as $loc): ?>
					<option value="<?=utf8_encode($loc->get('nombre'))?>"><?=utf8_encode($loc->get('nombre'))?></option>
				<? endforeach; ?>
			</select>
		</div>

		<div class="row">
			<!-- // Imagenes -->
			<label for="imagenes">Imágenes</label> 
			<input type="file" name="imagenes[]" id="imagenes" multiple="multiple" onchange="imgselected();">

			<div class="imagenes-zone"></div>
		</div>

		<div class="row aright">
			<!-- // Terminos y condiciones de uso -->
			<input type="checkbox" name="acepto" id="acepto"> 
			<label for="acepto">Acepto los Términos y Condiciones de uso</label>
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

	$('#subir').on('click', function() {
		processAviso();
	});

});
	
</script>