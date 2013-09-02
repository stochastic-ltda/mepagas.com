
// ------------------------------------------------------------------------------------------
// LOGICA DE DIVS
// ------------------------------------------------------------------------------------------

$('#sreg').on('click', function() {
	$('#usuario-registro').show();
	$('#usuario-login').hide();
	return false;
});

$('#slogin').on('click', function() {
	$('#usuario-registro').hide();
	$('#usuario-login').show();
	return false;
});

// ------------------------------------------------------------------------------------------
// FORMULARIO REGISTRO DE NUEVO USUARIO
// ------------------------------------------------------------------------------------------

$('#soyempresa').on('click', function() {

	if($(this).is(':checked')) {
		$('#user-enterprise-group').show();
	} else {
		$('#user-enterprise-group').hide();
	}

});

$('.lu').on('click', function(){

	var email = $('#login-email').val();
	var pass = $('#login-pass').val();
	var failed = false;

	if(email=='' || pass=='') failed = true;

	if(failed) {
		alert("Email o password incorrecto");
	} else {

		var request = $.ajax({
			type: "POST",
			url: '/includes/phpscripts/user_login.php', 
			data: {email:email, pass:pass},
			dataType: "json",
			success: function(data) {

				console.log(data);
				if(data.length == 0) {
					alert("Email o password incorrecto");
				} else {

					// inicio sesion
					setCookie('email', data.email);
					setCookie('username', data.nombre);
					setCookie('userid', data.userid);
					setCookie('avatar', data.avatar);

					$.post('/includes/phpscripts/user_loadregdata.php', {email:data.email}, function(response) {

						if(response == "ERROR") {
							alert("Ha ocurrido un problema, por favor inténtelo más tarde");
						} else {							
							$('#usuario-logged').html(response);
							$('#usuario-logged').show();
							$('#usuario-login').hide();
							$('#usuario-registro').hide();						
						}

					});

				}
			}
		});

	}

	return false;

});

$('.cc').on('click', function() {

	var nombre = $('#user-name').val();
	var telefono = $('#user-phone').val();
	var email = $('#user-email').val();
	var password = $('#user-pass').val();
	var isempresa = $('#soyempresa').is(':checked');
	var empresa = $('#user-enterprise').val();

	var request = $.ajax({
		type: "POST",
		url: '/includes/phpscripts/user_create.php', 
		data: { 
			nombre:nombre, 
			telefono:telefono, 
			email:email, 
			password:password, 
			isempresa:isempresa,
			empresa:empresa 
		},
		dataType: "json", 
		success: function(data) {

			if(typeof data.userid != "undefined") {

				// inicio sesion
				setCookie('email', email);
				setCookie('username', nombre);
				setCookie('userid', data.userid);
				setCookie('avatar', '');
				$.post('/includes/phpscripts/user_loadregdata.php', {email:email}, function(response) {

					if(response == "ERROR") {
						alert("Ha ocurrido un problema, por favor inténtelo más tarde");
					} else {							
						$('#usuario-logged').html(response);
						$('#usuario-logged').show();
						$('#usuario-login').hide();
						$('#usuario-registro').hide();						
					}

				});

			} else {
				// error en validacion 
				// muestro problemas de validacion
				for(var i=0; i<data.length; i++) alert(data[i]);
			}
		}
	});


	return false;

});

function checkul() {

	var email = getCookie('email');
	if(email != '' && typeof email != "undefined") {

		$.post('/includes/phpscripts/user_loadregdata.php', {email:email}, function(response) {

			if(response == "ERROR") {
				alert("Ha ocurrido un problema, por favor inténtelo más tarde");
			} else {							
				$('#usuario-logged').html(response);
				$('#usuario-logged').show();
				$('#usuario-login').hide();
				$('#usuario-registro').hide();						
			}

		});

	}
}

// ------------------------------------------------------------------------------------------
// REGISTRO CON FACEBOOK
// ------------------------------------------------------------------------------------------

function userdata() {
	FB.api('/me', function(userinfo) {

		var request = $.ajax({
			type: "POST",
			url: '/includes/phpscripts/user_create_facebook.php', 
			data: userinfo, 
			dataType: "json", 
			success: function(data) {

				if(typeof data.userid != "undefined") {

					// inicio sesion
					setCookie('email', userinfo.email);
					setCookie('username', userinfo.username);
					setCookie('userid', data.userid);
					setCookie('avatar', "http://graph.facebook.com/" + userinfo.id + "/picture");

					$.post('/includes/phpscripts/user_loadregdata.php', {email:userinfo.email}, function(response) {

						if(response == "ERROR") {
							alert("Ha ocurrido un problema, por favor inténtelo más tarde");
						} else {							
							$('#usuario-logged').html(response);
							$('#usuario-logged').show();
							$('#usuario-login').hide();
							$('#usuario-registro').hide();						
						}

					});

				}

			}
		});
	});	
}

// ------------------------------------------------------------------------------------------
// CATEGORIAS
// ------------------------------------------------------------------------------------------

$('#categorias').on('change', function() {

	var catID = $(this).val().split('||')[0];
	$.post('/includes/phpscripts/publish_categorias.php', {id_categoria:catID}, function(data){
		$('#subcategorias-wrapper').html(data);
	});

});