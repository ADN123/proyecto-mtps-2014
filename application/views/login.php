<section>
    <h2>Inicio de sesi&oacute;n</h2>
</section>
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
   <p align="center"> <label id="olvido" title="Contáctese con la Unidad de Desarrollo Tecnológico al teléfono: 2529-3725 ">¿Ha olvidado su contraseña?</label></p>
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

</script>

