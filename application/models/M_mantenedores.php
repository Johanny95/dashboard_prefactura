<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_mantenedores extends CI_Model { 
	private $por = '';
    private $usuid = '';
	public function __construct()
	{
		parent::__construct();
		$this->por = $this->session->rut;
        $this->usuid = $this->session->usuid;
		$this->load->database();

	} 


    public function ingresar($elemento){
        // var_dump ($elemento);
        // die();
        $aux = array();
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_ADD_REGISTRO_MANTENEDORES(:P_ORG,:P_PERIODO,:P_KILOS,:P_MTS_SUPER,:P_MTS_JARDINES,:P_DIAS_SERVICIO,:P_DOTACION,:P_VALOR_UF,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
        oci_bind_by_name(       $sp, ":P_ORG"               ,    $elemento['id_oficina']             , 1000);
        oci_bind_by_name(       $sp, ":P_PERIODO"           ,    $elemento['periodo']                , 1000);
        oci_bind_by_name(       $sp, ":P_KILOS"             ,    $elemento['kilos_produccion']       , 1000);
        oci_bind_by_name(       $sp, ":P_MTS_SUPER"         ,    $elemento['mts2_superficie']        , 1000);
        oci_bind_by_name(       $sp, ":P_MTS_JARDINES"      ,    $elemento['mts2_jardines']          , 1000);
        oci_bind_by_name(       $sp, ":P_DIAS_SERVICIO"     ,    $elemento['dias_servicios']         , 1000);
        oci_bind_by_name(       $sp, ":P_DOTACION"          ,    $elemento['dotacion']               , 1000);
        oci_bind_by_name(       $sp, ":P_VALOR_UF"          ,    $elemento['valor_uf']               , 1000);
        
        oci_bind_by_name(       $sp, ":P_ID_USUARIO"        ,    $this->usuid             , 1000);
        oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"    ,    $aux[] );
        oci_execute($sp, OCI_DEFAULT);
        return (!empty($aux[0])) ? true : false;
    }
    

    public function del($elemento)
    {   
        $aux = array();
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.DEL_DATOS_OFICINA_PERIODO(:P_PERIODO,:P_ORG,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
        oci_bind_by_name(       $sp, ":P_ORG"               ,    $elemento['id_oficina']             , 1000);
        oci_bind_by_name(       $sp, ":P_PERIODO"           ,    $elemento['periodo']                , 1000);
        
        oci_bind_by_name(       $sp, ":P_ID_USUARIO"        ,    $this->usuid             , 1000);
        oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"    ,    $aux[] );
        oci_execute($sp, OCI_DEFAULT);
        return (!empty($aux[0])) ? true : false;
    }

    public function editar($elemento)
    {
        // var_dump ($elemento);
        // die();
        $aux = array();
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_EDITAR_DATOS_MANT(:P_ORG,:P_PERIODO,:P_KILOS,:P_MTS_SUPER,:P_MTS_JARDINES,:P_DIAS_SERVICIO,:P_DOTACION,:P_VALOR_UF,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
        oci_bind_by_name(       $sp, ":P_ORG"               ,    $elemento['id_oficina']             , 1000);
        oci_bind_by_name(       $sp, ":P_PERIODO"           ,    $elemento['periodo']                , 1000);
        oci_bind_by_name(       $sp, ":P_KILOS"             ,    $elemento['kilos_produccion']       , 1000);
        oci_bind_by_name(       $sp, ":P_MTS_SUPER"         ,    $elemento['mts2_superficie']        , 1000);
        oci_bind_by_name(       $sp, ":P_MTS_JARDINES"      ,    $elemento['mts2_jardines']          , 1000);
        oci_bind_by_name(       $sp, ":P_DIAS_SERVICIO"     ,    $elemento['dias_servicios']         , 1000);
        oci_bind_by_name(       $sp, ":P_DOTACION"          ,    $elemento['dotacion']               , 1000);
        oci_bind_by_name(       $sp, ":P_VALOR_UF"          ,    $elemento['valor_uf']               , 1000);
        
        oci_bind_by_name(       $sp, ":P_ID_USUARIO"        ,    $this->usuid             , 1000);
        oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"    ,    $aux[] );
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

    public function get_org_datos_mantenedor($periodo)
    {
        $curs = $this->db->get_cursor();
        $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_DATOS_AMNT_PERIODO", array
            (
                array('name' => ':P_USER_ID'     ,       'value' => $this->usuid                , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':P_PERIODO'     ,       'value' => $periodo                    , 'type' => SQLT_CHR,'length' => -1),
                array('name' => ':CUR_USU'       ,       'value' => $curs                       , 'type' => OCI_B_CURSOR,'length' => -1)
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