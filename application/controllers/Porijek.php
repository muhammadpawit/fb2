<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Porijek extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/porijek/';
		$this->url=BASEURL.'Porijek/';
		$this->load->model('ReportModel');
		$this->load->model('M_potonganoperator');
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	function index(){
		$data 			=[];
		$data['title']	='Po Rijek';
		$data['prods']	=[];
		$data['no']		=1;
		$data['prods']	=$this->GlobalModel->getData('rijek',array());
		$data['total']	= $this->GlobalModel->QueryManualRow("SELECT COALESCE(sum(pcs),0) as total from rijek ");
		//$data['total']	=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(pcs),0) as total FROM rijek ");
		$data['action']	=$this->url.'save';
		$data['page']	=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	function save(){
		$post = $this->input->post();
		$po=explode("-", $post['kode_po']);
		//pre($po);
		$insert=array(
			'idpo'	=>$po[0],
			'kode_po'=>$po[1],
			'pcs'=>$post['pcs'],
			'keterangan'=>$post['keterangan']
		);
		$this->db->insert('rijek',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect($this->url);
	}

	function hapus($id){
		$this->db->delete('rijek',array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Dihapus');
		redirect($this->url);
	}
}