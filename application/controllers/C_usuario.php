<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_usuario extends FS_Controller {
	/**
	 * Controlador  Login
	 * 
	 * @Package		
	 * @Autor       Paolo Castillo
	 * @link        <http://url/dashboard_abastecimiento/index.php/perfil.html>
	 */

	/**
	 * Controlador   Class
	 * HO_Controller HO_Controller
	 * @subpackage   Libreria Login
	 * @categoria    Libreria
	 */
	private $body_perfil = 'usuario/perfil';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_usuarios','usuario');
	}

	public function view_perfil()
	{	
		$this->css();
		$this->js();
		$this->load->view($this->view_head());
		$this->load->view($this->body_perfil);
		$this->load->view($this->view_footer());
	}

	public function view_usuarios(){
		
		$this->css();
		$this->js();
		$data['organizaciones'] = $this->usuario->get_organizaciones();
		$this->load->view($this->view_head());
		$this->load->view('usuario/usuarios_config',$data,false);
		// $this->load->view('usuario/usuarios_config');
		$this->load->view($this->view_footer());	
	}


	public function get_roles(){

		$data = array();
		if ($this->input->is_ajax_request()) {
			$autocompletar = $this->input->post('autocompletar');
			$get = $this->usuario->get_roles($autocompletar);
			if (!empty($get)) {
				foreach ($get as $value) {
					$row = array();
					$row['id'] = $value->ROLID;
					$row['nombre'] = $value->NOMBRE;
					$data[] = $row;
				}
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
		
	}

	public function get_usuarios(){
		$data = array();
		if ($this->input->is_ajax_request()) {
			$autocompletar = $this->input->post('autocompletar');
			$get = $this->usuario->get_usuarios($autocompletar);
			if (!empty($get)) {
				foreach ($get as $value) {
					$row = array();
					$row['id'] = $value->ID_USUARIO;
					$row['nombre'] = $value->NOMBRE;
					$data[] = $row;
				}
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));

	}

	public function get_usurol_sistema(){
		$data = array();
		if ($this->input->is_ajax_request()) {
			$filter   = $this->input->post('search_filter');
			$result 		= $this->usuario->get_usurol_sistema($filter);
			if (!empty($result)) {
				foreach ($result as $key) {
					$row = array();
					$row[] = $key->USUID;
					$row[] = $key->USUNOM;
					$row[] = $key->RUT_USUARIO;
					$row[] = $key->NOM_DEPTO;
					$row[] = $key->ESTADO;
					$row[] = array('USUID' => $key->USUID , 'USUNOM' => $key->USUNOM, 'RUT_USUARIO' => $key->RUT_USUARIO, 'ROLID' => $key->ROLID, 'NOMBRE_ROL' => $key->NOMBRE, 'ESTADO' => $key->ESTADO);
					$data[]  = $row;
				}	
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));	
	}

	public function get_roles_json(){
		$autocompletar = '';
		$data['roles'] = $this->usuario->get_roles($autocompletar);
		echo json_encode($data);
	}

	public function get_organizaciones_json(){
		$data['organizaciones'] = $this->usuario->get_organizaciones();
		echo json_encode($data);
	}

	public function get_organizaciones_usuario(){
		$usuid 					= $this->input->post('usuid');
		$data['organizaciones_usuario'] = $this->usuario->get_org_usuario($usuid);
		echo json_encode($data);
	}
	public function get_rol_usuario(){
		$usuid 					= $this->input->post('usuid');
		$data['roles_usuario'] = $this->usuario->get_rol_usuario($usuid);
		echo json_encode($data);
	}

	public function upd_rol_usuario(){
		$msg['status']=true;
		$msg['error']='';
		if($this->input->is_ajax_request()){
			$this->form_validation->set_rules('idusuario_edit' 			, 'Usuario' 				, 'trim|required|max_length[50]');

			if($this->form_validation->run() == FALSE){
				$msg['status']=FALSE;
				$msg['error']=validation_errors();
			}else{
				$user       	= $this->session->userdata('usuario');
				$org    = array();
				$roles  = array();
				$org 	= explode(',', ($this->input->post('organizaciones_edit') ? $this->input->post('organizaciones_edit') : '0' ));
				$roles 	= explode(',', ($this->input->post('roles_edit') ? $this->input->post('roles_edit') : '0' ) );
				$elemento   	= array(
					'USUARIO' 			=> $this->input->post('idusuario_edit'),
					'ORG'				=> $org,
					'ROLES'				=> $roles,
					'USUARIO_SESSION'	=> $this->session->usuid
				);
				$msg['result'] 	= $this->usuario->upd_usu_rol($elemento);
				switch ($msg['result']) {
					case 0:
					$msg['status'] = false;
					$msg['error']  = 'Error de base de datos. Contactarse con informática...';
					break;
					case 1:
					$msg['status'] = true;
					break;
					case 2:
					$msg['status'] = false;
					$msg['error']  = 'El usuario ya se encuentra asignado a ese rol';
					break;
				}
			}
		}else{
			$msg['status']=false;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($msg));
	}

}

/* End of file c_usuario.php */
/* Location: ./application/controllers/c_usuario.php */
