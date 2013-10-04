// ------------------------------------------------------------------------------------------------------------------
// Funciones generales 
// ------------------------------------------------------------------------------------------------------------------

function setCookie(c_name,value,exdays) {
        var exdate=new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
        document.cookie=c_name + "=" + c_value + "; path=/";
}

function getCookie(c_name) {
        var i,x,y,ARRcookies=document.cookie.split(";");
        for (i=0;i<ARRcookies.length;i++) {
                x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
                y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
                x=x.replace(/^\s+|\s+$/g,"");
                if (x==c_name) {
                        return unescape(y);
                }
        }
}


// ------------------------------------------------------------------------------------------------------------------
// Publica tu pituto
// ------------------------------------------------------------------------------------------------------------------

function imgselected() {

	$('.imagenes-zone').append( $('#load-image-template').html() );

	var imagenes = document.getElementById('imagenes');
	var imagen = imagenes.files;
	var data = new FormData();

	for(var i=0; i<imagen.length; i++) {
		data.append('imagen'+i, imagen[i]);
	}

	$.ajax({
		url:'/includes/phpscripts/publish_imgupload.php',
		type:'POST', 
		contentType:false,
		data:data,
		processData:false, 
		cache:false 
	}).done(function(img){
		$('.imagenes-zone #load-image').remove();
		$('.imagenes-zone').append(img);
		$('#imagenes').val("");
	});

}

// TODO: restringir llamada de este metodo de manera segura
function imgdelete(img, id) {

	if(confirmDelete()) {
		$.post('/includes/phpscripts/publish_imgdelete.php', {img: img}, function() {
			$('#'+id).remove();
		});		
	}
}

function confirmDelete() {
	if(confirm("Estas seguro que deseas eliminar la imagen seleccionada?")) return true;
	return false;
}


// ------------------------------------------------------------------------------------------------------------------
// Login
// ------------------------------------------------------------------------------------------------------------------

/**
 * User register
 * Registro de usuario desde el modal
 */
function userregister(form) {

	$(form).append('<img src="/assets/img/loading.gif" class="loading">');

	event.preventDefault();	
	$('#reg-errorlist').html("");

	var nombre = form.nombre.value;
	var email = form.email.value;
	var password = form.password.value;
	var terms = form.terms.checked;

	var request = $.ajax({
		type: "POST",
		url: '/includes/phpscripts/user_create.php', 
		data: { 
			nombre:nombre, 
			email:email, 
			password:password, 
			terms: terms
		},
		dataType: "json", 
		success: function(data) {

			$('.loading').remove();

			if(typeof data.userid != "undefined") {

				// inicio sesion
				getloginstr(data.userid, 1);
				setCookie('email', email, 1);
				setCookie('nombre', nombre, 1);
				setCookie('userid', data.userid, 1);
				setCookie('avatar', '', 1);				

				changeloginfo(nombre, data.userid,"");
				if($('#usuario-login').length>0) changepubloginfo(data.nombre, email, data.avatar);
				$('.close-reveal-modal').click();
				if(typeof(checkul)=="function") checkul();

			} else {
				// error en validacion 
				// muestro problemas de validacion
				for(var i=0; i<data.length; i++)
					$('#reg-errorlist').append('<li>'+data[i]+'</li>');
			}
		}
	});

}

/**
 * Change Login Info
 * Cambia la informacion del usuario en la posicion superior derecha
 */
function changeloginfo(nombre, id, avatar) {

	if(avatar == "") avatar = "/upload/avatar/default.png";
	var html = 	'<img src="'+avatar+'" id="usr-ava">' +
				'<p>Hola <b>'+nombre.split(" ")[0]+'</b>!</p><br>' +
				'<p class="small-row"><a href="/usuario/'+id+'" id="usr-acc">Mi cuenta</a></p><br> '+
				'<p class="small-row"><a href="/usuario/'+id+'?s=msj" id="usr-msj">Mensajes</a></p>';
	$('.login-info').html(html);

	$.post('/includes/phpscripts/user_mensaje_checknew.php', {id:id}, function(data) {
		if(data == 0) {
			$('#usr-msj #new').remove();
		} else {
			$('#usr-msj').append('<span id="new">'+data+'</span>');
		}
	})
}

/**
 * Change Publish Login Info
 * Cambia la informacion del usuario en el formulario de publicacion de pituto
 */
function changepubloginfo(nombre, email, avatar) {

	if(avatar == "") avatar = "/upload/avatar/default.png";
	var html = 	'<img src="'+avatar+'" id="usr-ava">' +
				'<p><b>'+nombre+'</b></p><br>' +
				'<p>Email: '+ email +'</p>';
				
	$('#usuario-login').html(html);
}

/**
 * Check Login
 * Revisa si se ha iniciado sesion y carga la informacion de usuario
 */
function checkli() {

	var email = getCookie('email');
	var avatar = getCookie('avatar');
	var userid = getCookie('userid');
	var nombre = getCookie('nombre');

	if(email != '' && typeof email != "undefined") {
		changeloginfo(nombre, userid, avatar);
	}
}

/**
 * User Login
 * Inicio de sesion de usuario
 */
function userlogin(form) {

	$(form).append('<img src="/assets/img/loading.gif" class="loading">');

	event.preventDefault();	
	$('#log-errorlist').html("");

	var email = form.email.value;
	var pass = form.password.value;
	var failed = false;

	if(email=='' || pass=='') failed = true;

	if(failed) {
		$('#log-errorlist').append('<li>Email o password incorrecto</li>');
		$('.loading').remove();
	} else {

		var request = $.ajax({
			type: "POST",
			url: '/includes/phpscripts/user_login.php', 
			data: {email:email, pass:pass},
			dataType: "json",
			success: function(data) {

				$('.loading').remove();

				if(data.length == 0) {
					$('#log-errorlist').append('<li>Email o password incorrecto</li>');
				} else {

					// inicio sesion
					getloginstr(data.userid, 7);
					setCookie('email', email, 7);
					setCookie('nombre', data.nombre, 7);
					setCookie('userid', data.userid, 7);
					setCookie('avatar', data.avatar, 7);

					changeloginfo(data.nombre, data.userid, data.avatar);
					if($('#usuario-login').length>0) changepubloginfo(data.nombre, email, data.avatar);
					$('.close-reveal-modal').click();	
					if(typeof(checkul)=="function") checkul();

				}
			}
		});

	}
}

/**
 * Get Login String
 * Retorna string identificador de usuario
 */
function getloginstr(id, days) {
	$.post('/includes/phpscripts/user_login_str.php', {id:id}, function(str){
		setCookie('mutm_gif', str, days);
	});				
}

/**
 * User logout
 * Elimina cookies de usuario
 */
function userlogout() {
	setCookie('email','',-1);
	setCookie('avatar','',-1);
	setCookie('userid','',-1);
	setCookie('nombre','',-1);
	setCookie('mutm_gif','',-1);

	var html = 	'<a class="btn btn-register" href="#" data-reveal-id="regmodal">Registrar</a>'+
				'<a class="btn btn-login" href="#" data-reveal-id="logmodal">Login</a>';

	location.reload();
}

/**
 * User Recover
 * Recupera contraseña de usuario
 */
function userrecover(form) {

	event.preventDefault();
	$('#rec-errorlist').html("");
	$("#rec-donelist").html('<img src="/assets/img/loading.gif" class="loading">');

	var email = form.email.value;
	if(email=='' || typeof email == "undefined") {
		$('#rec-errorlist').append("<i>Ingresa un email válido</li>");
		$('#rec-donelist .loading').remove();
	} else {
		$.post('/includes/phpscripts/user_recover.php', {email:email}, function(response){
			console.log(response);
			if(response == '0') $('#rec-errorlist').append("<i>Ha ocurrido un problema al momento de enviar el correo</li>");
			else if(response == '1') $('#rec-errorlist').append("<i>Ingresa un email válido</li>");
			else if(response == '2') $('#rec-errorlist').append("<i>Su cuenta se encuentra inactiva, puedes activarla <a href='/usuario/enviar-activacion/?email="+email+"'>aquí</a></li>");
			else if(response == '3') $('#rec-errorlist').append("<i>Email no registrado</li>");
			else $('#rec-donelist').html("<i>Correo enviado!</i>");
			$('#rec-donelist .loading').remove();
		})
	}

}

// ---
// FIN Login
// ---

/**
 * Send Message
 * Envio de mensaje entre usuarios
 */
function sendmsj(form) {

	$(form).append('<img src="/assets/img/loading.gif" class="loading">');

	event.preventDefault();	
	$('#msj-errorlist').html("");

	var from = form.from.value;
	var to = form.to.value;
	var body = form.msjbody.value;
	var id_aviso = form.aviso.value;

	var request = $.ajax({
		type: "POST",
		url: '/includes/phpscripts/ficha_sendmessage.php', 
		data: { 
			from: from, 
			to: to, 
			body: body,
			id_aviso: id_aviso
		},
		dataType: "json", 
		success: function(data) {

			$('.loading').remove();

			if(data == true) {				
				done = "<b>¡Mensaje enviado!</b><br>Puedes revisar tus mensajes <a href='/usuario/"+getCookie('userid')+"?s=msj'>AQUI</a>";
				$('#msj-donelist').html(done);				
				$('#msjbody').val("");

			} else {
				// error en validacion 
				// muestro problemas de validacion
				for(var i=0; i<data.length; i++)
					$('#msj-errorlist').append('<li>'+data[i]+'</li>');
			}
		}
	});

}


function userlo() {
	setCookie('email','');
	setCookie('avatar','');
	setCookie('userid','');
	setCookie('nombre','');
	setCookie('mutm_gif','');
	document.location="/";
}

function userli() {

	var email = $('#li-email').val();
	var pass = $('#li-pass').val();
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
					setCookie('email', data.email, 7);
					setCookie('nombre', data.nombre, 7);
					setCookie('userid', data.userid, 7);
					setCookie('avatar', data.avatar, 7);

					$.post('/includes/phpscripts/user_login_str.php', {id:data.userid}, function(str){
						setCookie('mutm_gif', str, 7);
						location.reload();
					});				

				}
			}
		});

	}

	return false;
}