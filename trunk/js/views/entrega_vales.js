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
		$('#divHerramientas').load(base_url()+"index.php/vales/CargarOtros/"+seccion+"/"+fuente_fondo);	
		document.getElementById('verificando').value="";
		info(seccion,fuente_fondo);
	}else{

	}
		
console.log( fuente_fondo + " "+ seccion);

}



function marcados() {

    var i=0;
    $("input[name='values[]']:checked").each(function (){   //capturando los chekeados
        i++;
    }); 
console.log(i);
    if(i==0){
        document.getElementById('verificando').value="";
    }else{
        document.getElementById('verificando').value="ok";
    }
}

function info(id1,id2){
$.ajax({
        async:  true, 
        url:    base_url()+"/index.php/vales/consultar_consumo/"+id1+"/"+id2,
        dataType:"json",
        success: function(data){

			    
			    if($("#refuerzo").is(':checked')) {  

			    $("#cantidad_solicitada").prop('readonly', false);

				///Lo maximo que se puede pedir es la misma cantidad asignada

			    $("#cantidad_solicitada").destruirValidacion();					
			    $('#cantidad_solicitada').validacion({    
						req: true,
						numMin: 0,
						numMax: data.asignado
						});
		    	$('#justificacion').val("");

			    }else{

			    $("#cantidad_solicitada").prop('readonly', true);
				$("#cantidad_solicitada").val(data.peticion);
			    var txt = $("#id_seccion option:selected").text();

			    if(txt=="") {txt=document.getElementById('nombre').value;}
			    $('#justificacion').val("Cuota mensual asignada a "+ txt);
			   

			    }


            },
        error:function(data){
             alertify.alert('Error al cargar datos');
            console.log(data);
            }
        }); 
}

function refuerzock() {
 	if($("#refuerzo").is(':checked')) {  
 		$("#cantidad_solicitada").prop('readonly', false);
 		
 	}else{
 		$("#cantidad_solicitada").prop('readonly', true);
 	}
 	cargar_vehiculo();
}
