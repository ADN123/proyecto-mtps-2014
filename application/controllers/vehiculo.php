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
	*	Última Modificación: 13/11/2014
	*	Observaciones: Ninguna
	*/
	function vehiculos($estado_transaccion=NULL,$tipo=NULL)
	{
		if($estado_transaccion!=NULL)
		{
			$data['estado_transaccion']=$estado_transaccion;
			
			if($tipo!=NULL)
			{
				switch($tipo)
				{
					case 1: $data['mensaje']="Se ha ingresado la información de un nuevo vehículo éxitosamente";
							break;
					case 2: $data['mensaje']="Se ha modificado la información del vehículo éxitosamente";
							break;
				}
			}
		}
		$data['datos']=$this->transporte_model->consultar_vehiculos();
		pantalla('mantenimiento/vehiculos',$data);
	}
	
	/*
	*	Nombre: nuevo_vehiculo
	*	Objetivo: Carga la vista para el Registro de un nuevo Vehículo a la Base de Datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 13/11/2014
	*	Observaciones: Ninguna
	*/
	function nuevo_vehiculo($id_vehiculo=0)
	{
		if($id_vehiculo==0)
		{
			$data['motoristas']=$this->transporte_model->consultar_motoristas2();
			$data['marca']=$this->transporte_model->consultar_marcas();
			$data['modelo']=$this->transporte_model->consultar_modelos();
			$data['clase']=$this->transporte_model->consultar_clases();
			$data['condicion']=$this->transporte_model->consultar_condiciones();
			$data['seccion']=$this->transporte_model->consultar_secciones();
			$data['fuente_fondo']=$this->transporte_model->consultar_fuente_fondo();
			$data['bandera']='false';
		}
		else
		{
			$data['motoristas']=$this->transporte_model->consultar_motoristas2();
			$data['marca']=$this->transporte_model->consultar_marcas();
			$data['modelo']=$this->transporte_model->consultar_modelos();
			$data['clase']=$this->transporte_model->consultar_clases();
			$data['condicion']=$this->transporte_model->consultar_condiciones();
			$data['seccion']=$this->transporte_model->consultar_secciones();
			$data['fuente_fondo']=$this->transporte_model->consultar_fuente_fondo();
			$data['bandera']='true';
			$data['vehiculo_info']=$this->transporte_model->consultar_vehiculo_taller($id_vehiculo);
		}
		pantalla("mantenimiento/nuevo_vehiculo",$data);
	}
	
	/*
	*	Nombre: control_taller
	*	Objetivo: Carga el catálogo de Vehículos que se encuentran en taller.
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 19/08/2014
	*	Observaciones: Ninguna
	*/
	
	function control_taller()
	{
		$data['datos']=$this->transporte_model->consultar_vehiculos(2);
		pantalla('mantenimiento/control_taller',$data);
	}
	
	/*
	*	Nombre: controlMtto
	*	Objetivo: carga la vista de control de mantenimiento del vehículo
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 22/07/2014
	*	Observaciones: Ninguna
	*/
	
	function controlMtto($estado_transaccion=NULL)
	{
		$data['vehiculos']=$this->transporte_model->consultar_vehiculos(1);
		$data['estado_transaccion']=$estado_transaccion;
		pantalla('mantenimiento/control_mantenimiento',$data);
	}
	
	/*
	*	Nombre: guardar_mantenimiento
	*	Objetivo: insertar en la Base de Datos un nuevo registro de ingreso de un vehiculo al taller del MTPS
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 19/08/2014
	*	Observaciones: Ninguna
	*/
	
	function guardar_mantenimiento()
	{
		$this->db->trans_start();
		$_POST['id_usuario']=$this->session->userdata('id_usuario');
		$this->transporte_model->guardar_mtto($_POST);
		$this->db->trans_complete();
		$tr=($this->db->trans_status()===FALSE)?0:1;
		ir_a("index.php/vehiculo/controlMtto/".$tr);
	}
	
	/*
	*	Nombre: tallerMTPS
	*	Objetivo: carga la vista de Reparación y mantenimiento en taller del MTPS
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 27/11/2014
	*	Observaciones: Ninguna
	*/
	
	function tallerMTPS($id_v)
	{
		$data['vehiculos']=$this->transporte_model->consultar_vehiculo_taller($id_v,2);
		pantalla('mantenimiento/taller_MTPS',$data);
	}
	
	/*
	*	Nombre: guardar_taller
	*	Objetivo: insertar en la Base de Datos un nuevo registro de mtto. del taller del MTPS
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 20/08/2014
	*	Observaciones: Ninguna
	*/

	function guardar_taller()
	{
		$this->db->trans_start();
		$_POST['id_usuario']=$this->session->userdata('id_usuario');
		$this->transporte_model->guardar_taller($_POST);
		$this->db->trans_complete();
		$tr=($this->db->trans_status()===FALSE)?0:1;
		ir_a("index.php/vehiculo/tallerMTPS/".$tr);
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
	*	Última Modificación: 13/11/2014
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
		$id_seccion=$this->input->post('seccion');
		$id_empleado=$this->input->post('motorista');
		$id_fuente_fondo=$this->input->post('fuente');
		$tipo_combustible=$this->input->post('tipo_combustible');
		
		if($img_df=="si") $imagen="vehiculo.jpg";
		else
		{
			$config['upload_path'] = './fotografias_vehiculos/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['file_name']=$placa;
					
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
			$this->transporte_model->registrar_vehiculo($placa,$id_marca,$id_modelo,$id_clase,$anio,$id_condicion,$tipo_combustible,$id_seccion,$id_empleado,$id_fuente_fondo,$imagen);
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a("index.php/vehiculo/vehiculos/".$tr."/1");
		}
		else
		{
			ir_a("index.php/vehiculo/vehiculos/0");
		}
	}
	
	/*
	*	Nombre: modificar_vehiculo
	*	Objetivo: modifica los datos de un vehículo en la Base de Datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 13/11/2014
	*	Observaciones: Ninguna
	*/
	function modificar_vehiculo($id)
	{
		$this->db->trans_start();
		$placa=$this->input->post('placa');
		$id_marca=$this->input->post('marca');
		$id_modelo=$this->input->post('modelo');
		$id_clase=$this->input->post('clase');
		$anio=$this->input->post('anio');
		$id_condicion=$this->input->post('condicion');
		$id_seccion=$this->input->post('seccion');
		$id_empleado=$this->input->post('motorista');
		$id_fuente_fondo=$this->input->post('fuente');
		$tipo_combustible=$this->input->post('tipo_combustible');
		$estado=$this->input->post('estado');
		$img_df=$this->input->post('img_df');
		if($img_df=="si") $imagen=$this->input->post('imagen');
		else
		{
			$config['upload_path'] = './fotografias_vehiculos/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['file_name']=$placa;
					
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
				/*echo "<script language='javascript'>
				alert('Fotografia subida correctamente');
				</script>";*/
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
			$this->transporte_model->modificar_vehiculo($placa,$id_marca,$id_modelo,$id_clase,$anio,$id_condicion,$tipo_combustible,$id_seccion,$id_empleado,$id_fuente_fondo,$imagen,$id,$estado);
			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;
			ir_a("index.php/vehiculo/vehiculos/".$tr."/2");
		}
		else
		{
			ir_a("index.php/vehiculo/vehiculos/0");
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
		$this->load->view('mantenimiento/dialogo_vehiculo_info.php',$data);
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
	*	Objetivo: llama a la vista de vehiculo_pdf para observar los reportes
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 29/07/2014
	*	Observaciones: Ninguna
	*/
	
	function vehiculos_pdf()
	{
		$data['datos']=$this->transporte_model->filtro_vehiculo($_POST);
		$this->mpdf->mPDF('utf-8','A4-L'); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
		$stylesheet = file_get_contents('css/pdf/solicitud.css'); /*Selecionamos la hoja de estilo del pdf*/
		$this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
		$html = $this->load->view('mantenimiento/vehiculos_pdf', $data, true); /*Seleccionamos la vista que se convertirá en pdf*/
		$this->mpdf->WriteHTML($html,2); /*la escribimos en el pdf*/
		//if(count($data['destinos'])>1) { /*si la solicitud tiene varios detinos tenemos que crear otra hoja en el pdf y escribirlos allí*/
		//	$this->mpdf->AddPage();
		//	$html = $this->load->view('transporte/reverso_solicitud_pdf.php', $data, true);
		//	$this->mpdf->WriteHTML($html,2);
		//}
		$this->mpdf->Output(); /*Salida del pdf*/	
	}
	
	/*
	*	Nombre: presupuestos
	*	Objetivo: llama a la vista de presupuestos para el control de los presupuestos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 15/12/2014
	*	Observaciones: Ninguna
	*/
	
	function presupuestos($estado_transaccion=NULL,$tipo=NULL)
	{
		if($estado_transaccion!=NULL)
		{
			$data['estado_transaccion']=$estado_transaccion;
			if($tipo!=NULL && $estado_transaccion==1)
			{
				switch($tipo)
				{
					case 1: $data['mensaje']='Se ha registrado un nuevo presupuesto éxitosamente';
							break;
					case 2: $data['mensaje']='Se ha modificado la información del presupuesto éxitosamente';
							break;
					case 3: $data['mensaje']='Se ha reforzado el presupuesto éxitosamente';
							break;
				}
			}
		}
		$data['presupuesto']=$this->transporte_model->presupuesto();
		pantalla('mantenimiento/presupuestos',$data);
	}
	
	/*
	*	Nombre: nuevo_presupuesto
	*	Objetivo: función que sirve para ingresar un nuevo presupuestos o modificarlo
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 13/11/2014
	*	Observaciones: Ninguna
	*/
	
	function nuevo_presupuesto($id_presupuesto=0)
	{
		if($id_presupuesto!=0)
		{
			$data['presupuesto']=$this->transporte_model->presupuesto($id_presupuesto);
			$data['presupuesto']=$data['presupuesto'][0];
			$data['bandera']=true;
		}
		else $data['bandera']=false;
		pantalla('mantenimiento/nuevo_presupuesto',$data);
	}
	
	/*
	*	Nombre: ventana_presupuesto_gastos
	*	Objetivo: carga la ventana en donde se miran detalladamente los gastos realizados de un presupuesto específico
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 10/11/2014
	*	Observaciones: Ninguna
	*/
	
	function ventana_presupuesto_gastos($id_presupuesto)
	{
		$data['presupuesto_info']=$this->transporte_model->presupuesto($id_presupuesto);
		$data['presupuesto_info']=$data['presupuesto_info'][0];
		$data['gastos']=$this->transporte_model->gastos($id_presupuesto);
		$this->load->view('mantenimiento/ventana_gastos',$data);
	}
	
	/*
	*	Nombre: guardar_presupuesto
	*	Objetivo: guarda un nuevo registro de presupuesto
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 25/11/2014
	*	Observaciones: Ninguna
	*/
	
	function guardar_presupuesto()
	{
		$this->db->trans_start();
		$_POST['id_usuario']=$this->session->userdata('id_usuario');
		$this->transporte_model->guardar_presupuesto($_POST);
		$this->db->trans_complete();
		$tr=($this->db->trans_status()===FALSE)?0:1;
		ir_a("index.php/vehiculo/presupuestos/".$tr."/1");
	}
	
	/*
	*	Nombre: modificar_presupuesto
	*	Objetivo: guarda un nuevo registro de presupuesto
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 13/11/2014
	*	Observaciones: Ninguna
	*/
	
	function modificar_presupuesto()
	{
		$this->db->trans_start();
		$_POST['id_usuario']=$this->session->userdata('id_usuario');
		$this->transporte_model->modificar_presupuesto($_POST);
		$this->db->trans_complete();
		$tr=($this->db->trans_status()===FALSE)?0:1;
		ir_a("index.php/vehiculo/presupuestos/".$tr."/2");
	}
	
	/*
	*	Nombre: nuevo_refuerzo
	*	Objetivo: llama a la vista de nuevo refuerzo para registrarlo en la base de datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 15/12/2014
	*	Observaciones: Ninguna
	*/
	
	function nuevo_refuerzo($id_presupuesto)
	{
		$data['id_presupuesto']=$id_presupuesto;
		pantalla('mantenimiento/nuevo_refuerzo',$data);
	}
	
	/*
	*	Nombre: guardar_refuerzo
	*	Objetivo: guarda un nuevo refuerzo en la base de datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 15/12/2014
	*	Observaciones: Ninguna
	*/
	
	function guardar_refuerzo()
	{
		$this->db->trans_start();
		$_POST['id_usuario']=$this->session->userdata('id_usuario');
		$this->transporte_model->guardar_refuerzo($_POST);
		$this->db->trans_complete();
		$tr=($this->db->trans_status()===FALSE)?0:1;
		ir_a("index.php/vehiculo/presupuestos/".$tr."/3");
	}
	
	/*
	*	Nombre: nuevo_articulo
	*	Objetivo: llama a la vista de nuevo artículo para registrarlo en la base de datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 17/12/2014
	*	Observaciones: Si el valor de la variable $id_articulo es diferente de NULL,la función sirve para modificar la información de un artículo
	*/
	
	function nuevo_articulo($id_articulo=NULL)
	{
		if($id_articulo!=NULL)
		{
			$data['articulo']=$this->transporte_model->inventario($id_articulo);
			$data['articulo']=$data['articulo'][0];
			$data['bandera']='true';
		}
		else $data['bandera']='false';
		
		pantalla('mantenimiento/nuevo_articulo',$data);
	}
	
	/*
	*	Nombre: cargar_articulo
	*	Objetivo: llama a la vista de cargar_articulo para suplirlo en la bodega
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 17/12/2014
	*	Observaciones:
	*/
	
	function cargar_articulo($id_articulo)
	{
		$data['articulo']=$this->transporte_model->inventario($id_articulo);
		$data['articulo']=$data['articulo'][0];
		pantalla('mantenimiento/cargar_articulo',$data);
	}
	
	/*
	*	Nombre: guardar_articulo
	*	Objetivo: registra un nuevo artículo en la bodega.
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 16/12/2014
	*	Observaciones: Ninguna
	*/
	
	function guardar_articulo()
	{
		$this->db->trans_start();
		$_POST['id_usuario']=$this->session->userdata('id_usuario');
		$this->transporte_model->guardar_articulo($_POST);
		$this->db->trans_complete();
		$tr=($this->db->trans_status()===FALSE)?0:1;
		ir_a("index.php/vehiculo/bodega/".$tr."/3");
	}
	
	/*
	*	Nombre: modificar_articulo
	*	Objetivo: modifica la información del artículo en la bodega.
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 17/12/2014
	*	Observaciones: Ninguna
	*/
	
	function modificar_articulo()
	{
		$this->db->trans_start();
		$this->transporte_model->modificar_articulo($_POST);
		$this->db->trans_complete();
		$tr=($this->db->trans_status()===FALSE)?0:1;
		ir_a("index.php/vehiculo/bodega/".$tr."/4");
	}
	
	/*
	*	Nombre: surtir_articulo
	*	Objetivo: surte en bodega más artículos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 17/12/2014
	*	Observaciones:
	*/
	
	function surtir_articulo()
	{
		$this->db->trans_start();
		$this->transporte_model->surtir_articulo($_POST);
		$this->db->trans_complete();
		$tr=($this->db->trans_status()===FALSE)?0:1;
		ir_a("index.php/vehiculo/bodega/".$tr."/5");
	}
	
	/*
	*	Nombre: ventana_articulo
	*	Objetivo: llama a la ventana_rtículo para mostrar información detallada del artículo
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 17/12/2014
	*	Observaciones:
	*/
	
	function ventana_articulo($id_articulo)
	{
		$data['tta']=$this->transporte_model->transaccion_articulo($id_articulo);
		$data['articulo']=$this->transporte_model->inventario($id_articulo);
		$data['articulo']=$data['articulo'][0];
		$this->load->view('mantenimiento/ventana_articulo',$data);
	}
	
	/*
	*	Nombre: bodega
	*	Objetivo: llama a la vista de bodega para observar el inventario en bodega
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 13/11/2014
	*	Observaciones: Ninguna
	*/
	
	function bodega($estado_transaccion=NULL,$tipo=NULL)
	{
		if($estado_transaccion!=NULL)
		{
			$data['estado_transaccion']=$estado_transaccion;
			if($tipo!=NULL && $estado_transaccion==1)
			{
				switch($tipo)
				{
					case 1: $data['mensaje']='Se ha registrado un nuevo artículo a bodega éxitosamente';
							break;
					case 2: $data['mensaje']='Se ha modificado la información del artículo éxitosamente';
							break;
					case 3: $data['mensaje']='Se ha registrado un nuevo material en bodega éxitosamente';
							break;
					case 4: $data['mensaje']='Se ha cargado el material en bodega éxitosamente';
							break;
					case 5: $data['mensaje']='Se ha cargado el artículo en bodega éxitosamente';
							break;
				}
			}
		}
		$data['inventario']=$this->transporte_model->inventario();
		pantalla('mantenimiento/bodega',$data);
	}
}
?>