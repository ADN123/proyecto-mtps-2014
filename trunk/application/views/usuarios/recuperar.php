<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='La Información se ha almacenado exitosamente.';
    estado_incorrecto='<?php echo $msj?>';

</script>
<section>
    <h2>Recuperar Contraseña</h2>
</section>
<style>
.k-multiselect {
	display: inline-block;
}
</style>
<form name="form_recuperar" method="post" action="<?php echo base_url()?>index.php/usuarios/recuperar_clave" id="form">
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
                        <small>&nbsp;Envio de correo correo</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
            <h2 class="StepTitle">Datos de Usuario</h2>
            <p>
            	<div id="info_adicional">
                    <p>
                        <label for="nr" id="lnr">Usuario o NR </label>
                        <input  type="text" name="nr" id="nr" tabindex="1"></>
                    </p>
                    <p>
                    <label>Codigo</label>                           
                    <input type="text" data-req="true"  name="captcha_code" id="captcha_code" />
                    </p>
                    <p> 
                    <a href="#" id="cap" onclick="document.getElementById('captcha').src = '<?php echo base_url()?>/index.php/sessiones/capcha'; return false">
                        <img id="captcha" src="<?php echo base_url()?>/index.php/sessiones/capcha" alt="CAPTCHA Image"  style="margin-left: 150px;"/></a>
                    
                    </p>
                    <button class="btn btn-success" type="submit" name="feedbackSubmit" id="feedbackSubmit">
                     <span class="glyphicon glyphicon-send"></span> Enviar</button>                       


                </div>
            </p> 
        </div>

        <div id="step-2">	
            <h2 class="StepTitle">Codigo de activacion</h2>
            <div id="mensaje"></div>
            <p>
                <label for="pass1" id="lpass1">Codigo de activación</label>
                <input type="text" tabindex="1" id="pass1" name="pass1" class="tam-3" />
            </p>


      	</div>
        
    </div>
</form>

<script type="text/javascript">

    $('#wizard').smartWizard();
    $("#nr").validacion({       
        men: "Por favor ingrese sus credenciales",
        lonMin: 4 
     });
 
    $('.buttonNext').click(function () {
                    $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>/index.php/sessiones/sendmail",
                data: $("#form").serialize(),
                success: function(data) {
                    $("#cap").click();
                    if(data.status==1) {
                        $("#mensaje").html( '<div class="alert alert-success">'+
                            '   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                            '   <span class="glyphicon glyphicon-exclamation-sign"></span> El <strong>envío solicitud de cambio de contraseña</strong> se ha realizado exitosamente al correo: '+data.message+
                            '</div>');
                        $("#correo").val("");
                        $("#captcha_code").val("");                     
                    }
                    else
                        $("#mensaje").html( '<div class="alert alert-danger">'+
                            '   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                            '   <span class="glyphicon glyphicon-exclamation-sign"></span> Error al intentar <strong>enviar solicitud de cambio de contraseña</strong>: '+data.message+
                            '</div>');
                },
                error: function(response) {
                    $("#mensaje").html( '<div class="alert alert-danger">'+
                                        '   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                                        '   <span class="glyphicon glyphicon-exclamation-sign"></span> Error al intentar <strong>enviar solicitud de cambio de contraseña</strong>: Se perdió la señal de la red. Porfavor vuelva a intentarlo.'+
                                        '</div>');
                }
            });
            return false;


    });
</script>