/*
 *  Inicializacion de funciones base
 *  Creada por Leonel Peña
 *  leoneladonispm@hotmail.com
 *  Febrero 27 de 2014
 */
 var multi;
$(document).ready(function() {
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
		min: new Date(f.getFullYear(), f.getMonth(), f.getDate()+2)
	});
	$(".hora").kendoTimePicker();
	function startChange() {
		var startTime = start.value();
		if (startTime) {
			startTime = new Date(startTime);
			end.max(startTime);
			startTime.setMinutes(startTime.getMinutes() + this.options.interval);
			end.min(startTime);
			end.value(startTime);
		}
	}
	var start = $(".inicio").kendoTimePicker({
		change: startChange
	}).data("kendoTimePicker");
	var end = $(".fin").kendoTimePicker().data("kendoTimePicker");
	start.min("5:00 AM");
	start.max("5:30 PM");
	end.min("5:30 AM");
	end.max("6:00 PM");
});