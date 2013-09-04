$(document).ready(function(){

	setTimeout(function(){
		var count = $('#gallery img').length;
		
		if(count > 0) {
			for(var i=0; i < count; i++) {

				var img = $('#img-'+i);
				if(img.height() > img.width()) {

					img.height('100%');
					img.width('auto');
					img.css('left', '50%');
					img.css('margin-left', img.width()/-2);

				} else {

					img.css('top', '50%');
					img.css('margin-top', img.height()/-2);

				}
				
			}
		}

	}, 100);

	checkli();

	$.post('/includes/phpscripts/ficha_userdata.php', {id: userid, url: document.URL, titulo: $('.h1-ficha').html()}, function(userinfo) {
		$('.contenido_usuario_despl').html(userinfo);
	});

	$(window).on('scroll', function() {
		if($(window).scrollTop() > 200) {
			$('.contenido_centro_despl_full_usuario').addClass('info-fixed');
		} else {
			$('.contenido_centro_despl_full_usuario').removeClass('info-fixed');
		}
	});

});


$('.cont_galeria_nav_sig').click(function() {

	var actual = $('#gallery').attr('data-selected');
	var count = $('#gallery img').length;

	var next = parseInt(actual) + 1;
	if(next >= count) next = 0;

	$('#gallery').attr('data-selected', next);
	$('#gallery img').hide();
	$('#img-'+next).fadeIn();

	return false;

});

$('.cont_galeria_nav_ant').click(function() {

	var actual = $('#gallery').attr('data-selected');
	var count = $('#gallery img').length;

	var prev = parseInt(actual) - 1;
	if(prev < 0) prev = count-1;

	$('#gallery').attr('data-selected', prev);
	$('#gallery img').hide();
	$('#img-'+prev).fadeIn();

	return false;

});

$('#user-favorito').on('click', function() {

	var id_user = getCookie('userid');
	if(typeof id_user != "undefined" && id_user != '')
		$.post('/includes/phpscripts/ficha_userfavorite.php', {id_user:id_user, titulo: document.title, url: document.URL}, function() {
			alert("Aviso añadido a favoritos");			
		});
	else
		alert("Debes iniciar sesión para almacenar el aviso en favoritos");

	return false;


})

$('#user-denunciar').on('click', function() {

	var id_user = getCookie('userid');
	if(typeof id_user != "undefined" && id_user != '')
		$.post('/includes/phpscripts/ficha_userdenuncia.php', {id_user:id_user, url: document.URL}, function() {
			alert("Denuncia realizada. Lo revisaremos a la brevedad");			
		});
	else
		alert("Debes iniciar sesión para poder realizar una denuncia");

	return false;


})

function showInfo() {
	$('#btn-contactar').hide();
	$('#contacto_oculto').fadeIn();
}

function shareInfo(obj) {
    window.open(obj.href,'','width=500,height=300,location=no,menubar=no,status=no,titlebar=no,toolbar=no');
    return false;
}