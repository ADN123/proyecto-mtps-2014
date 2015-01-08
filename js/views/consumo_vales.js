// JavaScript Document
$(document).ready(function() {
	var tiempo = new Date();
	newfec=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate(), tiempo.getHours(), tiempo.getMinutes());
	
	$('#wizard').smartWizard();

	$("#id_gasolinera").validacion({
		men: "Debe seleccionar un item"        
	});
	
	var fec_soli=$("#fecha_factura").kendoDatePicker({
		culture: "es-SV",
		format: "dd/MM/yyyy",
		max: newfec
	}).data("kendoDatePicker");

	$("#fecha_factura").validacion({
		valFecha: true
	});
	$("#numero_factura").validacion({
		numMin:1,
		ent: true
	});

	$("#id_gasolinera").change(function(){
		var id_gasolinera = $(this).val();
		var fecha_factura = $("#fecha_factura").val();
		var seccion = $("#id_seccion").val();
		
		if(seccion!=""&&id_gasolinera!="" && fecha_factura!="" ){

			$('#divVehiculos').load(base_url()+"index.php/vales/vehiculos_consumo/"+id_gasolinera+"/"+fecha_factura+"/"+seccion);
			get_vales();
			get_obligatorios("/"+id_gasolinera+"/"+fecha_factura+"/"+seccion);

		}else{
			$('#divVehiculos').html("<br/><br/><br/>Debe seleccionar una <strong>gasolinera</strong> e ingresar la <strong>fecha de la factura</strong>...");	
		}
			
	});
	$("#total").validacion({
		valPrecio: true
	});
	$("#fecha_factura").blur(function(){
		$("#id_gasolinera").change();
	});
	$("#id_seccion").change(function(){
		$("#id_gasolinera").change();
	});
});

var valesStatic;

function get_obligatorios(url) {
		$.ajax({
		  async:	true, 
			url:	base_url()+"index.php/vales/tipo_combustible"+url,
		  dataType: "json", 
		  success: function(data) {
		  		precios_obligatorios(data);			

				  },
		  error: function (data) {
		  	console.log("error al verificar tipos de combustible");
		  }
		});

}
function precios_obligatorios(data) {

	$("#valor_diesel").destruirValidacion();					
	$("#valor_super").destruirValidacion();					
	$("#valor_regular").destruirValidacion();
	for (var i = 0; i < data.length; i++) {
			if(data[i].combustible=="Diesel"){

				$("#valor_diesel").validacion({
					valPrecio: true
				});

			}
			if(data[i].combustible=="Gasolina"){
				$("#valor_super").validacion({
					valPrecio: true
				});
				$("#valor_regular").validacion({
					valPrecio: true
				});
			}
		}
}

function get_vales() {
	var send=$('form').serializeArray();

		$.ajax({
		  type: "POST",
		  async:	true, 
			url:	base_url()+"index.php/vales/vales_a_consumir/",
		  data: send,
		  dataType: "json", 
		  success: function(data) {
		  		valesStactic = data;

				  },
		  error: function (data) {
		  	console.log("error al obtener series de vales");
		  }
		});

}

function mostrar_a_consumir(id_fondo, consumir){
	  	
	

	consumir=Number($("#consumo_vales"+id_fondo).val());
	var restante = Number($("#total_vales"+id_fondo).val())+consumir;
	var  indexV =0;
	var inicialv= new Array();
	var finalv = new Array();
	var fuente = new Array();
	var vales = valesStactic;
	var nfuente=""
	
if (restante>=consumir){
		

	while(consumir>0&&indexV<vales.length){
		//if(vales[indexV].bandera==1&&vales[indexV].fuente!=id_fondo){ indexV++;	}

		if (Number(id_fondo)==Number(vales[indexV].fuente) ){
			if(vales[indexV].cantidad_restante>=consumir){
				axu= Number(vales[indexV].inicial)+ consumir -1;
				inicialv.push(Number(vales[indexV].inicial));
				finalv.push(axu);
				consumir=0;
			}else{
				axu= Number(vales[indexV].inicial)+ Number(vales[indexV].cantidad_restante) -1;
				inicialv.push(Number(vales[indexV].inicial));
				finalv.push(axu);
				consumir-=vales[indexV].cantidad_restante;
				indexV++;

			}//fin else		
		nfuente=vales[indexV].nfuente;
		}else{
			indexV++;			
		}//fin if para verificar fuente
	}//fin while

}else{
console.log("no hay suficientes vales");
}

if (inicialv.length!==0) {

	var html= "Consumido: "+nfuente+" <ul>"
	for (var i = 0; i < inicialv.length; i++) {
		html += "<li><strong>"+ inicialv[i]+"-"+finalv[i]+"</strong></li>";
	};
	html+="</ul>";
	$('#display'+id_fondo).html(html);
}


/*	var cantidades = $('.cantidad')
	var extra = $('input[name="id_vehiculo[]"]');
	var totalFuente;

	for (var i = 0; i < cantidades.length; i++) {
		console.log(cantidades[i].val());
	} */
}
