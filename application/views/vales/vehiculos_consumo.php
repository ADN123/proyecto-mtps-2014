<table cellspacing="0" align="center" class="table_design">
    <thead>
        <th width="90">
            Placa
        </th>
        <th>
            Fuente
        </th>
        <th width="125">
            Tipo Gasolina
        </th>  
        <th width="125">
            Cantidad de Vales
        </th>                  
        <th width="90">
            Galones
        </th>                 
        <th width="120">
            Sub-Total ($)
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
                    <td ><?php echo $val['nombre_fuente_fondo'] ?></td>
                    <td>
                    	<select name="tip_gas[]" id="tip_gas<?php echo $val['id_vehiculo'] ?>" class="tipo_gas">
                        	<option value=""></option>
                            <option value="1">Regular</option>
                            <option value="2">Super</option>
                            <option value="3">Diesel</option>
                        </select>
                    </td>
                    <td><input class="cantidad" type="text" name="cantidad_consumo[]" id="cantidad_consumo<?php echo $val['id_vehiculo'] ?>" size="2" /></td>
                    <td class="gal">0.00</td>
                    <td class="sub">0.00</td>
                </tr>
        <?php } ?> 
        <tr> 
            <td align="right" colspan="3"> <strong>TOTAL</strong> </td>
            <td class="tval" style="color: #F8F8F8;  background: #EA8511; font-size: 14px;"><strong>0 Vales</strong></td>
            <td></td>
            <td class="tsub" style="color: #F8F8F8;  background: #EA8511; font-size: 14px;"><strong>$ 0.00 US</strong></td>
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
		
		if(gas!="" && gas!=0 && val!="" && val!=0) {
			var n1=5/gas*val;
			var n2=val*5;
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
		$(".tval").html("<strong>"+su+" Vales</strong>");			
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
				
			if(gas!="" && gas!=0 && val!="" && val!=0) {
				var n1=5/gas*val;
				var n2=val*5;
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
		$(".tval").html("<strong>"+su+" Vales</strong>");			
	});
	$("#valor_regular, #valor_super, #valor_diesel").keyup(function(){
		$(".tipo_gas").change();
	});
</script>