<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisapenjualan extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('CustomerModel');
		$this->load->model('PenjualanModel');
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/penjualan/';
		$this->url=BASEURL.'Penjualan/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Data Analisa PO Online';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			// $tanggal1=date('Y-m-d',strtotime("-7 day"));
			$tanggal1=date('Y-m-d',strtotime("first day of previous month"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['prods']=[];
		$results=$this->PenjualanModel->getAnalisaDataPenjualan();
		$data['total_bulan']=$results['total_bulan']->total_penjualan;
		$data['qty_bulan']	=$results['qty_bulan']->quantity;
		$data['total_bulan_lalu']=$results['total_bulan_lalu']->total_penjualan;
		$data['qty_bulan_lalu']	=$results['qty_bulan_lalu']->quantity;
		// pre($data['total_bulan']);
		$no=1;
		$absen=[];
		foreach($results['minggu_ini'] as $r){
			$data['prods'][]=array(
				'no'=>$no,
				'nama_po' 	=> $r['nama_po'],
				'serian' 	=> $r['serian'],
				'size'		=> $r['size'],
				'quantity'	=> $r['quantity'],
				'harga'		=> $r['harga'],
				'marketplace'=> $r['marketplace'],
				'detail'=>null,
			);
			$no++;
		}
		$data['action'] = $this->url.'add';
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'analisa';
			$this->load->view($this->layout,$data);
		}
	}

	public function add(){
		$data=[];
		$data['title']='Data Penjualan Online';
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
		$data['customer']=$this->CustomerModel->getDataCustomer();
		$data['ekspedisi']=$this->PenjualanModel->getDataEkspedisi();
		$data['marketplace']=$this->PenjualanModel->getDataMarketplace();
		// pre($data['marketplace']);
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		// pre($data['customer']);
		$data['action'] = $this->url.'insert';
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'add';
			$this->load->view($this->layout,$data);
		}
	}

	function detail($id){
		$data['title']='Detail Penjualan';
		$data['prods']=$this->PenjualanModel->getDataPenjualanDetail($id);
		$data['products']=$this->PenjualanModel->getDataPenjualanProductDetail($id);
		// pre($data['products']);
		$data['page']=$this->page.'detail';
		$this->load->view($this->layout,$data);
	}

	public function insert(){
		$input = $this->input->post();
		//pre($input);
		$save = $this->PenjualanModel->insertPenjualan($input);
		if($save['success']==TRUE){
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
		}else{
			$this->session->set_flashdata('gagal','Data gagal disimpan');
			redirect($this->url);
		}
	}
}