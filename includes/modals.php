<!-- // Modal login -->
<div id="logmodal" class="reveal-modal small">
     <a class="close-reveal-modal">&#215;</a>
	<h1>Inicia tu sesión</h1>
	<form method="post" onsubmit="userlogin(this)">
		<input type="text" id="email" name="email" placeholder="Email">
		<input type="password" id="password" name="password" placeholder="Contraseña">
		<div id="passforgot"><a href="/usuario/recuperar-clave">¿Olvidaste tu contraseña?</a></div>
		<ul class="errors" id="log-errorlist"></ul>
		<input type="submit" name="login" id="login" value="Login">
	</form>

	<h2>O también puedes...</h2>
	<div class="fb-button" onclick="fb_login()">
		Ingresar vía Facebook
	</div>
</div>

<!-- // Modal registro -->
<div id="regmodal" class="reveal-modal small">
	<a class="close-reveal-modal">&#215;</a>
	<h1>Primero crea tu propia cuenta</h1>
	<form method="post" onsubmit="userregister(this)">
		<input type="text" id="nombre" name="nombre" placeholder="Nombre">
		<input type="text" id="email" name="email" placeholder="Email">
		<input type="password" id="password" name="password" placeholder="Contraseña">
		<p><input type="checkbox" name="terms" id="terms"> He leído y acepto los <a href="#">Términos de Servicio</a> de Mepagas.com</p>
		<ul class="errors" id="reg-errorlist"></ul>
		<input type="submit" name="registrar" id="registrar" value="Crear cuenta">
	</form>

	<h2>O también puedes...</h2>
	<div class="fb-button" onclick="fb_login()">
		Registrarte vía Facebook
	</div>
</div>

<!-- // Modal mensaje -->
<div id="msjmodal" class="reveal-modal small">
	<a class="close-reveal-modal">&#215;</a>
	<h1>Envía un mensaje</h1>
	<form method="post" onsubmit="sendmsj(this)">
		<p id="msjde">De: {{msjde}}</p>
		<p id="msjpara">Para: {{msjpara}}</p>
		<input type="hidden" name="from" id="from">
		<input type="hidden" name="to" id="to">
		<input type="hidden" name="aviso" id="aviso">
		<p>Mensaje:</p>
		<textarea name="msjbody" id="msjbody"></textarea>
		<ul class="errors" id="msj-errorlist"></ul>
		<div id="msj-donelist"></div>
		<input type="submit" name="enviar" id="enviar" value="Enviar mensaje">
	</form>
</div>