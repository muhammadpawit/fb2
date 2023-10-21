<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datacustomer extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('CustomerModel');
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/datacustomer/';
		$this->url=BASEURL.'Datacustomer/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Data Customer';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 day"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['prods']=[];
		$results=$this->CustomerModel->getDataCustomer();
		$no=1;
		$absen=[];
		foreach($results as $r){
			$data['prods'][]=array(
				'no'=>$no,
				'nama'=>$r['nama'],
				'no_hp'=>$r['no_hp'],
				'email'=>$r['email'],
				'alamat'=>$r['alamat'],
			);
			$no++;
		}
		$data['action'] = $this->url.'insert';
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}

	public function insert(){
		$input = $this->input->post();
		$save = $this->CustomerModel->insertCustomer($input);
		if($save['success']==TRUE){
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
		}else{
			$this->session->set_flashdata('gagal','Data gagal disimpan');
			redirect($this->url);
		}
	}
}