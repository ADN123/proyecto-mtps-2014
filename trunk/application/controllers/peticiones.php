<?php 



class Peticiones extends CI_Controller {

		
	function Peticiones()
	{
        parent::__construct();
		date_default_timezone_set('America/El_Salvador');
		$this->load->model('seguridad_model');
		$this->load->model('transporte_model');
		$this->load->helper('cookie');
		$this->load->library("securimage/securimage");
		
    }

	/*
	*	Nombre: index
	*	Obejtivo: Carga la vista que contiene el formulario de login
	*	Hecha por: Jhonatan
	*	Modificada por: Leonel
	*	Ultima Modificacion: 15/03/2014
	*	Observaciones: Ninguna
	*/
	function index(){
	
		
	}

	function aprobar_solicitud($usuarioe=NULL,$solicitude=NULL,$opcion=NULL){
		//verificacion de  accion
		$accion=-1;
		if ($opcion==md5(1)) {
			$accion=2;
			
		}elseif($opcion==md5(0)) {
			$accion=0;
			
		}else{
			$this->cerrar_ventana();
			die("Informaci&oacute;n corrupta");
		}

		//verificacion de usuario
		$u=$this->seguridad_model->verificar_usuario($usuarioe);		
		if (isset($u) && sizeof($u)>0) {
			$id_usuario=$u['id_usuario'];
		}else{
			$this->cerrar_ventana();
			die("informaci&oacute;n de usuario incorrecta");
		}

		
		//verificacion de solicitud
		$u=$this->seguridad_model->verificar_solicitud($solicitude);		
		
		if (isset($u) && sizeof($u)>0 && $u['estado'] <=2) {
			$id_solicitud_transporte=$u['id_solicitud_transporte'];
			$this->db->trans_start();
					///al fin procesamos la actualizacion
			$this->transporte_model->aprobar($id_solicitud_transporte,$accion, $id_usuario);

			$this->db->trans_complete();
			$tr=($this->db->trans_status()===FALSE)?0:1;				
				if($tr==1 && $accion==2) {
					$this->cerrar_ventana();
					echo " Solictud aprobada";
					//enviar_correo_automatico_administracion($id_solicitud_transporte,68); //id de modulo 
				}else{
					$this->cerrar_ventana();
					echo "Solicitud denegada";
				}

			enviar_correo_automatico_usuarios($id_solicitud_transporte);
			$this->cerrar_ventana();

		}else{
			$this->cerrar_ventana();
			die("Solictud  invalida");
		}	
			
	}

	function cerrar_ventana()
	{
		echo '
		<script type="text/javascript">
			setTimeout("window.close();" , 5000);
		</script>
		
		';

	}
}
?>
