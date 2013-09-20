<script>
$.post('/includes/phpscripts/user_is_user.php', {code: getCookie('mutm_gif'), userid: <?=$user->get('id')?>}, function(response){
	if(response == 'false') {
		$('#user_edit').html("");
		document.location = "/";
	}
});
</script>

<div class="content" id="user_edit">
	<h1>Editar información de usuario</h1>

	<form method="post" action="/includes/phpscripts/user_update_info.php" enctype="multipart/form-data">

		<input type="hidden" name="id" value="<?=$user->get('id')?>">

		<? if(!$isFacebook): ?>
			<div class="section-half">
				<p>Usuario: <input type="text" name="usuario" value="<?=$user->get('usuario')?>"></p>
				<p>Nombre: <input type="text" name="nombre" value="<?=$user->get('nombre')?>"></p>
				<p><input type="checkbox" id="soyempresa" name="isempresa" <?=($user->get('nombre_empresa')!='')?'checked':'';?>> represento una empresa</p>
				<p>Empresa: <input type="text" name="nombre_empresa" value="<?=$user->get('nombre_empresa')?>"></p>
				<p>Email: <input type="text" name="email" value="<?=$user->get('email')?>"></p>
				<input type="hidden" name="oldemail" value="<?=$user->get('email')?>">
				<p>Teléfono: <input type="text" name="telefono" value="<?=$user->get('telefono')?>"></p>
			</div>

			<div class="section-half">
				<p>Avatar</p>
				<img src="<?=$user->get('avatar')?>">
				<input type="file" name="avatar">
			</div>

			<div class="section-full">
				<p>Acerca de mí:</p>
				<textarea name="acercade"><?=str_replace("<br />", "", $user->get('acercade'))?></textarea>
			</div>
		<? endif; ?>

		<? if($isFacebook): ?>
			<div class="section-half">
				<p>Usuario: <?=$user->get('usuario')?></p>
				<p>Nombre: <?=$user->get('nombre')?></p>
				<p><input type="checkbox" id="soyempresa" name="isempresa" <?=($user->get('nombre_empresa')!='')?'checked':'';?>> represento una empresa</p>
				<p>Empresa: <input type="text" name="nombre_empresa" value="<?=$user->get('nombre_empresa')?>"></p>
				<p>Email: <?=$user->get('email')?></p>
				<p>Teléfono: <?=$user->get('telefono')?></p>
			</div>

			<div class="section-half">
				<p>Avatar</p>
				<img src="<?=$user->get('avatar')?>?type=large">
				<input type="hidden" name="avatar" value="<?=$user->get('avatar')?>">
			</div>

			<div class="section-full">
				<p>Acerca de mí:</p>
				<textarea name="acercade"><?=str_replace("<br />", "", $user->get('acercade'))?></textarea>
			</div>
		<? endif; ?>

		<div class="section-full">
			<input type="submit" value="Actualizar mis datos" name="actualizar">
		</div>
	</form>
</div>