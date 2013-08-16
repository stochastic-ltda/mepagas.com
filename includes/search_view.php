<div class="publish-zone">
	<h1>En Mepagas.com gana dinero publicando <span class="gratis">GRATIS</span> TU PITUTO</h1> 
	<div class="text">
		<a href="/publica-tu-pituto">PUBLICA TU PITUTO AQUI</a>
	</div>
</div>

<div class="content">

	<aside class="sidebar-wrapper">
		
		<div class="sidebar">
			<!-- // Facets -->
			<h2>Precios</h2>
			<nav>
				<ul>
					<? foreach($facets['precio']['terms'] as $precio): ?>
						<li class="bg-<?=$precio['term']?>">
							<a href="#">
								Todo a <span class="color-<?=$precio['term']?>"><?=number_format($precio['term'],0,",",".")?></span> (<?=$precio['count']?>)
							</a>
						</li>
					<? endforeach; ?>
				</ul>
			</nav>

			<!--
			<h2>Cheques</h2>
			<nav>
				<ul>
					<li class="bg-cheque"><a href="#">Todo a 100.000</span></a></li>
					<li class="bg-cheque"><a href="#">Todo a 250.000</span></a></li>
					<li class="bg-cheque"><a href="#">Todo a 400.000</span></a></li>
					<li class="bg-cheque"><a href="#">Todo a 550.000</span></a></li>
					<li class="bg-cheque"><a href="#">Todo a 650.000</span></a></li>
				</ul>
			</nav>
			-->

			<h2>Categorías</h2>
			<nav>
				<ul>
					<? foreach($facets['categoria']['terms'] as $cat): ?>
						<li><a href="#"><?=$cat['term']?></span> (<?=$cat['count']?>)</a></li>
					<? endforeach; ?>
				</ul>
			</nav>
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
						<img src="/upload/<?=$r->__get('thumbnail')?>"/>
					</div>
				<? endif; ?>

				<div class="text <?=(!is_null($r->__get('thumbnail')))?'si':'no'?>-image">
					<h1><a href="#"><?=$r->__get('tipo')?> <span class="color-<?=$r->__get('precio')?>">$<?=number_format($r->__get('precio'),0,",",".")?></span> y <?=$r->__get('titulo')?></a></h1>
					<p><?=substr(strip_tags($r->__get('descripcion')),0,150)?>...</p>
					<span class="price">
						<span class="price-bill bg-<?=$r->__get('precio')?>"><span class="color-<?=$r->__get('precio')?>"><?=number_format($r->__get('precio'),0,",",".")?></span></span>
					</span>
				</div>

			</article>

		<? endforeach; ?>
		<!-- // FIN: Despliegue de Resultados -->

	</aside>

</div>