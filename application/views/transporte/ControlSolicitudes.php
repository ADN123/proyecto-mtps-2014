
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
			max-height: 70%;
			padding: 10px; 
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
       <input type="hidden"   id="resp" name="resp"/>
       <input type="hidden"   id="ids" name="ids"/>
       
        <fieldset  >
                <legend align="left">Información del  Solicitante</legend>
                <div id="empleado" style="font-size:14px;"> </div>        
         </fieldset>
         <br />
         <fieldset>      
              <legend align="left">Información de la Solicitud</legend>
               <div  id="mision" style="font-size:14px;"></div>
         </fieldset>
    <p>
        <label for="observacion" id="lobservacion">Observacion</label><br />
        <textarea class="tam-4" id="observacion" tabindex="2" name="observacion"/></textarea>
    </p>
        <button  id="aprobar" name="aprobar" onclick="Enviar(2)">Aprobar</button>
        <button  id="denegar" name="Denegar" onclick="Enviar(0)">Denegar</button>

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

 	var echo1="Nombre: <strong>"+data[0].nombre+"</strong> <br>" +
		       "Seccion: <strong>"+data[0].seccion+"</strong> <br>";
			   
	var echo2="Mision: <strong>"+data[0].mision+"</strong> <br>"+
		       "Fecha: <strong>"+data[0].fecha+"</strong> <br>"+
		       "Salida: <strong>"+data[0].salida+"</strong> <br>"+
		       "Entrada: <strong>"+data[0].entrada+"</strong> <br>"+
			   "Municipio: <strong>"+data[0].municipio+"</strong> <br>"+
			   "Lugar: <strong>"+data[0].lugar+"</strong> <br>";
			
			document.getElementById('empleado').innerHTML=echo1;
			document.getElementById('mision').innerHTML=echo2;
						
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
	
	$("#observacion").validacion({
			req: false,
			lonMin: 10
		});
</script>