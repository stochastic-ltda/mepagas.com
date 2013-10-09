<? if($redirect): ?><script> document.location="/"; </script><? endif; ?>

<div class="content" id="user_clasificar">
	<div id="uc_avatar">
		<img src="<?=$usuario->get('avatar')?>">
	</div>

	<h2>Clasifica a <?=$usuario->get('nombre')?></h2>
	<h3>¿Qué tan recomendable es <?=current(explode(" ",$usuario->get('nombre')))?>?</h3>

	<form method="post" id="calificar_form" name="calificar_form" onsubmit="calificar(this)">
		<div id="recomendar">
			<div id="star_recomendar"></div>
			<div class="hint_recomendar"></div>
		</div>

		<ul id="mas-calificaciones">
			<li>¿Confiable? <div id="star_confiable"></div><span class="hint_confiable"></span></li>
			<li>¿Responsable? <div id="star_responsable"></div><span class="hint_responsable"></span></li>
			<li>¿Experiencia? <div id="star_experiencia"></div><span class="hint_experiencia"></span></li>
			<li>¿Calidad del pituto? <div id="star_calidad"></div><span class="hint_calidad"></span></li>
		</ul>

		<div id="descripcion" class="row">
			<p>Descríbenos en detalle tu experiencia con <?=current(explode(" ", $usuario->get('nombre')))?></p>
			<textarea name="descripcion"></textarea>
			<p class="mini">Incluye detalles para ayudar a otros a decidir si deben o no contratar a <?=current(explode(" ", $usuario->get('nombre')))?></p>
		</div>		

		<div id="pituto" class="row">
			<p>
				Pituto: 
				<select id="nombre-pituto" name="nombre_pituto">
					<? foreach($avisos as $a): ?>
						<option value="<?=$a->get('id')?>"><?=$a->get('tipo')?> <?=$a->get('precio')?> y <?=$a->get('titulo')?></option>
					<? endforeach; ?>
				</select>
			</p>
		</div>

		<div id="calificar" class="row">
			<input type="hidden" name="id_usuario" value="<?=$usuario->get('id')?>">
			<p><input type="submit" value="Calificar"></p>	
		</div>
	</form>
</div>


<script src="/includes/javascripts/raty/jquery.raty.js"></script>
<script>
$(document).ready(function(){
	$('#star_recomendar').raty({
		number:5,
		readOnly:false,
		hints: ['Muy malo','Malo','Mas o menos','Bueno','Muy bueno'],
		scoreName: 'r_recomendar',
		target: '.hint_recomendar',
		starOn: 'star-on-big.png',
		starOff: 'star-off-big.png',
		size: 35
	});

	$('#star_confiable').raty({
		hints: ['Muy malo','Malo','Mas o menos','Bueno','Muy bueno'],
		scoreName: 'r_confiable',
		target: '.hint_confiable'
	});

	$('#star_responsable').raty({
		hints: ['Muy malo','Malo','Mas o menos','Bueno','Muy bueno'],
		scoreName: 'r_responsable',
		target: '.hint_responsable'
	});

	$('#star_experiencia').raty({
		hints: ['Muy malo','Malo','Mas o menos','Bueno','Muy bueno'],
		scoreName: 'r_experiencia',
		target: '.hint_experiencia'
	});

	$('#star_calidad').raty({
		hints: ['Muy malo','Malo','Mas o menos','Bueno','Muy bueno'],
		scoreName: 'r_calidad',
		target: '.hint_calidad'
	});

});

function calificar(form) {
	event.preventDefault();

	var descripcion = form.descripcion.value;
	var pituto = form.nombre_pituto.value;
	var recomendar = form.r_recomendar.value;
	var responsable = form.r_responsable.value;
	var calidad = form.r_calidad.value;
	var confiable = form.r_confiable.value;
	var experiencia = form.r_experiencia.value;
	var id_usuario = form.id_usuario.value;
	var id_califica = getCookie('userid');

	if(descripcion=='' || pituto=='' || recomendar=='' || responsable=='' || calidad=='' || confiable=='' || experiencia=='')
		alert("Debes completar todo el formulario");
	else {
		$.post('/includes/phpscripts/user_calificar.php', {descripcion:descripcion, pituto:pituto, recomendar:recomendar, responsable:responsable, calidad:calidad, confiable:confiable, experiencia:experiencia, id_usuario:id_usuario, id_califica:id_califica}, function(data) {
			document.location = "/usuario/"+id_usuario+"?s=cal";			
		});
	}
	
}
</script>