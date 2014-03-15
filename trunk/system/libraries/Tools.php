<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Session class using native PHP session features and hardened against session fixation.
*
* @package     CodeIgniter
* @subpackage  Libraries
* @category    Sessions
* @author      Dariusz Debowczyk
* @link        http://www.codeigniter.com/user_guide/libraries/sessions.html
*/
class CI_Tools {



	public function __construct()
	{

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