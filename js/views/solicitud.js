// JavaScript Document
$(document).ready(function(){
	$('#wizard').smartWizard();
	
	var tiempo = new Date();
	
	function startChange() {
		var startTime = start.value();
		var hor_rea = new Date(startTime);
		fec_min=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate(), tiempo.getHours()+24, tiempo.getMinutes());
		var fec = fec_soli.value();
		fec = new Date(fec);
		fec_rea=new Date(fec.getFullYear(), fec.getMonth(), fec.getDate(), hor_rea.getHours(), hor_rea.getMinutes());
		
		if(fec_min>fec_rea){
			$('#resultado_fecha').html("Esta solicitud queda sujeta a disponibilidad de transporte");
		}
		else {
			$('#resultado_fecha').html("");
		}
		startTime = start.value();
		if (startTime!="" &&  this.options.interval) {
			startTime = new Date(startTime);
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

	newfec=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate(), tiempo.getHours(), tiempo.getMinutes());
	
	var fec_soli=$("#fecha_mision").kendoDatePicker({
		culture: "es-SV",
		format: "dd/MM/yyyy",
		min: newfec,
		change: startChange
	}).data("kendoDatePicker");
	
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
	$("#observaciones").validacion({
		req: false,
		lonMin: 10
	});
	$("#acompanantes2").validacion({
		req: false,
		lonMin: 10
	});	
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
	
	$('#agregar').click(function(){
		var municipio=$('#municipio').val();
		var lugar_destino=$('#lugar_destino').val();
		var municipio_text=$('[name="municipio_input"]').val();
		if(municipio_text!="" && lugar_destino!="") {
			var construct=$('#content_table').html();
			var action=	'<a onClick="borrar_item(this)"><img src="'+base_url()+'img/ico_basura.png" width="25" height="25" align="absmiddle" title="Borrar item"/></a>';
			var input='<input type="hidden" name="values[]" value="'+ municipio +'**'+ lugar_destino +'"/>';
			construct+='<tr><td>'+ municipio_text +'</td><td>'+ lugar_destino +'</td><td align="center">'+ action +'</td>'+ input +'</tr>';
			$('#content_table').html(construct);
			$('#lugar_destino').val("");;
		}
		else {
			alert("Los campos 'Municipio' y 'Lugar de destino' no pueden estar vacios");
		}
	});
});

function borrar_item(row){
	$(row).parent().parent().remove();
}
