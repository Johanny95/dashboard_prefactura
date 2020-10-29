<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_datos_periodo extends FS_Controller {
	// private $view_ver = 'datos_periodo/datos_periodo';
	private $view_agregar = 'datos_periodo/datos_periodo';
    // private $view_conceptos = 'concepto/solicitud_cambio';

	private $datos = 'datos';
	private $data = array();
	private $id = 'id';
	private $mensaje = 'mensaje';
	private $estado = 'estado';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_mantenedores'	, 'm_model');

	}

	public function view_registrar()
	{
		$this->css();
		$this->js();
		$this->load->view($this->view_head());
		$this->load->view($this->view_agregar);
		$this->load->view($this->view_footer());	
	}

	public function get_datos_org(){
		$this->data[$this->estado] = FALSE;
		if ($this->input->is_ajax_request()) {
			
			$periodo = $this->input->post('periodo');
			// var_dump ($periodo);
			// die();
			// var_dump ($this->m_model->get_org_datos_mantenedor($periodo));
			// die();
			$this->data['datos'] = $this->m_model->get_org_datos_mantenedor($periodo);



		}
		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}

	public function ingresar(){
		$this->data[$this->estado]  = FALSE;
		$this->data[$this->mensaje] = array();
		if ($this->input->is_ajax_request()) {
			$id_oficina = $this->input->post('id_oficina');
			$this->form_validation->set_rules('id_oficina'								, 'Id orgnizacion'		, 'trim|required');
			$this->form_validation->set_rules('kilos_produccion'.$id_oficina			, 'Kilos produccion'	, 'trim|required');
			$this->form_validation->set_rules('mts2_superficie'.$id_oficina				, 'Mts superficie'		, 'trim|required');
			$this->form_validation->set_rules('mts2_jardines'.$id_oficina				, 'Mts jardines'		, 'trim|required');
			$this->form_validation->set_rules('dias_servicios'.$id_oficina				, 'Dias servicios'		, 'trim|required');
			$this->form_validation->set_rules('dotacion'.$id_oficina					, 'Dotacion'			, 'trim|required');
			$this->form_validation->set_rules('valor_uf'.$id_oficina					, 'Valor Uf'			, 'trim|required');
			$this->form_validation->set_rules('periodo'									, 'Periodo'				, 'trim|required');
			
			if ($this->form_validation->run() == TRUE) {
				
				$elemento = array(
					'id_oficina'			=> $this->input->post('id_oficina'),
					'kilos_produccion'		=> $this->input->post('kilos_produccion'.$id_oficina),
					'mts2_superficie'		=> $this->input->post('mts2_superficie'.$id_oficina),
					'mts2_jardines'			=> $this->input->post('mts2_jardines'.$id_oficina),
					'dias_servicios'		=> $this->input->post('dias_servicios'.$id_oficina),
					'dotacion'				=> $this->input->post('dotacion'.$id_oficina),
					'valor_uf'				=> $this->input->post('valor_uf'.$id_oficina),
					'periodo'				=> $this->input->post('periodo')
				);
				$this->data[$this->estado] = $this->m_model->ingresar($elemento);
			} else {
				foreach ($this->input->post() as $key => $value) 
				{
					$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
					$this->data[$this->mensaje][$key] = form_error($key);
				}
			}

		}
		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}

	public function eliminar_registro (){
		$this->data[$this->estado]  = FALSE;
		$this->data[$this->mensaje] = array();
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('id_oficina'								, 'Id orgnizacion'		, 'trim|required');
			$this->form_validation->set_rules('periodo'									, 'Periodo'				, 'trim|required');
			
			if ($this->form_validation->run() == TRUE) {
				
				$elemento = array(
					'id_oficina'			=> $this->input->post('id_oficina'),
					'periodo'				=> $this->input->post('periodo')
				);
				$this->data[$this->estado] = $this->m_model->del($elemento);
			} else {
				foreach ($this->input->post() as $key => $value) 
				{
					$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
					$this->data[$this->mensaje][$key] = form_error($key);
				}
			}

		}
		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}

	public function editar(){
		// var_dump ($this->input->post());
		// die();
		$this->data[$this->estado]  = FALSE;
		$this->data[$this->mensaje] = array();
		if ($this->input->is_ajax_request()) {
			$id_oficina = $this->input->post('id_oficina');
			$this->form_validation->set_rules('id_oficina'								, 'Id orgnizacion'		, 'trim|required');
			$this->form_validation->set_rules('kilos_produccion'.$id_oficina			, 'Kilos produccion'	, 'trim|required');
			$this->form_validation->set_rules('mts2_superficie'.$id_oficina				, 'Mts superficie'		, 'trim|required');
			$this->form_validation->set_rules('mts2_jardines'.$id_oficina				, 'Mts jardines'		, 'trim|required');
			$this->form_validation->set_rules('dias_servicios'.$id_oficina				, 'Dias servicios'		, 'trim|required');
			$this->form_validation->set_rules('dotacion'.$id_oficina					, 'Dotacion'			, 'trim|required');
			$this->form_validation->set_rules('valor_uf'.$id_oficina					, 'Valor Uf'			, 'trim|required');
			$this->form_validation->set_rules('periodo'									, 'Periodo'				, 'trim|required');
			
			if ($this->form_validation->run() == TRUE) {
				$elemento = array(
					'id_oficina'			=> $this->input->post('id_oficina'),
					'kilos_produccion'		=> $this->input->post('kilos_produccion'.$id_oficina),
					'mts2_superficie'		=> $this->input->post('mts2_superficie'.$id_oficina),
					'mts2_jardines'			=> $this->input->post('mts2_jardines'.$id_oficina),
					'dias_servicios'		=> $this->input->post('dias_servicios'.$id_oficina),
					'dotacion'				=> $this->input->post('dotacion'.$id_oficina),
					'valor_uf'				=> $this->input->post('valor_uf'.$id_oficina),
					'periodo'				=> $this->input->post('periodo')
				);
				$this->data[$this->estado] = $this->m_model->editar($elemento);
			} else {
				foreach ($this->input->post() as $key => $value) 
				{
					$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
					$this->data[$this->mensaje][$key] = form_error($key);
				}
			}

		}
		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));	
	}


}

/* End of file C_m_actos.php */
/* Location: ./application/controllers/C_m_actos.php */