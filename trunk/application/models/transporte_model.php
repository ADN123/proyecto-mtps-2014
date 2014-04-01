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
					LOWER(CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada)) AS nombre
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
					LOWER(CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada)) AS nombre
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
					LOWER(CONCAT_WS(', ', org_departamento.departamento, org_municipio.municipio)) AS nombre
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
 WHERE estado_solicitud_transporte = 1");
 
 
   	return $query->result();
		
	}
	/////FUNCION QUE RETORNA lAS SOlICITUDES QUE AÚN NO TIENEN UN VEHICUlO O MOTORISTA ASIGNADO
	function solicitudes_por_asignar(){
	  $query=$this->db->query("SELECT id_solicitud_transporte id, date_format(fecha_mision,'%d-%m-%Y') fecha,date_format(hora_entrada,'%r') entrada, date_format(hora_salida,'%r') salida, m.municipio, lugar_destino lugar, mision_encomendada mision, requiere_motorista FROM tcm_solicitud_transporte  t INNER JOIN org_municipio m  ON t.id_municipio=m.id_municipio where (estado_solicitud_transporte=2)");

   	return $query->result();
		
	}
	////////////////////////////////////////////////////////////////////////////////////////
	
/////////FUNCION QUE RETORNA lA lOCAlIZACIÓN, FECHA Y HORARIOS DE UNA SOlICITUD EN ESPECÍFICO/////
	function consultar_fecha_solicitud($id)
	{
		$query=$this->db->query("SELECT om.id_departamento_pais, st.fecha_mision AS fecha, st.hora_salida AS salida, st.hora_entrada AS entrada
FROM tcm_solicitud_transporte AS st
INNER JOIN org_municipio AS om ON ( st.id_municipio = om.id_municipio ) 
WHERE st.id_solicitud_transporte =  '$id';");
		return $query->result();
	}
	///////////////////////////////////////////////////////////////////////////////////////
	
	///////////////////VEHICUlOS DISPONIBlES PARA MISIONES lOCAlES////////////////////////////////
	function vehiculos_disponibles($fecha,$hentrada,$hsalida)
	{
		$query=$this->db->query("select v.id_vehiculo,v.placa,vm.nombre,vmo.modelo,vc.nombre_clase,vcon.condicion from tcm_vehiculo as v
inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
where v.id_vehiculo not in
  (select avm.id_vehiculo from tcm_solicitud_transporte as st
  inner join tcm_asignacion_sol_veh_mot as avm on (st.id_solicitud_transporte=avm.id_solicitud_transporte)
  where st.fecha_mision='$fecha' and (st.hora_salida='$hsalida' or st.hora_entrada='$hentrada'))
  and id_seccion=21
order by v.id_vehiculo asc;");
		return $query->result();
	}
	/////////////////////////////////////////////////////////////////////////////////////
	
	////////////////////VEHICUlOS DISPONIBlES PARA MISIONES FUERA DE SAN SAlVADOR//////////////
	
	function vehiculos_disponibles2($fecha,$hentrada,$hsalida)
	{
		$query=$this->db->query("select v.id_vehiculo,v.placa,vm.nombre,vmo.modelo,vc.nombre_clase,vcon.condicion from tcm_vehiculo as v
inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
where v.id_vehiculo not in
  (select avm.id_vehiculo from tcm_solicitud_transporte as st
  inner join tcm_asignacion_sol_veh_mot as avm on (st.id_solicitud_transporte=avm.id_solicitud_transporte)
  where st.fecha_mision='$fecha' and (st.hora_salida>='$hsalida' and st.hora_entrada<='$hentrada'))
  and id_seccion=21
order by v.id_vehiculo asc;");
		return $query->result();
	}
	
	//////////////////////////////////////////////////////////////////////////////////
	function datos_de_solicitudes($id,$seccion){
		  $query=$this->db->query("
SELECT id_solicitud_transporte id, 
	LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido,e.segundo_apellido,e.apellido_casada)) AS nombre,
	mision_encomendada mision, 
	DATE_FORMAT(fecha_solicitud_transporte, '%d-%m-%Y') fechaS,
	DATE_FORMAT(fecha_mision, '%d-%m-%Y')  fechaM,
	DATE_FORMAT(hora_salida,'%h:%i %p') salida,
	DATE_FORMAT(hora_entrada,'%h:%i %p') entrada,
	LOWER(CONCAT_WS(', ',d.departamento,m.municipio)) municipio,
	lugar_destino lugar,
	nombre_seccion seccion,
	requiere_motorista req,
	acompanante
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
	////////////////////////////////////////////////////////////////////////
	function consultar_motoristas($id)
	{
		$query=$this->db->query("(SELECT t.id_empleado,LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre FROM tcm_vehiculo_motorista t inner join sir_empleado e on (t.id_empleado=e.id_empleado)
where t.id_vehiculo='$id') union (SELECT t.id_empleado,LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre FROM tcm_vehiculo_motorista t
inner join sir_empleado e on (t.id_empleado=e.id_empleado)
inner join tcm_vehiculo v on (t.id_vehiculo=v.id_vehiculo)
where (v.id_seccion=21)
order by e.primer_nombre ASC);");
		return $query->result();
	}
	
	///////////////////////////////////////////////////
	
	function acompanantes_internos($id)
	{
		$query=$this->db->query("SELECT LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido,e.segundo_apellido,e.apellido_casada)) as nombre FROM sir_empleado e inner join tcm_acompanante t on (e.id_empleado=t.id_empleado)
where t.id_solicitud_transporte='$id';");
		
		return $query->result();
	}
	
	function asignar_veh_mot($id_solicitud,$id_empleado,$id_vehiculo,$estado,$fecha,$nr,$id_usuario)
	{
		$query=$this->db->query("insert into tcm_asignacion_sol_veh_mot(id_solicitud_transporte,id_empleado,id_vehiculo) values('$id_solicitud','$id_empleado','$id_vehiculo')");
		
		$query2=$this->db->query("update tcm_solicitud_transporte set estado_solicitud_transporte='$estado', fecha_modificacion='$fecha', id_usuario_modifica='$id_usuario' where id_solicitud_transporte='$id_solicitud'");
		
		return $query;
	}
	
	/////////////////////////////////////////////////
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
					(fecha_solicitud_transporte, id_empleado_solicitante, mision_encomendada, fecha_mision, hora_salida, hora_entrada, id_municipio, lugar_destino, requiere_motorista, acompanante, id_usuario_crea, fecha_creacion, estado_solicitud_transporte) 
					VALUES 
					('$fecha_solicitud_transporte', '$id_empleado_solicitante', '$mision_encomendada', '$fecha_mision', '$hora_salida', '$hora_entrada', '$id_municipio', '$lugar_destino', '$requiere_motorista', '$acompanante', '$id_usuario_crea', '$fecha_creacion', '$estado_solicitud_transporte')";
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
					LOWER(CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada)) AS nombre
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
	LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre,
	e.primer_apellido,e.segundo_apellido,e.apellido_casada)) AS nombre,
	estado_solicitud_transporte estado,
	DATE_FORMAT(hora_salida,'%h:%i %p') salida,
	DATE_FORMAT(hora_entrada,'%h:%i %p') entrada,
	LOWER(CONCAT_WS(', ',d.departamento,m.municipio)) municipio,
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
		$r1=$this->db->query($q);
		
		$q="UPDATE tcm_solicitud_transporte SET
		estado_solicitud_transporte = '4' 
		WHERE	id_solicitud_transporte = '$id' ;";
		$r2=$this->db->query($q);
		
		return ($r1 AND $r2);
	}

function regreso_vehiculo($id, $km, $hora, $gas){
	$q="UPDATE tcm_vehiculo_kilometraje 
	SET
		km_final = '$km' , 
		combustible = '$gas' , 
		hora_entrada = '$hora' , 
		fecha_modificacion = CURDATE()
	WHERE
		id_solicitud_transporte = '$id' ;
		";
		
		$r1=$this->db->query($q);
		
		$q="
		UPDATE tcm_solicitud_transporte SET
		estado_solicitud_transporte = '5'  
		WHERE	id_solicitud_transporte = '$id' ;
		";
		$r2=$this->db->query($q);
		
		return ($r1 AND $r2);		
	}
function infoSolicitud($id){
	$query="
	SELECT  
		LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido,e.segundo_apellido,e.apellido_casada)) AS nombre,
		DATE_FORMAT(hora_salida,'%h:%i %p') salida,
		DATE_FORMAT(hora_entrada,'%h:%i %p') regreso,
		v.modelo,
		v.placa,
		v.id_vehiculo		
	FROM tcm_asignacion_sol_veh_mot asi
		INNER JOIN sir_empleado e ON e.id_empleado= asi.id_empleado
		INNER JOIN tcm_solicitud_transporte s ON s.id_solicitud_transporte = asi.id_solicitud_transporte
		INNER JOIN tcm_vehiculo_datos v ON v.id_vehiculo = asi.id_vehiculo
	WHERE asi.id_solicitud_transporte =".$id;
		$q=$this->db->query($query);
		return $q->result();
	}
	function buscar_solicitudes($id_empleado=NULL,$estado=NULL)
	{
		$sentencia="SELECT
					tcm_solicitud_transporte.id_solicitud_transporte AS id,
					CONCAT_WS(' ',DATE_FORMAT(tcm_solicitud_transporte.fecha_mision, '%d-%m-%Y'),DATE_FORMAT(tcm_solicitud_transporte.hora_salida,'%h:%i %p')) AS fecha,
					tcm_solicitud_transporte.lugar_destino AS lugar,
					tcm_solicitud_transporte.mision_encomendada AS mision,
					tcm_solicitud_transporte.estado_solicitud_transporte AS estado
					FROM
					tcm_solicitud_transporte";
		if($id_empleado!=NULL || $estado!=NULL)
			$sentencia.=" WHERE ";
		if($id_empleado!=NULL) {
			$sentencia.=" tcm_solicitud_transporte.id_empleado_solicitante='".$id_empleado."'";
			if($estado!=NULL)
				$sentencia.=" AND tcm_solicitud_transporte.estado_solicitud_transporte>='".$estado."'";
		}
		else
			if($estado!=NULL)
				$sentencia.=" tcm_solicitud_transporte.estado_solicitud_transporte>='".$estado."'";
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return (array)$query->result_array();
		}
	}
	function eliminar_solicitud($id_solicitud)
	{
		$sentencia="DELETE FROM tcm_solicitud_transporte where id_solicitud_transporte='$id_solicitud'";
		$query=$this->db->query($sentencia);
		return true;
	}
	function consultar_solicitud($id_solicitud)
	{
		$sentencia="SELECT
					tcm_solicitud_transporte.id_solicitud_transporte,
					tcm_solicitud_transporte.id_empleado_solicitante,
					DATE_FORMAT(tcm_solicitud_transporte.fecha_mision, '%d/%m/%Y') AS fecha_mision,
					DATE_FORMAT(tcm_solicitud_transporte.hora_salida,'%h:%i %p') AS hora_salida,
					DATE_FORMAT(tcm_solicitud_transporte.hora_entrada,'%h:%i %p') AS hora_entrada,
					tcm_solicitud_transporte.acompanante,
					tcm_solicitud_transporte.mision_encomendada
					FROM tcm_solicitud_transporte
					WHERE tcm_solicitud_transporte.id_solicitud_transporte='".$id_solicitud."'";
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->row();
		}
		else {
			return array(
				'id_solicitud_transporte' => 0,
				'id_empleado_solicitante' => 0,
				'fecha_mision' => "",
				'hora_salida' => "",
				'hora_entrada' => "",
				'acompanante' => "",
				'id_municipio' => 0,
				'lugar_destino' => "",
				'mision_encomendada' => ""
			);
		}
	}
	function kilometraje($id){
			$query="SELECT v.id_vehiculo, COALESCE(MAX(k.km_inicial), 0) AS KMinicial, COALESCE(MAX(k.km_Final), 0) AS KMFinal
				FROM tcm_vehiculo  v 
				LEFT JOIN tcm_vehiculo_kilometraje  K 
				ON  V.id_vehiculo= K.id_vehiculo 
				GROUP BY v.id_vehiculo HAVING v.id_vehiculo=".$id;
		$q=$this->db->query($query);
		return $q->result();

	}

	function guardar_destinos($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO tcm_destino_mision
					(id_solicitud_transporte, id_municipio, lugar_destino) 
					VALUES 
					('$id_solicitud_transporte', '$id_municipio', '$lugar_destino')";
		$this->db->query($sentencia);
	}
	
	function buscar_solicitudes_seccion($seccion,$estado=NULL)
	{
		$sentencia="SELECT
  					tcm_solicitud_transporte.id_solicitud_transporte AS id,
					CONCAT_WS(' ',DATE_FORMAT(tcm_solicitud_transporte.fecha_mision, '%d-%m-%Y'),DATE_FORMAT(tcm_solicitud_transporte.hora_salida,'%h:%i %p')) AS fecha,
					tcm_solicitud_transporte.lugar_destino AS lugar,
					tcm_solicitud_transporte.mision_encomendada AS mision,
					tcm_solicitud_transporte.estado_solicitud_transporte AS estado
					FROM tcm_solicitud_transporte
					LEFT JOIN sir_empleado_informacion_laboral ON tcm_solicitud_transporte.id_empleado_solicitante  = sir_empleado_informacion_laboral.id_empleado 
					WHERE sir_empleado_informacion_laboral.id_seccion =".$seccion;
		if($estado!=NULL)
			$sentencia.=" AND tcm_solicitud_transporte.estado_solicitud_transporte>='".$estado."'";
    	$query=$this->db->query($sentencia);
		return (array)$query->result_array();
		
	}

}
?>