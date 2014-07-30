<?php
class Vehiculo extends CI_Controller
{
    
    function Vehiculo()
	{
        parent::__construct();
		date_default_timezone_set('America/El_Salvador');
		$this->load->model('transporte_model');
//		$this->load->model('vehiculo_model');
		$this->load->library("mpdf");
    	if(!$this->session->userdata('id_usuario')){
		 redirect('index.php/sessiones');
		}
		error_reporting(0);
    }
	
	function index()
	{
		echo"ok";
  	}
	
	/*
	*	Nombre: vehiculos
	*	Objetivo: Carga el catálogo de Vehículos y permite la modificación de los datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 28/04/2014
	*	Observaciones: Ninguna
	*/
	function vehiculos()
	{
		$data['datos']=$this->transporte_model->consultar_vehiculos();
		pantalla('mantenimiento/vehiculos',$data);
	}
	
	/*
	*	Nombre: nuevo_vehiculo
	*	Objetivo: Carga la vista para el Registro de un nuevo Vehículo a la Base de Datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 13/05/2014
	*	Observaciones: Ninguna
	*/
	function nuevo_vehiculo()
	{
		$data['motoristas']=$this->transporte_model->consultar_motoristas2();
		$data['marca']=$this->transporte_model->consultar_marcas();
		$data['modelo']=$this->transporte_model->consultar_modelos();
		$data['clase']=$this->transporte_model->consultar_clases();
		$data['condicion']=$this->transporte_model->consultar_condiciones();
		$data['seccion']=$this->transporte_model->consultar_secciones();
		$data['fuente_fondo']=$this->transporte_model->consultar_fuente_fondo();
		pantalla("mantenimiento/nuevo_vehiculo",$data);
	}
	
	/*
	*	Nombre: controlMtto
	*	Objetivo: carga la vista de control de mantenimiento del vehículo
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 22/07/2014
	*	Observaciones: Ninguna
	*/
	
	function controlMtto()
	{
		$data['vehiculos']=$this->transporte_model->consultar_vehiculos(1);
		pantalla('mantenimiento/control_mantenimiento',$data);
	}
	
	/*
	*	Nombre: tallerMTPS
	*	Objetivo: carga la vista de Reparación y mantenimiento en taller del MTPS
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 24/06/2014
	*	Observaciones: Ninguna
	*/
	
	function tallerMTPS()
	{
		$data['vehiculos']=$this->transporte_model->consultar_vehiculos(2);
		pantalla('mantenimiento/taller_MTPS',$data);
	}
	
	/*
	*	Nombre: vehiculo_info
	*	Objetivo: carga los datos de los vehiculos para la vista de Reparación y mantenimiento en taller del MTPS
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 22/07/2014
	*	Observaciones: Ninguna
	*/
	
	function vehiculo_info($id_vehiculo,$estado)
	{
		$vehiculo=$this->transporte_model->consultar_vehiculo_taller($id_vehiculo,$estado);
		
		$j=json_encode($vehiculo);
		echo $j;
	}
	
	/*
	*	Nombre: guardar_vehiculo
	*	Objetivo: Registra los datos de un nuevo vehículo en la Base de Datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 23/07/2014
	*	Observaciones: Ninguna
	*/
	function guardar_vehiculo()
	{
		$this->db->trans_start();
		$placa=$this->input->post('placa');
		$id_marca=$this->input->post('marca');
		$id_modelo=$this->input->post('modelo');
		$id_clase=$this->input->post('clase');
		$anio=$this->input->post('anio');
		$id_condicion=$this->input->post('condicion');
		$id_seccion_vales=$this->input->post('seccion_vales');
		$id_seccion=$this->input->post('seccion');
		$id_empleado=$this->input->post('motorista');
		$id_fuente_fondo=$this->input->post('fuente');
		$img_df=$this->input->post('img_df');
		if($img_df=="si") $imagen="vehiculo.jpg";
		else
		{
			$config['upload_path'] = './fotografias_vehiculos/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
					
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload())
			{
				echo "<script language='javascript'>
				alert('Seleccione Un Archivo valido de formato: .gif | .jpg | .png | .jpeg');
				</script>";
				pantalla('mantenimiento/nuevo_vehiculo');
			}	
			else
			{
				echo "<script language='javascript'>
				alert('Fotografia subida correctamente');
				</script>";
				$file_data = $this->upload->data();
				$imagen=$file_data['file_name'];
			}
		}		
		$nmarca=$this->input->post('nmarca');
		$nmodelo=$this->input->post('nmodelo');
		$nclase=$this->input->post('nclase');
		$nfuente=$this->input->post('nfuente');
		
		if($id_marca==0 && $nmarca!="")
		{
			$id_marca=$this->transporte_model->nueva_marca($nmarca);
		}
		if($id_modelo==0 && $nmodelo!="")
		{
			$id_modelo=$this->transporte_model->nuevo_modelo($nmodelo);
		}
		if($id_clase==0 && $nclase!="")
		{
			$id_clase=$this->transporte_model->nueva_clase($nclase);
		}
		if($id_fuente_fondo==0 && $nfuente!="")
		{
			$id_fuente_fondo=$this->transporte_model->nueva_fuente($nfuente);
		}
		if($id_marca!=0 && $id_modelo!=0 && $id_clase!=0 && $id_fuente_fondo!=0)
		{
			$this->transporte_model->registrar_vehiculo($placa,$id_marca,$id_modelo,$id_clase,$anio,$id_condicion,$id_seccion_vales,$id_seccion,$id_empleado,$id_fuente_fondo,$imagen);
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a("index.php/vehiculo/nuevo_vehiculo/".$tr);
		}
		else
		{
			ir_a("index.php/vehiculo/nuevo_vehiculo/0");
		}
	}
	
	/*
	*	Nombre: dialogo_vehiculo_info
	*	Objetivo: Modificar los datos de un vehículo en la Base de Datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 16/07/2014
	*	Observaciones: Ninguna
	*/
	
	function dialogo_vehiculo_info($id_vehiculo)
	{
		$data['datos']=$this->transporte_model->consultar_vehiculo_taller($id_vehiculo);
		$this->load->view('mantenimiento/dialogo_vehiculo_info',$data);
	}
	
	/*
	*	Nombre: guardar_taller
	*	Objetivo: insertar en la Base de Datos un nuevo registro de mtto. del taller del MTPS
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 05/07/2014
	*	Observaciones: Ninguna
	*/
	
	function guardar_mtto_taller()
	{
		$this->db->trans_start();
		
	}
	
	/*
	*	Nombre: guardar_mantenimiento
	*	Objetivo: insertar en la Base de Datos un nuevo registro de ingreso de un vehiculo al taller del MTPS
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 26/07/2014
	*	Observaciones: Ninguna
	*/
	
	function guardar_mantenimiento()
	{
		$this->db->trans_start();
		
	}

	function guardar_taller()
	{
		$this->db->trans_start();
		$_POST['id_usuario']=$this->session->userdata('id_usuario');
		$this->transporte_model->guardar_taller($_POST);

	}

	/*
	*	Nombre: vehiculos_pdf
	*	Objetivo: llama a la vista de vehiculo_pdf para odservar los reportes
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 28/07/2014
	*	Observaciones: Ninguna
	*/
	
	function reporte_vehiculos()
	{
		$data['motoristas']=$this->transporte_model->consultar_motoristas2();
		$data['marca']=$this->transporte_model->consultar_marcas();
		$data['modelo']=$this->transporte_model->consultar_modelos();
		$data['clase']=$this->transporte_model->consultar_clases();
		$data['condicion']=$this->transporte_model->consultar_condiciones();
		$data['seccion']=$this->transporte_model->consultar_secciones();
		$data['fuente_fondo']=$this->transporte_model->consultar_fuente_fondo();
		pantalla('mantenimiento/reporte_vehiculos',$data);	
	}

	/*
	*	Nombre: vehiculos_pdf
	*	Objetivo: llama a la vista de vehiculo_pdf para odservar los reportes
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 29/07/2014
	*	Observaciones: Ninguna
	*/
	
	function vehiculos_pdf()
	{
		$data['datos']=$this->transporte_model->filtro_vehiculo($_POST);
		$this->mpdf->mPDF('utf-8','letter',0, '', 4, 4, 6, 6, 9, 9); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
		$stylesheet = file_get_contents('css/pdf/solicitud.css'); /*Selecionamos la hoja de estilo del pdf*/
		$this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
		//$data['nombre'] = "Renatto NL";
		$html = $this->load->view('mantenimiento/vehiculos_pdf', $data, true); /*Seleccionamos la vista que se convertirá en pdf*/
		$this->mpdf->WriteHTML($html,2); /*la escribimos en el pdf*/
		//if(count($data['destinos'])>1) { /*si la solicitud tiene varios detinos tenemos que crear otra hoja en el pdf y escribirlos allí*/
		//	$this->mpdf->AddPage();
		//	$html = $this->load->view('transporte/reverso_solicitud_pdf.php', $data, true);
		//	$this->mpdf->WriteHTML($html,2);
		//}
		$this->mpdf->Output(); /*Salida del pdf*/	
	}
}
?>