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
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function ingreso_vales($estado_transaccion=NULL) 
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),69); 
		
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
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function guardar_vales() 
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),69); /*Verificacion de permiso para crear solicitudes*/
		
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
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/vales/ingreso_vales/'.$tr);
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	
	/*
	*	Nombre: ingreso_requisicion
	*	Objetivo: Cargar la vista de la requisicion (solicitud) de combustible
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function ingreso_requisicion($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),75); /*Verificacion de permiso para crear requisiciones*/
		$url='vales/requicision';
		$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));	
		//$data['id_permiso']=$permiso;
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
				case 2://seccion
					$data['oficinas']=$this->vales_model->consultar_oficinas($id_seccion['id_seccion']);
					$data['fuente']=$this->vales_model->consultar_fuente_fondo($id_seccion['id_seccion']);
					$data['vehiculos']=$this->vales_model->vehiculos($id_seccion['id_seccion']);
					if(sizeof($data['vehiculos'])==0) {
						$url.='Error';	
					}
					break;
				case 3://administrador
					$data['oficinas']=$this->vales_model->consultar_oficinas();
					$data['fuente']=$this->vales_model->consultar_fuente_fondo();

					break;
				case 4: //departamental
					if($this->vales_model->is_departamental($id_seccion['id_seccion'])) {// fuera de san salvador
						$data['oficinas']=$this->vales_model->consultar_oficinas($id_seccion['id_seccion']);
						$data['fuente']=$this->vales_model->consultar_fuente_fondo($id_seccion['id_seccion']);
						$data['vehiculos']=$this->vales_model->vehiculos($id_seccion['id_seccion']);
						if(sizeof($data['vehiculos'])==0){
							$url.='error';	
						}
					}
					else {//san salvador
						$data['oficinas']=$this->vales_model->consultar_oficinas_san_salvador();
						$data['fuente']=$this->vales_model->consultar_fuente_fondo_san_salvador();
					}
					break;
			}
			$data['estado_transaccion']=$estado_transaccion;
			/*echo "<br>  id seccion ".$id_seccion['id_seccion']." permiso ".$data['id_permiso'];
			print_r($data['oficinas']);  */
			pantalla($url,$data);	
		}
		else {
			echo 'No tiene permisos para acceder ';
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
		

		if(isset($_POST['refuerzo'])){

			$_POST['refuerzo']=1;
		}else{
			$_POST['refuerzo']=0;
		}

		$this->db->trans_start();

		$id_usuario=$this->session->userdata('id_usuario');
		$id_empleado_solicitante=$this->vales_model->get_id_empleado($this->session->userdata('nr')); 
		$id_requisicion=$this->vales_model->guardar_requisicion($_POST, $id_usuario, $id_empleado_solicitante);

		$vehiculos=$this->input->post('values');
			for($i=0;$i<count($vehiculos);$i++) {
				$this->vales_model->guardar_req_veh($vehiculos[$i], $id_requisicion);
			}
		$this->db->trans_complete();
		
		$tr=($this->db->trans_status()===FALSE)?0:1;
		ir_a('index.php/vales/ingreso_requisicion/'.$tr);		
	}
	
	/*
	*	Nombre: vehiculos
	*	Objetivo: Cargar por ajax los vehiculos de una seccion y fuente de fonodo segun selccione el usuario 
	*	en la pantalla de ingrese de requisicion de combustible 
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
	*	Nombre: consultar_consumo
	*	Objetivo: Verificar el consumo de una seccion para hacer la peticion y lo compara con la cantidad asignada
	*	Hecha por: Jhonatan
	*	Modificada por: Jhonatan
	*	Última Modificación: 1/07/2014
	*	Observaciones: Ninguna.
	*/
	function consultar_consumo($id_seccion, $id_fuente_fondo)
	{
		
				$a=$this->vales_model->consultar_consumo($id_seccion, $id_fuente_fondo);
				$a=$a[0];
				$b=$this->vales_model->asignaciones($id_seccion, $id_fuente_fondo);
				$b=$b[0];
				
				$c = array('peticion' => $b['cantidad']-$a['suma'],
							'asignado'=>$b['cantidad'],
							'restante'=>$a['suma']);
					echo json_encode($c);



	}
	/*
	*	Nombre: requisiciones_pdf
	*	Objetivo: Cargar el PDF 
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 07/06/2014
	*	Observaciones: Ninguna.
	*/
	

	function requisiciones_pdf($id)
	{
		$data['datos']=$this->vales_model->req_pdf($id);
		$this->load->view("vales/requisicion_pdf",$data);
	}

	/*
	*	Nombre: visto bueno
	*	Objetivo: Aprobar y asignar los vales a entregar a la oficina, o en su defecto rechazar la peticion
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function autorizacion($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),86); /*Verificacion de permiso para crear requisiciones*/
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
						}
						else{//san salvador
							$data['datos']=$this->vales_model->consultar_requisiciones_san_salvador(1);
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
	*	Nombre: dialogo_ autorizacion 
	*	Objetivo: Cargar el cuadro de dialogo mediante ajax en la pantalla de autorizacion de vales de combustible
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function dialogo_autorizacion($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),86);
		if(isset($data['id_permiso'])&& $data['id_permiso']>=2 ) {
			$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			$datos['d']=$this->vales_model->info_requisicion($id);
			$datos['f']=$this->vales_model->info_requisicion_vehiculos($id);
			$datos['v']=$this->vales_model->info_vales($id);
			$datos['id']=$id;
			
		
			$this->load->view('vales/dialogo_autorizacion',$datos);
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}

	/*
	*	Nombre: guardar_autorizacion
	*	Objetivo: Guardar la informacion o respuesta del usuario en visto bueno
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Utilizo el arreglo POST para faciclitar la transferencia de datos al modelo
	*/
	function guardar_autorizacion()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),86);
		$id_empleado=$this->vales_model->get_id_empleado($this->session->userdata('nr')); 
		$_POST['id_usuario']=$this->session->userdata('id_usuario');
		$_POST['id_empleado']=$id_empleado;
		
		if($data['id_permiso']!=NULL) {
			$this->db->trans_start();
				if ($_POST['resp']!=0) {
				$req=(array)$this->vales_model->info_requisicion($_POST['ids']);
				$val=$this->vales_model->buscar_vales($_POST['ids'],$req[0]->id_fuente_fondo,$_POST['asignar']);				

				}
				$this->vales_model->guardar_visto_bueno($_POST);
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/vales/autorizacion/'.$tr);		
		}
		else{
			echo 'No tiene permisos para acceder';
		}
	}

	
	/*
	*	Nombre: ver requiciciones de combustible 
	*	Objetivo: Aprobar y asignar los vales a entregar a la oficina, o en su defecto rechazar la peticion
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/



	function ver_requisiciones($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),89); /*Verificacion de permiso para crear requisiciones*/
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
						}
						else{//san salvador
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
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Utilizo el arreglo POST para faciclitar la transferencia de datos al modelo
	*/
	function dialogo_detalles($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),89);
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
	


/*
	*	Nombre: Asignaciones de vales a cada seccion
	*	Objetivo: Permite modificar, crear o elimnar las asignaciones mensuales de vales a las diferentes secciones
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function asignaciones($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),88); /*Verificacion de permiso gestionar asignaciones*/
		$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));	
		//$data['id_permiso']=$permiso;
		if($data['id_permiso']!=NULL) {
		
			$data['datos']=$this->vales_model->asignaciones();
			$data['estado_transaccion']=$estado_transaccion;
			//print_r($data);
			pantalla("vales/asignaciones",$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}		
	}
	/*
	*	Nombre: dialogoM_asignacion 
	*	Objetivo: 	Permite modificar las asignaciones
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Utilizo el arreglo POST para faciclitar la transferencia de datos al modelo
	*/
	

	
	function dialogoM_asignacion($id_seccion,$id_fuente_fondo)
	{
	$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),88); /*Verificacion de permiso gestionar asignaciones*/
		if($data['id_permiso']!=NULL) {
		
			$data['d']=$this->vales_model->asignaciones($id_seccion,$id_fuente_fondo);
			$this->load->view("vales/dialogoM_asignacion",$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}		
	}
	/*
	*	Nombre: modificar_asignacion
	*	Objetivo: 	modifica la asiganacion en la base de datos
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*/


	function modificar_asignacion()
	{
	$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),88); /*Verificacion de permiso gestionar asignaciones*/
		if($data['id_permiso']!=NULL) {
		
			$this->db->trans_start();
		$this->vales_model->modificar_asignaciones($_POST);
			

			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/vales/asignaciones/'.$tr);		
		}
		else {
			echo 'No tiene permisos para acceder';
		}		
	}

	/*
	*	Nombre: dialogoN_asignacion
	*	Objetivo: 	Permite insertar una nueva asignación
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*/
	

	function dialogoN_asignacion()
	{
	$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),88); /*Verificacion de permiso gestionar asignaciones*/
		if($data['id_permiso']!=NULL) {
		
			$data['oficinas']=$this->vales_model->consultar_oficinas();
			$data['fuente']=$this->vales_model->consultar_fuente_fondo();		
			$this->load->view("vales/dialogoN_asignacion",$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}		
	}
	/*
	*	Nombre: Insertar_asignacion
	*	Objetivo: 	guarda la asiganacion en la base de datos
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*/

	function insertar_asignacion()
	{
	$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),88); /*Verificacion de permiso gestionar asignaciones*/
		if($data['id_permiso']!=NULL) {
		
			$this->db->trans_start();
			$this->vales_model->insertar_asignaciones($_POST);		

			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/vales/asignaciones/'.$tr);		
		}
		else {
			echo 'No tiene permisos para acceder';
		}		
	}

	/*
	*	Nombre: eliminar_asignacion
	*	Objetivo: 	eliminar la asiganacion en la base de datos
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*/

	function eliminar_asignacion($id_seccion, $id_fuente_fondo)
	{
	$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),88); /*Verificacion de permiso gestionar asignaciones*/
		if($data['id_permiso']!=NULL) {
		
			$this->db->trans_start();
			$this->vales_model->eliminar_asignaciones($id_seccion, $id_fuente_fondo);		
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/vales/asignaciones/'.$tr);		
		}
		else {
			echo 'No tiene permisos para acceder';
		}		
	}


	/*
	*	Nombre: ingreso_consumo
	*	Objetivo: Carga la vista para el ingreso de comsumo de vales de combustible or vehiculo.
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/


	function ingreso_consumo($estado_transaccion=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),76); 
		
		if($data['id_permiso']!=NULL) {
			$data['fuente']=$this->vales_model->consultar_fuente_fondo();
			$data['gasolineras']=$this->vales_model->consultar_gasolineras();
			$data['estado_transaccion']=$estado_transaccion;
			pantalla("vales/consumo",$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}	
	}
	
	/*
	*	Nombre: vehiculos_consumo
	*	Objetivo: Cargar por ajax los vehiculos de una seccion segun la gasolinera que se seleccione  
	*	en la pantalla de ingrese de requisicion de combustible 
	*	Hecha por: Leonel
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function vehiculos_consumo($id_gasolinera = NULL, $fecha_factura_dia = NULL, $fecha_factura_mes = NULL, $fecha_factura_anio = NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),76); 
		
		if($data['id_permiso']!=NULL) {
			$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			$fecha_factura=$fecha_factura_anio."-".$fecha_factura_mes."-".$fecha_factura_dia;
			switch($data['id_permiso']) {
				case 1:
					break;
				case 2:
					$data['vehiculos']=$this->vales_model->consultar_vehiculos_seccion($id_seccion['id_seccion'],$id_gasolinera,$fecha_factura);
					$data['vales']=$this->vales_model->consultar_vales_seccion($id_seccion['id_seccion'],$id_gasolinera,$fecha_factura);
					break;
				case 3:
				case 4:
					if(!$this->vales_model->es_san_salvador($id_seccion['id_seccion'])) {
						$data['vehiculos']=$this->vales_model->consultar_vehiculos_seccion($id_seccion['id_seccion'],$id_gasolinera,$fecha_factura);
						$data['vales']=$this->vales_model->consultar_vales_seccion($id_seccion['id_seccion'],$id_gasolinera,$fecha_factura);
					}
					else {
						$data['vehiculos']=$this->vales_model->consultar_vehiculos_seccion(NULL,$id_gasolinera,$fecha_factura);
						$data['vales']=$this->vales_model->consultar_vales_seccion(NULL,$id_gasolinera,$fecha_factura);
					}
					break;
			}
			$this->load->view("vales/vehiculos_consumo",$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}	
	}
	
	/*
	*	Nombre: guardar_consumo
	*	Objetivo: Guardar formulario del consumo de vales de combustible
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Última Modificación: 07/07/2014
	*	Observaciones: Falta la creacion de la tabla "configuraciones" para saber si los vales se pueden "mezclar".
	*/
	function guardar_consumo()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),76); 
		
		if($data['id_permiso']!=NULL) {
			$this->db->trans_start();
			$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			$id_gasolinera=$this->input->post('id_gasolinera');
			$fec=str_replace("/","-",$this->input->post('fecha_factura'));
			$fecha_factura=date("Y-m-d", strtotime($fec));
			$numero_factura=$this->input->post('numero_factura');
			$valor_super=$this->input->post('valor_super');
			$valor_regular=$this->input->post('valor_regular');
			$valor_diesel=$this->input->post('valor_diesel');
			
			$id_vehiculo=$this->input->post('id_vehiculo');
			$actividad_consumo=$this->input->post('actividad_consumo');
			$tip_gas_bruto=$this->input->post('tip_gas');
			$cantidad_consumo=$this->input->post('cantidad_consumo');
			
			if(count($tip_gas_bruto)>count($id_vehiculo)) {
				for($x=1;$x<count($tip_gas_bruto);$x++) {
					if($x%2!=0)
						$tip_gas[]=$tip_gas_bruto[$x];
				}
			}
			else
				$tip_gas=$tip_gas_bruto;
			
			/*echo "<br><pre>";
			print_r($tip_gas);
			echo "</pre>";*/
			
			$formuInfo = array(
				'fecha_factura'=>$fecha_factura,
				'numero_factura'=>$numero_factura,
				'valor_super'=>$valor_super,
				'valor_regular'=>$valor_regular,
				'valor_diesel'=>$valor_diesel,
				'id_usuario_crea'=>$this->session->userdata('id_usuario')
			);
			$id_consumo=$this->vales_model->guardar_factura($formuInfo);
			
			/*$bandera=$this->vales_model->mezclar_tipo_vehiculo();*/
			$bandera=1;
			
			for($i=0;$i<count($id_vehiculo);$i++){
				$val=explode("**",$id_vehiculo[$i]);
				$id_veh=$val[0];
				$id_requisicion_vale=$val[1];
				$valor_vale=$val[2];
				$tipo_vehiculo=$val[3];

				if($tip_gas[$i]!="" && $cantidad_consumo[$i]!="") {
					$formuInfo = array(
						'id_consumo'=>$id_consumo,
						'id_vehiculo'=>$id_veh,
						'actividad_consumo'=>$actividad_consumo[$i],
						'tip_gas'=>$tip_gas[$i],
						'id_requisicion_vale'=>$id_requisicion_vale,
						'cantidad'=>$cantidad_consumo[$i],
						'id_gasolinera'=>$id_gasolinera,
						'recibido'=>1,
						'tipo_vehiculo'=>$tipo_vehiculo,
						'bandera'=>$bandera,
						'id_seccion'=>$id_seccion['id_seccion']
					);
					$this->vales_model->buscar_requisicion_vale($formuInfo);
				}
			}
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/vales/ingreso_consumo/'.$tr);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}	
	}
	/*
	*	Nombre: entrega de vales
	*	Objetivo: Mostrar la informacion necesaria para entregar los vales
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/


function entrega($estado_transaccion=NULL)
{
	$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),87); 
		$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));	
		//$data['id_permiso']=$permiso;
		if($data['id_permiso']!=NULL) {
		
		$data['datos']=$this->vales_model->consultar_requisiciones(NULL,2);											
		$data['estado_transaccion']=$estado_transaccion;
			pantalla("vales/entrega",$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}		
	
}
	/*
	*	Nombre: dialogo entrega vales
	*	Objetivo: Mostrar  informacion mas detallada de la entrega de vales
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Ninguna.
	*/
	function dialogo_entrega($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),87);
		if(isset($data['id_permiso'])&& $data['id_permiso']>=2 ) {
			$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			
			$t=$this->vales_model->info_cantidad_entregar($id);
			$datos['c']=$t[0];
			$datos['d']=$this->vales_model->info_requisicion($id);
			$datos['e']=$this->vales_model->info_requisicion_vales($id);
			$datos['f']=$this->vales_model->info_requisicion_vehiculos($id);
			$datos['id']=$id;
			//echo "<pre>";	print_r($datos);echo "</pre>";
			$this->load->view('vales/dialogo_entrega',$datos);
		}
		else {
			echo 'No tiene permisos para acceder';
		}
	}
	/*
	*	Nombre: guardar_entrega
	*	Objetivo: Guardar el registro de entrega
	*	Hecha por: Jhonatan
	*	Modificada por: Oscar
	*	Última Modificación: 07/07/2014
	*	Observaciones: Utilizo el arreglo POST para faciclitar la transferencia de datos al modelo
	*/
	function guardar_entrega()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),87);
		$id_empleado=$this->vales_model->get_id_empleado($this->session->userdata('nr')); 
		$_POST['id_usuario']=$this->session->userdata('id_usuario');
		$_POST['id_empleado']=$id_empleado;		
		if($data['id_permiso']!=NULL) {
			$this->db->trans_start();
			
			$this->vales_model->guardar_entrega($_POST);

			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a('index.php/vales/entrega/'.$tr);		
		}
		else{
			echo 'No tiene permisos para acceder';
		}
	}

		function reporte_consumo()
	{
$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),75); /*Verificacion de permiso para crear requisiciones*/
		$url='vales/reporte_consumo';
		$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));	
		//$data['id_permiso']=$permiso;
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
				case 2://seccion
					$data['oficinas']=$this->vales_model->consultar_oficinas($id_seccion['id_seccion']);
					$data['fuente']=$this->vales_model->consultar_fuente_fondo($id_seccion['id_seccion']);
					
					break;
				case 3://administrador
					$data['oficinas']=$this->vales_model->consultar_oficinas();
					$data['fuente']=$this->vales_model->consultar_fuente_fondo();

					break;
				case 4: //departamental
					if($this->vales_model->is_departamental($id_seccion['id_seccion'])) {// fuera de san salvador
						$data['oficinas']=$this->vales_model->consultar_oficinas($id_seccion['id_seccion']);
						$data['fuente']=$this->vales_model->consultar_fuente_fondo($id_seccion['id_seccion']);
					
					}
				
					break;
			}
			$data['estado_transaccion']=$estado_transaccion;
			/*echo "<br>  id seccion ".$id_seccion['id_seccion']." permiso ".$data['id_permiso'];
			print_r($data['oficinas']);  */
			pantalla($url,$data);	
		}
		else {
			echo 'No tiene permisos para acceder';
		}
		
	}
	function consumo_json($id_seccion='', $id_fuente_fondo="", $fecha_inicio=NULL, $fecha_fin=NULL)
	{
		$data=$this->vales_model->consumo_seccion_fuente();
		echo json_encode($data);	
	}

	


}

?>