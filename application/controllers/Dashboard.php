<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
		
	}

	public function index()
	{
		$viewData['produkPO'] = $this->db->count_all_results('produksi_po');
		$viewData['kirimGudang'] = $this->db->count_all_results('finishing_kirim_gudang');
		$user=user();
		$setujui=0;
		if(isset($user['id_user'])){
			$setujui=akses($user['id_user'],3);
		}
		$viewData['setujui']=$setujui;
		// //session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->view('global/header');
		$this->load->view('dashboard',$viewData);
		$this->load->view('global/footer');
	}
}
