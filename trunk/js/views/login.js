// JavaScript Document
$(document).ready(function() {
	$('#entrar').click(function entrar() {
		if (document.form1.user.value=="" || document.form1.pass.value=="") { 
			alert('por favor llene los datos');
			return false;
		}
	 	else {
			var formu = $('#form1').serializeArray();
			$.ajax({
				type:  "post",  
				async:	true, 
				url:	base_url()+"index.php/sessiones/iniciar_session",
				data:   formu,
				dataType: "json",
				success: function(data) { /////funcion ejecutada si la respuesta fue satictatoria
				if(data['estado']!=3){
					if(data['estado']==0) {
							alert(data['msj']);
					}
					else {	
						setTimeout('location.href="'+base_url()+'"',1000);
					}
				}else{
						if(data['intentos']==3){alert(data['msj'])}
						ele=document.getElementById('user') 
						ele.disabled=true;
						
						ele=document.getElementById('pass') 
						ele.disabled=true;
						
						ele=document.getElementById('entrar') 
						ele.disabled=true;
						
					}
				},
				error:function(data) { //////funcion ejecutada si hay error
					alert('Error al intentar ingresar al sistema: No se pudo conectar al servidor');
					console.log(data.resposeText);
					return false;
				}
			}); 
	 	}
	});
});