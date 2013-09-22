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

function checkli() {

	var email = getCookie('email');
	var avatar = getCookie('avatar');
	var userid = getCookie('userid');
	var username = getCookie('username');

	if(email != '' && typeof email != "undefined") {
		var html = '<img src="'+avatar+'"><p>Hola <b>'+username+'</b>!<br><a href="/usuario/'+userid+'">tu cuenta</a><br><a href="#" id="logout" onclick="userlo()">[salir]</a></p>';
		$('.login-info').html(html);
	}
}

function userlo() {
	setCookie('email','');
	setCookie('avatar','');
	setCookie('userid','');
	setCookie('username','');
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
					setCookie('username', data.username, 7);
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
					setCookie('email', userinfo.email,7);
					setCookie('username', userinfo.username,7);
					setCookie('userid', data.userid,7);
					setCookie('avatar', "http://graph.facebook.com/" + userinfo.id + "/picture",7);

					$.post('/includes/phpscripts/user_login_str.php', {id:data.userid}, function(str){
						setCookie('mutm_gif', str, 7);
						location.reload();
					});					

				}

			}
		});
	});	
}