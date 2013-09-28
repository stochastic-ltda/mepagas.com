<!-- // No token -->
<? if($action == 1) : ?>
<script type="text/javascript">document.location = "/";</script>
<? endif; ?>

<!-- // Done -->
<? if($action == 2) : ?>
<script type="text/javascript">
	alert("Tu cuenta ha sido activada!\nHaz clic en Login e inicia tu sesión de usuario");
	document.location = "/";
</script>
<? endif; ?>

<!-- // Token not founded -->
<? if($action == 3) : ?>
<script type="text/javascript">
	alert("Usuario no encontrado. Vuelve a intentarlo más tarde o contacta a uno de los administradores");
	document.location = "/";
</script>
<? endif; ?>