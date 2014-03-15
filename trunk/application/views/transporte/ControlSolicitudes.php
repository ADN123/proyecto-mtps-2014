
    <style>
		#lean_overlay {
			position: fixed;
			z-index:100;
			top: 0px;
			left: 0px;
			height:100%;
			width:100%;
			background: #000;
			display: none;
		}
		#ventana {
			width: 60%;
			min-height: 25%;
			max-height: 55%;
			padding: 30px; 
			display:none;
			background: #FFF;
			border-radius: 5px; 
			-moz-border-radius: 5px; 
			-webkit-border-radius: 5px;
			box-shadow: 0px 0px 4px rgba(0,0,0,0.7); 
			-webkit-box-shadow: 0 0 4px rgba(0,0,0,0.7);
			-moz-box-shadow: 0 0px 4px rgba(0,0,0,0.7);   
		}
	</style>
<section>
    <h2>Control de Solicitudes</h2>
</section>


<table  id="grid">
<thead>
  <tr>
    <th>Fecha y Hora</th>
    <th>Destino</th>
    <th>Mision Encomendada</th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?

	foreach ($datos as $fila)
	{
										
?>
  <tr>
    <td><?=$fila->fecha?></td>
    <td><?=$fila->lugar?></td>
    <td><?=$fila->mision?></td>
    <td><a rel="leanModal" href="#ventana" onclick="dialogo(<?=$fila->id?>)"><img  src="<?=base_url()?>img/lupa.png"/></a>
	</td>
  </tr>
<? } ?>
</tbody>
</table>

<div id="ventana" style="height:600px">
   <form action="<?=base_url()?>index.php/transporte/aprobar_solicitud" id="form" method="post">
    <fieldset>
      <legend align="left">Información de la Solicitud</legend>
       <input type="hidden"   id="resp" name="resp"/>
       <input type="hidden"   id="ids" name="ids"/>
        <p>
        <label>Solicitado por</label>
       <input type="text" id="empleado" readonly  size="50"/>
        </p>
        <p>
        <label>Justificación de la Misión:</label>
       <input type="text" id="mision"  size="70"readonly/>
        </p>
        <p>
        <label>Fecha de Misión:</label>
        <input type="date"  id="fecha" id="fecha" readonly/>Desde <input type="text" id="salida" readonly/>Hasta <input type="text" id="entrada" readonly/>
        </p>
        <p>
        <label>Municipio</label>
        <input type="text" size="20"  id="municipio" readonly/>
        Lugar:<input type="text" size="50"  id="lugar" readonly/>
        </p>
        <p>
        <button  id="aprobar" name="aprobar" onclick="Enviar(3)">Aprobar</button>
        <button  id="denegar" name="Denegar" onclick="Enviar(0)">Denegar</button>
        </p>
    </fieldset>
<form>


</div>
<script language="javascript" >

function dialogo(id){

		$.ajax({
		async:	true, 
		url:	"<?=base_url()?>/index.php/transporte/datos_de_solicitudes/"+id,
		dataType:"json",
		success: function(data){
			 document.getElementById('ids').value=id;
			 document.getElementById('empleado').value=data[0].nombre;
			 document.getElementById('mision').value=data[0].mision;
			 document.getElementById('fecha').value=data[0].fecha;
 			 document.getElementById('salida').value=data[0].salida;
			 document.getElementById('entrada').value=data[0].entrada;
			 document.getElementById('municipio').value=data[0].municipio;
			 document.getElementById('lugar').value=data[0].lugar;
			
			
			},
		error:function(data){
			 alert('Error al cargar datos');
			console.log(data);
			}
		});	
	}
	
	$("#grid").kendoGrid({
		height: 400,
		width: 800,
		sortable: true,
		dataSource: {
			type: "odata",
			pageSize: 5
		},
		pageable: {
			pageSizes: true,
			buttonCount: 5
		},
	});
	
		$(function() {
			$('a[rel*=leanModal]').leanModal({ top : 50 });		
		});
	function Enviar(v){
		document.getElementById('resp').value=v;		
		document.getElementById("form").submit();
	}
</script>