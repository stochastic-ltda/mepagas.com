<title><?=$title?></title>
<script type="text/javascript" src="/assets/js/user.js"></script>

<!-- // Header -->
<div class="fond_text_header_mp_despl"><div class="publish-zone_despl"><h3>Gana dinero publicando <span class="text_gratis">GRATIS</span> TU PITUTO</h3><div class="txt_publica_gratis_despl"><a href="/publica-tu-pituto">PUBLICA TU PITUTO AQUI</a></div> </div></div>

<div class="content" id="user_account">

	<div id="user-sidebar">
		<h2><?=$user->get('nombre');?></h2>
		<div id="avatar"><img src="<?=$user->get('avatar')?>?type=large"></div>

		<ul id="options">
			<li class="opt-perfil"><a href="/usuario/<?=$user->get('id')?>">Perfil</a></li>
			<li class="opt-pitutos"><a href="/usuario/<?=$user->get('id')?>?s=pit">Pitutos</a></li>
			<li class="opt-favoritos user-opt"><a href="/usuario/<?=$user->get('id')?>?s=fav">Favoritos</a></li>
			<li class="opt-calificaciones"><a href="/usuario/<?=$user->get('id')?>?s=cal">Calificaciones</a></li>
			<li class="opt-mensajes user-opt"><a href="/usuario/<?=$user->get('id')?>?s=msj">Mensajes</a></li>
			<li class="opt-cerrar_sesion user-opt"><a href="#" onclick="userlogout()">Cerrar sesión</a></li>
		</ul>
	</div>

	<div id="user-main">

		<h1><?=$h1?></h1>

		<!-- // Perfil -->
		<? if(is_null($s)): ?>
			<div class="user-opt opt-editperfil"><a href="/usuario/editar/<?=$user->get('id')?>">Editar perfil</a></div>
			<p>Nombre: <?=$user->get('nombre');?></p>
			<p>Empresa: <?=$user->get('nombre_empresa');?></p>
			<p>Acerca de mí: </p>
			<p><?=$user->get('acercade')?></p>
		<? endif; ?>

		<!-- // Pitutos -->
		<? if($s=="pit"): ?>
			<table width="100%" cellpadding="5" cellspacing="0">
			<? if(!is_null($avisos) && count($avisos) > 0): ?>
			<? foreach($avisos as $aviso): ?>
				<tr class="aviso-row">
					<td><a href="/<?=$aviso->get('id')?>/<?=$aviso->get('permalink')?>" target="_blank"><?=$aviso->get('tipo')?> <?=$aviso->get('precio')?> y <?=$aviso->get('titulo')?></a></td>
					<td class="user-opt" valign="top">
						<a href="/aviso/editar/<?=$aviso->get('id')?>">Editar</a> | 
						<? if($aviso->get('estado') == 'inactivo'): ?> <a href="#" data-id="<?=$aviso->get('id')?>" class="activar-aviso">Publicar</a> <? endif;?>
						<? if($aviso->get('estado') == 'pendiente'): ?> En espera <? endif;?>
						<? if($aviso->get('estado') == 'activo'): ?> <a href="#" data-id="<?=$aviso->get('id')?>" class="desactivar-aviso">Ocultar</a> <? endif;?>
					</td>
				</tr>
			<? endforeach; ?>
			<? endif; ?>
			</table>
		<? endif; ?>

		<!-- // Favoritos -->
		<? if($s=="fav"): ?>
			<table width="100%" cellpadding="5" cellspacing="0">
			<? foreach($favoritos as $favorito): ?>
				<tr id="fav<?=$favorito['id']?>" class="favorito-row">
					<td><a href="<?=$favorito['url']?>" target="_blank"><?=$favorito['titulo']?></a></td>
					<td class="user-opt" valign="top"><a href="#" data-id="<?=$favorito['id']?>" class="delfavorito">Eliminar</a></td>
				</tr>
			<? endforeach; ?>
			</table>
		<? endif; ?>

		<!-- // Calificacion de usuario -->
		<? if($s=="cal"): ?>
			<script src="/includes/javascripts/raty/jquery.raty.js"></script>

			<h3><?=$user->get('nombre')?></h3>
			<div id="star_recomendar-wrapper">
				<div id="star_recomendar"></div> 
				<span id="num_recomendado"><?=$user->get('r_recomendado')?></span>
				<span id="num_calificaciones">(<?=count($calificaciones)?> calificaci<?=(count($calificaciones)>1)?'ones':'ón';?>)</span>
			</div>

			<ul id="mas-calificaciones">
				<li><p class="star_label">Confiable</p> <div id="star_confiable" class="stars"></div><span class="hint_confiable"></span></li>
				<li><p class="star_label">Responsable</p> <div id="star_responsable" class="stars"></div><span class="hint_responsable"></span></li>
				<li><p class="star_label">Experiencia</p> <div id="star_experiencia" class="stars"></div><span class="hint_experiencia"></span></li>
				<li><p class="star_label">Calidad</p><div id="star_calidad" class="stars"></div><span class="hint_calidad"></span></li>
			</ul>

			<!-- // TODO: Implementar Filtros -->
			<!-- // Listado de calificaciones -->
			<h4>Listado de calificaciones</h4>
			<? $idx=0; ?>
			<div class="listado-calificaciones">
			<? foreach($calificaciones as $c): ?>
				<div class="calificacion">

					<!-- // star recomendado -->
					<div class="user-recomendado">
						<div class="star_recomendado" id="star_recomendado<?=$idx?>"></div>
						<div class="num_recomendado"><?=$recomendado[(int) ($c['calificacion']->get('r_recomendado') -1)]?></div>
					</div>
					<script>$('#star_recomendado<?=$idx?>').raty({readOnly:true,size: 35, starOn: 'star-on-semibig.png',starOff: 'star-off-semibig.png', score:<?=$c['calificacion']->get('r_recomendado')?>});</script>

					<!-- // fecha y nombre -->
					<? $date = new DateTime($c['calificacion']->get('fecha')); ?>
					<p class="date-name"><?=date_format($date, "d/m/y")?> <b><?=$c['usuario']->get('nombre')?></b></p>

					<!-- // titulo aviso -->
					<p class="title"><?=$c['aviso']->get('tipo')." ".$c['aviso']->get('precio')." y ".$c['aviso']->get('titulo')?></p>

					<!-- // mas calificaciones -->
					<ul class="user-calificaciones">
						<li><p class="star_label">Confiable</p> <div id="star_confiable<?=$idx?>" class="stars"></div></li>
						<li><p class="star_label">Responsable</p> <div id="star_responsable<?=$idx?>" class="stars"></div></li>
						<li><p class="star_label">Experiencia</p> <div id="star_experiencia<?=$idx?>" class="stars"></div></li>
						<li><p class="star_label">Calidad</p><div id="star_calidad<?=$idx?>" class="stars"></div></li>

						<script>$('#star_confiable<?=$idx?>').raty({readOnly:true, score:<?=$c['calificacion']->get('r_confiable')?>});</script>
						<script>$('#star_responsable<?=$idx?>').raty({readOnly:true, score:<?=$c['calificacion']->get('r_responsable')?>});</script>
						<script>$('#star_experiencia<?=$idx?>').raty({readOnly:true, score:<?=$c['calificacion']->get('r_experiencia')?>});</script>
						<script>$('#star_calidad<?=$idx?>').raty({readOnly:true, score:<?=$c['calificacion']->get('r_calidad')?>});</script>
					</ul>

					<!-- // detalles -->
					<p class="user-detalle"><?=$c['calificacion']->get('detalle')?></p>
					<? $idx++; ?>

				</div>
			<? endforeach; ?>
			</div>
		<? endif; ?>

		<!-- // Mensajes -->
		<? if($s=="msj"): ?>
			<ul id="msj-fold">
				<li class="active" id="btn-rec">Recibidos</li>
				<li id="btn-env">Enviados</li>
			</ul>
			
			<div id="msj-recibidos">
				<? if(count($msjrec) > 0) : ?>
					<table width="100%" cellpadding="5" cellspacing="0">
					<? foreach($msjrec as $m): ?>
						<tr id="msj<?=$m->get('id')?>" class="msj-row <?=($m->get('leido')==0)?'no-leido':''?>">
							<td id="ndesde<?=$m->get('id')?>"><?=$m->get('_desde')?></td>
							<td id="naviso<?=$m->get('id')?>"><?=$m->get('_aviso')?></td>
							<td><?=strtolower(date("j-M H:i", strtotime($m->get('fecha'))))?></td>
							<td><a href="#" data-id="<?=$m->get('id')?>" class="msj-delete"><img src="/assets/img/msj_delete.png"></a></td>
						</tr>
						<tr id="cuerpo<?=$m->get('id')?>" class="cuerpo-row" style="display:none;">
							<td colspan="4">
								<?=$m->get('mensaje')?>
								<div class="btn-responder"><a href="#" data-id="<?=$m->get('id')?>">Responder</a></div>
							</td>
						</tr>
					<? endforeach; ?>
					</table>
				<? else: ?>
					<p>No tienes nuevos mensajes</p>
				<? endif; ?>
			</div>

			<div id="msj-enviados" style="display:none">
				<? if(count($msjenv) > 0) : ?>
					<table width="100%" cellpadding="5" cellspacing="0">
					<? foreach($msjenv as $m): ?>
						<tr id="msj<?=$m->get('id')?>" class="msj-row">
							<td><?=$m->get('_para')?></td>
							<td><?=$m->get('_aviso')?></td>
							<td><?=$m->get('fecha')?></td>
							<td><a href="#" data-id="<?=$m->get('id')?>" class="msj-delete"><img src="/assets/img/msj_delete.png"></a></td>
						</tr>
						<tr id="cuerpo<?=$m->get('id')?>" class="cuerpo-row" style="display:none;">
							<td colspan="4"><?=$m->get('mensaje')?></td>
						</tr>
					<? endforeach; ?>
					</table>
				<? else: ?>
					<p>No tienes nuevos mensajes</p>
				<? endif; ?>
			</div>
		<? endif; ?>

	</div>
</div>

<script>
$('.content').user({userid: <?=$user->get('id')?>, avatar: "<?=$user->get('avatar')?>"});
</script>

<!-- // Scripts -->
<? if($s=="cal"): ?>
<script type="text/javascript">
	$('#star_recomendar').raty({
		number:5,
		readOnly:true,
		half: true,
		halfShow: true,
		starOn: 'star-on-big.png',
		starHalf: 'star-half-big.png',
		starOff: 'star-off-big.png',
		size: 35,
		score: <?=$user->get('r_recomendado')?>
	});

	$('#star_confiable').raty({
		score: <?=$user->get('r_confiable')?>,
		half: true,
		halfShow: true,
		readOnly: true
	});

	$('#star_responsable').raty({
		score: <?=$user->get('r_responsable')?>,
		half: true,
		halfShow: true,
		readOnly: true
	});

	$('#star_experiencia').raty({
		score: <?=$user->get('r_experiencia')?>,
		half: true,
		halfShow: true,
		readOnly: true

	});

	$('#star_calidad').raty({
		score: <?=$user->get('r_calidad')?>,
		half: true,
		halfShow: true,
		readOnly: true
	});
</script>
<? endif; ?>