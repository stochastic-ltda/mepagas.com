<?php
if (!class_exists('CategoriaMapper')) { include( dirname(__FILE__) . '/classes/Mappers/CategoriaMapper.php'); }
if (!class_exists('SubcategoriaMapper')) { include( dirname(__FILE__) . '/classes/Mappers/SubcategoriaMapper.php'); }
?>

<div class="publish-zone">
	<h1>En Mepagas.com gana dinero publicando <span class="gratis">GRATIS</span> TU PITUTO</h1> 
	<div class="text">
		<a href="/publica-tu-pituto">PUBLICA TU PITUTO AQUI</a>
	</div>
</div>

<div class="content">

	<aside class="sidebar-wrapper">
		
		<div class="sidebar">
			<!-- // Filtros -->
			<nav><ul>

				<? if(isset($term_precio) && !is_null($term_precio)): ?>
					<? $url = (isset($term_subcategoria)) ? "/".$term_categoria."/".$term_subcategoria : "/".$term_categoria; ?>
					<li><a href="<?=$url?>">[X] Precio: <?=$term_precio?></a></li>
				<? endif; ?>

				<? if(isset($term_categoria) && !is_null($term_categoria)): ?>
					<li><a href="/<?=$term_precio?>">[X] Categoria: <?=$term_categoria?></a></li>
				<? endif; ?>

				<? if(isset($term_subcategoria) && !is_null($term_subcategoria)): ?>
					<li><a href="/<?=$term_precio?>/<?=$term_categoria?>">[X] Subcategoria: <?=$term_subcategoria?></a></li>
				<? endif; ?>

			</ul></nav>

			<!-- // Facets -->
			<? if(!isset($term_precio) || is_null($term_precio)): ?>
				<h2>Precios</h2>
				<nav>
					<ul>		
						<? $url = (isset($term_subcategoria)) ? "/".$term_categoria."/".$term_subcategoria : "/".$term_categoria; ?>

						<? foreach($facets['precio']['terms'] as $precio): ?>
							<? $monto = $precio['term']; ?>
							<? if($precio['term']>20000) $precio['term'] = 'cheque'; ?>							
							<li class="bg-<?=$precio['term']?>">
								<a href="/<?=$monto?><?=$url?>">
									Todo a <span class="color-<?=$precio['term']?>"><?=number_format($monto,0,",",".")?></span> (<?=$precio['count']?>)
								</a>
							</li>
						<? endforeach; ?>					
					</ul>
				</nav>
			<? endif;?>

			<? if(!isset($term_categoria) || is_null($term_categoria)): ?>
				<h2>Categorías</h2>
				<nav>
					<ul>
						<? $base_cat_url = (isset($term_precio)) ? '/'.$term_precio.'/':'/';  ?>
						<? foreach($facets['categoria']['terms'] as $cat): ?>
							<li><a href="<?=$base_cat_url . CategoriaMapper::getPermalinkByNombre($cat['term'])?>"><?=$cat['term']?></span> (<?=$cat['count']?>)</a></li>
						<? endforeach; ?>
					</ul>
				</nav>
			<? endif; ?>

			<? if(isset($term_categoria) && !is_null($term_categoria)): ?>
				<h2>Sub Categorías</h2>
				<nav>
					<ul>
						<? $base_subcat_url = (isset($term_precio)) ? '/'.$term_precio.'/'.$term_categoria.'/':'/'.$term_categoria.'/';  ?>
						<? foreach($facets['subcategoria']['terms'] as $cat): ?>
							<li><a href="<?=$base_subcat_url. SubcategoriaMapper::getPermalinkByNombre(utf8_decode($cat['term']))?>""><?=$cat['term']?></span> (<?=$cat['count']?>)</a></li>
						<? endforeach; ?>
					</ul>
				</nav>
			<? endif; ?>
		</div>

	</aside>

	<aside class="main">

		<div class="controls-wrapper">
			<h3>Últimos Avisos</h3>
			<div class="controls">

				<div class="display">
					<span class="icon_orden"><a href="#"><img src="/assets/img/ordenar_1.jpg"/></a></span>
					<span class="icon_orden"><a href="#"><img src="/assets/img/ordenar_2.jpg"/></a></span>
				</div>

				<div class="order">
					<span class="orden">orden</span>
					<span class="orden_arrb"><a href="#"><img src="/assets/img/flecha_arriba.png"/></a></span>
					<span class="orden_pagina">12</span>
				</div>
				
			</div>
		</div>

		<!-- // INICIO: Despliegue de Resultados -->
		<? foreach($results as $r): ?>

			<article class="aviso">

				<? if(!is_null($r->__get('thumbnail'))): ?>
					<div class="thumb">
						<img src="/upload/img/<?=$r->__get('thumbnail')?>"/>
					</div>
				<? endif; ?>

				<div class="text <?=(!is_null($r->__get('thumbnail')))?'si':'no'?>-image">
					<h1><a href="#"><?=$r->__get('tipo')?> <span class="color-<?=$r->__get('precio')?>">$<?=number_format($r->__get('precio'),0,",",".")?></span> y <?=$r->__get('titulo')?></a></h1>
					<p><?=substr(strip_tags($r->__get('descripcion')),0,150)?>...</p>
					<span class="price">
						<span class="price-bill bg-<?=($r->__get('precio')>20000)?'cheque':$r->__get('precio');?>"><span class="color-<?=$r->__get('precio')?>"><?=number_format($r->__get('precio'),0,",",".")?></span></span>
					</span>
				</div>

			</article>

		<? endforeach; ?>
		<!-- // FIN: Despliegue de Resultados -->

	</aside>

</div>