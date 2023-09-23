<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gambar extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/gambar/';
		$this->url=BASEURL.'Gambar/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Gambar';
		$get=$this->input->get();
		$data['po']=$this->db->query("SELECT * FROM produksi_po WHERE hapus=0 ")->result_array();
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}
}