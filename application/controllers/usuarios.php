<?php
class Usuarios extends CI_Controller
{
    
    function Usuarios()
	{
        parent::__construct();
		$this->load->model('usuario_model');
		$this->load->model('transporte_model');
		$this->load->library("mpdf");
    	if(!$this->session->userdata('id_usuario')) {
			redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
		$this->roles();
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
					$data['menu']=$this->usuario_model->mostrar_menu();
					break;
				case 2:
					$data['menu']=$this->usuario_model->mostrar_menu();
					break;
				case 3:
					$data['menu']=$this->usuario_model->mostrar_menu();
					break;
			}
			$data['estado_transaccion']=$estado_transaccion;
			
			pantalla('usuarios/roles',$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: guardar_rol
	*	Objetivo: Guarda los registros de roles
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 14/05/2014
	*	Observaciones: Ninguna.
	*/
	function guardar_rol()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),78);
		
		if($data['id_permiso']!=NULL) {
			$this->db->trans_start();
			$nombre_rol=strtoupper($this->input->post('nombre_rol'));
			$descripcion_rol=$this->input->post('descripcion_rol');
			
			$formuInfo = array(
				'nombre_rol'=>$nombre_rol,
				'descripcion_rol'=>$descripcion_rol
			);
			
			$id_rol=$this->usuario_model->guardar_rol($formuInfo); /*Guardando rol*/
			$permiso=$this->input->post('permiso');
			
			for($i=0;$i<count($permiso);$i++) {
				if($permiso[$i]!="") {
					$explode_permiso=explode(",",$permiso[$i]);
					$id_modulo=$explode_permiso[0];
					$id_permiso=$explode_permiso[1];
					$formuInfo = array(
						'id_rol'=>$id_rol,
						'id_modulo'=>$id_modulo,
						'id_permiso'=>$id_permiso,
						'estado'=>1
					);
					$this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol*/
					
					$data=$this->usuario_model->buscar_padre_permisos_rol($id_modulo); 
					if($data['padre']!="") {
						$formuInfo = array(
							'id_rol'=>$id_rol,
							'id_modulo'=>$data['padre'],
							'id_permiso'=>$id_permiso,
							'estado'=>1
						);
						$total=$this->usuario_model->buscar_padre_modulo_rol($id_rol,$data['padre']);
						if($total['total']==0)
							$this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para el padre*/
					}
					
					if($data['abuelo']!="") {
						$formuInfo = array(
							'id_rol'=>$id_rol,
							'id_modulo'=>$data['abuelo'],
							'id_permiso'=>$id_permiso,
							'estado'=>1
						);
						$total=$this->usuario_model->buscar_padre_modulo_rol($id_rol,$data['abuelo']);
						if($total['total']==0)
							$this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para el abuelo*/
					}
					
					if($data['bisabuelo']!="") {
						$formuInfo = array(
							'id_rol'=>$id_rol,
							'id_modulo'=>$data['bisabuelo'],
							'id_permiso'=>$id_permiso,
							'estado'=>1
						);
						$total=$this->usuario_model->buscar_padre_modulo_rol($id_rol,$data['bisabuelo']);
						if($total['total']==0)
							$this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para el bisabuelo*/
					}
						
				}
			}
			$formuInfo = array(
				'id_rol'=>$id_rol,
				'id_modulo'=>71,
				'id_permiso'=>3,
				'estado'=>1
			);
			$this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para salir del sistema*/
			
			$this->db->trans_complete();
			ir_a('index.php/usuarios/roles/'.$this->db->trans_status());
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: usuarios
	*	Objetivo: Carga la vista de creación de usuarios
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 14/05/2014
	*	Observaciones: Ninguna.
	*/
	function crear_usuario($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),79); /*Verificacion de permiso para administrara usuarios*/
		
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
					$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					$data['empleados']=$this->usuario_model->empleados_sin_usuario($id_seccion['id_seccion']);
					break;
				case 2:
					$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					$data['empleados']=$this->usuario_model->empleados_sin_usuario($id_seccion['id_seccion']);
					break;
				case 3:
					$data['empleados']=$this->usuario_model->empleados_sin_usuario();
					break;
			}
			$data['roles']=$this->usuario_model->mostrar_roles();
			$data['estado_transaccion']=$estado_transaccion;
			
			pantalla('usuarios/crear_usuario',$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: buscar_info_adicional_usuario
	*	Objetivo: Mostrar la informacion del usuario que se necesita crear
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 14/05/2014
	*	Observaciones: Ninguna
	*/
	function buscar_info_adicional_usuario()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),79); /*Verificacion de permiso para crear solicitudes*/
		
		if($data['id_permiso']!=NULL) {
			$id_empleado=$this->input->post('id_empleado');
			$data=$this->usuario_model->info_adicional($id_empleado);
			if($data['usuario']!="")
				$estado=1;
			$json =array(
				'usuario'=>$data['usuario'],
				'estado'=>$estado
			);
			echo json_encode($json);
		}
		else {
			$json =array(
				'estado'=>0
			);
			echo json_encode($json);
		}
	}
	
	/*
	*	Nombre: guardar_usuario
	*	Objetivo: Guarda los registros de usuarios
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 14/05/2014
	*	Observaciones: Ninguna.
	*/
	function guardar_usuario()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),79);
		
		if($data['id_permiso']!=NULL) {
			$this->db->trans_start();
			$id_empleado=$this->input->post('nombre_completo');
			$password=md5($this->input->post('password'));
			
			$data=$this->usuario_model->info_adicional($id_empleado);
			
			if($data['sexo']==1) {
				$data['sexo']="M";
			}
			else 
				$data['sexo']="F";
			
			$formuInfo = array(
				'nombre_completo'=>$data['nombre'],
				'password'=>$password,
				'nr'=>$data['nr'],
				'sexo'=>$data['sexo'],
				'usuario'=>$data['usuario'],
				'id_seccion'=>$data['id_seccion'],
				'estado'=>1
			);
			
			$id_usuario=$this->usuario_model->guardar_usuario($formuInfo); /*Guardando usuario*/
			$id_rol=$this->input->post('id_rol');
			
			$formuInfo = array(
				'id_rol'=>$id_rol,
				'id_usuario'=>$id_usuario
			);
			$this->usuario_model->guardar_permisos_usuario($formuInfo); /*Guardando permisos del usuario*/
			$this->db->trans_complete();
			ir_a('index.php/usuarios/crear_usuario/'.$this->db->trans_status());
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
}
?>