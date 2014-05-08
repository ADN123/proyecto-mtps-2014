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
	
	function consultar_oficinas($id_seccion=NULL)
	{
		if($id_seccion!=NULL) {
			$oficinas=array(
				array("id_ofi"=>9,"nom_ofi"=>"Oficina Central San Salvador")
			);
		}
		else {
			$oficinas=array(
				array("id_ofi"=>9,"nom_ofi"=>"Oficina Central San Salvador"),
				array("id_ofi"=>1,"nom_ofi"=>"Oficina Departamental Ahuachapán"),
				array("id_ofi"=>2,"nom_ofi"=>"Oficina Departamental Cabañas"),
				array("id_ofi"=>3,"nom_ofi"=>"Oficina Departamental Chalatenango"),
				array("id_ofi"=>4,"nom_ofi"=>"Oficina Departamental Cuscatlán"),
				array("id_ofi"=>5,"nom_ofi"=>"Oficina Departamental La Libertad"),
				array("id_ofi"=>6,"nom_ofi"=>"Oficina Departamental La Unión"),
				array("id_ofi"=>7,"nom_ofi"=>"Oficina Departamental Morazán"),
				array("id_ofi"=>8,"nom_ofi"=>"Oficina Departamental San Miguel"),
				array("id_ofi"=>10,"nom_ofi"=>"Oficina Departamental San Vicente"),
				array("id_ofi"=>11,"nom_ofi"=>"Oficina Departamental Santa Ana"),
				array("id_ofi"=>12,"nom_ofi"=>"Oficina Departamental Sonsonate"),
				array("id_ofi"=>13,"nom_ofi"=>"Oficina Departamental Usulután"),
				array("id_ofi"=>14,"nom_ofi"=>"Oficina Departamental Zacatecoluca")
			);
		}
		return $oficinas;
	}
}
?>