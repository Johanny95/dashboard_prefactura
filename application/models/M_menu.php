<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * @package    
	 * @subpackage 
	 * @author     Paolo Castillo
     * @version    0.1
	 */
class M_menu extends CI_Model {
	// ALTER TABLE PF_MENU DROP PRIMARY KEY CASCADE

	// DROP TABLE PF_MENU_AR CASCADE CONSTRAINTS

	// CREATE TABLE PF_MENU_AR
	// (
	//   ID_MENU             NUMBER                    NOT NULL,
	//   PADRE               NUMBER,
	//   NOMBRE              VARCHAR2(50 BYTE)         NOT NULL,
	//   ICONO               VARCHAR2(50 BYTE)         NOT NULL,
	//   ORDEN               NUMBER                    NOT NULL,
	//   KEY                 VARCHAR2(100 BYTE),
	//   ID_ROL              NUMBER                    NOT NULL,
	//   FECHA_CREACION      DATE                      DEFAULT sysdate,
	//   FECHA_MODIFICACION  DATE                      DEFAULT sysdate,
	//   FECHA_ELIMINACION   DATE,
	//   POR                 VARCHAR2(11 BYTE)         NOT NULL,
	//   ATRIBUTO1           VARCHAR2(255 BYTE),
	//   ATRIBUTO2           NUMBER,
	//   ATRIBUTO3           VARCHAR2(255 BYTE),
	//   ATRIBUTO4           NUMBER,
	//   ATRIBUTO5           VARCHAR2(255 BYTE),
	//   ATRIBUTO6           NUMBER,
	//   ATTRIBUTE_VAR1      VARCHAR2(250 BYTE),
	//   ATTRIBUTE_VAR2      VARCHAR2(1000 BYTE),
	//   ATTRIBUTE_DATE1     DATE,
	//   ATTRIBUTE_DATE2     DATE,
	//   ATTRIBUTE_INT1      NUMBER,
	//   ATTRIBUTE_INT2      NUMBER
	// )

	// CREATE UNIQUE INDEX PK_ID_MENU ON PF_MENU_AR
	// (ID_MENU)

	// ALTER TABLE PF_MENU_AR ADD (
	//   CONSTRAINT PK_ID_MENU
	//   PRIMARY KEY
	//   (ID_MENU)
	//   USING INDEX PK_ID_MENU
	//   ENABLE VALIDATE)

	// ALTER TABLE PF_MENU_AR ADD (
	//   CONSTRAINT PF_MENU_AR_FK 
	//   FOREIGN KEY (PADRE) 
	//   REFERENCES PF_MENU_AR (ID_MENU)
	//   ENABLE VALIDATE)

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
	}

	public function get_menu()
	{
		$rol = $this->session->rol;
		// var_dump ($rol);
		// die();
		$this->db->select('*');
		$this->db->from('PF_MENU_PREFACTURA');
		$this->db->where_in('ID_ROL', $rol);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_padre()
	{
		$this->db->select('PADRE');
		$this->db->from('PF_MENU_PREFACTURA');
		$query = $this->db->get();
		return $query->result_array();
	}
}

/* End of file M_menu.php */
/* Location: ./application/models/M_menu.php */