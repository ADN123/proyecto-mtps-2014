<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
    accion='<?php echo $accion?>';
	estado_correcto='La Información se ha almacenado exitosamente.';
    estado_incorrecto='<?php echo $msj?>';

</script>
<section>
    <h2>Perfil de usuario</h2>
</section>
<style>
.k-multiselect {
	display: inline-block;
}
</style>
<form name="form_mision" method="post" action="<?php echo base_url()?>index.php/usuarios/cambiar_clave">
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Datos de usuario</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Contraseña</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
            <h2 class="StepTitle">Datos de Usuario</h2>
            <p>
            	<div id="info_adicional">

                	<?php    
                        echo '<label>Nombre </label><strong> '.ucwords($empleados[0]['nombre']).'</strong>';
                      echo	"<p><label>NR</label> <strong>".$info['nr']."</strong></p>".
									"<p><label>Cargo Nominal</label> <strong>".$info['nominal']."</strong></p>".
									"<p><label>Cargo Funcional</label> <strong>".$info['funcional']."</strong></p>".
									"<p><label>Departamento</label> <strong>".$info['nivel_2']."</strong></p>".
									"<p><label>Secci&oacute;n</label> <strong>".$info['nivel_1']."</strong></p>";					
					?>
                </div>
            </p> 
           <p>
                <label for="email" id="lemail">Correo Electronico</label>
                <input type="text" tabindex="1" id="email" name="email"  value="<?php echo $empleados[0][correo]; ?>"/>
            </p>
        </div>

        <div id="step-2">	
            <h2 class="StepTitle">Cambio de contraseña</h2>
            <p>
                <label for="pass1" id="lpass1">Contraseña Actual </label>
                <input type="password" tabindex="2" id="pass1" name="pass1" />
            </p>
           <p>
                <label for="pass2" id="lpass2">Nueva Contraseña</label>
                <input type="password" tabindex="3" id="pass2" name="pass2" />
            </p>
           <p>
                <label for="pass3" id="lpass3">Confirmacion de Contraseña</label>
                <input type="password" tabindex="4" id="pass3" name="pass3" />
            </p>
      	</div>
        
    </div>
</form>

<script type="text/javascript">

    $('#wizard').smartWizard();

    $("#pass1").validacion({       
        men: "Por favor ingrese su contraseña",
        lonMin: 5 
     });
    $("#pass2").validacion({       
        men: "Por favor ingrese su contraseña",
        lonMin: 5
     });
    $("#pass3").validacion({       
        lonMin: 5        
     }); 
    $("#email").validacion({       
        valCorreo: true        
     }); 
  
    $("#pass3").blur(function() {
        if ($('#pass2').val()!=$('#pass3').val()) {
                var mensaje="";
         $('#pass3').stop()
                $('#pass3').animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                $('#pass3').animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                $('#pass3').animate({ left: "0px" }, 100)

                $('#pass3').removeClass('correct').removeClass('correct2').addClass('required');            
                mensaje="<span class='mensaje-tooltip'><img src='"+base_url()+"img/error.png' width='12' width='12'/> Las contraseñas no coinciden</span><br/>";                

        }else{
                $('#pass3').removeClass('required').addClass("correct");


        }
});
</script>