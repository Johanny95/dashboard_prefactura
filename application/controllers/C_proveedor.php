<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_proveedor extends FS_Controller {
	private $view_ver = 'proveedor/listado';
	private $view_agregar = 'proveedor/registrar';

	private $datos = 'datos';
	private $data = array();
	private $id = 'id';
	private $mensaje = 'mensaje';
	private $estado = 'estado';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_proveedor', 'm_model');
		$this->load->model('M_servicio' , 'm_servicio');
	}

	public function view_todo()
	{
		$this->css();
		$this->js();
		$autocompletar = "";
		$this->data[$this->datos] = $this->m_model->get($autocompletar);
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

	public function add()
	{ 
		$this->data[$this->estado] = FALSE;
		$this->data[$this->mensaje] = array();
		if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('proveedor'		, 'Proveedor' 		, 'trim|required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('organizaciones'	, 'Organizaciones' 	, 'trim|required');
            $this->form_validation->set_rules('servicios'		, 'servicios'		, 'trim|required');

            if ($this->form_validation->run() == true) {
        		$proveedor 			= $this->input->post('proveedor');
        		$organizaciones		= explode(',', $this->input->post('organizaciones'));
        		$servicios 			= explode(',', $this->input->post('servicios'));
        		$elemento = array(
        			'proveedor' 		=> $proveedor,
        			'organizaciones'	=> $organizaciones,
        			'servicios'			=> $servicios,
        			'usuario'			=> $this->session->usuid
        		);
            	$this->data[$this->estado] = $this->m_model->add($elemento);
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

    public function edit()
    {

		$this->data[$this->estado]  = FALSE;
		$this->data[$this->mensaje] = array();
    	if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('nombre'				, 'Razon Social'	, 'trim|required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('id_proveedor_edit'	, 'Id proveedor'	, 'trim|required|max_length[150]');
            $this->form_validation->set_rules('estado_edit'			, 'Estado'			, 'trim|required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('organizaciones_edit' , 'Organizaciones'	, 'trim|required');
            $this->form_validation->set_rules('servicios_edit' 		, 'Servicios'		, 'trim|required');

    		if ($this->form_validation->run() == TRUE) {
    			$organizaciones		= explode(',', $this->input->post('organizaciones_edit'));
    			$servicios			= explode(',', $this->input->post('servicios_edit'));
        		$elemento = array(
        			'proveedor' 		=> $this->input->post('id_proveedor_edit'),
        			'estado' 			=> $this->input->post('estado_edit'),
        			'razon_social' 		=> $this->input->post('nombre'),
        			'organizaciones'	=> $organizaciones,
        			'servicios'			=> $servicios,
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


	public function get_proveedores_registrados(){
    	$data = array();
		if ($this->input->is_ajax_request()) {
			$autocompletar = $this->input->post('autocompletar');
			$result 		= $this->m_model->get($autocompletar);
			if (!empty($result)) {
				foreach ($result as $key) {
					$row = array();
					$row['id'] = $key->ID;
					$row['nombre'] = $key->RUT_PROVEEDOR.' | '.$key->NOMBRE;
					$data[]  = $row;
				}	
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));	
    }
	
	public function get_proveedores_by_org(){
		$data = array();
		if ($this->input->is_ajax_request()) {
			
			$elemento = array(
				'autocompletar' => $this->input->post('autocompletar'),
				'org_id'		=> $this->input->post('org_id')
			);
			$result 		= $this->m_model->get_proveedores_org($elemento);
			if (!empty($result)) {
				foreach ($result as $key) {
					$row = array();
					$row['id'] = $key->ID;
					$row['nombre'] = $key->RUT_PROVEEDOR.' | '.$key->NOMBRE;
					$data[]  = $row;
				}	
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));		
	}


}

/* End of file C_m_actos.php */
/* Location: ./application/controllers/C_m_actos.php */