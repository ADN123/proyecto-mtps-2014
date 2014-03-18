<?php

class Transporte_model extends CI_Model {
    //constructor de la clase
    function __construct() {
        //LLamar al constructor del Modelo
        parent::__construct();
	
    }
	function consultar_seccion_usuario($nr=0)
	{
		$sentencia="SELECT
					sir_empleado_informacion_laboral.id_seccion
					FROM
					org_usuario
					LEFT JOIN sir_empleado ON org_usuario.nr = sir_empleado.nr
					LEFT JOIN sir_empleado_informacion_laboral ON sir_empleado.id_empleado = sir_empleado_informacion_laboral.id_empleado
					WHERE org_usuario.nr like '".$nr."'";
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
					sir_empleado.id_empleado AS NR,
					CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada) AS nombre
					FROM sir_empleado
					WHERE sir_empleado.NR<>'".$nr."'";
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return 0;
		}
	}
	
	function consultar_empleado($nr=0) 
	{
		$sentencia="SELECT
					sir_empleado.id_empleado AS NR,
					CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada) AS nombre
					FROM sir_empleado
					WHERE sir_empleado.NR='".$nr."'";
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
		$sentencia="SELECT
					org_municipio.id_municipio AS id,
					CONCAT_WS(', ', org_departamento.departamento, org_municipio.municipio) AS nombre
					FROM
					org_municipio
					INNER JOIN org_departamento ON org_municipio.id_departamento_pais = org_departamento.id_departamento
					ORDER BY org_departamento.departamento, org_municipio.municipio";
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return 0;
		}
	}
	
	function solicitudes_por_confirmar($seccion){

	  $query=$this->db->query("
 SELECT id_solicitud_transporte AS id, 
  	CONCAT_WS(' ',DATE_FORMAT(fecha_mision, '%d-%m-%Y'),DATE_FORMAT(hora_salida,'%h:%i %p')) AS fecha, 
    lugar_destino AS lugar, 
    mision_encomendada  mision 
 FROM tcm_solicitud_transporte s
 INNER JOIN sir_empleado_informacion_laboral i ON s.id_empleado_solicitante  = i.id_empleado 
 WHERE estado_solicitud_transporte = 1 AND i.id_seccion =".$seccion);
 
 
   	return $query->result();
		
	}
function todas_solicitudes_por_confirmar(){

	  $query=$this->db->query("
 SELECT id_solicitud_transporte AS id, 
 	 CONCAT_WS(' ',DATE_FORMAT(fecha_mision, '%d-%m-%Y'),DATE_FORMAT(hora_salida,'%h:%i %p')) AS fecha, 
 	 lugar_destino AS lugar, 
 	 mision_encomendada  mision 
 FROM tcm_solicitud_transporte s
 INNER JOIN sir_empleado_informacion_laboral i ON s.id_empleado_solicitante  = i.id_empleado 
 WHERE estado_solicitud_transporte = 1");
 
 
   	return $query->result();
		
	}
	function solicitudes_por_asignar(){
	  $query=$this->db->query("SELECT id_solicitud_transporte id, date_format(fecha_mision,'%d-%m-%Y') fecha,date_format(hora_entrada,'%r') entrada, date_format(hora_salida,'%r') salida, m.municipio, lugar_destino lugar, mision_encomendada mision FROM tcm_solicitud_transporte  t INNER JOIN org_municipio m  ON t.id_municipio=m.id_municipio where (estado_solicitud_transporte=2)");
   	return $query->result();
		
	}
	function consultar_fecha_solicitud($id)
	{
		$query=$this->db->query("select st.fecha_mision as fecha, st.hora_salida as salida, st.hora_entrada as entrada from tcm_solicitud_transporte as st where st.id_solicitud_transporte='$id';");
		return $query->result();
	}
	
	///////////////////
	function consultar_fechas_solicitudes($fecha,$hentrada,$hsalida)
	{
		$query=$this->db->query("select avm.id_vehiculo from tcm_solicitud_transporte as st
inner join tcm_asignacion_sol_veh_mot as avm on (st.id_solicitud_transporte=avm.id_solicitud_transporte)
where st.fecha_mision='$fecha' and (st.hora_salida>='$hentrada' and st.hora_salida<='$hsalida');");
		return $query->result();
	}
	////////////////////
	
	function datos_de_solicitudes($id,$seccion){
		  $query=$this->db->query("
SELECT id_solicitud_transporte id, 
	CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido,e.segundo_apellido,e.apellido_casada) AS nombre,
	mision_encomendada mision, 
	DATE_FORMAT(fecha_solicitud_transporte, '%d-%m-%Y') fechaS,
	DATE_FORMAT(fecha_mision, '%d-%m-%Y')  fechaM,
	DATE_FORMAT(hora_salida,'%h:%i %p') salida,
	DATE_FORMAT(hora_entrada,'%h:%i %p') entrada,
	CONCAT_WS(', ',d.departamento,m.municipio) municipio,
	lugar_destino lugar,
	nombre_seccion seccion
FROM tcm_solicitud_transporte  s 
INNER JOIN sir_empleado e ON id_empleado_solicitante = id_empleado
INNER JOIN  org_municipio m ON m.id_municipio= s.id_municipio
INNER JOIN org_departamento d ON d.id_departamento= m.id_departamento_pais,
org_seccion sec
WHERE   sec.id_seccion = ".$seccion." AND id_solicitud_transporte =".$id);
	
		return $query->result();
	}	
	function aprobar($id, $estado, $nr, $iduse){
		$q="UPDATE tcm_solicitud_transporte SET 
				id_empleado_autoriza= (SELECT id_empleado FROM sir_empleado WHERE NR LIKE '".$nr."'),
				estado_solicitud_transporte = $estado,
				id_usuario_modifica = '".$iduse."', 
				fecha_modificacion=  CONCAT_WS(' ', CURDATE(),CURTIME())  
			WHERE id_solicitud_transporte= ".$id;
	
		  $query=$this->db->query($q);
	
		return $query;
	}	
	
	function consultar_vehiculos()
	{
		$query=$this->db->query("select * from tcm_vehiculo");
		return $query->result();
	}
	
	function validar_fecha_hora()
	{
		$query=$this->db->query("select st.id_solicitud_transporte,st.fecha_mision, st.hora_salida, st.hora_entrada, avm.id_vehiculo from tcm_solicitud_transporte as st
inner join tcm_asignacion_sol_veh_mot as avm on (st.id_solicitud_transporte=avm.id_solicitud_transporte)");
		return $query->result();
	}
	
	function consultar_motoristas()
	{
		$query=$this->db->query("SELECT * FROM sir_empleado;");
		return $query->result();
	}
	
	function info_adicional($id_empleado=0)
	{
		$sentencia="SELECT
					sir_empleado.nr,
					sir_empleado_informacion_laboral.id_seccion,
					sir_cargo_funcional.funcional,
					o1.nombre_seccion AS nivel_1,
					o2.nombre_seccion AS nivel_2,
					o3.nombre_seccion AS nivel_3
					FROM
					sir_empleado
					LEFT JOIN sir_empleado_informacion_laboral ON sir_empleado_informacion_laboral.id_empleado = sir_empleado.id_empleado
					LEFT JOIN sir_cargo_funcional ON sir_cargo_funcional.id_cargo_funcional = sir_empleado_informacion_laboral.id_cargo_funcional
					LEFT JOIN org_seccion AS o1 ON sir_empleado_informacion_laboral.id_seccion = o1.id_seccion
					LEFT JOIN org_seccion AS o2 ON o2.id_seccion = o1.depende
					LEFT JOIN org_seccion AS o3 ON o3.id_seccion = o2.depende
					WHERE sir_empleado.id_empleado='".$id_empleado."'";
		$query=$this->db->query($sentencia);
	
		if($query->num_rows>0) {
			return (array)$query->row();
		}
		else {
			return array(
				'nr' => 0
			);
		}
	}
	
	function guardar_solicitud($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO tcm_solicitud_transporte
					(fecha_solicitud_transporte, id_empleado_solicitante, mision_encomendada, fecha_mision, hora_salida, hora_entrada, id_municipio, lugar_destino, acompanante, id_usuario_crea, fecha_creacion, estado_solicitud_transporte) 
					VALUES 
					('$fecha_solicitud_transporte', '$id_empleado_solicitante', '$mision_encomendada', '$fecha_mision', '$hora_salida', '$hora_entrada', '$id_municipio', '$lugar_destino', '$acompanante', '$id_usuario_crea', '$fecha_creacion', '$estado_solicitud_transporte')";
		$this->db->query($sentencia);
		return $this->db->insert_id();
	}
	
	function guardar_acompanantes($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO tcm_acompanante
					(id_solicitud_transporte, id_empleado) 
					VALUES 
					('$id_solicitud_transporte', '$id_empleado')";
		$this->db->query($sentencia);
	}
	
	function insertar_descripcion($id,$descrip)
	{
		$q="INSERT INTO mtps.tcm_observacion 
				(id_solicitud_transporte, observacion)
			VALUES
				('".$id."', 
				'".$descrip."'
				);";
		
		$query=$this->db->query($q);	
		return $query;
	}
	
	function consultar_empleados_seccion($id_seccion)
	{
		$sentencia="SELECT
					sir_empleado.id_empleado AS NR,
					CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada) AS nombre
					FROM
					sir_empleado
					LEFT JOIN sir_empleado_informacion_laboral ON sir_empleado.id_empleado = sir_empleado_informacion_laboral.id_empleado
					WHERE sir_empleado_informacion_laboral.id_seccion='".$id_seccion."'";
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return 0;
		}
	}
/*---------------------------------Control de salidas y entradas de Vehiculos------------------------------------*/
	function salidas_entradas_vehiculos(){
		$query=$this->db->query("SELECT s.id_solicitud_transporte id,
	CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre,
	e.primer_apellido,e.segundo_apellido,e.apellido_casada) AS nombre,
	estado_solicitud_transporte estado,
	DATE_FORMAT(hora_salida,'%h:%i %p') salida,
	DATE_FORMAT(hora_entrada,'%h:%i %p') entrada,
	CONCAT_WS(', ',d.departamento,m.municipio) municipio,
	vh.placa	
FROM tcm_solicitud_transporte  s 
INNER JOIN sir_empleado e ON id_empleado_solicitante = id_empleado
INNER JOIN  org_municipio m ON m.id_municipio= s.id_municipio
INNER JOIN org_departamento d ON d.id_departamento= m.id_departamento_pais
INNER JOIN  tcm_asignacion_sol_veh_mot asi ON asi.id_solicitud_transporte=s.id_solicitud_transporte
INNER JOIN tcm_vehiculo vh ON vh.id_vehiculo= asi.id_vehiculo
WHERE  s.fecha_mision= CURDATE() AND (estado_solicitud_transporte=3 OR estado_solicitud_transporte=4)");
		return $query->result();
		
		}
function salida_vehiculo($id, $km_inicial,$hora_salida){
		$q="INSERT INTO tcm_vehiculo_kilometraje (
					id_solicitud_transporte, 
					id_vehiculo, 
					km_inicial, 
					hora_salida, 
					fecha_modificacion)
				VALUES(
					'".$id."', 
					(SELECT id_vehiculo FROM tcm_asignacion_sol_veh_mot WHERE id_solicitud_transporte = ".$id."),
					 '".$km_inicial."',    
					CONCAT_WS(' ',CURDATE(),'".$hora_salida."'), 
					CONCAT_WS(' ',CURDATE(),CURTIME())
				);";
		$this->db->query($q);
		return $this->db->insert_id();
	}

function regreso_vehiculo($id, $km, $hora, $gas){
	$q="UPDATE tcm_vehiculo_kilometraje 
	SET
		km_final = '$km' , 
		combustible = '$gas' , 
		hora_entrada = '$hora' , 
		fecha_modificacion = CURDATE()
	WHERE
		id_solicitud_transporte = '$id' ;";
	$this->db->query($q);
		return $this->db->insert_id();
		
	}
}
?>