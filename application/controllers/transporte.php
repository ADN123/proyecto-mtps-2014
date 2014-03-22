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
	
	function solicitud($id_solicitud=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']>1) {
			if($data['id_permiso']>2)//nivel 3
				$data['empleados']=$this->transporte_model->consultar_empleados();
			else {//nivel 2
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$data['empleados']=$this->transporte_model->consultar_empleados_seccion($id_seccion['id_seccion']);
			}
		}
		else {//nivel 1
			$data['empleados']=$this->transporte_model->consultar_empleado($this->session->userdata('nr'));
			foreach($data['empleados'] as $val) {
				$data['info']=$this->transporte_model->info_adicional($val['NR']);
			}
		}
		$data['solicitud']=$this->transporte_model->consultar_solicitud($id_solicitud);
		$data['acompanantes']=$this->transporte_model->consultar_empleados($this->session->userdata('nr'));
		$data['municipios']=$this->transporte_model->consultar_municipios();
		//print_r($data);
		pantalla('transporte/solicitud',$data);	
	}
	
	function control_solicitudes()
	{
 		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);
		
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
		if($data['id_permiso']>2)
		{
			$data['datos']=$this->transporte_model->solicitudes_por_asignar();
			pantalla('transporte/asignacion_veh_mot',$data);
		}
	}
///////////////////////////////////////////////////////////////////////////////////////

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
			
			//$motorista_asignado=$this->transporte_model->consultar_motoristas($id_vehiculo);
			//////////consulta al motorista asignado al vehiculo.
			
		/*	foreach($motorista_asignado as $m)
			{
				$id_motorista=$m->id_empleado;
			}
			*/ //
			$motoristas_disponibles=$this->transporte_model->motoristas_disponibles();//////////////////consulta los motoristas disponibles, pero no muestra al asignado
			$j=json_encode($motoristas_disponibles);
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
				$this->transporte_model->asignar_veh_mot($id_solicitud,$id_empleado,$id_vehiculo, $estado, $fecha_m,$nr,$this->session->userdata('id_usuario'));						
				
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
	
	function guardar_solicitud()
	{	
		$fec=str_replace("/","-",$this->input->post('fecha_mision'));
		$fecha_solicitud_transporte=date('Y-m-d');
		$id_empleado_solicitante=(int)$this->input->post('nombre');
		$mision_encomendada=$this->input->post('mision_encomendada');
		$fecha_mision=date("Y-m-d", strtotime($fec));
		$hora_salida=date("H:i:s", strtotime($this->input->post('hora_salida')));
		$hora_entrada=date("H:i:s", strtotime($this->input->post('hora_regreso')));
		$id_municipio=(int)$this->input->post('municipio');
		$lugar_destino=$this->input->post('lugar_destino');
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
			'acompanante'=>$acompanante,
			'id_usuario_crea'=>$id_usuario_crea,
			'fecha_creacion'=>$fecha_creacion,
			'estado_solicitud_transporte'=>$estado_solicitud_transporte
		);
		
		$id_solicitud_transporte=$this->transporte_model->guardar_solicitud($formuInfo);
		$acompanantes=$this->input->post('acompanantes');
		for($i=0;$i<count($acompanantes);$i++) {
			$formuInfo = array(
				'id_solicitud_transporte'=>$id_solicitud_transporte,
				'id_empleado'=>$acompanantes[$i]
			);
			$this->transporte_model->guardar_acompanantes($formuInfo);
		}
		ir_a('index.php/transporte/solicitud');
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
	function ver_solicitudes()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),61);
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) {
				case 1:
					break;
				case 2:
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
	
	function eliminar_solicitud($id_solicitud)
	{
		$this->transporte_model->eliminar_solicitud($id_solicitud);
		redirect('index.php/transporte/ver_solicitudes');
	}
}
?>