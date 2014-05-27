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

		$CI->load->view('encabezado',$data);
	 	$CI->load->view($vista);	
	 	$CI->load->view('piePagina');
	}

	function ir_a($url){
		echo'<script language="JavaScript" type="text/javascript">
				var pagina="'.base_url().$url.'"
				function redireccionar() 
				{
				location.href=pagina
				} 
				setTimeout ("redireccionar()", 1000);
				
				</script>';
		
		}	
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
		$mail->FromName = $title;
		$mail->IsHTML(true);          
		$mail->Timeout = 1000;
		$mail->AddAddress( $correo );
		$mail->ContentType = "text/html";
		$mail->Subject = $title;
		$mail->Body = $message;
		$r=$mail->Send();
		return $r;
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



/* End of file tools_helper.php */
/* Location: ./system/helpers/form_helper.php */
