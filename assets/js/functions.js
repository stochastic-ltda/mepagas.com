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
	var categoria = $('#categorias').val();
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
			imagenes[j] = src.replace("/upload/thumb_","");
			j++;
		}
	});

	var acepto = $('#acepto').is(":checked");	

	// TODO: Validacion de campos

	// Procesamiento de datos
	$.post('/includes/phpscripts/publish_aviso.php', {tipo:tipo, precio:precio, titulo:titulo, categoria:categoria, descripcion:descripcion, localidades:localidades, imagenes:imagenes, acepto:acepto}, function(data) {
		
		// TODO: Procesar posibles errores de carga en el aviso
		alert("Su aviso ha sido publicado");
		document.location="/";
	});


}