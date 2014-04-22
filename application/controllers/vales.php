<?php
class Vales extends CI_Controller
{
    
    function Vales()
	{
        parent::__construct();
		$this->load->model('transporte_model');
    	if(!$this->session->userdata('id_usuario')){
			redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
		pantalla("vales/ingreso");
  	}

	
	
		function requisicion()
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

			pantalla('vales/entrega',$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	


	


}
?>