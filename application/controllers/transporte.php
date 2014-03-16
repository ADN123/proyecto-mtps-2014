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
		$data['permiso']=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['permiso']>1) {
			/*$data['secciones']=$this->transporte_model->consultar_secciones();*/
			$data['empleados']=$this->transporte_model->consultar_empleados();
			$data['acompanantes']=$this->transporte_model->consultar_empleados($this->session->userdata('nr'));
		}
		else {
			/*$data['secciones']=$this->transporte_model->consultar_seccion($this->session->userdata('nr'));*/
			$data['empleados']=$this->transporte_model->consultar_empleado($this->session->userdata('nr'));
			$data['acompanantes']=$this->transporte_model->consultar_empleados($this->session->userdata('nr'));
		}
		$data['municipios']=$this->transporte_model->consultar_municipios();
		/*$data['departamentos']=$this->transporte_model->consultar_departamentos();*/
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
			$nr=$this->session->userdata('nr'); //NR del usuario Logueado
			if($estado ==2 || $estado== 0){
				$this->transporte_model->aprobar($id,$estado, $nr);
				$data['datos']=$this->transporte_model->solicitudes_por_confirmar();
				pantalla('transporte/ControlSolicitudes',$data);
			}
			else {
				echo'Datos corruptos';
			}
		}
		else {
			echo ' No tiene permiso';
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
		$fecha_solicitud_transporte=date('Y-m-d');
		$id_empleado_solicitante=$this->input->post('nombre');
		$mision_encomendada=$this->input->post('mision_encomendada');
		$fecha_mision=$this->input->post('fecha_mision');
		$hora_salida=$this->input->post('hora_salida');
		$hora_entrada=$this->input->post('hora_regreso');
		$id_municipio=$this->input->post('municipio');
		$lugar_destino=$this->input->post('lugar_destino');
		$acompanante=$this->input->post('acompanantes2');
		$id_usuario_crea=$this->session->userdata('id_usuario');
		$fecha_creacion=date('Y-m-d');
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
			'estado_solicitud_transporte'=>$estado_solicitud_transporte,
		);
		
		$id_solicitud_transporte=$this->transporte_model->guardar('tcm_solicitud_transporte',$formuInfo);
		
		$acompanantes=$this->input->post('acompanantes');
		//redirect('index.php/transporte/solicitud');
	}
}
?>