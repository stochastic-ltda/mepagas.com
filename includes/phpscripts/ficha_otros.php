<?php
if (!class_exists('AvisoMapper')) { include( dirname(__FILE__) . '/../classes/Mappers/AvisoMapper.php'); }
$avisoMapper = new AvisoMapper();

$todos = $avisoMapper->getLast(4, null);
$umil = $avisoMapper->getLast(4, 1000);
$dmil = $avisoMapper->getLast(4, 2000);
$cmil = $avisoMapper->getLast(4, 5000);
$dimil = $avisoMapper->getLast(4, 10000);
$vmil = $avisoMapper->getLast(4, 20000);
?>
<div class="contendor_tabs_list">
	<ul class="ul_tabs_list">
		<li><a data-show="list-todos" href="#" class="activo contenido_list_produc_fnd">Todos</a></li>
		<li><a data-show="list-mil" href="#"><span class="color_billete_mil tamano_num_list">1.000</span><span class="img_billete_list"><img src="/assets/img/billete_mil.png"/></span></a></li>
		<li><a data-show="list-2mil" href="#"><span class="color_billete_2mil tamano_num_list">2.000</span><span class="img_billete_list"><img src="/assets/img/billete_2mil.png"/></span></a></li>
		<li><a data-show="list-5mil" href="#"><span class="color_billete_5mil tamano_num_list">5.000</span><span class="img_billete_list"><img src="/assets/img/billete_5mil.png"/></span></a></li>
		<li><a data-show="list-10mil" href="#"><span class="color_billete_10mil tamano_num_list">10.000</span><span class="img_billete_list"><img src="/assets/img/billete_10mil.png"/></span></a></li>
		<li><a data-show="list-20mil" href="#"><span class="color_billete_20mil tamano_num_list">20.000</span><span class="img_billete_list"><img src="/assets/img/billete_20mil.png"/></span></a></li>
	</ul>

	<div class="contenido_list_produc contenido_list_produc_fnd list-todos">
		<? if(!is_null($todos)): ?>
		<? foreach($todos as $t): ?>
			<span class="contenedor_list_precios_producto">
				<span class="contenedor_list_producto_txt">
					<a href="<?=$t->get('id')?>/<?=$t->get('permalink')?>"><?=$t->get('tipo')?> <?=$t->get('precio')?> y <?=$t->get('titulo')?></a>
				</span>

				<? foreach($t->get('imagenes') as $img): ?>
					<img src="/upload/img/thumb_<?=$img?>">
					<? break; ?>
				<? endforeach; ?>

			</span> 
		<? endforeach; ?>
		<? endif; ?>
	</div>

	<div class="contenido_list_produc contenido_list_produc_fnd list-mil" style="display:none;">
		<? if(!is_null($umil)): ?>
		<? foreach($umil as $t): ?>
			<span class="contenedor_list_precios_producto">
				<span class="contenedor_list_producto_txt">
					<a href="<?=$t->get('id')?>/<?=$t->get('permalink')?>"><?=$t->get('tipo')?> <?=$t->get('precio')?> y <?=$t->get('titulo')?></a>
				</span>

				<? foreach($t->get('imagenes') as $img): ?>
					<img src="/upload/img/thumb_<?=$img?>">
					<? break; ?>
				<? endforeach; ?>

			</span> 
		<? endforeach; ?>
		<? endif; ?>

		<div class="cont_entrar_secc_list">
			<a href="/1000" target="_blank">Entrar a todo $1.000</a>
		</div>
	</div>

	<div class="contenido_list_produc contenido_list_produc_fnd list-2mil" style="display:none;">
		<? if(!is_null($dmil)): ?>
		<? foreach($dmil as $t): ?>
			<span class="contenedor_list_precios_producto">
				<span class="contenedor_list_producto_txt">
					<a href="<?=$t->get('id')?>/<?=$t->get('permalink')?>"><?=$t->get('tipo')?> <?=$t->get('precio')?> y <?=$t->get('titulo')?></a>
				</span>

				<? foreach($t->get('imagenes') as $img): ?>
					<img src="/upload/img/thumb_<?=$img?>">
					<? break; ?>
				<? endforeach; ?>

			</span> 
		<? endforeach; ?>
		<? endif; ?>

		<div class="cont_entrar_secc_list">
			<a href="/2000" target="_blank">Entrar a todo $2.000</a>
		</div>
	</div>

	<div class="contenido_list_produc contenido_list_produc_fnd list-5mil" style="display:none;">
		<? if(!is_null($cmil)): ?>
		<? foreach($cmil as $t): ?>
			<span class="contenedor_list_precios_producto">
				<span class="contenedor_list_producto_txt">
					<a href="<?=$t->get('id')?>/<?=$t->get('permalink')?>"><?=$t->get('tipo')?> <?=$t->get('precio')?> y <?=$t->get('titulo')?></a>
				</span>

				<? foreach($t->get('imagenes') as $img): ?>
					<img src="/upload/img/thumb_<?=$img?>">
					<? break; ?>
				<? endforeach; ?>

			</span> 
		<? endforeach; ?>
		<? endif; ?>

		<div class="cont_entrar_secc_list">
			<a href="/5000" target="_blank">Entrar a todo $5.000</a>
		</div>
	</div>

	<div class="contenido_list_produc contenido_list_produc_fnd list-10mil" style="display:none;">
		<? if(!is_null($dimil)): ?>
		<? foreach($dimil as $t): ?>
			<span class="contenedor_list_precios_producto">
				<span class="contenedor_list_producto_txt">
					<a href="<?=$t->get('id')?>/<?=$t->get('permalink')?>"><?=$t->get('tipo')?> <?=$t->get('precio')?> y <?=$t->get('titulo')?></a>
				</span>

				<? foreach($t->get('imagenes') as $img): ?>
					<img src="/upload/img/thumb_<?=$img?>">
					<? break; ?>
				<? endforeach; ?>

			</span> 
		<? endforeach; ?>
		<? endif; ?>

		<div class="cont_entrar_secc_list">
			<a href="/10000" target="_blank">Entrar a todo $10.000</a>
		</div>
	</div>

	<div class="contenido_list_produc contenido_list_produc_fnd list-20mil" style="display:none;">
		<? if(!is_null($vmil)): ?>
		<? foreach($vmil as $t): ?>
			<span class="contenedor_list_precios_producto">
				<span class="contenedor_list_producto_txt">
					<a href="<?=$t->get('id')?>/<?=$t->get('permalink')?>"><?=$t->get('tipo')?> <?=$t->get('precio')?> y <?=$t->get('titulo')?></a>
				</span>

				<? foreach($t->get('imagenes') as $img): ?>
					<img src="/upload/img/thumb_<?=$img?>">
					<? break; ?>
				<? endforeach; ?>

			</span> 
		<? endforeach; ?>
		<? endif; ?>

		<div class="cont_entrar_secc_list">
			<a href="/20000" target="_blank">Entrar a todo $20.000</a>
		</div>
	</div>

</div>

<!--
<div class="cont_entrar_secc_list">
	<a href="#">Entrar a todo $5.000</a>
</div>
-->

<script>
$('.ul_tabs_list li a').live('click', function() {

	event.preventDefault();
	$('.ul_tabs_list li a').removeClass("activo");
	$('.ul_tabs_list li a').removeClass("contenido_list_produc_fnd");

	$(this).addClass("activo");
	$(this).addClass("contenido_list_produc_fnd");

	$('.contenido_list_produc').hide();
	$("."+$(this).attr('data-show')).show();
	console.log($(this).attr('data-show'));

})
</script>