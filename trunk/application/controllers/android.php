<?php 
class Android extends CI_Controller {
		
	function Android()
	{
        parent::__construct();
		$this->load->model('android_model');
		$this->load->model('transporte_model');
		$this->load->model('seguridad_model');
    }

	
	
	/*
	*	Nombre: iniciar_session
	*	Obejtivo: Verificar que el nick y password introducidos por el usuario sean correctos
	*	Hecha por: Jhonatan
	*	Modificada por: Leonel
	*	Ultima Modificacion: 01/04/2014
	*	Observaciones: La variable de session "id_seccion" no la deberiamos ocupar, deberiamos ir a buscar el registro actual del usuario logueado cada vez que se requiera
	*/
	function index()
	{
		
//		$v=$this->android_model->salida_entrada(); 
$v=$this->transporte_model->salidas_entradas_vehiculos();
	$j=json_encode($v);
		echo $j;
	}
	
	function accesorios($estado, $id){
		
		if ($estado==4) {
			$j=$this->transporte_model->accesoriosABordo($id);			
		} else {
			$j=$this->transporte_model->accesorios();			
		}
		

		$j=json_encode($j);
		echo $j;
		}
		

	function kilometraje($placa){
		$j=$this->android_model->kilometraje($placa);
		$j=json_encode($j);
		echo $j;
			
		}

	function registrar(){
	
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
			echo $this->db->trans_status();	
		
		
		}
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

	function getSession($login, $clave)
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

		$v=$this->seguridad_model->consultar_usuario($login,$clave);  //Verificación en base de datos
		echo json_encode($v);
	}


}
?>