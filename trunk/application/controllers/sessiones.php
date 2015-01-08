<?php 

define("SERVER_MTPS","192.168.1.200");

class Sessiones extends CI_Controller {

		
	function Sessiones()
	{
        parent::__construct();
		date_default_timezone_set('America/El_Salvador');
		$this->load->model('seguridad_model');
		$this->load->helper('cookie');
		//error_reporting(0);
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
	
		$in=$this->verificar(1);
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
	*	Modificada por: Oscar
	*	Ultima Modificacion: 17/11/2014
	*	Observaciones: Funciona con el Active Directory
	*/
	function iniciar_session()
	{
		$in=$this->verificar();
		error_reporting(0);
		if ($in<=3)
		{				
			$login =$this->input->post('user');
			$clave =$this->input->post('pass');		
		$v=$this->seguridad_model->consultar_usuario2($login); //verifica únicamente por el nombre de usuario
		
		if($v['id_usuario']!=0){/*se verifica que el usuario exista*/
			/////////////////////////////verificacion de usuario con la contraseña////////////////////////////
				$v=$this->seguridad_model->consultar_usuario($login,$clave);  //Verificación en base de datos
				
				if($v['id_usuario']==0)/*El usuario y la contraseñan son incorrectos*/
				{
						
					if (SERVER_MTPS==$_SERVER['SERVER_NAME']) { //Se verifica que active directory este disponible
					
						/*Procedemos a buscar en el Active Directory*/
						$active=$this->ldap_login($login,$clave); /// verifica si existe ese usuario con el password en el Active Directory
						if($active=="login")
						{
							$v=$this->seguridad_model->consultar_usuario2($login); //verifica únicamente por el nombre de usuario
							if($v['id_usuario']==0)/*Si el usuario no ingreso sus datos correctamente*/
							{
								alerta("Clave incorrecta",'index.php/sessiones');	
							}
							else 
							{
								$this->session->set_userdata('nombre', $v['nombre_completo']);
								$this->session->set_userdata('id_usuario', $v['id_usuario']);
								$this->session->set_userdata('usuario', $v['usuario']);
								$this->session->set_userdata('nr', $v['NR']);			
								$this->session->set_userdata('id_seccion', $v['id_seccion']);
								$this->session->set_userdata('sexo', $v['sexo']);
								setcookie('contador', 1, time() + 15* 60);			
								ir_a('index.php/inicio'); 
							}
						}
						else alerta("Usuario y clave no coinciden en Active Directory",'index.php/sessiones');	
					////////////////Fin verificacion con Active Directory
											
					} else {
							alerta("Clave incorrecta",'index.php/sessiones');	
					}
				}
				else 
				{
					$this->session->set_userdata('nombre', $v['nombre_completo']);
					$this->session->set_userdata('id_usuario', $v['id_usuario']);
					$this->session->set_userdata('usuario', $v['usuario']);
					$this->session->set_userdata('nr', $v['NR']);			
					$this->session->set_userdata('id_seccion', $v['id_seccion']);
					$this->session->set_userdata('sexo', $v['sexo']);
					setcookie('contador', 1, time() + 15* 60);			
					ir_a('index.php/inicio'); 
				}
			////////////////////Fin de la verifiaciacion de usuario y contraseña
			}else{
			alerta("El usuario no esta registrado",'index.php/sessiones');	
			}
		}
		else
		{
			alerta($in." intentos. terminal bloqueada",'index.php/sessiones');
		
		}
	
		
	}
	
	/*
	*	Nombre: ldap_login
	*	Obejtivo: Verificar si password introducido por el usuario es del Active Directory o no.
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Ultima Modificacion: 25/11/2014
	*	Observaciones:
	*/
	
	function ldap_login($user,$pass)
	{
		$ldaprdn = $user.'@trabajo.local';
		$ldappass = $pass;
		$ds = 'trabajo.local';
		$dn = 'dc=trabajo,dc=local';
		$puertoldap = 389; 
		//$ldapconn = ldap_connect($ds,$puertoldap)
		//or die("ERROR: No se pudo conectar con el Servidor LDAP."); 
		
		if (ldap_connect($ds,$puertoldap)) 
		{ 
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3); 
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0); 
			$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
			if ($ldapbind) 
			{ 
				return "login";
			}
			else 
			{ 
				return "error";
			} 
		}
		else 
		{ 
			return "error";
		}
		ldap_close($ldapconn);
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
	function verificar($get=NULL){
		$in;
				 	
		  if(!isset($_COOKIE['contador']))
		  { 		// Caduca en 10 minutos y se ajusta a uno la primera vez

			 
			 if($get==NULL)  {
			 	setcookie('contador', 1, time() + 10* 60); 
			 }

			 	return 1;
		  }else{ 
		  // si existe cookie procede a contar  
			if($get==NULL) {
				setcookie('contador', $_COOKIE['contador'] + 1, time() + 15 * 60); 
			}

			 sleep (1); //es nesesario pausar debido a que se tiene que crear la cookie
				return $_COOKIE['contador'];
		  }//fin else de intentos
	
	}
}
?>