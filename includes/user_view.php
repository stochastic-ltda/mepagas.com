<script>
$.post('/includes/phpscripts/user_is_user.php', {code: getCookie('mutm_gif'), userid: <?=$user->get('id')?>}, function(response){
	if(response == 'false') {
		//$('#user_edit').html("");
	} else {
		setCookie('avatar', "<?=$user->get('avatar')?>", 7);
	}
});
</script>
<title><?=$title?></title>
<script type="text/javascript" src="/assets/js/user.js"></script>
<script> 
	$('#divlogo').addClass('logo_mepagas_despliegue').removeClass('logo');
</script>
<div class="fond_text_header_mp_despl">
				
	<div class="publish-zone_despl">
		 <h1>Gana dinero publicando <span class="text_gratis">GRATIS</span> TU PITUTO</h1>
		<div class="txt_publica_gratis_despl">
			<a href="/publica-tu-pituto">PUBLICA TU PITUTO AQUI</a>
		</div> 
	</div>

</div>

<p class="user-opt" id="user-opt-edit"><a href="/usuario/editar/<?=$user->get('id')?>">Editar</a></p>

<div class="content" id="user_account">

	<div class="user_general row">
		<div id="user_avatar"><img src="<?=$user->get('avatar')?>?type=large"></div>
		<div id="user_info">
			<h1><?=$user->get('usuario')?></h1>
			<ul>
				<li>Nombre: <?=$user->get('nombre')?></li>
				<li>Empresa: <?=$user->get('nombre_empresa')?></li>
				<li>Email: <?=$user->get('email')?></li>
				<li>Teléfono: <?=$user->get('telefono')?></li>
			</ul>
		</div>		
		<div id="user_about">
			<?=$user->get('acercade')?>
		</div>
	</div>

	<div class="user_data row">
		<div id="user_avisos">
			<h3>Mis Avisos</h3>
			<table width="100%" cellpadding="5" cellspacing="0">
			<? if(!is_null($aviso) && count($aviso) > 0): ?>
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
		</div>

		<div id="user_favoritos">
			<h3>Mis Favoritos</h3>
			<table width="100%" cellpadding="5" cellspacing="0">
			<? foreach($favoritos as $favorito): ?>
				<tr id="fav<?=$favorito['id']?>" class="favorito-row">
					<td><a href="<?=$favorito['url']?>" target="_blank"><?=$favorito['titulo']?></a></td>
					<td class="user-opt" valign="top"><a href="#" data-id="<?=$favorito['id']?>" class="delfavorito">Eliminar</a></td>
				</tr>
			<? endforeach; ?>
			</table>
		</div>
	</div> 

</div>

<script>
$('.content').user({userid: <?=$user->get('id')?>});
</script>