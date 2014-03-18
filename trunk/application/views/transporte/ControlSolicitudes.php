<section>
    <h2>Control de Solicitudes</h2>
</section>
<table  class="grid">
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
    <td><a title="Ver solicitud" rel="leanModal" href="#ventana" onclick="dialogo(<?=$fila->id?>)"><img  src="<?=base_url()?>img/lupa.gif"/></a>
	</td>
  </tr>
<? } ?>
</tbody>
</table>

<div id="ventana" style="height:600px">
	<div id="signup-header">
        <h2>Solicitud de Misi&oacute;n Oficial</h2>
        <a class="modal_close"></a>
    </div>
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
        <button type="submit"  id="aprobar" class="button tam-1 boton_validador" name="aprobar" onclick="Enviar(2)">Aprobar</button>
        <button  type="submit" id="denegar" class="button tam-1 boton_validador" name="Denegar" onclick="Enviar(0)">Denegar</button>

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
	
	function Enviar(v){
		document.getElementById('resp').value=v;
	}
	
	$("#observacion").validacion({
			req: false,
			lonMin: 10
		});
</script>