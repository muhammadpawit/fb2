<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biayahpp extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/biayahpp/';
		$this->login 		= BASEURL.'login';
		$this->url 		= BASEURL.'Biayahpp/';
		$this->load->model('BiayaHppPerpoModel');
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}


	public function index(){
		$data=[];
		$data['title']='Biaya HPP Per PO';
		$data['prods'] = $this->BiayaHppPerpoModel->getData();
		// pre($data['prods']);
		$data['tambah']=$this->url.'add';
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	public function add(){
		$data=[];
		$data['title']='Biaya HPP Per PO';
		$data['po'] = $this->GlobalModel->GetData('produksi_po',array('hapus'=>0));
		$data['batal']=$this->url.'';
		$data['action']=$this->url.'save';
		$data['page']=$this->page.'form';
		$this->load->view($this->layout,$data);
	}

	public function save(){
		$data=$this->input->post();
		
		$insert=array(
			'nama_biaya'=>$data['nama_biaya'],
			'nominal'	=>$data['nominal'],
			'tanggal'	=> date('Y-m-d'),
		);
		$this->db->insert('biaya_hpp_perpo',$insert);
		$id = $this->db->insert_id();
		foreach($data['idpo'] as $key => $val ){
			$detail = array(
				'idbiayapo' => $id,
				'idpo' => $val,
				'nominal' => $data['nominal'],
			);
			$this->db->insert('biaya_hpp_perpodetail',$detail);
		}
		user_activity(callSessUser('id_user'),1,' input biaya hpp per po dengan id '.$id);
		$this->session->set_flashdata('msg','Data berhasil diupdate');
		redirect($this->url);
	}

	
		
}