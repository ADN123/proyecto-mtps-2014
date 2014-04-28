<?php

class Vales_model extends CI_Model {
    //constructor de la clase
    function __construct() {
        //LLamar al constructor del Modelo
        parent::__construct();
	
    }
	
	function consultar_gasolineras()
	{
		$sentencia="SELECT tcm_gasolinera.id_gasolinera, tcm_gasolinera.nombre FROM tcm_gasolinera";
		$query=$this->db->query($sentencia);
	
		return (array)$query->result_array();
	}
	
	function guardar_vales($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO tcm_vale
					(inicial, final, valor_nominal, tipo_vehiculo, id_gasolinera, fecha_recibido, cantidad_restante, id_usuario_crea, fecha_creacion) 
					VALUES 
					('$inicial', '$final', '$valor_nominal', '$tipo_vehiculo', '$id_gasolinera', '$fecha_recibido', '$cantidad_restante', '$id_usuario_crea', '$fecha_creacion')";
		$this->db->query($sentencia);
	}
}
?>