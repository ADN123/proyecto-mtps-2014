<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
    function Welcome()
	{
        parent::__construct();
		date_default_timezone_set('America/El_Salvador');
		$this->load->model('transporte_model');
		$this->load->library("mpdf");
    	if(!$this->session->userdata('id_usuario')) {
			redirect('index.php/sessiones');
		}
    }

	public function PDF($id=1)
	{		


			/*$this->load->view('transporte/solicitud_pdf.php',$data);*/
			
			$this->mpdf->mPDF('utf-8','letter',0, '', 4, 4, 6, 6, 9, 9); /*Creacion de objeto mPDF con configuracion de pagina y margenes*/
			$stylesheet = file_get_contents('css/pdf/solicitud.css'); /*Selecionamos la hoja de estilo del pdf*/
			$this->mpdf->WriteHTML($stylesheet,1); /*lo escribimos en el pdf*/
			$data['nombre'] = "Renatto NL";
			//$html = $this->load->view('prueba', $data, true); /*Seleccionamos la vista que se convertirá en pdf*/
			$this->load->view('prueba', $data);
			echo "string";
			
			$this->mpdf->WriteHTML($html,2); /*la escribimos en el pdf*/
			
			/* if(count($data['destinos'])>1) { /*si la solicitud tiene varios detinos tenemos que crear otra hoja en el pdf y escribirlos allí
				$this->mpdf->AddPage();
				$html = $this->load->view('transporte/reverso_solicitud_pdf.php', $data, true);
				$this->mpdf->WriteHTML($html,2);
			}
				*/
	
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */