// JavaScript Document
$(document).ready(function(){
	$('#wizard').smartWizard();
	
	var tiempo = new Date();
	newfec=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate(), tiempo.getHours(), tiempo.getMinutes());
	
	function startChange() {
		var startTime = start.value();
		
		var hor_rea = new Date(startTime);
		fec_min=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate(), tiempo.getHours()+24, tiempo.getMinutes());
		var fec = fec_soli.value();
		fec = new Date(fec);
		fec_rea=new Date(fec.getFullYear(), fec.getMonth(), fec.getDate(), hor_rea.getHours(), hor_rea.getMinutes());
		
		if(permiso!=3)
			if(fec_min>fec_rea){
				$('#resultado_fecha').html("Esta solicitud queda sujeta a disponibilidad de transporte");
			}
			else {
				$('#resultado_fecha').html("");
			}
		if(newfec>=fec_rea) {
				start.min(newfec);
		}
		else {
			start.min("5:00 AM");
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
	start.min(newfec);
	start.max("5:30 PM");
	end.min("5:30 AM");
	end.max("6:00 PM");

	
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
	$("#hora_salida").validacion();
	$("#hora_regreso").validacion();
	$("#observaciones").validacion({
		req: false,
		lonMin: 10
	});
	$("#mision_encomendada").validacion({
		lonMin: 5
	});
	$("#lugar_destino").validacion({
		lonMin: 5
	});
	$("#municipio").validacion({
		men: "Debe seleccionar un item"
	});
	$("#direccion_empresa").validacion({
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
						data['funcional']="(No se encuentró este registro)";
					if(data['nivel_1']==null)
						data['nivel_1']="(No se encuentró este registro)";
					if(data['nivel_2']==null)
						data['nivel_2']="(No se encuentró este registro)";
					if(data['nivel_3']==null)
						data['nivel_3']="(No se encuentró este registro)";
					var html=	"<br>"+
								"<p><label>NR</label> <strong>"+data['nr']+"</strong></p>"+
								"<p><label>Cargo</label> <strong>"+data['funcional']+"</strong></p>"+
								"<p><label>Departamento</label> <strong>"+data['nivel_2']+"</strong></p>"+
								"<p><label>Secci&oacute;n</label> <strong>"+data['nivel_1']+"</strong></p>";

					$("#info_adicional").html(html);
				}
				else {	
					alertify.alert('Error al intentar buscar empleado: No se encuentra el registro');
					$("#info_adicional").html("");
				}
			},
			error:function(data) { 
				alertify.alert('Error al intentar buscar empleado: No se pudo conectar al servidor');
				$("#info_adicional").html("");
			}
		});
	});
	
	$('#agregar').click(function(){
		var municipio=$('#municipio').val();
		var mision_encomendada=$('#mision_encomendada').val();
		var direccion_empresa=$('#direccion_empresa').val();
		var lugar_destino=$('#lugar_destino').val();
		var municipio_text=$('[name="municipio_input"]').val();
		if(municipio_text!="" && lugar_destino!="" && mision_encomendada!="") {
			var construct=$('#content_table').html();
			var action=	'<a onClick="borrar_item(this)"><img src="'+base_url()+'img/ico_basura.png" width="25" height="25" align="absmiddle" title="Borrar item"/></a>';
			var input='<input type="hidden" name="values[]" value="'+ municipio +'**'+ lugar_destino +'**'+ direccion_empresa +'**'+ mision_encomendada +'"/>';
			construct+='<tr><td>'+ municipio_text +'</td><td>'+ lugar_destino +'</td><td>'+ direccion_empresa +'</td><td>'+ mision_encomendada +'</td><td align="center">'+ action +'</td>'+ input +'</tr>';
			$('#content_table').html(construct);
			$('#lugar_destino').val("");
			$('#direccion_empresa').val("");
			$('#mision_encomendada').val("");
			$(".modal_close").click();
		}
	});
});

function borrar_item(row){
	$(row).parent().parent().remove();
}
