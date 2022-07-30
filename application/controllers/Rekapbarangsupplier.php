<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapbarangsupplier extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/rekapbarangsupplier/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Rekapbarangsupplier/';
	}

	public function index(){
		$data=array();
		$data['title']='Rekap Barang Masuk Supplier';
		$data['n']=1;
		$data['action']=$this->url.'rekapbarangsupplier_save';
		$data['prods']=[];
		$sql="SELECT * FROM rekapbarangsupplier WHERE hapus=0 ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $r){
			$s=$this->GlobalModel->getDataRow('master_supplier',array('id'=>$r['supplier']));
			$data['prods'][]=array(
				'id'=>$r['id'],
				'periode'=>$r['periode'],
				'ket'=>$r['keterangan'],
				'nama'=>$s['nama'],
				'detail'=>$this->url.'detail/'.$r['id'],
			);
		}
		$data['tambah']=$this->url.'add';
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	public function add(){
		$data=array();
		$data['title']='Input Rekap Barang Masuk Supplier';
		$data['simpan']=$this->url.'save';
		$data['sup']=$this->GlobalModel->getData('master_supplier',array('hapus'=>0));
		$data['page']=$this->page.'form';
		$this->load->view($this->layout,$data);
	}

	public function save(){
		$data=$this->input->post();
		$insert=array(
			'keterangan'=>$data['keterangan'],
			'periode'=>$data['periode'],
			'supplier'=>$data['supplier'],
			'hapus'=>0,
		);
		$this->db->insert('rekapbarangsupplier',$insert);
		$id=$this->db->insert_id();
		foreach($data['prods'] as $p){
			$idd=array(
				'idrekap'=>$id,
				'tanggal_awal'=>$p['tanggal_awal'],
				'tanggal_akhir'=>$p['tanggal_akhir'],
				'hapus'=>0,
			);
			$this->db->insert('rekapbarangsupplier_detail',$idd);
		}
		$this->session->set_flashdata('msg','Berhasil Di Simpan');
		redirect($this->url);
	}

	public function detail($id){
		$data=array();
		$data['title']='Detail Rekap Barang Masuk Supplier';
		$data['cancel']=$this->url;
		$data['k']=$this->GlobalModel->getDataRow('rekapbarangsupplier',array('hapus'=>0,'id'=>$id));
		$s=$this->GlobalModel->getDataRow('master_supplier',array('id'=>$data['k']['supplier']));
		$data['nama']=$s['nama'];
		$results=$this->GlobalModel->getData('rekapbarangsupplier_detail',array('hapus'=>0,'idrekap'=>$id));
		$total=0;
		foreach($results as $r){
			$total=$this->ReportModel->totalsup($data['k']['supplier'],$r['tanggal_awal'],$r['tanggal_akhir']);
			$data['d'][]=array(
				'tanggal_awal'=>$r['tanggal_awal'],
				'tanggal_akhir'=>$r['tanggal_akhir'],
				'nama'=>$s['nama'],
				'total'=>!empty($total)?$total:0,
			);
		}
		$data['page']=$this->page.'detail';
		$this->load->view($this->layout,$data);
	}
}