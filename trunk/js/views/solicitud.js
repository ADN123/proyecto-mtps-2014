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
});
