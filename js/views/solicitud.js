// JavaScript Document
$(document).ready(function(){
	$('#wizard').smartWizard();
	$("#fecha_mision").validacion({
		valFecha: true
	});
	$("#nombre").validacion({
		men: "Debe seleccionar un item"
	});
	$("#mision_encomendada").validacion({
		valNombre: true
	});
	$("#hora_salida").validacion();
	$("#hora_regreso").validacion();
	$("#municipio").validacion({
		men: "Debe seleccionar un item"
	});
	$("#lugar_destino").validacion();
	
	$("#nombre").change(function(){
		var id=$(this).val();
		$.ajax({
			type:  "post",  
			async:	true, 
			url:	base_url()+"index.php/transporte/buscar_info_adicional",
			data:   {
					id_empleado: id
				},
			dataType: "json",
			success: function(data) { 
				if(data['estado']==1) {
					var html="Hola!";
					$("#info_adicional").html(html);
				}
				else {	
					alert('Error al intentar buscar empleado: No se encuentra el registro');
				}
			},
			error:function(data) { 
				alert('Error al intentar buscar empleado: No se pudo conectar al servidor');
			}
		});
	});
});
