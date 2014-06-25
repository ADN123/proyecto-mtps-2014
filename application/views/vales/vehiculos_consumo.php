<table cellspacing="0" align="center" class="table_design" style="width: 98%; min-width: 770px;">
    <thead>
        <th width="70">
            Placa
        </th>
        <th>
            Fuente
        </th>
        <th>
            Actividad
        </th>
        <th width="100">
            Tipo Gasolina
        </th>  
        <th width="85">
            Cantidad de Vales
        </th>   
        <th width="85">
            Valor Nominal ($)
        </th>                 
        <th width="75">
            Galones
        </th>                 
        <th width="100">
            Sub-Total ($)
        </th>
    </thead>
    <tbody id="content_table">
		 <?php
            foreach($vehiculos as $val) { ?>
                <tr> 
                    <td align="left" title="<?php echo $val['marca'] ?> <?php echo $val['modelo'] ?>">
						<?php echo $val['placa'] ?>
                   		<input type="hidden" name="id_vehiculo[]" id="id_vehiculo<?php echo $val['id_vehiculo'] ?>" value="<?php echo $val['id_vehiculo'] ?>" />
                    </td>
                    <td><?php echo $val['nombre_fuente_fondo'] ?></td>
                    <td><input type="text" name="actividad_consumo[]" id="actividad_consumo<?php echo $val['id_vehiculo'] ?>"/></td>
                    <td>
                    	<select name="tip_gas[]" id="tip_gas<?php echo $val['id_vehiculo'] ?>" class="tipo_gas">
                        	<option value=""></option>
                            <option value="1">Regular</option>
                            <option value="2">Super</option>
                            <option value="3">Diesel</option>
                        </select>
                    </td>
                    <td><input class="cantidad" type="text" name="cantidad_consumo[]" id="cantidad_consumo<?php echo $val['id_vehiculo'] ?>" size="2" maxlength="2"/></td>
                    <td align="right" class="pre"><?php echo number_format($val['valor_nominal'],2,'.',',') ?></td>
                    <td align="right" class="gal">0.00</td>
                    <td align="right" class="sub">0.00</td>
                </tr>
        <?php } ?> 
        <tr> 
            <td align="right" colspan="4"> <strong>TOTAL</strong> </td>
            <td class="tval" style="color: #F8F8F8;  background: #EA8511; font-size: 14px;"><strong>0</strong></td>
            <td></td><td></td>
            <td align="right" class="tsub" style="color: #F8F8F8;  background: #EA8511; font-size: 14px;"><strong>$ 0.00 US</strong></td>
        </tr>
    </tbody>
</table>
<script>
	$(".tipo_gas").kendoComboBox({
		autoBind: false,
		filter: "contains"
	});
	$(".cantidad").validacion({
		numMin:0,
		numMax:15,
		ent: true,
		req: false
	});
	$(".cantidad").keyup(function(){
		var $abu=$(this).parents('tr'); 
		var $sel=$abu.find("select");
		var combobox = $sel.data("kendoComboBox");
		
		var gas=Number(combobox.value());
		
		switch(gas) {
			case 1:
				gas=Number($("#valor_regular").val());
				break;
			case 2:
				gas=Number($("#valor_super").val());
				break;
			case 3:
				gas=Number($("#valor_diesel").val());
				break;
			default:
				gas="";
		}
		
		var val=Number($(this).val());
		
		var $gal=$abu.find(".gal");
		var $sub=$abu.find(".sub");
		var $pre=Number($abu.find(".pre").html());
		
		if(gas!="" && gas!=0 && val!="" && val!=0) {
			var n1=$pre/gas*val;
			var n2=val*$pre;
			$gal.html(parseFloat(n1).toFixed(2));
			$sub.html(parseFloat(n2).toFixed(2));
		}
		else {
			$gal.html("0.00");
			$sub.html("0.00");
		}
		
		var su=0;
		$(".sub").each(function (index) {
			su=su+Number($(this).html());			
		});
		$(".tsub").html("<strong>$ "+parseFloat(su).toFixed(2)+" US</strong>");		
		
		var su=0;
		$(".cantidad").each(function (index) {
			su=su+Number($(this).val());			
		});
		$(".tval").html("<strong>"+su+"</strong>");			
	});
	$(".tipo_gas").change(function(){

		var $abu=$(this).parents('tr'); 
		var $can=$abu.find(".cantidad");
		
		var val=Number($can.val());
		if($(this).val()!="") {
			switch(Number($(this).val())) {
				case 1:
					gas=Number($("#valor_regular").val());
					break;
				case 2:
					gas=Number($("#valor_super").val());
					break;
				case 3:
					gas=Number($("#valor_diesel").val());
					break;
				default:
					gas="";
			}
		
			var $gal=$abu.find(".gal");
			var $sub=$abu.find(".sub");
			var $pre=Number($abu.find(".pre").html());
				
			if(gas!="" && gas!=0 && val!="" && val!=0) {
				var n1=$pre/gas*val;
				var n2=val*$pre;
				$gal.html(parseFloat(n1).toFixed(2));
				$sub.html(parseFloat(n2).toFixed(2));
			}
			else {
				$gal.html("0.00");
				$sub.html("0.00");
			}
		}
		
		var su=0;
		$(".sub").each(function (index) {
			su=su+Number($(this).html());			
		});
		$(".tsub").html("<strong>$ "+parseFloat(su).toFixed(2)+" US</strong>");		
		
		var su=0;
		$(".cantidad").each(function (index) {
			su=su+Number($(this).val());			
		});
		$(".tval").html("<strong>"+su+"</strong>");			
	});
	$("#valor_regular, #valor_super, #valor_diesel").keyup(function(){
		$(".cantidad").keyup();
	});
</script>