<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_concepto extends CI_Model { 
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
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_ADD_CONCEPTO(:P_VENDOR_ID,:P_SERVICIO,:P_NOMBRE,:P_CUENTA,:P_PRECIO1,:P_PRECIO2,:P_PRECIO3,:P_MEDIDA1,:P_MEDIDA2,:P_MEDIDA3,:P_URL,:P_CHECK_OC,:P_TIPO_PAGO,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
        oci_bind_by_name(       $sp, ":P_VENDOR_ID"         ,    $elemento['proveedor']          , 1000);
        oci_bind_by_name(       $sp, ":P_SERVICIO"          ,    $elemento['servicio']           , 1000);
        oci_bind_by_name(       $sp, ":P_NOMBRE"            ,    $elemento['nombre']             , 1000);
        oci_bind_by_name(       $sp, ":P_CUENTA"            ,    $elemento['cta']                , 1000);
        oci_bind_by_name(       $sp, ":P_PRECIO1"           ,    $elemento['precio1']            , 1000);
        oci_bind_by_name(       $sp, ":P_PRECIO2"           ,    $elemento['precio2']            , 1000);
        oci_bind_by_name(       $sp, ":P_PRECIO3"           ,    $elemento['precio3']            , 1000);
        oci_bind_by_name(       $sp, ":P_MEDIDA1"           ,    $elemento['medida1']            , 1000);
        oci_bind_by_name(       $sp, ":P_MEDIDA2"           ,    $elemento['medida2']            , 1000);
        oci_bind_by_name(       $sp, ":P_MEDIDA3"           ,    $elemento['medida3']            , 1000);
        oci_bind_by_name(       $sp, ":P_URL"               ,    $elemento['url']                , 1000);
        oci_bind_by_name(       $sp, ":P_CHECK_OC"          ,    $elemento['validacion_oc']      , 1000);
        oci_bind_by_name(       $sp, ":P_TIPO_PAGO"         ,    $elemento['tipo_pago']          , 1000);
        oci_bind_by_name(       $sp, ":P_ID_USUARIO"        ,    $elemento['usuario']            , 1000);
        oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"    ,    $aux[] );
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
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_UPD_CONCEPTO(:P_ID_CONCEPTO,:P_NOMBRE,:p_ESTADO,:P_VALIDA_OC,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
        oci_bind_by_name(       $sp, ":P_ID_CONCEPTO"      ,    $elemento['proveedor']          , 1000);
        oci_bind_by_name(       $sp, ":P_NOMBRE"           ,    $elemento['razon_social']       , 1000);
        oci_bind_by_name(       $sp, ":p_ESTADO"           ,    $elemento['estado']             , 1000);
        oci_bind_by_name(       $sp, ":P_VALIDA_OC"        ,    $elemento['validacion_oc']      , 1000);
        oci_bind_by_name(       $sp, ":P_ID_USUARIO"       ,    $elemento['usuario']            , 1000);
        oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"   ,    $aux[] );
        oci_execute($sp, OCI_DEFAULT);
        return (!empty($aux[0])) ? true : false;   
    }

    public function solicitud_cambio($elemento)
    {
        $aux = array();
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_EDITAR_CONCEPTO(:P_ID_CONCEPTO,:P_ID_PRECIO,:P_CUENTA_CONTABLE,:P_PRECIO1,:P_PRECIO2,:P_PRECIO3,:P_MEDIDA1,:P_MEDIDA2,:P_MEDIDA3,:P_URL,:P_ID_USUARIO,:P_FECHA_DESDE,:P_ESTADO_PROCESO); END;");
        oci_bind_by_name(       $sp, ":P_ID_CONCEPTO"           ,    $elemento['id_concepto']        , 1000);
        oci_bind_by_name(       $sp, ":P_ID_PRECIO"            ,    $elemento['id_precio']        , 1000);
        oci_bind_by_name(       $sp, ":P_CUENTA_CONTABLE"       ,    $elemento['cta']                , 1000);
        oci_bind_by_name(       $sp, ":P_PRECIO1"               ,    $elemento['precio1']            , 1000);
        oci_bind_by_name(       $sp, ":P_PRECIO2"               ,    $elemento['precio2']            , 1000);
        oci_bind_by_name(       $sp, ":P_PRECIO3"               ,    $elemento['precio3']            , 1000);
        oci_bind_by_name(       $sp, ":P_MEDIDA1"               ,    $elemento['medida1']            , 1000);
        oci_bind_by_name(       $sp, ":P_MEDIDA2"               ,    $elemento['medida2']            , 1000);
        oci_bind_by_name(       $sp, ":P_MEDIDA3"               ,    $elemento['medida3']            , 1000);
        oci_bind_by_name(       $sp, ":P_URL"                   ,    $elemento['url']                , 1000);
        oci_bind_by_name(       $sp, ":P_ID_USUARIO"            ,    $elemento['usuario']            , 1000);
        oci_bind_by_name(       $sp, ":P_FECHA_DESDE"           ,    $elemento['fecha_desde']        , 1000);
        oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"        ,    $aux[] );
        oci_execute($sp, OCI_DEFAULT);
        return (!empty($aux[0])) ? true : false;   
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

    public function get_solicitud_prendientes($id_concepto){
        $aux = array();
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_VALIDACION_SOLICITUD_CON(:P_ID_CONCEPTO,:P_VALIDADOR); END;");
        oci_bind_by_name(       $sp, ":P_ID_CONCEPTO"           ,    $id_concepto        , 1000);
        oci_bind_by_name(       $sp, ":P_VALIDADOR"             ,    $aux[] );
        oci_execute($sp, OCI_DEFAULT);
        return $aux[0]; 
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

     public function get_medidas(){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_MEDIDAS_SISTEMA", array
            (
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

    public function get_tipos_pago(){
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_TIPOS_PAGO", array
            (
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

    public function get_cuentas_contables($filtro){

        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_CUENTAS_CONTABLES", array
            (
                array('name' => ':P_ID_PROVEEDOR',  'value' => $filtro          , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':CUR_USU',         'value' => $curs            , 'type' => OCI_B_CURSOR,'length' => -1)
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

    public function get_conceptos(){

        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_CONCEPTOS", array
            (
                array('name' => ':CUR_USU',         'value' => $curs            , 'type' => OCI_B_CURSOR,'length' => -1)
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

    public function get_solicitudes_cambio(){

        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_SOLICITUDES_CAMBIO", array
            (
                array('name' => ':CUR_USU',         'value' => $curs            , 'type' => OCI_B_CURSOR,'length' => -1)
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
    
    public function aprobar_cambio($elemento){
        $aux = array();
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_APROBAR_CAMBIOS(:P_ID_SOLICITUD,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
        oci_bind_by_name(       $sp, ":P_ID_SOLICITUD"          ,    $elemento['id_solicitud']        , 1000);
        oci_bind_by_name(       $sp, ":P_ID_USUARIO"            ,    $elemento['usuario']             , 1000);
        oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"        ,    $aux[] );
        oci_execute($sp, OCI_DEFAULT);
        return (!empty($aux[0])) ? true : false; 
    }
    
    public function rechazar_cambio($elemento){
         // var_dump ($lemento);
         // die();
        $aux = array();
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_RECHAZAR_SOLICITUD(:P_ID_SOLICITUD,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
        oci_bind_by_name(       $sp, ":P_ID_SOLICITUD"          ,    $elemento['id_solicitud']        , 1000);
        oci_bind_by_name(       $sp, ":P_ID_USUARIO"            ,    $elemento['usuario']             , 1000);
        oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"        ,    $aux[] );
        oci_execute($sp, OCI_DEFAULT);
        return (!empty($aux[0])) ? true : false; 
    }


 public function get_historial_concepto($id_concepto){

        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_HISTORIAL_CONCEPTO", array
            (
                array('name' => ':P_ID_CONCEPTO',   'value' => $id_concepto          , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':CUR_USU',         'value' => $curs            , 'type' => OCI_B_CURSOR,'length' => -1)
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


    public function get_conceptos_by_servicio($id_servicio , $id_proveedor){
        //SP_GET_CONCEPTOS_BY_SERVICIO
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_CONCEPTOS_BY_SERVICIO", array
            (
                array('name' => ':P_ID_SERVICIO' ,   'value' => $id_servicio     , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':P_ID_PROVEEDOR',   'value' => $id_proveedor    , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':CUR_USU',          'value' => $curs            , 'type' => OCI_B_CURSOR,'length' => -1)
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