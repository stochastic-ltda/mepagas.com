(function($) {

	$.fn.publish = function(options) {

		// Variables
		var defaults = {} // default variables

		$.fn.publish.options = $.extend(defaults, options);
        var options = $.fn.publish.options;

        // Functions
        // Logica de div's
        var showregistro = function() {
        	$('#usuario-registro').show();
			$('#usuario-login').hide();
			return false;
        }

        var showlogin = function() {
        	$('#usuario-registro').hide();
			$('#usuario-login').show();
			return false;
        }

        // Formulario registro nuevo usuario
        var toggleempresa = function() {
        	if($(this).is(':checked')) $('#user-enterprise-group').show();
			else $('#user-enterprise-group').hide();
        }

        var loginuser = function() {

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

        }

        var createuser = function() {

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

        }

        var changecategory = function() {
        	var catID = $(this).val().split('||')[0];
			$.post('/includes/phpscripts/publish_categorias.php', {id_categoria:catID}, function(data){
				$('#subcategorias-wrapper').html(data);
			});
        }

        var processaviso = function() {

        	// Obtengo datos
			var tipo = $('#tipo').val();
			var precio = $('#precio').val();
			var titulo = $('#titulo').val();
			var categoria = $('#categorias').val().split("||")[1];
			var subcategoria = $('#subcategorias').val();
			var descripcion = $('#descripcion').val();
			
			var i=0;
			var localidades = new Array();
			$('.search-choice span').each(function() {
				localidades[i] = $(this).html();
				i++;
			});

			var imagenes = new Array();
			var j=0;
			$('.image-thumb img').each(function() {
				var src = $(this).attr('src');
				if(src != '/assets/img/delete.png') {
					imagenes[j] = src.replace("/upload/img/thumb_","");
					j++;
				}
			});

			var acepto = $('#acepto').is(":checked");	
			var id_usuario = getCookie('userid');

			// TODO: Validacion de campos
			if(validaraviso()) {

				// Procesamiento de datos
				$.post('/includes/phpscripts/publish_aviso.php', {id_usuario:id_usuario, tipo:tipo, precio:precio, titulo:titulo, categoria:categoria, subcategoria:subcategoria, descripcion:descripcion, localidades:localidades, imagenes:imagenes, acepto:acepto}, function(data) {
					
					// TODO: Procesar posibles errores de carga en el aviso
					alert("Su aviso ha sido modificado");
					document.location="/";
				});

			}

        }

        var editaraviso = function() {

        	// Obtengo datos
        	var avisoid = $('#avisoid').val();
        	console.log(avisoid);
			var tipo = $('#tipo').val();
			var precio = $('#precio').val();
			var titulo = $('#titulo').val();
			var categoria = $('#categorias').val().split("||")[1];
			var subcategoria = $('#subcategorias').val();
			var descripcion = $('#descripcion').val();
			
			var i=0;
			var localidades = new Array();
			$('.search-choice span').each(function() {
				localidades[i] = $(this).html();
				i++;
			});

			var imagenes = new Array();
			var j=0;
			$('.image-thumb img').each(function() {
				var src = $(this).attr('src');
				if(src != '/assets/img/delete.png') {
					imagenes[j] = src.replace("/upload/img/thumb_","");
					j++;
				}
			});

			var acepto = $('#acepto').is(":checked");	
			var id_usuario = getCookie('userid');

			// TODO: Validacion de campos
			if(validaraviso()) {

				// Procesamiento de datos
				$.post('/includes/phpscripts/publish_edit_aviso.php', {id: avisoid, id_usuario:id_usuario, tipo:tipo, precio:precio, titulo:titulo, categoria:categoria, subcategoria:subcategoria, descripcion:descripcion, localidades:localidades, imagenes:imagenes, acepto:acepto}, function(data) {
					
					// TODO: Procesar posibles errores de carga en el aviso
					alert("Tu aviso ha sido actualizado");
					document.location="/aviso/editar/"+avisoid;
				});

			}

        }

        var validaraviso = function() {

        	var ret = true;

        	// Validacion de usuario
        	var email = getCookie('email');
			if(email == '' || typeof email == "undefined") {
				alert("Debes iniciar sesión antes de publicar un aviso");
				ret = false;
			}

			// Validacion de campos
			if($('#precio').val() == '') { alert("Debes seleccionar un precio"); ret = false; }
			if($('#titulo').val() == '') { alert("Debes ingresar un titulo a tu aviso"); ret = false; }
			if($('#categorias').val() == '') { alert("Debes seleccionar una categoría"); ret = false; }
			if($('#subcategorias').val() == '') { alert("Debes seleccionar una sub categoría"); ret = false; }
			if($('#descripcion').val() == '') { alert("Debes ingresar una descripción a tu aviso"); ret = false; }
			if($('#cobertura').val() == null) { alert("Debes seleccionar al menos una localidad"); ret = false; }
			if($('.image-thumb img').length == 0) { alert("Debes ingresar al menos una imagen a tu aviso"); ret = false; }
			if(!$('#acepto').is(':checked')) { alert("Debes aceptar los términos y condiciones de uso"); ret = false; }

			return ret;
        	
        }



        $('#sreg').bind('click', showregistro);
        $('#slogin').bind('click', showlogin);
        $('#soyempresa').bind('click', toggleempresa);
        $('.lu').bind('click', loginuser);
        $('.cc').bind('click', createuser);
        $('#categorias').bind('change', changecategory);
        if($('#subir').length > 0) $('#subir').bind('click', processaviso);
        if($('#actualizar').length > 0) $('#actualizar').bind('click', editaraviso);

	}

	$.fn.publish.options = {}	

})(jQuery);


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
