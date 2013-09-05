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

function processAviso() {

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

	// Procesamiento de datos
	$.post('/includes/phpscripts/publish_aviso.php', {id_usuario:id_usuario, tipo:tipo, precio:precio, titulo:titulo, categoria:categoria, subcategoria:subcategoria, descripcion:descripcion, localidades:localidades, imagenes:imagenes, acepto:acepto}, function(data) {
		
		// TODO: Procesar posibles errores de carga en el aviso
		alert("Su aviso ha sido publicado");
		document.location="/";
	});


}


// ------------------------------------------------------------------------------------------------------------------
// Login
// ------------------------------------------------------------------------------------------------------------------

function checkli() {

	var email = getCookie('email');
	var avatar = getCookie('avatar');
	var userid = getCookie('userid');
	var username = getCookie('username');

	if(email != '' && typeof email != "undefined") {
		var html = '<img src="'+avatar+'"><p>Hola <b>'+username+'</b>!<br><a href="/usuario/'+userid+'">mi cuenta</a><br><a href="#" id="logout" onclick="userlo()">[salir]</a></p>';
		$('.login-info').html(html);
	}
}

function userlo() {
	setCookie('email','');
	setCookie('avatar','');
	setCookie('userid','');
	setCookie('username','');
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
					setCookie('email', data.email);
					setCookie('username', data.username);
					setCookie('userid', data.userid);
					setCookie('avatar', data.avatar);

					location.reload();

				}
			}
		});

	}

	return false;
}

function userlif() {
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

					location.reload();

				}

			}
		});
	});	
}