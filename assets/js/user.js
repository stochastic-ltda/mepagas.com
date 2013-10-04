(function($){

	$.fn.user = function(options) {

		// Variables
		var defaults = {} // default variables

		$.fn.user.options = $.extend(defaults, options);
        var options = $.fn.user.options;

		// Functions
		var deletefav = function() {
			var id= $(this).attr('data-id');
			if(confirm('¿Seguro que deseas eliminar este favorito?')) {
				$.post('/includes/phpscripts/user_delete_favorite.php', {id:id}, function(data){
					$('#fav'+id).fadeOut();
				});
			}
			return false;
		}

		var activaraviso = function() {
			var id = $(this).attr('data-id');
			$.post('/includes/phpscripts/aviso_activar.php', {id:id}, function(data){
				if(data == "true") $('.activar-aviso[data-id='+id+']').html("En espera");						
			});

			return false;
		}

		var desactivaraviso = function() {

			if(confirm("¿Estas seguro que desear dar de baja este aviso?")) {
				var id = $(this).attr('data-id');
				$.post('/includes/phpscripts/aviso_desactivar.php', {id:id}, function(data){
					if(data == "true") $('.desactivar-aviso[data-id='+id+']').html("En espera");						
				});
			}

			return false;
		}

		var userisuser = function(id,avatar) {
			$.post('/includes/phpscripts/user_is_user.php', {code: getCookie('mutm_gif'), userid: id}, function(response){
				if(response != 'false')
					setCookie('avatar', avatar, 7);
			});
		}

		// Mensajes
		var showrecibidos = function() {
			$('#msj-enviados').hide();
			$('#btn-env').removeClass('active');

			$('#msj-recibidos').fadeIn();
			$('#btn-rec').addClass("active");
		}

		var showenviados = function() {
			$('#msj-recibidos').hide();
			$('#btn-rec').removeClass('active');

			$('#msj-enviados').fadeIn();
			$('#btn-env').addClass('active');			
		}

		var togglemsj = function () {
			var id = $(this).attr('id').replace("msj","");
			$('#cuerpo'+id).toggle();
			
			if($('#msj'+id).hasClass('no-leido')) {
				$('#msj'+id).removeClass('no-leido');
				$.post('/includes/phpscripts/user_mensaje_leer.php', {id:id});
			}
		}

		var eliminarmsj = function () {
			event.preventDefault();
			var id = $(this).attr('data-id');
			if(confirm("¿Estas seguro que deseas eliminar este mensaje?")) {
				$.post('/includes/phpscripts/user_mensaje_eliminar.php', {id:id}, function() {
					$('#msj'+id).hide();
					$('#cuerpo'+id).hide();
				})
			}
		}

		var respondermsj = function() {

			event.preventDefault();
			var id = $(this).attr('data-id');
			var request = $.ajax({
				type: "POST",
				url: '/includes/phpscripts/user_mensaje_get.php', 
				data: {id:id},
				dataType: "json",
				success: function(msj) {

					var toname = $('#ndesde'+id).html();
					$('#msjde').html($('#msjde').html().replace("{{msjde}}","<b>"+getCookie('nombre')+"</b>"));
					$('#msjpara').html($('#msjpara').html().replace('{{msjpara}}', "<b>"+toname+"</b>"));
					$('#msjmodal #from').val(msj.to);
					$('#msjmodal #to').val(msj.from);
					$('#msjmodal #aviso').val(msj.avisoid);
					$('#msjmodal').reveal();
					$('#msjbody').focus();

					
				}
			});
			
		}

		// Main
		$('#divlogo').addClass('logo_mepagas_despliegue').removeClass('logo');
		$('.activar-aviso').bind('click', activaraviso);
		$('.desactivar-aviso').bind('click', desactivaraviso);
		$('#btn-rec').bind('click', showrecibidos);
		$('#btn-env').bind('click', showenviados);
		$('.msj-row').bind('click', togglemsj);		

		userisuser(options.userid, options.avatar);

		// Flag is same user or visit
		isUser = true;
		if( typeof getCookie('mutm_gif') == 'undefined' || getCookie('mutm_gif') == '' ) isUser = false;
		else {
			$.post('/includes/phpscripts/user_is_user.php', {code: getCookie('mutm_gif'), userid: options.userid}, function(response){
				
				if(response == 'false')
					isUser = false;

				if(isUser) {
					$('.delfavorito').bind('click', deletefav);
					$('.msj-delete').bind('click', eliminarmsj);
					$('.btn-responder a').bind('click', respondermsj);
					setTimeout( function() { $('.user-opt').show(); }, 100);
				} else {
					$('.user-opt').html("");
					$('.user-opt').hide();
				}
				
			});
		}

	}

	$.fn.user.options = {};

})(jQuery);