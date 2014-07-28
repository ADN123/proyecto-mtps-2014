/*
 *  Inicializacion de funciones base
 *  Creada por Leonel Peña
 *  leoneladonispm@hotmail.com
 *  Febrero 27 de 2014
 */
 var multi;
 var estado_transaccion="";
 var estado_correcto="La transacci&oacute;n fue ejecutada exitosamente";
 var estado_incorrecto="Error en la transacci&oacute;n: No se pudo conectar al servidor";
 var id='';
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
	if(id!=''){
		var dropdownlist = $("#nombre").data("kendoComboBox");
		id=Number(id);
		dropdownlist.value(id);
	}
		
	$(".multi").kendoMultiSelect({
		filter: "contains"	
	});
	

	//ya estaba comentado
	/*var multiSelect = $("#acompanantes2").data("kendoMultiSelect");
	
	setValue = function(e) {
		if (e.type != "keypress" || kendo.keys.ENTER == e.keyCode) {
			multiSelect.dataSource.filter({}); //clear applied filter before setting value
			var x="1,2,4";
			multiSelect.value(x.split(","));
		}
	};*/
	
	//esto no
	

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


$('.grid').dataTable( {
        "language": {
            "url": base_url()+"js/de_ES.txt"
        }
    } );

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
function recargar_javascript(arg) {
	$('a[rel*=leanModal]').leanModal({ top : 50, closeButton: ".modal_close"});
}