<?php
class Seguridad extends CI_Controller
{
    
    function Seguridad()
	{
        parent::__construct();
		error_reporting(0);
		date_default_timezone_set('America/El_Salvador');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('seguridad_model');
		if(!$this->session->userdata('id_usuario')){
		 redirect('index.php/sessiones');
		}
    }
	
	function bitacora($d,$t)
	{
		$user = $this->session->userdata('id_usuario');
		$this->bitacora_model->insertar($d,$user,$t);
		return 0;
	}
    
	function index()
	{
		echo '<pre>';
		print_r( $this->seguridad_model->buscar_menus(22) );
		echo '</pre>';
		echo '<pre>';
		print_r( $this->seguridad_model->buscar_menus2(22) );
		echo '</pre>';
  	}
	
	function registrar_usuario_index()
	{
		$this->load->view('encabezado');
		$this->load->view('seguridad/menu_registrar_usuario');
		$this->load->view('seguridad/registrar_usuario_index');
		$this->load->view('piePagina');
	}
	
	function copia_seguridad_index()
	{
		$this->load->view('encabezado');
		$this->load->view('seguridad/menu_respaldo');
		$this->load->view('seguridad/copia_seguridad_index');
		$this->load->view('piePagina');
	}
	
	function nuevo_usuario()
	{
		$this->load->view('encabezado');
		$this->load->view('seguridad/menu_registrar_usuario');
		$this->load->view('seguridad/nuevo_usuario');
		$this->load->view('piePagina');
	}
	
	function crear_copia()
	{
		$this->load->view('encabezado');
		$this->load->view('seguridad/menu_respaldo');
		$this->load->view('seguridad/nueva_copia');
		$this->load->view('piePagina');
	}
	
	function busqueda_usuario()
	{
		$this->load->view('encabezado');
		$this->load->view('seguridad/menu_registrar_usuario');
		$data['datos'] =$this->seguridad_model->ConsultaGnral();
		$this->load->view('seguridad/busqueda_usuario',$data);
		$this->load->view('piePagina');
	}
	
	function  registrar_usuario()
	{
		$clave=$this->input->post('claveC');
		$clave2=$this->input->post('clave2C');
		$clave3=$this->input->post('clave3C');
		
		$id_usuario = $this->session->userdata('id_usuario');
		
		$clave4=$this->seguridad_model->getClave($id_usuario);
		
		if($clave3==$clave4)
		{
			$estadoC='activo';
			$usuarioInfo = array(
			'loginC'=>$this->input->post('loginC'),
			'nombreC'=>$this->input->post('nombreC'),
			'apellidoC'=>$this->input->post('apellidoC'),
			'claveC'=>$clave,
			'nivelN'=>$this->input->post('nivelN'),
			'estadoC'=>$estadoC
			);
			
			if($this->seguridad_model->insertar($usuarioInfo)==true)
			{
				$descripcion="Se registró al Usuario: ".$usuarioInfo['nombreC']." ".$usuarioInfo['apellidoC'];
				$this->bitacora($descripcion,'sin problemas');
			 	$this->load->view('info');
			}
			else
			{
				$descripcion="Se produjo un error al intentar registrar al usuario: ".$usuarioInfo['nombreC']." ".$usuarioInfo['apellidoC'];
				$this->bitacora($descripcion, 'error');
				$this->load->view('error');
			}
			
			$this->registrar_usuario_index();
		}
		else
		{
			$this->load->view('error');
		}
	}
	
	function modificar_usuario($id_user)
	{
		$q=$this->seguridad_model->consultar($id_user);
		
		if($q)
		{
			$data = array(
			'id_usuario'=>$id_user,
			'loginC'=>$q->loginC,
			'nombreC'=>$q->nombreC,
			'apellidoC'=>$q->apellidoC,
			'claveC'=>$q->claveC,
			'nivelN'=>$q->nivelN,
			'estadoC'=>$q->estadoC
			);
			
			$this->load->view('encabezado');
			$this->load->view('seguridad/menu_registrar_usuario');
			$this->load->view('seguridad/modificar_usuario', $data);
			$this->load->view('piePagina');
		}
	}
	
	function actualizar_usuario()
	{
		$id=$this->input->post('id_usuario');
		$clave=$this->input->post('claveC');
		$clave2=$this->input->post('clave2C');
		$clave3=$this->input->post('clave3C');
		
		$id_usuario = $this->session->userdata('id_usuario');
		
		$clave4=$this->seguridad_model->getClave($id_usuario);
		
		if($clave3!=$clave4)
		{		
			$this->load->view('error');
			$this->busqueda_usuario();
		}
		else
		{
			$estadoC='activo';
			$usuarioInfo = array(
			'loginC'=>$this->input->post('loginC'),
			'nombreC'=>$this->input->post('nombreC'),
			'apellidoC'=>$this->input->post('apellidoC'),
			'claveC'=>$clave,
			'nivelN'=>$this->input->post('nivelN'),
			'estadoC'=>$estadoC
			);
			
			if($this->seguridad_model->modificar($usuarioInfo,$id)==true)
			{
				$descripcion="Se modificaron los datos del Usuario ".$usuarioInfo['nombreC']." ".$usuarioInfo['apellidoC'];
				$this->bitacora($descripcion,'sin problemas');
				$this->load->view('info');
			}
			else
			{
				$descripcion="Se produjo un error al intentar modificar los datos del Usuario ".$usuarioInfo['nombreC']." ".$usuarioInfo['apellidoC'];
				$this->bitacora($descripcion,'error');
				$this->load->view('error');
			}
			
			$this->busqueda_usuario();
		}
	}
	
	function usuarios_inactivos()
	{
		$this->load->view('encabezado');
		$this->load->view('seguridad/menu_registrar_usuario');
		$data['datos'] =$this->seguridad_model->ConsultaGnralInactivos();
		$this->load->view('seguridad/busqueda_usuario_inactivo',$data);
		$this->load->view('piePagina');
	}
	
	function cambiar_estado_usuario($id_user,$n)
	{
		if($n==1)$estadoC='inactivo';
		else if($n==2)$estadoC='activo';
		
		$data=$this->seguridad_model->getNombreUsuario($id_user);
		
		$usuarioInfo = array(
		'estadoC'=>$estadoC
		);
			
		if($this->seguridad_model->cambiar_estado($id_user,$usuarioInfo)==true)
		{
			if($n==1) $descripcion="Se dió de baja al Usuario: ".$data->nombreC." ".$data->apellidoC;
			else if($n==2) $descripcion="Se dió de alta al Usuario: ".$data->nombreC." ".$data->apellidoC;
			
			$this->bitacora($descripcion,'sin problemas');
			$this->load->view('info');
		}
		else
		{
			if($n==1) $descripcion="Se produjo un error al intentar dar de baja al Usuario: ".$data->nombreC." ".$data->apellidoC;
			else if($n==2) $descripcion="Se produjo un error al intentar dar de alta al Usuario: ".$data->nombreC." ".$data->apellidoC;
			
			$this->bitacora($descripcion,'error');
			$this->load->view('error');
		}
			
		if($n==1) redirect('index.php/seguridad/busqueda_usuario'); 
		else if($n==2) redirect('index.php/seguridad/usuarios_inactivos');
	}
	
	/////////////////////////////////////////funciones del respaldo///////////////////////
	
	function crear_nueva_copia()
	{
		$copia=$this->input->post('nombreC');
		$usuario="root";
		$p="root";
		$bd="sisclidenbd"; //
		// mysql_select_db($bd,$conexion);
		$sec=date('d-m-y');
		$hora = date('H')."-".date('i')."-".date('s');
		if($copia=="")
			$bdatos="BASE_DE_DATOS_SISCLIDEN(".$sec.")(".$hora.").sql";
		else 
			$bdatos="".$copia."(".$sec.")(".$hora.").sql";
		$executa = "C:\AppServ\MySQL\bin\mysqldump.exe -u $usuario --password=$p --opt $bd > ".$bdatos;//
		system($executa);
		// Inserta el nombre del backUp en latablas backups de la base de datos de respaldos
		$fechaF=date("Y-m-d");
		$this->conectar_base_copia();
		mysql_query("INSERT INTO backuptb(nombreC,fechaF) values('$bdatos','$fechaF')");
		mysql_close();
		
		$descripcion="Se creó una copia de seguridad de la base de datos: ".$bdatos;
		$this->bitacora($descripcion,'sin problemas');
		
		$this->load->view('info');
		$this->copia_seguridad_index();
	}
	
	function restaurar_copia()
	{
		$this->load->view('encabezado');
		$this->load->view('seguridad/menu_respaldo');
		$this->load->view('seguridad/restaurar_copia');
		$this->load->view('piePagina');
	}
	
	function restaurar_copia_seguridad($id)
	{
		$bd="sisclidenbd";
		$usuario="root";
		$p="root";
		$this->conectar_base_copia();
		$con=mysql_query("SELECT nombreC FROM backuptb WHERE id_backup='$id'");
		if($row=mysql_fetch_array($con))
			$nombre=$row['nombreC'];
		mysql_close();
		try 
		{
			$executa = "C:\AppServ\MySQL\bin\mysql.exe -u $usuario --password=$p $bd <".$nombre;  
		}
		catch(Exception  $e)
		{
			//echo '1 Excepción capturada: '.  $e->getMessage(). "\n";
		}
		try 
		{
			system($executa,$resultado);
		}
		catch(Exception  $e)
		{
			//echo '2 Excepción capturada: '.  $e->getMessage(). "\n";
		}
		if ($resultado)
		{
			$descripcion="Se produjo un error al intentar restaurar una copia de seguridad de la base de datos: ".$nombre;
			$this->bitacora($descripcion,'error');
			$this->load->view('error');
			$this->restaurar_copia();
		}
		else
		{
			$descripcion="Se restauró una copia de seguridad de la base de datos: ".$nombre;
			$this->bitacora($descripcion,'sin problemas');
			$this->load->view('info');
			$this->copia_seguridad_index();
		}
	}
	function restaurar_copia_seguridad2()
	{
		$bd="sisclidenbd";
		$usuario="root";
		$p="root";
		
		$nombre=$_POST['archivo'];
		
		$this->conectar_base_copia();
		
		
	//////////////////////
		
		try 
		{
			$executa = "C:\AppServ\MySQL\bin\mysql.exe -u $usuario --password=$p $bd < ".$nombre;  
		$fechaF=date("Y-m-d");
		$bdatos=$nombre;
		mysql_query("INSERT INTO backuptb(nombreC,fechaF) values('$bdatos','$fechaF')");
		mysql_close();
		}
		catch(Exception  $e)
		{
			//echo '1 Excepción capturada: '.  $e->getMessage(). "\n";
		}
		try 
		{
			system($executa,$resultado);
		}
		catch(Exception  $e)
		{
			//echo '2 Excepción capturada: '.  $e->getMessage(). "\n";
		}
		if ($resultado)
		{
			$descripcion="Se produjo un error al intentar restaurar una copia de seguridad de la base de datos: ".$nombre;
			$this->bitacora($descripcion,'error');
			$this->load->view('error');
			$this->restaurar_copia();
		}
		else
		{
			$descripcion="Se restauró una copia de seguridad de la base de datos: ".$nombre;
			$this->bitacora($descripcion,'sin problemas');
			$this->load->view('info');
			$this->copia_seguridad_index();
			
		}
		
	}
	
	function conectar_base_copia(){
		mysql_connect("localhost","root","root");
		mysql_select_db("sisclidenbd_respaldo");
		return ;
		
		}
	
	
}
?>