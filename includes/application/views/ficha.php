<? if(is_null($data)): ?>
	<title>Aviso en proceso de carga</title>
	<div id="pituto-no-disponible">		
		<p align="center">Tu pituto estará disponible dentro de los próximos segundos...</p>
		<meta http-equiv="refresh" content="10">
	</div>
<? endif; ?>

<? if(!is_null($data)): ?>

	<title><?=$title?></title>
	<META NAME="Description" CONTENT="<?=strip_tags($data['descripcion'])?>">
	<script> 
		var userid = <?=$data['id_usuario']?>; 
		$('#divlogo').addClass('logo_mepagas_despliegue').removeClass('logo');
	</script>

	<div class="fond_text_header_mp_despl">
					
		<div class="publish-zone_despl">
			 <h3>Gana dinero publicando <span class="text_gratis">GRATIS</span> TU PITUTO</h3>
			<div class="txt_publica_gratis_despl">
				<a href="/publica-tu-pituto">PUBLICA TU PITUTO AQUI</a>
			</div> 
		</div>

	</div>

	<div class="contenedor_nav_superior_despl">

		<div class="contenido_nav_categorias">
	        <a href="javascript:history.go(-1)">Volver</a>
	        <a href="/<?=$data['precio']?>">Todo a $<?=$precio?></a>
	        <a href="/<?=$data['precio']?>/<?=$categoria_url?>"><?=$data['categoria']?></a>
	        <a href="/<?=$data['precio']?>/<?=$categoria_url?>/<?=$subcategoria_url?>"><?=$data['subcategoria']?></a>
		</div>

		<div class="contenido_nav_ant_sig" style="display:none">
			<span class="flecha_nav_ant">
				<a href="#">Anterior</a>|
			</span>
			<a href="#">Volver</a>
			<span class="flecha_nav_sig">
				|<a href="#">Siguiente</a>
			</span>
		</div>
	</div>  

	<h1 class="h1-ficha"><?=$title?></h1>

	<aside class="contenido_centro_despl_full">
		
		<aside class="contenido_full_centro_izq">
			
			 <div class="contenedor_galeria_full">
				 <div class="cont_galeria_nav" id="gallery" data-selected="0">
				 	<? $idx=0; ?>
			 		<? foreach($data['imagenes'] as $i) : ?>
			 			<img src="/upload/img/<?=$i?>" id="img-<?=$idx?>" <?=($idx++>0)?'style="display:none"':''?>>
			 		<? endforeach; ?>							 	
					<a href="#" class="cont_galeria_nav_ant">ANTERIOR</a>
					<a href="#" class="cont_galeria_nav_sig">SIGUIENTE</a>
				</div> 

			</div> 

		</aside>

		<aside class="contenido_full_centro_der">

			<h2>Precio</h2>
			<div class="precio_conten_desp">
				<span class="contendor_precio_txt color_billete_5mil">$<?=$precio?></span>
				<span class="contendor_precio_icon"><img src="/assets/img/billete_5mil_gran.png"/></span>
			</div>

			<h2>Cobertura del Servicio</h2>
			<div class="contenedor_coberturas_servicios">
				<? foreach($data['localidades'] as $l): ?>
					<a href="#"><?=$l?></a>
				<? endforeach; ?>
			</div>

			<? if($data['estado'] == 'pendiente'): ?>
			<h2 style="color:red">Aviso en proceso de aprobación</h2>
			<? endif; ?>

			<!-- // TODO: Implementar calificacion de aviso -->
			<!--
			<h2>Calificar</h2>
			<div class="contenedor_calificar">
				<a href="#">Estrella 1</a>
				<a href="#">Estrella 2</a>
				<a href="#">Estrella 3</a>
				<a href="#">Estrella 4</a>
				<a href="#">Estrella 5</a>
			</div>
			-->

		</aside>

		<div class="contenido_fav_denuncia">
			 <div class="contenido_fav_den_right">
				<a href="#" class="contenido_fav_denuncia_mar" id="user-favorito">Añadir a Favoritos</a>
				<a href="#" id="user-denunciar">Denunciar</a>
			</div> 
		</div>

		<div class="contenido_ficha_descripcion">
			<h2>Descripción</h2>
			<p><?=strip_tags($data['descripcion'],"<b><i><br><ul><ol><u><strong><em><p><div><span><li>")?></p> 
		</div>

		<div class="contenido_selec_precios" style="display:none">
			<div class="contendor_tabs_list">
				<ul class="ul_tabs_list">
					<li><a href="#" class="activo contenido_list_produc_fnd">Todos</a></li>
					<li><a href="#"><span class="color_billete_mil tamano_num_list">1.000</span><span class="img_billete_list"><img src="/assets/img/billete_mil.png"/></span></a></li>
					<li><a href="#"><span class="color_billete_2mil tamano_num_list">2.000</span><span class="img_billete_list"><img src="/assets/img/billete_2mil.png"/></span></a></li>
					<li><a href="#"><span class="color_billete_5mil tamano_num_list">5.000</span><span class="img_billete_list"><img src="/assets/img/billete_5mil.png"/></span></a></li>
					<li><a href="#"><span class="color_billete_10mil tamano_num_list">10.000</span><span class="img_billete_list"><img src="/assets/img/billete_10mil.png"/></span></a></li>
					<li><a href="#"><span class="color_billete_20mil tamano_num_list">20.000</span><span class="img_billete_list"><img src="/assets/img/billete_20mil.png"/></span></a></li>
				</ul>

				<div class="contenido_list_produc contenido_list_produc_fnd">
					<span class="contenedor_list_precios_producto">
						<span class="contenedor_list_producto_txt">
							<a href="#">Me pagas $5.000 y te corto el pasto con máquina lalalal</a>
						</span>
						<img src="/assets/img/img_aviso_lista.jpg"/>
					</span> 
					<span class="contenedor_list_precios_producto">
						<span class="contenedor_list_producto_txt">
							<a href="#">Me pagas $5.000 y te corto el pasto con máquina lalalal</a>
						</span>
						<img src="/assets/img/img_aviso_lista.jpg"/>
					</span> 
					<span class="contenedor_list_precios_producto">
						<span class="contenedor_list_producto_txt">
							<a href="#">Me pagas $5.000 y te corto el pasto con máquina lalalal</a>
						</span>
						<img src="/assets/img/img_aviso_lista.jpg"/>
					</span> 
					<span class="contenedor_list_precios_producto">
						<span class="contenedor_list_producto_txt">
							<a href="#">Me pagas $5.000 y te corto el pasto con máquina lalalal</a>
						</span>
						<img src="/assets/img/img_aviso_lista.jpg"/>
					</span> 
				</div>

			</div>

			<div class="cont_entrar_secc_list">
				<a href="#">Entrar a todo $5.000</a>
			</div>

		</div>

		<div class="contenedor_disqus">
		    <div id="disqus_thread"></div>
		    <script type="text/javascript">
		        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		        var disqus_shortname = 'mepagascom'; // required: replace example with your forum shortname

		        /* * * DON'T EDIT BELOW THIS LINE * * */
		        (function() {
		            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
		            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		        })();
		    </script>
		    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
		</div>

	</aside>

	<!-- // User info -->
	<aside class="contenido_centro_despl_full_usuario">
		 <div class="contenido_usuario_despl"></div> 
	</aside>

	<!-- // Ficha scripts -->
	<script type="text/javascript" src="/assets/js/ficha.js">

<? endif; ?>