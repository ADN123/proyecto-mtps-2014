<?php 
class Sessiones extends CI_Controller {
		
	function Sessiones()
	{
        parent::__construct();
		$this->load->model('seguridad_model');
		$this->load->helper('cookie');
    }

	/*
	*	Nombre: index
	*	Obejtivo: Carga la vista que contiene el formulario de login
	*	Hecha por: Jhonatan
	*	Modificada por: Leonel
	*	Ultima Modificacion: 15/03/2014
	*	Observaciones: Ninguna
	*/
	function index(){
	
		$in=$this->verificar();
		if($in<=3){
			$this->load->view('encabezadoLogin.php'); 
			$this->load->view('login.php'); 
			$this->load->view('piePagina.php');		
		}else{
		//echo"Sistema Bloqueado";
		$this->load->view('encabezadoLogin.php'); 
		$this->load->view('lock.php'); 
		$this->load->view('piePagina.php');		

		
		}
	}
	
	/*
	*	Nombre: iniciar_session
	*	Obejtivo: Verificar que el nick y password introducidos por el usuario sean correctos
	*	Hecha por: Jhonatan
	*	Modificada por: Leonel
	*	Ultima Modificacion: 01/04/2014
	*	Observaciones: La variable de session "id_seccion" no la deberiamos ocupar, deberiamos ir a buscar el registro actual del usuario logueado cada vez que se requiera
	*/
	function iniciar_session()
	{
		$in=$this->verificar();
		//error_reporting(0);
		if ($in<=3){				
		
					$login =$this->input->post('user');
					$clave =$this->input->post('pass');			
					$v=$this->seguridad_model->consultar_usuario($login,$clave);  //Verificación en base de datos
				
				
					if($v['id_usuario']==0) {
							alerta("Datos Incorrectos",'index.php/sessiones');
						
					}else {
					$this->session->set_userdata('nombre', $v['nombre_completo']);
					$this->session->set_userdata('id_usuario', $v['id_usuario']);
					$this->session->set_userdata('usuario', $v['usuario']);
					$this->session->set_userdata('nr', $v['NR']);			
					$this->session->set_userdata('id_seccion', $v['id_seccion']);
					$this->session->set_userdata('sexo', $v['sexo']);
					setcookie('contador', 1, time() + 15* 60);			
					ir_a('index.php/inicio'); 
					}
		}else{//
			alerta($in." intentos. terminal bloqueada",'index.php/sessiones');
		
		}
	
		
	}
	
	/*
	*	Nombre: cerrar_session
	*	Obejtivo: Cerrar la sesion de un usuario
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Ultima Modificacion: 15/03/2014
	*	Observaciones: Ninguna
	*/
	function cerrar_session()
	{
		
		$this->session->set_userdata('nombre','');
		$this->session->set_userdata('id_usuario','');
		$this->session->set_userdata('usuario', '');	
		$this->session->set_userdata('nr','');
		
	   	redirect('index.php/sessiones/');
	}
	
	function verificar(){
		$in;
				 	
		  if(!isset($_COOKIE['contador']))
		  { 		// Caduca en 15 minutos y se ajusta a uno la primera vez

			 setcookie('contador', 1, time() + 15* 60); 
//			 sleep (2); //es nesesario pausar debido a que se tiene que crear la cookie
			 	return 1;
		  }else{ 
		  // si existe cookie procede a contar  
			setcookie('contador', $_COOKIE['contador'] + 1, time() + 15 * 60); 
			 sleep (1); //es nesesario pausar debido a que se tiene que crear la cookie
				return $_COOKIE['contador'];
		  }//fin else de intentos
	
	}
}
?>