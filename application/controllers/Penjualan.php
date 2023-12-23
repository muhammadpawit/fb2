<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('CustomerModel');
		$this->load->model('PenjualanModel');
		$this->load->model('OnlineModel');
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
		$results=$this->PenjualanModel->getDataPenjualan();
		// pre($results);
		$no=1;
		$absen=[];
		foreach($results as $r){
			$data['prods'][]=array(
				'no'=>$no,
				'tanggal' => date('d-m-Y',strtotime($r['tanggal'])),
				'namacustomer'=>$r['namacustomer'],
				'no_hp'=>$r['no_hp'],
				'total_harga'=>$r['total_harga'],
				'biaya_pengiriman'=>$r['biaya_pengiriman'],
				'total_discount'=>$r['total_discount'],
				'total'=>$r['total'],
				'detail'=>$this->url.'detail/'.$r['id'],
				'hapus'=>$this->url.'hapus/'.$r['id'],
			);
			$no++;
		}
		$data['action'] = $this->url.'add';
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
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
		// $data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['po']=$this->OnlineModel->getDataStok();
		// pre($data['po']);
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
		// pre($input);
		$save = $this->PenjualanModel->insertPenjualan($input);
		if($save['success']==TRUE){
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
		}else{
			$this->session->set_flashdata('gagal','Data gagal disimpan');
			redirect($this->url);
		}
	}

	public function hapus($id){
		// $input = $this->GlobalModel->getdata('');
		// pre($input);
		$save = $this->PenjualanModel->hapusPenjualan($id);
		if($save['success']==TRUE){
			$this->session->set_flashdata('msg','Data berhasil dihapus');
			redirect($this->url);
		}else{
			$this->session->set_flashdata('gagal','Data gagal dihapus');
			redirect($this->url);
		}
	}

	function stokpo(){
		$data['title']='Stok PO Online';
		$data['rekap']=$this->OnlineModel->getDataStokGroupBySize();
		$data['products']=$this->OnlineModel->getDataStok();
		// pre($data['products']);

		$pos = [
			[
				'kode_po' => 'PO 1',
				'items' => [
					[
						'serian' => 'Greens',
						'sizes' => [
							['size' => 1, 'qty' => 1],
							['size' => 2, 'qty' => 1],
							['size' => 3, 'qty' => 1],
							['size' => 4, 'qty' => 1],
							['size' => 5, 'qty' => 1],
							['size' => 6, 'qty' => 2]
						]
					],
					[
						'serian' => 'Coklut',
						'sizes' => [
							['size' => 1, 'qty' => 1],
							['size' => 2, 'qty' => 1],
							['size' => 3, 'qty' => 1],
							['size' => 4, 'qty' => 1],
							['size' => 5, 'qty' => 1],
							['size' => 6, 'qty' => 1]
						]
					],
					// Anda dapat menambahkan item lain dengan struktur yang sama di sini
				]
			],
			[
				'kode_po' => 'PO 2',
				'items' => [
					[
						'serian' => 'Green',
						'sizes' => [
							['size' => 1, 'qty' => 1],
							['size' => 2, 'qty' => 1],
							['size' => 3, 'qty' => 1],
							['size' => 4, 'qty' => 1],
							['size' => 5, 'qty' => 1],
							['size' => 6, 'qty' => 1]
						]
					],
					// Anda dapat menambahkan item lain dengan struktur yang sama di sini
				]
			]
		];
		
		$data['pos']=$pos;		
		$get = $this->input->get();
		if(!isset($get['excel'])){
			$data['page']=$this->page.'stok';
			$this->load->view($this->layout,$data);
		}else{
			$this->load->view($this->page.'stok_excel',$data);
		}
		
	}
}