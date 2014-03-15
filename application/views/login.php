<script type="text/javascript">
	function entrar() {
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
					if(data['estado']==0) {
							alert(data['msj']);
					}
					else {	
						setTimeout('location.href="'+base_url()+'"',1000);
					}
				},
				error:function(data) { //////funcion ejecutada si hay error
					alert('Error no se pudo conectar al servidor');
					console.log(data.resposeText);
					return false;
				}
			}); 
	 	}
	}
</script>
<section>
    <h2>Inicio de Sesi&oacute;n</h2>
</section>
<div id="contenedor">
    <form name="form1" id="form1" action="<?php echo base_url();?>index.php/sessiones/iniciar_session"  method="post"> 
        <p>
            <input type="hidden" name="ir" />
        </p>
        <p>
            <label for="user" id="luser">Usuario</label>
            <input type="text"  tabindex="1"class="tam-4" name="user" id="user" />
        </p>
        <p>
            <label for="pass" id="lpass">Clave</label>
            <input type="password" tabindex="2" class="tam-4" name="pass" id="pass" />
        </p>
        <p>
            <button type="button" class="button tam-1 boton_validador" tabindex="3" id="guardar" name="guardar" onclick="entrar()"> Entrar</button>
        </p>
    </form>
</div>

