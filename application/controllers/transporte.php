<?php
class Transporte extends CI_Controller
{
    
    function Transporte()
	{
        parent::__construct();
		$this->load->model('transporte_model');
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
	*	Obejtivo: Carga la vista para la creacion del solicitudes de transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 01/04/2014
	*	Observaciones: Ninguna
	*/
	function solicitud($id_solicitud=NULL)
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
			
			$data['solicitud']=$this->transporte_model->consultar_solicitud($id_solicitud);
			$data['acompanantes']=$this->transporte_model->consultar_empleados($this->session->userdata('nr'));
			$data['municipios']=$this->transporte_model->consultar_municipios();

			pantalla('transporte/solicitud',$data);	
		}
		else {
			echo ' No tiene permisos para acceder';
		}
	}
	
	function control_solicitudes()
	{
 		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);
		
		echo $data['id_permiso'];
		if(isset($data['id_permiso'])&&$data['id_permiso']>1) {
			if($data['id_permiso']>2){//nivel 3
				$data['datos']=$this->transporte_model->todas_solicitudes_por_confirmar();
			}else {//nivel 2
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$data['datos']=$this->transporte_model->solicitudes_por_confirmar($id_seccion['id_seccion']);			
			}	 
			pantalla('transporte/ControlSolicitudes',$data);
		
		}else{//nivel 1
				echo "No Autorizado";

		}


	
	}
	
	function datos_de_solicitudes($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);
		if(isset($data['id_permiso'])) {
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			$d=$this->transporte_model->datos_de_solicitudes($id, $id_seccion['id_seccion']);
			$a=$this->transporte_model->acompanantes($id);
			$j=json_encode($d);
			echo $j;
		}
		else {
			echo ' No tiene permiso';
		}
	}
	
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
			
			}else {
				echo'Datos corruptos';
			}
		}else {
			echo ' No tiene permisos para acceder';
		}	
	}
	
	
	///////////esta función carga la vista de Asignaciones de vehículos y Motoristas////////////
	function asignar_vehiculo_motorista()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']>=2)
		{
			$data['datos']=$this->transporte_model->solicitudes_por_asignar();
			pantalla('transporte/asignacion_veh_mot',$data);
		}
		//echo $data['id_permiso'];
	}
	
///////////////////////////////////////////////////////////////////////////////////////

/////////////función para cargar datos de solicitudes////////////////////////////////////
	function cargar_datos_solicitud($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']>2)
		{
			$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			$d=$this->transporte_model->datos_de_solicitudes($id, $id_seccion['id_seccion']);
			$a=$this->transporte_model->acompanantes_internos($id);
			
			$solicitud_actual=$this->transporte_model->consultar_fecha_solicitud($id);
			//////////consulta la fecha, hora de entrada, y hora de salida de la solicitud actual, para luego compararla con otras solicitudes ya aprobadas.
									
			foreach($solicitud_actual as $row)
			{
				$id_departamento=$row->id_departamento_pais;
				$fecha=$row->fecha;
				$entrada=$row->entrada;
				$salida=$row->salida;		
			}
			
			if($id_departamento=="00006")////Para misiones locales, el 6 significa departamento de San Salvador
			{
				$vehiculos_disponibles=$this->transporte_model->vehiculos_disponibles($fecha,$entrada,$salida);
			}
			else///////////////////////para misiones fuera de san salvador
			{
				$vehiculos_disponibles=$this->transporte_model->vehiculos_disponibles2($fecha,$entrada,$salida);
			}
			
			echo 
			"
			<div id='signup-header'>
			<h2>Asignaci&oacute;n de Veh&iacute;culos y Motoristas</h2>
			<a class='modal_close'></a>
			</div>
			
			<form id='form' action='".base_url()."index.php/transporte/asignar_veh_mot' method='post'>
			<input type='hidden'   id='id_solicitud' name='id_solicitud'/>
			<input type='hidden' id='resp' name='resp' />
			<input type='hidden' name='id_mot' value='id_mot' />
			
			<fieldset>      
				<legend align='left'>Información de la Solicitud</legend>
				";
				foreach($d as $datos)
				{
					$nombre=$datos->nombre;
					$seccion=$datos->seccion;
					$mision=$datos->mision;
					$fechaS=$datos->fechaS;
					$fechaM=$datos->fechaM;
					$salida=$datos->salida;
					$entrada=$datos->entrada;
					$municipio=$datos->municipio;
					$lugar=$datos->lugar;
					$requiere=$datos->req;
					$acompanante=$datos->acompanante;
				}
				
			
			echo "Nombre: <strong>".$nombre."</strong> <br>
			Sección: <strong>".$seccion."</strong> <br>
			Misión: <strong>".$mision."</strong> <br>
			Fecha de Solicitud: <strong>".$fechaS."</strong> <br>
			Fecha de Misión: <strong>".$fechaM."</strong> <br>
			Hora de Salida: <strong>".$salida."</strong> <br>
			Hora de Regreso: <strong>".$entrada."</strong> <br>
			Municipio: <strong>".$municipio."</strong> <br>
			Lugar: <strong>".$lugar."</strong> <br>
			
			</fieldset>
		   <br>
		    <fieldset>
				<legend align='left'>Acompañantes</legend>
				
				";
				foreach($a as $acompa)
				{
					echo "<strong>".$acompa->nombre."</strong> <br />";
				}
				echo "<strong>".$acompanante."</strong><br />";
			echo "
		    </fieldset>
			<br>
			<fieldset>
			<legend align='left'>Vehículos</legend>
				<p>
				<label>Información</label>
			   <select name='vehiculo' id='vehiculo' onchange='motoristaf(this.value)'>
			   ";
			   
				foreach($vehiculos_disponibles as $v)
				{
					echo "<option value='".$v->id_vehiculo."' data-motorista='".."'>".$v->placa." - ".$v->nombre." - ".$v->modelo."</option>";
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
			if($requiere==1)
			{
			echo "
				   <select name='motorista' id='motorista'>
				   </select>
				";
			}
			else
			{
				echo "<label>".$nombre."</label>";
			}
			echo "
			</p>
				</fieldset>
			 <p>
				<label for='observacion' id='lobservacion'>Observación</label>
				<textarea class='tam-4' id='observacion' tabindex='2' name='observacion'/></textarea>
			</p>
			<p style='text-align: center;'>
				<button type='submit' id='asignar' name='asignar' onclick='enviar(3)'>Asignar</button>
			</p>
			</form>
			";
			
		}
		else
		{
			echo ' No tiene permiso';
		}
	}

/////////////////Función para conocer los vehículos disponibles para las misiones oficiales
	function verificar_fecha_hora($id_solicitud)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']>2)
		{
			/*$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));*////////consulta la seccion
			
			$solicitud_actual=$this->transporte_model->consultar_fecha_solicitud($id_solicitud);
			//////////consulta la fecha, hora de entrada, y hora de salida de la solicitud actual, para luego compararla con otras solicitudes ya aprobadas.
									
			foreach($solicitud_actual as $row)
			{
				$id_departamento=$row->id_departamento_pais;
				$fecha=$row->fecha;
				$entrada=$row->entrada;
				$salida=$row->salida;		
			}
			
			if($id_departamento=="00006")////Para misiones locales, el 6 significa departamento de San Salvador
			{
				$vehiculos_disponibles=$this->transporte_model->vehiculos_disponibles($fecha,$entrada,$salida);
			}
			else///////////////////////para misiones fuera de san salvador
			{
				$vehiculos_disponibles=$this->transporte_model->vehiculos_disponibles2($fecha,$entrada,$salida);
			}
				
			$j=json_encode($vehiculos_disponibles);
			echo $j;
		}
		else
		{
			echo ' No tiene permiso';
		}
	}
	////////////////////////////////////////////////////////////////////////////////////////////
	
	////////función para conocer el motorista que se ha de asignar a la misión oficial//////////
	function verificar_motoristas($id_vehiculo)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']>2)
		{
			
			$motoristas=$this->transporte_model->consultar_motoristas($id_vehiculo);
			//////////consulta al motorista asignado al vehiculo.
			
			$j=json_encode($motoristas);
			echo $j;
		}
		else
		{
			echo ' No tiene permiso';
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////

/////Función para registrar una asignación de vehículo con su correspondiente motorista////////
function asignar_veh_mot()
	{
		$data['permiso']=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['permiso']>=2)
		{
			$id_solicitud=$this->input->post('id_solicitud');//id_solicitud
			$id_vehiculo=$this->input->post('vehiculo'); //id_vehiculo
			$id_motorista=$this->input->post('motorista'); //estado de la solicitud
			$estado=$this->input->post('resp');//futurp estado de la solicitud
			$fecha_m=date('Y-m-d H:i:s');
			$nr=$this->session->userdata('nr'); //NR del usuario Logueado
			
			if($estado==3)
			{
				$this->transporte_model->asignar_veh_mot($id_solicitud,$id_motorista,$id_vehiculo, $estado, $fecha_m,$nr,$this->session->userdata('id_usuario'));						
				
				ir_a("index.php/transporte/asignar_vehiculo_motorista");
			
			}
			else
			{
				echo'Datos corruptos';
			}
		}
		else
		{
			echo ' No tiene permisos para acceder';
		}	
	}
/////////////////////////////////////////////////////////////////////////////////////////////

	/*
	*	Nombre: buscar_info_adicional
	*	Obejtivo: Mostrar la informacion del puesto del empleado que necesita el transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 15/03/2014
	*	Observaciones: Ninguna
	*/
	function buscar_info_adicional()
	{
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
			);}
		echo json_encode($json);
	}
	
	/*
	*	Nombre: guardar_solicitud
	*	Obejtivo: Guardar el formulario de solicitud de transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 01/04/2014
	*	Observaciones: Ninguna
	*/
	function guardar_solicitud()
	{	
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59); /*Verificacion de permiso para crear solicitudes*/
		
		if($data['id_permiso']!=NULL) {
			$fec=str_replace("/","-",$this->input->post('fecha_mision'));
			$fecha_solicitud_transporte=date('Y-m-d');
			$id_empleado_solicitante=(int)$this->input->post('nombre');
			$mision_encomendada=$this->input->post('mision_encomendada');
			$fecha_mision=date("Y-m-d", strtotime($fec));
			$hora_salida=date("H:i:s", strtotime($this->input->post('hora_salida')));
			$hora_entrada=date("H:i:s", strtotime($this->input->post('hora_regreso')));
			$id_municipio=(int)$this->input->post('municipio');
			$lugar_destino=$this->input->post('lugar_destino');
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
				'mision_encomendada'=>$mision_encomendada,
				'fecha_mision'=>$fecha_mision,
				'hora_salida'=>$hora_salida,
				'hora_entrada'=>$hora_entrada,
				'id_municipio'=>$id_municipio,
				'lugar_destino'=>$lugar_destino,
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
						'lugar_destino'=>$campos[1]
					);
					$this->transporte_model->guardar_destinos($formuInfo); /*Guardando destinos*/
				}
			}
			
			$this->transporte_model->insertar_descripcion($id_solicitud_transporte,$observaciones); /*Guardando observaciones*/
			
			ir_a('index.php/transporte/solicitud');
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	function control_salidas_entradas(){
	$data['datos']=$this->transporte_model->salidas_entradas_vehiculos();
	pantalla("transporte/despacho",$data);	
	}
	function guardar_despacho(){

		$estado=$this->input->post('estado');
		$id=$this->input->post('id');
		$km=$this->input->post('km');
		$hora=date("H:i:s", strtotime($this->input->post('hora')));
		if($estado==3){
			$this->transporte_model->salida_vehiculo($id, $km,$hora);
		}else{
			if($estado==4){
			$gas=$this->input->post('gas');
			$this->transporte_model->regreso_vehiculo($id, $km, $hora, $gas);		
			}
		}
		ir_a('index.php/transporte/control_salidas_entradas');
		}
	function infoSolicitud($id){
			
			$d=$this->transporte_model->infoSolicitud($id);	
			$j=json_encode($d);
			echo $j;
				
	}
	function kilometraje($id){
			
			$d=$this->transporte_model->kilometraje($id);	
			$j=json_encode($d);
			echo $j;
				
	}
	
	/*
	*	Nombre: ver_solicitudes
	*	Obejtivo: Ver el estado actual de las solicitudes. Permite editar o eliminar solicitudes
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 15/03/2014
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
	*	Obejtivo: Elimina (desactiva) una solicitud de transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 15/03/2014
	*	Observaciones: Ninguna
	*/
	function eliminar_solicitud($id_solicitud)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),61);
		
		if($data['id_permiso']!=NULL) {
			$this->transporte_model->eliminar_solicitud($id_solicitud);
			redirect('index.php/transporte/ver_solicitudes');
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	
	/*
	*	Nombre: reporte_solicitud
	*	Obejtivo: Muestra solicitudes que ya tienen asignado vehiculo y motorista. Permite exportar a pdf
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 01/04/2014
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
	*	Obejtivo: Genera una archivo pdf de una solicitud
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 01/04/2014
	*	Observaciones: Ninguna
	*/
	function solicitud_pdf($id) 
	{
		echo $id;
	}
}
?>