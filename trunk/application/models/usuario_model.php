<?php

class Usuario_model extends CI_Model {
    //constructor de la clase
    function __construct() {
        //LLamar al constructor del Modelo
        parent::__construct();
	
    }
	
	function mostrar_menu()
	{
		$sentencia="SELECT id_sistema, nombre_sistema FROM org_sistema";
		$query0=$this->db->query($sentencia);
		$m0=(array)$query0->result_array();
		$result='';
		foreach($m0 as $val) { 
			$id_sistema=$val['id_sistema'];
			$nombre_sistema=$val['nombre_sistema'];
			if($id_sistema==5)
				$result.='<ul class="treeview" style="max-width: 600px; width: 100%; margin: 0 auto;"><li data-expanded="true">'.$nombre_sistema;
			else
				$result.='<ul class="treeview" style="max-width: 600px; width: 100%; margin: 0 auto;"><li data-expanded="false">'.$nombre_sistema;
			$sentencia="SELECT id_modulo, nombre_modulo, descripcion_modulo FROM org_modulo where (dependencia IS NULL OR dependencia = 0) AND id_modulo<>71 AND id_sistema=".$id_sistema." ORDER BY orden";
			$query1=$this->db->query($sentencia);
			$m1=(array)$query1->result_array();
			
			$result.='<ul>';
			foreach($m1 as $val) { 
				$id_modulo=$val['id_modulo'];
				$nombre_modulo=$val['nombre_modulo'];
				$descripcion_modulo=$val['descripcion_modulo'];
				
				$sentencia="SELECT id_modulo, nombre_modulo, descripcion_modulo FROM org_modulo where dependencia = ".$id_modulo." ORDER BY orden";
				$query2=$this->db->query($sentencia);
				$m2=(array)$query2->result_array();
				
				if($query2->num_rows>0)
					$result.='<li data-expanded="false" title="'.$descripcion_modulo.'"> '.$nombre_modulo;
				else {
					$result.='<li> '.$nombre_modulo;
					$result.='<select class="oculto" name="permiso[]" style="height: 16px; float: right; padding: 0px;"><option value="'.$id_modulo.',1">Usuario General</option><option value="'.$id_modulo.',2">Delegado Sección</option><option value="'.$id_modulo.',3">Administrador</option></select>';
				}
				
				if($query2->num_rows>0)
					$result.=' <ul>';
				
				foreach($m2 as $val2) {
					$id_modulo=$val2['id_modulo'];
					$nombre_modulo=$val2['nombre_modulo'];
					$descripcion_modulo=$val['descripcion_modulo'];
					
					$sentencia="SELECT id_modulo, nombre_modulo, descripcion_modulo FROM org_modulo where dependencia = ".$id_modulo." ORDER BY orden";
					$query3=$this->db->query($sentencia);
					$m3=(array)$query3->result_array();
					
					if($query3->num_rows>0)
						$result.='<li data-expanded="false" title="'.$descripcion_modulo.'"> '.$nombre_modulo;
					else {
						$result.='<li> '.$nombre_modulo;
						$result.='<select class="oculto" name="permiso[]" style="height: 16px; float: right; padding: 0px;"><option value="'.$id_modulo.',1">Usuario General</option><option value="'.$id_modulo.',2">Delegado Sección</option><option value="'.$id_modulo.',3">Administrador</option></select>';
					}
					
					if($query3->num_rows>0)
						$result.=' <ul>';
					
					foreach($m3 as $val3) {
						$id_modulo=$val3['id_modulo'];
						$nombre_modulo=$val3['nombre_modulo'];
						$descripcion_modulo=$val['descripcion_modulo'];
						
						$result.='<li title="'.$descripcion_modulo.'"> '.$nombre_modulo;
						$result.='<select class="oculto" name="permiso[]" style="height: 16px; float: right; padding: 0px;"><option value="'.$id_modulo.',1">Usuario General</option><option value="'.$id_modulo.',2">Delegado Sección</option><option value="'.$id_modulo.',3">Administrador</option></select>';
						$result.=' </li>';				
					}
					if($query3->num_rows>0)
						$result.=' </ul>';
					$result.=' </li>';
				}
				if($query2->num_rows>0)
					$result.=' </ul>';
				$result.=' </li>';
			}
			$result.=' </ul></li></ul>';
		}
		return $result;
	}
	
	function guardar_rol($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO org_rol
					(nombre_rol, descripcion_rol) 
					VALUES 
					('$nombre_rol', '$descripcion_rol')";
		$this->db->query($sentencia);
		return $this->db->insert_id();
	}
	
	function guardar_permisos_rol($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO org_rol_modulo_permiso
					(id_rol, id_modulo, id_permiso, estado) 
					VALUES 
					('$id_rol', '$id_modulo', '$id_permiso', '$estado')";
		$this->db->query($sentencia);
	}
	
	function consultar_oficinas($id_seccion=NULL)
	{
		if($id_seccion!=NULL) {
			$oficinas=array(
				array("id_ofi"=>9,"nom_ofi"=>"Oficina Central San Salvador")
			);
		}
		else {
			$oficinas=array(
				array("id_ofi"=>9,"nom_ofi"=>"Oficina Central San Salvador"),
				array("id_ofi"=>1,"nom_ofi"=>"Oficina Departamental Ahuachapán"),
				array("id_ofi"=>2,"nom_ofi"=>"Oficina Departamental Cabañas"),
				array("id_ofi"=>3,"nom_ofi"=>"Oficina Departamental Chalatenango"),
				array("id_ofi"=>4,"nom_ofi"=>"Oficina Departamental Cuscatlán"),
				array("id_ofi"=>5,"nom_ofi"=>"Oficina Departamental La Libertad"),
				array("id_ofi"=>6,"nom_ofi"=>"Oficina Departamental La Unión"),
				array("id_ofi"=>7,"nom_ofi"=>"Oficina Departamental Morazán"),
				array("id_ofi"=>8,"nom_ofi"=>"Oficina Departamental San Miguel"),
				array("id_ofi"=>10,"nom_ofi"=>"Oficina Departamental San Vicente"),
				array("id_ofi"=>11,"nom_ofi"=>"Oficina Departamental Santa Ana"),
				array("id_ofi"=>12,"nom_ofi"=>"Oficina Departamental Sonsonate"),
				array("id_ofi"=>13,"nom_ofi"=>"Oficina Departamental Usulután"),
				array("id_ofi"=>14,"nom_ofi"=>"Oficina Departamental Zacatecoluca")
			);
		}
		return $oficinas;
	}
	
	function empleados_sin_usuario($id_seccion=NULL)
	{
		if($id_seccion!=NULL)
			$where_seccion="AND sir_empleado_informacion_laboral.id_seccion=".$id_seccion;
		else
			$where_seccion="";
		$sentencia="SELECT DISTINCT
					sir_empleado.id_empleado,
					LOWER(CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada)) AS nombre
					FROM
					sir_empleado
					LEFT JOIN sir_empleado_informacion_laboral ON sir_empleado_informacion_laboral.id_empleado = sir_empleado.id_empleado
					WHERE sir_empleado.nr NOT IN (SELECT nr FROM org_usuario WHERE nr IS NOT NULL AND nr<>'') ".$where_seccion;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function mostrar_roles()
	{
		$sentencia="SELECT org_rol.id_rol, LOWER(org_rol.nombre_rol) AS nombre_rol, org_rol.descripcion_rol FROM org_rol";
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function info_adicional($id_empleado)
	{
		$sentencia="SELECT
					LOWER(CONCAT_WS(' ',sir_empleado.primer_nombre, sir_empleado.segundo_nombre, sir_empleado.tercer_nombre, sir_empleado.primer_apellido, sir_empleado.segundo_apellido, sir_empleado.apellido_casada)) AS nombre,
					LOWER(CONCAT_WS('.',primer_nombre, primer_apellido)) AS usuario,
					sir_empleado.nr,
					sir_empleado.id_genero,
					sir_empleado_informacion_laboral.id_seccion
					FROM sir_empleado
					LEFT JOIN sir_empleado_informacion_laboral ON sir_empleado_informacion_laboral.id_empleado = sir_empleado.id_empleado 
					WHERE sir_empleado.id_empleado='".$id_empleado."'
					ORDER BY id_empleado_informacion_laboral DESC LIMIT 0,1";
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
	
	function guardar_usuario($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO org_usuario
					(nombre_completo, password, nr, sexo, usuario, id_seccion, estado) 
					VALUES 
					('$nombre_completo', '$password', '$nr', '$sexo', '$usuario', '$id_seccion', '$estado')";
		$this->db->query($sentencia);
		return $this->db->insert_id();
	}
	
	function guardar_permisos_usuario($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="INSERT INTO org_usuario_rol
					(id_rol, id_usuario) 
					VALUES 
					('$id_rol', '$id_usuario')";
		$this->db->query($sentencia);
	}
	
	function buscar_padre_permisos_rol($id_modulo)
	{
		$sentencia="SELECT
					m4.id_modulo AS bisabuelo,
					m3.id_modulo AS abuelo,
					m2.id_modulo AS padre
					FROM
					org_modulo AS m1
					LEFT JOIN org_modulo AS m2 ON m2.id_modulo = m1.dependencia
					LEFT JOIN org_modulo AS m3 ON m3.id_modulo = m2.dependencia
					LEFT JOIN org_modulo AS m4 ON m4.id_modulo = m3.dependencia
					WHERE m1.id_modulo=".$id_modulo;
		$query=$this->db->query($sentencia);
		return (array)$query->row();
	}
	
	function buscar_padre_modulo_rol($id_rol,$id_modulo)
	{
		$sentencia="SELECT count(*) AS total FROM org_rol_modulo_permiso WHERE id_modulo=".$id_modulo." AND id_rol=".$id_rol."";
		$query=$this->db->query($sentencia);
	
		/*return $query->num_rows;*/
		return (array)$query->row();
	}
}
?>