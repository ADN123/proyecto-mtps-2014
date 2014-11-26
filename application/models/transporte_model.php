<?php

class Transporte_model extends CI_Model {
    //constructor de la clase
    function __construct() {
        //LLamar al constructor del Modelo
        parent::__construct();
    }
	function consultar_seccion_usuario($nr=0)
	{
		
		$sentencia="SELECT id_empleado FROM sir_empleado WHERE nr like '".$nr."'";
		$query=$this->db->query($sentencia);
		
		$datos=(array)$query->row();
				
		$sentencia="SELECT
			sir_empleado_informacion_laboral.id_empleado_informacion_laboral,
			sir_empleado_informacion_laboral.id_empleado,
			sir_empleado_informacion_laboral.id_seccion,
			sir_empleado_informacion_laboral.fecha_inicio
			FROM sir_empleado_informacion_laboral
			WHERE sir_empleado_informacion_laboral.id_empleado=".$datos['id_empleado']."
			GROUP BY sir_empleado_informacion_laboral.id_empleado_informacion_laboral
			HAVING sir_empleado_informacion_laboral.fecha_inicio >= ALL(SELECT
					sir_empleado_informacion_laboral.fecha_inicio
					FROM sir_empleado_informacion_laboral
					WHERE sir_empleado_informacion_laboral.id_empleado=".$datos['id_empleado']."
					GROUP BY sir_empleado_informacion_laboral.id_empleado,sir_empleado_informacion_laboral.fecha_inicio) 
		";
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
	
	////////////////////////////////FUNCION QUE CARGA lOS USUARIOS DE SITCOM//////////////////////
	
	function usuario_sitcom()
	{
		$query=$this->db->query("
			SELECT u.id_usuario, LOWER(u.nombre_completo) AS usuario
			FROM org_usuario u
			INNER JOIN org_usuario_rol AS ur ON (ur.id_usuario=u.id_usuario)
			INNER JOIN org_rol_modulo_permiso AS rmp ON (rmp.id_rol=ur.id_rol)
			INNER JOIN org_modulo AS m ON (m.id_modulo=rmp.id_modulo)
			WHERE m.id_sistema=5
			GROUP BY u.nombre_completo;
		");
		return $query->result();		
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////	
	
	function consultar_empleados($nr=0, $id_solicitud=NULL) 
	{
		$where=" ";
		if($id_solicitud!=NULL){
			$where=" AND sir_empleado.id_empleado NOT IN (
			SELECT a.id_empleado FROM tcm_acompanante a WHERE a.id_solicitud_transporte = ".$id_solicitud.")";

		}

		$sentencia="SELECT
					sir_empleado.id_empleado AS NR,
					LOWER(CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada)) AS nombre
					FROM sir_empleado
					WHERE sir_empleado.NR<>'".$nr."'".$where;
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
	
	function consultar_empl($nr) 
	{
		$sentencia="SELECT id_empleado FROM tcm_empleado where nr like '$nr'";
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return 0;
		}
	}
	
	function consultar_cargo($id)
	{
		$query=$this->db->query("
			select f.funcional, n.cargo_nominal
			from sir_empleado as e
			inner join sir_empleado_informacion_laboral as i on i.id_empleado=e.id_empleado
			inner join sir_cargo_nominal as n on i.id_cargo_nominal=n.id_cargo_nominal
			inner join sir_cargo_funcional as f on i.id_cargo_funcional=f.id_cargo_funcional
			where e.id_empleado='$id'
			");
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
	
	function solicitudes_por_seccion_estado($seccion, $estado,$id){

	  $query=$this->db->query("
		SELECT DISTINCT
		id_solicitud_transporte id,
		DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
		DATE_FORMAT(hora_entrada,'%h:%i %p') entrada,
		DATE_FORMAT(hora_salida,'%h:%i %p') salida,
		LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre,
		st.estado_solicitud_transporte estado,
		s.nombre_seccion seccion, i.id_empleado
		FROM
		sir_empleado_informacion_laboral AS i
		LEFT JOIN org_seccion AS s ON s.id_seccion = i.id_seccion
		LEFT JOIN sir_empleado AS e ON e.id_empleado = i.id_empleado
		INNER JOIN tcm_solicitud_transporte AS st ON st.id_empleado_solicitante = e.id_empleado
		WHERE 
		(i.id_seccion='$seccion' || i.id_seccion in (SELECT distinct(o.id_seccion) FROM org_seccion as o
		inner join tcm_empleado as e on e.id_seccion=o.depende
		where e.id_seccion='$seccion')) and
		e.id_empleado<>'$id' and st.estado_solicitud_transporte = '".$estado."' AND (i.id_empleado, i.fecha_inicio) IN  
		( SELECT id_empleado ,MAX(fecha_inicio)  FROM sir_empleado_informacion_laboral GROUP BY id_empleado  ) 
			");
 
 
   	return $query->result();
		
	}
function todas_solicitudes_por_estado($estado,$id)
{
	  $query=$this->db->query("
		SELECT * FROM
		(
		SELECT id_solicitud_transporte id,
		DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
		DATE_FORMAT(hora_entrada,'%r') entrada,
		DATE_FORMAT(hora_salida,'%r') salida,
		requiere_motorista,
		LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
		LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido, s.apellido_casada)) AS nombre
		FROM tcm_solicitud_transporte  t
		LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
		LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
		LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
		WHERE
			s.id_empleado<>'$id' and
			(estado_solicitud_transporte='".$estado."')
			and (t.id_empleado_solicitante not in
					(select id_empleado from sir_empleado_informacion_laboral))
				
		UNION
				
		SELECT id_solicitud_transporte id,
		DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
		DATE_FORMAT(hora_entrada,'%r') entrada,
		DATE_FORMAT(hora_salida,'%r') salida,
		requiere_motorista,
		LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
		LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada)) AS nombre
		FROM tcm_solicitud_transporte  t
		LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
		LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
		LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
		WHERE
			s.id_empleado<>'$id' and
			(estado_solicitud_transporte='".$estado."')
			and 
			(	i.id_empleado_informacion_laboral in
				(
					SELECT se.id_empleado_informacion_laboral
					FROM sir_empleado_informacion_laboral AS se
					INNER JOIN
					(
						SELECT id_empleado, MAX(fecha_inicio) AS fecha FROM sir_empleado_informacion_laboral
						GROUP BY id_empleado
						HAVING COUNT(id_empleado>=1)
					)
					AS ids
					ON (se.id_empleado=ids.id_empleado AND se.fecha_inicio=ids.fecha)
					ORDER BY se.id_empleado_informacion_laboral
				)
			)
		)
		as k
		GROUP BY k.id 
		ORDER BY k.fecha DESC
	");
 
 
   	return $query->result();
		
}

function todas_solicitudes_sanSalvador($estado,$id)
{
			  $query=$this->db->query("
			  	SELECT * FROM
(
SELECT id_solicitud_transporte id,
DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
DATE_FORMAT(hora_entrada,'%r') entrada,
DATE_FORMAT(hora_salida,'%r') salida,
requiere_motorista,
estado_solicitud_transporte estado,
LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido, s.apellido_casada)) AS nombre
FROM tcm_solicitud_transporte  t
LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
WHERE
	s.id_empleado<>'$id' and
	(estado_solicitud_transporte='".$estado."')
	and (t.id_empleado_solicitante not in
			(select id_empleado from sir_empleado_informacion_laboral))
	and o.id_seccion NOT IN 
			(SELECT id_seccion FROM org_seccion WHERE id_seccion BETWEEN 52 AND 66)
UNION
		
SELECT id_solicitud_transporte id,
DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
DATE_FORMAT(hora_entrada,'%r') entrada,
DATE_FORMAT(hora_salida,'%r') salida,
requiere_motorista,
estado_solicitud_transporte estado,
LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada)) AS nombre
FROM tcm_solicitud_transporte  t
LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
WHERE 
s.id_empleado<>'$id' and
 o.id_seccion NOT IN 
			(SELECT id_seccion FROM org_seccion WHERE id_seccion BETWEEN 52 AND 66)
	and
	(estado_solicitud_transporte='".$estado."')
	and 
	(	i.id_empleado_informacion_laboral in
		(
			SELECT se.id_empleado_informacion_laboral
			FROM sir_empleado_informacion_laboral AS se
			INNER JOIN
			(
				SELECT id_empleado, MAX(fecha_inicio) AS fecha FROM sir_empleado_informacion_laboral
				GROUP BY id_empleado
				HAVING COUNT(id_empleado>=1)
			)
			AS ids
			ON (se.id_empleado=ids.id_empleado AND se.fecha_inicio=ids.fecha)
			ORDER BY se.id_empleado_informacion_laboral
		)
	)
)
as k
GROUP BY k.id 
ORDER BY k.fecha DESC

			  	");
	   	return $query->result();
}




	/////FUNCION QUE RETORNA lAS SOlICITUDES QUE AÚN NO TIENEN UN VEHICUlO O MOTORISTA ASIGNADO NIVEL LOCAL//////////////////////////////
	function solicitudes_por_asignar($seccion){
	  $query=$this->db->query("
		SELECT * FROM
		(
			SELECT id_solicitud_transporte id,
			DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
			DATE_FORMAT(hora_entrada,'%r') entrada,
			DATE_FORMAT(hora_salida,'%r') salida,
			requiere_motorista,
			LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
			LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido, s.apellido_casada)) AS nombre
			FROM tcm_solicitud_transporte  t
			LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
			LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
			LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
			WHERE 
				(estado_solicitud_transporte=2 and o.id_seccion='$seccion')
				and (t.id_empleado_solicitante not in
						(select id_empleado from sir_empleado_informacion_laboral))
					
			UNION
					
			SELECT id_solicitud_transporte id,
			DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
			DATE_FORMAT(hora_entrada,'%r') entrada,
			DATE_FORMAT(hora_salida,'%r') salida,
			requiere_motorista,
			LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
			LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada)) AS nombre
			FROM tcm_solicitud_transporte  t
			LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
			LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
			LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
			WHERE 
				(estado_solicitud_transporte=2 and o.id_seccion='$seccion')
				and 
				(	i.id_empleado_informacion_laboral in
					(
						SELECT se.id_empleado_informacion_laboral
						FROM sir_empleado_informacion_laboral AS se
						INNER JOIN
						(
							SELECT id_empleado, MAX(fecha_inicio) AS fecha FROM sir_empleado_informacion_laboral
							GROUP BY id_empleado
							HAVING COUNT(id_empleado>=1)
						)
						AS ids
						ON (se.id_empleado=ids.id_empleado AND se.fecha_inicio=ids.fecha)
						ORDER BY se.id_empleado_informacion_laboral
					)
				)
		)
		as k
		GROUP BY k.id
		");

	   	return $query->result();
			
	}
	
	/////FUNCION QUE RETORNA lAS SOlICITUDES QUE AÚN NO TIENEN UN VEHICUlO O MOTORISTA ASIGNADO NIVEL ADMINISTRADOR//////////////////////////////
function todas_solicitudes_por_asignar(){
	  $query=$this->db->query("
		SELECT * FROM
		(
			SELECT id_solicitud_transporte id,
			DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
			DATE_FORMAT(hora_entrada,'%r') entrada,
			DATE_FORMAT(hora_salida,'%r') salida,
			requiere_motorista,
			LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
			LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido, s.apellido_casada)) AS nombre
			FROM tcm_solicitud_transporte  t
			LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
			LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
			LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
			WHERE 
				(estado_solicitud_transporte=2)
				and (t.id_empleado_solicitante not in
						(select id_empleado from sir_empleado_informacion_laboral))
					
			UNION
					
			SELECT id_solicitud_transporte id,
			DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
			DATE_FORMAT(hora_entrada,'%r') entrada,
			DATE_FORMAT(hora_salida,'%r') salida,
			requiere_motorista,
			LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
			LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada)) AS nombre
			FROM tcm_solicitud_transporte  t
			LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
			LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
			LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
			WHERE 
				(estado_solicitud_transporte=2)
				and 
				(	i.id_empleado_informacion_laboral in
					(
						SELECT se.id_empleado_informacion_laboral
						FROM sir_empleado_informacion_laboral AS se
						INNER JOIN
						(
							SELECT id_empleado, MAX(fecha_inicio) AS fecha FROM sir_empleado_informacion_laboral
							GROUP BY id_empleado
							HAVING COUNT(id_empleado>=1)
						)
						AS ids
						ON (se.id_empleado=ids.id_empleado AND se.fecha_inicio=ids.fecha)
						ORDER BY se.id_empleado_informacion_laboral
					)
				)
		)
		as k
		GROUP BY k.id
		");

	   	return $query->result();
			
	}
	////////////////////////////////////////////////////////////////////////////////////////
	
	/////FUNCION QUE RETORNA lAS SOlICITUDES QUE AÚN NO TIENEN UN VEHICUlO O MOTORISTA ASIGNADO NIVEL DEPARTAMENTAL/////////////////////////////
function solicitudes_por_asignar_depto(){
	  $query=$this->db->query("
		SELECT * FROM
		(
			SELECT id_solicitud_transporte id,
			DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
			DATE_FORMAT(hora_entrada,'%r') entrada,
			DATE_FORMAT(hora_salida,'%r') salida,
			requiere_motorista,
			LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
			LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido, s.apellido_casada)) AS nombre
			FROM tcm_solicitud_transporte  t
			LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
			LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
			LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
			WHERE 
				(estado_solicitud_transporte=2 and (o.id_seccion!=52 and o.id_seccion!=53 and o.id_seccion!=54 and o.id_seccion!=55 and o.id_seccion!=56 and o.id_seccion!=57 and o.id_seccion!=58 and o.id_seccion!=59 and o.id_seccion!=60 and o.id_seccion!=61 and o.id_seccion!=64 and o.id_seccion!=65 and o.id_seccion!=66))
				and (t.id_empleado_solicitante not in
						(select id_empleado from sir_empleado_informacion_laboral))
					
			UNION
					
			SELECT id_solicitud_transporte id,
			DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
			DATE_FORMAT(hora_entrada,'%r') entrada,
			DATE_FORMAT(hora_salida,'%r') salida,
			requiere_motorista,
			LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
			LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada)) AS nombre
			FROM tcm_solicitud_transporte  t
			LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
			LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
			LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
			WHERE 
				(estado_solicitud_transporte=2 and (o.id_seccion!=52 and o.id_seccion!=53 and o.id_seccion!=54 and o.id_seccion!=55 and o.id_seccion!=56 and o.id_seccion!=57 and o.id_seccion!=58 and o.id_seccion!=59 and o.id_seccion!=60 and o.id_seccion!=61 and o.id_seccion!=64 and o.id_seccion!=65 and o.id_seccion!=66))
				and 
				(	i.id_empleado_informacion_laboral in
					(
						SELECT se.id_empleado_informacion_laboral
						FROM sir_empleado_informacion_laboral AS se
						INNER JOIN
						(
							SELECT id_empleado, MAX(fecha_inicio) AS fecha FROM sir_empleado_informacion_laboral
							GROUP BY id_empleado
							HAVING COUNT(id_empleado>=1)
						)
						AS ids
						ON (se.id_empleado=ids.id_empleado AND se.fecha_inicio=ids.fecha)
						ORDER BY se.id_empleado_informacion_laboral
					)
				)
		)
		as k
		GROUP BY k.id
		");

	   	return $query->result();
			
	}
	////////////////////////////////////////////////////////////////////////////////////////
	
/////////FUNCION QUE RETORNA FECHA Y HORARIOS DE UNA SOlICITUD EN ESPECÍFICO/////
	function consultar_fecha_solicitud($id)
	{
		$query=$this->db->query("
		SELECT st.fecha_mision AS fecha, st.hora_salida AS salida, st.hora_entrada AS entrada
		FROM tcm_solicitud_transporte AS st
		WHERE st.id_solicitud_transporte =  '$id';
		");
		return $query->result();
	}
	///////////////////////////////////////////////////////////////////////////////////////
	
	//////VEHICUlOS DISPONIBlES INClUYE lOS QUE ESTÁN EN MISIONES lOCAlES VERSIÓN OFICINAS ///////////
	function vehiculos_disponibles($fecha,$hentrada,$hsalida,$seccion)
	{
		$query=$this->db->query("
			select v.id_vehiculo, v.placa, vm.nombre, vmo.modelo, vc.nombre_clase, vcon.condicion
			from tcm_vehiculo as v
			inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
			inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
			inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
			inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
			where v.id_vehiculo not in
			(
				select avm.id_vehiculo
				from tcm_solicitud_transporte as st
				inner join tcm_destino_mision as dm
				on (dm.id_solicitud_transporte=st.id_solicitud_transporte)
				inner join tcm_asignacion_sol_veh_mot as avm
				on (avm.id_solicitud_transporte=st.id_solicitud_transporte)
				where avm.id_vehiculo in
				(
					select avm.id_vehiculo
					from tcm_solicitud_transporte as st
					inner join tcm_asignacion_sol_veh_mot as avm
					on (st.id_solicitud_transporte=avm.id_solicitud_transporte)
					where st.fecha_mision='$fecha' and 
					(
						(st.hora_salida>='$hsalida' and st.hora_salida<='$hentrada')
						 or (st.hora_entrada>='$hsalida' and st.hora_entrada<='$hentrada')
						 or (st.hora_salida<='$hsalida' and st.hora_entrada>='$hentrada')
					 )
					 and st.estado_solicitud_transporte=3
				)
				and st.estado_solicitud_transporte=3
			)
			and (id_seccion='$seccion') and v.estado=1
			order by v.id_vehiculo asc;");
				return $query->result();
	}
	/////////////////////////////////////////////////////////////////////////////////////
	
	//////VEHICUlOS DISPONIBlES INClUYE lOS QUE ESTÁN EN MISIONES lOCAlES VERSION CENTRAL ///////////
	function vehiculos_disponibles_central($fecha,$hentrada,$hsalida)
	{
		$query=$this->db->query("
			select v.id_vehiculo, v.placa, vm.nombre, vmo.modelo, vc.nombre_clase, vcon.condicion
			from tcm_vehiculo as v
			inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
			inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
			inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
			inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
			where v.id_vehiculo not in
			(
				select avm.id_vehiculo
				from tcm_solicitud_transporte as st
				inner join tcm_destino_mision as dm
				on (dm.id_solicitud_transporte=st.id_solicitud_transporte)
				inner join tcm_asignacion_sol_veh_mot as avm
				on (avm.id_solicitud_transporte=st.id_solicitud_transporte)
				where avm.id_vehiculo in
				(
					select avm.id_vehiculo
					from tcm_solicitud_transporte as st
					inner join tcm_asignacion_sol_veh_mot as avm
					on (st.id_solicitud_transporte=avm.id_solicitud_transporte)
					where st.fecha_mision='$fecha' and 
					(
						(st.hora_salida>='$hsalida' and st.hora_salida<='$hentrada')
						 or (st.hora_entrada>='$hsalida' and st.hora_entrada<='$hentrada')
						 or (st.hora_salida<='$hsalida' and st.hora_entrada>='$hentrada')
					 )
					 and st.estado_solicitud_transporte=3
				)
				and st.estado_solicitud_transporte=3
				and dm.id_municipio<>97
			)
			and (v.id_seccion!=52 and v.id_seccion!=53 and v.id_seccion!=54 and v.id_seccion!=55 and v.id_seccion!=56 and v.id_seccion!=57 and v.id_seccion!=58 and v.id_seccion!=59 and v.id_seccion!=60 and v.id_seccion!=61 and v.id_seccion!=64 and v.id_seccion!=65 and v.id_seccion!=66)
			and v.estado=1
			order by v.id_vehiculo asc;");
				return $query->result();
	}
	/////////////////////////////////////////////////////////////////////////////////////
	
	//////VEHICUlOS DISPONIBlES INClUYE lOS QUE ESTÁN EN MISIONES lOCAlES VERSION ADMIN ///////////
	function vehiculos_disponibles_nacional($fecha,$hentrada,$hsalida)
	{
		$query=$this->db->query("
			select v.id_vehiculo, v.placa, vm.nombre, vmo.modelo, vc.nombre_clase, vcon.condicion
			from tcm_vehiculo as v
			inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
			inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
			inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
			inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
			where v.id_vehiculo not in
			(
				select avm.id_vehiculo
				from tcm_solicitud_transporte as st
				inner join tcm_destino_mision as dm
				on (dm.id_solicitud_transporte=st.id_solicitud_transporte)
				inner join tcm_asignacion_sol_veh_mot as avm
				on (avm.id_solicitud_transporte=st.id_solicitud_transporte)
				where avm.id_vehiculo in
				(
					select avm.id_vehiculo
					from tcm_solicitud_transporte as st
					inner join tcm_asignacion_sol_veh_mot as avm
					on (st.id_solicitud_transporte=avm.id_solicitud_transporte)
					where st.fecha_mision='$fecha' and 
					(
						(st.hora_salida>='$hsalida' and st.hora_salida<='$hentrada')
						 or (st.hora_entrada>='$hsalida' and st.hora_entrada<='$hentrada')
						 or (st.hora_salida<='$hsalida' and st.hora_entrada>='$hentrada')
					 )
					 and st.estado_solicitud_transporte=3
				)
				and st.estado_solicitud_transporte=3
				and dm.id_municipio<>97
			)
			and v.estado=1
			order by v.id_vehiculo asc;");
				return $query->result();
	}
	/////////////////////////////////////////////////////////////////////////////////////
	
	//////////////////////VEHICUlOS EN MISION lOCAl/////////////////////////////////
	
	function vehiculo_en_mision_local($fecha,$hsalida,$hentrada,$id_veh)
	{
		$query=$this->db->query("
		select avm.id_vehiculo
		from tcm_solicitud_transporte as st
		inner join tcm_asignacion_sol_veh_mot as avm
		on (st.id_solicitud_transporte=avm.id_solicitud_transporte)
		where st.fecha_mision='$fecha' and 
		(
			(st.hora_salida>='$hsalida' and st.hora_salida<='$hentrada')
			 or (st.hora_entrada>='$hsalida' and st.hora_entrada<='$hentrada')
			 or (st.hora_salida<='$hsalida' and st.hora_entrada>='$hentrada')
		)
		and st.estado_solicitud_transporte=3
		and avm.id_vehiculo='$id_veh'
		");
		
		if($query->num_rows>0)
		{
			return $query->result();
		}
		else
		{
			return 0;
		}
	}
	
	///////////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////////Informacion del cuadro de dialogo de aprobacion de solicitudes////////////////////////////////////////////////
	function datos_de_solicitudes($id,$seccion){
		/*
		*	Cambie este query porque el id_seccion 
		*	que esta recibiendo esta funcion es el 
		*	del usuario logueado, no el del solicitante,
		*	por eso no mostraba la seccion real a la que pertenece
		*	el empleado solicitante
		*/

		$query=$this->db->query("SELECT id_solicitud_transporte id, 
								LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido,e.segundo_apellido,e.apellido_casada)) AS nombre,
								DATE_FORMAT(fecha_solicitud_transporte, '%d-%m-%Y') fechaS,
								DATE_FORMAT(fecha_mision, '%d-%m-%Y')  fechaM,
								DATE_FORMAT(hora_salida,'%h:%i %p') salida,
								DATE_FORMAT(hora_entrada,'%h:%i %p') entrada,
								LOWER(COALESCE(nombre_seccion, 'No hay registro')) seccion,
								requiere_motorista req,
								acompanante,
								id_empleado_solicitante
								FROM tcm_solicitud_transporte  s 
								INNER JOIN sir_empleado e ON id_empleado_solicitante = id_empleado
								LEFT JOIN sir_empleado_informacion_laboral i ON e.id_empleado = i.id_empleado
								LEFT JOIN org_seccion sec ON i.id_seccion = sec.id_seccion
								WHERE id_solicitud_transporte=".$id);
		return $query->result();
	}	
	function aprobar($id, $estado, $nr, $iduse){
		$q="UPDATE tcm_solicitud_transporte SET 
				id_empleado_autoriza= (SELECT id_empleado FROM sir_empleado WHERE NR LIKE '".$nr."'),
				estado_solicitud_transporte = $estado,
				id_usuario_modifica = '".$iduse."', 
				fecha_modificacion=  CONCAT_WS(' ', CURDATE(),CURTIME()),  
				fecha_aprobacion=  CONCAT_WS(' ', CURDATE(),CURTIME())  
			WHERE id_solicitud_transporte= ".$id;
	
		  $query=$this->db->query($q);
	
		return $query;
	}	
	
	
	/////////////////////////////////CONSUlTAR VEHICUlOS//////////////////////////////////////////
	function consultar_vehiculos($estado=NULL)
	{
		if($estado==NULL)
		{
			$consulta="
			select v.id_vehiculo id, v.placa, vm.nombre as marca, vmo.modelo, vc.nombre_clase clase, vcon.condicion
			from tcm_vehiculo as v
			inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
			inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
			inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
			inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
			";
		}
		else
		{
			$consulta="
			select v.id_vehiculo id, v.placa, vm.nombre as marca, vmo.modelo, vc.nombre_clase clase, vcon.condicion
			from tcm_vehiculo as v
			inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
			inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
			inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
			inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
			where v.estado='$estado'
			";
		}
		$query=$this->db->query($consulta);
		return $query->result();
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
		
	//////////////////////////////CONSUlTAR MARCAS//////////////////////////////
	function consultar_marcas()
	{
		$query=$this->db->query("select id_vehiculo_marca, lower(nombre) as nombre  from tcm_vehiculo_marca");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////REGISTRAR MARCAS//////////////////////////////
	function nueva_marca($marca)
	{
		$query=$this->db->query("insert into tcm_vehiculo_marca(nombre) values('$marca')");
		$query2=$this->db->query("select max(id_vehiculo_marca) as id from tcm_vehiculo_marca");
		
		$vm=$query2->result();
		foreach($vm as $v)
		{
			$id=$v->id;
		}
		return $id;
	}
	////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////CONSUlTAR MODElOS//////////////////////////////
	function consultar_modelos()
	{
		$query=$this->db->query("select id_vehiculo_modelo, lower(modelo) as modelo from tcm_vehiculo_modelo");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////REGISTRAR MODELOS//////////////////////////////
	function nuevo_modelo($modelo)
	{
		$query=$this->db->query("insert into tcm_vehiculo_modelo(modelo) values('$modelo')");
		$query2=$this->db->query("select max(id_vehiculo_modelo) as id from tcm_vehiculo_modelo");
		
		$vm=$query2->result();
		foreach($vm as $v)
		{
			$id=$v->id;
		}
		return $id;
	}
	////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////CONSUlTAR ClASES//////////////////////////////
	function consultar_clases()
	{
		$query=$this->db->query("select id_vehiculo_clase, lower(nombre_clase) as nombre_clase from tcm_vehiculo_clase");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////REGISTRAR CLASES//////////////////////////////
	function nueva_clase($clase)
	{
		$query=$this->db->query("insert into tcm_vehiculo_clase(nombre_clase) values('$clase')");
		$query2=$this->db->query("select max(id_vehiculo_clase) as id from tcm_vehiculo_clase");
		
		$vm=$query2->result();
		foreach($vm as $v)
		{
			$id=$v->id;
		}
		return $id;
	}
	////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////CONSUlTAR CONDICIONES//////////////////////////////
	function consultar_condiciones()
	{
		$query=$this->db->query("select id_vehiculo_condicion, lower(condicion) as condicion from tcm_vehiculo_condicion");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////CONSULTAR SECCIONES//////////////////////////////
	function consultar_secciones()
	{
		$query=$this->db->query("select id_seccion, lower(nombre_seccion) as seccion from org_seccion");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////
	
	/////////////////CONSULTAR LAS FUENTES DE FONDO DE LOS VEHÍCULOS//////////////////
	
	function consultar_fuente_fondo()
	{
		$query=$this->db->query("select id_fuente_fondo,nombre_fuente_fondo as fuente from tcm_fuente_fondo");
		return $query->result();
	}
	
	//////////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////REGISTRAR FUENTES DE FONDO//////////////////////////////
	function nueva_fuente($fuente)
	{
		$query=$this->db->query("insert into tcm_fuente_fondo(nombre_fuente_fondo) values('$fuente')");
		$query2=$this->db->query("select max(id_fuente_fondo) as id from tcm_fuente_fondo");
		
		$vm=$query2->result();
		foreach($vm as $v)
		{
			$id=$v->id;
		}
		return $id;
	}
	////////////////////////////////////////////////////////////////////////////
	
	function consultar_vehiculo_taller($id, $estado=NULL)
	{
		if($estado==NULL)
		{
			$query=$this->db->query("
			select v.placa, IF(vmot.id_empleado=0,'No tiene asignado',LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada))) AS motorista,
			o.nombre_seccion as seccion, vm.nombre as marca, vmo.modelo, vc.nombre_clase clase, vcon.condicion, COALESCE(max(vk.km_final),'0') as kilometraje, v.anio, v.estado,
			ff.nombre_fuente_fondo as fuente_fondo,v.imagen, v.id_seccion, v.id_clase, v.id_condicion, v.id_fuente_fondo, v.id_marca, v.id_modelo, v.id_vehiculo, vmot.id_empleado,
			v.tipo_combustible
			from tcm_vehiculo as v
			inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
			inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
			inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
			inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
			left join tcm_vehiculo_motorista as vmot on (v.id_vehiculo=vmot.id_vehiculo)
			left join tcm_vehiculo_kilometraje as vk on (vk.id_vehiculo=v.id_vehiculo)
			left join sir_empleado as s on (vmot.id_empleado=s.id_empleado)
			inner join org_seccion as o on (v.id_seccion=o.id_seccion)
			inner join tcm_fuente_fondo as ff on (ff.id_fuente_fondo=v.id_fuente_fondo)
			where v.id_vehiculo='$id'
			GROUP BY v.placa,motorista,seccion,marca,modelo,clase,condicion
			");
		}
		else
		{
			$query=$this->db->query("
			select v.placa, IF(vmot.id_empleado=0,'No tiene asignado',LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada))) AS motorista,
			o.nombre_seccion as seccion, vm.nombre as marca, vmo.modelo, vc.nombre_clase clase, vcon.condicion, COALESCE(max(vk.km_final),'0') as kilometraje, v.anio, v.estado,
			ff.nombre_fuente_fondo as fuente_fondo,v.imagen, v.id_seccion, v.id_clase, v.id_condicion, v.id_fuente_fondo, v.id_marca, v.id_modelo, v.id_vehiculo, vmot.id_empleado,
			v.tipo_combustible
			from tcm_vehiculo as v
			inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
			inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
			inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
			inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
			left join tcm_vehiculo_motorista as vmot on (v.id_vehiculo=vmot.id_vehiculo)
			left join tcm_vehiculo_kilometraje as vk on (vk.id_vehiculo=v.id_vehiculo)
			left join sir_empleado as s on (vmot.id_empleado=s.id_empleado)
			inner join org_seccion as o on (v.id_seccion=o.id_seccion)
			inner join tcm_fuente_fondo as ff on (ff.id_fuente_fondo=v.id_fuente_fondo)
			where v.id_vehiculo='$id' and v.estado='$estado'
			GROUP BY v.placa,motorista,seccion,marca,modelo,clase,condicion
			");
		}
		return $query->result();
	}
	//////////////////////Consultar los datos de los vehículos//////////////////
	function consultar_datos_vehiculos($id)
	{
		$query=$this->db->query("
		select v.placa, IF(vmot.id_empleado=0,'No tiene asignado',LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada))) AS motorista,
		o.nombre_seccion as seccion, vm.nombre as marca, vmo.modelo, vc.nombre_clase clase, vcon.condicion, COALESCE(max(vk.km_final),'0') as kilometraje, v.anio, v.estado,
		ff.nombre_fuente_fondo as fuente_fondo,v.imagen, v.id_seccion, v.id_clase, v.id_condicion, v.id_fuente_fondo, v.id_marca, v.id_modelo, v.id_vehiculo, vmot.id_empleado
		from tcm_vehiculo as v
		inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
		inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
		inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
		inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
		left join tcm_vehiculo_motorista as vmot on (v.id_vehiculo=vmot.id_vehiculo)
		left join tcm_vehiculo_kilometraje as vk on (vk.id_vehiculo=v.id_vehiculo)
		left join sir_empleado as s on (vmot.id_empleado=s.id_empleado)
		inner join org_seccion as o on (v.id_seccion=o.id_seccion)
		inner join tcm_fuente_fondo as ff on (ff.id_fuente_fondo=v.id_fuente_fondo)
		where v.id_vehiculo='$id' and v.estado=1;
		GROUP BY v.placa,motorista,seccion,marca,modelo,clase,condicion
		");
		return $query->result();
	}
	
	//////////////////////////FUNCIÓN PARA REGISTRAR UN NUEVO VEHÍCULO/////////////////////////////
	
	function registrar_vehiculo($nplaca,$marca,$modelo,$clase,$year,$condicion,$tcombustible,$seccion,$motorista,$fuente_fondo,$foto)
	{
		$query="INSERT INTO tcm_vehiculo(placa,id_seccion,id_marca,id_modelo,id_clase,id_condicion,anio,imagen,id_fuente_fondo,estado,cantidad_combustible,id_seccion_vale,tipo_combustible)
				values('$nplaca','$seccion','$marca','$modelo','$clase','$condicion','$year','$foto','$fuente_fondo',1,50,'$seccion','$tcombustible')";
		$this->db->query($query);
		
		$q=$this->db->query("select max(id_vehiculo) as id from tcm_vehiculo");
		$vehiculo=$q->result();
		
		foreach($vehiculo as $v)
		{
			$id_vehiculo=$v->id;
		}
		
		$query2="INSERT INTO tcm_vehiculo_motorista(id_empleado,id_vehiculo) values('$motorista','$id_vehiculo')";
		$this->db->query($query2);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function modificar_vehiculo($nplaca,$marca,$modelo,$clase,$year,$condicion,$tcombustible,$seccion,$motorista,$fuente_fondo,$foto,$id_vehiculo,$estado)
	{
		$query="UPDATE tcm_vehiculo SET placa='$nplaca', id_seccion='$seccion', id_marca='$marca', id_modelo='$modelo', id_clase='$clase', id_condicion='$condicion', anio='$year', imagen='$foto', id_fuente_fondo='$fuente_fondo', estado='$estado', tipo_combustible='$tcombustible' WHERE (id_vehiculo='$id_vehiculo');";
		$this->db->query($query);
				
		$query2="update tcm_vehiculo_motorista set id_empleado='$motorista' where id_vehiculo='$id_vehiculo'";
		$this->db->query($query2);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////
	
	function guardar_taller($datos)
	{
		extract($datos);
		$consulta="INSERT INTO tcm_mantenimiento_interno (id_vehiculo, aceite, frenos, bateria, electricidad, 
					amortiguadores, llantas, motor, otro_mtto, naceite, presion, agua, rllantas, caja_velocidades, 
					clutch, r_motor, lavado, observaciones, fecha, id_usuario) 
					VALUES ('$placa', '$aceite', '$frenos', '$bateria', '$electricidad',
					'$amortiguadores', '$llantas', '$motor', '$otro_mtto', '$naceite', '$presion',
					'$agua', '$rllantas', '$caja_velocidades', '$clutch', '$r_motor', '$lavado', '$observaciones',
					CURDATE(), '$id_usuario');";
		$this->db->query($consulta);
	}
	/////////////////////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////////////////////////////////////////////////////////////////////
	
	function guardar_mtto($datos)
	{
		extract($datos);
		$fecha_recepcion=date('Y-m-d');
		$fecha_modificacion=('Y-m-d H:i:s');
		$consulta="INSERT INTO tcm_ingreso_taller (fecha_recepcion,
					llanta_repo, mica, triangulo, herramientas, extintor, encendedor, t_circulacion, radio,
					alfombras, nalfombras, retrovisor, respaldo, tapon, retrovisor_izq, retrovisor_der, logos, 
					emblemas, cricos_escobillas, copas, ncopas, vidrios, nvidrios, parabrisas_delantero, 
					parabrisas_trasero, antena, id_vehiculo, trabajo_solicitado, trabajo_solicitado_carroceria, 
					id_empleado, id_usuario_crea, id_usuario_modifica, fecha_modificacion)
					VALUES ('$fecha_recepcion',	'$llanta_repo', '$mica', '$triangulo', '$herramientas', '$extintor',
					'$encendedor', '$t_circulacion', '$radio', '$alfombras', '$nalfombras', '$retrovisor', '$respaldo',
					'$tapon', '$retrovisor_izq', '$retrovisor_der', '$logos', '$emblemas', '$cricos_escobillas', '$copas',
					'$ncopas', '$vidrios', '$nvidrios', '$parabrisas_delantero', '$parabrisas_trasero', '$antena',
					'$placa', '$trabajo_solicitado', '$trabajo_solicitado_carroceria', '$id_empleado',
					'$id_usuario', '$id_usuario', CONCAT_WS(' ',CURDATE(),CURTIME()));";
		if($this->db->query($consulta))
		{
			$consulta2="UPDATE tcm_vehiculo SET estado='2' WHERE (id_vehiculo='$placa');";
			return $this->db->query($consulta2);
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////
	
	function filtro_vehiculo($datos)
	{
		extract($datos);
		
		$where='';
		$select='';
		
		/*///////////////declaración de los where, por defecto vacios//////////*/
		$where_placa='';
		$where_marca='';
		$where_modelo='';
		$where_clase='';
		$where_condicion='';
		$where_anio='';
		$where_fuente_fondo='';
		$where_estado='';
		$where_tipo_combustible='';
		$where_seccion='';
		
		
		/*/////////////////////verificación de los select y los where para generar la consulta///////////*/
		if($marca!='') $where_marca = " vm.id_vehiculo_marca = '".$marca."' ";
		else $select = $select.', vm.nombre as marca';
		
		if($modelo!='') $where_modelo = " vmo.id_vehiculo_modelo = '".$modelo."' ";
		else $select = $select.', vmo.modelo';
		
		if($clase!='') $where_clase = " vc.id_vehiculo_clase = '".$clase."' ";
		else $select = $select.', vc.nombre_clase as clase';
		
		if($condicion!='') $where_condicion = " vcon.id_vehiculo_condicion = '".$condicion."' ";
		else $select = $select.', vcon.condicion';
		
		if($condicion!='') $where_condicion = " vcon.id_vehiculo_condicion = '".$condicion."' ";
		else $select = $select.', vcon.condicion';
		
		if($condicion!='') $where_condicion = " vcon.id_vehiculo_condicion = '".$condicion."' ";
		else $select = $select.', vcon.condicion';
		
		if($condicion!='') $where_condicion = " vcon.id_vehiculo_condicion = '".$condicion."' ";
		else $select = $select.', vcon.condicion';
		
		if($condicion!='') $where_condicion = " vcon.id_vehiculo_condicion = '".$condicion."' ";
		else $select = $select.', vcon.condicion';
		
		if($condicion!='') $where_condicion = " vcon.id_vehiculo_condicion = '".$condicion."' ";
		else $select = $select.', vcon.condicion';
		
		if($condicion!='') $where_condicion = " vcon.id_vehiculo_condicion = '".$condicion."' ";
		else $select = $select.', vcon.condicion';
		
		/*/////////////concatenación de los where/////////////*/
		$cont=0;
		if($where_marca=='' && $where_modelo=='' && $where_clase=='' && $where_condicion=='') $where='';
		else
		{
			$where='where (';
			
			if($where_marca!='')
			{
				$where=$where.$where_marca;
				$cont++;
			}
			if($where_modelo!='')
			{
				if($cont==0)
				{
					$where=$where.$where_modelo;
					$cont++;
				}
				else $where=$where.' and '.$where_modelo;
			}
			if($where_clase!='')
			{
				if($cont==0)
				{
					$where=$where.$where_clase;
					$cont++;
				}
				else $where=$where.' and '.$where_clase;
			}
			if($where_condicion!='')
			{
				if($cont==0)
				{
					$where=$where.$where_condicion;
					$cont++;
				}
				else $where=$where.' and '.$where_condicion;
			}
			
			$where=$where.' )';
		}
		
		/*////////////////////concatenación de la consulta////////////////*/
		$consulta="select v.placa ".$select
			." from tcm_vehiculo as v
			inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
			inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
			inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
			inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion) ".$where.";";

		$query=$this->db->query($consulta);
		return $query->result_array();
		/*if($query->num_rows()>0) {
			return (array)$query->result_array();
		}
		else {
			return 0;
		}*/
	}
	
	///////////////////////////////FUNCIÓN QUE FIlTRA lOS INFORMES DE SOlICITUDES/////////////////////
	
	function filtro_informes($id_solicitante,$id_user,$seccion,$estado,$id_mot,$placa,$f1,$f2,$h1,$h2)
	{
		$select="";
		$where="";
		
		if($id_solicitante==0)
		{
			$select=$select.", e.";
		}
		
		$query="
		select sol.id_solicitud_transporte ".$select."
		from tcm_solicitud_transporte as sol
		inner join tcm_asignacion_sol_veh_mot as asv on (sol.id_solicitud_transporte=asv.id_solicitud_transporte)
		inner join tcm_empleado as e on (e.id_empleado=sol.id_empleado_solicitante)
		inner join org_usuario
		";
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////

	///////////////////////////FUNCIÓN PARA VALIDAR LA FECHA Y LA HORA DE UNA SOLICITUD//////////
	
	function validar_fecha_hora()
	{
		$query=$this->db->query("select st.id_solicitud_transporte,st.fecha_mision, st.hora_salida, st.hora_entrada, avm.id_vehiculo from tcm_solicitud_transporte as st
inner join tcm_asignacion_sol_veh_mot as avm on (st.id_solicitud_transporte=avm.id_solicitud_transporte)");
		return $query->result();
	}
	//////////////////////////////////////////////////////////////////////////////////////////////
	
	///////////////CONSULTAR MOTORISTAS: CARGA LOS MOTORISTAS CORRESPONDIENTES A LOS VEHICULOS VERSION OFICINAS/////////////////////////////////
	function consultar_motoristas($id,$seccion)
	{
		$query=$this->db->query("(SELECT t.id_empleado, IF(t.id_empleado!=0,LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)),'No tiene asignado') as nombre FROM tcm_vehiculo_motorista t left join sir_empleado e on (t.id_empleado=e.id_empleado)
where t.id_vehiculo='$id') union (SELECT t.id_empleado,LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre FROM tcm_vehiculo_motorista t
inner join sir_empleado e on (t.id_empleado=e.id_empleado)
inner join tcm_vehiculo v on (t.id_vehiculo=v.id_vehiculo)
where (v.id_seccion='$seccion')
order by e.primer_nombre ASC);");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	///////////////CONSULTAR MOTORISTAS: CARGA LOS MOTORISTAS CORRESPONDIENTES A LOS VEHICULOS VERSION CENTRAL/////////////////////////////////
	function consultar_motoristas_central($id,$seccion=NULL)
	{
		$query=$this->db->query("(SELECT t.id_empleado, IF(t.id_empleado!=0,LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)),'No tiene asignado') as nombre FROM tcm_vehiculo_motorista t left join sir_empleado e on (t.id_empleado=e.id_empleado)
where t.id_vehiculo='$id') union (SELECT t.id_empleado,LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre FROM tcm_vehiculo_motorista t
inner join sir_empleado e on (t.id_empleado=e.id_empleado)
inner join tcm_vehiculo v on (t.id_vehiculo=v.id_vehiculo)
where (v.id_seccion!=52 and v.id_seccion!=53 and v.id_seccion!=54 and v.id_seccion!=55 and v.id_seccion!=56 and v.id_seccion!=57 and v.id_seccion!=58 and v.id_seccion!=59 and v.id_seccion!=60 and v.id_seccion!=61 and v.id_seccion!=64 and v.id_seccion!=65 and v.id_seccion!=66)
order by e.primer_nombre ASC);");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	///////////////CONSULTAR MOTORISTAS: CARGA LOS MOTORISTAS CORRESPONDIENTES A LOS VEHICULOS VERSION ADMIN/////////////////////////////////
	function consultar_motoristas_nacional($id)
	{
		$query=$this->db->query("(SELECT t.id_empleado, IF(t.id_empleado!=0,LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)),'No tiene asignado') as nombre FROM tcm_vehiculo_motorista t left join sir_empleado e on (t.id_empleado=e.id_empleado)
where t.id_vehiculo='$id') union (SELECT t.id_empleado,LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre FROM tcm_vehiculo_motorista t
inner join sir_empleado e on (t.id_empleado=e.id_empleado)
inner join tcm_vehiculo v on (t.id_vehiculo=v.id_vehiculo)
order by e.primer_nombre ASC);");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	////////////CONSULTAR MOTORISTAS 2: CARGA LOS EMPLEADOS CUYO CARGO NOMINAL O FUNCIONAL ES MOTORISTA////////////
	
	function consultar_motoristas2()
	{
		$query=$this->db->query("select
		s.id_empleado,
		LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada)) AS nombre
		from sir_empleado as s
		inner join sir_empleado_informacion_laboral as i on (i.id_empleado=s.id_empleado)
		inner join sir_cargo_funcional as c on (c.id_cargo_funcional=i.id_cargo_funcional)
		inner join sir_cargo_nominal as n on (n.id_cargo_nominal=i.id_cargo_nominal)
		where
			(i.id_cargo_funcional=241 || i.id_cargo_nominal=101 || i.id_cargo_nominal=102 || i.id_cargo_nominal=103)
			and i.id_empleado_informacion_laboral in
			(SELECT max(id_empleado_informacion_laboral) as id
				FROM sir_empleado_informacion_laboral
				group by id_empleado
				having count(id_empleado)>=1)");
		return $query->result();
	}
	
	///////////////////////////////////////////////////
	
	function acompanantes_internos($id)
	{
		$query=$this->db->query("SELECT t.id_empleado AS id_empleado, e.nr, LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido,e.segundo_apellido,e.apellido_casada)) as nombre FROM sir_empleado e inner join tcm_acompanante t on (e.id_empleado=t.id_empleado)
where t.id_solicitud_transporte='$id';");
		
		return $query->result();
	}
	
	/////////////////FUNCIÓN PARA INSERTAR UN REGISTRO DE ASIGNACIÓN DE VEHICULO Y MOTORISTA/////////////////////////////
	function asignar_veh_mot($id_solicitud,$id_empleado,$id_vehiculo,$estado,$fecha,$nr,$id_usuario)
	{
		$query=$this->db->query("insert into tcm_asignacion_sol_veh_mot(id_solicitud_transporte,id_empleado,id_vehiculo,id_empleado_asigna,fecha_hora_asignacion) values('$id_solicitud','$id_empleado','$id_vehiculo','$id_usuario','$fecha')");
		
		$query2=$this->db->query("update tcm_solicitud_transporte set estado_solicitud_transporte='$estado', fecha_modificacion='$fecha', id_usuario_modifica='$id_usuario' where id_solicitud_transporte='$id_solicitud'");
		
		return $query;
	}
	
	//////////////////FUNCIÓN PARA REGISTRAR UNA DENEGACIÓN DE ASIGNACIÓN DE VEHICULO Y MOTORISTA//////////////////////
	function nasignar_veh_mot($id_solicitud,$estado,$fecha,$id_usuario)
	{
		$query=$this->db->query("update tcm_solicitud_transporte set estado_solicitud_transporte='$estado', fecha_modificacion='$fecha', id_usuario_modifica='$id_usuario' where id_solicitud_transporte='$id_solicitud'");
		
		return $query;
	}
	////////////////////////////FUNCION DE DESTINOS/////////////////
	function destinos($id)
	{
		$query=$this->db->query("select LOWER(m.municipio) AS municipio, d.lugar_destino destino, d.mision_encomendada mision,direccion_destino as direccion from tcm_destino_mision as d
inner join org_municipio as m on (d.id_municipio=m.id_municipio)
inner join tcm_solicitud_transporte as s on (d.id_solicitud_transporte=s.id_solicitud_transporte)
where s.id_solicitud_transporte='$id'");
		
		return $query->result();
	}
	///////////////////////////////////////////////////////////////
	
	/////////////////////////////////////////////////
	function info_adicional($id_empleado=0)
	{
				
		/*$sentencia="SELECT
			sir_empleado_informacion_laboral.id_empleado_informacion_laboral,
			sir_empleado_informacion_laboral.id_empleado,
			sir_empleado_informacion_laboral.id_seccion,
			sir_empleado_informacion_laboral.fecha_inicio
			FROM sir_empleado_informacion_laboral
			WHERE sir_empleado_informacion_laboral.id_empleado=".$id_empleado."
			GROUP BY sir_empleado_informacion_laboral.id_empleado_informacion_laboral
			HAVING sir_empleado_informacion_laboral.fecha_inicio >= ALL(SELECT
					sir_empleado_informacion_laboral.fecha_inicio
					FROM sir_empleado_informacion_laboral
					WHERE sir_empleado_informacion_laboral.id_empleado='".$id_empleado."'
					GROUP BY sir_empleado_informacion_laboral.id_empleado,sir_empleado_informacion_laboral.fecha_inicio) 
		";
		$query=$this->db->query($sentencia);
		$datos=(array)$query->row();
		
		$sentencia="SELECT
					sir_empleado.nr,
					sir_empleado_informacion_laboral.id_seccion,
					sir_cargo_funcional.funcional,
					sir_cargo_nominal.cargo_nominal AS nominal,
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
					LEFT JOIN sir_cargo_nominal ON sir_cargo_nominal.id_cargo_nominal = sir_empleado_informacion_laboral.id_cargo_nominal
					WHERE sir_empleado.id_empleado='".$id_empleado."' AND sir_empleado_informacion_laboral.id_seccion='".$datos['id_seccion']."'";
		$query=$this->db->query($sentencia);*/
		
		$sentencia="SELECT 
					tcm_empleado.nr,
					tcm_empleado.id_seccion,
					UPPER(tcm_empleado.funcional) AS funcional,
					UPPER(tcm_empleado.nominal) AS nominal,
					UPPER(tcm_empleado.seccion) AS nivel_1,
					UPPER(tcm_empleado.padre) AS nivel_2,
					UPPER(tcm_empleado.abuelo) AS nivel_3
					FROM tcm_empleado
					WHERE tcm_empleado.id_empleado='".$id_empleado."'";
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
					(id_solicitud_transporte, fecha_solicitud_transporte, id_empleado_solicitante, fecha_mision, hora_salida, hora_entrada, requiere_motorista, acompanante, id_usuario_crea, fecha_creacion, estado_solicitud_transporte) 
					VALUES 
					($id_solicitud_transporte, '$fecha_solicitud_transporte', '$id_empleado_solicitante', '$fecha_mision', '$hora_salida', '$hora_entrada', '$requiere_motorista', '$acompanante', '$id_usuario_crea', '$fecha_creacion', '$estado_solicitud_transporte')";
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
	
	function insertar_descripcion($id,$descrip,$quien=NULL)
	{
		$q="INSERT INTO tcm_observacion 
				(id_solicitud_transporte, observacion, quien_realiza)
			VALUES
				('".$id."', 
				'".$descrip."', 
				".$quien."
				);";
		
		$query=$this->db->query($q);	
		return $query;
	}
	
	function consultar_empleados_seccion($id_seccion)
	{
		$sentencia="SELECT DISTINCT
							LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre,
							i.id_empleado AS NR
							FROM
							sir_empleado_informacion_laboral AS i
							LEFT JOIN sir_empleado AS e ON e.id_empleado = i.id_empleado
							WHERE (i.id_empleado, i.fecha_inicio) IN  
							( SELECT id_empleado ,MAX(fecha_inicio)  FROM sir_empleado_informacion_laboral GROUP BY id_empleado  ) 
							AND i.id_seccion=".$id_seccion."
							ORDER BY e.id_empleado";


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
				vh.placa	
			FROM tcm_solicitud_transporte  s 
			INNER JOIN sir_empleado e ON id_empleado_solicitante = id_empleado
			INNER JOIN  tcm_asignacion_sol_veh_mot asi ON asi.id_solicitud_transporte=s.id_solicitud_transporte
			INNER JOIN tcm_vehiculo vh ON vh.id_vehiculo= asi.id_vehiculo
			WHERE  ( (estado_solicitud_transporte=3) OR estado_solicitud_transporte=4)");
		return $query->result();
		
		}
function salidas_entradas_vehiculos_seccion($id_seccion){
		$query=$this->db->query("
						SELECT * FROM
						(
						SELECT t.id_solicitud_transporte id,
						DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
						DATE_FORMAT(hora_entrada,'%r') entrada,
						DATE_FORMAT(hora_salida,'%r') salida,
						veh.placa,
						estado_solicitud_transporte estado,
						LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
						LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido, s.apellido_casada)) AS nombre
						FROM tcm_solicitud_transporte  t
						INNER JOIN tcm_asignacion_sol_veh_mot asi  ON asi.id_solicitud_transporte = t.id_solicitud_transporte
						INNER JOIN tcm_vehiculo veh ON veh.id_vehiculo = asi.id_vehiculo
						LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
						LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
						LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)

						WHERE 
							(estado_solicitud_transporte= 3 OR estado_solicitud_transporte = 4 )
							and o.id_seccion= '".$id_seccion."'

						)
						as k
						GROUP BY k.id 
						ORDER BY k.fecha DESC

			");
		return $query->result();
		
		}
function salidas_entradas_vehiculos_SanSalvador(){
		$query=$this->db->query("
SELECT * FROM
(
SELECT t.id_solicitud_transporte id,
DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
DATE_FORMAT(hora_entrada,'%r') entrada,
DATE_FORMAT(hora_salida,'%r') salida,
veh.placa,
estado_solicitud_transporte estado,
LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido, s.apellido_casada)) AS nombre
FROM tcm_solicitud_transporte  t
INNER JOIN tcm_asignacion_sol_veh_mot asi  ON asi.id_solicitud_transporte = t.id_solicitud_transporte
INNER JOIN tcm_vehiculo veh ON veh.id_vehiculo = asi.id_vehiculo
LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)

WHERE 
	(estado_solicitud_transporte= 3 OR estado_solicitud_transporte = 4 )
	and o.id_seccion  NOT IN 
			(SELECT id_seccion FROM org_seccion WHERE id_seccion BETWEEN 52 AND 66)
)
as k
GROUP BY k.id 
ORDER BY k.fecha DESC

			");
		return $query->result();
		
		}


	function accesoriosABordo($id_solicitud)
{
	$sentencia=" SELECT
			ca.id_solicitud_transporte,
			a.nombre, a.id_accesorio
				FROM
					tcm_accesorios  a
				INNER JOIN	tcm_chekeo_accesorio ca ON a.id_accesorio=ca.id_accesorio
				WHERE ca.id_solicitud_transporte = '$id_solicitud'";
	$query=$this->db->query($sentencia);
	return $query->result();
}


function salida_vehiculo($id, $km_inicial,$hora_salida,$acces,$gas){
			
		$q="INSERT INTO tcm_vehiculo_kilometraje (
					id_solicitud_transporte, 
					id_vehiculo, 
					km_inicial,
					km_final, 
					hora_salida, 
					fecha_modificacion,
					combustibleIni)
				VALUES(
					'".$id."', 
					(SELECT id_vehiculo FROM tcm_asignacion_sol_veh_mot WHERE id_solicitud_transporte = ".$id."),
					 '".$km_inicial."',
					 '".$km_inicial."',        
					CONCAT_WS(' ',CURDATE(),'".$hora_salida."'), 
					CONCAT_WS(' ',CURDATE(),CURTIME()),
					'".$gas."'
				);";
		$this->db->query($q);

				foreach($acces as  $row)://insert de accesorio


			$this->db->query("INSERT INTO tcm_chekeo_accesorio(id_solicitud_transporte, 
							id_accesorio, salida)
							VALUES
							($id, $row, 1 );");
			
		endforeach;
		
		$q="UPDATE tcm_solicitud_transporte SET
		estado_solicitud_transporte = '4' 
		WHERE	id_solicitud_transporte = '$id' ;";
		$this->db->query($q);
	}


function regreso_vehiculo($id, $km, $hora, $gas,$acces){

	$q="UPDATE tcm_vehiculo_kilometraje 
	SET
		km_final = '$km' , 
		combustible = '$gas' , 
		hora_entrada = CONCAT(CURDATE(),' $hora'), 
		fecha_modificacion = CURDATE()
	WHERE
		id_solicitud_transporte = '$id' ;
		";
	
		$this->db->query($q);
		
		foreach($acces as  $row)://insert de accesorio

		$this->db->query("UPDATE tcm_chekeo_accesorio SET regreso = 1	
				WHERE id_solicitud_transporte = $id AND id_accesorio = $row ;"); 

			
		endforeach;
		$q="
		UPDATE tcm_solicitud_transporte SET
		estado_solicitud_transporte = '5'  
		WHERE	id_solicitud_transporte = '$id' ;
		";
		$this->db->query($q);
		
	}
function infoSolicitud($id){
	$query="
SELECT
	LOWER(
		CONCAT_WS(
			' ',
			e.primer_nombre,
			e.segundo_nombre,
			e.tercer_nombre,
			e.primer_apellido,
			e.segundo_apellido,
			e.apellido_casada
		)
	) AS nombre,
	DATE_FORMAT(hora_salida, '%h:%i %p') salida,
	DATE_FORMAT(hora_entrada, '%h:%i %p') regreso,
	v.placa,
	v.id_vehiculo,
	vm.modelo,
v.cantidad_combustible as gas
FROM
	tcm_vehiculo v
INNER JOIN tcm_asignacion_sol_veh_mot asi ON v.id_vehiculo = asi.id_vehiculo
INNER JOIN tcm_vehiculo_modelo vm ON vm.id_vehiculo_modelo = v.id_modelo
INNER JOIN tcm_solicitud_transporte s ON s.id_solicitud_transporte = asi.id_solicitud_transporte
LEFT JOIN sir_empleado e ON e.id_empleado = s.id_empleado_solicitante
		WHERE s.id_solicitud_transporte = ".$id;
		$q=$this->db->query($query);
		return $q->result();
	}
	function buscar_solicitudes($id_empleado=NULL,$estado=NULL, $id_seccion=NULL)
	{

	
		$whereExtra="";

		if($id_empleado!=NULL) {
			$whereExtra.=" AND id_empleado_solicitante='".$id_empleado."'  ";
	
		}
		if($estado!=""||$estado!=NULL){
				$whereExtra.=" AND estado_solicitud_transporte>='".$estado."' "  ;
		}
		if($id_seccion!=NULL){
				$whereExtra.=" AND i.id_seccion= '".$id_seccion."' "  ;
				}


		/*$sentencia="SELECT DISTINCT
					id_solicitud_transporte id,
					DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
					DATE_FORMAT(hora_entrada,'%h:%i %p') entrada,
					DATE_FORMAT(hora_salida,'%h:%i %p') salida,
					LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre,
					LOWER(COALESCE(s.nombre_seccion, 'No hay registro')) seccion,
					st.estado_solicitud_transporte estado
					FROM
					sir_empleado_informacion_laboral AS i
					LEFT JOIN org_seccion AS s ON s.id_seccion = i.id_seccion
					LEFT JOIN sir_empleado AS e ON e.id_empleado = i.id_empleado
					INNER JOIN tcm_solicitud_transporte AS st ON st.id_empleado_solicitante = e.id_empleado
					WHERE (i.id_empleado, i.fecha_inicio) IN  
					( SELECT id_empleado ,MAX(fecha_inicio)  FROM sir_empleado_informacion_laboral GROUP BY id_empleado  ) ".$whereExtra."
					ORDER BY fecha_mision,hora_salida
					";*/
		$sentencia="
		SELECT * FROM
		(
			SELECT id_solicitud_transporte id,
			DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
			DATE_FORMAT(hora_entrada,'%r') entrada,
			DATE_FORMAT(hora_salida,'%r') salida,
			requiere_motorista,
			LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
			estado_solicitud_transporte estado,
			LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido, s.apellido_casada)) AS nombre
			FROM tcm_solicitud_transporte  t
			LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
			LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
			LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
			WHERE 
				(t.id_empleado_solicitante not in
						(select id_empleado from sir_empleado_informacion_laboral))
				".$whereExtra."
					
			UNION
					
			SELECT id_solicitud_transporte id,
			DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
			DATE_FORMAT(hora_entrada,'%r') entrada,
			DATE_FORMAT(hora_salida,'%r') salida,
			requiere_motorista,
			LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
			estado_solicitud_transporte estado,
			LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada)) AS nombre
			FROM tcm_solicitud_transporte  t
			LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
			LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
			LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
			WHERE 
				(	i.id_empleado_informacion_laboral in
					(
						SELECT se.id_empleado_informacion_laboral
						FROM sir_empleado_informacion_laboral AS se
						INNER JOIN
						(
							SELECT id_empleado, MAX(fecha_inicio) AS fecha FROM sir_empleado_informacion_laboral
							GROUP BY id_empleado
							HAVING COUNT(id_empleado>=1)
						)
						AS ids
						ON (se.id_empleado=ids.id_empleado AND se.fecha_inicio=ids.fecha)
						ORDER BY se.id_empleado_informacion_laboral
					)
				)
				".$whereExtra."
		)
		as k
		GROUP BY k.id
		";
		
		$query=$this->db->query($sentencia);
		if($query->num_rows>0) {
			return (array)$query->result_array();
		}
		else {
			return (array)$query->result_array();
		}
	}
	
	function consultar_destinos($id_solicitud=NULL)
	{
		$sentencia="SELECT lugar_destino, direccion_destino, mision_encomendada, LOWER(CONCAT_WS(', ',departamento,municipio)) AS lugar, tcm_destino_mision.id_municipio FROM tcm_destino_mision INNER JOIN org_municipio ON org_municipio.id_municipio = tcm_destino_mision.id_municipio INNER JOIN org_departamento ON org_departamento.id_departamento = org_municipio.id_departamento_pais WHERE id_solicitud_transporte='".$id_solicitud."'";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function eliminar_solicitud($id_solicitud, $real=false)
	{
		if ($real) {
			$sentencia="DELETE FROM tcm_solicitud_transporte where id_solicitud_transporte='$id_solicitud'";
		} else {
			$sentencia="UPDATE tcm_solicitud_transporte SET estado_solicitud_transporte='-1' 
								WHERE id_solicitud_transporte='$id_solicitud'";
		}
		
		$query=$this->db->query($sentencia);

	}

	function consultar_estado($id_solicitud=NULL)
	{
		$sentencia="SELECT estado_solicitud_transporte  as estado FROM tcm_solicitud_transporte  WHERE id_solicitud_transporte='$id_solicitud'";
		$query=$this->db->query($sentencia);
		return $query->result_array();

	}
	function consultar_solicitud($id_solicitud=NULL,$estado=NULL)
	{
		if($estado!=NULL)
			$where_estado=" AND tcm_solicitud_transporte.estado_solicitud_transporte IN(".$estado.")";
		$sentencia="SELECT
					tcm_solicitud_transporte.id_solicitud_transporte,
					tcm_solicitud_transporte.id_empleado_solicitante,
					tcm_solicitud_transporte.id_empleado_autoriza,
					DATE_FORMAT(tcm_solicitud_transporte.fecha_aprobacion, '%d/%m/%Y') AS fecha_aprobacion,
					DATE_FORMAT(tcm_solicitud_transporte.fecha_aprobacion,'%h:%i %p') AS hora_aprobacion,
					LOWER(CONCAT_WS(' ',e1.primer_nombre, e1.segundo_nombre, e1.tercer_nombre, e1.primer_apellido, e1.segundo_apellido, e1.apellido_casada)) AS nombre,
					LOWER(CONCAT_WS(' ',e2.primer_nombre, e2.segundo_nombre, e2.tercer_nombre, e2.primer_apellido, e2.segundo_apellido, e2.apellido_casada)) AS nombre2,
					DATE_FORMAT(tcm_solicitud_transporte.fecha_mision, '%d/%m/%Y') AS fecha_mision,
					DATE_FORMAT(tcm_solicitud_transporte.fecha_solicitud_transporte, '%d/%m/%Y') AS fecha_solicitud_transporte,
					DATE_FORMAT(tcm_solicitud_transporte.hora_salida,'%h:%i %p') AS hora_salida,
					DATE_FORMAT(tcm_solicitud_transporte.hora_entrada,'%h:%i %p') AS hora_entrada,
					tcm_solicitud_transporte.acompanante,
					tcm_observacion.observacion,
					tcm_observacion.quien_realiza,
					tcm_solicitud_transporte.requiere_motorista,
					e1.nr AS NR
					FROM tcm_solicitud_transporte
					INNER JOIN sir_empleado AS e1 ON tcm_solicitud_transporte.id_empleado_solicitante=e1.id_empleado
					LEFT JOIN sir_empleado AS e2 ON tcm_solicitud_transporte.id_empleado_autoriza=e2.id_empleado
					LEFT JOIN tcm_observacion ON tcm_observacion.id_solicitud_transporte = tcm_solicitud_transporte.id_solicitud_transporte
					WHERE tcm_solicitud_transporte.id_solicitud_transporte='".$id_solicitud."' ".$where_estado;
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
				'mision_encomendada' => "",
				'nombre' => "",
				'observacion' => "",
				'quien_realiza' => "",
				'requiere_motorista' => "",
				'NR' => ""
			);
		}
	}
	function kilometraje($id){
			$query="SELECT v.id_vehiculo, COALESCE(MAX(k.km_inicial), 0) AS KMinicial, COALESCE(MAX(k.km_Final), 0) AS KMFinal
				FROM tcm_vehiculo  v 
				LEFT JOIN tcm_vehiculo_kilometraje  k  
				ON  v.id_vehiculo= k.id_vehiculo 
				GROUP BY v.id_vehiculo HAVING v.id_vehiculo=".$id;
		$q=$this->db->query($query);
		return $q->result();

	}

	function guardar_destinos($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO tcm_destino_mision
					(id_solicitud_transporte, id_municipio, lugar_destino, direccion_destino, mision_encomendada) 
					VALUES 
					('$id_solicitud_transporte', '$id_municipio', '$lugar_destino', '$direccion_destino', '$mision_encomendada')";
		$this->db->query($sentencia);
	}
		
	function accesorios(){
					$query="SELECT 	id_accesorio, nombre,  descrip, estado	 
							FROM  tcm_accesorios ";
							
		$q=$this->db->query($query);
		return $q->result();
		
		}
	function datos_motorista_vehiculo($id_solicitud_transporte) 
	{
		$sentencia="SELECT
					LOWER(CONCAT_WS(' ',e1.primer_nombre, e1.segundo_nombre, e1.tercer_nombre, e1.primer_apellido, e1.segundo_apellido, e1.apellido_casada)) AS nombre,
					tcm_asignacion_sol_veh_mot.id_empleado_asigna,
					DATE_FORMAT(tcm_asignacion_sol_veh_mot.fecha_hora_asignacion, '%d/%m/%Y') AS fecha_asignacion,
					DATE_FORMAT(tcm_asignacion_sol_veh_mot.fecha_hora_asignacion,'%h:%i %p') AS hora_asignacion,
					LOWER(CONCAT_WS(' ',e2.primer_nombre, e2.segundo_nombre, e2.tercer_nombre, e2.primer_apellido, e2.segundo_apellido, e2.apellido_casada)) AS nombre2,
					tcm_vehiculo.placa,
					LOWER(tcm_vehiculo_clase.nombre_clase) AS nombre_clase
					FROM tcm_vehiculo
					INNER JOIN tcm_vehiculo_clase ON tcm_vehiculo_clase.id_vehiculo_clase = tcm_vehiculo.id_clase
					INNER JOIN tcm_asignacion_sol_veh_mot ON tcm_asignacion_sol_veh_mot.id_vehiculo = tcm_vehiculo.id_vehiculo
					INNER JOIN sir_empleado AS e1 ON tcm_asignacion_sol_veh_mot.id_empleado = e1.id_empleado
					INNER JOIN sir_empleado AS e2 ON tcm_asignacion_sol_veh_mot.id_empleado_asigna = e2.id_empleado
					WHERE tcm_asignacion_sol_veh_mot.id_solicitud_transporte = '".$id_solicitud_transporte."'";
		$query=$this->db->query($sentencia);
		
		return (array)$query->row();
	}
	function datos_salida_entrada_real($id_solicitud_transporte)
	{
		$sentencia="SELECT
					CONCAT_WS(' ', tcm_vehiculo_kilometraje.km_inicial, 'Kms') AS km_inicial,
					CASE 
						WHEN tcm_vehiculo_kilometraje.km_final IS NOT NULL THEN
							CONCAT_WS(' ', tcm_vehiculo_kilometraje.km_final, 'Kms') 
						ELSE
							''
						END
						AS km_final,
					CASE 
						WHEN tcm_vehiculo_kilometraje.km_final IS NOT NULL THEN
					CONCAT_WS(' ', (tcm_vehiculo_kilometraje.km_final-tcm_vehiculo_kilometraje.km_inicial), 'Kms')
						ELSE
							''
						END
						AS total,
					tcm_vehiculo_kilometraje.combustible,
					DATE_FORMAT(tcm_vehiculo_kilometraje.hora_salida,'%d/%m/%Y') AS fecha_mision,
					DATE_FORMAT(tcm_vehiculo_kilometraje.hora_salida,'%h:%i %p') AS hora_salida,
					DATE_FORMAT(tcm_vehiculo_kilometraje.hora_entrada,'%h:%i %p') AS hora_entrada
					FROM tcm_vehiculo_kilometraje
					WHERE id_solicitud_transporte='".$id_solicitud_transporte."'";
		$query=$this->db->query($sentencia);
		
		return (array)$query->row();
	}
	function observaciones($id_solicitud_transporte)
	{
		$sentencia="SELECT
					tcm_observacion.observacion,
					tcm_observacion.quien_realiza
					FROM tcm_observacion
					WHERE id_solicitud_transporte='".$id_solicitud_transporte."'";
		$query=$this->db->query($sentencia);
		
		return (array)$query->result_array();
	}

	public function is_departamental($id_seccion=NULL)
	{	
		if($id_seccion>=52 AND $id_seccion<=66 ){
			return true;
		}else{
			return false;
		}
	}
	
	public function consultar_empleados_depto()
	{
		$sentencia="SELECT DISTINCT
					LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre,
					i.id_empleado AS NR
					FROM
					sir_empleado_informacion_laboral AS i
					LEFT JOIN sir_empleado AS e ON e.id_empleado = i.id_empleado
					WHERE (i.id_empleado, i.fecha_inicio) IN  
						( SELECT id_empleado ,MAX(fecha_inicio)  FROM sir_empleado_informacion_laboral GROUP BY id_empleado  ) 
						AND i.id_seccion<>52 AND i.id_seccion<>53 AND i.id_seccion<>54 AND i.id_seccion<>55 AND i.id_seccion<>56 AND i.id_seccion<>57 AND i.id_seccion<>58 AND i.id_seccion<>59 AND i.id_seccion<>60 AND i.id_seccion<>61 AND i.id_seccion<>64 AND i.id_seccion<>65 AND i.id_seccion<>66 
						ORDER BY e.id_empleado";
		$query=$this->db->query($sentencia);

		return (array)$query->result_array();
	}
	
	public function buscar_solicitudes_depto($estado=NULL)
	{
		
		$sentencia="SELECT * FROM
					(
						SELECT id_solicitud_transporte id,
						DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
						DATE_FORMAT(hora_entrada,'%r') entrada,
						DATE_FORMAT(hora_salida,'%r') salida,
						requiere_motorista,
						LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
						estado_solicitud_transporte estado,
						LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido, s.apellido_casada)) AS nombre
						FROM tcm_solicitud_transporte  t
						LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
						LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
						LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
						WHERE 
							(estado_solicitud_transporte>='".$estado."' and (o.id_seccion!=52 and o.id_seccion!=53 and o.id_seccion!=54 and o.id_seccion!=55 and o.id_seccion!=56 and o.id_seccion!=57 and o.id_seccion!=58 and o.id_seccion!=59 and o.id_seccion!=60 and o.id_seccion!=61 and o.id_seccion!=64 and o.id_seccion!=65 and o.id_seccion!=66))
							and (t.id_empleado_solicitante not in
									(select id_empleado from sir_empleado_informacion_laboral))
								
						UNION
								
						SELECT id_solicitud_transporte id,
						DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
						DATE_FORMAT(hora_entrada,'%r') entrada,
						DATE_FORMAT(hora_salida,'%r') salida,
						requiere_motorista,
						LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion,
						estado_solicitud_transporte estado,
						LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada)) AS nombre
						FROM tcm_solicitud_transporte  t
						LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
						LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
						LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
						WHERE 
							(estado_solicitud_transporte>='".$estado."' and (o.id_seccion!=52 and o.id_seccion!=53 and o.id_seccion!=54 and o.id_seccion!=55 and o.id_seccion!=56 and o.id_seccion!=57 and o.id_seccion!=58 and o.id_seccion!=59 and o.id_seccion!=60 and o.id_seccion!=61 and o.id_seccion!=64 and o.id_seccion!=65 and o.id_seccion!=66))
							and 
							(	i.id_empleado_informacion_laboral in
								(
									SELECT se.id_empleado_informacion_laboral
									FROM sir_empleado_informacion_laboral AS se
									INNER JOIN
									(
										SELECT id_empleado, MAX(fecha_inicio) AS fecha FROM sir_empleado_informacion_laboral
										GROUP BY id_empleado
										HAVING COUNT(id_empleado>=1)
									)
									AS ids
									ON (se.id_empleado=ids.id_empleado AND se.fecha_inicio=ids.fecha)
									ORDER BY se.id_empleado_informacion_laboral
								)
							)
					)
					as k
					GROUP BY k.id";
		$query=$this->db->query($sentencia);

		return (array)$query->result_array();
	}

	function update_combustible($id, $gas)
	{
		$q="UPDATE tcm_vehiculo SET cantidad_combustible= '".$gas."'
		 WHERE (id_vehiculo='(SELECT id_vehiculo 
		 	FROM tcm_asignacion_sol_veh_mot 
		 	WHERE id_solicitud_transporte = ".$id.")')";
		
		$query=$this->db->query($q);

	}
	

	function consultar_direfencia($id,$gas)
	{

		$q="SELECT
				cantidad_combustible - ".$gas." as diferencia
			FROM tcm_vehiculo
			WHERE
				id_vehiculo = ( SELECT id_vehiculo
					FROM 		tcm_asignacion_sol_veh_mot
					WHERE
						id_solicitud_transporte = ".$id."
				)";
		
		$query=$this->db->query($q);
		return (array)$query->result_array();
	}


	function insertar_bitacora_combustible($id,$gas)
	{

		$q="INSERT INTO `tcm_bitacora_vehiculo` (
				`id_solicitud_transporte_bitacora`,
				`fecha_hora`,
				`id_vehiculo`,
				`diferencia`
			)
			VALUES
				(
					".$id.",
				 CONCAT_WS(' ',CURDATE(),CURTIME()),
					(SELECT id_vehiculo 
					 	FROM tcm_asignacion_sol_veh_mot 
					 	WHERE id_solicitud_transporte = ".$id."),
					'".$gas."'
				)";
		
		$query=$this->db->query($q);
	}
	///////////////////////FUNCIONES DEL PRESUPUESTO////////////////////////////////////////////////////
	
	/**********************FUNCIÓN PRESUPUESTO ASIGNADO PARA EL ÁREA DE MANTENIMIENTO VEHICULAR***********************/
	function presupuesto($id_presupuesto=NULL)
	{
		$where="";
		if($id_presupuesto!=NULL) $where=" where tpm.id_presupuesto='$id_presupuesto'";
		
		$query="SELECT tpm.id_presupuesto, tpm.presupuesto, COALESCE((tpm.presupuesto-g.gasto), tpm.presupuesto) as cantidad_actual, COALESCE(g.gasto,0) as gasto,
				DATE_FORMAT(tpm.fecha_inicial,'%d-%m-%Y') AS fecha_inicial,
				DATE_FORMAT(tpm.fecha_final,'%d-%m-%Y') AS fecha_final
				FROM tcm_presupuesto_mantenimiento AS tpm
				LEFT JOIN 
				(
					SELECT tpm.id_presupuesto, SUM(gp.gasto) AS gasto
					FROM tcm_gasto_presupuesto AS gp
					INNER JOIN tcm_presupuesto_mantenimiento AS tpm ON (gp.id_presupuesto=tpm.id_presupuesto)
					GROUP BY tpm.id_presupuesto
				) as g
				ON (tpm.id_presupuesto=g.id_presupuesto)".$where;
				
		$query=$this->db->query($query);
		return (array)$query->result_array();
	}
	/*****************************************************************************************************************/
	
	/******************FUNCIÓN QUE OBTIENE LOS GASTOS REALIZADOS DE UN PRESUPUESTO EN ESPECÍFICO**********************/
	function gastos($id_presupuesto)
	{
		$query="SELECT tcp.id_presupuesto, tcp.id_gasto, DATE_FORMAT(tcp.fecha,'%d-%m-%Y') AS fecha, tcp.gasto, tcp.descripcion
				FROM tcm_gasto_presupuesto AS tcp
				INNER JOIN tcm_presupuesto_mantenimiento AS tpm ON (tcp.id_presupuesto=tpm.id_presupuesto)
				WHERE tpm.id_presupuesto='$id_presupuesto'";
				
		$query=$this->db->query($query);
		return (array)$query->result_array();
	}
	/*****************************************************************************************************************/
	
	/*******************************FUNCIÓN PARA GUARDAR UN REGISTRO PRESUPUESTO**************************************/
	function guardar_presupuesto($datos)
	{
		extract($datos);
		$fecha_inicial2=date('Y-m-d',strtotime($fecha_inicial));
		$fecha_final2=date('Y-m-d',strtotime($fecha_final));
		$fecha_crea=date('Y-m-d H:i:s');
		$query="INSERT INTO tcm_presupuesto_mantenimiento(presupuesto,fecha_inicial,fecha_final,id_usuario_crea,fecha_crea)
				values('$presupuesto','$fecha_inicial2','$fecha_final2','$id_usuario','$fecha_crea')";
		return $this->db->query($query);
	}
	/*****************************************************************************************************************/
	
	/*******************************FUNCIÓN PARA MODIFICAR UN REGISTRO PRESUPUESTO**************************************/
	function modificar_presupuesto($datos)
	{
		extract($datos);
		$fecha_inicial2=date('Y-m-d',strtotime($fecha_inicial));
		$fecha_final2=date('Y-m-d',strtotime($fecha_final));
		$query="UPDATE tcm_presupuesto_mantenimiento SET presupuesto='$presupuesto', fecha_inicial='$fecha_inicial2', fecha_final='$fecha_final2' WHERE id_presupuesto='".$_POST['id_presupuesto']."';";
		return $this->db->query($query);
	}
	/*****************************************************************************************************************/
	
	//////////////////////////////////////////////FUNCIONES DE LOS ARTÍCUlOS////////////////////////////////////////////
	
	/************************************FUNCIÓN QUE MUESTRA LOS ARTÍCULOS DISPONIBLES*********************************/
	function inventario($id_articulo=NULL)
	{
		$where="";
		if($id_articulo!=NULL)
		{
			$where=" where art.id_articulo='$id_articulo'";
		}
		
		$query="SELECT art.id_articulo, art.nombre, art.descripcion, art.cantidad FROM tcm_articulo_bodega as art";
		$query=$this->db->query($query);
		return (array)$query->result_array();
	}
	/******************************************************************************************************************/
	
	/*************************************FUNCIÓN PARA INGRESAR UN NUEVO ARTÍCULO**************************************/
	function nuevo_articulo($datos)
	{
		extract($datos);
		$query="INSERT INTO tcm_articulo_bodega(nombre, decripcion, cantidad) VALUES('$nombre','$descripcion','$cantidad')";
		return $this->db->query($query);
	}
}
?>