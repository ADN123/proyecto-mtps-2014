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


	function verificarRepetidos($inicial=0, $final=0)
{
        $query=$this->db->query("SET @x1 := ".$inicial.";");
        $query=$this->db->query("SET @x2 := ".$final.";");
        $q="SELECT
                        *
                FROM
                        tcm_vale
                WHERE
                        (
                                (@x1 >= inicial AND @x1 <= final)
                                OR (@x2 >= inicial AND @x2 <= final)
                        ) AND DATE_ADD( fecha_creacion, INTERVAL 1 YEAR)  > CURDATE()";


                        $query=$this->db->query($q);
                        return $query->result_array();

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
	
 function simular_buscar_requisicion_vale($formuInfo)
        {
                extract($formuInfo);
                        
                $sentencia="SELECT tcm_requisicion_vale.id_requisicion_vale,
                                         (
                                                tcm_requisicion_vale.cantidad_entregado - tcm_requisicion_vale.cantidad_restante + tcm_requisicion_vale.numero_inicial
                                        ) AS inicial,
                                         tcm_requisicion_vale.cantidad_restante,
                                        tcm_vale.tipo_vehiculo as fuente, 
                                        $bandera as bandera, 
                                        f.nombre_fuente_fondo as nfuente
                                        FROM
                                                        tcm_requisicion
                                                INNER JOIN tcm_requisicion_vale ON tcm_requisicion_vale.id_requisicion = tcm_requisicion.id_requisicion
                                                INNER JOIN tcm_vale ON tcm_requisicion_vale.id_vale = tcm_vale.id_vale
                                                INNER JOIN tcm_fuente_fondo f ON f.id_fuente_fondo= tcm_vale.tipo_vehiculo 
                                                WHERE
                                                        tcm_requisicion_vale.cantidad_restante > 0
                                                AND tcm_vale.id_gasolinera = $id_gasolinera
                                                AND id_seccion = $id_seccion  
                                        ORDER BY tcm_vale.fecha_recibido ASC";                                  

                $query=$this->db->query($sentencia);
                return $query->result_array();

        }

	
	function consultar_oficinas($id_seccion=NULL)
	{
		if($id_seccion!=NULL){
			$where.= "	WHERE s.id_seccion = '".$id_seccion."'";
		}

		$sentencia="SELECT DISTINCT * FROM (
					SELECT 	s.id_seccion,s.nombre_seccion
										FROM 	org_seccion s
									INNER JOIN tcm_vehiculo v ON s.id_seccion = v.id_seccion_vale
									".$where."
					GROUP BY s.id_seccion
					UNION 
					SELECT 	s.id_seccion,s.nombre_seccion
							FROM 	org_seccion s
						INNER JOIN tcm_herramienta v ON s.id_seccion = v.id_seccion_vale
						".$where."
					GROUP BY s.id_seccion
					) as x ; ";

		$query=$this->db->query($sentencia);	
		return (array)$query->result_array();

	}
		function consultar_oficinas_fuente($id_fuente_fondo =NULL)
	{
		$where ="";
		if($id_fuente_fondo!=NULL){
			$where.= "	WHERE sa.id_fuente_fondo =".$id_fuente_fondo;
		}						
		$sentencia="SELECT 	s.id_seccion,s.nombre_seccion
					FROM 	org_seccion s
				INNER JOIN tcm_seccion_asignacion sa ON sa.id_seccion= s.id_seccion
				".$where."
				 GROUP BY s.id_seccion";
//print($query);
		$query=$this->db->query($sentencia);	
		return (array)$query->result_array();

	}

	function consultar_oficinas_san_salvador()
	{

		$sentencia="SELECT 	s.id_seccion,s.nombre_seccion
									FROM 	org_seccion s
									INNER JOIN tcm_vehiculo v ON s.id_seccion = v.id_seccion_vale			
					WHERE 	s.id_seccion NOT BETWEEN 52 AND 66
									 GROUP BY s.id_seccion";

		$query=$this->db->query($sentencia);	
		return (array)$query->result_array();

	}
		function consultar_todas_oficinas()
	{

		$sentencia="SELECT 	s.id_seccion,s.nombre_seccion
									FROM 	org_seccion s ";

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
				$sentencia.= "	WHERE v.id_seccion_vale = '".$id_seccion."'";
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
			$sentencia.="	ORDER BY placa";
		$query=$this->db->query($sentencia);
		
		return (array)$query->result_array();
	
	}

	function otros($id_seccion=NULL, $id_fuente_fondo= NULL)	
	{	
		$whereb=FALSE;

		$sentencia="SELECT  id_herramienta, nombre, descripcion, id_seccion_vale FROM tcm_herramienta v ";

			if($id_seccion!=NULL){
				$sentencia.= "	WHERE v.id_seccion_vale = '".$id_seccion."'";
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
			$sentencia.="	ORDER BY nombre";
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
		( fecha , id_seccion, cantidad_solicitada,id_empleado_solicitante,id_fuente_fondo,justificacion , id_usuario_crea, fecha_creacion, refuerzo, mes, asignado, restante_anterior) 
VALUES ( CONCAT_WS(' ', CURDATE(),CURTIME()), '$id_seccion','$cantidad_solicitada','$id_empleado_solicitante', $id_fuente_fondo, '$justificacion', $id_usuario,  CONCAT_WS(' ', CURDATE(),CURTIME()), $refuerzo, $mes, $asignado,$restante)";
		

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
		
	public function guardar_req_veh($id_vehiculo=NULL,$id_herramienta=NULL, $id_requisicion)
	{
		$sql="INSERT INTO tcm_req_veh VALUES('".$id_requisicion."',".$id_vehiculo.",".$id_herramienta.");";

		if ($id_herramienta==NULL) {
			$sql="INSERT INTO tcm_req_veh VALUES('".$id_requisicion."',".$id_vehiculo.",NULL);";

		}else{
			if ($id_vehiculo==NULL) {
			$sql="INSERT INTO tcm_req_veh VALUES('".$id_requisicion."',NULL,".$id_herramienta.");";
			}
		}


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
	
	public function es_san_salvador($id_seccion)
	{	
		$secciones=array(52,53,54,55,56,57,58,59,60,61,64,65,66);
		if(in_array($id_seccion,$secciones)){
			return false;
		}else{
			return true;
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
				DATE_FORMAT(fecha_creacion,'%d/%m/%Y %h:%i %p') as fecha,
				ff.id_fuente_fondo as id_fuente_fondo,
				ff.nombre_fuente_fondo as fuente_fondo,
				r.cantidad_entregado,
				r.cantidad_solicitada,
				justificacion,
				LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido,e.segundo_apellido,e.apellido_casada)) AS nombre,
				DATE_FORMAT(fecha_visto_bueno,'%d/%m/%Y %h:%i %p') as fecha_visto_bueno,			
				LOWER(CONCAT_WS(' ',e2.primer_nombre, e2.segundo_nombre, e2.tercer_nombre, e2.primer_apellido,e2.segundo_apellido,e2.apellido_casada)) AS visto_bueno,
				DATE_FORMAT(fecha_entregado,'%d/%m/%Y %h:%i %p') as fecha_entregado,			
				LOWER(CONCAT_WS(' ',e3.primer_nombre, e3.segundo_nombre, e3.tercer_nombre, e3.primer_apellido,e3.segundo_apellido,e3.apellido_casada)) AS entrego,
				
				estado, refuerzo, correlativo


				FROM
					tcm_requisicion r
				INNER JOIN org_seccion sr ON r.id_seccion = sr.id_seccion
				LEFT JOIN sir_empleado e ON r.id_empleado_solicitante= e.id_empleado
				LEFT JOIN sir_empleado e2 ON r.id_empleado_vistobueno = e2.id_empleado
				LEFT JOIN sir_empleado e3 ON r.id_empledo_entrega = e3.id_empleado
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

	
	$q="UPDATE tcm_requisicion SET
					id_empleado_vistobueno = ".$id_empleado.",
					fecha_visto_bueno = CONCAT_WS(' ',CURDATE(),CURTIME()),
					fecha_modificacion = CONCAT_WS(' ',CURDATE(),CURTIME()),
					id_usuario_modifica = ".$id_usuario.",
					estado = ".$resp.",
					observaciones = '".$observacion."',
					cantidad_entregado = ".$asignar."
					WHERE id_requisicion = ".$ids;

		
					$this->db->query($q);

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
	
	function buscar_vales($id_requisicion,$id_fuente_fondo, $cantidad)
	{

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
				
				$sentencia="INSERT INTO tcm_requisicion_vale (id_vale, id_requisicion, cantidad_entregado, numero_inicial, cantidad_restante)
				 VALUES (".$r[id_vale].", ".$id_requisicion.", ".$cantidad_entregado.", ".$r[inicial].", ".$cantidad_entregado.")";
				$query=$this->db->query($sentencia);
			}
		}
		/*if($cantidad>0)
			echo "No se entregaron todos los vales solicitados. Faltaron ".$cantidad." vales";
		else
			echo "Se entregaron todos los vales solicitados";*/
	}

	function vales_entregados($id_requisicion)
	{
		$sentencia="SELECT
						numero_inicial AS inicial,
						numero_inicial + cantidad_entregado -1 AS final,
						cantidad_restante as restante
					FROM
						tcm_requisicion_vale
					WHERE
						id_requisicion= ".$id_requisicion;
		$query=$this->db->query($sentencia);
		return 	$query->result_array();		
	}

	function vales_a_entregar($id)
	{	

		$sentencia="SELECT cantidad_entregado, id_fuente_fondo FROM tcm_requisicion WHERE id_requisicion = ".$id;
		$query=$this->db->query($sentencia);
		$res=(array)$query->result_array();
		
		foreach($res as $r) {
		$cantidad=$r['cantidad_entregado'];
		$id_fuente_fondo=$r['id_fuente_fondo'];
			}

		$sentencia="SELECT id_vale, (final-cantidad_restante+1) AS inicial, cantidad_restante FROM tcm_vale WHERE tipo_vehiculo='".$id_fuente_fondo."' AND cantidad_restante>0 ORDER BY fecha_recibido, id_vale";
		$query=$this->db->query($sentencia);
		$res=(array)$query->result_array();


		$pila =  array();

		foreach($res as $r) {
			if($cantidad>0) {
				if($r[cantidad_restante]>=$cantidad) {
					
					$cantidad_entregado=$cantidad;
					$cantidad=0;
				}
				else {
					
					$cantidad_entregado=$r[cantidad_restante];
					$cantidad=$cantidad-$r[cantidad_restante];
				}	

				$fila=array('inicial' => $r[inicial],
							'final'=>$r[inicial]+$cantidad_entregado-1,
							'restante'=>$r[cantidad_restante]-$cantidad_entregado
						);
				

				
				array_push($pila,$fila);
	

			}
		
		}
		//echo "<pre>";print_r($pila); echo "</pre>";
		return $pila;
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


	function req_info_pdf($id_requisicion)
	{
		$query=$this->db->query("
		SELECT id_requisicion, DATE_FORMAT(r.fecha,'%d-%m-%Y') as fecha,
		o.nombre_seccion as seccion,
		r.cantidad_solicitada,
		LOWER(CONCAT_WS(' ',e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre,
		r.justificacion, r.cantidad_entregado,
		r.numero_inicial, r.cantidad_restante
		FROM tcm_requisicion AS r
		LEFT JOIN org_seccion AS o ON o.id_seccion=r.id_seccion
		LEFT JOIN sir_empleado AS e ON 
					(
					 e.id_empleado = r.id_empleado_solicitante AND
					 e.id_empleado = r.id_empleado_autoriza AND
					 e.id_empleado = r.id_empleado_recibe AND
					 e.id_empleado = r.id_empleado_vistobueno AND
					 e.id_empleado = r.id_empledo_entrega
					)
		WHERE r.id_requisicion='$id_requisicion'");
		return $query->result();
	}
	

	function consultar_vehiculos_seccion($id_seccion=NULL, $id_gasolinera=NULL, $fecha_factura=NULL)
	{
		if($id_seccion!=NULL)
			$where="tcm_requisicion.id_seccion=".$id_seccion;
		else
			$where="tcm_requisicion.id_seccion<>52 AND tcm_requisicion.id_seccion<>53 AND tcm_requisicion.id_seccion<>54 AND tcm_requisicion.id_seccion<>55 AND tcm_requisicion.id_seccion<>56 AND tcm_requisicion.id_seccion<>57 AND tcm_requisicion.id_seccion<>58 AND tcm_requisicion.id_seccion<>59 AND tcm_requisicion.id_seccion<>60 AND tcm_requisicion.id_seccion<>61 AND tcm_requisicion.id_seccion<>64 AND tcm_requisicion.id_seccion<>65 AND tcm_requisicion.id_seccion<>66";
		if($id_gasolinera!=NULL)
			$where.=" AND tcm_vale.id_gasolinera='".$id_gasolinera."'";

		if($fecha_factura!=NULL)// nuevo
			$where.=" AND tcm_requisicion.mes<='".$fecha_factura."'";
			//antiguo
			//$where.=" AND DATE_FORMAT(tcm_requisicion.fecha_visto_bueno,'%Y-%m-%d')<='".$fecha_factura."'";
/*
//sentencia original por Leonel
		$sentencia="SELECT tcm_vehiculo.id_vehiculo, tcm_vehiculo.placa, tcm_vehiculo.id_fuente_fondo, tcm_fuente_fondo.nombre_fuente_fondo, tcm_vehiculo_marca.nombre as marca, tcm_vehiculo_modelo.modelo, CAST(GROUP_CONCAT(tcm_requisicion_vale.id_requisicion_vale) AS CHAR) AS id_requisicion_vale, CAST(GROUP_CONCAT(tcm_vale.valor_nominal) AS CHAR) AS valor_nominal2, CAST(GROUP_CONCAT(DISTINCT tcm_vale.valor_nominal) AS CHAR) AS valor_nominal
					FROM tcm_vehiculo
					INNER JOIN tcm_req_veh ON tcm_req_veh.id_vehiculo = tcm_vehiculo.id_vehiculo
					INNER JOIN tcm_requisicion ON tcm_req_veh.id_requisicion = tcm_requisicion.id_requisicion
					INNER JOIN tcm_requisicion_vale ON tcm_requisicion_vale.id_requisicion = tcm_requisicion.id_requisicion
					INNER JOIN tcm_vale ON tcm_requisicion_vale.id_vale = tcm_vale.id_vale
					INNER JOIN tcm_vehiculo_marca ON tcm_vehiculo.id_marca = tcm_vehiculo_marca.id_vehiculo_marca
					INNER JOIN tcm_vehiculo_modelo ON tcm_vehiculo.id_modelo = tcm_vehiculo_modelo.id_vehiculo_modelo
					INNER JOIN tcm_fuente_fondo ON tcm_vehiculo.id_fuente_fondo = tcm_fuente_fondo.id_fuente_fondo
					WHERE tcm_requisicion_vale.cantidad_restante>0 AND ".$where." 
					GROUP BY tcm_vehiculo.id_vehiculo, tcm_vehiculo.placa, tcm_vehiculo.id_fuente_fondo, tcm_fuente_fondo.nombre_fuente_fondo, marca, tcm_vehiculo_modelo.modelo
					ORDER BY tcm_vehiculo.placa DESC";
*/
// Modificacion por Jhonatan


			$sentencia="SELECT 
							tcm_vehiculo.id_vehiculo, 
							0 as id_herramienta,
							0 as herramienta, 
							tcm_vehiculo.placa, 
							tcm_vehiculo.id_fuente_fondo, 
							tcm_fuente_fondo.nombre_fuente_fondo, 
							tcm_vehiculo_marca.nombre as marca, 
							tcm_vehiculo_modelo.modelo, 
							'' as  descripcion,
							CAST(GROUP_CONCAT(tcm_requisicion_vale.id_requisicion_vale) AS CHAR) AS id_requisicion_vale, 
							CAST(GROUP_CONCAT(tcm_vale.valor_nominal) AS CHAR) AS valor_nominal2,
							CAST(GROUP_CONCAT(DISTINCT tcm_vale.valor_nominal) AS CHAR) AS valor_nominal,
							tcm_vehiculo.tipo_combustible as combustible
						FROM tcm_vehiculo
						INNER JOIN tcm_req_veh ON tcm_req_veh.id_vehiculo = tcm_vehiculo.id_vehiculo
						INNER JOIN tcm_requisicion ON tcm_req_veh.id_requisicion = tcm_requisicion.id_requisicion
						INNER JOIN tcm_requisicion_vale ON tcm_requisicion_vale.id_requisicion = tcm_requisicion.id_requisicion
						INNER JOIN tcm_vale ON tcm_requisicion_vale.id_vale = tcm_vale.id_vale
						INNER JOIN tcm_vehiculo_marca ON tcm_vehiculo.id_marca = tcm_vehiculo_marca.id_vehiculo_marca
						INNER JOIN tcm_vehiculo_modelo ON tcm_vehiculo.id_modelo = tcm_vehiculo_modelo.id_vehiculo_modelo
						INNER JOIN tcm_fuente_fondo ON tcm_vehiculo.id_fuente_fondo = tcm_fuente_fondo.id_fuente_fondo
						WHERE tcm_requisicion_vale.cantidad_restante>0 AND ".$where." 
						GROUP BY tcm_vehiculo.id_vehiculo, tcm_vehiculo.placa, tcm_vehiculo.id_fuente_fondo, tcm_fuente_fondo.nombre_fuente_fondo, marca, tcm_vehiculo_modelo.modelo
					
					UNION
						SELECT
							0 as id_vehiculo,
							h.id_herramienta,
							h.nombre as herramienta, 
							'' as placa,
							h.id_fuente_fondo,
							f.nombre_fuente_fondo,
							''  AS marca,
							'' AS modelo,
							h.descripcion, 
							CAST(GROUP_CONCAT(tcm_requisicion_vale.id_requisicion_vale) AS CHAR	) AS id_requisicion_vale,
							CAST(	GROUP_CONCAT(tcm_vale.valor_nominal) AS CHAR) AS valor_nominal2,
							CAST(		GROUP_CONCAT(	DISTINCT tcm_vale.valor_nominal) AS CHAR) AS valor_nominal,
								h.combustible
						FROM
							tcm_herramienta h
						INNER JOIN tcm_req_veh ON tcm_req_veh.id_herramienta = h.id_herramienta
						INNER JOIN tcm_requisicion ON tcm_req_veh.id_requisicion = tcm_requisicion.id_requisicion
						INNER JOIN tcm_requisicion_vale ON tcm_requisicion_vale.id_requisicion = tcm_requisicion.id_requisicion
						INNER JOIN tcm_vale ON tcm_requisicion_vale.id_vale = tcm_vale.id_vale
						INNER JOIN tcm_fuente_fondo f ON h.id_fuente_fondo = f.id_fuente_fondo
						WHERE tcm_requisicion_vale.cantidad_restante>0 AND ".$where."

						GROUP BY
							h.id_herramienta,
							h.id_fuente_fondo,
							f.nombre_fuente_fondo
					";

		$query=$this->db->query($sentencia);
		return (array)$query->result_array();	
	}

	function consultar_vales_seccion($id_seccion=NULL, $id_gasolinera=NULL, $fecha_factura=NULL)
	{
		if($id_seccion!=NULL)
			$where="tcm_requisicion.id_seccion=".$id_seccion;
		else
			$where="tcm_requisicion.id_seccion<>52 AND tcm_requisicion.id_seccion<>53 AND tcm_requisicion.id_seccion<>54 AND tcm_requisicion.id_seccion<>55 AND tcm_requisicion.id_seccion<>56 AND tcm_requisicion.id_seccion<>57 AND tcm_requisicion.id_seccion<>58 AND tcm_requisicion.id_seccion<>59 AND tcm_requisicion.id_seccion<>60 AND tcm_requisicion.id_seccion<>61 AND tcm_requisicion.id_seccion<>64 AND tcm_requisicion.id_seccion<>65 AND tcm_requisicion.id_seccion<>66";
		
		if($id_gasolinera!=NULL)
			$where.=" AND tcm_vale.id_gasolinera='".$id_gasolinera."'";
		
		if($fecha_factura!=NULL)
			//antiguo  modificar tambiem funcion consultar_vehiculos_seccion
			//$where.=" AND DATE_FORMAT(tcm_requisicion.fecha_visto_bueno,'%Y-%m-%d')<='".$fecha_factura."'";
			//nuevo
			$where.=" AND tcm_requisicion.mes<='".$fecha_factura."'";
			
		$sentencia="SELECT
					tcm_requisicion.id_fuente_fondo,
					tcm_fuente_fondo.nombre_fuente_fondo,
					Sum(tcm_requisicion_vale.cantidad_restante) AS total
					FROM tcm_vale
					INNER JOIN tcm_requisicion_vale ON tcm_requisicion_vale.id_vale = tcm_vale.id_vale
					INNER JOIN tcm_requisicion ON tcm_requisicion_vale.id_requisicion = tcm_requisicion.id_requisicion
					INNER JOIN tcm_fuente_fondo ON tcm_requisicion.id_fuente_fondo = tcm_fuente_fondo.id_fuente_fondo
					WHERE tcm_requisicion_vale.cantidad_restante>0 AND ".$where." 
					GROUP BY tcm_requisicion.id_fuente_fondo";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();	
	}

	function asignaciones($id_seccion=NULL,$id_fuente_fondo=NULL)
	{
		$where=" ";
		if($id_seccion !=NULL && $id_fuente_fondo!=NULL){
			
			$where.="WHERE  a.id_seccion = ".$id_seccion." AND a.id_fuente_fondo = ".$id_fuente_fondo; 
			

		}

		$sentencia ="SELECT
			a.id_seccion, a.id_fuente_fondo, nombre_seccion as seccion, f.nombre_fuente_fondo as fuente , cantidad
			FROM
				tcm_seccion_asignacion a
			INNER JOIN tcm_fuente_fondo f ON a.id_fuente_fondo = f.id_fuente_fondo
			INNER JOIN org_seccion s ON a.id_seccion = s.id_seccion".$where;

		$query=$this->db->query($sentencia);
		return (array)$query->result_array();		
	}

	function modificar_asignaciones($post)
	{extract($post);
		$q="UPDATE tcm_seccion_asignacion SET cantidad = ".$cantidad."
		WHERE id_seccion = ".$id_seccion." AND id_fuente_fondo = ".$id_fuente_fondo;
		$this->db->query($q);
	}
	function insertar_asignaciones($post)
	{extract($post);
		$q="INSERT INTO tcm_seccion_asignacion(id_seccion,id_fuente_fondo, cantidad ) 
		VALUES (".$id_seccion.",".$id_fuente_fondo.",".$cantidad.")";
		$this->db->query($q);
	}
	function eliminar_asignaciones($id_seccion, $id_fuente_fondo)
	{
		$q="DELETE FROM tcm_seccion_asignacion 
			WHERE id_seccion = ".$id_seccion." AND id_fuente_fondo =".$id_fuente_fondo;
		$this->db->query($q);
	}
	function consultar_consumo($id_seccion, $id_fuente_fondo)
	{
		$q="SELECT
			COALESCE(SUM(cantidad_restante), 0) suma 	
			FROM
				tcm_requisicion r
			INNER JOIN tcm_requisicion_vale v ON r.id_requisicion = v.id_requisicion
			WHERE id_seccion = ".$id_seccion." AND id_fuente_fondo =".$id_fuente_fondo;
		$query=$this->db->query($q);
		return $query->result_array();
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
		
		$where="AND id_seccion=".$id_seccion;

		/*
/Note by Jhonatan: Leo habia hecho esto, supongo que era por lo de niveles, 
pero eso ocasiono problemas de revueltijo de vales, 
por lo tanto la logica de niveles se manejara de forma diferente

		if(!$this->es_san_salvador($id_seccion))
			$where="AND id_seccion=".$id_seccion; 
		else
			$where="AND id_seccion<>52 AND id_seccion<>53 AND id_seccion<>54 AND id_seccion<>55 AND id_seccion<>56 AND id_seccion<>57 AND id_seccion<>58 AND id_seccion<>59 AND id_seccion<>60 AND id_seccion<>61 AND id_seccion<>64 AND id_seccion<>65 AND id_seccion<>66";
		*/
		if($bandera==1)
			$where.=" AND tcm_vale.tipo_vehiculo=".$tipo_vehiculo;
			
		$sentencia="SELECT tcm_requisicion_vale.id_requisicion_vale, (tcm_requisicion_vale.cantidad_entregado-tcm_requisicion_vale.cantidad_restante+tcm_requisicion_vale.numero_inicial) AS inicial, tcm_requisicion_vale.cantidad_restante
					FROM tcm_requisicion
					INNER JOIN tcm_requisicion_vale ON tcm_requisicion_vale.id_requisicion = tcm_requisicion.id_requisicion
					INNER JOIN tcm_vale ON tcm_requisicion_vale.id_vale = tcm_vale.id_vale
					WHERE tcm_requisicion_vale.cantidad_restante>0 AND tcm_vale.id_gasolinera=".$id_gasolinera." ".$where. " ORDER BY tcm_vale.fecha_recibido ASC";
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
				
				if ($id_vehiculo==0) {	$id_vehiculo="NULL";	}
				if ($id_herramienta==0) {	$id_herramienta="NULL";	}
				$sentencia="INSERT INTO tcm_consumo_vehiculo (id_consumo, id_vehiculo,id_herramienta, actividad, tip_gas, cantidad_vales, inicial, recibido) VALUES (".$id_consumo.", ".$id_vehiculo.",".$id_herramienta.", '".$actividad_consumo."', '".$tip_gas."', ".$cantidad_entregado.", ".$r[inicial].", ".$recibido.")";
				$query=$this->db->query($sentencia);
				
				$id_consumo_vehiculo=$this->db->insert_id();
				$sentencia="INSERT INTO tcm_requisicion_vale_consumo_vehiculo (id_requisicion_vale, id_consumo_vehiculo) VALUES (".$r[id_requisicion_vale].", ".$id_consumo_vehiculo.")";
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
	function info_requisicion_vales($id)
	{
	$query=$this->db->query("SELECT
						id_requisicion_vale,
						numero_inicial,
						(numero_inicial + cantidad_entregado - 1 ) AS numero_final
					FROM
						tcm_requisicion_vale
					WHERE id_requisicion=".$id);
			return $query->result();

	}
	function info_correlativo()
	{
	$query=$this->db->query(" SELECT
	COUNT(id_requisicion) + 1 AS correlativo
			FROM
				tcm_requisicion r
			WHERE
				YEAR (r.fecha_entregado) = YEAR (CURDATE())");
						return $query->result();

	}
	function guardar_entrega($post)
	{
		extract($post);
	
		$q="UPDATE tcm_requisicion
			SET 
			 correlativo = ".$correlativo.",
			 fecha_entregado = CONCAT_WS(' ', CURDATE(), CURTIME()),
			id_empledo_entrega = ".$id_empleado.", 
			id_usuario_modifica = ".$id_usuario.",
			 estado = 3
			WHERE
				id_requisicion = ".$ids;
				$this->db->query($q);
	
	}	
	function consumo_seccion_fuente($id_seccion='', $id_fuente_fondo="", $fecha_inicio=NULL, $fecha_fin=NULL, $agrupar=NULL)
	{
	/*		$q="SELECT
					s.nombre_seccion as seccion,
					SUM(rv.cantidad_entregado - rv.cantidad_restante ) AS consumido,
					sa.cantidad as asignado
				FROM
					tcm_requisicion r
				INNER JOIN tcm_requisicion_vale rv ON r.id_requisicion = rv.id_requisicion
				INNER JOIN org_seccion s ON r.id_seccion = s.id_seccion
				INNER JOIN tcm_seccion_asignacion sa ON (s.id_seccion = sa.id_seccion AND r.id_fuente_fondo= sa.id_fuente_fondo)
				GROUP BY r.id_seccion "; */

				$fechaF=" DATE_FORMAT(DATE(fecha_factura),'%Y-%m') = DATE_FORMAT(CURDATE(),'%Y-%m')	";
				$fuenteF="";
				$seccionF="";
				if($fecha_inicio !=NULL && $fecha_fin!=NULL){

					$fechaF="  fecha_factura  BETWEEN DATE('".$fecha_inicio."') AND DATE('".$fecha_fin."')";
				}
				if($id_seccion!=NULL){

					$seccionF=" AND r.id_seccion = ".$id_seccion;
				}
				if($id_fuente_fondo!=NULL){

					$fuenteF=" AND r.id_fuente_fondo = ".$id_fuente_fondo;
				}

				if($agrupar==NULL || $agrupar==2){ //por mes
	
					$selecM="	CONCAT( s.nombre_seccion, ' <br>', f.nombre_fuente_fondo, ' - ',DATE_FORMAT(DATE( CONCAT_WS('-',LEFT(x.mes,4),RIGHT(x.mes,2),'01')),'%M %Y'))  as seccion,";
					$mes ="r.mes";

				}else{ // por año
					$selecM="	CONCAT( s.nombre_seccion, ' <br>', f.nombre_fuente_fondo, '-', x.mes) as seccion,";
					$mes="LEFT(r.mes,4)";

				}

				$where= $fechaF.$seccionF.$fuenteF;
			$query=$this->db->query(" SET lc_time_names = 'es_ES'");		
			$query=$this->db->query(" SET @row_number:=0;");
			$q="SELECT
					@row_number:=@row_number+1 AS row_number, 
					r.id_seccion, 
							".$selecM."
					x.asignado asignado,
					SUM( cv.cantidad_vales) consumido, 
					SUM(cv.cantidad_vales) * v.valor_nominal as  dinero, 
					fecha_factura
				FROM
					tcm_consumo_vehiculo cv
				INNER JOIN tcm_consumo c ON c.id_consumo = cv.id_consumo
				INNER JOIN tcm_requisicion_vale_consumo_vehiculo rvcv ON rvcv.id_consumo_vehiculo = cv.id_consumo_vehiculo
				INNER JOIN tcm_requisicion_vale rv ON rv.id_requisicion_vale = rvcv.id_requisicion_vale
				INNER JOIN tcm_requisicion r ON r.id_requisicion = rv.id_requisicion
				INNER JOIN org_seccion s ON s.id_seccion= r.id_seccion
				INNER JOIN tcm_vale v ON v.id_vale  = rv.id_vale
				INNER JOIN tcm_fuente_fondo f ON f.id_fuente_fondo = r.id_fuente_fondo 
				LEFT  JOIN (	SELECT
						SUM(asignado) asignado,
						id_seccion, 
						".$mes." as mes
					FROM
						tcm_requisicion r
					GROUP BY
						id_seccion,
						".$mes." ) as x ON r.id_seccion = x.id_seccion AND ".$mes." = x.mes
				WHERE ".$where."	
				 GROUP BY r.id_seccion, ".$mes;

			$query=$this->db->query($q);

			return $query->result();

	}
	function meses_requisicion()
	{

		$query=$this->db->query(" SET lc_time_names = 'es_ES'");		

		$q="SELECT DATE_FORMAT(DATE_ADD( CURDATE(), INTERVAL -40 DAY),'%M') mes_nombre, DATE_FORMAT(DATE_ADD( CURDATE(), INTERVAL -20 DAY),'%Y%m') mes 
				UNION
			SELECT DATE_FORMAT(CURDATE(),'%M') mes_nombre, DATE_FORMAT(CURDATE(),'%Y%m') mes
			UNION
			SELECT DATE_FORMAT(DATE_ADD( CURDATE(), INTERVAL 7 DAY),'%M') mes_nombre, DATE_FORMAT(DATE_ADD( CURDATE(), INTERVAL 7 DAY),'%Y%m') mes 

		";
		$query=$this->db->query($q);		
		return $query->result_array();

	}
	function consultar_refuerzo($id_seccion, $id_fuente_fondo, $mes)
	{		$q="SELECT COUNT(mes)  as num FROM tcm_requisicion WHERE id_fuente_fondo = ".$id_fuente_fondo." AND id_seccion = ".$id_seccion." AND mes LIKE '".$mes."'";
			$query=$this->db->query($q);		
			return $query->result();
	}

	function vales_sin_entregar()
	{
		
				$q="SELECT 	v.id_vale,
							valor_nominal valor, 
							inicial, 
							final, 
							cantidad_restante restante, 
							f.nombre_fuente_fondo fuente, 
							g.nombre  gasolinera,
							v.final - v.inicial + 1 as cant							
					 FROM tcm_vale v
					INNER JOIN tcm_fuente_fondo f ON f.id_fuente_fondo = v.tipo_vehiculo
					INNER JOIN tcm_gasolinera g ON g.id_gasolinera = v.id_gasolinera";
			$query=$this->db->query($q);		
			return $query->result_array();
	}
	function vales_de_seccion($id_seccion=NULL, $san_salvador=0)
	{

		if($id_seccion!=NULL){
			$where= " AND r.id_seccion = ".$id_seccion;			// para una seccion				
		}else{
			$select= " ,s.nombre_seccion as seccion";
			$inner= " INNER JOIN org_seccion s ON s.id_seccion = r.id_seccion";			
			if ($san_salvador==1) {
					$where= " AND (r.id_seccion NOT BETWEEN 52 AND 66  )";   // para san salvador				
			}else{
				//si no pide solo las de san salvador mostrara todo
			}    		
		}	

			$q="SELECT
					v.valor_nominal AS valor,
					rv.numero_inicial as inicial,
					rv.cantidad_restante as restante,
					rv.numero_inicial + rv.cantidad_entregado -1 AS final,
					f.nombre_fuente_fondo as fuente,
					g.nombre as gasolinera".$select."
				FROM
					tcm_requisicion_vale rv
				INNER JOIN tcm_vale v ON rv.id_vale = v.id_vale
				INNER JOIN tcm_fuente_fondo f ON f.id_fuente_fondo = v.tipo_vehiculo
				INNER JOIN tcm_gasolinera g ON g.id_gasolinera = v.id_gasolinera
				INNER JOIN tcm_requisicion r ON rv.id_requisicion = r.id_requisicion AND r.id_fuente_fondo = f.id_fuente_fondo ".$inner."
				WHERE
					rv.cantidad_restante > 0 ".$where;
				$q.=" ORDER BY inicial ASC";
				$query=$this->db->query($q);		
				return $query->result_array();
		
	}

	function vales_san_salvador()
	{
		return $this->vales_de_seccion(NULL,1);
	}

		function herramientas($id_seccion=NULL)
	{
		$where=" ";
		if($id_seccion !=NULL){
			
			$where.="WHERE  s.id_seccion = ".$id_seccion; 			

		}


		$sentencia ="SELECT
							h.id_herramienta,
							h.nombre, 
							f.nombre_fuente_fondo fuente,
							s.nombre_seccion seccion,
							h.combustible
						FROM
							tcm_herramienta h
						INNER JOIN tcm_fuente_fondo f ON h.id_fuente_fondo = f.id_fuente_fondo
						INNER JOIN org_seccion s ON s.id_seccion = h.id_seccion_vale ".$where;

		$query=$this->db->query($sentencia);
		return (array)$query->result_array();		
	}

	function modificar_herramienta($post)
	{extract($post);
		$q="UPDATE tcm_herramienta SET id_seccion_vale = ".$id_seccion.",
				id_fuente_fondo = ".$id_fuente_fondo.",
				descripcion = '".$descripcion."',
				combustible = '".$combustible."'
				nombre = '".$nombre."'
		WHERE id_herramienta = ".$id;
		$this->db->query($q);
	}
	function insertar_herramientas($post)
	{extract($post);
		$q='INSERT INTO tcm_herramienta (id_seccion_vale, id_fuente_fondo, descripcion, nombre, combustible) 
			VALUES('.$id_seccion.','.$id_fuente_fondo.',"'.$descripcion.'", "'.$nombre.'", "'.$combustible.'");';
		$this->db->query($q);
	}
	function eliminar_herramientas($id_seccion, $id_fuente_fondo)
	{
		$q="DELETE FROM tcm_seccion_asignacion 
			WHERE id_seccion = ".$id_seccion." AND id_fuente_fondo =".$id_fuente_fondo;
		$this->db->query($q);
	}

	function consultar_herramientas($id_herramienta=NULL)
	{

		$sentencia ="SELECT
							h.*, s.nombre_seccion AS seccion
						FROM
							tcm_herramienta h
						INNER JOIN org_seccion s ON h.id_seccion_vale = s.id_seccion
						WHERE  id_herramienta = ".$id_herramienta;
		$query=$this->db->query($sentencia);
		return (array)$query->result();		
	}
	function secciones_vales($san_salvador=false)
	{
		$where="";
		if($san_salvador){//todas de san salvador
			$where=" WHERE a.id_seccion NOT BETWEEN 52 AND 66 ";
		}

	$query="SELECT
				s.nombre_seccion AS seccion,
				s.id_seccion
			FROM
				tcm_seccion_asignacion a
			INNER JOIN org_seccion s ON a.id_seccion = s.id_seccion
				".$where."
			GROUP BY
				a.id_seccion
			ORDER BY a.id_seccion ";
		$query=$this->db->query($query);
		return (array)$query->result_array();		

	}

function consumo_seccion_fuente_d($id_seccion='', $id_fuente_fondo="", $fecha_inicio=NULL, $fecha_fin=NULL, $agrupar=NULL)
	{
//FILTROS
	
				$fechaF=" DATE_FORMAT(DATE(fecha_factura),'%Y-%m') = DATE_FORMAT(CURDATE(),'%Y-%m')	";
				$fuenteF="";
				$seccionF="";
				if($fecha_inicio !=NULL && $fecha_fin!=NULL){

					$fechaF="  fecha_factura  BETWEEN DATE('".$fecha_inicio."') AND DATE('".$fecha_fin."')";
				}
				if($id_seccion!=NULL){

					$seccionF=" AND r.id_seccion = ".$id_seccion;
				}
				if($id_fuente_fondo!=NULL){

					$fuenteF=" AND r.id_fuente_fondo = ".$id_fuente_fondo;
				}

///PREPARACION DE DATOS

				switch ($agrupar){
					case 1:
						
						$fecha=" DATE_FORMAT(c.fecha_factura,'%d-%m-%Y')	as fecha";
						$grup= " c.fecha_factura";
						break;
					case 2:
						$fecha=" DATE_FORMAT(c.fecha_factura,'%M') fecha ";
						$grup= " DATE_FORMAT(c.fecha_factura,'%Y%m')";
						break;
					case 3:
						$fecha=" DATE_FORMAT(c.fecha_factura,'%Y') fecha ";
						$grup= " DATE_FORMAT(c.fecha_factura,'%Y')";
						break;
					default:
						$fecha=" DATE_FORMAT(c.fecha_factura,'%d-%m-%Y')	as fecha";
						$grup= " c.fecha_factura";
						break;
				}


				$where= $fechaF.$seccionF.$fuenteF;
			$query=$this->db->query(" SET @row_number:=0;");
			$query=$this->db->query(" SET lc_time_names = 'es_ES'");		

			$q=" 		SELECT		@row_number:=@row_number+1 AS row_number, 
									r.id_seccion, 
									CONCAT( s.nombre_seccion, ' (', f.nombre_fuente_fondo, ' )') as seccion,
									SUM( cv.cantidad_vales) consumido, 
									SUM(cv.cantidad_vales) * v.valor_nominal as  dinero,
									".$fecha."				
								FROM
									tcm_consumo_vehiculo cv
								INNER JOIN tcm_consumo c ON c.id_consumo = cv.id_consumo
								INNER JOIN tcm_requisicion_vale_consumo_vehiculo rvcv ON rvcv.id_consumo_vehiculo = cv.id_consumo_vehiculo
								INNER JOIN tcm_requisicion_vale rv ON rv.id_requisicion_vale = rvcv.id_requisicion_vale
								INNER JOIN tcm_requisicion r ON r.id_requisicion = rv.id_requisicion
								INNER JOIN org_seccion s ON s.id_seccion= r.id_seccion
								INNER JOIN tcm_vale v ON v.id_vale  = rv.id_vale
								INNER JOIN tcm_fuente_fondo f ON f.id_fuente_fondo = r.id_fuente_fondo 
										WHERE ".$where."				
						GROUP BY ".$grup."
						ORDER BY c.fecha_factura";


			$query=$this->db->query($q);

			return $query->result();

	}	

		function consumo_vehiculo($id_seccion='', $id_fuente_fondo="", $fecha_inicio=NULL, $fecha_fin=NULL)
	{
				$fechaF1=" WHERE DATE_FORMAT(hora_entrada,'%Y-%m-%d') <= DATE_FORMAT(CURDATE(),'%Y-%m-%d') ";
				$fechaF2=" WHERE fecha_factura <CURDATE()  ";
				
				$fuenteF="";
				$seccionF="";
				
				if($fecha_inicio !=NULL && $fecha_fin!=NULL){
				

					$fechaF1=" WHERE DATE_FORMAT(hora_entrada,'%Y-%m-%d') BETWEEN DATE('".$fecha_inicio."') AND DATE('".$fecha_fin."')";
					$fechaF2=" WHERE fecha_factura BETWEEN DATE('".$fecha_inicio."') AND DATE('".$fecha_fin."')";
				}
				if($id_seccion!=NULL){

					$seccionF=" AND id_seccion_vale = ".$id_seccion; //solo al where 2
				}
				if($id_fuente_fondo!=NULL){

					$fuenteF=" AND id_fuente_fondo = ".$id_fuente_fondo;
				}

				$where1= $fechaF1;
				$where2= $fechaF2.$seccionF.$fuenteF;


			$query=$this->db->query(" SET @row_number:=0;");
			$q="SELECT *, 
						ROUND( COALESCE(glxv * vales / recorrido ,0), 2 )  as rendimiento 
						FROM (
										SELECT
											d.id_vehiculo, 
											d.modelo, 
											d.placa,
											d.marca,			
											SUM(cv.cantidad_vales) as vales,
											COALESCE(k.recor ,0) as recorrido, 
											vg.valor_gasolina, 
											vg.valor_nominal, 
											(vg.valor_nominal/valor_gasolina)as glxv			
										FROM
											tcm_consumo c
										INNER JOIN tcm_consumo_vehiculo cv ON cv.id_consumo = c.id_consumo
										INNER JOIN tcm_vehiculo_datos d ON d.id_vehiculo = cv.id_vehiculo
										LEFT  JOIN (
													SELECT id_vehiculo, SUM(km_final-km_inicial ) as recor FROM tcm_vehiculo_kilometraje 
													".$where1."			
													GROUP BY id_vehiculo ) AS K  ON k.id_vehiculo = d.id_vehiculo
										INNER JOIN tcm_consumo_vehiculo_valores vg ON cv.id_consumo_vehiculo = vg.id_consumo_vehiculo 
									".$where2."
								GROUP BY id_vehiculo
								) AS X";

			$query=$this->db->query($q);

			return $query->result();

	}

	function asignaciones_vehiculo()
	{
		$q="SELECT
				v.id_vehiculo,
				v.placa,
				COALESCE(s.nombre_seccion, '----NO TIENE ASIGNACION----')  AS seccion_vale,
				m.nombre as marca, 
				v.id_fuente_fondo, 
				f.nombre_fuente_fondo as fuente_fondo
			FROM
				tcm_vehiculo v
			LEFT  JOIN org_seccion s ON s.id_seccion = v.id_seccion_vale
			LEFT JOIN tcm_fuente_fondo f ON  f.id_fuente_fondo= v.id_fuente_fondo
			INNER JOIN tcm_vehiculo_marca m ON m.id_vehiculo_marca = v.id_marca ORDER BY s.nombre_seccion";

			$query=$this->db->query($q);

			return $query->result_array();
		
	}
	function consultar_datos_vehiculos($id_vehiculo= NULL)
	{
				$q="SELECT * FROM tcm_vehiculo_datos WHERE id_vehiculo = ".$id_vehiculo;

			$query=$this->db->query($q);

			return $query->result_array();
		

	}
	function seccion_asignada($datos)
	{
		extract($datos);
			$q="UPDATE tcm_vehiculo SET id_seccion_vale = ".$id_seccion.", tipo_combustible='".$combustible."' WHERE  id_vehiculo =".$id_vehiculo;
			$query=$this->db->query($q);
	}

	function detalleV($id_vale=NULL)
	{
		$q="SELECT
				rv.numero_inicial AS del,
				rv.numero_inicial + rv.cantidad_entregado - 1 AS al,
				s.nombre_seccion AS seccion,
				id_vale,
				rv.id_requisicion_vale,
				rv.cantidad_entregado AS cantidad,
				rv.cantidad_restante AS restante
			FROM
				tcm_requisicion_vale rv
			INNER JOIN tcm_requisicion r ON rv.id_requisicion = r.id_requisicion
			INNER JOIN org_seccion s ON s.id_seccion = r.id_seccion
			WHERE
				rv.id_vale = $id_vale
			UNION
				SELECT
					v.final - v.cantidad_restante + 1 AS del,
					v.final AS al,
					'No entregados',
					id_vale,
					0,
					v.final - (v.final - v.cantidad_restante),
					v.cantidad_restante 
				FROM
					tcm_vale v
				WHERE
					v.cantidad_restante >0 AND
					v.id_vale = $id_vale";
				$query=$this->db->query($q);
			return $query->result_array();

	}

function detalleR($id_requisicion=NULL)
	{
		$q="SELECT 
				c.id_consumo,
				numero_factura AS factura,
				DATE_FORMAT(fecha_factura,'%d-%m-%Y') AS fecha,
				cv.inicial AS del,
				cv.inicial + SUM(cv.cantidad_vales) - 1 AS al,
				SUM(cv.cantidad_vales) as cantidad 
			FROM
				tcm_consumo c
			INNER JOIN tcm_consumo_vehiculo cv ON cv.id_consumo = c.id_consumo
			INNER JOIN tcm_requisicion_vale_consumo_vehiculo rvcv ON rvcv.id_consumo_vehiculo = cv.id_consumo_vehiculo
			WHERE
				rvcv.id_requisicion_vale = $id_requisicion
			GROUP BY
				c.id_consumo
			UNION 
			SELECT 
			0, 
			'--', 
			'-/-/-', 
			rv.numero_inicial + rv.cantidad_entregado - rv.cantidad_restante,
			rv.numero_inicial + rv.cantidad_entregado - 1,
			rv.cantidad_restante
			FROM
			 tcm_requisicion_vale rv
			WHERE
			rv.cantidad_restante >0 AND
			id_requisicion_vale = $id_requisicion";

			$query=$this->db->query($q);
			return $query->result_array();
	}
function detalleF($id_consumo=NULL)
	{
		$q="SELECT
				id_consumo,
				actividad,
				inicial del,
				inicial + cv.cantidad_vales - 1 AS al,
				cv.cantidad_vales AS cantidad, 
								CASE 1
								WHEN cv.id_vehiculo IS NULL THEN
									h.nombre 
								WHEN cv.id_herramienta IS NULL THEN
									v.placa 
								END		as en
			FROM
				tcm_consumo_vehiculo cv
			LEFT JOIN tcm_herramienta h ON cv.id_herramienta = h.id_herramienta
			LEFT JOIN tcm_vehiculo v ON v.id_vehiculo = cv.id_vehiculo
			WHERE
				id_consumo = $id_consumo";

			$query=$this->db->query($q);
			return $query->result_array();
	}

function asignacion_reporte($id_seccion='', $id_fuente_fondo="", $fecha_inicio=NULL, $fecha_fin=NULL, $agrupar=NULL)
        {
                $fechaF=" rv.mes = DATE_FORMAT(CURDATE(),'%Y%m')        ";
                                $fuenteF="";
                                $seccionF="";
                                if($fecha_inicio !=NULL && $fecha_fin!=NULL){

                                        $fechaF="  rv.mes  BETWEEN DATE_FORMAT(DATE('".$fecha_inicio."'),'%Y%m') AND DATE_FORMAT(DATE('".$fecha_fin."'),'%Y%m')";
                                }
                                if($id_seccion!=NULL){

                                        $seccionF=" AND r.id_seccion = ".$id_seccion;
                                }
                                if($id_fuente_fondo!=NULL){

                                        $fuenteF=" AND r.id_fuente_fondo = ".$id_fuente_fondo;
                                }

                                if($agrupar==NULL || $agrupar==2){ //por mes
        
                                        $selecM="       CONCAT( s.nombre_seccion, ' <br>', f.nombre_fuente_fondo, ' - ',DATE_FORMAT(DATE( CONCAT_WS('-',LEFT(x.mes,4),RIGHT(x.mes,2),'01')),'%M %Y'))  as seccion,";
                                        $mes ="r.mes";

                                }else{ // por año
                                        $selecM="       CONCAT( s.nombre_seccion, ' <br>', f.nombre_fuente_fondo, '-', x.mes) as seccion,";
                                        $mes="LEFT(r.mes,4)";

                                }

                        $where= $fechaF.$seccionF.$fuenteF;
                        $query=$this->db->query(" SET lc_time_names = 'es_ES'");                
                        $query=$this->db->query(" SET @row_number:=0;");
                        $q="SELECT
                                        @row_number:=@row_number+1 AS row_number, 
                                        r.id_seccion, 
                                                        ".$selecM."
                                        x.asignado asignado,
                                        x.entregado,
                                        GROUP_CONCAT(rv.inicial) as inicial ,
                                        GROUP_CONCAT(rv.final) as final
                                FROM tcm_requisicion r 
                                INNER JOIN tcm_requisicion_vale2 rv ON r.id_requisicion = rv.id_requisicion
                                INNER JOIN org_seccion s ON s.id_seccion= r.id_seccion
                                INNER JOIN tcm_vale v ON v.id_vale  = rv.id_vale
                                INNER JOIN tcm_fuente_fondo f ON f.id_fuente_fondo = r.id_fuente_fondo 
                                LEFT  JOIN (    SELECT
                                                SUM(asignado) asignado,
                                                SUM(cantidad_entregado) entregado,
                                                id_seccion, 
                                                ".$mes." as mes
                                        FROM
                                                tcm_requisicion r
                                        GROUP BY
                                                id_seccion,
                                                ".$mes." ) as x ON r.id_seccion = x.id_seccion AND ".$mes." = x.mes
                                WHERE ".$where."        
                                 GROUP BY r.id_seccion, ".$mes;

                        $query=$this->db->query($q);

                        return $query->result();

        }


     

}	
?>