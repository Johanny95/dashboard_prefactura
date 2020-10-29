<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_concepto extends FS_Controller {
	private $view_ver = 'concepto/listado';
	private $view_agregar = 'concepto/registrar';
	private $view_solicitudes = 'concepto/solicitud_cambio';

	private $datos = 'datos';
	private $data = array();
	private $id = 'id';
	private $mensaje = 'mensaje';
	private $estado = 'estado';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_concepto', 'm_model');
	}

	public function view_todo()
	{
		$this->css();
		$this->js();
		$this->data[$this->datos] = $this->m_model->get_conceptos();
		$this->load->view($this->view_head());
		$this->load->view($this->view_ver, $this->data);
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

	public function view_aprobacion_solicitud()
	{
		$this->css();
		$this->js();
		$this->data[$this->datos] = $this->m_model->get_solicitudes_cambio();
		$this->load->view($this->view_head());
		$this->load->view($this->view_solicitudes, $this->data);
		$this->load->view($this->view_footer());
	}
	


	public function add()
	{ 

		$this->data = array('estado' => FALSE, 'mensaje' => NULL);
		if ($this->input->is_ajax_request()) {

			$this->form_validation->set_rules('proveedor'		, 'Proveedor' 			, 'trim|required|min_length[3]|max_length[150]');
			$this->form_validation->set_rules('nombre'			, 'Nombre concepto' 	, 'trim|required|min_length[3]|max_length[600]');
			$this->form_validation->set_rules('servicio'		, 'servicio'			, 'trim|required');
			$this->form_validation->set_rules('medida1'			, 'Tipo medida 1'		, 'trim|required');
			$this->form_validation->set_rules('medida2'			, 'Tipo medida 2'		, 'trim|required');
			$this->form_validation->set_rules('medida3'			, 'Tipo medida 3'		, 'trim|required');
			$this->form_validation->set_rules('cta_contable'	, 'Cuenta Contable'		, 'trim|required');
			$this->form_validation->set_rules('precio1'			, 'Precio 1'			, 'trim|required|min_length[1]|max_length[10]|numeric');
			$this->form_validation->set_rules('precio2'			, 'Precio 2'			, 'trim|required|min_length[1]|max_length[10]|numeric');
			$this->form_validation->set_rules('precio3'			, 'Precio 3'			, 'trim|required|min_length[1]|max_length[10]|numeric');
			if ($this->form_validation->run() == true) {
				$proveedor 			= $this->input->post('proveedor');
				$servicio 			= $this->input->post('servicio');
				$elemento = array(
					'proveedor' 		=> $proveedor,
					'servicio'			=> $servicio,
					'nombre'			=> $this->input->post('nombre'),
					'cta'				=> $this->input->post('cta_contable'),
					'precio1'			=> $this->input->post('precio1'),
					'precio2'			=> $this->input->post('precio2'),
					'precio3'			=> $this->input->post('precio3'),
					'medida1'			=> $this->input->post('medida1'),
					'medida2'			=> $this->input->post('medida2'),
					'medida3'			=> $this->input->post('medida3'),
					'validacion_oc'		=> ($this->input->post('check_oc') ? 'S' : 'N' ),
					'usuario'			=> $this->session->usuid
				);
				$pathname = "upload/$proveedor/$servicio";
				if (!is_dir( $pathname )) {
					mkdir( $pathname , 0777, true);
				}
				$config["upload_path"] = $pathname;
				$config["overwrite"] = TRUE;
				$config["allowed_types"] = 'jpg|png|jpeg|pdf';
				$config['file_name']   = 'ficha_concepto_'.date('Y-m-d_h_i_s');
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('file')){
					$this->data['mensaje']['validacion'] = '<p>'.$this->upload->display_errors().'</p>';
				}else{
					$file 			  =  $this->upload->data();
					$elemento['url']  =  $pathname.'/'.$file['file_name'];
					// var_dump ($elemento);
					// die();
					$this->data['estado'] = $this->m_model->add($elemento);
				}

			} else {
				foreach ($this->input->post() as $key => $value) 
				{
					$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
					$this->data['mensaje'][$key] = form_error($key);
				}
			}
			
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}

	public function alpha_dash($name)
	{
		$regex = '/[A-Za-záéíóú_\-\s\/]+$/';

		if(preg_match($regex, $name))
		{
			return TRUE;
		}else{
			$this->form_validation->set_message('alpha_dash', 'El campo {field} solo puede contener caracteres del alfabeto, espacios y separadores comunes.');
			return FALSE;
		}
	}

	public function del()
	{
		$this->data[$this->estado] = FALSE;
		if ($this->input->is_ajax_request()) {
			$this->data[$this->estado] = $this->m_model->del($this->input->post('id'));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}

	public function upd()
	{
		// var_dump ($this->input->post());
		// die();
		$this->data[$this->estado]  = FALSE;
		$this->data[$this->mensaje] = array();
		if ($this->input->is_ajax_request()) {

			$this->form_validation->set_rules('nombre'				, 'Nombre concepto'	, 'trim|required|min_length[3]|max_length[500]');
			$this->form_validation->set_rules('id_concepto'			, 'Id concepto'		, 'trim|required|max_length[150]');
			$this->form_validation->set_rules('estado_edit'			, 'Estado'			, 'trim|required|min_length[3]|max_length[150]|callback_alpha_dash');

			if ($this->form_validation->run() == TRUE) {
				
				$elemento = array(
					'proveedor' 		=> $this->input->post('id_concepto'),
					'estado' 			=> $this->input->post('estado_edit'),
					'razon_social' 		=> $this->input->post('nombre'),
					'validacion_oc'		=> ($this->input->post('check_oc') ? 'S' : 'N' ),
					'usuario'			=> $this->session->usuid
				);

				$this->data[$this->estado] = $this->m_model->upd($elemento);
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

	public function editar_precio()
	{

		$this->data[$this->estado]  = FALSE;
		$this->data[$this->mensaje] = array();
		if ($this->input->is_ajax_request()) {

			$this->form_validation->set_rules('id_concepto'			, 'Id concepto'			, 'trim|required|max_length[1000]');
			$this->form_validation->set_rules('id_precio'			, 'Id Precio'			, 'trim|required|max_length[1000]');
			// $this->form_validation->set_rules('medida1'				, 'Tipo medida 1'		, 'trim|required');
			// $this->form_validation->set_rules('medida2'				, 'Tipo medida 2'		, 'trim|required');
			// $this->form_validation->set_rules('medida3'				, 'Tipo medida 3'		, 'trim|required');
			$this->form_validation->set_rules('cta_contable'		, 'Cuenta Contable'		, 'trim|required');
			$this->form_validation->set_rules('precio1'				, 'Precio 1'			, 'trim|required|min_length[1]|max_length[10]|numeric');
			$this->form_validation->set_rules('precio2'				, 'Precio 2'			, 'trim|required|min_length[1]|max_length[10]|numeric');
			$this->form_validation->set_rules('precio3'				, 'Precio 3'			, 'trim|required|min_length[1]|max_length[10]|numeric');
			$this->form_validation->set_rules('fecha_desde'			, 'Fecha desde'			, 'trim|required');


			if ($this->form_validation->run() == TRUE) {
				$concepto  =  $this->input->post('id_concepto');
				$validador = $this->m_model->get_solicitud_prendientes($concepto);
				if( $validador == 0 ){
					$elemento = array(
						'id_concepto' 		=> $concepto,
						'id_precio'				=> $this->input->post('id_precio'),
						'cta'				=> $this->input->post('cta_contable'),
						'precio1'			=> $this->input->post('precio1'),
						'precio2'			=> $this->input->post('precio2'),
						'precio3'			=> $this->input->post('precio3'),
						// 'medida1'			=> $this->input->post('medida1'),
						// 'medida2'			=> $this->input->post('medida2'),
						// 'medida3'			=> $this->input->post('medida3'),
						'fecha_desde'		=> $this->input->post('fecha_desde'),
						'usuario'			=> $this->session->usuid
					);

					$pathname = "upload/cambio/$concepto";
					if (!is_dir( $pathname )) {
						mkdir( $pathname , 0777, true);
					}
					$config["upload_path"] = $pathname;
					$config["overwrite"] = TRUE;
					$config["allowed_types"] = 'jpg|png|jpeg|pdf';
					$config['file_name']   = 'ficha_concepto_'.date('Y-m-d_h_i_s');
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if(!$this->upload->do_upload('file')){
						$this->data[$this->mensaje]['validacion'] = '<p>'.$this->upload->display_errors().'</p>';
					}else{
						$file 			  =  $this->upload->data();
						$elemento['url']  =  $pathname.'/'.$file['file_name'];
						// var_dump ($elemento);
						// die();
						$this->data[$this->estado] = $this->m_model->solicitud_cambio($elemento);
					}
				}else{
					$this->data[$this->estado]  = FALSE;
					$this->data[$this->mensaje]['validacion'] = "Ya existe una solicitud pendiente de aprobacion para este concepto";
				}

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

	public function get_vendors(){
		$data = array();
		if ($this->input->is_ajax_request()) {
			$filter   = $this->input->post('autocompletar');
			$result 		= $this->m_model->get_vendors($filter);
			if (!empty($result)) {
				foreach ($result as $key) {
					$row = array();
					$row['id'] = $key->ID_PROVEEDOR;
					$row['nombre'] = $key->RUT.' | '.$key->RAZON_SOCIAL;
					$data[]  = $row;
				}	
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));	
	}

	public function get_org_proveedor(){
		$usuid 					= $this->input->post('id_proveedor');
		$data['organizaciones'] = $this->m_model->get_org_proveedor($usuid);
		echo json_encode($data);
	}

	public function get_servicios_proveedor(){
		$usuid 					= $this->input->post('id_proveedor');
		$data['servicios'] = $this->m_model->get_servicios_proveedor($usuid);
		echo json_encode($data);
	}

	public function get_medidas(){
		
		$data = array();
		if ($this->input->is_ajax_request()) {
			$result 		= $this->m_model->get_medidas();
			if (!empty($result)) {
				foreach ($result as $key) {
					$row = array();
					$row['id'] = $key->CODIGO;
					$row['nombre'] = $key->NOMBRE;
					$data[]  = $row;
				}	
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));	
	}


	public function get_cuentas_contables(){
		$data = array();
		if ($this->input->is_ajax_request()) {
			$filter   = $this->input->post('autocompletar');
			$result 		= $this->m_model->get_cuentas_contables($filter);
			if (!empty($result)) {
				foreach ($result as $key) {
					$row = array();
					$row['id'] = $key->CODIGO;
					$row['nombre'] = $key->CODIGO.' | '.$key->NOMBRE;
					$data[]  = $row; 
				}	
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));	
	}


	public function aprobar_cambio(){
		$this->data[$this->estado]  = FALSE;
		$this->data[$this->mensaje] = array();
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('id'				, 'Id Solicitud'	, 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				$elemento = array(
					'id_solicitud' 		=> $this->input->post('id'),
					'id_precio' 		=> $this->input->post('id_precio'),
					'usuario'			=> $this->session->usuid
				);
				$this->data[$this->estado] = $this->m_model->aprobar_cambio($elemento);
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

	public function rechazar_cambio(){
		// var_dump ($this->input->post());
		// die();
		$this->data[$this->estado]  = FALSE;
		$this->data[$this->mensaje] = array();
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('id'				, 'Id Solicitud'	, 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				$elemento = array(
					'id_solicitud' 		=> $this->input->post('id'),
					'usuario'			=> $this->session->usuid
				);
				$this->data[$this->estado] = $this->m_model->rechazar_cambio($elemento);

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
	
	
	public function get_historial_concepto(){
		$data = array();
		if ($this->input->is_ajax_request()) {
			$id_concepto = $this->input->post('id_concepto');
			$result 		= $this->m_model->get_historial_concepto($id_concepto);
			if (!empty($result)) {
				foreach ($result as $key) {
					$row = array();
					$row['id_concepto'] = $key->ID_CONCEPTO;
					$row['id_precio'] = $key->ID_PRECIO;
					$row['nombre'] = $key->NOMBRE_CONCEPTO;
					$row['cta'] = $key->CUENTA_CONTABLE;
					$row['fecha_creacion'] = $key->FECHA_CREACION;
					$row['medida1'] = $key->MEDIDA1;
					$row['precio1'] = $key->PRECIO1;
					$row['medida2'] = $key->MEDIDA2;
					$row['precio2'] = $key->PRECIO2;
					$row['medida3'] = $key->MEDIDA3;
					$row['precio3'] = $key->PRECIO3;
					$row['fecha_desde'] = $key->FECHA_DESDE;
					$row['fecha_hasta'] = $key->FECHA_HASTA;
					$row['documento'] = $key->DOCUMENTO;
					$data[]  = $row;
				}	
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));	
	}
	


}

/* End of file C_m_actos.php */
/* Location: ./application/controllers/C_m_actos.php */