<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_eventos extends FS_Controller {
	private $view_ver = 'eventos/listado';
	private $view_agregar = 'eventos/eventos';
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

	public function ver_evento( $id_evento ){
		$this->css();
		$this->js();

		$elemento = array(
				'id_evento'			=>  $id_evento ,
				'organizaciones'	=>  null,
				'periodo'			=>  null
		);

		$this->data['evento'] = $this->m_evento->get_eventos($elemento);
		$this->load->view($this->view_head());
		$this->load->view('eventos/detalle', $this->data);
		$this->load->view($this->view_footer());
	}

	public function view_eventos()
	{
		$this->css();
		$this->js();
		$this->load->view($this->view_head());
		$this->load->view($this->view_agregar);
		$this->load->view($this->view_footer());	
	}

	

	public function registrar_evento(){
		$this->data = array('estado' => FALSE, 'mensaje' => NULL);
		if ($this->input->is_ajax_request()) {

			$array_servicios = array();
			$this->form_validation->set_rules('fecha'			, 'Periodo' 				, 'trim|required|min_length[3]|max_length[150]');
			$this->form_validation->set_rules('organizaciones'	, 'Organización' 			, 'trim|required');
			$this->form_validation->set_rules('proveedor'		, 'Proveedor' 				, 'trim|required|max_length[150]');
			$this->form_validation->set_rules('servicios'		, 'Servicios' 				, 'trim|required');
			$this->form_validation->set_rules('numero_guia'		, 'Numero de guia' 			, 'trim|required');
			

			$array_servicios = json_decode($this->input->post('servicios'));

			foreach ($array_servicios as $key => $s) {
				foreach ($s->CONCEPTOS as $key => $c) {
					$this->form_validation->set_rules($c.'_cantidad1'	, 'Cantidad 1' 			, 'trim|required');
					$this->form_validation->set_rules($c.'_cantidad2'	, 'Cantidad 2' 			, 'trim');
					$this->form_validation->set_rules($c.'_cantidad3'	, 'Cantidad 3' 			, 'trim');
				}
			}
			if ( $this->form_validation->run() == TRUE) {	

				$periodo 	=  $this->input->post('fecha');
				$servicio 	=  $this->input->post('servicios');
				$org 		=  $this->input->post('organizaciones');
				$proveedor 	=  $this->input->post('proveedor');
				$numero_guia=  $this->input->post('numero_guia');
				$periodo_dir=  str_replace('/', '-', $periodo) ;

				$validacion = $this->m_apertura->get_validacion_mes($periodo);
				if($validacion == 1 ){
					$pathname = "upload/eventos/$org/$periodo_dir/$proveedor";
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
						$servicios = array();
						foreach ($array_servicios as $key => $s) {
							$conceptos = array();
							foreach ($s->CONCEPTOS as $key => $c) {

								$conceptos[] = implode('|',
									array( $c,
										$this->input->post($c.'_cantidad1'),
										($this->input->post($c.'_cantidad2') ? $this->input->post($c.'_cantidad2') : 0),
										($this->input->post($c.'_cantidad3') ? $this->input->post($c.'_cantidad3') : 0)
									));
							}
							array_push( $servicios, $s->ID.'='.implode('#',$conceptos));
						}
						$evento = array(	"periodo" 		=> $periodo,
											"org"			=> $org,
											"proveedor"		=> $proveedor,
											"url"			=> $pathname.'/'.$file['file_name'],
											"servicios" 	=> $servicios,
											"numero_guia"	=> $numero_guia
						);
						// var_dump ($evento);
						// die();
						$this->data['estado'] = $this->m_evento->agregar_evento($evento);

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
	
	public function get_eventos()
	{
		$data 		= array();

		$elemento 	= array(
						'periodo' 			=> $this->input->post('periodo'),
						'organizaciones'	=> (($this->input->post('org')) ?  implode(',',$this->input->post('org')) : '0' ),
						'id_evento'			=> -1
		);

		if ($this->input->is_ajax_request()) {
			$get = $this->m_evento->get_eventos($elemento);
			if (!empty($get)) {
				foreach ($get as $value) {
					$row = array();
					$row['id_evento']			= $value['id_evento'];
					$row['periodo'] 			= $value['periodo'];
					$row['proveedor']			= $value['rut_proveedor'].' | '.$value['nombre_proveedor'];
					$row['organizacion']		= $value['organizacion'];
					$row['estado']				= $value['estado'];
					$row['fecha_creacion'] 		= $value['fecha_creacion'];
					$row['doc']					= base_url().$value['documento'];
					$row['url']					= site_url().'eventos/ver_evento/'.$value['id_evento'];
					$data[] = $row;
				}
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}


}

/* End of file C_m_actos.php */
/* Location: ./application/controllers/C_m_actos.php */