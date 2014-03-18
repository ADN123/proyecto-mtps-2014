// JavaScript Document
$(document).ready(function(){

function dialogo(id){

		$.ajax({
		async:	true, 
		url:	"<?=base_url()?>/index.php/transporte/datos_de_solicitudes/"+id,
		dataType:"json",
		success: function(data){
			 document.getElementById('ids').value=id;

 	var echo1="Nombre: <strong>"+data[0].nombre+"</strong> <br>" +
		       "Sección: <strong>"+data[0].seccion+"</strong> <br>";
			   
	var echo2="Misión: <strong>"+data[0].mision+"</strong> <br>"+
		       "Fecha de Solicitud: <strong>"+data[0].fechaS+"</strong> <br>"+
   		       "Fecha de Misión: <strong>"+data[0].fechaM+"</strong> <br>"+
		       "Hora de Salida: <strong>"+data[0].salida+"</strong> <br>"+
		       "Hora de Regreso: <strong>"+data[0].entrada+"</strong> <br>"+
			   "Municipio: <strong>"+data[0].municipio+"</strong> <br>"+
			   "Lugar: <strong>"+data[0].lugar+"</strong> <br>";
			
			document.getElementById('empleado').innerHTML=echo1;
			document.getElementById('mision').innerHTML=echo2;
						
			},
		error:function(data){
			 alert('Error al cargar datos');
			console.log(data);
			}
		});	
	}
	
	function Enviar(v){
		document.getElementById('resp').value=v;
	}
	
	$("#observacion").validacion({
			req: false,
			lonMin: 10
		});
});