<?php
class Android_model extends CI_Model {
    
	//constructor de la clase
    function __construct() {
        //LLamar al constructor del Modelo
        parent::__construct();
    }
	
	function salida_entrada()
	{
		$sentencia="SELECT s.id_solicitud_transporte id,
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
			";
		$query=$this->db->query($sentencia);
	
		
	return $query->result();
	
	}
	function kilometraje($placa)
	{
		$sentencia="SELECT v.id_vehiculo, COALESCE(MAX(k.km_inicial), 0) AS KMinicial, COALESCE(MAX(k.km_Final), 0) AS KMFinal
				FROM tcm_vehiculo  v 
				LEFT JOIN tcm_vehiculo_kilometraje  K 
				ON  V.id_vehiculo= K.id_vehiculo
				GROUP BY v.placa HAVING placa LIKE '$placa'";
		$query=$this->db->query($sentencia);
	
		
	return $query->result();
	
	}
	
	
}
?>