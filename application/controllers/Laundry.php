<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laundry extends CI_Controller {

	function __construct() {

		parent::__construct();

		////sessionLogin(URLPATH."\\".$this->uri->segment(1));

		////session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');

		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Kirim Setor Laundry';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("Monday this week"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$sql="SELECT * FROM laundry WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY id DESC ";
		$results =$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$cmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$r['idcmt']));
			$data['products'][]=array(
				'no'=>$no++,
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'cmt'=>$cmt['cmt_name'],
				'kode_po'=>$r['kode_po'],
				'kirim'=>$r['kirim_pcs'],
				'setor'=>$r['setor_pcs'],
				'harga'=>$r['harga'],
				'keterangan'=>$r['keterangan'],
				'status'=>$r['status'],
			);
		}
		$data['page']=$this->page.'laundry/list';
		$data['tambah']=BASEURL.'Laundry/add';
		$this->load->view($this->layout,$data);
	}

	public function add(){
		$data=[];
		$data['action']=BASEURL.'Laundry/save';
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0));
		$data['page']=$this->page.'laundry/add';
		$this->load->view($this->layout,$data);
	}

}
