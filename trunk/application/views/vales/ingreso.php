<section>
    <h2>Ingresos de vales de combustible</h2>
</section>
<form name="formu" id="formu" action="index.php" method="post">
    <p>
        <label for="cantidad" id="lcantidad">Cantidad de Vales: </label>
        <input type="text" class="tam-1" tabindex="1" id="cantidad" name="cantidad"/> 
    </p>
    <p>
        <label for="valor" id="valor">Valor nominal: $</label>
        <input type="text" class="tam-1" tabindex="1" id="nombre2" name="nombre2"/>

    </p >

    <p>
        <label for="inicio" id="linicio">Correlativos: Inicio</label>
        <input class="tam-1" id="inicio" tabindex="2" name="inicio" type="text"/>
       <label for="final" id="lfinal">Final</label>
        <input class="tam-1" id="final" tabindex="2" name="final" type="text"/>
    </p>
    <p>
        <label for="desingnacion" id="ldesingnacion">Desingnacion</label>
        <select class="tam-1" tabindex="4" id="desingnacion" name="desingnacion">
            <option value="1">Servicio General</option>
            <option value="2">Banco Mundial</option>
        </select>
    </p>
    <p>
        <label for="Proveedor" id="lProveedor">Proveedor</label>
        <select class="tam-1" tabindex="4" id="Proveedor" name="Proveedor">
            <option value="1">Texaco</option>
            <option value="2">Puma</option>
        </select>
    </p>
    <p>
        <button type="submit" class="button tam-1 boton_validador" tabindex="8" id="guardar" name="guardar">Guardar</button>
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
        $("#inicio").validacion({
            req: false,
            lonMin: 10
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
                alertify.alert("Se va");         
        });
    });
</script>