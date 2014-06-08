<?php
class Vales extends CI_Controller
{
    
    function Vales()
	{
        parent::__construct();
		date_default_timezone_set('America/El_Salvador');
		$this->load->model('vales_model');
		$this->load->model('transporte_model');
		$this->load->library("mpdf");
    	if(!$this->session->userdata('id_usuario')){
			redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
		$this->ingreso_vales();
  	}

	/*
	*	Nombre: ingreso_vales
	*	Objetivo: Carga la vista para el ingreso de vales de combustible
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 28/04/2014
	*	Observaciones: Ninguna.
	*/
	function ingreso_vales($estado_transaccion=NULL) 
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),63); 
		
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) {
				case 1:

				case 2:
				case 3:
			}
			$data['gasolineras']=$this->vales_model->consultar_gasolineras();
			$data['estado_transaccion']=$estado_transaccion;
			$data['fuente_fondo']=$this->transporte_model->consultar_fuente_fondo();
			pantalla("vales/ingreso",$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}	
	}
	
	/*
	*	Nombre: guardar_vales
	*	Objetivo: guarda los datos de los vales de combustible
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 28/04/2014
	*	Observaciones: Ninguna.
	*/
	function guardar_vales() 
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),63); /*Verificacion de permiso para crear solicitudes*/
		
		if($data['id_permiso']!=NULL) {
			$this->db->trans_start();
			$fec=str_replace("/","-",$this->input->post('fecha_recibido'));
			$fecha_recibido=date("Y-m-d", strtotime($fec));
			$inicial=$this->input->post('inicial');
			$cantidad_restante=$this->input->post('cantidad');
			$tipo_vehiculo=$this->input->post('tipo_vehiculo');
			$valor_nominal=$this->input->post('valor_nominal');
			$id_gasolinera=$this->input->post('id_gasolinera');
			$final=$this->input->post('inicial')+$this->input->post('cantidad')-1;
			$id_usuario_crea=$this->session->userdata('id_usuario');
			$fecha_creacion=date('Y-m-d H:i:s');
			
			$formuInfo = array(
				'inicial'=>$inicial,
				'final'=>$final,
				'valor_nominal'=>$valor_nominal,
				'tipo_vehiculo'=>$tipo_vehiculo,
				'id_gasolinera'=>$id_gasolinera,
				'id_usuario_crea'=>$id_usuario_crea,
				'fecha_creacion'=>$fecha_creacion,
				'fecha_recibido'=>$fecha_recibido,
				'cantidad_restante'=>$cantidad_restante
			);
			
			$this->vales_model->guardar_vales($formuInfo);
			
			$this->db->trans_complete();
			ir_a('index.php/vales/ingreso_vales/'.$this->db->trans_status());
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	
	/*
	*	Nombre: ingreso_requisicion
	*	Objetivo: Cargar la vista de la requisicion (solicitud) de combustible
	*	Hecha por: Leonel
	*	Modificada por: Jhonatan
	*	Última Modificación: 05/06/2014
	*	Observaciones: Ninguna.
	*/
	function ingreso_requisicion($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),75); /*Verificacion de permiso para crear requisiciones*/
		$url='vales/entrega';
		$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));	
		//$data['id_permiso']=$permiso;
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
				case 2://seccion
					$data['oficinas']=$this->vales_model->consultar_oficinas($id_seccion['id_seccion']);
					$data['fuente']=$this->vales_model->consultar_fuente_fondo($id_seccion['id_seccion']);
					$data['vehiculos']=$this->vales_model->vehiculos($id_seccion['id_seccion']);
						if(sizeof($data['vehiculos'])==0){
							$url.='error';	
						}
					break;
				case 3://administrador
					$data['oficinas']=$this->vales_model->consultar_oficinas();
					$data['fuente']=$this->vales_model->consultar_fuente_fondo();

					break;
				case 4: //departamental
					

						if($this->vales_model->is_departamental($id_seccion['id_seccion'])){// fuera de san salvador
							
								$data['oficinas']=$this->vales_model->consultar_oficinas($id_seccion['id_seccion']);
								$data['fuente']=$this->vales_model->consultar_fuente_fondo($id_seccion['id_seccion']);
								$data['vehiculos']=$this->vales_model->vehiculos($id_seccion['id_seccion']);
									if(sizeof($data['vehiculos'])==0){
												$url.='error';	
										}
						}else{//san salvador
			
								$data['oficinas']=$this->vales_model->consultar_oficinas_san_salvador();
								$data['fuente']=$this->vales_model->consultar_fuente_fondo_san_salvador();

						}

					break;
					
			}

			$data['estado_transaccion']=$estado_transaccion;
/*			 echo "<br>  id seccion ".$id_seccion['id_seccion']." permiso ".$data['id_permiso'];
			print_r($data['oficinas']);  */

			pantalla($url,$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
		/*
	*	Nombre: guardar_requisicion
	*	Objetivo: Guardar la requisicion de una seccion
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 25/05/2014
	*	Observaciones: Ninguna.
	*/

	function guardar_requisicion()
	{
		$this->db->trans_start();

		$id_usuario=$this->session->userdata('id_usuario');
		$id_empleado_solicitante=$this->vales_model->get_id_empleado($this->session->userdata('nr')); 
		$id_requisicion=$this->vales_model->guardar_requisicion($_POST, $id_usuario, $id_empleado_solicitante);

		$vehiculos=$this->input->post('values');
			for($i=0;$i<count($vehiculos);$i++) {
				$this->vales_model->guardar_req_veh($vehiculos[$i], $id_requisicion);
			}
		$this->db->trans_complete();
			ir_a('index.php/vales/ingreso_requisicion/'.$this->db->trans_status());		
	}
	/*
	*	Nombre: vehiculos
	*	Objetivo: Cargar por ajax los vehiculos de una seccion y fuente de fonodo segun selccione el usuario 
		en la pantalla de ingrese de requisicion de combustible 
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 21/05/2014
	*	Observaciones: Ninguna.
	*/
	function vehiculos($id_seccion=NULL, $id_fuente_fondo = NULL)
	{

	$data['vehiculos']=$this->vales_model->vehiculos($id_seccion, $id_fuente_fondo);
	$this->load->view("vales/vehiculos",$data);
		

	}
	
	/*
	*	Nombre: requisiciones_pdf
	*	Objetivo: Cargar el PDF 
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 07/06/2014
	*	Observaciones: Ninguna.
	*/
	function requisiciones_pdf()
	{
		$this->load->view("vales/requisicion_pdf");
	}

		/*
	*	Nombre: visto bueno
	*	Objetivo: Aprobar y asignar los vales a entregar a la oficina, o en su defecto rechazar la peticion
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 7/06/2014
	*	Observaciones: Ninguna.
	*/

	function visto_bueno($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),80); /*Verificacion de permiso para crear requisiciones*/
		$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));	
		//$data['id_permiso']=$permiso;
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
				case 2://seccion
				$data['datos']=$this->vales_model->consultar_requisiciones($id_seccion['id_seccion'], 1);


					break;
				case 3://administrador
				$data['datos']=$this->vales_model->consultar_requisiciones(NULL,1);					

					break;
				case 4: //departamental
					

						if($this->vales_model->is_departamental($id_seccion['id_seccion'])){// fuera de san salvador

							$data['datos']=$this->vales_model->consultar_requisiciones($id_seccion['id_seccion'], 1);
						}else{//san salvador
							$data['datos']=$this->vales_model->consultar_requisiciones_san_salvador(1);

						}

					break;
					
			}

			$data['estado_transaccion']=$estado_transaccion;
			//print_r($data);
			pantalla("vales/visto_bueno",$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
		

	}

/*
	*	Nombre: dialogo_visto bueno
	*	Objetivo: 	cargar el cuadro de dialogo mediante ajax en la pantalla de visto_bueno
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 7/06/2014
	*	Observaciones: Ninguna.
	*/

function dialogo_visto_bueno($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),80);
		if(isset($data['id_permiso'])&& $data['id_permiso']>=2 ) {
			$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			$datos['d']=$this->vales_model->info_requisicion($id);
			$datos['f']=$this->vales_model->info_requisicion_vehiculos($id);
			$datos['id']=$id;
			$this->load->view('vales/dialogo_visto_bueno',$datos);
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}


/*
	*	Nombre: guardar_visto bueno
	*	Objetivo: 	Guardar la informacion o respuesta del usuario en visto bueno
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 7/06/2014
	*	Observaciones: Utilizo el arreglo POST para faciclitar la transferencia de datos al modelo
	*/
function guardar_visto_bueno()
{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),80);
		$id_empleado=$this->vales_model->get_id_empleado($this->session->userdata('nr')); 
		$_POST['id_usuario']=$this->session->userdata('id_usuario');
		$_POST['id_empleado']=$id_empleado;

		if($data['id_permiso']!=NULL) {
			
				$this->db->trans_start();
				$this->vales_model->guardar_visto_bueno($_POST);
				$this->db->trans_complete();
				ir_a('index.php/vales/visto_bueno/'.$this->db->trans_status());		

		}else{
				echo 'No tiene permisos para acceder';
		}

	}

		/*
	*	Nombre: autorizar_requisicion
	*	Objetivo: Aprobar y asignar los vales a entregar a la oficina, o en su defecto rechazar la peticion
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 7/06/2014
	*	Observaciones: Ninguna.
	*/

	function autorizar_requisicion($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),81); /*Verificacion de permiso para crear requisiciones*/
		$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));	
		//$data['id_permiso']=$permiso;
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
				case 2://seccion
				$data['datos']=$this->vales_model->consultar_requisiciones($id_seccion['id_seccion'], 2);


					break;
				case 3://administrador
				$data['datos']=$this->vales_model->consultar_requisiciones(NULL,2);					

					break;
				case 4: //departamental
					

						if($this->vales_model->is_departamental($id_seccion['id_seccion'])){// fuera de san salvador

							$data['datos']=$this->vales_model->consultar_requisiciones($id_seccion['id_seccion'], 2);
						}else{//san salvador
							$data['datos']=$this->vales_model->consultar_requisiciones_san_salvador(2);
						}

					break;
					
			}

			$data['estado_transaccion']=$estado_transaccion;
			//print_r($data);
			pantalla("vales/autorizacion",$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
		

	}

/*
	*	Nombre: dialogo_autorizacion
	*	Objetivo: 	cargar el cuadro de dialogo mediante ajax en la pantalla de autorizacion
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 7/06/2014
	*	Observaciones: Ninguna.
	*/

function dialogo_autorizacion($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),81);
		if(isset($data['id_permiso'])&& $data['id_permiso']>=2 ) {
			$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			$datos['d']=$this->vales_model->info_requisicion($id);
			$datos['f']=$this->vales_model->info_requisicion_vehiculos($id);
			$datos['id']=$id;
			$this->load->view('vales/dialogo_autorizacion',$datos);
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}


/*
	*	Nombre: guardar_autorizacion
	*	Objetivo: 	Guardar la informacion o respuesta del usuario en visto bueno
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 8/06/2014
	*	Observaciones: Utilizo el arreglo POST para faciclitar la transferencia de datos al modelo
	*/
function guardar_autorizacion()
{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),81);
		$id_empleado=$this->vales_model->get_id_empleado($this->session->userdata('nr')); 
		$_POST['id_usuario']=$this->session->userdata('id_usuario');
		$_POST['id_empleado']=$id_empleado;

		if($data['id_permiso']!=NULL) {
			
				$this->db->trans_start();
				$this->vales_model->guardar_autorizacion($_POST);
				$this->db->trans_complete();
				ir_a('index.php/vales/autorizar_requisicion/'.$this->db->trans_status());		

		}else{
				echo 'No tiene permisos para acceder';
		}

	}
		/*
	*	Nombre: ver requiciciones de combustible 
	*	Objetivo: Aprobar y asignar los vales a entregar a la oficina, o en su defecto rechazar la peticion
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 8/06/2014
	*	Observaciones: Ninguna.
	*/

	function ver_requisiciones($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),82); /*Verificacion de permiso para crear requisiciones*/
		$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));	
		//$data['id_permiso']=$permiso;
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
				case 2://seccion
				$data['datos']=$this->vales_model->consultar_requisiciones($id_seccion['id_seccion']);


					break;
				case 3://administrador
				$data['datos']=$this->vales_model->consultar_requisiciones();					

					break;
				case 4: //departamental
					

						if($this->vales_model->is_departamental($id_seccion['id_seccion'])){// fuera de san salvador

							$data['datos']=$this->vales_model->consultar_requisiciones($id_seccion['id_seccion']);
						}else{//san salvador
							$data['datos']=$this->vales_model->consultar_requisiciones_san_salvador();
						}

					break;
					
			}

			$data['estado_transaccion']=$estado_transaccion;
			//print_r($data);
			pantalla("vales/ver_requisiciones",$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
/*
	*	Nombre: dialogo detalle
	*	Objetivo: 	Guardar la informacion o respuesta del usuario en visto bueno
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 8/06/2014
	*	Observaciones: Utilizo el arreglo POST para faciclitar la transferencia de datos al modelo
	*/
function dialogo_detalles($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),82);
		if(isset($data['id_permiso'])&& $data['id_permiso']>=2 ) {
			$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			$datos['d']=$this->vales_model->info_requisicion($id);
			$datos['f']=$this->vales_model->info_requisicion_vehiculos($id);
			$datos['id']=$id;
			
			

		//echo "<pre>";	print_r($datos);echo "</pre>";

			$this->load->view('vales/dialogo_detalles',$datos);
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}

}
?>