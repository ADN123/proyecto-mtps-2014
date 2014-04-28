// JavaScript Document
$(document).ready(function() {
	var tiempo = new Date();
	newfec=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate(), tiempo.getHours(), tiempo.getMinutes());
	
	$('#wizard').smartWizard();
	
	var fec_soli=$("#fecha_recibido").kendoDatePicker({
		culture: "es-SV",
		format: "dd/MM/yyyy",
		max: newfec
	}).data("kendoDatePicker");

	$("#fecha_recibido").validacion({
		valFecha: true
	});
	$("#cantidad").validacion({
		numMin:1,
		ent: true
	});
	$("#valor_nominal").validacion({
		valPrecio: true
	});
	$("#inicial").validacion({
		ent: true
	});
	$("#tipo_vehiculo").validacion({
		men: "Debe seleccionar un item"
	});
	$("#id_gasolinera").validacion({
		men: "Debe seleccionar un item"        
	});
	
	$("#cantidad,#inicial").blur(function(){
		if($("#cantidad").hasClass("correct") && $("#inicial").hasClass("correct")) {
			var final=Number($("#cantidad").val())+Number($("#inicial").val())-1;
			$("#final").html(final);
		}
	});
});