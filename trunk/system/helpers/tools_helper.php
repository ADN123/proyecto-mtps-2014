<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Form Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Jhonatan Flores
 * @link		http://codeigniter.com/user_guide/helpers/form_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Form Declaration
 *
 * Creates the opening portion of the form.
 *
 * @access	public
 * @param	string	the URI segments of the form destination
 * @param	array	a key/value pair of attributes
 * @param	array	a key/value pair hidden data
 * @return	string
 */
	

	function pantalla($vista, $data=NULL) 
	{
		$CI =& get_instance();
		$data['nick']=$CI->session->userdata('usuario');
		$data['nombre']=$CI->session->userdata('nombre');
		$data['menus']=$CI->seguridad_model->buscar_menus($CI->session->userdata('id_usuario'));
		
////para ayuda
		$descripcion_ayuda= "Descripcion del modulo ";
					  			for ($i=0; $i <4 ; $i++) { 
					  				$descripcion_ayuda.=$descripcion_ayuda;
					  			}
		$pasos = array("paso 1 tambiem ", 
						"paso 2 van los ",
						"paso 4 errores",
						"paso 5 de ejemplo");

		$data['descripcion_ayuda']=$descripcion_ayuda;
		$data['pasos']=$pasos;
		$data['errores']=$pasos;
	
	//fin para ayuda

		$CI->load->view('encabezado',$data);
	 	$CI->load->view($vista);	
	 	$CI->load->view('piePagina');
	}

	function ir_a($url){

		/*
	echo'<script language="JavaScript" type="text/javascript">
				var pagina="'.base_url().$url.'"
				function redireccionar() 
				{
				location.href=pagina
				} 
				setTimeout ("redireccionar()", 600);	
				
				</script>'; */

	echo'<script language="JavaScript" type="text/javascript">
				var pagina="'.base_url().$url.'"
				window.location.href=pagina
				</script>'; 
		
		}	

	function nuevaVentana($url){
		echo'<script language="JavaScript" type="text/javascript">
				var pagina2="'.base_url().$url.'"
				function nuevaVentana() 
				{
				window.open(pagina2,"_blank");
				} 
				setTimeout ("nuevaVentana()", 300);
				
				</script>';
		
		}	

	/*function enviar_correo($correo=array(),$title,$message) */
	function enviar_correo($correo,$title,$message) 
	{
		$CI =& get_instance();
		$CI->load->library("phpmailer");
		
		$mail = new PHPMailer();
		$mail->Host = "mtrabajo.mtps.gob.sv";
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->Username = "departamento.transporte@mtps.gob.sv";
		$mail->Password = ".[?=)&%$";
		$mail->From = "departamento.transporte@mtps.gob.sv";
		$mail->FromName = "Departamento de Transporte";
		$mail->IsHTML(true);          
		$mail->Timeout = 1000;
		/*for($i=0;$i<count($correo);$i++)
			$mail->AddAddress( $correo[$i] );*/
		$mail->AddAddress( $correo );
		$mail->ContentType = "text/html";
		$mail->Subject = $title;
		$mail->Body = $message;
		$r=$mail->Send();
		if(!$r) {
			//echo "Error al enviar: " .$mail->ErrorInfo;
			} else {
			//echo "Mensaje enviado!";
		}
		return $r;
	}
	
	
	function enviar_por_gmail($correo,$title,$message) 
	{
			$CI =& get_instance();
			$CI->load->library("phpmailer");		
			$mail = new PHPMailer();
			//indico a la clase que use SMTP
			$mail->isSMTP();
			//permite modo debug para ver mensajes de las cosas que van ocurriendo 2 para desactivar  1
			$mail->SMTPDebug = 1;
			//Debo de hacer autenticación SMTP
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			//indico el servidor de Gmail para SMTP
			$mail->Host = "smtp.gmail.com";
			//indico el puerto que usa Gmail
			$mail->Port = 465;
			//indico un usuario / clave de un usuario de gmail
			$mail->Username = "informatica.mtps@gmail.com";
			$mail->Password = "wsx!@#mko";
			$mail->From = "thanf92@gmail.com";
			$mail->FromName = "Informatica MTPS";
			$mail->AddReplyTo("informatica.mtps@gmail.com","Informatica mtps");
			$mail->Subject = $title;
			$mail->MsgHTML($message);
			//indico destinatario
			$mail->AddAddress( $correo);
			$r=$mail->Send();
				if(!$r) {
					//echo "Error al enviar: " .$mail->ErrorInfo;
					} else {
					//echo "Mensaje enviado!";
				}
				return $r;
	}
	
	function enviar_correo_automatico_administracion($id_solicitud_transporte=NULL, $id_modulo=NULL) 
	{
		$CI =& get_instance();
		$CI->load->model('usuario_model');
		$CI->load->model('transporte_model');
		$datos=$CI->usuario_model->buscar_correos($id_solicitud_transporte, $id_modulo);
		$solicitud=$CI->transporte_model->consultar_solicitud($id_solicitud_transporte);
		for($i=0;$i<count($datos);$i++) {
			$nombre=ucwords($datos[$i]['nombre']);
			$correo=ucwords($datos[$i]['correo']);
			/*$correo="leoneladonispm@hotmail.com";*/
			$nominal=ucwords($datos[$i]['nominal']);
			$mensaje="Estimad@ ".$nombre.",<br><br>La solicitud N&deg;<strong>".$id_solicitud_transporte."</strong> realizada por <strong>".ucwords($solicitud['nombre'])."</strong> ";
			switch($id_modulo){
				case 60:
					$titulo="SOLICITUD DE TRANSPORTE PENDIENTE DE AUTORIZACION";
					$mensaje.="requiere de su autorizaci&oacute;n.<br><br>Departamento de Transporte.<br><br><img src='".base_url()."img/mtps.jpg' />";
					break;
				case 62:
					$titulo="SOLICITUD DE TRANSPORTE PENDIENTE DE ASIGACION DE VEHCULO/MOTORISTA";
					$mensaje.="requiere asignaci&oacute;n de veh&iacute;culo/motorista.<br><br>Departamento de Transporte.<br><br><img src='".base_url()."img/mtps.jpg' />";
					break;
				default:
					$titulo="";
					$mensaje="";
			}
			$r=enviar_correo($correo,$titulo,$mensaje);
		}
	}
	
	function enviar_correo_automatico_usuarios($id_solicitud_transporte=NULL) 
	{
		$CI =& get_instance();
		$CI->load->model('usuario_model');
		$CI->load->model('transporte_model');
		$datos=$CI->usuario_model->buscar_correo($id_solicitud_transporte);
		$nombre=ucwords($datos['nombre']);
		$correo=ucwords($datos['correo']);
		/*$correo="leoneladonispm@hotmail.com";*/
		$nominal=ucwords($datos['nominal']);
		$mensaje="Estimad@ ".$nombre.",<br><br>Su solicitud N&deg;<strong>".$id_solicitud_transporte."</strong> con fecha de salida <strong>".$datos['fecha_mision']."</strong> ";
		switch($datos['estado']){
			case 0:
				$titulo="SOLICITUD DE TRANSPORTE RECHAZADA";
				$mensaje.="ha sido reprobada. Puede que se deba a uno de los siguientes motivos: '<strong>".$datos['observacion']."</strong>'<br><br>Departamento de Transporte.<br><br><img src='".base_url()."img/mtps.jpg' />";
				break;
			case 2:
				$titulo="SOLICITUD DE TRANSPORTE APROBADA";
				$mensaje.="ha sido aprobada.<br><br>Departamento de Transporte.<br><br><img src='".base_url()."img/mtps.jpg' />";
				break;
			case 3:
				$titulo="SOLICITUD DE TRANSPORTE ASIGNADA CON VEHICULO/MOTORISTA";
				$mensaje.="ha sido asignada con veh&iacute;culo/motorista.<br><br>Departamento de Transporte.<br><br><img src='".base_url()."img/mtps.jpg' />";
				break;
			default:
				$titulo="";
				$mensaje="";
		}
		$r=enviar_correo($correo,$titulo,$mensaje);
	}
	
	function alerta($msj,$url){
		echo'
	<link href="'.base_url().'css/default.css" rel="stylesheet" type="text/css" />
		<link href="'.base_url().'css/component.css" rel="stylesheet" type="text/css" />
        <link href="'.base_url().'css/kendo.common.min.css" rel="stylesheet" type="text/css" />
        <link href="'.base_url().'css/kendo.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="'.base_url().'css/kendo.dataviz.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="'.base_url().'css/tooltipster.css" rel="stylesheet" type="text/css" />
		<link href="'.base_url().'css/alertify.core.css" rel="stylesheet" />
		<link href="'.base_url().'css/alertify.default.css" rel="stylesheet" />
        <link href="'.base_url().'css/style-base.css" rel="stylesheet" type="text/css" />
        <script src="'.base_url().'js/jquery-1.8.2.js"></script>
        <!--<script src="'.base_url().'js/jquery-ui-1.9.0.custom.js"></script>-->
		<script src="'.base_url().'js/classie.js"></script>
        <script src="'.base_url().'js/kendo.all.min.js" type="text/javascript"></script>
        <script src="'.base_url().'js/jquery.tooltipster.js" type="text/javascript"></script>
        <script src="'.base_url().'js/jquery.leanModal.min.js" type="text/javascript"></script>
        <script src="'.base_url().'js/waypoints.min.js"></script>
        <script src="'.base_url().'js/alertify.js" type="text/javascript"></script>
		<script language="JavaScript" type="text/javascript">
		
				var pagina="'.base_url().$url.'"
				function redireccionar() 
				{
				alertify.alert("'.$msj.'");
				setTimeout("partB()",2000)
				} 
				function partB() 
				{
				location.href=pagina
				} 
				setTimeout ("redireccionar()",1000);			
		</script>';
		
		}	
 function deleteform($item)
  {
  	$array=$_SESSION['form'];
  	$item=$item['keyform'];

  	foreach ($array as $key => $value) {
  		if($value==$item){
  			unset($_SESSION['form'][$key]);
  		}

  	}
  }

 function verificarform($item)
  {
  	$array=$_SESSION['form'];
  	$item=$item['keyform'];
  	$ban=false;
  	foreach ($array as $key => $value) {
  		if($value==$item){
  			$ban=true;
  		}

  	}
  	return $ban;
  }

function randomkey($length=16)
      {
        $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";

        for($i=0;$i<$length;$i++)
            $key .= $pattern{rand(0,35)};

       $tem=$_SESSION['form'];
       $tem[]=$key;
       $_SESSION['form']=$tem;

       return $key;
      }  

function llaveform(){
	echo '<input value="'.randomkey().'" type="hidden" name="keyform"/>';
}

function restar_mes($mes=NULL,$rest=NULL)
{	$arr2 = str_split($mes, 4); //divide en 4 digitos, cada arreglo
	$a=$arr2[0];
	$m=$arr2[1];
	
	while ( $rest>=12) {
		$a--; $rest-=12;
	}
	
	$m=$m-$rest;
	//echo $m;
	if($m<0){
		//$m=13-$rest;
		$m=12-(-$m);
		$a--;
	}	
	if($m==0){
		$m=12;
		$a--;
	}


	if($m<10){ ///para que se mantenga el formato de dos digitos en mes
		$m="0".$m;
	}
	$nmes=$a.$m;	
	return $nmes;
}

function getUltimoDiaMes($elAnio=NULL,$elMes=NULL) {
		if ($elMes==NULL) {
			$elMes=date('m');
		}
		if ($elAnio==NULL) {
			$elAnio=date('Y');
		}
  return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
}
/* End of file tools_helper.php */
/* Location: ./system/helpers/form_helper.php */
