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

	



/* End of file tools_helper.php */
/* Location: ./system/helpers/form_helper.php */
