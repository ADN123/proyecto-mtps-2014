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
					WHERE org_usuario.nr like '".$nr."' 
					ORDER BY sir_empleado_informacion_laboral.id_empleado_informacion_laboral DESC LIMIT 0,1";
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
 	   SELECT id_solicitud_transporte id,
		estado_solicitud_transporte,
		 id_empleado_solicitante,
		  DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
		  DATE_FORMAT(hora_entrada,'%r') entrada, 
		  DATE_FORMAT(hora_salida,'%r') salida, requiere_motorista, 
		  COALESCE(o.nombre_seccion, 'No hay registro') seccion, 
		  LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada)) AS nombre 
		FROM tcm_solicitud_transporte  t
			LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
			LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
			LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
			WHERE (estado_solicitud_transporte=1 AND i.id_seccion = '".$seccion."')");
 
 
   	return $query->result();
		
	}
function todas_solicitudes_por_confirmar(){

	  $query=$this->db->query("
	   SELECT id_solicitud_transporte id,
estado_solicitud_transporte,
  DATE_FORMAT(fecha_mision,'%d-%m-%Y') fecha,
  DATE_FORMAT(hora_entrada,'%r') entrada, 
  DATE_FORMAT(hora_salida,'%r') salida, requiere_motorista, 
  LOWER(COALESCE(o.nombre_seccion, 'No hay registro')) seccion, 
  LOWER(CONCAT_WS(' ',s.primer_nombre, s.segundo_nombre, s.tercer_nombre, s.primer_apellido,s.segundo_apellido,s.apellido_casada)) AS nombre 
FROM tcm_solicitud_transporte  t
	LEFT JOIN sir_empleado s ON (s.id_empleado=t.id_empleado_solicitante)
	LEFT JOIN sir_empleado_informacion_laboral i ON (i.id_empleado=s.id_empleado)
	LEFT JOIN org_seccion o ON (i.id_seccion=o.id_seccion)
	WHERE estado_solicitud_transporte=1");
 
 
   	return $query->result();
		
	}
	/////FUNCION QUE RETORNA lAS SOlICITUDES QUE AÚN NO TIENEN UN VEHICUlO O MOTORISTA ASIGNADO
	function solicitudes_por_asignar($seccion){
	  $query=$this->db->query("
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
		WHERE (estado_solicitud_transporte=2)
    	order by id ASC, i.id_empleado_informacion_laboral DESC");

   	return $query->result();
		
	}
	////////////////////////////////////////////////////////////////////////////////////////
	
/////////FUNCION QUE RETORNA lA lOCAlIZACIÓN, FECHA Y HORARIOS DE UNA SOlICITUD EN ESPECÍFICO/////
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
	
	//////VEHICUlOS DISPONIBlES INClUYE lOS QUE ESTÁN EN MISIONES lOCAlES ///////////
	function vehiculos_disponibles($fecha,$hentrada,$hsalida)
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
	and (id_seccion=21 or id_seccion=113)
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
		/*$query=$this->db->query("
				SELECT id_solicitud_transporte id, 
					LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido,e.segundo_apellido,e.apellido_casada)) AS nombre,
					DATE_FORMAT(fecha_solicitud_transporte, '%d-%m-%Y') fechaS,
					DATE_FORMAT(fecha_mision, '%d-%m-%Y')  fechaM,
					DATE_FORMAT(hora_salida,'%h:%i %p') salida,
					DATE_FORMAT(hora_entrada,'%h:%i %p') entrada,
					nombre_seccion seccion,
					requiere_motorista req,
					acompanante,
					id_empleado_solicitante
				FROM tcm_solicitud_transporte  s 
				INNER JOIN sir_empleado e ON id_empleado_solicitante = id_empleado,
				org_seccion sec
				WHERE   sec.id_seccion = ".$seccion." AND id_solicitud_transporte =".$id);*/
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
				fecha_modificacion=  CONCAT_WS(' ', CURDATE(),CURTIME())  
			WHERE id_solicitud_transporte= ".$id;
	
		  $query=$this->db->query($q);
	
		return $query;
	}	
	
	function consultar_vehiculos()
	{
		$query=$this->db->query("
		select v.id_vehiculo id, v.placa, vm.nombre as marca, vmo.modelo, vc.nombre_clase clase, vcon.condicion
		from tcm_vehiculo as v
		inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
		inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
		inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
		inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
		");
		return $query->result();
	}
	
	//////////////////////////////CONSUlTAR MARCAS//////////////////////////////
	function consultar_marcas()
	{
		$query=$this->db->query("select id_vehiculo_marca, lower(nombre) as nombre  from tcm_vehiculo_marca");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////CONSUlTAR MODElOS//////////////////////////////
	function consultar_modelos()
	{
		$query=$this->db->query("select id_vehiculo_modelo, lower(modelo) as modelo from tcm_vehiculo_modelo");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////CONSUlTAR ClASES//////////////////////////////
	function consultar_clases()
	{
		$query=$this->db->query("select id_vehiculo_clase, lower(nombre_clase) as nombre_clase from tcm_vehiculo_clase");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////CONSUlTAR CONDICIONES//////////////////////////////
	function consultar_condiciones()
	{
		$query=$this->db->query("select id_vehiculo_condicion, lower(condicion) as condicion from tcm_vehiculo_condicion");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////CONSUlTAR SECCIONES//////////////////////////////
	function consultar_secciones()
	{
		$query=$this->db->query("select id_seccion, lower(nombre_seccion) as seccion from org_seccion");
		return $query->result();
	}
	////////////////////////////////////////////////////////////////////////////
	
	function consultar_datos_vehiculos($id)
	{
		$query=$this->db->query("
		select v.placa, vm.nombre as marca, vmo.modelo, vc.nombre_clase clase, vcon.condicion
		from tcm_vehiculo as v
		inner join tcm_vehiculo_marca as vm on (v.id_marca=vm.id_vehiculo_marca)
		inner join tcm_vehiculo_modelo as vmo on (v.id_modelo=vmo.id_vehiculo_modelo)
		inner join tcm_vehiculo_clase as vc on (v.id_clase=vc.id_vehiculo_clase)
		inner join tcm_vehiculo_condicion as vcon on (v.id_condicion=vcon.id_vehiculo_condicion)
		where v.id_vehiculo='$id'
		");
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
		$query=$this->db->query("(SELECT t.id_empleado, IF(t.id_empleado!=0,LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)),'No tiene asignado') as nombre FROM tcm_vehiculo_motorista t left join sir_empleado e on (t.id_empleado=e.id_empleado)
where t.id_vehiculo='$id') union (SELECT t.id_empleado,LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre FROM tcm_vehiculo_motorista t
inner join sir_empleado e on (t.id_empleado=e.id_empleado)
inner join tcm_vehiculo v on (t.id_vehiculo=v.id_vehiculo)
where (v.id_seccion=21)
order by e.primer_nombre ASC);");
		return $query->result();
	}
	
	///////////////////////////CONSUlTAR MOTORISTAS 2//////////////////////////////////
	
	function consultar_motoristas2()
	{
		$query=$this->db->query("SELECT e.id_empleado, LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido,e.segundo_apellido,e.apellido_casada)) as nombre FROM sir_empleado as e");
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
					(fecha_solicitud_transporte, id_empleado_solicitante, fecha_mision, hora_salida, hora_entrada, requiere_motorista, acompanante, id_usuario_crea, fecha_creacion, estado_solicitud_transporte) 
					VALUES 
					('$fecha_solicitud_transporte', '$id_empleado_solicitante', '$fecha_mision', '$hora_salida', '$hora_entrada', '$requiere_motorista', '$acompanante', '$id_usuario_crea', '$fecha_creacion', '$estado_solicitud_transporte')";
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
		$q="INSERT INTO mtps.tcm_observacion 
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
				vh.placa	
			FROM tcm_solicitud_transporte  s 
			INNER JOIN sir_empleado e ON id_empleado_solicitante = id_empleado
			INNER JOIN  tcm_asignacion_sol_veh_mot asi ON asi.id_solicitud_transporte=s.id_solicitud_transporte
			INNER JOIN tcm_vehiculo vh ON vh.id_vehiculo= asi.id_vehiculo
			WHERE  (s.fecha_mision= CURDATE() AND (estado_solicitud_transporte=3) OR estado_solicitud_transporte=4)");
		return $query->result();
		
		}
function salida_vehiculo($id, $km_inicial,$hora_salida,$acces){
		/*$this->db->trans_start();*/
		
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

				foreach($acces as  $row)://insert de accesorio


			$this->db->query("INSERT INTO mtps.tcm_chekeo_accesorio(id_solicitud_transporte, 
							id_accesorio, salida)
							VALUES
							($id, $row, 1 );");
			
		endforeach;
		
		$q="UPDATE tcm_solicitud_transporte SET
		estado_solicitud_transporte = '4' 
		WHERE	id_solicitud_transporte = '$id' ;";
		$this->db->query($q);
		
/*		$this->db->trans_complete();
		
		if ($this->db->trans_status())
		{
			echo"Ok";

		}else{	// Error en tra
		echo"Error";
			
		}*/
	}

function regreso_vehiculo($id, $km, $hora, $gas,$acces){


	/*$this->db->trans_start();*/
	
	$q="UPDATE tcm_vehiculo_kilometraje 
	SET
		km_final = '$km' , 
		combustible = '$gas' , 
		hora_entrada = '$hora' , 
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
		
		/*//Finde transacion
		$this->db->trans_complete();
		
		if ($this->db->trans_status())
		{
			echo"Ok";

		}else{	// Error en transacion
		echo"Error";
			
		}*/

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
					CONCAT_WS(' ',DATE_FORMAT(tcm_solicitud_transporte.fecha_mision, '%d-%m-%Y')) AS fecha,
					DATE_FORMAT(tcm_solicitud_transporte.hora_salida,'%h:%i %p') AS salida,
					DATE_FORMAT(tcm_solicitud_transporte.hora_entrada,'%h:%i %p') AS entrada,
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
					LOWER(CONCAT_WS(' ',e1.primer_nombre, e1.segundo_nombre, e1.tercer_nombre, e1.primer_apellido, e1.segundo_apellido, e1.apellido_casada)) AS nombre,
					LOWER(CONCAT_WS(' ',e2.primer_nombre, e2.segundo_nombre, e2.tercer_nombre, e2.primer_apellido, e2.segundo_apellido, e2.apellido_casada)) AS nombre2,
					DATE_FORMAT(tcm_solicitud_transporte.fecha_mision, '%d/%m/%Y') AS fecha_mision,
					DATE_FORMAT(tcm_solicitud_transporte.hora_salida,'%h:%i %p') AS hora_salida,
					DATE_FORMAT(tcm_solicitud_transporte.hora_entrada,'%h:%i %p') AS hora_entrada,
					tcm_solicitud_transporte.acompanante
					FROM tcm_solicitud_transporte
					INNER JOIN sir_empleado AS e1 ON tcm_solicitud_transporte.id_empleado_solicitante=e1.id_empleado
					LEFT JOIN sir_empleado AS e2 ON tcm_solicitud_transporte.id_empleado_autoriza=e2.id_empleado
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
					(id_solicitud_transporte, id_municipio, lugar_destino, direccion_destino, mision_encomendada) 
					VALUES 
					('$id_solicitud_transporte', '$id_municipio', '$lugar_destino', '$direccion_destino', '$mision_encomendada')";
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
	
	function accesorios(){
					$query="SELECT 	id_accesorio, nombre,  descrip, estado	 
							FROM  tcm_accesorios ";
							
		$q=$this->db->query($query);
		return $q->result();
		
		}
	function datos_motorista_vehiculo($id_solicitud_transporte) 
	{
		$sentencia="SELECT
					LOWER(CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada)) AS nombre,
					tcm_vehiculo.placa,
					LOWER(tcm_vehiculo_clase.nombre_clase) AS nombre_clase
					FROM tcm_vehiculo
					INNER JOIN tcm_vehiculo_clase ON tcm_vehiculo_clase.id_vehiculo_clase = tcm_vehiculo.id_clase
					INNER JOIN tcm_asignacion_sol_veh_mot ON tcm_asignacion_sol_veh_mot.id_vehiculo = tcm_vehiculo.id_vehiculo
					INNER JOIN sir_empleado ON tcm_asignacion_sol_veh_mot.id_empleado = sir_empleado.id_empleado
					WHERE id_solicitud_transporte='".$id_solicitud_transporte."'";
		$query=$this->db->query($sentencia);
		
		return (array)$query->row();
	}
	function datos_salida_entrada_real($id_solicitud_transporte)
	{
		$sentencia="SELECT
					tcm_vehiculo_kilometraje.km_inicial,
					tcm_vehiculo_kilometraje.km_final,
					tcm_vehiculo_kilometraje.combustible,
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

}
?>