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
	$("#valor_super").validacion({
		valPrecio: true
	});
	$("#valor_regular").validacion({
		valPrecio: true
	});
	$("#valor_diesel").validacion({
		valPrecio: true
	});
	$("#id_gasolinera").change(function(){
		var id_gasolinera = $(this).val();
		var fecha_factura = $("#fecha_factura").val();
		var seccion = $("#id_seccion").val();
		
		if(seccion!=""&&id_gasolinera!="" && fecha_factura!="" ){

			$('#divVehiculos').load(base_url()+"index.php/vales/vehiculos_consumo/"+id_gasolinera+"/"+fecha_factura+"/"+seccion);
			get_vales();
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
		  	console.log("error");
		  }
		});
}

function mostrar_a_consumir(id_fondo, consumir){
	  	
	
	var restante = $("#total_vales"+id_fondo).val();
	var  indexV =0;
	var inicialv= new Array();
	var finalv = new Array();
	var fuente = new Array();
	var vales = valesStactic;
if (restante>=consumir){
console.log(vales);
console.log("indexV "+ indexV);
console.log("vales[indexV].cantidad_restante  "+ vales[indexV].cantidad_restante);

	while(consumir>0){
		if(vales[indexV].bandera==1&&vales[indexV].fuente!=id_fondo){ indexV++;	}

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
	}//fin while
}else{
console.log("no hay suficientes vales");
}

var html= "Consumido: <ul>"
for (var i = 0; i < inicialv.length; i++) {
	html += "<li><strong>"+ inicialv[i]+"-"+finalv[i]+"</strong></li>";
};

html+="</ul>";
$('#display'+id_fondo).html(html);

/*	var cantidades = $('.cantidad')
	var extra = $('input[name="id_vehiculo[]"]');
	var totalFuente;

	for (var i = 0; i < cantidades.length; i++) {
		console.log(cantidades[i].val());
	} */
}
