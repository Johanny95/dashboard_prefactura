<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_proveedor extends CI_Model { 
	private $por = '';
    private $usuid = '';
	public function __construct()
	{
		parent::__construct();
		$this->por = $this->session->rut;
        $this->usuid = $this->session->usuid;
		$this->load->database();

	} 


    public function add($elemento){
        $aux = array();
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_ADD_PROVEEDOR(:P_VENDOR_ID,:P_ORG,:P_SERVICIOS,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
        oci_bind_by_name(       $sp, ":P_VENDOR_ID"        ,    $elemento['proveedor']         , 1000);
        oci_bind_array_by_name( $sp, ":P_ORG"              ,    $elemento['organizaciones']    , count($elemento['organizaciones'])         , -1, SQLT_CHR);
        oci_bind_array_by_name( $sp, ":P_SERVICIOS"        ,    $elemento['servicios']         , count($elemento['servicios'])              , -1, SQLT_CHR);
        oci_bind_by_name(       $sp, ":P_ID_USUARIO"       ,    $elemento['usuario']           , 1000);
        oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"   ,    $aux[] );
        oci_execute($sp, OCI_DEFAULT);
        return (!empty($aux[0])) ? true : false;
    }
    

    public function del($id)
    {   
        $this->db->trans_begin();
        $this->db->set('FECHA_ELIMINACION', 'SYSDATE', FALSE);
        $this->db->set('USUARIO_ELIMINACION', $this->usuid);
        $this->db->where('ID_PROVEEDOR', $id, FALSE);
        $this->db->update('PF_FACT_PROVEEDORES');
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }   
    }

    public function upd($elemento)
    {
        $aux = array();
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_UPD_PROVEEDOR(:P_VENDOR_ID,:P_ORG,:P_SERVICIOS,:P_RAZON_SOCIAL,:p_ESTADO,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
        oci_bind_by_name(       $sp, ":P_VENDOR_ID"        ,    $elemento['proveedor']          , 1000);
        oci_bind_array_by_name( $sp, ":P_ORG"              ,    $elemento['organizaciones']     , count($elemento['organizaciones'])       , -1, SQLT_CHR);
        oci_bind_array_by_name( $sp, ":P_SERVICIOS"        ,    $elemento['servicios']          , count($elemento['servicios'])       , -1, SQLT_CHR);
        oci_bind_by_name(       $sp, ":P_RAZON_SOCIAL"     ,    $elemento['razon_social']       , 1000);
        oci_bind_by_name(       $sp, ":p_ESTADO"           ,    $elemento['estado']             , 1000);
        oci_bind_by_name(       $sp, ":P_ID_USUARIO"       ,    $elemento['usuario']            , 1000);
        oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"   ,    $aux[] );
        oci_execute($sp, OCI_DEFAULT);
        return (!empty($aux[0])) ? true : false;   
    }

    public function get($autocompletar)
    {
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_PROVEEDORES_SISTEMA", array
            (
                array('name' => ':P_FILTRO',       'value' => $autocompletar  , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':CUR_USU',         'value' => $curs        , 'type' => OCI_B_CURSOR,'length' => -1)
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

    public function get_proveedores_org($elemento)
    {
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_PROVEEDORES_BY_ORG", array
            (
                array('name' => ':P_FILTRO',       'value' => $elemento['autocompletar']  , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':P_ORG_ID',       'value' => $elemento['org_id']  , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':CUR_USU',         'value' => $curs        , 'type' => OCI_B_CURSOR,'length' => -1)
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

    

    public function getNumRows($id)
    {
        $this->db->select('*');
        $this->db->from('PF_FACT_PROVEEDORES');
        $this->db->where('FECHA_ELIMINACION IS NULL');
        $this->db->where('ID_PROVEEDOR', $id, FALSE);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_vendors($autocompletar){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_VENDORS", array
            (
                array('name' => ':P_FILTRO',       'value' => $autocompletar  , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':CUR_USU',         'value' => $curs        , 'type' => OCI_B_CURSOR,'length' => -1)
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

    

    public function get_org_proveedor($id_proveedor){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_ORG_PROVEEDOR", array
            (
                array('name' => ':P_ID_PROVEEDOR',  'value' => $id_proveedor  , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':CUR_USU',         'value' => $curs          , 'type' => OCI_B_CURSOR,'length' => -1)
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



       public function get_servicios_proveedor($id_proveedor){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_SERVICIOS_PROVEEDOR", array
            (
                array('name' => ':P_ID_PROVEEDOR',  'value' => $id_proveedor  , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':CUR_USU',         'value' => $curs          , 'type' => OCI_B_CURSOR,'length' => -1)
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

    


}

/* End of file M_cargo.php */
/* Location: ./application/models/M_cargo.php */