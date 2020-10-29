<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HO_Controller extends CI_Controller{
	private $login   = 'login';

	public function __construct() {
		parent::__construct();
		if ($this->agent->browser() == 'Internet Explorer' && $this->agent->version() <= 11) {
			redirect(site_url('usuario/denegado'), 'refresh');
		}else{
			$this->load->library('Limpiar_log');
			$this->load->library('login');
		}
	}

	public function view_login()
	{
		return $this->login;
	}

}

class HE_Controller extends CI_Controller{
	private $head   = 'template/header';
	private $footer = 'template/footer';

	public function view_head()
	{
		return $this->head;
	}

	public function view_footer()
	{
		return $this->footer;
	}
}

class US_Controller extends CI_Controller{
	private $head   = 'template/header';
	private $footer = 'template/footer';

	public function __construct() {
		parent::__construct();
		if($this->session->login == FALSE || $this->session->login == NULL) {
			redirect(base_url(),'refresh');
		}else{
			ini_set('memory_limit', '586M');
			$this->load->library('funcion');
			$this->session->set_userdata(array('last_visited' => time()));
		}
	}

	public function view_head()
	{
		return $this->head;
	}

	public function view_footer()
	{
		return $this->footer;
	}
}




class FS_Controller extends CI_Controller{
	private $head   = 'template/header';
	private $footer = 'template/footer';
	
	public function __construct() {
		parent::__construct();
		if($this->session->login == FALSE || $this->session->login == NULL) {
			redirect(base_url(),'refresh');
		}else{
			ini_set('memory_limit', '586M');
			$this->load->library('funcion');
			$this->session->set_userdata(array('last_visited' => time()));
		}
	}

	public function view_head()
	{
		return $this->head;
	}

	public function view_footer()
	{
		return $this->footer;
	}

	public function css()
	{
		$css = array(
			'resource/bower_components/select2/dist/css/select2.min.css',
			'resource/plugins/JGallery/css/jgallery.min.css',
			'resource/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
			'resource/bower_components/bootstrap-daterangepicker/daterangepicker.css',
			'resource/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
			'resource/plugins/toggle/bootstrap-toggle.min.css',
			'resource/plugins/iCheck/all.css',
			'resource/bower_components/treetable/jquery-treetable.css',
			'resource/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css',
			'resource/plugins/toggle/bootstrap-toggle.min.css',
			'resource/plugins/bootstrap-fileinput/css/fileinput.min.css'
		);
		add_css_dy($css);
		return;	
	}

	public function js()
	{
		$js = array(
			'resource/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
			'resource/bower_components/datatables.net/js/jquery.dataTables.min.js',
			'resource/plugins/datatables/dataTables.rowsGroup.js',
			'resource/plugins/iCheck/icheck.js',
			'resource/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
			'resource/bower_components/moment/min/moment.min.js',
			'resource/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
			'resource/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js',
			'resource/plugins/datatables/extensions/bootstrap_extensions/js/dataTables.buttons.min.js',
			'resource/plugins/datatables/extensions/bootstrap_extensions/js/buttons.bootstrap.min.js',
			'resource/plugins/input-mask/jquery.inputmask.bundle.js',
			'resource/bower_components/select2/dist/js/select2.full.min.js',
			 'resource/bower_components/select2/dist/js/i18n/es.js',
			'resource/plugins/toggle/bootstrap-toggle.min.js',
			'resource/bower_components/bootstrap-daterangepicker/daterangepicker.js',
			'resource/plugins/datatables/extensions/bootstrap_extensions/js/buttons.html5.min.js',
			'resource/plugins/datatables/extensions/bootstrap_extensions/js/buttons.colVis.min.js',
			'resource/plugins/jszip.min.js',
			'resource/plugins/pdfmake.min.js',
			'resource/bower_components/treetable/jquery-treetable.js',
			'resource/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js',
			'resource/bower_components/bootstrap-select/dist/js/i18n/defaults-es_CL.min.js',
			'resource/plugins/toggle/bootstrap-toggle.min.js',
			'resource/plugins/rut/jquery.rut.chileno.min.js',
			'resource/plugins/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js',
			'resource/plugins/bootstrap-fileinput/js/plugins/sortable.min.js',
			'resource/plugins/bootstrap-fileinput/js/plugins/purify.min.js',
			'resource/plugins/bootstrap-fileinput/js/fileinput.min.js',
			'resource/plugins/bootstrap-fileinput/js/locales/es.js'
		);
		add_js_dy($js);
		return;
	}
}