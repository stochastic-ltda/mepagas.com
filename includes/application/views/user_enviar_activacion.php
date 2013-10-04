
<!-- // Email incorrecto -->
<? if($action == 1) : ?>
<script>
	alert("Email incorrecto");
	document.location="/";
</script>
<? endif; ?>

<!-- // Email enviado -->
<? if($action == 2) : ?>
<script>
	alert("La cuenta ya se encuentra activa");
	document.location="/";
</script>
<? endif; ?>

<!-- // Email enviado -->
<? if($action == 3) : ?>
<script>
	alert("Hemos enviado un email con los pasos necesarios para la activacion");
	history.go(-1);
</script>
<? endif; ?>

