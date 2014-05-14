<?php
class Vehiculo extends CI_Controller
{
    
    function Vehiculo()
	{
        parent::__construct();
		$this->load->model('transporte_model');
//		$this->load->model('vehiculo_model');
    	if(!$this->session->userdata('id_usuario')){
		 redirect('index.php/sessiones');
		}
    }
	
	function index()
	{
		echo"ok";
  	}
	function  mantenimiento(){
		
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
	*	Nombre: guardar_vehiculo
	*	Objetivo: Registra los datos de un nuevo vehículo en la Base de Datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 14/05/2014
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
		$id_departamento=$this->input->post('oficina');
		$id_seccion=$this->input->post('seccion');
		$id_empleado=$this->input->post('motorista');
		$id_fuente_fondo=$this->input->post('fuente');
		$imagen=$this->input->post('imagen');
		
		if($imagen=="") $imagen="vehiculo.jpg"; ////////////// si no se sube una fotografía se pondrá una por defecto.
		
		$nmarca=$this->input->post('nmarca');
		$nmodelo=$this->input->post('nmodelo');
		$nclase=$this->input->post('nclase');
		$nfuente=$this->input->post('nfuente');
		
		if($id_marca==0 && $nmarca!="")
		{
			$this->transporte_model->nueva_marca($nmarca);
			$id_marca=$this->transporte_model->ultima_marca();
		}
		if($id_modelo==0 && $nmodelo!="")
		{
			$this->transporte_model->nuevo_modelo($nmodelo);
			$id_modelo=$this->transporte_model->ultimo_modelo();
		}
		if($id_clase==0 && $nclase!="")
		{
			$this->transporte_model->nueva_clase($nclase);
			$id_clase=$this->transporte_model->ultima_clase();
		}
		if($id_fuente_fondo==0 && $nfuente!="")
		{
			$this->transporte_model->nueva_fuente($nfuente);
			$id_fuente_fondo=$this->transporte_model->ultima_fuente_fondo();
		}
		if($id_marca!=0 && $id_modelo!=0 && $id_clase!=0 && $id_fuente_fondo!=0)
		{
			$this->transporte_model->registrar_vehiculo($placa,$id_marca,$id_modelo,$id_clase,$anio,$id_condicion,$id_departamento,$id_seccion,$id_empleado,$id_fuente_fondo,$imagen);
			$this->db->trans_complete();
			ir_a("index.php/vehiculo/nuevo_vehiculo/".$this->db->trans_status());
		}
		else
		{
			ir_a("index.php/vehiculo/nuevo_vehiculo/0");
		}
	}
	
	/*
	*	Nombre: modifica_vehiculo
	*	Objetivo: Modificar los datos de un vehículo en la Base de Datos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 29/04/2014
	*	Observaciones: Ninguna
	*/
	
	function modifica_vehiculo()
	{
		$data['datos']=$this->transporte_model->consultar_vehiculos();
	}
}
?>