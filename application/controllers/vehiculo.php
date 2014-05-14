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
		
		$nmarca=$this->input->post('nmarca');
		$nmodelo=$this->input->post('nmodelo');
		$nclase=$this->input->post('nclase');
		$nfuente=$this->input->post('nfuente');
		
		if($id_marca!=0 && $id_modelo!=0 && $id_clase!=0 && $id_fuente_fondo!=0)
		{
			
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