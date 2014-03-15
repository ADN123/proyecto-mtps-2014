<?php 
class Sessiones extends CI_Controller {
	
	function Sessiones()
	{
        parent::__construct();
		$this->load->model('seguridad_model');
    }

	function index(){
	  	$this->load->view('encabezadoLogin.php'); 
	  	$this->load->view('login.php'); 
		$this->load->view('piePagina.php');
	}

	function iniciar_session()
	{
		$login =$this->input->post('user');
		$clave =$this->input->post('pass');
			
		$v=$this->seguridad_model->consultar_usuario($login,$clave);

		if($v['id_usuario']==0) {
			$json =array(
				'estado'=>"0",
				'msj'=>"Error al intentar ingresar al sistema: Los datos ingresados son incorrectos"
			);
		 	echo json_encode($json);
			//redirect('index.php/sessiones');
		}
		else {
			$this->session->set_userdata('nombre', $v['nombre_completo']);
			$this->session->set_userdata('id_usuario', $v['id_usuario']);
			$this->session->set_userdata('usuario', $v['usuario']);
			$this->session->set_userdata('nr', $v['NR']);			
			$json =array(
				'estado'=>1,
				'msj'=>"Iniciando Session...."
			);
			echo json_encode($json);
			//redirect('index.php'); 
		}
	}
	
	function cerrar_session()
	{
		
		$this->session->set_userdata('nombre','');
		$this->session->set_userdata('id_usuario','');
		$this->session->set_userdata('usuario', '');	
		$this->session->set_userdata('nr','');
		
	   	redirect('index.php/sessiones/');
	}
		


}
?>