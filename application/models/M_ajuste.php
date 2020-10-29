<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ajuste extends CI_Model { 
    private $por   = '';
    private $usuid = '';

    public function __construct()
    {
      parent::__construct(); 
      $this->por        = $this->session->rut;
      $this->usuid      = $this->session->usuid;
      $this->load->database();

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



public function get_ajustes($elemento)
{
    $curs = $this->db->get_cursor();
    $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_AJUSTES", array
        (
            array('name' => ':P_ID_EVENTO',      'value' => $elemento['id_ajuste']          , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':P_PERIODO',        'value' => $elemento['periodo']            , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':P_ORGANIZACION',   'value' => $elemento['organizaciones']     , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':CUR_USU',          'value' => $curs                           , 'type' => OCI_B_CURSOR,'length' => -1)
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



}

/* End of file M_cargo.php */
/* Location: ./application/models/M_cargo.php */