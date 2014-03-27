<?php
class Vehiculo extends CI_Controller
{
    
    function Vehiculo()
	{
        parent::__construct();
		$this->load->model('transporte_model');
//		$this->load->model('vehiculo_model');
    	if(!$this->session->userdata('id_usuario')){
		 redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
		echo"ok";
  	}
	function  mantenimiento(){
		
		}
	
}
?>