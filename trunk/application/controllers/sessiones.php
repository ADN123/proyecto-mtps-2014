<?php 

define("SERVER_MTPS","192.168.1.200");

class Sessiones extends CI_Controller {

		
	function Sessiones()
	{
        parent::__construct();
		date_default_timezone_set('America/El_Salvador');
		$this->load->model('seguridad_model');
		$this->load->model('usuario_model');
		$this->load->helper('cookie');
		$this->load->library("securimage/securimage");
		error_reporting(0);
    }

	/*
	*	Nombre: index
	*	Obejtivo: Carga la vista que contiene el formulario de login
	*	Hecha por: Jhonatan
	*	Modificada por: Leonel
	*	Ultima Modificacion: 15/03/2014
	*	Observaciones: Ninguna
	*/
	function index($estado_transaccion=200){
	
		$in=$this->verificar(1);
		if($in<=3){
			$data['estado_transaccion']=$estado_transaccion;
			$this->load->view('encabezadoLogin.php'); 
			$this->load->view('login.php', $data); 
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
									
								if($_SESSION['url']!=NULL && $_SESSION['url']!='' ) {
									redirect($_SESSION['url']);													

								}else{
									
									ir_a('index.php/inicio'); 									
								}	
							}
						}	else alerta("Usuario y clave no coinciden en Active Directory",'index.php/sessiones');	
					////////////////Fin verificacion con Active Directory
											
					} else {
							alerta("Clave incorrecta",'index.php/sessiones');	
					}
				}
				else 
				{	//se guardan los datos cuando, sin requerir verificacion en base de datos
					$this->session->set_userdata('nombre', $v['nombre_completo']);
					$this->session->set_userdata('id_usuario', $v['id_usuario']);
					$this->session->set_userdata('usuario', $v['usuario']);
					$this->session->set_userdata('nr', $v['NR']);			
					$this->session->set_userdata('id_seccion', $v['id_seccion']);
					$this->session->set_userdata('sexo', $v['sexo']);
					setcookie('contador', 1, time() + 15* 60);			
								if($_SESSION['url']!=NULL && $_SESSION['url']!='' ) {
									redirect($_SESSION['url']);													

								}else{
									
									ir_a('index.php/inicio'); 									
								}	
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
		$ldapconn = ldap_connect($ds,$puertoldap)
		or die("ERROR: No se pudo conectar con el Servidor LDAP."); 
		
		if ($ldapconn) 
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
	function recuperar($estado_transaccion=NULL, $accion=0)
	{
		echo "string";
			$data['estado_transaccion']=$estado_transaccion;
			switch ($accion) {
				case 1:
					$data['msj']="No se pudo completar la trasacion";

					break;
				case 2:
					$data['msj']="Las contraseña nuevas no coinciden";
					$data['estado_transaccion']=0;
					break;
				case 3:
					$data['msj']="La contraseña actual es incorrecta";
					$data['estado_transaccion']=0;
					break;
				default:
					$data['msj']="";
					break;
			}
	
			$this->load->view('encabezadoLogin.php'); 
			$this->load->view('usuarios/recuperar',$data); 
			$this->load->view('piePagina.php');		
		//print_r($data[empleados]);
	}
	function recuperar_clave()
	{			$correo="thanf92@gmail.com";
				$title="recuperar clave";
				$msj="Esta sera su nueva clave para acceder dsdfsdksldkflskd";
				echo "<pre>";
			//enviar_correo($correo,$title,$msj);

				$formuInfo = array(
					'password'=>'sasas',
					'id_usuario'=>'dsds'
				);
				//$this->usuario_model->actualizar_clave($formuInfo);
			echo "</pre>";
	}
		function capcha()
	{
		$img = new Securimage();
		$img->show(); 
	}

	function sendmail()
	{
		header('Content-type: application/json');
		$securimage = new Securimage();
		$correo=$this->input->post('nr');
		$captcha_code=$this->input->post('captcha_code');

		if ($securimage->check($captcha_code)) {
			$letras = "ABCDEFGHJKLMNPRSTUVWXYZ98765432";
			$contra=str_shuffle($letras);
			$contra=substr($contra,0,10);
			
			$letras2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0987654321";
			$contra2=str_shuffle($letras2);
			$contra2=substr($contra2,0,40);	
			
			$info=$this->seguridad_model->info_empleado(NULL,"id_usuario, nombre, correo",NULL,$correo);
			
			$formuInfo = array(
				'id_usuario'=>$info['id_usuario'],
				'fecha_caso'=>date('Y-m-d'),
				'nuevo_pass'=>md5($contra),
				'codigo_caso'=>$contra2
			);
			$this->seguridad_model->guardar_caso($formuInfo);
			
			$message='
				Hola '.ucwords($info['nombre']).'! Esta es tu nueva contraseña: '.$contra.'. Si la quieres activar da clic <a href="'.base_url().'index.php/sessiones/activar/'.$contra2.'" target="_blank">aquí</a>. 
					o copia el siguiente codigo en el formulario de restablecimiento <br><br>'.$contra2.'<br><br>Tiene 3 días para activar a partir  del '.date("d-m-Y H:i:s");
			
			$r= enviar_por_gmail($info['correo'],"SITCOM - Restablecimiento de Contraseña",$message);
						
			$correo2=$info['correo'];
			$needle='@';
			$pos=strripos($correo2, $needle);
			for($i=2;$i<$pos;$i++)
				$correo2[$i]="*";
			if($r=1)
				echo json_encode(array('status' => 1, 'message' => $contra));
			else
				echo json_encode(array('status' => 0, 'message' => 'Ha fallado el envío del correo'));
		}
		else {
			echo json_encode(array('status' => 0, 'message' => 'El código ingresado no es corecto!'));
		}
	}
	
	function activar($codigo_caso=NULL)
	{
		
		if ($codigo_caso!=NULL || isset($_POST['pass1'])) {
			
			if ($codigo_caso==NULL) {
				$codigo_caso=$_POST['pass1'];
			}
			$est=$caso=$this->seguridad_model->buscar_caso($codigo_caso);
			$this->index($est);

			if ($est==1) {
				//alerta("Nueva Clave Activada",'index.php/sessiones');	
			}
			if ($est==2) {
				//alerta("Se produjo un error al intentar activar la clave",'index.php/sessiones');	
			}

		}else{
			alerta("Error desconocido",'index.php/sessiones');	
			
		}

	}
}
?>