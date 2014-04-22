/*
 *  Inicializacion de funciones base
 *  Creada por Leonel Peña
 *  leoneladonispm@hotmail.com
 *  Febrero 27 de 2014
 */
 var multi;
 var estado_transaccion="";
 var estado_correcto="La transacción fue ejecutada exitosamente";
 var estado_incorrecto="Error en la transacción: No se pudo conectar al servidor";
$(document).ready(function() {
	if(estado_transaccion!="") {
		if(Number(estado_transaccion)==1) {
			//alertify.alert(estado_correcto);
			alertify.success(estado_correcto);
		}
		else {
			if(Number(estado_transaccion)==0) {
				//alertify.alert(estado_incorrecto); 
				alertify.error(estado_incorrecto);
			}
		}
	}
	var f = new Date();
	$("select").prepend('<option value="" selected="selected"></option>');
	$(".select").kendoComboBox({
		autoBind: false,
		filter: "contains"
	});
	multi= $(".multi").kendoMultiSelect({
		filter: "contains"	
	}).data("kendoMultiSelect");
	
	$(".nac").kendoDatePicker({
		culture: "es-SV",
		format: "dd/MM/yyyy",
		max: new Date(f.getFullYear()-15, f.getMonth(), f.getDate())
	});
	$(".fec").kendoDatePicker({
		culture: "es-SV",
		format: "dd/MM/yyyy"
	});
	$(".fec_hoy").kendoDatePicker({
		culture: "es-SV",
		format: "dd/MM/yyyy",
		min: new Date(f.getFullYear(), f.getMonth(), f.getDate()+1),
	});
	$(".hora").kendoTimePicker();
	$(".grid").kendoGrid({
		height: 450,
		width: 800,
		sortable: true,
		dataSource: {
			type: "odata",
			pageSize: 9
		},
		pageable: true
	});
});
$(function() {
	$('a[rel*=leanModal]').leanModal({ top : 50, closeButton: ".modal_close"});		
});
	String.prototype.capitalize = function()
	{
		return this.replace(/\w+/g, function(a)
		{
			return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase();
		});
	};