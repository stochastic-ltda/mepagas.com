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
		<? if($s=="cal"): ?><? endif; ?>

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