<?php 
class Sessiones extends CI_Controller {
	
	function Sessiones()
	{
        parent::__construct();
		$this->load->model('seguridad_model');
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
	  	$this->load->view('encabezadoLogin.php'); 
	  	$this->load->view('login.php'); 
		$this->load->view('piePagina.php');
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

		$login =$this->input->post('user');
		$clave =$this->input->post('pass');
	
	
					//añadimos 1 a la sesión
			$_SESSION['intentos']++ ;
			//Comprobamos intentos
			if ($_SESSION['intentos'] <3)
			{

				$v=$this->seguridad_model->consultar_usuario($login,$clave);
		
				if($v['id_usuario']==0) {
					$json =array(
						'estado'=>"0",
						'msj'=>"Error al intentar ingresar al sistema: "
					);
					echo json_encode($json);
					//redirect('index.php/sessiones');
				}
				else {
					$this->session->set_userdata('nombre', $v['nombre_completo']);
					$this->session->set_userdata('id_usuario', $v['id_usuario']);
					$this->session->set_userdata('usuario', $v['usuario']);
					$this->session->set_userdata('nr', $v['NR']);			
					$this->session->set_userdata('id_seccion', $v['id_seccion']);			
					$json =array(
						'estado'=>1,
						'msj'=>"Iniciando Session...."
					);
					echo json_encode($json);
					//redirect('index.php'); 
				}
	}else{
					$json =array(
						'estado'=>"3",
						'msj'=>"Demasiados intentos. Sistema bloqueado",
						'intentos'=>$_SESSION['intentos']
					);
					echo json_encode($json);
		
		
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
		


}
?>