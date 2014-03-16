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
			$data['secciones']=$this->transporte_model->consultar_secciones();
			$data['acompanantes']=$this->transporte_model->consultar_empleados($this->session->userdata('nr'));
			$data['empleados']=$this->transporte_model->consultar_empleados();
			$data['municipios']=$this->transporte_model->consultar_municipios();
		}
		else {
			$data['secciones']=$this->transporte_model->consultar_seccion($this->session->userdata('nr'));
			$data['empleados']=$this->transporte_model->consultar_empleado($this->session->userdata('nr'));
			$data['acompanantes']=$this->transporte_model->consultar_empleados($this->session->userdata('nr'));
		}
		$data['departamentos']=$this->transporte_model->consultar_departamentos();
		//print_r($data);
		pantalla('transporte/solicitud',$data);	
	}
	
	function control_solicitudes()
	{
	$data['datos']=$this->transporte_model->solicitudes_por_confirmar();
	pantalla('transporte/ControlSolicitudes',$data);
	}
	
	function datos_de_solicitudes($id){
		$d=$this->transporte_model->datos_de_solicitudes($id, $this->session->userdata('id_seccion'));	
		$j=json_encode($d);
		echo $j;
	}
	function aprobar_solicitud()
	{
	$id=$this->input->post('ids'); //id solicitud
	$estado=$this->input->post('resp'); //estado de la solicitud
	$nr=$this->session->userdata('nr'); //NR del usuario Logueado
		
	if($estado ==2 || $estado== 0){
		$this->transporte_model->aprobar($id,$estado, $nr);
		$data['datos']=$this->transporte_model->solicitudes_por_confirmar();
		pantalla('transporte/ControlSolicitudes',$data);
	}else{
		echo'Datos corruptos';
		}
			
	}
	
	function asignar_vehiculo_motorista()
	{
		$data['vehiculos']=$this->transporte_model->consultar_vehiculos();
		$data['motoristas']=$this->transporte_model->consultar_motoristas();
		$data['datos']=$this->transporte_model->solicitudes_por_asignar();
		pantalla('transporte/asignacion_veh_mot',$data);
	}	
	
}
?>