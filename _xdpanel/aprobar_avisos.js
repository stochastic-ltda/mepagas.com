(function($){

	$.fn.avisos = function(options) {

		// Variables
		var defaults = {} // default variables
		var lastid = null;

		$.fn.avisos.options = $.extend(defaults, options);
        var options = $.fn.avisos.options;

        // Functions
        var avisosespera = function() {
        	$.post('/includes/phpscripts/aviso_espera.php', {fromid: lastid}, function(avisos) {
        		$('#list-avisos').append(avisos);
        	});
        }

        var aprobar = function() {
        	var id = $(this).attr('data-id');
        	$.post('/includes/phpscripts/aviso_activar.php', {id: id}, function(avisos) {
        		$('.aviso[aviso-id='+id+']').fadeOut();
        	});
        }

        var rechazar = function() {
        	var id = $(this).attr('data-id');
        	$.post('/includes/phpscripts/aviso_rechazar.php', {id: id}, function(avisos) {
        		$('.aviso[aviso-id='+id+']').fadeOut();
        	});
        }


        // Main
        avisosespera();
        setTimeout(function() {
	        $('.btn-aprobar').bind('click', aprobar);
	        $('.btn-rechazar').bind('click', rechazar);
	    }, 2000);



	}

	$.fn.avisos.options = {};

})(jQuery);