<?php
class Transporte extends CI_Controller
{
    
    function Transporte()
	{
        parent::__construct();
		$this->load->model('transporte_model');
		$this->load->library("mpdf");
    	if(!$this->session->userdata('id_usuario')) {
			redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
		$this->solicitud();
  	}
	
	/*
	*	Nombre: solicitud
	*	Objetivo: Carga la vista para la creacion del solicitudes de transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 13/04/2014
	*	Observaciones: Ya no se podrá utilizar esta funcion para modificar (A menos que sepa como mandarle dos variables desde la barra de direcciones).
	*/
	function solicitud($estado_transaccion=NULL,$id_solicitud=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59); /*Verificacion de permiso para crear solicitudes*/
		
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
					$data['empleados']=$this->transporte_model->consultar_empleado($this->session->userdata('nr'));
					foreach($data['empleados'] as $val) {
						$data['info']=$this->transporte_model->info_adicional($val['NR']);
					}
					break;
				case 2:
					$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					$data['empleados']=$this->transporte_model->consultar_empleados_seccion($id_seccion['id_seccion']);
					break;
				case 3:
					$data['empleados']=$this->transporte_model->consultar_empleados();
					break;
				case 4:
					$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					if($id_seccion==52 || $id_seccion==53 || $id_seccion==54 || $id_seccion==55 || $id_seccion==56 || $id_seccion==57 || $id_seccion==58 || $id_seccion==59 || $id_seccion==60 || $id_seccion==61 || $id_seccion==64 || $id_seccion==65 || $id_seccion==66) {
						$data['empleados']=$this->transporte_model->consultar_empleados_seccion($id_seccion['id_seccion']);	
					}
					else {
						$data['empleados']=$this->transporte_model->consultar_empleados_depto();
					}

					break;
			}
			$data['estado_transaccion']=$estado_transaccion;
			$data['solicitud']=$this->transporte_model->consultar_solicitud($id_solicitud,1);
			$data['info']=$this->transporte_model->info_adicional($data['solicitud']['id_empleado_solicitante']);
			$data['solicitud_destinos']=$this->transporte_model->consultar_destinos($data['solicitud']['id_solicitud_transporte']);
			$data['solicitud_acompanantes']=$this->transporte_model->acompanantes_internos($data['solicitud']['id_solicitud_transporte']);
			$data['acompanantes']=$this->transporte_model->consultar_empleados($this->session->userdata('nr'));
			$data['municipios']=$this->transporte_model->consultar_municipios();

			pantalla('transporte/solicitud',$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: control_solicitudes
	*	Objetivo: Control 
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 13/05/2014
	*	Observaciones: Ninguna
	*/
	function control_solicitudes($estado_transaccion=NULL,$accion=NULL)
	{
 		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);

		if(isset($data['id_permiso'])&&$data['id_permiso']>1) {
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$id_seccion_val=$id_seccion['id_seccion'];
				switch ($data['id_permiso']) {
					case 2:
						$data['datos']=$this->transporte_model->solicitudes_por_seccion_estado($id_seccion_val,1);			
						break;
					case 3:
						$data['datos']=$this->transporte_model->todas_solicitudes_por_estado(1);
						break;
					case 4:
							$departamental=$this->transporte_model->is_departamental($id_seccion_val);

						if($departamental){
							$data['datos']=$this->transporte_model->solicitudes_por_seccion_estado($id_seccion_val,1);		
								
						}else{/// para san salvador
								
							$data['datos']=$this->transporte_model->todas_solicitudes_sanSalavador(1);
						}

						break;
				}
				
				$data['estado_transaccion']=$estado_transaccion;
				if($accion==0)
					$data['accion']="denega";
				if($accion==2)
					$data['accion']="aproba";					 
				pantalla('transporte/ControlSolicitudes',$data);
		}
		else 
		{
			echo "No tiene permisos para acceder";
		}
	}
	
	/*
	*	Nombre: datos_de_solictudes
	*	Objetivo: Mostrar informacion General de una mision, a fin de que el Jefe de Unidad o Departamento tenga una aplia vision para aprobar o denegar un solicitud
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 08/04/2014
	*	Observaciones: Cargada mediante Ajax desde la pantalla de control de solicitudes
	*/
	function datos_de_solicitudes($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);
		if(isset($data['id_permiso'])&& $data['id_permiso']>=2 ) {
			$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			$datos['d']=$this->transporte_model->datos_de_solicitudes($id, $id_seccion['id_seccion']);
			$datos['a']=$this->transporte_model->acompanantes_internos($id);
			$datos['f']=$this->transporte_model->destinos($id);
			$datos['observaciones']=$this->transporte_model->observaciones($id);
			$datos['id']=$id;
			$this->load->view('transporte/dialogoAprobacion',$datos);
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: aprobar _solicitud
	*	Objetivo: Registrar la aprobacion hecha por un Jefe de Unidad o Departamento
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 5/03/2014
	*	Observaciones: Ninguna
	*/
	function aprobar_solicitud()
	{
		$data['permiso']=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);
		if($data['permiso']>=2 && $data['permiso']!=NULL){
			$this->db->trans_start();
			$id=$this->input->post('ids'); //id solicitud
			$estado=$this->input->post('resp'); //estado de la solicitud
			$descrip=$this->input->post('observacion'); //Observacion
			$nr=$this->session->userdata('nr'); //NR del usuario Logueado
			
			if($estado ==2 || $estado== 0){
				$this->transporte_model->aprobar($id,$estado, $nr,$this->session->userdata('id_usuario'));
				if($descrip!="")
					$this->transporte_model->insertar_descripcion($id,$descrip,2);
				$this->db->trans_complete();
				ir_a("index.php/transporte/control_solicitudes/".$this->db->trans_status()."/".$estado);
			}
			else {
				$this->db->trans_complete();
				ir_a("index.php/transporte/control_solicitudes/0/0");
			}
		}
		else {
			echo 'No tiene permisos para acceder';
		}	
	}
	
	/*
	*	Nombre: asignar_vehiculo_motorista
	*	Objetivo: Carga la vista de Asignaciones de vehículos y Motoristas
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 23/05/2014
	*	Observaciones: Ninguna
	*/
	function asignar_vehiculo_motorista($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']!=NULL) {
			if($data['id_permiso']==2) {// para solicitudes locales
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$data['datos']=$this->transporte_model->solicitudes_por_asignar($id_seccion['id_seccion']);	
				$data['estado_transaccion']=$estado_transaccion;
				pantalla('transporte/asignacion_veh_mot',$data);
			}
			else if($data['id_permiso']==3) { // Para solicitudes nacionales
				$data['datos']=$this->transporte_model->todas_solicitudes_por_asignar();	
				$data['estado_transaccion']=$estado_transaccion;
				pantalla('transporte/asignacion_veh_mot',$data);
			}
			else if($data['id_permiso']==4) { // Para solicitudes departamentales
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				if($id_seccion['id_seccion']==52 || $id_seccion['id_seccion']==53 || $id_seccion['id_seccion']==54 || $id_seccion['id_seccion']==55 || $id_seccion['id_seccion']==56 || $id_seccion['id_seccion']==57 || $id_seccion['id_seccion']==58 || $id_seccion['id_seccion']==59 || $id_seccion['id_seccion']==60 || $id_seccion['id_seccion']==61 || $id_seccion['id_seccion']==64 || $id_seccion['id_seccion']==65 || $id_seccion['id_seccion']==66) /*Oficina Departamental*/
				{
					$data['datos']=$this->transporte_model->solicitudes_por_asignar($id_seccion['id_seccion']);	
					$data['estado_transaccion']=$estado_transaccion;
				}
				else /*San Salvador*/
				{
					$data['datos']=$this->transporte_model->solicitudes_por_asignar_depto();	
					$data['estado_transaccion']=$estado_transaccion;
				}
				pantalla('transporte/asignacion_veh_mot',$data);
			}
		}
		else
		{
			echo "No tiene permisos para acceder";
		}
	}

	/*
	*	Nombre: cargar_datos_solicitud
	*	Objetivo: Función para cargar datos de solicitudes
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 23/05/2014
	*	Observaciones: Ninguna
	*/
	function cargar_datos_solicitud($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']!=NULL) {
			if($data['id_permiso']>2) {
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$d=$this->transporte_model->datos_de_solicitudes($id, $id_seccion['id_seccion']);
				$a=$this->transporte_model->acompanantes_internos($id);
				$f=$this->transporte_model->destinos($id);
				$observaciones=$this->transporte_model->observaciones($id);
				
				$solicitud_actual=$this->transporte_model->consultar_fecha_solicitud($id);
				//////////consulta la fecha, hora de entrada, y hora de salida de la solicitud actual, para luego compararla con otras solicitudes ya aprobadas.					
				foreach($solicitud_actual as $row) {
					$fecha=$row->fecha;
					$entrada=$row->entrada;
					$salida=$row->salida;
				}
				
				if($id_seccion['id_seccion']==52 || $id_seccion['id_seccion']==53 || $id_seccion['id_seccion']==54 || $id_seccion['id_seccion']==55 || $id_seccion['id_seccion']==56 || $id_seccion['id_seccion']==57 || $id_seccion['id_seccion']==58 || $id_seccion['id_seccion']==59 || $id_seccion['id_seccion']==60 || $id_seccion['id_seccion']==61 || $id_seccion['id_seccion']==64 || $id_seccion['id_seccion']==65 || $id_seccion['id_seccion']==66)//Oficinas departamentales//
				{
					$vehiculos_disponibles=$this->transporte_model->vehiculos_disponibles($fecha,$entrada,$salida,$id_seccion['id_seccion']);
					/*aquí se comparan la fecha, hora de entrada y de salida de la solicitud actual con las que ya tiene vehículo asignado, para mostrar únicamente los posibles vehiculos a utilizar */
				}
				else if($data['id_permiso']==4)
				{
					$vehiculos_disponibles=$this->transporte_model->vehiculos_disponibles_central($fecha,$entrada,$salida);
					/*aquí se comparan la fecha, hora de entrada y de salida de la solicitud actual con las que ya tiene vehículo asignado, para mostrar únicamente los posibles vehiculos a utilizar */
				}
				else if($data['id_permiso']==3)
				{
					$vehiculos_disponibles=$this->transporte_model->vehiculos_disponibles_nacional($fecha,$entrada,$salida);
					/*aquí se comparan la fecha, hora de entrada y de salida de la solicitud actual con las que ya tiene vehículo asignado, para mostrar únicamente los posibles vehiculos a utilizar */
				}
								
				echo 
				"
				<form id='form' action='".base_url()."index.php/transporte/asignar_veh_mot' method='post'>
				<input type='hidden' id='resp' name='resp' />
				<input type='hidden' name='id_solicitud' value='".$id."' />
				
				<fieldset>      
					<legend align='left'>Información de la Solicitud</legend>
					";
					foreach($d as $datos)
					{
						$nombre=ucwords($datos->nombre);
						$seccion=ucwords($datos->seccion);
						$fechaS=$datos->fechaS;
						$fechaM=$datos->fechaM;
						$salida=$datos->salida;
						$entrada=$datos->entrada;
						$requiere=$datos->req;
						$acompanante=ucwords($datos->acompanante);
						$id_empleado=$datos->id_empleado_solicitante;
					}
				
				echo "Nombre: <strong>".$nombre."</strong> <br>
				Sección: <strong>".$seccion."</strong> <br>
				Fecha de Solicitud: <strong>".$fechaS."</strong> <br>
				Fecha de Misión: <strong>".$fechaM."</strong> <br>
				Hora de Salida: <strong>".$salida."</strong> <br>
				Hora de Regreso: <strong>".$entrada."</strong> <br>
				
				</fieldset>
				<br />";
	?>
    	<fieldset>
        <legend align='left'>Observaciones</legend>
		<?php
            if(count($observaciones)!=0)
            foreach($observaciones as $val) {
                switch($val['quien_realiza']) {
                    case 1:
                        $quien="Por parte del solicitante";
                        break;
                    case 2:
                        $quien="Por parte del Jefe de Departamento o Secci&oacute;n";
                        break;
                    case 3:
                        $quien="Por parte del Jefe de Servicios Generales";
                        break;
                    default:
                        $quien="General";
                }
                echo $quien.":<br><li><strong>".$val['observacion'].".</strong></li><br>";					
            }
            if(count($observaciones)==0)
                echo "<strong>(No hay observaciones)</strong>";
		?>
        </fieldset>
	<?php
            
    echo "<br />
				
				<fieldset>
				<legend align='left'>Destinos</legend>
				
				<table cellspacing='0' align='center' class='table_design'>
						<thead>
							<th>
								Municipio
							</th>
							<th>
								Lugar de destino
							</th>
							<th>
								Dirección
							</th>
							<th>
								Misión Encomendada
							</th>
						</thead>
						<tbody>
							";
							foreach($f as $r)
							{
								echo "<tr><td>".$r->municipio."</td>";
								echo "<td>".$r->destino."</td>";
								echo "<td>".$r->direccion."</td>";
								echo "<td>".$r->mision."</td></tr>";
							}
						echo "
						</tbody>
					</table>
				
				</fieldset>
				
			    <br />
			   
				<fieldset>
					<legend align='left'>Acompañantes</legend>
					
					";
					foreach($a as $acompa)
					{
						echo "<strong>".ucwords($acompa->nombre)."</strong> <br />";
					}
					echo "<strong>".$acompanante."</strong>";
					if(count($acompa)==0 && $acompanante=="")
						echo "<strong>(No hay acompa&ntilde;antes)</strong>";
				echo "
				</fieldset>
				<br>
				<fieldset>
				<legend align='left'>Informaci&oacute;n del Vehículo</legend>
					<p>
					<label>N&deg; Placa</label>
				   <select class='select' name='vehiculo' id='vehiculo' style='width:100px;' onchange='motoristaf(this.value,".$id.")'>
				   ";
				   
					foreach($vehiculos_disponibles as $v) {
						/*echo "<option value='".$v->id_vehiculo."'>".$v->placa." - ".$v->nombre." - ".$v->modelo."</option>";*/
						echo "<option value='".$v->id_vehiculo."'>".$v->placa."</option>";
					}
				   
				   echo "    
				   </select>
					</p>   
				</fieldset>
				<br>
				<fieldset>
					<legend align='left'>Informaci&oacute;n del Motorista</legend>
				";
				if($requiere==1) {
				echo "
						<label>Nombre</label>
						<div id='cont-select' style='width:350px; display:inline-block;'>
							<select name='motorista' id='motorista'>
							</select>
						</div>
					";
				}
				else {
					echo "Nombre: <strong>".$nombre."</strong>";
					echo "<input type='hidden' name='motorista' value='".$id_empleado."'>";
				}
				echo "
					</fieldset>
				 
       	<br>
		<fieldset>
			<legend align='left'>Informaci&oacute;n  Adicional</legend>
					<label for='observacion' id='lobservacion' class='label_textarea'>Observación</label>
					<textarea class='tam-4' id='observacion' tabindex='2' name='observacion'/></textarea>
				</fieldset>
				<p style='text-align: center;'>
					<button type='submit' id='asignar' name='asignar' class='boton_validador' onclick='enviar(3)'>Asignar</button>
				</p>
				</form>
				";
				
				echo "<script>
					$('select').prepend('<option value=\"\" selected=\"selected\"></option>');
					$('.select').kendoComboBox({
						autoBind: false,
						filter: 'contains'
					});
					$('#vehiculo').validacion({
						men: 'Debe seleccionar un item'
					});";
				if($requiere==1)
					echo "$('#motorista').kendoComboBox({
							autoBind: false,
							filter: 'contains',
							enable: false
						});";

				echo "$('#observacion').validacion({
						req: false,
						lonMin: 10
					});
				</script>";
			}
		}
		else
		{
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: verificar_motoristas
	*	Objetivo: Función para conocer el motorista que se ha de asignar a la misión oficial
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 23/05/2014
	*	Observaciones: Ninguna
	*/
	function verificar_motoristas($id_vehiculo,$id_solicitud_actual)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
		if($data['id_permiso']!=NULL) {
			if($data['id_permiso']>2) {
				$datos_actual=$this->transporte_model->consultar_fecha_solicitud($id_solicitud_actual);
				
				foreach($datos_actual as $da) {
					$fecha==$da->fecha;
					$salida==$da->salida;
					$entrada==$da->entrada;
				}
				
				$vehiculo_mision_local=$this->transporte_model->vehiculo_en_mision_local($fecha,$salida,$entrada,$id_vehiculo);
				
				if($vehiculo_mision_local!=0) { ///el vehiculo se encuentra en mision local
					echo "El vehículo se encuentra reservado para esta hora";
				}
				
				if($id_seccion['id_seccion']==52 || $id_seccion['id_seccion']==53 || $id_seccion['id_seccion']==54 || $id_seccion['id_seccion']==55 || $id_seccion['id_seccion']==56 || $id_seccion['id_seccion']==57 || $id_seccion['id_seccion']==58 || $id_seccion['id_seccion']==59 || $id_seccion['id_seccion']==60 || $id_seccion['id_seccion']==61 || $id_seccion['id_seccion']==64 || $id_seccion['id_seccion']==65 || $id_seccion['id_seccion']==66)//Oficinas departamentales//
				{
					$motoristas=$this->transporte_model->consultar_motoristas($id_vehiculo,$id_seccion['id_seccion']);
					//////////consulta al motorista asignado al vehiculo.
					////////// y muestra los posibles motoristas de acuerdo a la oficina departamental
				}
				else if($data['id_permiso']==4)
				{
					$motoristas=$this->transporte_model->consultar_motoristas_central($id_vehiculo);
					//////////consulta al motorista asignado al vehiculo.
					////////// y muestra los posibles motoristas de acuerdo a la central
				}
				else if($data['id_permiso']==3)
				{
					$motoristas=$this->transporte_model->consultar_motoristas_nacional($id_vehiculo);
					//////////consulta al motorista asignado al vehiculo.
					////////// y muestra todos los posibles motoristas del mtps
				}
				
				$j=json_encode($motoristas);
				echo $j;
			}
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}

	/*
	*	Nombre: asignar_veh_mot
	*	Objetivo: Función para registrar una asignación de vehículo con su correspondiente motorista
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 25/05/2014
	*	Observaciones: Ninguna
	*/
	
	function asignar_veh_mot()
	{
		$data['permiso']=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		
		if($data['permiso']!=NULL) {
			if($data['permiso']>=2) {
				$this->db->trans_start();
				$id_solicitud=$this->input->post('id_solicitud');//id_solicitud
				$id_vehiculo=$this->input->post('vehiculo'); //id_vehiculo
				$id_motorista=$this->input->post('motorista'); //estado de la solicitud
				$estado=$this->input->post('resp');//futurp estado de la solicitud
				$fecha_m=date('Y-m-d H:i:s');
				$nr=$this->session->userdata('nr'); //NR del usuario Logueado
				$observaciones=$this->input->post('observacion');//observación, si es que hay
				
				if($estado==3) {
					$this->transporte_model->asignar_veh_mot($id_solicitud,$id_motorista,$id_vehiculo, $estado, $fecha_m,$nr,$this->session->userdata('id_usuario'));
					
					if($observaciones!="") $this->transporte_model->insertar_descripcion($id_solicitud,$observaciones,3);
					$this->db->trans_complete();
					ir_a("index.php/transporte/asignar_vehiculo_motorista/".$this->db->trans_status());
				}
				else {
					ir_a("index.php/transporte/asignar_vehiculo_motorista/0");
				}
			}
		}
		else {
			echo 'No tiene permisos para acceder';
		}	
	}


	/*
	*	Nombre: buscar_info_adicional
	*	Objetivo: Mostrar la informacion del puesto del empleado que necesita el transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 01/04/2014
	*	Observaciones: Ninguna
	*/
	function buscar_info_adicional()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59); /*Verificacion de permiso para crear solicitudes*/
		
		if($data['id_permiso']!=NULL) {
			$id_empleado=$this->input->post('id_empleado');
			$data=$this->transporte_model->info_adicional($id_empleado);
			if($data['nr']!='0') {
				$json =array(
					'estado'=>1,
					'nr'=>$data['nr'],
					'id_seccion'=>$data['id_seccion'],
					'funcional'=>$data['funcional'],
					'nominal'=>$data['nominal'],
					'nivel_1'=>$data['nivel_1'],
					'nivel_2'=>$data['nivel_2'],
					'nivel_3'=>$data['nivel_3']
				);
			}
			else {
				$json =array(
					'estado'=>0
				);
			}
			echo json_encode($json);
		}
		else {
			$json =array(
				'estado'=>0
			);
			echo json_encode($json);
		}
	}
	
	/*
	*	Nombre: guardar_solicitud
	*	Objetivo: Guardar el formulario de solicitud de transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 01/04/2014
	*	Observaciones: Ninguna
	*/
	function guardar_solicitud()
	{	
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59); /*Verificacion de permiso para crear solicitudes*/
		
		if($data['id_permiso']!=NULL) {
			$this->db->trans_start();
			
			$id_solicitud_old=$this->input->post('id_solicitud_old');
			
			if($id_solicitud_old!="") {
				$this->transporte_model->eliminar_solicitud($id_solicitud_old);
			}
			
			$fec=str_replace("/","-",$this->input->post('fecha_mision'));
			$fecha_solicitud_transporte=date('Y-m-d');
			$id_empleado_solicitante=(int)$this->input->post('nombre');
			$fecha_mision=date("Y-m-d", strtotime($fec));
			$hora_salida=date("H:i:s", strtotime($this->input->post('hora_salida')));
			$hora_entrada=date("H:i:s", strtotime($this->input->post('hora_regreso')));
			if($this->input->post('requiere_motorista')!="")
				$requiere_motorista=$this->input->post('requiere_motorista');
			else
				$requiere_motorista=0;
			$observaciones=$this->input->post('observaciones');
			$acompanante=$this->input->post('acompanantes2');
			$id_usuario_crea=$this->session->userdata('id_usuario');
			$fecha_creacion=date('Y-m-d H:i:s');
			$estado_solicitud_transporte=1;
			
			$formuInfo = array(
				'fecha_solicitud_transporte'=>$fecha_solicitud_transporte,
				'id_empleado_solicitante'=>$id_empleado_solicitante,
				'fecha_mision'=>$fecha_mision,
				'hora_salida'=>$hora_salida,
				'hora_entrada'=>$hora_entrada,
				'requiere_motorista'=>$requiere_motorista,
				'acompanante'=>$acompanante,
				'id_usuario_crea'=>$id_usuario_crea,
				'fecha_creacion'=>$fecha_creacion,
				'estado_solicitud_transporte'=>$estado_solicitud_transporte
			);
			
			$id_solicitud_transporte=$this->transporte_model->guardar_solicitud($formuInfo); /*Guardando la solicitud*/
			$acompanantes=$this->input->post('acompanantes');
			for($i=0;$i<count($acompanantes);$i++) {
				$formuInfo = array(
					'id_solicitud_transporte'=>$id_solicitud_transporte,
					'id_empleado'=>$acompanantes[$i]
				);
				$this->transporte_model->guardar_acompanantes($formuInfo); /*Guardando acompañantes*/
			}
			$destinos=$this->input->post('values');
			for($i=0;$i<count($destinos);$i++) {
				$campos=explode("**",$destinos[$i]);
				if(isset($campos[1])) {
					$formuInfo = array(
						'id_solicitud_transporte'=>$id_solicitud_transporte,
						'id_municipio'=>$campos[0],
						'lugar_destino'=>$campos[1],
						'direccion_destino'=>$campos[2],
						'mision_encomendada'=>$campos[3]

					);
					$this->transporte_model->guardar_destinos($formuInfo); /*Guardando destinos*/
				}
			}
			
			if($observaciones!="")
				$this->transporte_model->insertar_descripcion($id_solicitud_transporte,$observaciones, 1); /*Guardando observaciones*/
			
			$this->db->trans_complete();
			if($id_solicitud_old!="") {
				ir_a('index.php/transporte/ver_solicitudes/'.$this->db->trans_status());
			}
			else {
				ir_a('index.php/transporte/solicitud/'.$this->db->trans_status());
			}
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	/*
	*	Nombre: control de entradas y salidas
	*	Objetivo: Mostrar la salida o ingreso de un vehiculo
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 08/04/2014
	*	Observaciones: Falta mostrar datos segun el permiso que posea
	*/
	function control_salidas_entradas($estado_transaccion=NULL,$accion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),64);

		if(isset($data['id_permiso'])&&$data['id_permiso']>1) {
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$id_seccion_val=$id_seccion['id_seccion'];
				switch ($data['id_permiso']) {
					case 2:
						$data['datos']=$this->transporte_model->salidas_entradas_vehiculos_seccion($id_seccion_val);
						print_r($id_seccion_val.$data['datos']);
						break;
					case 3:
						$data['datos']=$this->transporte_model->salidas_entradas_vehiculos();
						break;
					case 4:
							$departamental=$this->transporte_model->is_departamental($id_seccion_val);

						if($departamental){
							$data['datos']=$this->transporte_model->salidas_entradas_vehiculos_seccion($id_seccion_val);
								
						}else{/// para san salvador
								
							$data['datos']=$this->transporte_model->salidas_entradas_vehiculos_SanSalvador();
						}

						break;
				}
				
			$data['estado_transaccion']=$estado_transaccion;
			if($accion==3)
				$data['accion']="salida";
			if($accion==4)
				$data['accion']="entrada";	 
			pantalla("transporte/despacho",$data);	
		}
		else 
		{
			echo "No tiene permisos para acceder";
		}

	}
	/*
	*	Nombre: Cargar Accesorios
	*	Objetivo: cargar una lista de cheakbox para selccionar los accesorios que un vehiculo lleva
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 10/05/2014
	*	Observaciones: Falta mostrar datos segun el permiso que posea
	*/
	function accesoriosABordo($id_solicitud_transporte,$estado)
	{
		if ($estado==3) {//en caso de salida se puede seleccionar todos los accesorios
			$data['accesorios']=$this->transporte_model->accesorios();					
		} else {
			if ($estado==4) {//si viene de regrese unicamente muestra los accesorios con los que salio
					$data['accesorios']=$this->transporte_model->accesoriosABordo($id_solicitud_transporte);					
				}	
		}
		

			$this->load->view("transporte/accesorios",$data);
		

	}

	/*
	*	Nombre: guardar_despacho
	*	Objetivo: Registrar la salida o ingreso de un vehiculo
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 08/04/2014
	*	Observaciones: Ninguna
	*/
	function guardar_despacho()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),64);
		
		if($data['id_permiso']!=NULL) {
			$this->db->trans_start();
			$estado=$this->input->post('estado');
			$id=$this->input->post('id');
			$km=$this->input->post('km');
			$gas=$this->input->post('gas');
			$hora=date("H:i:s", strtotime($this->input->post('hora')));
	
			/*remuevo de post los datos para que solo queden los accesorios*/

			$acces=$_POST;
			unset($acces['estado']);
			unset($acces['gas']);
			unset($acces['id']);
			unset($acces['km']);
			unset($acces['hora']);
			
			if($estado==3){
				$this->transporte_model->salida_vehiculo($id, $km,$hora,$acces);

			}
			else {
				
				if($estado==4) {
				$this->transporte_model->regreso_vehiculo($id, $km, $hora, $gas,$acces);		
			  

				}
			}
			$this->db->trans_complete();
			ir_a('index.php/transporte/control_salidas_entradas/'.$this->db->trans_status()."/".$estado);	
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
		
	/*
	*	Nombre: infoSolicitud
	*	Objetivo: Ver datos de interes para el encargado de despacho sobre la mision
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 23/03/2014
	*	Observaciones: Falta llevar el control de permiso para ver esta informacion
	*/
	function infoSolicitud($id)
	{		
		$d=$this->transporte_model->infoSolicitud($id);	
		$j=json_encode($d);
		echo $j;
	}
	
	/*
	*	Nombre: kilometraje
	*	Objetivo: Extraer el kilometraje recorrido de un vehiculo
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 26/03/2014
	*	Observaciones: Falta llevar el control de permiso para ver esta informacion
	*/
	function kilometraje($id)
	{
		$d=$this->transporte_model->kilometraje($id);	
		$j=json_encode($d);
		echo $j;				
	}
	
	/*
	*	Nombre: ver_solicitudes
	*	Objetivo: Ver el estado actual de las solicitudes. Permite editar o eliminar solicitudes
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 15/03/2014
	*	Observaciones: Ninguna
	*/
	function ver_solicitudes($estado_transaccion=NULL)
	{ 

							
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),61);

		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) {
				case 1:
					$empleado=$this->transporte_model->consultar_empleado($_SESSION['nr']);
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes($empleado[0]['NR'], 1);
					break;
				case 2:
					$seccion=$this->transporte_model->consultar_seccion_usuario($_SESSION['nr']);
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes(NULL, 1, $seccion['id_seccion']);
					break;
				case 3:
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes(NULL,1);
					break;
				case 4:
					$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					if($id_seccion==52 || $id_seccion==53 || $id_seccion==54 || $id_seccion==55 || $id_seccion==56 || $id_seccion==57 || $id_seccion==58 || $id_seccion==59 || $id_seccion==60 || $id_seccion==61 || $id_seccion==64 || $id_seccion==65 || $id_seccion==66) {
						$data['solicitudes']=$this->transporte_model->buscar_solicitudes(NULL, 1, $id_seccion['id_seccion']);
					}
					else {
						$data['solicitudes']=$this->transporte_model->buscar_solicitudes_depto(1);	
					}
					break;
			}
			$data['estado_transaccion']=$estado_transaccion;
			
			pantalla("transporte/ver_solicitudes",$data);	
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	
	/*
	*	Nombre: eliminar_solicitud
	*	Objetivo: Elimina (desactiva) una solicitud de transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 15/03/2014
	*	Observaciones: Ninguna
	*/
	function eliminar_solicitud($id_solicitud)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),61);
		
		if($data['id_permiso']!=NULL) {
			$this->db->trans_start();
			$this->transporte_model->eliminar_solicitud($id_solicitud);
			$this->db->trans_complete();
			redirect('index.php/transporte/ver_solicitudes/'.$this->db->trans_status());
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	
	/*
	*	Nombre: reporte_solicitud
	*	Objetivo: Muestra solicitudes que ya tienen asignado vehiculo y motorista. Permite exportar a pdf
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 01/04/2014
	*	Observaciones: Ninguna
	*/
	function reporte_solicitud()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),66);
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) {
				case 1:
					$empleado=$this->transporte_model->consultar_empleado($this->session->userdata('nr'));
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes($empleado[0]['NR'],3,NULL);
					break;
				case 2:
					$seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes(NULL,3,$seccion['id_seccion']);
					break;
				case 3:
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes(NULL,3,NULL);
					break;
				case 4:
					$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					if($id_seccion==52 || $id_seccion==53 || $id_seccion==54 || $id_seccion==55 || $id_seccion==56 || $id_seccion==57 || $id_seccion==58 || $id_seccion==59 || $id_seccion==60 || $id_seccion==61 || $id_seccion==64 || $id_seccion==65 || $id_seccion==66) {
						$data['solicitudes']=$this->transporte_model->buscar_solicitudes(NULL, 3, $id_seccion['id_seccion']);
					}
					else {
						$data['solicitudes']=$this->transporte_model->buscar_solicitudes_depto(3);
					}
					break;
			}
			pantalla("transporte/reporte_solicitudes",$data);	
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	
	/*
	*	Nombre: solicitud_pdf
	*	Objetivo: Genera una archivo pdf de una solicitud
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 13/04/2014
	*	Observaciones: Ninguna
	*/
	function solicitud_pdf($id) 
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),66);
		if($data['id_permiso']!=NULL) {
			$data['info_solicitud']=$this->transporte_model->consultar_solicitud($id);
			$id_solicitud_transporte=$data['info_solicitud']['id_solicitud_transporte'];
			$id_empleado_solicitante=$data['info_solicitud']['id_empleado_solicitante'];
			$id_empleado_autoriza=$data['info_solicitud']['id_empleado_autoriza'];
			$data['info_empleado']=$this->transporte_model->info_adicional($id_empleado_solicitante);
			$data['info_empleado2']=$this->transporte_model->info_adicional($id_empleado_autoriza);
			$data['acompanantes']=$this->transporte_model->acompanantes_internos($id_solicitud_transporte);
			$data['destinos']=$this->transporte_model->destinos($id_solicitud_transporte);
			$data['salida_entrada_real']=$this->transporte_model->datos_salida_entrada_real($id_solicitud_transporte);
			$data['motorista_vehiculo']=$this->transporte_model->datos_motorista_vehiculo($id_solicitud_transporte);
			$data['observaciones']=$this->transporte_model->observaciones($id_solicitud_transporte);
			/*$this->load->view('transporte/solicitud_pdf.php',$data);*/
			
			$this->mpdf->mPDF('utf-8','letter',0, '', 4, 4, 6, 6, 9, 9); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
			$stylesheet = file_get_contents('css/pdf/solicitud.css'); /*Selecionamos la hoja de estilo del pdf*/
			$this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
			$data['nombre'] = "Renatto NL";
			$html = $this->load->view('transporte/solicitud_pdf.php', $data, true); /*Seleccionamos la vista que se convertirá en pdf*/
			$this->mpdf->WriteHTML($html,2); /*la escribimos en el pdf*/
			if(count($data['destinos'])>1) { /*si la solicitud tiene varios detinos tenemos que crear otra hoja en el pdf y escribirlos allí*/
				$this->mpdf->AddPage();
				$html = $this->load->view('transporte/reverso_solicitud_pdf.php', $data, true);
				$this->mpdf->WriteHTML($html,2);
			}
			$this->mpdf->Output(); /*Salida del pdf*/
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
}
?>