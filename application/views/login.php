<section>
    <h2>Inicio de sesi&oacute;n</h2>
</section>
<style type="text/css">
    .hvr-grow:hover, .hvr-grow:focus, .hvr-grow:active {
    -webkit-transform: scale(1.7);
      transform: scale(1.7);
}
.hvr-grow{
    color: #00436F
}

</style>
<div id="contenedor">
    <form name="form1" id="form1" action="<?php echo base_url();?>index.php/sessiones/iniciar_session"  method="post" name="form1" style="width: 300px;"> 
        <p>
            <input type="hidden" name="ir" />
        </p>
        <p>
            <label for="user" id="luser">Usuario</label>
            <input type="text"  tabindex="1" style="width: 225px;" name="user" id="user" />
        </p>
        <p>
            <label for="pass" id="lpass">Clave</label>
            <input type="password" tabindex="2" style="width: 225px;" name="pass" id="pass" />
        </p>

     
        <p style="text-align: center;">
            <button type="submit" class="button tam-1 boton_validador" tabindex="3" id="entrar" name="entrar"> Entrar</button>
        </p>
   </form>
   <p align="center"> <a  class="hvr-grow" href="<?php echo base_url(); ?>index.php/sessiones/recuperar">¿Ha olvidado su contraseña?</a></p>
</div>

<script type="text/javascript">

    $("#pass").validacion({       
        men: "Por favor ingrese su contraseña",
        lonMin: 5   
     });
    $("#user").validacion({       
        men: "Por favor ingrese su usuario",
        lonMin: 5   
     });

    estado_transaccion='<?php echo $estado_transaccion?>';
    estado_correcto='El cambio de contraseña se ha realizado correctamente.';
    estado_incorrecto='Se produjo un error al cambiar la contraseña';
</script>



