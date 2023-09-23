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
        if(isset($get['jenis_po'])){
			$jenis_po=$get['jenis_po'];
		}else{
			$jenis_po=null;
		}
        $data['jenis_po']=$jenis_po;

        $data['jenis']=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
        $sql ="SELECT * FROM produksi_po WHERE hapus=0 AND gambar_po IS NOT NULL ";
        if(!empty($jenis_po)){
            $sql .=" AND nama_po='".$jenis_po."' ";
        }
		$data['po']=$this->db->query($sql)->result_array();
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}
}