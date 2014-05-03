// JavaScript Document
$(document).ready(function(){
	$('#wizard').smartWizard();
	
	$("#cantidad_solicitada").validacion({
		numMin: 0,
		ent: true
	});
	$("#justificacion").validacion({
		lonMin: 10
	});
	$("#tipo_requisicion").validacion({
		men: "Debe seleccionar un item"
	});
	$("#servicio_de").validacion({
		men: "Debe seleccionar un item"
	});
});