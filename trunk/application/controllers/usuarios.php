<?php
class Usuarios extends CI_Controller
{
    
    function Usuarios()
	{
        parent::__construct();
		$this->load->model('transporte_model');
		$this->load->library("mpdf");
    	if(!$this->session->userdata('id_usuario')) {
			redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
		$this->solicitud();
  	}
	
	/*
	*	Nombre: roles
	*	Objetivo: Carga la vista para la administracion de los roles
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 11/05/2014
	*	Observaciones: Ninguna.
	*/
	function roles($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),78); /*Verificacion de permiso para administrara roles*/
		
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:

					break;
				case 2:
				
					break;
				case 3:
				
					break;
			}
			$data['estado_transaccion']=$estado_transaccion;
			
			pantalla('usuarios/roles',$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
}
?>