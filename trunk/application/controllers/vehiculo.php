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
	*	Objetivo: Carga la vista para el Registro y Actualización de Datos de los Vehículos
	*	Hecha por: Oscar
	*	Modificada por: Oscar
	*	Última Modificación: 27/04/2014
	*	Observaciones: Ninguna
	*/
	function vehiculos()
	{
		$data['datos']=$this->transporte_model->consultar_vehiculos();
		pantalla('mantenimiento/vehiculos',$data);
	}
	
	function nuevo_vehiculo()
	{
		$data['motoristas']=$this->transporte_model->consultar_motoristas2();
		pantalla("mantenimiento/nuevo_vehiculo",$data);
	}
	
	function guardar_vehiculo()
	{
		$placa=$this->input->post('placa');
		$marca=$this->input->post('marca');
		$clase=$this->input->post('clase');
		$condicion=$this->input->post('condicion');
		$id_seccion=$this->input->post('seccion');
		$id_empleado=$this->input->post('motorista');
	}
}
?>