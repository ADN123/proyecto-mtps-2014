<?php
class Vales extends CI_Controller
{
    
    function Vales()
	{
        parent::__construct();
		$this->load->model('vales_model');
		$this->load->model('transporte_model');
		$this->load->library("mpdf");
    	if(!$this->session->userdata('id_usuario')){
			redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
		$this->ingreso_vales();
  	}

	/*
	*	Nombre: ingreso_vales
	*	Objetivo: Carga la vista para el ingreso de vales de combustible
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 28/04/2014
	*	Observaciones: Ninguna.
	*/
	function ingreso_vales($estado_transaccion=NULL) 
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),63); 
		
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) {
				case 1:

				case 2:
				case 3:
			}
			$data['gasolineras']=$this->vales_model->consultar_gasolineras();
			$data['estado_transaccion']=$estado_transaccion;
			$data['fuente_fondo']=$this->transporte_model->consultar_fuente_fondo();
			pantalla("vales/ingreso",$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}	
	}
	
	/*
	*	Nombre: guardar_vales
	*	Objetivo: guarda los datos de los vales de combustible
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 28/04/2014
	*	Observaciones: Ninguna.
	*/
	function guardar_vales() 
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),63); /*Verificacion de permiso para crear solicitudes*/
		
		if($data['id_permiso']!=NULL) {
			$this->db->trans_start();
			$fec=str_replace("/","-",$this->input->post('fecha_recibido'));
			$fecha_recibido=date("Y-m-d", strtotime($fec));
			$inicial=$this->input->post('inicial');
			$cantidad_restante=$this->input->post('cantidad');
			$tipo_vehiculo=$this->input->post('tipo_vehiculo');
			$valor_nominal=$this->input->post('valor_nominal');
			$id_gasolinera=$this->input->post('id_gasolinera');
			$final=$this->input->post('inicial')+$this->input->post('cantidad')-1;
			$id_usuario_crea=$this->session->userdata('id_usuario');
			$fecha_creacion=date('Y-m-d H:i:s');
			
			$formuInfo = array(
				'inicial'=>$inicial,
				'final'=>$final,
				'valor_nominal'=>$valor_nominal,
				'tipo_vehiculo'=>$tipo_vehiculo,
				'id_gasolinera'=>$id_gasolinera,
				'id_usuario_crea'=>$id_usuario_crea,
				'fecha_creacion'=>$fecha_creacion,
				'fecha_recibido'=>$fecha_recibido,
				'cantidad_restante'=>$cantidad_restante
			);
			
			$this->vales_model->guardar_vales($formuInfo);
			
			$this->db->trans_complete();
			ir_a('index.php/vales/ingreso_vales/'.$this->db->trans_status());
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	
	/*
	*	Nombre: ingreso_requisicion
	*	Objetivo: Cargar la vista de la requisicion (solicitud) de combustible
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 28/04/2014
	*	Observaciones: Ninguna.
	*/
	function ingreso_requisicion($permiso, $estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59); /*Verificacion de permiso para crear requisiciones*/
				$data['id_permiso']=$permiso;
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
				case 2:
					$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					$data['oficinas']=$this->vales_model->consultar_oficinas($id_seccion['id_seccion']);
					$data['vehiculos']=$this->vales_model->vehiculos($id_seccion['id_seccion']);
					break;
				case 3:
					$data['oficinas']=$this->vales_model->consultar_oficinas();
					$data['vehiculos']=$this->vales_model->vehiculos();
					break;
			}
			$data['estado_transaccion']=$estado_transaccion;


			pantalla('vales/entrega',$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}

	function guardar_requisicion()
	{
		print_r($_POST);
	}
}
?>