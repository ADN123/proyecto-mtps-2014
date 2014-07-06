<?php
class Inicio extends CI_Controller
{
    
    function Inicio()
	{
        parent::__construct();
		date_default_timezone_set('America/El_Salvador');
		error_reporting(0);
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('seguridad_model');
		
		if(!$this->session->userdata('id_usuario')){
		 	redirect('index.php/sessiones');
		}
    }
	
	function index()
	{	
		$data=$this->seguridad_model->sexoUsuario($this->session->userdata('id_usuario'));
		$data=$data[0];
	 	$this->pantalla('home',$data);
	}
	
	function pantalla ($vista,$data) 
	{
		$data['nick']=$this->session->userdata('usuario');
		$data['nombre']=$this->session->userdata('nombre');
		$data['menus']=$this->seguridad_model->buscar_menus($this->session->userdata('id_usuario'));
	 	
	 //	echo"<pre>";print_r($data); echo "</pre>";
	 	$this->load->view('encabezado',$data); $this->load->view($vista);	 $this->load->view('piePagina');
	 	
	 
	}

}
?>