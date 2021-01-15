<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_evento extends CI_Model { 
	private $por   = '';
    private $usuid = '';

    public function __construct()
    {
      parent::__construct(); 
      $this->por        = $this->session->rut;
      $this->usuid      = $this->session->usuid;
      $this->load->database();

  } 

  public function agregar_evento($evento)
  {
    $aux = array();
    $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_ADD_EVENTO(:P_PERIODO,:P_ORG,:P_PROVEEDOR,:P_DOCUMENTO,:P_NUM_GUIA,:P_SERVICIOS,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;" );
    oci_bind_by_name(       $sp, ":P_PERIODO"               ,   $evento['periodo']);
    oci_bind_by_name(       $sp, ":P_ORG"                   ,   $evento['org']);
    oci_bind_by_name(       $sp, ":P_PROVEEDOR"             ,   $evento['proveedor']);
    oci_bind_by_name(       $sp, ":P_DOCUMENTO"             ,   $evento['url']);
    oci_bind_by_name(       $sp, ":P_NUM_GUIA"              ,   $evento['numero_guia']);
    oci_bind_array_by_name( $sp, ":P_SERVICIOS"             ,   $evento['servicios'] , count($evento['servicios']), -1, SQLT_CHR);
    oci_bind_by_name(       $sp, ":P_ID_USUARIO"            ,   $this->usuid);
    oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"        ,   $aux[]);
    oci_execute($sp, OCI_DEFAULT);
    $estado =  (!empty($aux[0])) ? true : false;
    return $estado;    

}

public function cierre($id)
{
    $this->db->trans_begin();
    $this->db->set('FECHA_CIERRE', 'SYSDATE', FALSE);
    $this->db->set('USUARIO_CIERRE', $this->usuid);
    $this->db->set('ESTADO', 'CERRADO');
    $this->db->where('MES', $id);
    $this->db->update('PF_FACT_MES_APERTURA');
    if ($this->db->trans_status() === FALSE)
    {
        $this->db->trans_rollback();
        return false;
    }else{
        $this->db->trans_commit();
        return true;
    }   
}

public function upd($data)
{
    $this->db->trans_begin();
    $this->db->set('NOMBRE', $data->nombre);
    $this->db->set('FECHA_MODIFICACION', 'SYSDATE', FALSE);
    $this->db->set('USUARIO_UPD', $this->usuid);
    $this->db->where('ID_SERVICIO', $data->id, FALSE);
    $this->db->update('PF_FACT_MES_APERTURA');
    if ($this->db->trans_status() === FALSE)
    {

        $this->db->trans_rollback();

        return false;
    }else{
        $this->db->trans_commit();
        return true;
    }      
}

public function del_evento($id_evento){
    $aux = array();
    $sp  = oci_parse( $this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_DEL_EVENTOS(:P_ID_EVENTO,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;" );
    oci_bind_by_name(       $sp, ":P_ID_EVENTO"             ,   $id_evento);
    oci_bind_by_name(       $sp, ":P_ID_USUARIO"            ,   $this->usuid);
    oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"        ,   $aux[]);
    oci_execute($sp, OCI_DEFAULT);
    $estado =  (!empty($aux[0])) ? true : false;
    return $estado;    
}


public function get_eventos($elemento)
{
    $curs = $this->db->get_cursor();
    $this->db->stored_procedure("PF_SISTEMA_PREFACTURA","SP_GET_EVENTOS", array
        (
            array('name' => ':P_ID_EVENTO',      'value' => $elemento['id_evento']          , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':P_PERIODO',        'value' => $elemento['periodo']            , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':P_ORGANIZACION',   'value' => $elemento['organizaciones']     , 'type' => SQLT_CHR,'length' => -1),
            array('name' => ':CUR_USU',          'value' => $curs                            , 'type' => OCI_B_CURSOR,'length' => -1)
        )
    );
    oci_execute($curs);
    $data = array();
    $eventos = array();
    while (($row = oci_fetch_object($curs)) != false) {

        if( !isset($eventos[$row->ID_EVENTO] ) ){
            $eventos[$row->ID_EVENTO] = array(
                'id_evento'         => $row->ID_EVENTO,
                'periodo'           => $row->PERIODO,
                'proveedor'         => $row->PROVEEDOR,
                'numero_guia'       => $row->NUMERO_GUIA,
                'rut_proveedor'     => $row->RUT_PROVEEDOR,
                'nombre_proveedor'  => $row->NOMBRE_PROVEEDOR,
                'organizacion'      => $row->ORGANIZACION,
                'documento'         => $row->DOCUMENTO,
                'estado'            => $row->ESTADO,
                'creador'           => $row->CREADOR,
                'usunom'            => $row->USUNOM,
                'rut_usuario'       => $row->RUT_USUARIO,
                'fecha_creacion'    => $row->FECHA_CREACION,
                'servicios'         => array()
            );
        }

        if( !isset($eventos[$row->ID_EVENTO]['servicios'][$row->ID_SERVICIO] ) ){
            $eventos[$row->ID_EVENTO]['servicios'][$row->ID_SERVICIO] = 
            array(
                'id_servicio'       => $row->ID_SERVICIO,
                'nombre_servicio'   => $row->NOMBRE_SERVICIO,
                'conceptos'         => array()
            );
        }
        // $concepto['rut'] = $p->RUT;
        // $usu['nombre'] = $p->NOMBRES.' '.$p->APELLIDOS;
        $concepto['id_concepto']     = $row->ID_CONCEPTO;
        $concepto['nombre_concepto'] = $row->NOMBRE_CONCEPTO;
        $concepto['medida1']         = $row->MEDIDA1;
        $concepto['medida2']         = $row->MEDIDA2;
        $concepto['medida3']         = $row->MEDIDA3;
        $concepto['cantidad1']       = $row->CANTIDAD1;
        $concepto['cantidad2']       = $row->CANTIDAD2;
        $concepto['cantidad3']       = $row->CANTIDAD3;
        $concepto['id_usuario']      = $row->CREADOR;
        $concepto['estado_evento']      = $row->ESTADO_EVENTO;
        


        array_push($eventos[$row->ID_EVENTO]['servicios'][$row->ID_SERVICIO]['conceptos'], $concepto);

        //  if( !isset($eventos[$row->ID_SERVICIO]['servicios'][$row->ID_SERVICIO]['conceptos'][$row->ID_CONCEPTO] ) ){
        //     $eventos[$row->ID_SERVICIO]['servicios'][$row->ID_SERVICIO]['conceptos'][$row->ID_CONCEPTO] = 
        //     array(
        // }


        


            // array_push(  ,  $concepto );
      

    }

    oci_free_statement($curs);
    $result = $data;

     // var_dump ($conceptos);
     // die();
   
    return $eventos;

}




public function getNumRows($id)
{
    $this->db->select('*');
    $this->db->from('PF_FACT_MES_APERTURA');
    $this->db->where('FECHA_ELIMINACION IS NULL');
    $this->db->where('ID_SERVICIO', $id, FALSE);
    $query = $this->db->get();
    return $query->num_rows();
}

public function get_validacion_mes($mes){

    $aux = array();
    $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_GET_VALIDACION_MES(:P_MES,:P_ESTADO_PROCESO) ; END;");
    oci_bind_by_name(       $sp, ":P_MES"               ,    $mes         , 1000);
    oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"    ,    $aux[] );
    oci_execute($sp, OCI_DEFAULT);
    return $aux[0];
}

public function get_eventos_by_id(){

}


}

/* End of file M_cargo.php */
/* Location: ./application/models/M_cargo.php */