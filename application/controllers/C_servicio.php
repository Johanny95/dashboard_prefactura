<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_servicio extends FS_Controller {
	private $view_ver = 'servicios/listado';
	private $view_agregar = 'servicios/registrar';

	private $datos = 'datos';
	private $data = array();
	private $id = 'id';
	private $mensaje = 'mensaje';
	private $estado = 'estado';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_servicio', 'm_model');
	}

	public function view_todo()
	{
		$this->css();
		$this->js();
		$this->data[$this->datos] = $this->m_model->get();
		$this->load->view($this->view_head());
		$this->load->view($this->view_ver, $this->data);
		$this->load->view($this->view_footer());
	}

	public function view_registrar()
	{
		$this->load->view($this->view_head());
		$this->load->view($this->view_agregar);
		$this->load->view($this->view_footer());	
	}

	public function add()
	{
		$this->data[$this->estado] = FALSE;
		$this->data[$this->mensaje] = array();
		if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[3]|max_length[150]|callback_alpha_dash');
            if ($this->form_validation->run() == TRUE) {
            	$this->data[$this->estado] = $this->m_model->add(strtoupper($this->input->post('nombre')));
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
            $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[3]|max_length[150]|callback_alpha_dash');
    		if ($this->form_validation->run() == TRUE) {
    			$data                 = new \stdClass();
    			$data->id             = $this->input->post('id');
    			$data->nombre         = $this->input->post('nombre');
    			$this->data[$this->estado] = $this->m_model->upd($data);
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


    public function get_servicios(){
		$data['servicios'] = $this->m_model->get();
		echo json_encode($data);
	}
    

}

/* End of file C_m_actos.php */
/* Location: ./application/controllers/C_m_actos.php */