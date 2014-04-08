<?php
class Transporte extends CI_Controller
{
    
    function Transporte()
	{
        parent::__construct();
		$this->load->model('transporte_model');
		$this->load->library('html2pdf');
    	if(!$this->session->userdata('id_usuario')){
		 redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
		$this->solicitud();
  	}
	
	/*
	*	Nombre: solicitud
	*	Obejtivo: Carga la vista para la creacion del solicitudes de transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 01/04/2014
	*	Observaciones: Ninguna
	*/
	function solicitud($id_solicitud=NULL)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59); /*Verificacion de permiso para crear solicitudes*/
		
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) { /*Busqueda de informacion a mostrar en la pantalla segun el nivel del usuario logueado*/
				case 1:
					$data['empleados']=$this->transporte_model->consultar_empleado($this->session->userdata('nr'));
					foreach($data['empleados'] as $val) {
						$data['info']=$this->transporte_model->info_adicional($val['NR']);
					}
					break;
				case 2:
					$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					$data['empleados']=$this->transporte_model->consultar_empleados_seccion($id_seccion['id_seccion']);
					break;
				case 3:
					$data['empleados']=$this->transporte_model->consultar_empleados();
					break;
			}
			
			$data['solicitud']=$this->transporte_model->consultar_solicitud($id_solicitud);
			$data['acompanantes']=$this->transporte_model->consultar_empleados($this->session->userdata('nr'));
			$data['municipios']=$this->transporte_model->consultar_municipios();

			pantalla('transporte/solicitud',$data);	
		}
		else {
			echo ' No tiene permisos para acceder';
		}
	}
	
	function control_solicitudes()
	{
 		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);
		
		echo $data['id_permiso'];
		if(isset($data['id_permiso'])&&$data['id_permiso']>1) {
			if($data['id_permiso']>2){//nivel 3
				$data['datos']=$this->transporte_model->todas_solicitudes_por_confirmar();
			}else {//nivel 2
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$data['datos']=$this->transporte_model->solicitudes_por_confirmar($id_seccion['id_seccion']);			
			}	 
			pantalla('transporte/ControlSolicitudes',$data);
		
		}else{//nivel 1
				echo "No Autorizado";

		}


	
	}
	
	function datos_de_solicitudes($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);
		if(isset($data['id_permiso'])&&$data['id_permiso']>=2 ) {
		/*	$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
			$d=$this->transporte_model->datos_de_solicitudes($id, $id_seccion['id_seccion']);
			$a=$this->transporte_model->acompanantes_internos($id);
			$j=json_encode($d);
			echo $j;*/
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$datos['d']=$this->transporte_model->datos_de_solicitudes($id, $id_seccion['id_seccion']);
				$datos['a']=$this->transporte_model->acompanantes_internos($id);
				$datos['f']=$this->transporte_model->destinos($id);
				$datos['id']=$id;
				$this->load->view('transporte/dialogoAprobacion',$datos);
				
				
		}
		else {
			echo ' No tiene permiso';
		}
	}
	
	function aprobar_solicitud()
	{
		$data['permiso']=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),60);
		if($data['permiso']>=2){
			$id=$this->input->post('ids'); //id solicitud
			$estado=$this->input->post('resp'); //estado de la solicitud
			$descrip=$this->input->post('observacion'); //Observacion
			$nr=$this->session->userdata('nr'); //NR del usuario Logueado
			
			if($estado ==2 || $estado== 0){
				$this->transporte_model->aprobar($id,$estado, $nr,$this->session->userdata('id_usuario'));
					if($descrip!="")
						$this->transporte_model->insertar_descripcion($id,$descrip);
						
				
				ir_a("index.php/transporte/control_solicitudes");
			
			}else {
				echo'Datos corruptos';
			}
		}else {
			echo ' No tiene permisos para acceder';
		}	
	}
	
	
	///////////esta función carga la vista de Asignaciones de vehículos y Motoristas////////////
	function asignar_vehiculo_motorista()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']!=NULL)
		{
			if($data['id_permiso']>=2)
			{
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$data['datos']=$this->transporte_model->solicitudes_por_asignar($id_seccion);
				pantalla('transporte/asignacion_veh_mot',$data);
			}
		}
		else
		{
			echo "No tiene permiso";
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////

/////////////función para cargar datos de solicitudes////////////////////////////////////
	function cargar_datos_solicitud($id)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']!=NULL)
		{
			if($data['id_permiso']>2)
			{
				$id_seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
				$d=$this->transporte_model->datos_de_solicitudes($id, $id_seccion['id_seccion']);
				$a=$this->transporte_model->acompanantes_internos($id);
				$f=$this->transporte_model->destinos($id);
				
				$solicitud_actual=$this->transporte_model->consultar_fecha_solicitud($id);
				//////////consulta la fecha, hora de entrada, y hora de salida de la solicitud actual, para luego compararla con otras solicitudes ya aprobadas.
				$cont=0;
				$cont1=0;					
				foreach($solicitud_actual as $row)
				{
					$id_departamento=$row->id_departamento_pais;
					if($id_departamento=="00006")
					{
						$cont++;
					}
					$fecha=$row->fecha;
					$entrada=$row->entrada;
					$salida=$row->salida;
					$cont1++;		
				}
				
				if($cont==$cont1)////Para misiones locales, el 0 significa departamento de San Salvador
				{
					$vehiculos_disponibles=$this->transporte_model->vehiculos_disponibles($fecha,$entrada,$salida);
				}
				else if($cont!=$cont1)///////////////////////para misiones fuera de san salvador
				{
					$vehiculos_disponibles=$this->transporte_model->vehiculos_disponibles2($fecha,$entrada,$salida);
				}
				
				echo 
				"
				<div id='signup-header'>
				<h2>Asignaci&oacute;n de Veh&iacute;culos y Motoristas</h2>
				<a class='modal_close'></a>
				</div>
				
				<form id='form' action='".base_url()."index.php/transporte/asignar_veh_mot' method='post'>
				<input type='hidden' id='resp' name='resp' />
				<input type='hidden' name='id_solicitud' value='".$id."' />
				
				<fieldset>      
					<legend align='left'>Información de la Solicitud</legend>
					";
					foreach($d as $datos)
					{
						$nombre=ucwords($datos->nombre);
						$seccion=$datos->seccion;
						$fechaS=$datos->fechaS;
						$fechaM=$datos->fechaM;
						$salida=$datos->salida;
						$entrada=$datos->entrada;
						$requiere=$datos->req;
						$acompanante=ucwords($datos->acompanante);
						$id_empleado=$datos->id_empleado_solicitante;
					}
					
				
				echo "Nombre: <strong>".$nombre."</strong> <br>
				Sección: <strong>".$seccion."</strong> <br>
				Fecha de Solicitud: <strong>".$fechaS."</strong> <br>
				Fecha de Misión: <strong>".$fechaM."</strong> <br>
				Hora de Salida: <strong>".$salida."</strong> <br>
				Hora de Regreso: <strong>".$entrada."</strong> <br>
				
				</fieldset>
				<br />
				
				<fieldset>
				<legend align='left'>Destinos</legend>
				
				<table cellspacing='0' align='center' class='table_design'>
						<thead>
							<th>
								Municipio
							</th>
							<th>
								Lugar de destino
							</th>
							<th>
								Dirección
							</th>
							<th>
								Misión Encomendada
							</th>
						</thead>
						<tbody>
							";
							foreach($f as $r)
							{
								echo "<tr><td>".$r->municipio."</td>";
								echo "<td>".$r->destino."</td>";
								echo "<td>".$r->direccion."</td>";
								echo "<td>".$r->mision."</td></tr>";
							}
						echo "
						</tbody>
					</table>
				
				</fieldset>
				
			   <br>
				<fieldset>
					<legend align='left'>Acompañantes</legend>
					
					";
					foreach($a as $acompa)
					{
						echo "<strong>".ucwords($acompa->nombre)."</strong> <br />";
					}
					echo "<strong>".$acompanante."</strong><br />";
				echo "
				</fieldset>
				<br>
				<fieldset>
				<legend align='left'>Vehículos</legend>
					<p>
					<label>Información:</label>
				   <select class='select' name='vehiculo' id='vehiculo' onchange='motoristaf(this.value)'>
				   ";
				   
					foreach($vehiculos_disponibles as $v)
					{
						echo "<option value='".$v->id_vehiculo."'>".$v->placa." - ".$v->nombre." - ".$v->modelo."</option>";
					}
				   
				   echo "    
				   </select>
					</p>   
				</fieldset>
				<br>
				<fieldset>
					<legend align='left'>Motorista</legend>
						<p>
						<label>Nombre:</label>
				";
				if($requiere==1)
				{
				echo "
					   <select name='motorista' id='motorista'>
					   </select>
					";
				}
				else
				{
					echo "<strong>".$nombre."</strong>";
					echo "<input type='hidden' name='motorista' value='".$id_empleado."'>";
				}
				echo "
				</p>
					</fieldset>
				 <p>
					<label for='observacion' id='lobservacion'>Observación</label>
					<textarea class='tam-4' id='observacion' tabindex='2' name='observacion'/></textarea>
				</p>
				<p style='text-align: center;'>
					<button type='submit' id='asignar' name='asignar' onclick='enviar(3)'>Asignar</button>
				</p>
				</form>
				";
				
				echo "<script>
					$('select').prepend('<option value=\"\" selected=\"selected\"></option>');
					$('.select').kendoComboBox({
						autoBind: false,
						filter: 'contains'
					});
					/*$('#motorista').kendoComboBox({
						autoBind: false,
						filter: 'contains'
					})
					var se=$('motorista').data('kendoComboBox');
					se.destroy();*/
				</script>";
				
			}
		}
		else
		{
			echo ' No tiene permiso';
		}
	}
	///////////////////////////////////////////////////////////////////////////////////////////
	
	////////función para conocer el motorista que se ha de asignar a la misión oficial//////////
	function verificar_motoristas($id_vehiculo)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		if($data['id_permiso']!=NULL)
		{
			if($data['id_permiso']>2)
			{
				
				$motoristas=$this->transporte_model->consultar_motoristas($id_vehiculo);
				//////////consulta al motorista asignado al vehiculo.
				
				$j=json_encode($motoristas);
				echo $j;
			}
		}
		else
		{
			echo ' No tiene permiso';
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////

/////Función para registrar una asignación de vehículo con su correspondiente motorista////////
function asignar_veh_mot()
	{
		$data['permiso']=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59);
		
		if($data['permiso']!=NULL)
		{
			if($data['permiso']>=2)
			{
				$id_solicitud=$this->input->post('id_solicitud');//id_solicitud
				$id_vehiculo=$this->input->post('vehiculo'); //id_vehiculo
				$id_motorista=$this->input->post('motorista'); //estado de la solicitud
				$estado=$this->input->post('resp');//futurp estado de la solicitud
				$fecha_m=date('Y-m-d H:i:s');
				$nr=$this->session->userdata('nr'); //NR del usuario Logueado
				$observaciones=$this->input->post('observacion');//observación, si es que hay
				
				if($estado==3)
				{
					$this->transporte_model->asignar_veh_mot($id_solicitud,$id_motorista,$id_vehiculo, $estado, $fecha_m,$nr,$this->session->userdata('id_usuario'));
					
					if($observaciones!="") $this->transporte_model->insertar_descripcion($id_solicitud,$observaciones);						
					
					ir_a("index.php/transporte/asignar_vehiculo_motorista");
				
				}
				else
				{
					echo'Datos corruptos';
				}
			}
		}
		else
		{
			echo ' No tiene permisos para acceder';
		}	
	}
/////////////////////////////////////////////////////////////////////////////////////////////

	/*
	*	Nombre: buscar_info_adicional
	*	Obejtivo: Mostrar la informacion del puesto del empleado que necesita el transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 01/04/2014
	*	Observaciones: Ninguna
	*/
	function buscar_info_adicional()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59); /*Verificacion de permiso para crear solicitudes*/
		
		if($data['id_permiso']!=NULL) {
			$id_empleado=$this->input->post('id_empleado');
			$data=$this->transporte_model->info_adicional($id_empleado);
			if($data['nr']!='0') {
				$json =array(
					'estado'=>1,
					'nr'=>$data['nr'],
					'id_seccion'=>$data['id_seccion'],
					'funcional'=>$data['funcional'],
					'nivel_1'=>$data['nivel_1'],
					'nivel_2'=>$data['nivel_2'],
					'nivel_3'=>$data['nivel_3']
				);
			}
			else {
				$json =array(
					'estado'=>0
				);
			}
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
	*	Nombre: guardar_solicitud
	*	Obejtivo: Guardar el formulario de solicitud de transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 01/04/2014
	*	Observaciones: Ninguna
	*/
	function guardar_solicitud()
	{	
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),59); /*Verificacion de permiso para crear solicitudes*/
		
		if($data['id_permiso']!=NULL) {
			$fec=str_replace("/","-",$this->input->post('fecha_mision'));
			$fecha_solicitud_transporte=date('Y-m-d');
			$id_empleado_solicitante=(int)$this->input->post('nombre');
			$fecha_mision=date("Y-m-d", strtotime($fec));
			$hora_salida=date("H:i:s", strtotime($this->input->post('hora_salida')));
			$hora_entrada=date("H:i:s", strtotime($this->input->post('hora_regreso')));
			if($this->input->post('requiere_motorista')!="")
				$requiere_motorista=$this->input->post('requiere_motorista');
			else
				$requiere_motorista=0;
			$observaciones=$this->input->post('observaciones');
			$acompanante=$this->input->post('acompanantes2');
			$id_usuario_crea=$this->session->userdata('id_usuario');
			$fecha_creacion=date('Y-m-d H:i:s');
			$estado_solicitud_transporte=1;
			
			$formuInfo = array(
				'fecha_solicitud_transporte'=>$fecha_solicitud_transporte,
				'id_empleado_solicitante'=>$id_empleado_solicitante,
				'fecha_mision'=>$fecha_mision,
				'hora_salida'=>$hora_salida,
				'hora_entrada'=>$hora_entrada,
				'requiere_motorista'=>$requiere_motorista,
				'acompanante'=>$acompanante,
				'id_usuario_crea'=>$id_usuario_crea,
				'fecha_creacion'=>$fecha_creacion,
				'estado_solicitud_transporte'=>$estado_solicitud_transporte
			);
			
			$id_solicitud_transporte=$this->transporte_model->guardar_solicitud($formuInfo); /*Guardando la solicitud*/
			$acompanantes=$this->input->post('acompanantes');
			for($i=0;$i<count($acompanantes);$i++) {
				$formuInfo = array(
					'id_solicitud_transporte'=>$id_solicitud_transporte,
					'id_empleado'=>$acompanantes[$i]
				);
				$this->transporte_model->guardar_acompanantes($formuInfo); /*Guardando acompañantes*/
			}
			$destinos=$this->input->post('values');
			for($i=0;$i<count($destinos);$i++) {
				$campos=explode("**",$destinos[$i]);
				if(isset($campos[1])) {
					$formuInfo = array(
						'id_solicitud_transporte'=>$id_solicitud_transporte,
						'id_municipio'=>$campos[0],
						'lugar_destino'=>$campos[1],
						'direccion_destino'=>$campos[2],
						'mision_encomendada'=>$campos[3]

					);
					$this->transporte_model->guardar_destinos($formuInfo); /*Guardando destinos*/
				}
			}
			
			$this->transporte_model->insertar_descripcion($id_solicitud_transporte,$observaciones); /*Guardando observaciones*/
			
			ir_a('index.php/transporte/solicitud');
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	function control_salidas_entradas(){
	$data['datos']=$this->transporte_model->salidas_entradas_vehiculos();
	pantalla("transporte/despacho",$data);	
	}
	function guardar_despacho(){

		$estado=$this->input->post('estado');
		$id=$this->input->post('id');
		$km=$this->input->post('km');
		$hora=date("H:i:s", strtotime($this->input->post('hora')));
		if($estado==3){
			$this->transporte_model->salida_vehiculo($id, $km,$hora);
		}else{
			if($estado==4){
			$gas=$this->input->post('gas');
			$this->transporte_model->regreso_vehiculo($id, $km, $hora, $gas);		
			}
		}
		ir_a('index.php/transporte/control_salidas_entradas');
		}
	function infoSolicitud($id){
			
			$d=$this->transporte_model->infoSolicitud($id);	
			$j=json_encode($d);
			echo $j;
				
	}
	function kilometraje($id){
			
			$d=$this->transporte_model->kilometraje($id);	
			$j=json_encode($d);
			echo $j;
				
	}
	
	/*
	*	Nombre: ver_solicitudes
	*	Obejtivo: Ver el estado actual de las solicitudes. Permite editar o eliminar solicitudes
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 15/03/2014
	*	Observaciones: Ninguna
	*/
	function ver_solicitudes()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),61);
		
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) {
				case 1:
					$empleado=$this->transporte_model->consultar_empleado($this->session->userdata('nr'));
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes($empleado[0]['NR']);
					break;
				case 2:
					$seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes_seccion($seccion['id_seccion']);
					break;
				case 3:
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes();
			}
			
			pantalla("transporte/ver_solicitudes",$data);	
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	
	/*
	*	Nombre: eliminar_solicitud
	*	Obejtivo: Elimina (desactiva) una solicitud de transporte
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 15/03/2014
	*	Observaciones: Ninguna
	*/
	function eliminar_solicitud($id_solicitud)
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),61);
		
		if($data['id_permiso']!=NULL) {
			$this->transporte_model->eliminar_solicitud($id_solicitud);
			redirect('index.php/transporte/ver_solicitudes');
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	
	/*
	*	Nombre: reporte_solicitud
	*	Obejtivo: Muestra solicitudes que ya tienen asignado vehiculo y motorista. Permite exportar a pdf
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 01/04/2014
	*	Observaciones: Ninguna
	*/
	function reporte_solicitud()
	{
		$data=$this->seguridad_model->consultar_permiso($this->session->userdata('id_usuario'),66);
		if($data['id_permiso']!=NULL) {
			switch($data['id_permiso']) {
				case 1:
					$empleado=$this->transporte_model->consultar_empleado($this->session->userdata('nr'));
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes($empleado[0]['NR'],3);
					break;
				case 2:
					$seccion=$this->transporte_model->consultar_seccion_usuario($this->session->userdata('nr'));
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes_seccion($seccion['id_seccion'],3);
					break;
				case 3:
					$data['solicitudes']=$this->transporte_model->buscar_solicitudes(NULL,3);
			}
			pantalla("transporte/reporte_solicitudes",$data);	
		}
		else {
			echo "No tiene permisos para acceder";
		}
	}
	
	/*
	*	Nombre: solicitud_pdf
	*	Obejtivo: Genera una archivo pdf de una solicitud
	*	Hecha por: Leonel
	*	Modificada por: Leonel
	*	Ultima Modificacion: 02/04/2014
	*	Observaciones: Esta a la mitad, falta cargar librerias para el pdf
	*/
	function solicitud_pdf($id) 
	{
		$dir='./archivos/';
		$nom='test.pdf';
		
		if(!is_dir($dir))
            mkdir($dir, 0777);
		
		$this->html2pdf->folder($dir);
        $this->html2pdf->filename($nom);
        $this->html2pdf->paper('a4', 'portrait');
		
		$data['info_solicitud']=$this->transporte_model->consultar_solicitud($id);
		$id_solicitud_transporte=$data['info_solicitud']['id_solicitud_transporte'];
		$id_empleado_solicitante=$data['info_solicitud']['id_empleado_solicitante'];
		$data['info_empleado']=$this->transporte_model->info_adicional($id_empleado_solicitante);
		$data['acompanantes']=$this->transporte_model->acompanantes_internos($id_solicitud_transporte);
		$data['destinos']=$this->transporte_model->destinos($id_solicitud_transporte);
		//$this->load->view('transporte/solicitud_pdf.php',$data);
		$this->html2pdf->html(utf8_decode($this->load->view('transporte/solicitud_pdf.php', $data, true)));
		$this->html2pdf->create('save');
		$this->downloadPdf();
	}
	
	public function show()
    {
		$dir='archivos/';
        if(is_dir($dir))
        {
			$nom='test.pdf';
            $route = base_url($dir.$nom); 
            if(file_exists('./'.$dir.$nom))
            {
                header('Content-type: application/pdf'); 
                readfile($route);
            }
        }
    }
	
	public function downloadPdf()
    {
            //ruta completa al archivo
            $route = base_url("archivos/test.pdf"); 
            //nombre del archivo
            $filename = "test.pdf"; 
            //si existe el archivo empezamos la descarga del pdf

                header("Cache-Control: public"); 
                header("Content-Description: File Transfer"); 
                header('Content-disposition: attachment; filename='.basename($route)); 
                header("Content-Type: application/pdf"); 
                header("Content-Transfer-Encoding: binary"); 
                header('Content-Length: '. filesize($route)); 
                readfile($route);
    }
}
/*
		$this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Israel Parra');
        $pdf->SetTitle('Ejemplo de provincías con TCPDF');
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
 
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
 
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
		//relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
		 
		// ---------------------------------------------------------
		// establecer el modo de fuente por defecto
        $pdf->setFontSubsetting(true);
 
		// Establecer el tipo de letra
 
		//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
		// Helvetica para reducir el tamaño del archivo.
        $pdf->SetFont('freemono', '', 14, '', true);
 
		// Añadir una página
		// Este método tiene varias opciones, consulta la documentación para más información.
        $pdf->AddPage();
 
		//fijar efecto de sombra en el texto
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
 
		// Establecemos el contenido para imprimir
        $provincia = $this->input->post('provincia');
        $provincias = $this->pdfs_model->getProvinciasSeleccionadas($provincia);
        foreach($provincias as $fila)
        {
            $prov = $fila['p.provincia'];
        }
        //preparamos y maquetamos el contenido a crear
        $html = '';
        $html .= "<style type=text/css>";
        $html .= "th{color: #fff; font-weight: bold; background-color: #222}";
        $html .= "td{background-color: #AAC7E3; color: #fff}";
        $html .= "</style>";
        $html .= "<h2>Localidades de ".$prov."</h2><h4>Actualmente: ".count($provincias)." localidades</h4>";
        $html .= "<table width='100%'>";
        $html .= "<tr><th>Id localidad</th><th>Localidades</th></tr>";
        
        //provincias es la respuesta de la función getProvinciasSeleccionadas($provincia) del modelo
        foreach ($provincias as $fila) 
        {
            $id = $fila['l.id'];
            $localidad = $fila['l.localidad'];
 
            $html .= "<tr><td class='id'>" . $id . "</td><td class='localidad'>" . $localidad . "</td></tr>";
        }
        $html .= "</table>";
 
		// Imprimimos el texto con writeHTMLCell()
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
 
		// ---------------------------------------------------------
		// Cerrar el documento PDF y preparamos la salida
		// Este método tiene varias opciones, consulte la documentación para más información.
        $nombre_archivo = utf8_decode("Localidades de ".$prov.".pdf");
        $pdf->Output($nombre_archivo, 'I');
*/
?>