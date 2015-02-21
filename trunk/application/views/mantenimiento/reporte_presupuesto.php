<section>
    <h2>Presupuestos</h2>
</section>
<form id="filtro" action="<? echo base_url()?>index.php/vehiculo/reporte_presupuesto_pdf" method="post">
<table align="center" width="100%">
    <tr>
        <td width="50%">
        <label style="width:120px">Mantenimiento: </label>
            <select class="select" style="width:300px" name="mtto" id="mtto" multiple="multiple">
                <option value="0" selected="selected">[Todos]</option>
                <option value="1">Interno</option>
                <option value="2">Externo</option>                
            </select>
        </td>
        <td>
            <label style="width:100px">Vehículo: </label>
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
<script language="javascript" src="<?php echo base_url()?>js/views/reporte_presupuesto.js"></script>