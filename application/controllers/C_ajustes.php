<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_ajustes extends FS_Controller {
	private $view_ver = 'ajustes/listado';
	private $view_agregar = 'ajustes/registrar';
    // private $view_conceptos = 'concepto/solicitud_cambio';

	private $datos = 'datos';
	private $data = array();
	private $id = 'id';
	private $mensaje = 'mensaje';
	private $estado = 'estado';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_concepto'	, 'm_model');
		$this->load->model('M_apertura'	, 'm_apertura');
		$this->load->model('M_evento'	, 'm_evento');
		$this->load->model('M_ajuste'	, 'm_ajuste');

	}

	public function view_todo()
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

	public function ver_ajuste( $id_ajuste ){
		$this->css();
		$this->js();
		$elemento = array(
			'id_ajuste'			=>  $id_ajuste ,
			'organizaciones'	=>  null,
			'periodo'			=>  null
		);
		$this->data['ajustes'] = $this->m_ajuste->get_ajustes($elemento);
		$this->load->view($this->view_head());
		$this->load->view('ajustes/detalle', $this->data);
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

	public function add_ajuste(){

		$this->data = array('estado' => FALSE, 'mensaje' => NULL);
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('fecha'			, 'Periodo' 				, 'trim|required|min_length[3]|max_length[150]');
			$this->form_validation->set_rules('organizaciones'	, 'Organización' 			, 'trim|required');
			$this->form_validation->set_rules('proveedor'		, 'Proveedor' 				, 'trim|required|max_length[150]');
			$this->form_validation->set_rules('servicios'		, 'Servicios' 				, 'trim|required');
			$this->form_validation->set_rules('numero_guia'		, 'Numero de guia' 			, 'trim');
			$this->form_validation->set_rules('concepto'		, 'Concepto' 			, 'trim|required');
			

			$this->form_validation->set_rules('cantidad1'		, 'Cantidad 1' 			, 'trim|required');
			$this->form_validation->set_rules('cantidad2'		, 'Cantidad 2' 			, 'trim');
			$this->form_validation->set_rules('cantidad3'		, 'Cantidad 3' 			, 'trim');


			if ( $this->form_validation->run() == TRUE) {
				$periodo 	=  $this->input->post('fecha');
				$servicio 	=  $this->input->post('servicios');
				$org 		=  $this->input->post('organizaciones');
				$proveedor 	=  $this->input->post('proveedor');
				$numero_guia=  $this->input->post('numero_guia');
				$periodo_dir=  str_replace('/', '-', $periodo);

				$validacion = $this->m_apertura->get_validacion_mes($periodo);
				if($validacion == 1 ){
					$pathname = "upload/ajustes/$org/$periodo_dir/$proveedor";
					if (!is_dir( $pathname )) {
						mkdir( $pathname , 0777, true);
					}
					$config["upload_path"] = $pathname;
					$config["overwrite"] = TRUE;
					$config["allowed_types"] = 'jpg|png|jpeg|pdf';
					$config['file_name']   = 'guia_'.date('Y-m-d_h_i_s');
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload('file')){
						$file 			  =  $this->upload->data();
						$ajuste = array(	"periodo" 		=> $periodo,
											"org"			=> $org,
											"proveedor"		=> $proveedor,
											"url"			=> $pathname.'/'.$file['file_name'],
											"servicio" 		=> $servicio,
											"numero_guia"	=> $numero_guia,
											"concepto"		=> $this->input->post('concepto'),
											"cantidad1"		=> $this->input->post('cantidad1'),
											"cantidad2"		=> ($this->input->post('cantidad2') ? $this->input->post('cantidad3') : 0),
											"cantidad3"		=> ($this->input->post('cantidad3') ? $this->input->post('cantidad3') : 0)
						);
						// var_dump ($ajuste);
						// die();

						$this->data['estado'] = $this->m_ajuste->agregar_ajuste($ajuste);

					}else{
						$this->data['mensaje']['validacion'] = '<p>'.$this->upload->display_errors().'</p>';
					}

				}else{
					$this->data['mensaje']['fecha'] = '<p class="text-danger">El periodo que intenta ingresar no se encuentra abierto</p>';
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
	
	public function get_ajustes()
	{
		$data 		= array();

		$elemento 	= array(
			'periodo' 			=> $this->input->post('periodo'),
			'organizaciones'	=> (($this->input->post('org')) ?  implode(',',$this->input->post('org')) : '0' ),
			'id_ajuste'			=> -1
		);

		if ($this->input->is_ajax_request()) {
			$get = $this->m_ajuste->get_ajustes($elemento);

			// var_dump ($get);
			// die();


			if (!empty($get)) {
				foreach ($get as $value) {
					$row = array();
					$row['id_ajuste']			= $value->ID_AJUSTE;
					$row['periodo'] 			= $value->PERIODO;
					$row['proveedor']			= $value->RUT_PROVEEDOR.' | '.$value->NOMBRE_PROVEEDOR;
					$row['organizacion']		= $value->ORGANIZACION;
					$row['estado']				= $value->ESTADO;
					$row['fecha_creacion'] 		= $value->FECHA_CREACION;
					$row['concepto'] 			= $value->CONCEPTO;
					$row['doc']					= base_url().$value->DOCUMENTO;
					$row['url']					= site_url().'ajustes/ver_ajuste/'.$value->ID_AJUSTE;
					$row['creador']					= $value->CREADOR;
					$data[] = $row;
				}
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}


}

/* End of file C_m_actos.php */
/* Location: ./application/controllers/C_m_actos.php */