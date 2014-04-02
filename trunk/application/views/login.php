<script src="<?php echo base_url()?>js/views/login.js" type="text/javascript"></script>
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
</div>

