<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_tableau extends CI_Model {

	private $server		= 'tableau_prod.pf100.cl';
	private $url 		= 'https://tableau.pfalimentos.cl/trusted';
	private $ticket		= '';


	public function __construct()
	{
		parent::__construct();

		$fields_string ='username=Informatica';

		$ch = curl_init();      
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Blindly accept the certificate
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Encoding: gzip'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

		$this->ticket = curl_exec($ch);
		curl_close($ch);
	}

	public function getTicket() {
		return $this->ticket;
		// return 'WtpnfJwUQ2q4YdudksVjmg==:Tx_wzvkHciqDwMcA5fAs0-3R';
	}
}

/* End of file C_cargo.php */
/* Location: ./application/models/C_actividad.php */