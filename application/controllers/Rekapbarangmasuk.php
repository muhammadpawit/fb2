<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapbarangmasuk extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/rekapbarangmasuk/';
		$this->url=BASEURL.'Rekapbarangmasuk/';
		$this->load->model('RekapbarangmasukModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}


	public function index(){
		$data=[];
		$data['title']='Rekap Barang Masuk';
		$get=$this->input->get();
		if(isset($get['bulan'])){
			$bulan=$get['bulan'];
		}else{
			$bulan=date('n');
		}
		if(isset($get['tahun'])){
			$tahun=$get['tahun'];
		}else{
			$tahun=date('Y');
		}

		if(isset($get['supplier'])){
			$cmt=$get['supplier'];
		}else{
			$cmt=null;
		}

		$filter=array(
			'bulan'=>$bulan,
			'tahun'=>$tahun,
			'supplier'=>$cmt,
		);
		$data['bulan']=$bulan;
		$data['tahun'] =$tahun;
		$data['cmt'] =$cmt;
		$data['supplier']=$this->GlobalModel->Getdata('master_supplier',array('hapus'=>0));
		$data['prods']=[];
		$data['prods']=$this->RekapbarangmasukModel->getdata($filter);
		//pre($data['prods']);
		if(!isset($get['excel'])){
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}else{
			$this->load->view($this->page.'excel',$data);
		}
	}
}