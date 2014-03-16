<?php

class Transporte_model extends CI_Model {
    //constructor de la clase
    function __construct() {
        //LLamar al constructor del Modelo
        parent::__construct();
	
    }
	function consultar_seccion($nr)
	{
		$sentencia="SELECT
					o1.id_seccion AS id_nivel_1,
					o1.nombre_seccion AS nivel_1,
					o2.id_seccion AS id_nivel_2,
					o2.nombre_seccion AS nivel_2,
					o3.id_seccion AS id_nivel_3,
					o3.nombre_seccion AS nivel_3,
					o4.id_seccion AS id_nivel_4,
					o4.nombre_seccion AS nivel_4,
					o5.id_seccion AS id_nivel_5,
					o5.nombre_seccion AS nivel_5,
					o6.id_seccion AS id_nivel_6,
					o6.nombre_seccion AS nivel_6,
					CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre) AS nombre
					CONCAT_WS(' ',sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada) AS apellido
					FROM
					sir_empleado
					INNER JOIN org_seccion AS o1 ON sir_empleado.id_seccion = o1.id_seccion
					LEFT JOIN org_seccion AS o2 ON o2.id_seccion=o1.depende
					LEFT JOIN org_seccion AS o3 ON o3.id_seccion=o2.depende
					LEFT JOIN org_seccion AS o4 ON o4.id_seccion=o3.depende
					LEFT JOIN org_seccion AS o5 ON o5.id_seccion=o4.depende
					LEFT JOIN org_seccion AS o6 ON o6.id_seccion=o5.depende
					WHERE sir_empleado.nr like '".$nr."'";
		$query=$this->db->query($sentencia);
	
		if($query->num_rows>0) {
			return (array)$query->row();
		}
		else {
			return array(
				'id_nivel_1' => 0
			);
		}
	}
	
	function consultar_empleados($nr=0) 
	{
		$sentencia="SELECT
					sir_empleado.NR,
					CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada) AS nombre
					FROM sir_empleado
					WHERE sir_empleado.NR<>".$nr;
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return 0;
		}
	}
	
	function consultar_empleado($nr) 
	{
		$sentencia="SELECT
					sir_empleado.NR,
					CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada) AS nombre
					FROM sir_empleado
					WHERE sir_empleado.NR=".$nr;
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return 0;
		}
	}
	
	function consultar_departamentos() 
	{
		$sentencia="SELECT
					org_departamento.id_departamento,
					org_departamento.departamento
					FROM
					org_departamento
					LIMIT 0, 14";
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return 0;
		}
	}

	function consultar_municipios() 
	{
		$sentencia="SELECT id_municipio id , municipio nombre FROM org_municipio ";
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return 0;
		}
	}
	
	function consultar_secciones() 
	{
		$sentencia="SELECT
					org_seccion.id_seccion,
					org_seccion.nombre_seccion
					FROM
					org_seccion";
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return 0;
		}
	}
	
	function solicitudes_por_confirmar(){
	  $query=$this->db->query(" SELECT id_solicitud_transporte AS id, CONCAT_WS(' ',fecha_mision,hora_salida) AS fecha, lugar_destino AS lugar, mision_encomendada  mision FROM tcm_solicitud_transporte WHERE estado_solicitud_transporte = 1");
   	return $query->result();
		
	}
	function solicitudes_por_asignar(){
	  $query=$this->db->query(" SELECT id_solicitud_transporte id, date_format(fecha_mision,'%d-%m-%Y') fecha,hora_entrada_mision entrada, hora_salida_mision salida, municipio,lugar_destino lugar, mision_encomendada mision FROM tcm_solicitud_transporte  t INNER JOIN org_municipio m  ON t.id_org_municipio=m.id_municipio WHERE estado=3");
   	return $query->result();
		
	}
	function datos_de_solicitudes($id,$seccion){
		  $query=$this->db->query("SELECT id_solicitud_transporte id, 
	CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada) AS nombre,
	mision_encomendada mision, 
	fecha_solicitud_transporte fecha,
	hora_salida salida,
	hora_entrada entrada,
	m.municipio ,
	lugar_destino lugar,
	nombre_seccion
	FROM tcm_solicitud_transporte  s 
	INNER JOIN sir_empleado e ON id_empleado_solicitante = id_empleado
	INNER JOIN  org_municipio m ON m.id_municipio= s.id_municipio,
	org_seccion sec
	WHERE   sec.id_seccion = ".$seccion." AND id_solicitud_transporte =".$id);
	
		return $query->result();
	}	
	function aprobar($id, $estado, $nr){
		  $query=$this->db->query("UPDATE tcm_solicitud_transporte SET estado_solicitud_transporte=".$estado.", NR_autorizado = '".$nr."' WHERE id_solicitud_transporte= '".$id."'");
	
		return $query;
	}	
	
	function consultar_vehiculos()
	{
		$query=$this->db->query("SELECT ov.placa,ov.marca,ov.modelo,otv.nombre as tipo_vehiculo,ov.condicion
								FROM org_vehiculo as ov inner join org_tipo_vehiculo as otv on (ov.id_tipo_vehiculo=otv.id_tipo_vehiculo);");
		return $query->result();
	}
	function consultar_motoristas()
	{
		$query=$this->db->query("SELECT * FROM sir_empleado o;");
		return $query->result();
	}
	
}
?>