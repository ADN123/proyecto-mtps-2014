<?php
class Inicio extends CI_Controller
{
    
    function Inicio()
	{
        parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('seguridad_model');
		
		if(!$this->session->userdata('id_usuario')){
		 	redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
	 	$this->pantalla('home');
		
		/*$data['menus']=$this->seguridad_model->buscar_menus($this->session->userdata('id_usuario'));
		$this->load->view('prueba',$data);*/
	}
	
	function pantalla ($vista) 
	{
		$data['nick']=$this->session->userdata('usuario');
		$data['nombre']=$this->session->userdata('nombre');
		$data['menus']=$this->seguridad_model->buscar_menus($this->session->userdata('id_usuario'));
	 	$this->load->view('encabezado',$data);
	 	$this->load->view($vista);	
	 	$this->load->view('piePagina');
	}

}
?>