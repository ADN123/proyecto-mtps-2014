<?php

class Usuario_model extends CI_Model {
    //constructor de la clase
    function __construct() {
        //LLamar al constructor del Modelo
        parent::__construct();
	
    }
	
	function mostrar_menu($id_rol=NULL)
	{
		$sentencia="SELECT id_modulo, id_permiso FROM org_rol_modulo_permiso WHERE estado=1 AND id_rol='".$id_rol."'";
		$query=$this->db->query($sentencia);
		$m=(array)$query->result_array();
		$id_mod=array();
		$id_per=array();
		foreach($m as $val) { 
			$id_mod[]=$val['id_modulo'];
			$id_per[]=$val['id_permiso'];
		}
		$sentencia="SELECT id_sistema, nombre_sistema FROM org_sistema WHERE id_sistema=5";
		$query0=$this->db->query($sentencia);
		$m0=(array)$query0->result_array();
		$result='';
		foreach($m0 as $val0) { 
			$id_sistema=$val0['id_sistema'];
			$nombre_sistema=$val0['nombre_sistema'];
			if($id_sistema==5)
				$result.='<ul class="treeview" style="max-width: 600px; width: 100%; margin: 0 auto;"><li data-expanded="true">'.$nombre_sistema;
			else
				$result.='<ul class="treeview" style="max-width: 600px; width: 100%; margin: 0 auto;"><li data-expanded="false">'.$nombre_sistema;
			$sentencia="SELECT id_modulo, nombre_modulo, descripcion_modulo FROM org_modulo where (dependencia IS NULL OR dependencia = 0) AND id_modulo<>71 AND id_sistema=".$id_sistema." ORDER BY orden";
			$query1=$this->db->query($sentencia);
			$m1=(array)$query1->result_array();
			
			$result.='<ul>';
			foreach($m1 as $val1) { 
				$id_modulo=$val1['id_modulo'];
				$nombre_modulo=$val1['nombre_modulo'];
				$descripcion_modulo=$val1['descripcion_modulo'];
				
				$sentencia="SELECT id_modulo, nombre_modulo, descripcion_modulo FROM org_modulo where dependencia = ".$id_modulo." ORDER BY orden";
				$query2=$this->db->query($sentencia);
				$m2=(array)$query2->result_array();
				
				if($query2->num_rows>0) {
					$expanded="false";
					for($i=0;$i<count($id_mod);$i++) {
						$ancestros=$this->buscar_padre_permisos_rol($id_mod[$i]);
						if($id_modulo==$ancestros['padre'] || $id_modulo==$ancestros['abuelo'] || $id_modulo==$ancestros['bisabuelo'])
							$expanded="true";
					}
					$result.='<li data-expanded="'.$expanded.'" title="'.$descripcion_modulo.'"> '.$nombre_modulo;
				}
				else {
					$result.='<li title="'.$descripcion_modulo.'"> '.$nombre_modulo;
					$clave='';
					$clave=array_search($id_modulo, $id_mod);
					$op1='';
					$op2='';
					$op3='';
					$op4='';
					$x='';
					if($clave!==FALSE) {
						switch($id_per[$clave]) {
							case 1:
								$x=1;
								$op1='selected="selected"';
								break;
							case 2:
								$x=2;
								$op2='selected="selected"';
								break;
							case 3:
								$x=3;
								$op3='selected="selected"';
								break;
							case 4:
								$x=4;
								$op4='selected="selected"';
								break;
						}
					}
 					$result.='<select class="oculto" name="permiso[]" style="height: 16px; float: right; padding: 0px;"><option value=""></option><option value="'.$id_modulo.',1" '.$op1.'>Personal</option><option value="'.$id_modulo.',2" '.$op2.'>Sección</option><option value="'.$id_modulo.',4" '.$op4.'>Departamental</option><option value="'.$id_modulo.',3" '.$op3.'>Nacional</option></select>';
				}
				
				if($query2->num_rows>0)
					$result.=' <ul>';
				
				foreach($m2 as $val2) {
					$id_modulo=$val2['id_modulo'];
					$nombre_modulo=$val2['nombre_modulo'];
					$descripcion_modulo=$val2['descripcion_modulo'];
					
					$sentencia="SELECT id_modulo, nombre_modulo, descripcion_modulo FROM org_modulo where dependencia = ".$id_modulo." ORDER BY orden";
					$query3=$this->db->query($sentencia);
					$m3=(array)$query3->result_array();
					
					if($query3->num_rows>0){
						$expanded="false";
						for($i=0;$i<count($id_mod);$i++) {
							$ancestros=$this->buscar_padre_permisos_rol($id_mod[$i]);
							if($id_modulo==$ancestros['padre'] || $id_modulo==$ancestros['abuelo'] || $id_modulo==$ancestros['bisabuelo'])
								$expanded="true";
						}
						$result.='<li data-expanded="'.$expanded.'" title="'.$descripcion_modulo.'"> '.$nombre_modulo;
					}
					else {
						$result.='<li title="'.$descripcion_modulo.'"> '.$nombre_modulo;
						$clave='';
						$clave=array_search($id_modulo, $id_mod);
						$op1='';
						$op2='';
						$op3='';
						$op4='';
						$x='';
						if($clave!==FALSE) {
							switch($id_per[$clave]){
								case 1:
									$x=1;
									$op1='selected="selected"';
									break;
								case 2:
									$x=2;
									$op2='selected="selected"';
									break;
								case 3:
									$x=3;
									$op3='selected="selected"';
									break;
								case 4:
									$x=4;
									$op4='selected="selected"';
									break;
							}
						}
						$result.='<select class="oculto" name="permiso[]" style="height: 16px; float: right; padding: 0px;"><option value=""></option><option value="'.$id_modulo.',1" '.$op1.'>Personal</option><option value="'.$id_modulo.',2" '.$op2.'>Sección</option><option value="'.$id_modulo.',4" '.$op4.'>Departamental</option><option value="'.$id_modulo.',3" '.$op3.'>Nacional</option></select>';
					}
					
					if($query3->num_rows>0)
						$result.=' <ul>';
					
					foreach($m3 as $val3) {
						$id_modulo=$val3['id_modulo'];
						$nombre_modulo=$val3['nombre_modulo'];
						$descripcion_modulo=$val3['descripcion_modulo'];
						
						$result.='<li title="'.$descripcion_modulo.'"> '.$nombre_modulo;
						$clave='';
						$clave=array_search($id_modulo, $id_mod);
						$op1='';
						$op2='';
						$op3='';
						$op4='';
						$x='';
						if($clave!==FALSE) {
							switch($id_per[$clave]){
								case 1:
									$x=1;
									$op1='selected="selected"';
									break;
								case 2:
									$x=2;
									$op2='selected="selected"';
									break;
								case 3:
									$x=3;
									$op3='selected="selected"';
									break;
								case 4:
									$x=4;
									$op4='selected="selected"';
									break;
							}
						}
						$result.='<select class="oculto" name="permiso[]" style="height: 16px; float: right; padding: 0px;"><option value=""></option><option value="'.$id_modulo.',1" '.$op1.'>Personal</option><option value="'.$id_modulo.',2" '.$op2.'>Sección</option><option value="'.$id_modulo.',4" '.$op4.'>Departamental</option><option value="'.$id_modulo.',3" '.$op3.'>Nacional</option></select>';
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
	
	function mostrar_roles($id_rol=NULL)
	{
		if($id_rol!=NULL)
			$where_rol=" WHERE id_rol=".$id_rol;
		else
			$where_rol="";
		$sentencia="SELECT id_rol, LOWER(nombre_rol) AS nombre_rol, descripcion_rol FROM org_rol".$where_rol." ORDER BY id_rol DESC";
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
	
	function eliminar_permisos_rol($id_rol)
	{
		$sentencia="DELETE FROM org_rol_modulo_permiso where id_rol='$id_rol'";
		$this->db->query($sentencia);
	}
	
	function eliminar_rol($id_rol)
	{
		$sentencia="DELETE FROM org_rol where id_rol='$id_rol'";
		$this->db->query($sentencia);
	}
	
	function actualizar_rol($formuInfo) 
	{
		extract($formuInfo);
		$sentencia="UPDATE org_rol SET nombre_rol='$nombre_rol', descripcion_rol='$descripcion_rol' where id_rol='$id_rol'";
		$this->db->query($sentencia);
	}
	
	function mostrar_usuarios($id_usuario=NULL,$id_seccion=NULL)
	{
		if($id_usuario!=NULL)
			$where_usuario=" AND org_usuario.id_usuario=".$id_usuario;
		else
			$where_usuario="";
		if($id_seccion!=NULL)
			$where_seccion=" AND sir_empleado_informacion_laboral.id_seccion=".$id_seccion;
		else
			$where_seccion="";
		$sentencia="SELECT DISTINCT
					org_usuario.id_usuario,
					nombre_completo,
					usuario,
					id_rol
					FROM
					org_usuario
					INNER JOIN sir_empleado ON org_usuario.nr = sir_empleado.nr 
					LEFT JOIN sir_empleado_informacion_laboral ON sir_empleado.id_empleado = sir_empleado_informacion_laboral.id_empleado 
					LEFT JOIN org_usuario_rol ON org_usuario_rol.id_usuario = org_usuario.id_usuario WHERE org_usuario.estado=1 ".$where_seccion.$where_usuario;
		$query=$this->db->query($sentencia);
		return (array)$query->result_array();
	}
	
	function eliminar_permisos_usuario($id_usuario)
	{
		$sentencia="DELETE FROM org_rol_modulo_permiso where id_usuario='$id_usuario'";
		$this->db->query($sentencia);
	}
	
	function eliminar_usuario($id_usuario)
	{
		$sentencia="DELETE FROM org_usuario where id_usuario='$id_usuario'";
		$this->db->query($sentencia);
	}
	
	function desactivar_usuario($id_usuario)
	{
		$sentencia="UPDATE org_usuario SET estado=0 where id_usuario='$id_usuario'";
		$this->db->query($sentencia);
	}
}
?>