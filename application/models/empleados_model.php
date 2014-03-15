<?php

class Transporte_model extends CI_Model {
    //constructor de la clase
    function __construct() {
        //LLamar al constructor del Modelo
        parent::__construct();
	
    }
	function consultar_empleados()
	{
		
		$query= $this->db->query("SELECT * FROM org_empleado o;");
	
		if($query->num_rows>0)
		{				return (array)$query-result();
	
		}else{
			return array(
			'usuario' => 0
			);
		}
	}
	
}

?>