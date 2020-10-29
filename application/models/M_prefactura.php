<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_prefactura extends CI_Model { 
    private $por   = '';
    private $usuid = '';

    public function __construct()
    {
      parent::__construct(); 
      $this->por        = $this->session->rut;
      $this->usuid      = $this->session->usuid;
      $this->hpferi = $this->load->database('hpferi', TRUE);
      $this->load->database();
      // hpferi

  } 

  public function agregar_ajuste($elemento)
  {
    $aux = array();
    $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_ADD_AJUSTE(:P_PERIODO,:P_CONCEPTO,:P_ORG,:P_PROVEEDOR,:P_SERVICIO,:P_DOCUMENTO,:P_NUM_GUIA,:P_CANTIDAD1,:P_CANTIDAD2,:P_CANTIDAD3,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;" );
    oci_bind_by_name(       $sp, ":P_PERIODO"               ,   $elemento['periodo']);
    oci_bind_by_name(       $sp, ":P_CONCEPTO"              ,   $elemento['concepto']);
    oci_bind_by_name(       $sp, ":P_ORG"                   ,   $elemento['org']);
    oci_bind_by_name(       $sp, ":P_PROVEEDOR"             ,   $elemento['proveedor']);
    oci_bind_by_name(       $sp, ":P_SERVICIO"              ,   $elemento['servicio']);
    oci_bind_by_name(       $sp, ":P_DOCUMENTO"             ,   $elemento['url']);
    oci_bind_by_name(       $sp, ":P_NUM_GUIA"              ,   $elemento['numero_guia']);
    oci_bind_by_name(       $sp, ":P_CANTIDAD1"             ,   $elemento['cantidad1']);
    oci_bind_by_name(       $sp, ":P_CANTIDAD2"             ,   $elemento['cantidad2']);
    oci_bind_by_name(       $sp, ":P_CANTIDAD3"             ,   $elemento['cantidad3']);
    oci_bind_by_name(       $sp, ":P_ID_USUARIO"            ,   $this->usuid);
    oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"        ,   $aux[]);
    oci_execute($sp, OCI_DEFAULT);
    $estado =  (!empty($aux[0])) ? true : false;
    return $estado;    

}

public function get_informe_prefactura($elemento)
{
    $curs = $this->db->get_cursor();
    $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_RESUMEN_INFORME", array
        (
            array('name' => ':P_PERIODO',           'value' => $elemento['periodo']            , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':P_ORGANIZACION',      'value' => $elemento['organizaciones']     , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':P_PROVEEDOR',         'value' => $elemento['proveedores']        , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':P_SERVICIOS',         'value' => $elemento['servicios']          , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':CUR_USU',             'value' => $curs                           , 'type' => OCI_B_CURSOR,'length' => -1)
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

public function sp_get_prefacturas($elemento)
{
    $curs = $this->db->get_cursor();
    $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_PREFACTURAS", array
        (
            array('name' => ':P_PERIODO',           'value' => $elemento['periodo']            , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':CUR_USU',             'value' => $curs                           , 'type' => OCI_B_CURSOR,'length' => -1)
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


public function agregar_prefactura($elemento)
{
    $aux = array();
    $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_ADD_PRE_FACTURA(:P_PERIODO,:P_ORGANIZACIONES,:P_PROVEEDORES,:P_SERVICIOS,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;" );
    oci_bind_by_name(       $sp, ":P_PERIODO"               ,   $elemento['periodo']);
    oci_bind_by_name(       $sp, ":P_ORGANIZACIONES"        ,   $elemento['organizaciones']);
    oci_bind_by_name(       $sp, ":P_PROVEEDORES"           ,   $elemento['proveedores']);
    oci_bind_by_name(       $sp, ":P_SERVICIOS"             ,   $elemento['servicios']);
    oci_bind_by_name(       $sp, ":P_ID_USUARIO"            ,   $this->usuid);
    oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"        ,   $aux[]);
    oci_execute($sp, OCI_DEFAULT);
    $estado =  (!empty($aux[0])) ? true : false;
    return $estado;
}


public function del($id)
{
    $aux = array();
    $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_DEL_AJUSTE(:P_ID_AJUSTE,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;" );
    oci_bind_by_name(       $sp, ":P_ID_AJUSTE"             ,   $id);
    oci_bind_by_name(       $sp, ":P_ID_USUARIO"            ,   $this->usuid);
    oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"        ,   $aux[]);
    oci_execute($sp, OCI_DEFAULT);
    $estado =  (!empty($aux[0])) ? true : false;
    return $estado;    

}


public function get_proevedores_org($org){
        $this->db->select(' DISTINCT C.ID_PROVEEDOR'               , FALSE);
        $this->db->select('INITCAP(C.RAZON_SOCIAL) NOMBRE'  , FALSE);
        $this->db->select('C.RUT_PROVEEDOR RUT_PROVEEDOR'   , FALSE);
        $this->db->from('PF_FACT_PROVEEDORES C');
        $this->db->join('PF_FACT_PROVEEDOR_ORG D', 'C.ID_PROVEEDOR = D.ID_PROVEEDOR');
        $this->db->where("D.ESTADO = 'S' ");
        $this->db->where("C.ESTADO = 'S' ");
        $this->db->where('D.FECHA_ELIMINACION IS NULL');
        $this->db->where('C.FECHA_ELIMINACION IS NULL');
        $this->db->where_in('D.ORGANIZATION_ID', $org);
        $query  = $this->db->get();
        return $query->result();
}


public function get_servicios_pro($proveedor){
    // var_dump ($proveedor);
    // die();
        $this->db->select('DISTINCT C.ID_SERVICIO'               , FALSE);
        $this->db->select('INITCAP(C.NOMBRE) NOMBRE'    , FALSE);
        $this->db->select('D.ID_PROVEEDOR ID_PROVEEDOR' , FALSE);
        $this->db->select('D.ESTADO'                    , FALSE);
        $this->db->select('P.RAZON_SOCIAL'              , FALSE);
        $this->db->select('P.RUT_PROVEEDOR'             , FALSE);
        $this->db->select('P.ID_PROVEEDOR'              , FALSE);
        $this->db->from('PF_FACT_SERVICIOS C');
        $this->db->join('PF_FACT_SERVICIOS_PROVEEDOR D' , 'C.ID_SERVICIO  = D.ID_SERVICIO');
        $this->db->join('PF_FACT_PROVEEDORES P'         , 'D.ID_PROVEEDOR = P.ID_PROVEEDOR');
        $this->db->where("D.ESTADO = 'S' ");
        $this->db->where("C.ESTADO = 'S' ");
        $this->db->where('D.FECHA_ELIMINACION IS NULL');
        $this->db->where('C.FECHA_ELIMINACION IS NULL');
        $this->db->where_in('D.ID_PROVEEDOR', $proveedor);
        $query  = $this->db->get();
        return $query->result();
}

public function get_prefactura($id_prefactura){
     $curs = $this->db->get_cursor();
    $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_PREFACTURA", array
        (
            array('name' => ':P_ID_PREFACTURA',           'value' => $id_prefactura                  , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':CUR_USU',             'value' => $curs                           , 'type' => OCI_B_CURSOR,'length' => -1)
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


public function get_prefactura_detalle($id_prefactura){
     $curs = $this->db->get_cursor();
    $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_DETALLE_PREFACTURA", array
        (
            array('name' => ':P_ID_PREFACTURA',           'value' => $id_prefactura                  , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':CUR_USU',             'value' => $curs                           , 'type' => OCI_B_CURSOR,'length' => -1)
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


public function rechazar_prefactura($id_prefactura){
    $aux = array();
    $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_RECHAZAR_PREFACTURA(:P_ID_PREFACTURA,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;" );
    oci_bind_by_name(       $sp, ":P_ID_PREFACTURA"         ,   $id_prefactura);
    oci_bind_by_name(       $sp, ":P_ID_USUARIO"            ,   $this->usuid);
    oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"        ,   $aux[]);
    oci_execute($sp, OCI_DEFAULT);
    $estado =  (!empty($aux[0])) ? true : false;
    return $estado;    

}

//
public function aprobar_prefactura($id_prefactura){
    // var_dump ($id_prefactura);
    // die();
    $aux = array();
    $sp  = oci_parse( $this->hpferi->conn_id, "BEGIN PF_PREFACTURA_CREACION_OC.SP_CREAR_OC_PRE_FACTURA(:P_ID_PREFACTURA,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;" );
    oci_bind_by_name(       $sp, ":P_ID_PREFACTURA"         ,   $id_prefactura);
    oci_bind_by_name(       $sp, ":P_ID_USUARIO"            ,   $this->usuid);
    oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"        ,   $aux[]);
    oci_execute($sp, OCI_DEFAULT);
    $estado =  (!empty($aux[0])) ? true : false;
    return $estado;  
}

public function get_oc_prefactura($id_prefactura){
     $curs = $this->db->get_cursor();
    $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_OC_BY_PREFACTURA", array
        (
            array('name' => ':P_ID_PREFACTURA',           'value' => $id_prefactura                  , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':CUR_USU',             'value' => $curs                           , 'type' => OCI_B_CURSOR,'length' => -1)
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