<div class="content" id="user_edit">
	<h1>Recuperar contraseña de usuario</h1>

	<? if($action == 1): ?>

		<form method="post" onsubmit="userrecover(this)">

			<div class="section-half">
				<p>Ingresa tu email:</p>
				<p>
					<input type="text" name="email" value="">
					<input type="submit" value="Enviar" name="enviar">
				</p>
				<ul class="errors" id="rec-errorlist"></ul>
				<ul class="dones" id="rec-donelist"></ul>
				<p class="infotext">Te enviaremos un correo electrónico con los pasos necesarios para poder restaurar tu contraseña de usuario.</p>
			</div>
		</form>

	<? endif; ?>

	<? if($action == 2): ?>

		<form method="post" action="">

			<div class="section-half">
				<p>Ingresa tu nueva contraseña: <input type="password" name="pass1" value=""></p>
				<p>Vuelve a escribir tu contraseña: <input type="password" name="pass2" value=""></p>
				<p><input type="submit" value="Actualizar" name="actualizar"></p>
			</div>
		</form>

	<? endif; ?>


</div>
