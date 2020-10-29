<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controlador  Home
	 * 
	 * @Package		
	 * @Autor       Paolo Castillo
	 * @link        <http://url/dashboard_meta/index.php/inicio.html>
	 */

	/**
	 * Controlador   Class
	 * HO_Controller HO_Controller
	 * @subpackage   Libreria Login
	 * @categoria    Libreria
	 */
	class C_dashboard extends HE_Controller {

		private $view_dashboard = 'dashboard/dashboard'; 
		/**
		 * [__construct cargar modelo]
		 */
		public function __construct()
		{
			parent::__construct();
			$this->load->model('M_tableau','tableau');
		}
		/**
		 * [inicio vista inicio]
		 * @return [type] [vista]
		 */
		public function inicio()
		{
			$data['ticket'] = $this->tableau->getTicket();
			$this->load->view($this->view_head());
			$this->load->view($this->view_dashboard, $data);
			$this->load->view($this->view_footer());
		}

		// }	

	}

	/* End of file C_home.php */
/* Location: ./application/controllers/C_home.php */