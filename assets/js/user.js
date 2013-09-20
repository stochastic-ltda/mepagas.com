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

		// Main
		$('.activar-aviso').bind('click', activaraviso);
		$('.desactivar-aviso').bind('click', desactivaraviso);

		// Flag is same user or visit
		isUser = true;
		if( typeof getCookie('mutm_gif') == 'undefined' || getCookie('mutm_gif') == '' ) isUser = false;
		else {
			$.post('/includes/phpscripts/user_is_user.php', {code: getCookie('mutm_gif'), userid: options.userid}, function(response){
				
				if(response == 'false')
					isUser = false;

				if(isUser) {
					$('.delfavorito').bind('click', deletefav);
					setTimeout( function() { $('.user-opt').fadeIn(); }, 1000);
				} else {
					$('.user-opt').html("");
					$('.user-opt').hide();
				}
				
			});
		}

	}

	$.fn.user.options = {};

})(jQuery);