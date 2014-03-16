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
		if($data['']!=0) {
			$json =array(
				'estado'=>1
			);
		}
		else {
			$json =array(
				'estado'=>0
			);}
		echo json_encode($json);
	}
}
?>