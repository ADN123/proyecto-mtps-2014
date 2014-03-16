// JavaScript Document
$(document).ready(function(){
	$('#wizard').smartWizard();
	
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
					if(data['funcional']==null)
						data['funcional']="(No se encuentro este registro)";
					if(data['nivel_1']==null)
						data['nivel_1']="(No se encuentro este registro)";
					if(data['nivel_2']==null)
						data['nivel_2']="(No se encuentro este registro)";
					if(data['nivel_3']==null)
						data['nivel_3']="(No se encuentro este registro)";
					var html=	"<br>"+
								"<p><label>NR</label> <strong>"+data['nr']+"</strong></p>"+
								"<p><label>Cargo</label> <strong>"+data['funcional']+"</strong></p>"+
								"<p><label>Departamento</label> <strong>"+data['nivel_2']+"</strong></p>"+
								"<p><label>Secci&oacute;n</label> <strong>"+data['nivel_1']+"</strong></p>";

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
