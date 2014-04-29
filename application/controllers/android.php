<?php 
class Android extends CI_Controller {
		
	function Android()
	{
        parent::__construct();
		$this->load->model('android_model');
		$this->load->model('transporte_model');
		
    }

	
	
	/*
	*	Nombre: iniciar_session
	*	Obejtivo: Verificar que el nick y password introducidos por el usuario sean correctos
	*	Hecha por: Jhonatan
	*	Modificada por: Leonel
	*	Ultima Modificacion: 01/04/2014
	*	Observaciones: La variable de session "id_seccion" no la deberiamos ocupar, deberiamos ir a buscar el registro actual del usuario logueado cada vez que se requiera
	*/
	function index()
	{
		
		$v=$this->android_model->salida_entrada(); 
//		print_r($v);
		$j=json_encode($v);
		echo $j;
	}
	
	function accesorios(){
		
		$j=$this->transporte_model->accesorios();
		$j=json_encode($j);
		echo $j;
		}
		
	function registrar(){
		echo "POST ok:";
		print_r($_POST);
		
		}

}
?>