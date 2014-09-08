<?php 

                foreach($d as $datos)
                {
                    $nombre=$datos->nombre;
                    $id_seccion=$datos->id_seccion_vale;
                    $id_fuente_fondo=$datos->id_fuente_fondo;
                    $descripcion=$datos->descripcion;
                    $id=$datos->id_herramienta;
                    $seccion=$datos->seccion;
                    $combustible=$datos->combustible;
                }



?>

<form id='form' action="<?php echo base_url()?>index.php/vales/modificar_herramienta" method='post'>
            <input  id='id' tabindex='3' name='id' value="<?php echo $id;?>" type="hidden" />

    <fieldset>      
        <legend align='left'>Información de asginación</legend>    
          <p> 
                <label for="id_fuente_fondo" id="lid_fuente_fondo">Fuente de Fondo </label>
                <select class="select" style="width:200px;" tabindex="1" id="id_fuente_fondo" name="id_fuente_fondo" onChange="recargar_seccion(this.value)"  >
                    <?php
                        foreach($fuente as $val) {
                    ?>
                       <option value="<?php echo $val['id_fuente_fondo'] ?>" 
                        <?php if($id_fuente_fondo==$val['id_fuente_fondo']){  echo " selected";}?>
                        ><?php echo $val['nombre_fuente'] ?></option>
                    <?php   
                        }
                    ?>
                </select>
            </p>        
            <p>
                <label for="id_seccion" id="lservicio_de">Sección</label>
                 <input id="id_seccion" name="id_seccion" class="tam-3" />  
            </p>
</fieldset>      
<fieldset>      
        <legend align='left'>Información adicional</legend>
    
        <p>
            <label for="nombre" id="lnombre" class="tam-1" >Nombre</label>
            <input class="tam-2" id='nombre' tabindex='3' name='nombre' type="text"  value="<?php echo $nombre;?>"/>
        </p>
         <p>

            <label for="combustible" id="lcombustible" class="tam-1">Combustible</label>
            <select class="tam-1" name="combustible" id="combustible">
                <option value="Gasolina" <?php if($combustible=="Gasolina"){  echo " selected";}?> >Gasolina</option>             
                <option value="Diesel"   <?php if($combustible=="Diesel"){  echo " selected";}?> >Diesel</option>
            </select>  
        </p>
        <p>

            <label for="descripcion" id="ldescripcion" class="label_textarea">Descripción</label>
            <textarea class="tam-3" id='descripcion' tabindex='4' name='descripcion' ><?php echo $descripcion;?></textarea>
        </p>
    

 </fieldset>
    <br />
    

    <p style='text-align: center;'>
    	<button type="submit"  id="aprobar" class="button tam-1 boton_validador"  onclick="Enviar(2)" tabindex='3' >Guardar</button>
    </p>
</form>
<script>
    $("#nombre").validacion({
        lonMin: 5
    });
    $("#descripcion").validacion({
         lonMin: 5,
         req: false
        });
    $("#id_seccion").kendoDropDownList();

    $("#id_fuente_fondo").kendoDropDownList();
    $("#combustible").kendoDropDownList();
    function recargar_seccion(id_fuente_fondo) {
var combo;
        $.ajax({
            async:  true, 
            url:    base_url()+"index.php/vales/seccion_vale/"+id_fuente_fondo,
            dataType:"json",
            success: function(data){
              console.log(data);
                       
                               // create DropDownList from input HTML element
          combo= $("#id_seccion").kendoDropDownList({
                        dataTextField: "nombre_seccion",
                        dataValueField: "id_seccion",
                        dataSource: data,
                        value: <?php echo $id_seccion;?>
                    });

                },
            error:function(data){              

               alertify.alert('Error al cargar datos');
         
                }
        });    

    }
    recargar_seccion(document.getElementById('id_fuente_fondo').value);

</script>