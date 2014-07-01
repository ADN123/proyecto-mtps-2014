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

	function vehiculos($id_seccion=NULL, $id_fuente_fondo= NULL)	
	{	
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
		( fecha , id_seccion, cantidad_solicitada,id_empleado_solicitante,id_fuente_fondo,justificacion , id_usuario_crea, fecha_creacion, refuerzo) 
VALUES ( CONCAT_WS(' ', CURDATE(),CURTIME()), '$id_seccion','$cantidad_solicitada','$id_empleado_solicitante', $id_fuente_fondo, '$justificacion', $id_usuario,  CONCAT_WS(' ', CURDATE(),CURTIME()), $refuerzo)";
		

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

		if($estado!=NULL){
			$where.= "	WHERE estado = '".$estado."'";
		}
		if($id_seccion!=NULL && $estado!=NULL){
			$where.= "	AND sr.id_seccion = '".$id_seccion."'";
		}
		if($id_seccion!=NULL && $estado==NULL){
			$where.= "	WHERE sr.id_seccion = '".$id_seccion."'";	
		}

		$query=$this->db->query("SELECT
									id_requisicion,
									sr.nombre_seccion AS seccion,
									cantidad_solicitada AS cantidad,
									DATE_FORMAT(fecha,'%d/%m/%Y') as fecha,
									estado , refuerzo 
								FROM
									tcm_requisicion r
								INNER JOIN org_seccion sr ON r.id_seccion = sr.id_seccion
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
		$q="SELECT
									id_requisicion,
									sr.nombre_seccion AS seccion,
									cantidad_solicitada AS cantidad,
									DATE_FORMAT(fecha,'%d/%m/%Y') as fecha,
									estado
								FROM
									tcm_requisicion r
								INNER JOIN org_seccion sr ON r.id_seccion = sr.id_seccion
								WHERE sr.id_seccion NOT BETWEEN 52 	AND 66
								".$where."
								ORDER BY
									fecha DESC";
									//echo $q;

		$query=$this->db->query($q);
			return (array)$query->result_array();
	}

	function info_requisicion($id)
	{
		$query=$this->db->query(" SELECT
				id_requisicion,
				sr.nombre_seccion AS seccion,
				cantidad_solicitada AS cantidad,
				DATE_FORMAT(fecha_creacion,'%d/%m/%Y %h:%i %p') as fecha,
				ff.id_fuente_fondo as id_fuente_fondo,
				ff.nombre_fuente_fondo as fuente_fondo,
				justificacion,
				LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido,e.segundo_apellido,e.apellido_casada)) AS nombre,
				DATE_FORMAT(fecha_visto_bueno,'%d/%m/%Y %h:%i %p') as fecha_visto_bueno,			
				LOWER(CONCAT_WS(' ',e2.primer_nombre, e2.segundo_nombre, e2.tercer_nombre, e2.primer_apellido,e2.segundo_apellido,e2.apellido_casada)) AS visto_bueno,
				DATE_FORMAT(fecha_autorizado,'%d/%m/%Y %h:%i %p') as fecha_autorizado,			
				LOWER(CONCAT_WS(' ',e3.primer_nombre, e3.segundo_nombre, e3.tercer_nombre, e3.primer_apellido,e3.segundo_apellido,e3.apellido_casada)) AS autorizado,
				estado, refuerzo

			FROM
				tcm_requisicion r
			INNER JOIN org_seccion sr ON r.id_seccion = sr.id_seccion
			LEFT JOIN sir_empleado e ON r.id_empleado_solicitante= e.id_empleado
			LEFT JOIN sir_empleado e2 ON r.id_empleado_vistobueno = e2.id_empleado
			LEFT JOIN sir_empleado e3 ON r.id_empleado_autoriza = e3.id_empleado
			LEFT JOIN tcm_fuente_fondo ff ON ff.id_fuente_fondo = r.id_fuente_fondo
				WHERE id_requisicion= ".$id);
			return $query->result();

		
	}

	function info_requisicion_vehiculos($id)
	{
	$query=$this->db->query("SELECT 
					v.placa, 
					 c.nombre_clase as clase,
					 m.nombre as marca, 
					ff.nombre_fuente_fondo  as fondo
					 FROM tcm_req_veh rv 
					INNER JOIN tcm_vehiculo v ON rv.id_vehiculo = v.id_vehiculo
					INNER JOIN tcm_fuente_fondo ff ON  ff.id_fuente_fondo = v.id_fuente_fondo
					INNER JOIN tcm_vehiculo_clase c ON c.id_vehiculo_clase = v.id_clase
					INNER JOIN  tcm_vehiculo_marca m ON m.id_vehiculo_marca = v.id_marca
					WHERE id_requisicion = ".$id);
			return $query->result();
	}
	
	function guardar_visto_bueno($post)
	{
	extract($post);

	/*$this->db->query("UPDATE tcm_requisicion SET
					id_empleado_vistobueno = ".$id_empleado.",
					fecha_visto_bueno = CONCAT_WS(' ',CURDATE(),CURTIME()),
					fecha_modificacion = CONCAT_WS(' ',CURDATE(),CURTIME()),
					id_usuario_modifica = ".$id_usuario.",
					cantidad_entregado = ".$asignar.",
					cantidad_restante = ".$asignar.",
					id_vale = ".$id_vale.",
					numero_inicial = ".$numero_inicial.",
					estado = ".$resp."
					WHERE id_requisicion = ".$ids);*/
	
	$this->db->query("UPDATE tcm_requisicion SET
					id_empleado_vistobueno = ".$id_empleado.",
					fecha_visto_bueno = CONCAT_WS(' ',CURDATE(),CURTIME()),
					fecha_modificacion = CONCAT_WS(' ',CURDATE(),CURTIME()),
					id_usuario_modifica = ".$id_usuario.",
					estado = ".$resp."
					WHERE id_requisicion = ".$ids);

	}
	
	function req_pdf($id_requisicion)
	{
		$query=$this->db->query("SELECT DATE_FORMAT(r.fecha,'%d-%m-%Y') as fecha,
		o.nombre_seccion as seccion,
		r.cantidad_solicitada,
		LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre,
		r.tipo_requisicion, r.justificacion, r.servicio_de,
		r.numero_inicial, r.cantidad_restante
		FROM tcm_requisicion AS r
		LEFT JOIN org_seccion AS o ON o.id_seccion=r.id_seccion
		LEFT JOIN sir_empleado AS e ON 
					(e.id_empleado = r.id_empleado_solicitante AND
					 e.id_empleado = r.id_empleado_autoriza AND
					 e.id_empleado = r.id_empleado_recibe AND
					 e.id_empleado = r.id_empleado_vistobueno AND
					 e.id_empleado = r.id_empledo_entrega
					)
		WHERE r.id_requisicion='$id_requisicion'");
	}
	
	function guardar_autorizacion($post)
	{
		extract($post);
	
		$q="UPDATE tcm_requisicion
			SET 
			 fecha_autorizado = CONCAT_WS(' ', CURDATE(), CURTIME()),
			 fecha_modificacion = CONCAT_WS(' ', CURDATE(), CURTIME()),
			id_empleado_autoriza = ".$id_empleado.", 
			id_usuario_modifica = ".$id_usuario.",
			 estado = 3
			WHERE
				id_requisicion = ".$ids;
				$this->db->query($q);
	
	}
	
	function buscar_vales($formuInfo)
	{
		extract($formuInfo);
		$sentencia="SELECT id_vale, (final-cantidad_restante+1) AS inicial, cantidad_restante FROM tcm_vale WHERE tipo_vehiculo='".$id_fuente_fondo."' AND cantidad_restante>0 ORDER BY fecha_recibido, id_vale";
		$query=$this->db->query($sentencia);
		$res=(array)$query->result_array();
		foreach($res as $r) {
			if($cantidad>0) {
				if($r[cantidad_restante]>=$cantidad) {
					$sentencia="UPDATE tcm_vale SET cantidad_restante=cantidad_restante-".$cantidad." WHERE id_vale=".$r[id_vale];
					$cantidad_entregado=$cantidad;
					$cantidad=0;
				}
				else {
					$sentencia="UPDATE tcm_vale SET cantidad_restante=0 WHERE id_vale=".$r[id_vale];
					$cantidad_entregado=$r[cantidad_restante];
					$cantidad=$cantidad-$r[cantidad_restante];
				}	
				$query=$this->db->query($sentencia);
				
				$sentencia="INSERT INTO tcm_requisicion_vale (id_vale, id_requisicion, cantidad_entregado, numero_inicial, cantidad_restante) VALUES (".$r[id_vale].", ".$id_requisicion.", ".$cantidad_entregado.", ".$r[inicial].", ".$cantidad_entregado.")";
				$query=$this->db->query($sentencia);
			}
		}
		/*if($cantidad>0)
			echo "No se entregaron todos los vales solicitados. Faltaron ".$cantidad." vales";
		else
			echo "Se entregaron todos los vales solicitados";*/
	}
	
	function info_vales($id) 
	{
		$sentencia="SELECT id_fuente_fondo FROM tcm_requisicion WHERE id_requisicion='".$id."'";	
		$query=$this->db->query($sentencia);
		$res=(array)$query->row();
		$sentencia="SELECT SUM(cantidad_restante) AS cantidad_restante FROM tcm_vale WHERE tipo_vehiculo='".$res['id_fuente_fondo']."'";	
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}

	function consultar_vehiculos_seccion($id_seccion=NULL, $id_gasolinera=NULL, $fecha_factura=NULL)
	{
		if($id_seccion!=NULL)
			$where="tcm_requisicion.id_seccion=".$id_seccion;
		else
			$where="tcm_requisicion.id_seccion<>52 AND tcm_requisicion.id_seccion<>53 AND tcm_requisicion.id_seccion<>54 AND tcm_requisicion.id_seccion<>55 AND tcm_requisicion.id_seccion<>56 AND tcm_requisicion.id_seccion<>57 AND tcm_requisicion.id_seccion<>58 AND tcm_requisicion.id_seccion<>59 AND tcm_requisicion.id_seccion<>60 AND tcm_requisicion.id_seccion<>61 AND tcm_requisicion.id_seccion<>64 AND tcm_requisicion.id_seccion<>65 AND tcm_requisicion.id_seccion<>66";
		if($id_gasolinera!=NULL)
			$where.=" AND tcm_vale.id_gasolinera='".$id_gasolinera."'";
		if($fecha_factura!=NULL)
			$where.=" AND tcm_requisicion.fecha_visto_bueno<'".$fecha_factura."'";
		/*$sentencia="SELECT tcm_vehiculo.id_vehiculo, tcm_vehiculo.placa, tcm_fuente_fondo.nombre_fuente_fondo, tcm_vehiculo_marca.nombre as marca, tcm_vehiculo_modelo.modelo, tcm_vale.valor_nominal
					FROM tcm_vehiculo
					INNER JOIN tcm_req_veh ON tcm_req_veh.id_vehiculo = tcm_vehiculo.id_vehiculo
					INNER JOIN tcm_requisicion ON tcm_req_veh.id_requisicion = tcm_requisicion.id_requisicion
					INNER JOIN tcm_requisicion_vale ON tcm_requisicion_vale.id_requisicion = tcm_requisicion.id_requisicion
					INNER JOIN tcm_vale ON tcm_requisicion_vale.id_vale = tcm_vale.id_vale
					INNER JOIN tcm_vehiculo_marca ON tcm_vehiculo.id_marca = tcm_vehiculo_marca.id_vehiculo_marca
					INNER JOIN tcm_vehiculo_modelo ON tcm_vehiculo.id_modelo = tcm_vehiculo_modelo.id_vehiculo_modelo
					INNER JOIN tcm_fuente_fondo ON tcm_vehiculo.id_fuente_fondo = tcm_fuente_fondo.id_fuente_fondo AND tcm_requisicion.id_fuente_fondo = tcm_fuente_fondo.id_fuente_fondo
					WHERE tcm_requisicion_vale.cantidad_restante>0 AND ".$where." 
					GROUP BY tcm_vehiculo.id_vehiculo, tcm_vehiculo.placa, tcm_fuente_fondo.nombre_fuente_fondo, marca, tcm_vehiculo_modelo.modelo, tcm_vale.valor_nominal
					ORDER BY tcm_vehiculo.placa DESC";*/
		$sentencia="SELECT tcm_vehiculo.id_vehiculo, tcm_vehiculo.placa, tcm_fuente_fondo.nombre_fuente_fondo, tcm_vehiculo_marca.nombre as marca, tcm_vehiculo_modelo.modelo, CAST(GROUP_CONCAT(tcm_requisicion_vale.id_requisicion_vale) AS CHAR) AS id_requisicion_vale, CAST(GROUP_CONCAT(tcm_vale.valor_nominal) AS CHAR) AS valor_nominal2, CAST(GROUP_CONCAT(DISTINCT tcm_vale.valor_nominal) AS CHAR) AS valor_nominal
					FROM tcm_vehiculo
					INNER JOIN tcm_req_veh ON tcm_req_veh.id_vehiculo = tcm_vehiculo.id_vehiculo
					INNER JOIN tcm_requisicion ON tcm_req_veh.id_requisicion = tcm_requisicion.id_requisicion
					INNER JOIN tcm_requisicion_vale ON tcm_requisicion_vale.id_requisicion = tcm_requisicion.id_requisicion
					INNER JOIN tcm_vale ON tcm_requisicion_vale.id_vale = tcm_vale.id_vale
					INNER JOIN tcm_vehiculo_marca ON tcm_vehiculo.id_marca = tcm_vehiculo_marca.id_vehiculo_marca
					INNER JOIN tcm_vehiculo_modelo ON tcm_vehiculo.id_modelo = tcm_vehiculo_modelo.id_vehiculo_modelo
					INNER JOIN tcm_fuente_fondo ON tcm_vehiculo.id_fuente_fondo = tcm_fuente_fondo.id_fuente_fondo
					WHERE tcm_requisicion_vale.cantidad_restante>0 AND ".$where." 
					GROUP BY tcm_vehiculo.id_vehiculo, tcm_vehiculo.placa, tcm_fuente_fondo.nombre_fuente_fondo, marca, tcm_vehiculo_modelo.modelo
					ORDER BY tcm_vehiculo.placa DESC";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();		
	}

	function guardar_factura($formuInfo)
	{
		extract($formuInfo);
		$sentencia="INSERT INTO tcm_consumo 
					(fecha_factura, numero_factura, valor_super, valor_regular, valor_diesel, id_usuario_crea, fecha_creacion) VALUES 
					('$fecha_factura', '$numero_factura','$valor_super','$valor_regular', $valor_diesel, $id_usuario_crea, CONCAT_WS(' ', CURDATE(),CURTIME()))";
		$this->db->query($sentencia);
		return $this->db->insert_id();
	}
	
	function buscar_requisicion_vale($formuInfo)
	{
		extract($formuInfo);
		$sentencia="SELECT tcm_requisicion_vale.id_requisicion_vale, (tcm_requisicion_vale.cantidad_entregado-tcm_requisicion_vale.cantidad_restante+1) AS inicial, tcm_requisicion_vale.cantidad_restante
					FROM tcm_requisicion
					INNER JOIN tcm_requisicion_vale ON tcm_requisicion_vale.id_requisicion = tcm_requisicion.id_requisicion
					INNER JOIN tcm_vale ON tcm_requisicion_vale.id_vale = tcm_vale.id_vale
					WHERE tcm_requisicion_vale.cantidad_restante>0 AND tcm_vale.id_gasolinera=".$id_gasolinera;
		$query=$this->db->query($sentencia);
		$res=(array)$query->result_array();
		foreach($res as $r) {
			if($cantidad>0) {
				if($r[cantidad_restante]>=$cantidad) {
					$sentencia="UPDATE tcm_requisicion_vale SET cantidad_restante=cantidad_restante-".$cantidad." WHERE id_requisicion_vale=".$r[id_requisicion_vale];
					$cantidad_entregado=$cantidad;
					$cantidad=0;
				}
				else {
					$sentencia="UPDATE tcm_requisicion_vale SET cantidad_restante=0 WHERE id_requisicion_vale=".$r[id_requisicion_vale];
					$cantidad_entregado=$r[cantidad_restante];
					$cantidad=$cantidad-$r[cantidad_restante];
				}	
				$query=$this->db->query($sentencia);
				
				$sentencia="INSERT INTO tcm_consumo_vehiculo (id_consumo, id_vehiculo, actividad, tip_gas, cantidad_vales, inicial, recibido) VALUES (".$id_consumo.", ".$id_vehiculo.", '".$actividad_consumo."', '".$tip_gas."', ".$cantidad_entregado.", ".$r[inicial].", ".$recibido.")";
				$query=$this->db->query($sentencia);
			}
		}
		/*if($cantidad>0)
			echo "No se entregaron todos los vales solicitados. Faltaron ".$cantidad." vales";
		else
			echo "Se entregaron todos los vales solicitados";*/
		
		/*return (array)$query->row();*/
	}
	
	function guardar_consumo($formuInfo)
	{
		extract($formuInfo);
		$sentencia="INSERT INTO tcm_consumo 
					(fecha_factura, numero_factura, valor_super, valor_regular, valor_diesel, id_usuario_crea, fecha_creacion) VALUES 
					('$fecha_factura', '$numero_factura','$valor_super','$valor_regular', $valor_diesel, $id_usuario_crea, CONCAT_WS(' ', CURDATE(),CURTIME()))";
		$this->db->query($sentencia);
		return $this->db->insert_id();
	}
}	
?>