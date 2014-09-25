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
	
	$("#mes").validacion({
		men: "Debe seleccionar un item"
	});
	$("#verificando").validacion({       
        men: "Porfavor Selccione un vehiculo"
     });
	$("#id_seccion").validacion({
		men: "Debe seleccionar un item"
	});
});

function cargar_vehiculo(){

	var fuente_fondo = document.getElementById('id_fuente_fondo').value;
	var seccion = document.getElementById('id_seccion').value;
	var mes = document.getElementById('mes').value;


	if(fuente_fondo!="" && seccion!=""&& mes!=""){
		$('#divVehiculos').load(base_url()+"index.php/vales/vehiculos/"+seccion+"/"+fuente_fondo);	
		$('#divHerramientas').load(base_url()+"index.php/vales/CargarOtros/"+seccion+"/"+fuente_fondo);				

		document.getElementById('verificando').value="";
		verificarRF(seccion,fuente_fondo,mes)

	}else{
	$('#divVehiculos').html("<br/><br/><br/>Debe seleccionar <strong>Fuente de Fondo, Sección </strong> y <strong>Mes </strong>...");
	$('#divHerramientas').html("<br/><br/><br/>Debe seleccionar <strong>Fuente de Fondo, Sección </strong> y <strong>Mes </strong>...");		
	}
		

}



function marcados() {

    var i=0;
    $("input[name='values[]']:checked").each(function (){   //capturando los chekeados
        i++;
    }); 
    $("input[name='values2[]']:checked").each(function (){   //capturando los chekeados
        i++;
    }); 
    
console.log(i);
    if(i==0){
        document.getElementById('verificando').value="";
    }else{
        document.getElementById('verificando').value="ok";
    }
}

function verificarRF(id1, id2, mes){
	$.ajax({
	        async:  true, 
	        url:    base_url()+"/index.php/vales/consultar_refuerzo/"+id1+"/"+id2+"/"+mes,
	        dataType:"json",
	        success: function(data){
	        	
               if(data[0].num==0){
      				document.getElementById('refuerzo').value=0;     
      				$('#lbl').html("No");
                  }else{
					document.getElementById('refuerzo').value=1;
					$('#lbl').html("Si");
                  }
				info(id1,id2);
            },
        error:function(data){
             alertify.alert('Error al cargar datos');
            console.log(data);
            
            }
        }); 

}

function info(id1,id2){
$.ajax({
        async:  true, 
        url:    base_url()+"/index.php/vales/consultar_consumo/"+id1+"/"+id2,
        dataType:"json",
        success: function(data){
        	console.log(data);
        		$('#restante').val(data.restante);
	        	if(data.asignado!=null){
	        		$('#lbl2').html(data.asignado);
	        		$('#lbl3').html(data.peticion);
	        	}else{
	        		$('#lbl2').html("(No tiene ninguna asignación)");
	        		$('#lbl3').html("(No tiene ninguna asignación)");
	        	}
			    
			    
			    if(document.getElementById('refuerzo').value!=0) {  

			    $("#cantidad_solicitada").prop('readonly', false);

				///Lo maximo que se puede pedir es la misma cantidad asignada

				$("#cantidad_solicitada").destruirValidacion();					
			    $('#cantidad_solicitada').validacion({    
						req: true,
						numMin: 0,
						numMax: data.asignado +1
						});
		    	$('#justificacion').val("");

			    }else{

//			    $("#cantidad_solicitada").prop('readonly', true); //temporalmente habilitado
				$("#cantidad_solicitada").val(data.peticion);
			    var txt = $("#id_seccion option:selected").text();

			    if(txt=="") {txt=document.getElementById('nombre').value;}
			    $('#justificacion').val("CUOTA MENSUAL ASIGNADA A "+ txt);
			   

			    }


            },
        error:function(data){
             alertify.alert('Error al cargar datos');
            console.log(data);
            }
        }); 
}



