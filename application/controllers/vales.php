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
}
?>