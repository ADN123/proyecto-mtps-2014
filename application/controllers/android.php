<?php 


class Android extends CI_Controller {
	function Android()
	{
        parent::__construct();
		date_default_timezone_set('America/El_Salvador');
		$this->load->model('android_model');
		$this->load->model('transporte_model');
		$this->load->model('seguridad_model');
    }

	
	
	function index()
	{		$v=$this->transporte_model->salidas_entradas_vehiculos();
			$j=json_encode($v);
				echo $j;}
		/*
	*	Nombre: lista
	*	Obejtivo: Mostrar la lista de misiones listas para salir o en proceso correspondiente a cada oficina o departamento 
	*	Hecha por: Jhonatan
	*	Ultima Modificacion: 13/05/2014
	*	Observaciones: 	*/

	function lista($lugar){

		
		$v=$this->transporte_model->salidas_entradas_vehiculos();
			$j=json_encode($v);
				echo $j;

	}
	/*
	*	Nombre: accesorios
	*	Obejtivo: devolver una lista de accesorios que posee un vehiculo ($id) se basa en lo que llevo en la ultima salida
	* 	en caso contrario de que se nueva mision muestra todos los objetos
	*	Hecha por: Jhonatan
	*	Ultima Modificacion: 3/05/2014
	*	Observaciones: 	*/
	function accesorios($estado, $id){
		
		if ($estado==4) {
			$j=$this->transporte_model->accesoriosABordo($id);			
		} else {
			$j=$this->transporte_model->accesorios();			
		}
		

		$j=json_encode($j);
		echo $j;
		}
	/*
	*	Nombre: kilometraje
	*	Obejtivo: Recibe una placa y devuleve dos valores de kilometraje: entrada y salida respectivamente
	*	Hecha por: Jhonatan
	*	Ultima Modificacion: 3/05/2014
	*	Observaciones: 	*/	

	function kilometraje($placa){
		$j=$this->android_model->kilometraje($placa);
		$j=json_encode($j);
		echo $j;
			
		}
	/*
	*	Nombre: registrar
	*	Obejtivo: registrar la salida o entrada de vehiculo
	*	Hecha por: Jhonatan
	*	Ultima Modificacion: 13/05/2014
	*	Observaciones: 	*/

	function registrar(){
		error_reporting(0);	
//	print_r($_POST);
		$this->db->trans_start();
			$estado=$this->input->post('estado');
			$id=$this->input->post('id');
			$km=$this->input->post('km');
			$gas=$this->input->post('gas');
			$hora=date("H:i:s", strtotime($this->input->post('hora')));	
			/*remuevo de post los datos para que solo queden los accesorios*/
			$acces=$_POST;
			unset($acces['estado']);
			unset($acces['gas']);
			unset($acces['id']);
			unset($acces['km']);
			unset($acces['hora']);			
			if($estado==3){
				$this->transporte_model->salida_vehiculo($id, $km,$hora,$acces);
			}else {				
				if($estado==4) {
				$this->transporte_model->regreso_vehiculo($id, $km, $hora, $gas,$acces);					  

				}
			}
		$this->db->trans_complete();			
			$resp= $this->db->trans_status();	

			if(resp){
				echo 1;
			}else{
				echo 0;
			}
		
		
		}

	/*
	*	Nombre: iniciar_session
	*	Obejtivo: Verificar que el nick y password introducidos por el usuario sean correctos
	*	Hecha por: Jhonatan
	*	Ultima Modificacion: 13/05/2014
	*	Observaciones: 	*/

	function iniciar_session(){
		error_reporting(0);

					$login =$this->input->post('user');
					$clave =$this->input->post('pass');			
					$v=$this->seguridad_model->consultar_usuario($login,$clave);  //Verificación en base de datos
				
					if($v['id_usuario']==0) {
						echo 0; //credeciales incorrectas

						
					}else {
					$data=$this->seguridad_model->consultar_permiso($v['id_usuario'],67);
						
						if($data['id_permiso']!=NULL) {
								echo 2; //todo bien
						}else{
								echo 1; //logeado pero sin permisos
						}
						
					//falta verificar si tiene permiso para usar la app movil
					
					}	
			
	}

	/*
	*	Nombre: getSession
	*	Obejtivo: Enviar datos de session
	*	Hecha por: Jhonatan
	*	Ultima Modificacion: 13/05/2014
	*	Observaciones: 	*/

	function getSession()
	{
		///datos de session 
	/*
		$this->session->set_userdata('nombre', $v['nombre_completo']);
		$this->session->set_userdata('id_usuario', $v['id_usuario']);
		$this->session->set_userdata('usuario', $v['usuario']);
		$this->session->set_userdata('nr', $v['NR']);			
		$this->session->set_userdata('id_seccion', $v['id_seccion']);
				$login =$this->input->post('user');
		$clave =$this->input->post('pass');			
	*/

echo 568;
	}


}
?>