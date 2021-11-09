<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Setting extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
	}

	public function index(){
		$data=[];
		$data['title']='Periode Produksi Sistem';
		$data['action']=BASEURL.'Setting/simpan';;
		$data['s']=$this->GlobalModel->GetDataRow('periodeproduksi',array());
		$data['page']=$this->page.'setting';
		$this->load->view($this->page.'main',$data);
	}

	public function simpan(){
		$data=$this->input->post();
		$update=array(
			'bulan'=>$data['bulan'],
			'tahun'=>$data['tahun'],
		);
		$this->db->update('periodeproduksi',$update);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Setting');
	}

}