<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {


	function __construct() {

		parent::__construct();

		//sessionLogin(URLPATH."\\".$this->uri->segment(1));

		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');

	}

	public function index(){
		$data=array();
		$this->load->view('global/header');
		$data['url']=BASEURL.'Product';
		$data['i']=1;
		$data['tambah']=BASEURL.'Product/Add';
			$filter=array(
				'hapus'=>0,
			);
		$results=array();
		$results=$this->GlobalModel->getData('product',$filter);
		$satuan=0;
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => BASEURL.'Product/View/'.$result['product_id'],
			);

			$action[] = array(
				'text' => 'Warna',
				'href' => BASEURL.'Product/Color/'.$result['product_id'],
			);

			$satuan = $this->GlobalModel->getDataRow('master_satuan_barang',array('id_satuan_barang'=>$result['satuan']));
			
			$data['products'][]=array(
				'product_id'=>$result['product_id'],
				'kodebarang'=>$result['kodebarang'],
				'nama'=>strtoupper($result['nama']),
				'satuan'=>$satuan['kode_satuan_barang'],
				'quantity'=>$result['quantity'],
				'price'=>number_format($result['price'],2),
				'action'=>$action,
			);
		}
		
		
		$this->load->view('master/product/list_product',$data);
		$this->load->view('global/footer');
	}

	public function Add(){
		$data=array();
		$this->load->view('global/header');
		$data['url']=BASEURL.'Product';
		$data['tambah']=BASEURL.'ProductAdd';
		$this->load->view('master/product/add_product',$data);
		$this->load->view('global/footer');
	}

	public function Productsave(){
		$data=$this->input->post();
		$ip=array(
			'nama'=>$data['nama'],
			'warna_item'=>$data['warna_item'],
			'ukuran_item'=>$data['ukuran_item'],
			'satuan_ukuran_item'=>$data['satuan_ukuran_item'],
			'satuan'=>$data['satuan'],
			'quantity'=>0,
			'price'=>0,
			'hapus'=>0,
			'date_added'=>date('Y-m-d H:i:s'),
			'user_added'=>callSessUser('nama_user'),
			'minstok'=>$data['minstok'],
			'resiko'=>$data['resiko'],
		);
		$this->db->insert('product',$ip);
		$id=$this->db->insert_id();
		$this->db->query("UPDATE product set kodebarang='ITM-0".$id."' WHERE product_id='$id' ");
		$gip=array(
			'id_persediaan'=>$id,
			'nama_item'=>$data['nama'],
			'warna_item'=>$data['warna_item'],
			'ukuran_item'=>$data['ukuran_item'],
			'satuan_ukuran_item'=>$data['satuan_ukuran_item'],
			'satuan_jumlah_item'=>$data['satuan'],
			'jumlah_item'=>0,			
			'created_date'=>date('Y-m-d'),
			'nama_supplier'=>'-',
			'kode_transfer'=>0,
			'contact_supplier'=>0,
			'harga_item'=>0,
			'resiko_item'=>0,
		);
		$this->db->insert('gudang_persediaan_item',$gip);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Product');
	}

	public function View($id){
		$data=array();
		$this->load->view('global/header');
		$data['url']=BASEURL.'Product';
		$data['tambah']=BASEURL.'ProductAdd';
		$this->load->view('master/product/add_product',$data);
		$this->load->view('global/footer');
	}

	public function Color($id){
		$data=array();
		$this->load->view('global/header');
		$data['url']=BASEURL.'Product';
		$data['tambah']=BASEURL.'ProductAdd';
		$this->load->view('master/product/add_product',$data);
		$this->load->view('global/footer');
	}
}

?>