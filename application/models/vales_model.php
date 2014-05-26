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
		if($id_seccion!=NULL){
			$where.= "	WHERE s.id_seccion = '".$id_seccion."'";
		}
			
		$sentencia="SELECT 	s.id_seccion,s.nombre_seccion
					FROM 	org_seccion s
				INNER JOIN tcm_vehiculo v ON s.id_seccion = v.id_seccion
				".$where."
				 GROUP BY s.id_seccion";

		$query=$this->db->query($sentencia);	
		return (array)$query->result_array();

	}

	function vehiculos($id_seccion=NULL, $id_fuente_fondo= NULL)	{	
		$whereb=FALSE;

		$sentencia="SELECT  v.id_vehiculo, v.placa,  vm.nombre as marca, vmo.modelo, v.id_seccion
						FROM tcm_vehiculo v
							INNER JOIN tcm_vehiculo_marca vm ON v.id_marca = vm.id_vehiculo_marca 
							INNER JOIN  tcm_vehiculo_modelo vmo ON vmo.id_vehiculo_modelo = v.id_modelo";

			if($id_seccion!=NULL){
				$sentencia.= "	WHERE v.id_seccion = '".$id_seccion."'";
				$whereb = TRUE;
			}

			if ($id_fuente_fondo!=NULL) {
				
				if ($whereb) {
					$sentencia.=" AND ";
				}else{
					$sentencia.=" WHERE ";
				}
			$sentencia.= " v.id_fuente_fondo = '".$id_fuente_fondo."'";
			} 
			
		$query=$this->db->query($sentencia);
		
		return (array)$query->result_array();
	
	}

		function consultar_fuente_fondo()
	{
		$query=$this->db->query("select id_fuente_fondo ,nombre_fuente_fondo as nombre_fuente from tcm_fuente_fondo");
			return (array)$query->result_array();
	}
	function guardar_requisicion($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO tcm_requisicion 
		( fecha , id_seccion, cantidad_solicitada,id_empleado_solicitante,id_fuente_fondo,justificacion , id_usuario_crea, fecha_creacion) 
		VALUES 
		(CURDATE(), '$id_seccion','$cantidad_solicitada',      '$id_empleado', $id_fuente_fondo '$justificacion' $id_usuario,   'CURDATE()');";
		echo $sentencia;
		//$this->db->query($sentencia);

	}

public function get_id_empleado($nr=''){}
{
	# code...
}
	
}
?>