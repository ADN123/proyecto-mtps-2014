// JavaScript Document
$(document).ready(function(){
	$('#wizard').smartWizard();
	
	$("#cantidad_solicitada").validacion({
		numMin: 0,
		ent: true
	});
	$("#justificacion").validacion({
		lonMin: 10
	});
	$("#id_fuente_fondo").validacion({
		men: "Debe seleccionar un item"
	});
	$("#id_seccion").validacion({
		men: "Debe seleccionar un item"
	});
	$("#verificando").validacion({       
        men: "Porfavor Selccione un vehiculo"
     });
});

function cargar_vehiculo(){

	var fuente_fondo = document.getElementById('id_fuente_fondo').value;
	var seccion = document.getElementById('id_seccion').value;


	if(fuente_fondo!="" && seccion!=""){
		$('#divVehiculos').load(base_url()+"index.php/vales/vehiculos/"+seccion+"/"+fuente_fondo);	
	}else{

	}
		
console.log( fuente_fondo + " "+ seccion);

}


$( "#form_mision").submit(function( event ) {
   alert("Mision jjjjj");
    return false;
  event.preventDefault();

});