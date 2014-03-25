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
	var tiempo = new Date();
	if(permiso!=3) {
		var hora=Number(tiempo.getHours());
		var tipo="AM";
		if(Number(tiempo.getHours())<=5 || Number(tiempo.getHours())>=18)
			hora=5;
		else 
			if(Number(tiempo.getHours())>12) {
				hora=Number(tiempo.getHours())-12;
				tipo="PM";
			}
	}
	start.min("5:00 AM");
	start.max("5:30 PM");
	end.min("5:30 AM");
	end.max("6:00 PM");
	
	function verificar_hora() {
		if((tiempo.getDate()+1)<10)
			d="0"+(tiempo.getDate()+1);
		else
			d=(tiempo.getDate()+1);
		if((tiempo.getMonth()+1)<10)
			m="0"+(tiempo.getMonth()+1);
		else
			m=(tiempo.getMonth()+1);
		var fec=d+"/"+m+"/"+tiempo.getFullYear();
		if($("#fecha_mision").val()==fec) {
			start.min(hora+":00 "+tipo);
			end.min(hora+":30 "+tipo);
		}
		else {
			start.min("5:00 AM");
			end.min("5:30 AM");
		}
	}
	if(Number(tiempo.getHours())>=18)
		newfec=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate()+2);
	else
		newfec=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate()+1);
	
	if(permiso==3) 
		newfec=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate());
	
	$("#fecha_mision").kendoDatePicker({
		culture: "es-SV",
		format: "dd/MM/yyyy",
		min: newfec,
		change: verificar_hora
	});
	
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
	/*$("#municipio").validacion({
		men: "Debe seleccionar un item"
	});
	$("#lugar_destino").validacion();*/
	
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
