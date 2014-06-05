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

function consultar_oficinas_san_salvador()
	{

		$sentencia="SELECT 	s.id_seccion,s.nombre_seccion
									FROM 	org_seccion s
									INNER JOIN tcm_vehiculo v ON s.id_seccion = v.id_seccion			
					WHERE 	s.id_seccion NOT BETWEEN 52 AND 66
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

		function consultar_fuente_fondo($id_seccion=NULL)
	{
		$where="";
		if($id_seccion!=NULL){
			$where="WHERE 	tv.id_seccion = ".$id_seccion;

		}
		$query=$this->db->query("	SELECT
									ff.id_fuente_fondo,
									ff.nombre_fuente_fondo AS nombre_fuente
								FROM
									tcm_fuente_fondo ff
								INNER JOIN tcm_vehiculo tv ON tv.id_fuente_fondo = ff.id_fuente_fondo
								".$where."
								GROUP BY
									id_fuente_fondo");
			return (array)$query->result_array();

	}
	function consultar_fuente_fondo_san_salvador()
	{

		$query=$this->db->query("	SELECT
									ff.id_fuente_fondo,
									ff.nombre_fuente_fondo AS nombre_fuente
								FROM
									tcm_fuente_fondo ff
								INNER JOIN tcm_vehiculo tv ON tv.id_fuente_fondo = ff.id_fuente_fondo
								WHERE 	tv.id_seccion NOT BETWEEN 52 AND 66
								GROUP BY
									id_fuente_fondo");
			return (array)$query->result_array();

	}
	function guardar_requisicion($formuInfo,$id_usuario, $id_empleado_solicitante) 
	{ 
		extract($formuInfo);
		$sentencia="INSERT INTO tcm_requisicion 
		( fecha , id_seccion, cantidad_solicitada,id_empleado_solicitante,id_fuente_fondo,justificacion , id_usuario_crea, fecha_creacion) 
			VALUES (CURDATE(), '$id_seccion','$cantidad_solicitada','$id_empleado_solicitante', $id_fuente_fondo, '$justificacion', $id_usuario, CURDATE())";
		

		$this->db->query($sentencia);
		return $this->db->insert_id();

	}

public function get_id_empleado($nr)
{
	$query="SELECT id_empleado FROM sir_empleado WHERE nr ='$nr'";
	$query=$this->db->query($query);
	$query=$query->result_array();
	$query= $query[0];
	return $query['id_empleado'];

}
public function guardar_req_veh($id_vehiculo, $id_requisicion)
{
	$sql="INSERT INTO tcm_req_veh VALUES('$id_requisicion','$id_vehiculo');";
	$query=$this->db->query($sql);
}
public function is_departamental($id_seccion=58)
	{	

		if($id_seccion>=52 AND $id_seccion<=66 ){
			return true;
		}else{
			return false;
		}
	}
	


function consultar_requisiciones($id_seccion=NULL, $estado=NULL)
	{		
		$where="";
		if($id_seccion!=NULL){
			$where.= "	AND sr.id_seccion = '".$id_seccion."'";
		}

		$query=$this->db->query("SELECT
									id_requisicion,
									sr.nombre_seccion AS seccion,
									cantidad_solicitada AS cantidad,
									fecha
								FROM
									tcm_requisicion r
								INNER JOIN org_seccion sr ON r.id_seccion = sr.id_seccion
									WHERE estado =".$estado."
											".$where."
								ORDER BY
									fecha DESC");
			return (array)$query->result_array();


	}

	function consultar_requisiciones_san_salvador($estado=NULL)
	{
		$where="";

		if($estado!=NULL){
			$where.= "	AND estado = '".$estado."'";
		}

		$query=$this->db->query("SELECT
									id_requisicion,
									sr.nombre_seccion AS seccion,
									cantidad_solicitada AS cantidad,
									fecha
								FROM
									tcm_requisicion r
								INNER JOIN org_seccion sr ON r.id_seccion = sr.id_seccion
								WHERE sr.id_seccion NOT BETWEEN 52 	
								".$where."
								ORDER BY
									fecha DESC");
			return (array)$query->result_array();

	}
}

?>