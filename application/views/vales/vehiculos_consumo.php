<table cellspacing="0" align="center" class="table_design">
    <thead>
        <th>
            Placa
        </th>
        <th>
            Tipo Gasolina
        </th>  
        <th width="175">
            Cantidad de Vales
        </th>                  
        <th width="120">
            Galones
        </th>                 
        <th width="120">
            Sub-Total
        </th>
    </thead>
    <tbody id="content_table">
		 <?php
            foreach($vehiculos as $val) { ?>
                <tr> 
                    <td title="<?php echo $val['marca'] ?> <?php echo $val['modelo'] ?>">
						<?php echo $val['placa'] ?>
                   		<input type="hidden" name="id_vehiculo[]" id="id_vehiculo<?php echo $val['id_vehiculo'] ?>" value="<?php echo $val['id_vehiculo'] ?>" />
                    </td>
                    <td>
                    	<select name="tip_gas[]" id="tip_gas<?php echo $val['id_vehiculo'] ?>" class="tipo_gas">
                        	<option value=""></option>
                            <option value="1">Regular</option>
                            <option value="2">Super</option>
                            <option value="3">Diesel</option>
                        </select>
                    </td>
                    <td><input type="text" name="cantidad_consumo[]" id="cantidad_consumo<?php echo $val['id_vehiculo'] ?>" size="2" /></td>
                    <td>0.00</td>
                    <td>$ 0.00 US</td>
                </tr>
        <?php } ?> 
        <tr> 
            <td align="right" colspan="2"> <strong>TOTAL</strong> </td>
            <td><strong>0</strong></td>
            <td></td>
            <td><strong>$ 0.00 US</strong></td>
        </tr>
    </tbody>
</table>
<script>
	$(".tipo_gas").kendoComboBox({
		autoBind: false,
		filter: "contains"
	});
</script>