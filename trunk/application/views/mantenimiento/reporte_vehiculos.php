<form name="form_reporte" method="post" action="<?php echo base_url()?>index.php/vehiculo/vehiculos_pdf">
<table width="900px">
	<tr>
    	<td colspan="2"><h1>Generación de Reporte de Vehículos</h1></td>
    </tr>
    <tr>
    	<td width="450px">
        	<p>
            	<label>Placa: </label>
                <input type="text" name="placa" id="placa" width="150px" />
            </p>
        	<p>
        		<label>Marca: </label>
                 <select name="marca" id="marca" class="select" style="width:150px">
                <?php
                
                foreach($marca as $mar)
                {
                    echo "<option value='".$mar->id_vehiculo_marca."'>".ucwords($mar->nombre)."</option>";
                }
                ?>
            	</select>
            </p>
            <p>
                <label>Modelo: </label>
                 <select name="modelo" id="modelo" class="select" style="width:200px">
                <?php
                
                foreach($modelo as $model)
                {
                    echo "<option value='".$model->id_vehiculo_modelo."'>".ucwords($model->modelo)."</option>";
                }
                ?>
                </select>
            </p>
            <p>
                <label>Clase: </label>
                 <select name="clase" id="clase" class="select" style="width:150px">
                <?php
                
                foreach($clase as $cla)
                {
                    echo "<option value='".$cla->id_vehiculo_clase."'>".ucwords($cla->nombre_clase)."</option>";
                }
                ?>
                </select>
            </p>
            <p>
                <label>Año: </label>
                 <select name="anio" id="anio" class="select" style="width:150px">
                <?php
                
                for($i=1980;$i<=date('Y');$i++)
                {
                    echo "<option value='".$i."'>".$i."</option>";
                }
                ?>
                </select>
            </p>
            <p>
                <label>Tipo de Combustible: </label>
                <select name="tipo_comustible" id="tipo_combustible" class="select" style="width:150px">
                	<option value="Gasolina">Gasolina</option>
                    <option value="Diesel">Diesel</option>
                </select>
            </p>
        </td>
        <td width="450px">
        	<p>
                <label>Fuente de Fondo: </label>
                <select name="fuente" id="fuente" class="select" style="width:250px">
                <?php                
					foreach($fuente_fondo as $fue)
					{
						echo "<option value='".$fue->id_fuente_fondo."'>".ucwords($fue->fuente)."</option>";
					}
                ?>
                </select>
            </p>
            <p>
                <label>Condición: </label>
                 <select name="condicion" id="condicion" class="select" style="width:175px">
                <?php
                foreach($condicion as $con)
                {
                    echo "<option value='".$con->id_vehiculo_condicion."'>".ucwords($con->condicion)."</option>";
                }
                ?>
                </select>
            </p>
            <p>
                <label>Sección: </label>
                <select name="seccion" id="seccion" class="select" style="width:350px">
                <?php
                
                foreach($seccion as $sec)
                {
                    echo "<option value='".$sec->id_seccion."'>".ucwords($sec->seccion)."</option>";
                }
                ?>
                </select>
            </p>
            <p>
                <label>Motorista: </label>
                <select name="motorista" id="motorista" class="select" style="width:300px">
                <?php
                
                foreach($motoristas as $mot)
                {
                    echo "<option value='".$mot->id_empleado."'>".ucwords($mot->nombre)."</option>";
                }
                ?>
                </select>
            </p>
            <p>
                <label>Estado: </label>
                <select name="estado" id="estado" class="select" style="width:150px">
               		<option value="0">De Baja</option>
                    <option value="1">Activo</option>
                    <option value="2">En Taller Interno</option>
                    <option value="3">En Taller Externo</option>
                    <option value="4">Robado</option>
                </select>
            </p>
        </td>
    </tr>
    <tr>
        <td align="center" colspan="2"><button type="button" name="btnFiltrar" class="button tam-1" onclick="validar_filtro()">Filtrar</button></td>
    </tr>
</table>
</form>
<script language="javascript">
function validar_filtro()
{
	var placa = document.getElementById('placa').value;
	var marca = document.getElementById('marca').value;
	var modelo = document.getElementById('modelo').value;
	var clase = document.getElementById('clase').value;
	var condicion = document.getElementById('condicion').value;
	var fuente = document.getElementById('fuente').value;
	var seccion = document.getElementById('seccion').value;
	var motorista = document.getElementById('motorista').value;
	var anio = document.getElementById('anio').value;
	var estado = document.getElementById('estado').value;
	var tipo_combustible = document.getElementById('tipo_combustible').value;
	if(placa=='' && marca=='' && modelo=='' && clase=='' && condicion=='' && fuente=='' && seccion=='' && motorista=='' && anio=='' && tipo_combustible=='' && estado=='')
	{
		alert('Error: Debe llenar al menos 1 campo');
	}
	else
	{
		document.form_reporte.submit();
	}
}
</script>
