// JavaScript Document
$(document).ready(function() {
	var tiempo = new Date();
	newfec=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate(), tiempo.getHours(), tiempo.getMinutes());
	
	$('#wizard').smartWizard();
	
	$("#id_gasolinera").validacion({
		men: "Debe seleccionar un item"        
	});
	
	var fec_soli=$("#fecha_factura").kendoDatePicker({
		culture: "es-SV",
		format: "dd/MM/yyyy",
		max: newfec
	}).data("kendoDatePicker");

	$("#fecha_factura").validacion({
		valFecha: true
	});
	$("#numero_factura").validacion({
		numMin:1,
		ent: true
	});
	$("#valor_super").validacion({
		valPrecio: true
	});
	$("#valor_regular").validacion({
		valPrecio: true
	});
	$("#valor_diesel").validacion({
		valPrecio: true
	});
});