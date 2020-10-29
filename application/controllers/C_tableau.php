<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Controlador  Home
	 * 
	 * @Package		
	 * @Autor       Johanny lopez
	 * @link        
	 */

	/**
	 * Controlador   Class
	 * C_tableau C_tableau
	 * @subpackage   Libreria Login
	 * @categoria    Libreria
	 */
	class C_tableau extends FS_Controller {

		private $view_dashboard = 'informe_tableau/dashboard_tableau'; 
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