<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_apertura extends CI_Model { 
	private $por   = '';
    private $usuid = '';

	public function __construct()
	{
		parent::__construct(); 
		$this->por        = $this->session->rut;
        $this->usuid      = $this->session->usuid;
		$this->load->database();
	
	} 

   public function add($mes)
    {
        $aux = array();
        $sp = oci_parse($this->db->conn_id, "BEGIN PF_SISTEMA_PREFACTURA.SP_ADD_APERTURA_MES(:P_MES,:P_ID_USUARIO,:P_ESTADO_PROCESO); END;");
        oci_bind_by_name(       $sp, ":P_MES"               ,    $mes         , 1000);
        oci_bind_by_name(       $sp, ":P_ID_USUARIO"        ,    $this->usuid            , 1000);
        oci_bind_by_name(       $sp, ":P_ESTADO_PROCESO"    ,    $aux[] );
        oci_execute($sp, OCI_DEFAULT);
        return $aux[0];

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

    public function get()
    {
    	$this->db->select('MES ID', FALSE);
    	$this->db->select('INITCAP(MES) MES', FALSE);
        $this->db->select("TO_CHAR(FECHA_CIERRE,'DD-MM-RRRR') FECHA_CIERRE", FALSE);
        $this->db->select('ESTADO', FALSE);
        $this->db->select("TO_CHAR(FECHA_CREACION,'DD-MM-RRRR') FECHA_CREACION", FALSE);
    	$this->db->from('PF_FACT_MES_APERTURA');
    	$this->db->where('FECHA_ELIMINACION IS NULL');
    	$query  = $this->db->get();
    	return $query->result();
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

}

/* End of file M_cargo.php */
/* Location: ./application/models/M_cargo.php */