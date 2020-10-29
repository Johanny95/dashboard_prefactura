<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_usuarios extends CI_Model {
	private $id = 'U.USUID';
	private $nombre = 'U.USUNOM';
	private $oficina_origen = 'U.OF_ORIGEN';
	private $oficina_codigo = 'U.OFICOD';
	private $oficina_nombre = 'O.NOMBRE_OFICINA';
	private $id_login = 'U.USULOGIN';
	private $nombre_departamento = 'D.NOM_DEPTO';
	private $rol = 'I.ROLID';
	private $webusuario = 'WEBUSUARIO U';
	private $webdepartamento = 'PF_MA_DEPARTAMENTOS D';
	private $weboficina = 'PF_OFICINA@OBIOPER O';
	private $webrol = 'ITR_USUROL I';
	private $where_departamento = 'U.ID_DEPTO = D.ID_DEPTO';
	private $where_oficina = 'O.CODIGO_OFICINA = U.OF_ORIGEN';
	private $where_id = 'I.USUID = U.USUID';
	private $where_login = 'U.RUT_USUARIO';
	private $where_clave = 'USUCLAVE';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->hpferi = $this->load->database('hpferi', TRUE);
	}

	public function get_usuarios($autocompletar)
	{
		$this->db->select('U.USUID ID_USUARIO');
		$this->db->select('U.USUNOM NOMBRE');
		$this->db->from('WEBUSUARIO U');
		$this->db->join('ITR_USUROL UR', 'U.USUID = UR.USUID' , NULL, FALSE);
		$this->db->where('UR.ROLID = 75');
		$this->db->where("UPPER(U.USUNOM) LIKE UPPER('%".$autocompletar."%')");
		$query = $this->db->get();
		return $query->result();
	}


	public function get_organizaciones(){
		$this->hpferi->select('ORGANIZATION_ID ID');
		$this->hpferi->select('ORGANIZATION_NAME ORGANIZACION');
		$this->hpferi->select('ORGANIZATION_CODE');
		$this->hpferi->from('APPS.ORG_ORGANIZATION_DEFINITIONS');
		$this->hpferi->where('DISABLE_DATE IS NULL');
		$this->hpferi->where('OPERATING_UNIT', 103, false);
		$this->hpferi->where("ORGANIZATION_ID IN (SELECT DC.CODIGO
			FROM APPS.DEV_LOOKUP_TYPES DT, 
			APPS.DEV_LOOKUP_CODES DC
			WHERE DT.DEV_LOOKUP_TYPE_ID = DC.DEV_LOOKUP_TYPE_ID
			AND DT.FLAG = 'S'
			AND DC.FLAG = 'S'
			AND DT.TYPE_NAME = 'PF_PREFACT_ORG_SISTEMA')");
		$query = $this->hpferi->get();
		return $query->result();
	}


	// public function (){
	// 	$this->db->select('ROLID');
	// 	$this->db->select('NOMBRE');
	// 	$this->db->from('ITR_ROL');
	// 	$this->db->where("ROLID IN (SELECT DC.CODIGO
	// 										    FROM APPS.DEV_LOOKUP_TYPES@PPFERI DT, 
	// 										         APPS.DEV_LOOKUP_CODES@PPFERI DC
	// 										    WHERE DT.DEV_LOOKUP_TYPE_ID = DC.DEV_LOOKUP_TYPE_ID
	// 										    AND DT.FLAG = 'S'
	// 										    AND DC.FLAG = 'S'
	// 										    AND DT.TYPE_NAME = 'PF_PREFACT_ROLES_SISTEMAS')");
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }


	public function get_roles($autocompletar){
		// die(var_dump($autocompletar));
		$curs = $this->db->get_cursor();
		$this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_ROLES_SISTEMA", array
			(
				array('name' => ':AUTOCOMPLETAR', 'value' => $autocompletar,'type' => SQLT_CHR,'length' => -1),
				array('name' => ':CUR_USU',		  'value' => $curs,'type' => OCI_B_CURSOR,'length' => -1)
			)
		);
		oci_execute($curs);
		$data = array();
		while (($row = oci_fetch_object($curs)) != false) {
			$data[] = $row;
		}
		oci_free_statement($curs);
		$result = $data;
		return $result; 
	}

	public function get_usurol_sistema($autocompletar){
		// die(var_dump($autocompletar));
		$curs = $this->db->get_cursor();
		$this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_ROLES_SISTEMA_USUARIO", array
			(
				array('name' => ':P_FILTRO', 		'value' => $autocompletar,'type' => SQLT_CHR,'length' => -1),
				array('name' => ':CUR_USU',		    'value' => $curs,'type' => OCI_B_CURSOR,'length' => -1)
			)
		);
		oci_execute($curs);
		$data = array();
		while (($row = oci_fetch_object($curs)) != false) {
			$data[] = $row;
		}
		oci_free_statement($curs);
		$result = $data;
		return $result; 
	}


	public function add_usu_rol($elemento){

		$aux = array();
		$sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_ADD_USUROL(:P_USUID,:P_IDROL,:P_ORG,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
		oci_bind_by_name($sp, ":P_USUID"			,    $elemento['USUARIO']			, 1000);
		oci_bind_by_name($sp, ":P_IDROL"			,    $elemento['IDROL']				, 1000);
		oci_bind_array_by_name( $sp, ":P_ORG"       ,    $elemento['ORG'] 				, count($elemento['ORG']), -1, SQLT_CHR);
		oci_bind_by_name($sp, ":P_ID_USUARIO"		,    $elemento['USUARIO_SESSION']	, 1000);
		oci_bind_by_name($sp, ":P_ESTADO_PROCESO"	,    $aux[]	);
		oci_execute($sp, OCI_DEFAULT);
		return (!empty($aux[0])) ? $aux[0] : 0;
	}

	public function get_org_usuario($id_usuario){
		$curs = $this->db->get_cursor();
		$this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_ORG_USUARIO", array
			(
				array('name' => ':P_ID_USER', 		'value' => $id_usuario 	, 'type' => SQLT_CHR,'length' => -1),
				array('name' => ':CUR_USU',		    'value' => $curs 		, 'type' => OCI_B_CURSOR,'length' => -1)
			)
		);
		oci_execute($curs);
		$data = array();
		while (($row = oci_fetch_object($curs)) != false) {
			$data[] = $row;
		}
		oci_free_statement($curs);
		$result = $data;
		return $result;
	}

	public function get_rol_usuario($id_usuario){
		$curs = $this->db->get_cursor();
		$this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_USUARIO_ROLES", array
			(
				array('name' => ':P_ID_USER', 		'value' => $id_usuario 	, 'type' => SQLT_CHR,'length' => -1),
				array('name' => ':CUR_USU',		    'value' => $curs 		, 'type' => OCI_B_CURSOR,'length' => -1)
			)
		);
		oci_execute($curs);
		$data = array();
		while (($row = oci_fetch_object($curs)) != false) {
			$data[] = $row;
		}
		oci_free_statement($curs);
		$result = $data;
		return $result;
	}

	public function upd_usu_rol($elemento){

		$aux = array();
		$sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_UPD_USUROL(:P_USUID,:P_ORG,:P_ROL,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
		oci_bind_by_name($sp, ":P_USUID"			,    $elemento['USUARIO']			, 1000);
		oci_bind_array_by_name( $sp, ":P_ORG"       ,    $elemento['ORG'] 				, count($elemento['ORG'])		, -1, SQLT_CHR);
		oci_bind_array_by_name( $sp, ":P_ROL"       ,    $elemento['ROLES'] 			, count($elemento['ROLES'])		, -1, SQLT_CHR);
		oci_bind_by_name($sp, ":P_ID_USUARIO"		,    $elemento['USUARIO_SESSION']	, 1000);
		oci_bind_by_name($sp, ":P_ESTADO_PROCESO"	,    $aux[]	);
		oci_execute($sp, OCI_DEFAULT);
		return (!empty($aux[0])) ? $aux[0] : 0;
	}



}

/* End of file M_home.php */
/* Location: ./application/models/M_home.php */