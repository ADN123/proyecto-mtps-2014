// JavaScript Document
$(document).ready(function(){
	$('#wizard').smartWizard();
	$("#verificando").validacion({       
        men: "Porfavor Selccione un vehiculo"
     });

	$("#justificacion").validacion({
		lonMin: 10
	});
	
	
	/* $("#mes").validacion({
        men: "Debe seleccionar un item"
    }); 
	
	$("#id_seccion").validacion({
		men: "Debe seleccionar un item"
	});*/
});

function cargar_vehiculo(){

	var fuente_fondo = document.getElementById('id_fuente_fondo').value;
	var seccion = document.getElementById('id_seccion').value;
	var mes = document.getElementById('mes').value;
	var id_requisicion = document.getElementById('id_requisicion').value;

	if(fuente_fondo!="" && seccion!=""&& mes!=""){
		$('#divVehiculos').load(base_url()+"index.php/vales/vehiculos/"+seccion+"/"+fuente_fondo+'/'+id_requisicion);	
		$('#divHerramientas').load(base_url()+"index.php/vales/CargarOtros/"+seccion+"/"+fuente_fondo+'/'+id_requisicion);				

		document.getElementById('verificando').value="";
		verificarRF(seccion,fuente_fondo,mes)
		setTimeout ("marcados()", 2000);

	}else{
		console.log('aun hay campos vacios');
		console.log('fuente '+fuente_fondo);
		console.log('seccion '+seccion);
		console.log('mes '+mes);
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

			  if (estado_requisicion==1) {
				   	$("#cantidad_solicitada").destruirValidacion();					
				    $('#cantidad_solicitada').validacion({    
							req: true,
							numMin: 0,
							numMax: Number(data.asignado) +1
							});
			    }else{

			    	if (estado_requisicion==2) {
					   	$("#cantidad_entregado").destruirValidacion();					
					    $('#cantidad_entregado').validacion({    
								req: true,
								numMin: 0,
								numMax: Number(data.asignado) +1
								});

			    	}
			    }



            },
        error:function(data){
             alertify.alert('Error al cargar datos');
            console.log(data);
            }
        }); 
}



