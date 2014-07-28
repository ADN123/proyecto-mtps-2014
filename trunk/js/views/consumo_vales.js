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
	$("#id_gasolinera").change(function(){
		var id_gasolinera = $(this).val();
		var fecha_factura = $("#fecha_factura").val();
		
		if(id_gasolinera!="" && fecha_factura!="" )
			$('#divVehiculos').load(base_url()+"index.php/vales/vehiculos_consumo/"+id_gasolinera+"/"+fecha_factura);
		else
			$('#divVehiculos').html("<br/><br/><br/>Debe seleccionar una <strong>gasolinera</strong> e ingresar la <strong>fecha de la factura</strong>...");	
	});
	$("#total").validacion({
		valPrecio: true
	});
	$("#fecha_factura").blur(function(){
		$("#id_gasolinera").change();
	});
/*	$("#id_seccion").change(function(){
		$("#id_gasolinera").change();
	});*/
});