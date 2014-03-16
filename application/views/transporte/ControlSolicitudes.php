
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
                <div id="empleado" style="font-size:12px;"> </div>        
         </fieldset>
         
         <fieldset>      
              <legend align="left">Información de la Solicitud</legend>
               <label  id="mision"></label>
         </fieldset>
            
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
/*			 document.getElementById('ids').value=id;
			 document.getElementById('empleado').innerHTML =data[0].nombre;
			 document.getElementById('mision').innerHTML=data[0].mision;
			 document.getElementById('fecha').innerHTML=data[0].fecha;
 			 document.getElementById('salida').innerHTML=data[0].salida;
			 document.getElementById('entrada').innerHTML=data[0].entrada;
			 document.getElementById('municipio').innerHTML=data[0].municipio;
			 document.getElementById('lugar').innerHTML=data[0].lugar;
*/
 	var echo1="Nombre: <strong>"+data[0].nombre+"</strong> <br>";
			
			document.getElementById('empleado').innerHTML=echo1;
						
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