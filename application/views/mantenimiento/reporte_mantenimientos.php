<section>
    <h2>Mantenimientos</h2>
</section>
<form id="filtro" action="<? echo base_url()?>index.php/vehiculo/reporte_mantenimientos_pdf" method="post">
<input type="hidden" id="titulo" name="titulo" value="" />
<table align="center" width="100%">
    <tr>
        <td width="50%">
        <label style="width:100px">Mecánico: </label>
            <select class="select" style="width:300px" name="mecanico" id="mecanico" multiple="multiple">
                <option value="0" selected="selected">[Todos]</option>
                <?php
                    foreach($mecanicos as $m)
                    {
                        echo "<option value='".$m['id_empleado']."'>".ucwords($m['nombre'])."</option>";
                    }
                ?>
            </select>
        </td>
        <td>
            <label>Vehículo: </label>
            <select class="select" style="width:100px" name="id_vehiculo" id="id_vehiculo" multiple="multiple">
                <option value="0" selected='selected'>[Todos]</option>
                <?php
                    foreach($vehiculos as $v)
                    {
                        echo "<option value='".$v->id."'>".$v->placa."</option>";
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <label style="width:100px">Fecha Inicial: </label>
            <input type="text" name="fecha_inicial" id="fecha_inicial">
        </td>
        <td>
            <label>Fecha Final: </label>
            <input type="text" name="fecha_final" id="fecha_final">
        </td>
    </tr>
</table>
<p align="center">
        <button type="button" id="Filtrar" class="button tam-1" >Filtrar</button>                    
        <button   id="imp1" class="button tam-1" >Imprimir</button>

</p>
</form>
<br><br>
<div id="tabla_resultado">
</div>
<br><br>
<div style="height:400px; background:#FFFFFF;" id="chartdiv">
</div>
<script language="javascript" src="<?php echo base_url()?>js/views/reporte_mantenimientos.js"></script>