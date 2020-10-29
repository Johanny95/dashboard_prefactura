<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_servicio extends CI_Model { 
	private $por   = '';
    private $usuid = '';

	public function __construct()
	{
		parent::__construct();
		$this->por        = $this->session->rut;
        $this->usuid      = $this->session->usuid;
		$this->load->database();
	
	} 

   public function add($nombre)
    {
        $this->db->trans_begin();
        $this->db->set('ID_SERVICIO','PF_FACT_SEQ_SERVICIOS.nextval', FALSE);
        $this->db->set('NOMBRE', $nombre);
        $this->db->set('ESTADO', 'S');
        $this->db->set('FECHA_CREACION', 'SYSDATE',false);
        $this->db->set('NOMBRE', $nombre);
        $this->db->insert('PF_FACT_SERVICIOS');
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }

    public function del($id)
    {
        $this->db->trans_begin();
        $this->db->set('FECHA_ELIMINACION', 'SYSDATE', FALSE);
        $this->db->set('USUARIO_ELIMINACION', $this->por);
        $this->db->set('ESTADO', 'N');
        $this->db->where('ID_SERVICIO', $id, FALSE);
        $this->db->update('PF_FACT_SERVICIOS');
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
        $this->db->update('PF_FACT_SERVICIOS');
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
    	$this->db->select('ID_SERVICIO ID', FALSE);
    	$this->db->select('INITCAP(NOMBRE) NOMBRE', FALSE);
    	$this->db->from('PF_FACT_SERVICIOS');
    	$this->db->where('FECHA_ELIMINACION IS NULL');
    	$query  = $this->db->get();
    	return $query->result();
    }


    public function getNumRows($id)
    {
        $this->db->select('*');
        $this->db->from('PF_FACT_SERVICIOS');
        $this->db->where('FECHA_ELIMINACION IS NULL');
        $this->db->where('ID_SERVICIO', $id, FALSE);
        $query = $this->db->get();
        return $query->num_rows();
    }
}

/* End of file M_cargo.php */
/* Location: ./application/models/M_cargo.php */