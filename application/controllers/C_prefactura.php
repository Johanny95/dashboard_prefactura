<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_prefactura extends FS_Controller {
	private $view_ver = 'prefactura/informe_prefactura';
	private $view_agregar = 'ajustes/registrar';
	private $view_listado = 'prefactura/listado_prefactura';

	private $datos = 'datos';
	private $data = array();
	private $id = 'id';
	private $mensaje = 'mensaje';
	private $estado = 'estado';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_concepto'		, 'm_model');
		$this->load->model('M_apertura'		, 'm_apertura');
		$this->load->model('M_evento'		, 'm_evento');
		$this->load->model('M_ajuste'		, 'm_ajuste');
		$this->load->model('M_prefactura'	, 'm_prefactura');

	}

	public function view_prefactura()
	{
		$this->css();
		$this->js();
		// $this->data[$this->datos] = $this->m_evento->get_eventos();
		// var_dump ($this->data[$this->datos]);
		// die();
		$this->load->view($this->view_head());
		$this->load->view($this->view_ver);
		$this->load->view($this->view_footer());
	}

	public function view_listado(){
		$this->css();
		$this->js();
		$this->load->view($this->view_head());
		$this->load->view($this->view_listado);
		$this->load->view($this->view_footer());
	}

	public function ver_prefactura( $id_prefactura ){
		$this->css();
		$this->js();
		$this->data['prefactura'] = $this->m_prefactura->get_prefactura($id_prefactura);
		$this->data['detalle'] 	  = $this->m_prefactura->get_prefactura_detalle($id_prefactura);
		$this->data['detalle_oc'] = $this->m_prefactura->get_oc_prefactura($id_prefactura);
		$this->load->view($this->view_head());
		$this->load->view('prefactura/detalle_prefactura', $this->data);
		$this->load->view($this->view_footer());
	}

	public function view_registrar()
	{
		$this->css();
		$this->js();
		$this->load->view($this->view_head());
		$this->load->view($this->view_agregar);
		$this->load->view($this->view_footer());	
	}

	public function get_proveedores_org(){
		$data = array();
		if ($this->input->is_ajax_request()) {

			$org = ($this->input->post('organizaciones') ? $this->input->post('organizaciones'): array(0));
			$result 		= $this->m_prefactura->get_proevedores_org($org);
			if (!empty($result)) {
				$data	= $result;
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_servicios_pro(){
		// var_dump ($this->input->post());
		// die();
		$data = array();
		if ($this->input->is_ajax_request()) { 

			$proveedores 	= ( $this->input->post('proveedores')  ? $this->input->post('proveedores') : array(0) );
			$result 		= $this->m_prefactura->get_servicios_pro($proveedores);
			if (!empty($result)) {
				$data	= $result;
			}
			// var_dump ($result);
			// die();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_informe_pre(){

		$data = array();
		if ($this->input->is_ajax_request()) {
			$elemento = array(
				"periodo" 			=>  $this->input->post('periodo')  ,
				"servicios"			=> implode(',',   ($this->input->post('servicios') 		? $this->input->post('servicios') 		: array(0) ) ),
				"organizaciones"	=> implode(',',   ($this->input->post('organizaciones') ? $this->input->post('organizaciones')  : array(0) ) ),
				"proveedores"		=> implode(',',   ($this->input->post('proveedores') 	? $this->input->post('proveedores') 	: array(0) ) )
			);


			$result = $this->m_prefactura->get_informe_prefactura($elemento);
			if (!empty($result)) {
				foreach ($result as $value) {
					$row = array();
					$row['tipo']		= $value->TIPO;
					$row['organizacion']		= $value->ORGANIZACION;
					$row['proveedor']			= $value->RUT_PROVEEDOR.' | '.$value->RAZON_SOCIAL;
					$row['servicio'] 			= $value->SERVICIO;
					$row['concepto']			= $value->CONCEPTO;
					$row['medida1'] 			= $value->MEDIDA1;
					$row['precio1'] 			= $value->PRECIO1;
					$row['cantidad1'] 			= $value->CANTIDAD1;
					$row['tipo_pago'] 			= $value->TIPO_PAGO;
					$row['total1'] 				= round($value->TOTAL1);
					// $row['doc']					= base_url().$value->DOCUMENTO;
					// $row['url']					= site_url().'ajustes/ver_ajuste/'.$value->ID_AJUSTE;
					// $row['creador']					= $value->CREADOR;
					$data[] = $row;
				}
			}

			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function agregar(){
		$this->data = array('estado' => FALSE, 'mensaje' => NULL);
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('periodo'			, 'Periodo' 				, 'trim|required|min_length[3]|max_length[150]');
			$this->form_validation->set_rules('organizaciones'	, 'Organización' 			, 'trim|required');
			$this->form_validation->set_rules('proveedores'		, 'Proveedor' 				, 'trim|required');
			$this->form_validation->set_rules('servicios'		, 'Servicios' 				, 'trim|required');
			if ( $this->form_validation->run() == TRUE) {

				// var_dump ($this->input->post('servicios') );
				// die();

				$elemento 	= array(
					'periodo'			=> $this->input->post('periodo'),
					"servicios"			=> $this->input->post('servicios'),
					"organizaciones"	=> $this->input->post('organizaciones'),
					"proveedores"		=> $this->input->post('proveedores')
				);
				// var_dump ($elemento);
				// die();
				$validacion = $this->m_apertura->get_validacion_mes($elemento['periodo']);
				if($validacion == 1 ){

					$this->data['estado'] = $this->m_prefactura->agregar_prefactura($elemento);
					// $this->data['estado'] = true;

				}else{
					$this->data['mensaje']['validacion'] = '<p>El periodo que intenta ingresar no se encuentra abierto</p>';

				}
			} else {
				foreach ($this->input->post() as $key => $value) 
				{
					$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
					$this->data['mensaje'][$key] = form_error($key);
				}
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
		}
	}

	function del(){
		$this->data[$this->estado] = FALSE;
		if ($this->input->is_ajax_request()) {
			$this->data[$this->estado] = $this->m_ajuste->del($this->input->post('id_ajuste'));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}

	public function get_conceptos_by_servicio(){
		$data = array();
		if ($this->input->is_ajax_request()) {

			$id_servicio 	= $this->input->post('id_servicio');
			$id_proveedor 	= $this->input->post('id_proveedor');
			// var_dump ($id_proveedor);
			// die();
			$result 		= $this->m_model->get_conceptos_by_servicio($id_servicio , $id_proveedor);
			if (!empty($result)) {
				$data	= $result;
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	public function get_prefacturas()
	{
		$data 		= array();
		$elemento 	= array(
			'periodo' 			=> $this->input->post('periodo')
		);
		if ($this->input->is_ajax_request()) {
			$get = $this->m_prefactura->sp_get_prefacturas($elemento);

			// var_dump ($get);
			// die();


			if (!empty($get)) {
				foreach ($get as $value) {
					$row = array();
					$row['id_prefactura']		= $value->ID_PREFACTURA;
					$row['periodo'] 			= $value->PERIODO;
					$row['solicitante']			= $value->SOLICITANTE;
					$row['aprobador']			= $value->APROBADOR;
					$row['estado']				= $value->ESTADO;
					$row['fecha_creacion'] 		= $value->FECHA_CREACION;
					$row['fecha_aprobacion'] 	= $value->FECHA_APROBACION;
					$row['url']					= site_url('prefactura/ver_prefactura/'.$value->ID_PREFACTURA);
					$data[] = $row;
				}
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}


	public function rechazar_prefactura(){

		// var_dump ($this->input->post());
		// die();
		$this->data = array('estado' => FALSE, 'mensaje' => NULL);
		if ($this->input->is_ajax_request()) {

			$this->form_validation->set_rules('id_prefactura'		, 'id_prefactura' 				, 'trim|required');
			$this->form_validation->set_rules('periodo'				, 'periodo' 					, 'trim|required');
			
			if ( $this->form_validation->run() == TRUE) {

				$validacion = $this->m_apertura->get_validacion_mes($this->input->post('periodo'));
				if($validacion == 1 ){

					$id_prefactura = $this->input->post('id_prefactura');
					$this->data['estado'] = $this->m_prefactura->rechazar_prefactura($id_prefactura);
					// $this->data['estado'] = true;
				}else{
					$this->data['mensaje']['validacion'] = '<p>El periodo que intenta ingresar no se encuentra abierto</p>';

				}
			}else {
				foreach ($this->input->post() as $key => $value) 
				{
					$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
					$this->data['mensaje'][$key] = form_error($key);
				}
			}


			$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
		}
	}

//
	public function aprobar_prefactura(){
		// var_dump ($this->input->post());
		// die();
		$this->data = array('estado' => FALSE, 'mensaje' => NULL);
		if ($this->input->is_ajax_request()) {

			$this->form_validation->set_rules('id_prefactura'		, 'id_prefactura' 				, 'trim|required');
			$this->form_validation->set_rules('periodo'				, 'periodo' 					, 'trim|required');
			
			if ( $this->form_validation->run() == TRUE) {

				$validacion = $this->m_apertura->get_validacion_mes($this->input->post('periodo'));
				if($validacion == 1 ){

					$id_prefactura = $this->input->post('id_prefactura');
					$this->data['estado'] = $this->m_prefactura->aprobar_prefactura($id_prefactura);
					// $this->data['estado'] = true;
				}else{
					$this->data['mensaje']['validacion'] = '<p>El periodo que intenta ingresar no se encuentra abierto</p>';

				}
			}else {
				foreach ($this->input->post() as $key => $value) 
				{
					$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
					$this->data['mensaje'][$key] = form_error($key);
				}
			}


			$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
		}
	}

}

/* End of file C_m_actos.php */
/* Location: ./application/controllers/C_m_actos.php */