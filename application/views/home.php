<section>
    <h2>Nuevo Formulario</h2>
</section>
<form name="formu" id="formu" action="index.php" method="post">
    <p>
        <label for="nombre" id="lnombre">Texto</label>
        <input type="text" class="tam-4" tabindex="1" id="nombre" name="nombre"/>
    </p>
    <p>
        <label for="nombre2" id="lnombre2">Texto2</label>
        <input type="text" class="tam-3" tabindex="1" id="nombre2" name="nombre2"/>
    </p>
    <p>
        <label for="direccion" id="ldireccion">Textarea</label>
        <textarea class="tam-4" id="direccion" tabindex="2" name="direccion"/></textarea>
    </p>
    <p>
        <label for="nacimiento" id="lnacimiento">Nacimiento</label>
        <input type="text" class="nac" tabindex="3" id="nacimiento" name="nacimiento"/>
    </p>
    <p>
        <label for="select" id="lselect">Select</label>
        <select class="tam-1" tabindex="4" id="select" name="select">
            <option value="1">Valor 1</option>
            <option value="2">Valor 2</option>
        </select>
    </p>
    <p>
        <label for="precio" id="lprecio">Precio</label>
        <input type="text" class="tam-1" tabindex="5" id="precio" name="precio"/>
    </p>
    <p>
        <label for="telefono" id="ltelefono">Tel&eacute;fono</label>
        <input type="text" class="tam-2" tabindex="6" id="telefono" name="telefono"/>
    </p>
    <p>
        <label for="correo" id="lcorreo">Correo</label>
        <input type="text" class="tam-3" tabindex="7" id="correo" name="correo"/>
    </p>
    <p>
        <button type="submit" class="button tam-1 boton_validador" tabindex="8" id="guardar" name="guardar"><img src="img/guardar.png" width="12" height="12"> Guardar</button>
    </p>
</form>
<script type="text/javascript">
	$(document).ready(function(){
	   $("#nombre").validacion({
			valNombre: true
		});
		$("#nombre2").validacion({
			alf: true,
			lonMin: 15
		});
		$("#direccion").validacion({
			req: false,
			lonMin: 10
		});
		$("#nacimiento").validacion({
			valFecha: true
		});
		$("#precio").validacion({
			valPrecio: true
		});
		$("#select").validacion({
			men: "Debe seleccionar un item"
		});
		$("#telefono").validacion({
			req: false,
			valTelefono: true
		});
		$("#correo").validacion({
			valCorreo: true,
			verOk: true
		});
		$("#guardar").click(function(){
			if($("#formu").data("ok"))
				alert("Se va");			
		});
	});
</script>