<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subir
{
	protected $ci;
	private $dir_upload = 'uploads';
	private $dir_upload_meta = 'uploads/metas';

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	public function get_dir_meta()
	{
		return $this->dir_upload_meta;
	}

	public function dir_upload_meta()
	{
		$this->dir_upload();
		if (!is_dir($this->dir_upload_meta)) {
			mkdir($this->dir_upload_meta);
		}
	}

	public function upload_meta()
	{
		$this->dir_upload_meta();
		$ci = &get_instance();
		$ci->load->library('upload');
		$config['upload_path']   = realpath(APPPATH. '../uploads/metas');
		$config['file_name']     = date('d-m-Y_h-i-s').'_metas_'.$ci->session->rut;
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['max_size']      = '*';
	    $ci->upload->initialize($config);
		if (!$ci->upload->do_upload('file')){
			$error = array('error' => '<span class="help-block">'.$ci->upload->display_errors().'</span>', 'status' => FALSE);
			return $error;
		}
		else{
			$data = array('upload_data' => $ci->upload->data(), 'status' => TRUE);
			return $data;
		}
	}
}

/* End of file Funciones.php */
/* Location: ./application/libraries/Funciones.php */
