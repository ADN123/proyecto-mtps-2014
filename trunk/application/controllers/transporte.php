<?php
class Transporte extends CI_Controller
{
    
    function Transporte()
	{
        parent::__construct();
		$this->load->model('transporte_model');
		$this->load->library("mpdf");
    	if(!$this->session->userdata('id_usuario')){
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
	function solicitud($estado_transaccion=NULL)
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
			}
			$data['estado_transaccion']=$estado_transaccion;
			//$data['solicitud']=$this->transporte_model->consultar_solicitud($id_solicitud);
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
	*	Modificada por: Jhonatan
	*	Última Modificación: 08/04/2014
	*	Observaciones: 
	*/
	function control_solicitudes()
	{
 		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);
		
		//echo $data['id_permiso'];
		if(isset($data['id_permiso'])&&$data['id_permiso']>1) {
			if($data['id_permiso']>2){//nivel 3
				$data['datos']=$this->transporte_model->todas_solicitudes_por_confirmar();
			}
			else {//nivel 2
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$data['datos']=$this->transporte_model->solicitudes_por_confirmar($id_seccion['id_seccion']);			
			}	 
			pantalla('transporte/ControlSolicitudes',$data);
		}
		else {//nivel 1
			echo " No tiene permisos para acceder";
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
		if(isset($data['id_permiso'])&&$data['id_permiso']>=2 ) {
			$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			$datos['d']=$this->transporte_model->datos_de_solicitudes($id, $id_seccion['id_seccion']);
			$datos['a']=$this->transporte_model->acompanantes_internos($id);
			$datos['f']=$this->transporte_model->destinos($id);
			$datos['id']=$id;
			$this->load->view('transporte/dialogoAprobacion',$datos);
		}
		else {
			echo ' No tiene permiso';
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
		if($data['permiso']>=2){
			$id=$this->input->post('ids'); //id solicitud
			$estado=$this->input->post('resp'); //estado de la solicitud
			$descrip=$this->input->post('observacion'); //Observacion
			$nr=$this->session->userdata('nr'); //NR del usuario Logueado
			
			if($estado ==2 || $estado== 0){
				$this->transporte_model->aprobar($id,$estado, $nr,$this->session->userdata('id_usuario'));
				if($descrip!="")
					$this->transporte_model->insertar_descripcion($id,$descrip);
				ir_a("index.php/transporte/control_solicitudes");
			}
			else {
				echo'Datos corruptos';
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
	*	Última Modificación: 01/04/2014
	*	Observaciones: Ninguna
	*/
	function asignar_vehiculo_motorista()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']!=NULL) {
			if($data['id_permiso']>=2) {
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$data['datos']=$this->transporte_model->solicitudes_por_asignar($id_seccion);
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
	*	Última Modificación: 09/04/2014
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
				
				$solicitud_actual=$this->transporte_model->consultar_fecha_solicitud($id);
				//////////consulta la fecha, hora de entrada, y hora de salida de la solicitud actual, para luego compararla con otras solicitudes ya aprobadas.					
				foreach($solicitud_actual as $row) {
					$fecha=$row->fecha;
					$entrada=$row->entrada;
					$salida=$row->salida;
				}
				
				/*aquí se comparan la fecha, hora de entrada y de salida de la solicitud actual con las que ya tiene vehículo asignado, para mostrar únicamente los posibles vehiculos a utilizar */
				$vehiculos_disponibles=$this->transporte_model->vehiculos_disponibles($fecha,$entrada,$salida);
								
				echo 
				"
				<div id='signup-header'>
				<h2>Asignaci&oacute;n de Veh&iacute;culos y Motoristas</h2>
				<a class='cerrar-modal'></a>
				</div>
				<div id='contenido-ventana'>
				<form id='form' action='".base_url()."index.php/transporte/asignar_veh_mot' method='post'>
				<input type='hidden' id='resp' name='resp' />
				<input type='hidden' name='id_solicitud' value='".$id."' />
				
				<fieldset>      
					<legend align='left'>Información de la Solicitud</legend>
					";
					foreach($d as $datos)
					{
						$nombre=ucwords($datos->nombre);
						$seccion=$datos->seccion;
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
				<br />
				
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
				
			   <br>
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
				<legend align='left'>Vehículos</legend>
					<p>
					<label>Información:</label>
				   <select class='select' name='vehiculo' id='vehiculo' onchange='motoristaf(this.value,".$id.")'>
				   ";
				   
					foreach($vehiculos_disponibles as $v)
					{
						echo "<option value='".$v->id_vehiculo."'>".$v->placa." - ".$v->nombre." - ".$v->modelo."</option>";
					}
				   
				   echo "    
				   </select>
					</p>   
				</fieldset>
				<br>
				<fieldset>
					<legend align='left'>Motorista</legend>
						<p>
						<label>Nombre:</label>
				";
				if($requiere==1) {
				echo "
					   <select name='motorista' id='motorista'>
					   </select>
					";
				}
				else {
					echo "<strong>".$nombre."</strong>";
					echo "<input type='hidden' name='motorista' value='".$id_empleado."'>";
				}
				echo "
				</p>
					</fieldset>
				 
       	<br>
		<fieldset>
			<legend align='left'>Adicional</legend>
					<label for='observacion' id='lobservacion' class='label_textarea'>Observación</label>
					<textarea class='tam-4' id='observacion' tabindex='2' name='observacion'/></textarea>
				</fieldset>
				<p style='text-align: center;'>
					<button type='submit' id='asignar' name='asignar' onclick='enviar(3)'>Asignar</button>
				</p>
				</form>
				</div>
				";
				
				echo "<script>
					$('select').prepend('<option value=\"\" selected=\"selected\"></option>');
					$('.select').kendoComboBox({
						autoBind: false,
						filter: 'contains'
					});
					$('.cerrar-modal').click(function(){
						$('.modal_close').click();
					});
					/*$('#motorista').kendoComboBox({
						autoBind: false,
						filter: 'contains'
					})
					var se=$('motorista').data('kendoComboBox');
					se.destroy();*/
				</script>";
			}
		}
		else
		{
			echo ' No tiene permiso';
		}
	}
	
	/*
	*	Nombre: verificar_motoristas
	*	Objetivo: Función para conocer el motorista que se ha de asignar a la misión oficial
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 09/04/2014
	*	Observaciones: Ninguna
	*/
	function verificar_motoristas($id_vehiculo,$id_solicitud_actual)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
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
				
				$motoristas=$this->transporte_model->consultar_motoristas($id_vehiculo);
				//////////consulta al motorista asignado al vehiculo.
				
				$j=json_encode($motoristas);
				echo $j;
			}
		}
		else {
			echo ' No tiene permiso';
		}
	}

	/*
	*	Nombre: asignar_veh_mot
	*	Objetivo: Función para registrar una asignación de vehículo con su correspondiente motorista
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 01/04/2014
	*	Observaciones: Ninguna
	*/
	
	function asignar_veh_mot()
	{
		$data['permiso']=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		
		if($data['permiso']!=NULL)
		{
			if($data['permiso']>=2)
			{
				$id_solicitud=$this->input->post('id_solicitud');//id_solicitud
				$id_vehiculo=$this->input->post('vehiculo'); //id_vehiculo
				$id_motorista=$this->input->post('motorista'); //estado de la solicitud
				$estado=$this->input->post('resp');//futurp estado de la solicitud
				$fecha_m=date('Y-m-d H:i:s');
				$nr=$this->session->userdata('nr'); //NR del usuario Logueado
				$observaciones=$this->input->post('observacion');//observación, si es que hay
				
				if($estado==3)
				{
					$this->transporte_model->asignar_veh_mot($id_solicitud,$id_motorista,$id_vehiculo, $estado, $fecha_m,$nr,$this->session->userdata('id_usuario'));
					
					if($observaciones!="") $this->transporte_model->insertar_descripcion($id_solicitud,$observaciones);						
					
					ir_a("index.php/transporte/asignar_vehiculo_motorista");
				
				}
				else
				{
					echo'Datos corruptos';
				}
			}
		}
		else
		{
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
			
			$this->transporte_model->insertar_descripcion($id_solicitud_transporte,$observaciones); /*Guardando observaciones*/
			
			$this->db->trans_complete();
			ir_a('index.php/transporte/solicitud/'.$this->db->trans_status());
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
	*	Observaciones: Posee un simulador de medidor de tanque hecho con canvas
	*/
	function control_salidas_entradas(){
	$data['datos']=$this->transporte_model->salidas_entradas_vehiculos();
	$data['accesorios']=$this->transporte_model->accesorios();
	pantalla("transporte/despacho",$data);	
	}
	/*
	*	Nombre: guardar_despacho
	*	Objetivo: Registrar la salida o ingreso de un vehiculo
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 08/04/2014
	*	Observaciones: Ninguna
	*/
	function guardar_despacho(){

		$estado=$this->input->post('estado');
		$id=$this->input->post('id');
		$km=$this->input->post('km');
		$gas=$this->input->post('gas');
		$hora=date("H:i:s", strtotime($this->input->post('hora')));

//remuevo de post los datos para que solo queden los accesorios
				$acces=$_POST;
			unset($acces['estado']);
			unset($acces['gas']);
			unset($acces['id']);
			unset($acces['km']);
			unset($acces['hora']);
		
		if($estado==3){
			$this->transporte_model->salida_vehiculo($id, $km,$hora,$acces);
		}else{
			if($estado==4){
			
			$this->transporte_model->regreso_vehiculo($id, $km, $hora, $gas,$acces);		
			
			}
		}
		
		ir_a('index.php/transporte/control_salidas_entradas');
		}
		
	/*
	*	Nombre: infoSolicitud
	*	Objetivo: Ver datos de interes para el encargado de despacho sobre la mision
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 23/03/2014
	*	Observaciones: Funcion invocada desde la pantanlla de control de entradas y salidas atravez de ajax
	*/
		
	function infoSolicitud($id){
			
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
	*	Observaciones: Esta funcion es invocada por ajax desde la pantalla de control de salidas y entradas de vehiculo
	*/
	
	function kilometraje($id){
			
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
	function ver_solicitudes()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),61);
		
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) {
				case 1:
					$empleado=$this->transporte_model->consultar_empleado($this->session->userdata('nr'));
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes($empleado[0]['NR']);
					break;
				case 2:
					$seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes_seccion($seccion['id_seccion']);
					break;
				case 3:
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes();
			}
			
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
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes($empleado[0]['NR'],3);
					break;
				case 2:
					$seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes_seccion($seccion['id_seccion'],3);
					break;
				case 3:
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes(NULL,3);
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
			$data['info_empleado']=$this->transporte_model->info_adicional($id_empleado_solicitante);
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