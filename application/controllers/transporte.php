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
	
	function solicitud()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']>1) {
			if($data['id_permiso']>2)
				$data['empleados']=$this->transporte_model->consultar_empleados();
			else {
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$data['empleados']=$this->transporte_model->consultar_empleados_seccion($id_seccion['id_seccion']);
			}
		}
		else {
			$data['empleados']=$this->transporte_model->consultar_empleado($this->session->userdata('nr'));
			foreach($data['empleados'] as $val) {
				$data['info']=$this->transporte_model->info_adicional($val['NR']);
			}
		}
		$data['acompanantes']=$this->transporte_model->consultar_empleados($this->session->userdata('nr'));
		$data['municipios']=$this->transporte_model->consultar_municipios();
		//print_r($data);
		pantalla('transporte/solicitud',$data);	
	}
	
	function control_solicitudes()
	{
		$data['permiso']=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);
		if($data['permiso']>=2){
			$data['datos']=$this->transporte_model->solicitudes_por_confirmar($this->session->userdata('id_seccion'));
			pantalla('transporte/ControlSolicitudes',$data);
		}
		else {
			echo ' No tiene permiso';
		}
	
	}
	
	function datos_de_solicitudes($id)
	{
		$data['permiso']=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);
		if($data['permiso']>=2){
			$d=$this->transporte_model->datos_de_solicitudes($id, $this->session->userdata('id_seccion'));	
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
			$descrip=$this->input->post('resp'); //estado de la solicitud
			$nr=$this->session->userdata('nr'); //NR del usuario Logueado
			
			if($estado ==2 || $estado== 0){
				$this->transporte_model->aprobar($id,$estado, $nr);
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
	
	function asignar_vehiculo_motorista()
	{
		$data['vehiculos']=$this->transporte_model->consultar_vehiculos();
		$data['motoristas']=$this->transporte_model->consultar_motoristas();
		$data['datos']=$this->transporte_model->solicitudes_por_asignar();
		pantalla('transporte/asignacion_veh_mot',$data);
	}	
	
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
		redirect('index.php/transporte/solicitud');
	}
}
?>