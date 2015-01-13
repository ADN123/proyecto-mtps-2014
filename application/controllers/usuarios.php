<?php
class Usuarios extends CI_Controller
{
    
    function Usuarios()
	{
        parent::__construct();
		date_default_timezone_set('America/El_Salvador');
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
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function roles($estado_transaccion=NULL,$accion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),84); /*Verificacion de permiso para administrara roles*/
		
		if($data['id_permiso']==3) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
					$data['roles']=$this->usuario_model->mostrar_roles();
					break;
				case 2:
					$data['roles']=$this->usuario_model->mostrar_roles();
					break;
				case 3:
					$data['roles']=$this->usuario_model->mostrar_roles();
					break;
			}
			$data['estado_transaccion']=$estado_transaccion;
			if($accion==0)
				$data['accion']="elimina";
			if($accion==1)
				$data['accion']="actualiza";
			if($accion==2)
				$data['accion']="guarda";
			pantalla('usuarios/roles',$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: datos_de_rol
	*	Objetivo: Carga la vista para crear o modificar los roles
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 03/07/2014
	*	Observaciones: Ninguna.
	*/
	function datos_de_rol($id_rol=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),84); /*Verificacion de permiso para administrara roles*/
		
		if($data['id_permiso']==3) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
					$data['menu']=$this->usuario_model->mostrar_menu($id_rol);
					break;
				case 2:
					$data['menu']=$this->usuario_model->mostrar_menu($id_rol);
					break;
				case 3:
					$data['menu']=$this->usuario_model->mostrar_menu($id_rol);
					break;
			}
			
			if($id_rol!=NULL)			
				$data['rol']=$this->usuario_model->mostrar_roles($id_rol);
			else
				$data['rol']=array();
				
			$this->load->view('usuarios/formu_rol',$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: guardar_rol
	*	Objetivo: Guarda los registros de roles
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function guardar_rol()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),84);
		
		if($data['id_permiso']==3) {
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
				'id_modulo'=>77,
				'id_permiso'=>3,
				'estado'=>1
			);
			$this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para salir del sistema*/
			
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/usuarios/roles/'.$tr.'/2');
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: actualizar_rol
	*	Objetivo: Actualiza los registros de roles
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function actualizar_rol() 
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),84);
		
		if($data['id_permiso']==3) {
			$this->db->trans_start();
			$id_rol=$this->input->post('id_rol');
			$nombre_rol=strtoupper($this->input->post('nombre_rol'));
			$descripcion_rol=$this->input->post('descripcion_rol');
			
			$formuInfo = array(
				'id_rol'=>$id_rol,
				'nombre_rol'=>$nombre_rol,
				'descripcion_rol'=>$descripcion_rol
			);
			
			$this->usuario_model->actualizar_rol($formuInfo); /*Actualizar rol*/
			$this->usuario_model->eliminar_permisos_rol($id_rol); /*Eliminar permisos del rol*/
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
				'id_modulo'=>77,
				'id_permiso'=>3,
				'estado'=>1
			);
			$this->usuario_model->guardar_permisos_rol($formuInfo); /*Guardando permisos del rol para salir del sistema*/
			
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/usuarios/roles/'.$tr.'/1');
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: eliminar_rol
	*	Objetivo: Elimina los registros de roles
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function eliminar_rol($id_rol=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),84);
		
		if($data['id_permiso']==3) {
			$this->db->trans_start();
			$this->usuario_model->eliminar_rol($id_rol); /*Eliminar rol*/
			$this->usuario_model->eliminar_permisos_rol($id_rol); /*Eliminar permisos del rol*/
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/usuarios/roles/'.$tr.'/0');
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: usuario
	*	Objetivo: Carga la vista para la administracion de los usuarios
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function usuario($estado_transaccion=NULL,$accion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),85); /*Verificacion de permiso para administrara usuarios*/
		
		if($data['id_permiso']==3) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
					$data['usuarios']=$this->usuario_model->mostrar_usuarios();
					break;
				case 2:
					$data['usuarios']=$this->usuario_model->mostrar_usuarios();
					break;
				case 3:
					$data['usuarios']=$this->usuario_model->mostrar_usuarios();
					break;
			}
			$data['estado_transaccion']=$estado_transaccion;
			if($accion==0)
				$data['accion']="elimina";
			if($accion==1)
				$data['accion']="actualiza";
			if($accion==2)
				$data['accion']="guarda";
			pantalla('usuarios/usuarios',$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
		
	/*
	*	Nombre: datos_de_usuario
	*	Objetivo: Carga la vista del formulario creación o actualización de usuarios
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function datos_de_usuario($id_usuario=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),85); /*Verificacion de permiso para administrara usuarios*/
		
		if($data['id_permiso']==3) {
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
			
			if($id_usuario!=NULL)			
				$data['usu']=$this->usuario_model->mostrar_usuarios($id_usuario);
			else
				$data['usu']=array();
			
			$this->load->view('usuarios/formu_usuario',$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: buscar_info_adicional_usuario
	*	Objetivo: Mostrar la informacion del usuario que se necesita crear
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna
	*/
	function buscar_info_adicional_usuario()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),85); /*Verificacion de permiso para crear solicitudes*/
		
		if($data['id_permiso']==3) {
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
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function guardar_usuario()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),85);
		
		if($data['id_permiso']==3) {
			$this->db->trans_start();
			$id_empleado=$this->input->post('nombre_completo');
			$usuario=$this->input->post('usuario');
			$password=md5($this->input->post('password'));
			
			$data=$this->usuario_model->info_adicional($id_empleado);
			

			if($data['id_genero']==1) {
				$data['id_genero']="M";
			}
			else 
				$data['id_genero']="F";
			
			$formuInfo = array(
				'nombre_completo'=>$data['nombre'],
				'password'=>$password,
				'nr'=>$data['nr'],
				'sexo'=>$data['id_genero'],
				'usuario'=>$usuario,
				'id_seccion'=>$data['id_seccion'],
				'estado'=>1
			);
			
			$id_usuario=$this->usuario_model->guardar_usuario($formuInfo); /*Guardando usuario*/
			$id_rol=$this->input->post('id_rol');

			for($i=0;$i<count($id_rol);$i++) {
				$formuInfo = array(
					'id_rol'=>$id_rol[$i],
					'id_usuario'=>$id_usuario
				);
				$this->usuario_model->guardar_permisos_usuario($formuInfo); /*Guardando permisos del usuario*/
			}
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/usuarios/usuario/'.$tr.'/2');
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: actualizar_usuario
	*	Objetivo: Actualiza los registros de usuarios
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function actualizar_usuario()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),85);
		
		if($data['id_permiso']==3) {
			$this->db->trans_start();
			$id_usuario=$this->input->post('id_usuario');
			$password=$this->input->post('password');
			if($password!="") {			
				$formuInfo = array(
					'password'=>$password,
					'id_usuario'=>$id_usuario
				);
				$this->usuario_model->actualizar_usuario($formuInfo); /*Actualizar usuario*/

			}
			
			$this->usuario_model->eliminar_roles_usuario($id_usuario); /*Eliminar permisos del usuario*/
			
			$id_rol=$this->input->post('id_rol');

			for($i=0;$i<count($id_rol);$i++) {
				$formuInfo = array(
					'id_rol'=>$id_rol[$i],
					'id_usuario'=>$id_usuario
				);
				$this->usuario_model->guardar_permisos_usuario($formuInfo); /*Guardando permisos del usuario*/
			}
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/usuarios/usuarios/'.$tr.'/1');
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	
	/*
	*	Nombre: eliminar_usuario
	*	Objetivo: Desvactiva los registros de usuarios
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: No elimina, solo cambia a cero el estado del usuario.
	*/
	function eliminar_usuario($id_usuario=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),85);
		
		if($data['id_permiso']==3) {
			$this->db->trans_start();
			$this->usuario_model->desactivar_usuario($id_usuario); /*Desactivar usuario*/
			/*$this->usuario_model->eliminar_usuario($id_usuario);*/ /*Eliminar usuario*/
			/*$this->usuario_model->eliminar_permisos_usuario($id_usuario);*/ /*Eliminar permisos del usuario*/
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/usuarios/usuario/'.$tr.'/0');
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	function perfil($estado_transaccion=NULL, $accion=0)
	{
		$data['estado_transaccion']=$estado_transaccion;
			switch ($accion) {
				case 1:
					$data['msj']="No se pudo completar la trasacion";

					break;
				case 2:
					$data['msj']="Las confirmacion de la contraseña nueva no conincide";
					$data['estado_transaccion']=0;
					break;
				case 3:
					$data['msj']="La contraseña actual es incorrecta";
					$data['estado_transaccion']=0;
					break;
				default:
					//$data['msj']="";
					break;
			}
	
		
		$data['empleados']=$this->transporte_model->consultar_empleado($this->session->userdata('nr'));
		//$data['empleados']=$this->usuario_model->consultar_usuario($this->session->userdata('nr'));
					foreach($data['empleados'] as $val) {
						$data['info']=$this->transporte_model->info_adicional($val['NR']);
		
		}
		pantalla('usuarios/clave',$data);
		//print_r($data[empleados]);
	}
	function cambiar_clave()
	{
		
			$login=$this->session->userdata('usuario');
			$clave =$this->input->post('pass1');			
			$id_usuario=$this->session->userdata('id_usuario');
		

			$v=$this->seguridad_model->consultar_usuario($login,$clave);  //Verificación en base de datos
			
		if($v['id_usuario']!=0){/*El usuario y la contraseñan son correctos*/
			if($_POST[pass2]==$_POST[pass3]){
				$formuInfo = array(
					'password'=>$_POST[pass2],
					'id_usuario'=>$id_usuario,
					'email'=>$_POST[email]
				);
				$this->db->trans_start();
				$this->usuario_model->actualizar_usuario($formuInfo); /*Actualizar usuario*/			
				$this->db->trans_complete();
				$tr=($this->db->trans_status()===FALSE)?0:1;
				
			$accion=1;
			}else{
				//echo "Las contraseña nuevas no coinciden";
				$accion=2;
				$tr=0;
			}
		}else{
			//echo "La contraseña actual es incorrecta";
			$accion=3;
			$tr=0;

		}	
	
	ir_a('index.php/usuarios/perfil/'.$tr.'/'.$accion);
	}

}
?>