<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajuanalatalat extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/ajuanalatalat/';
		$this->url=BASEURL.'Ajuanalatalat/';
		$this->load->model('AjuanalatModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index($id){
		$data=[];
		$data['title']="Ajuan alat-alat ";
		$data['title'].=$id==1?'Bordir':'Konveksi';
		$get=$this->input->get();
		$url='';
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
			$url.='&tanggal1='.$tanggal1;
		}else{
			$tanggal1=null;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
			$url.='&tanggal2='.$tanggal2;
		}else{
			$tanggal2=null;
		}		
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
		);
		$data['prods']=$this->AjuanalatModel->show($filter);
		$data['id']=$id;
		$data['tambah']=$this->url.'tambah'.'/'.$id;
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	public function tambah($id){
		$data=[];
		$data['title']="Form Ajuan alat-alat ";
		$data['title'].=$id==1?'Bordir':'Konveksi';
		$get=$this->input->get();
		$url='';
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
			$url.='&tanggal1='.$tanggal1;
		}else{
			$tanggal1=null;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
			$url.='&tanggal2='.$tanggal2;
		}else{
			$tanggal2=null;
		}		
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
		);
		$data['barang'] = $this->GlobalModel->QueryManual("SELECT * FROM gudang_persediaan_item WHERE hapus=0 AND id_persediaan IN (SELECT idpersediaan FROM barangkeluarharian_detail WHERE hapus=0 GROUP BY idpersediaan) ORDER BY nama_item ASC");
		$data['action']=$this->url.'save';
		$data['cancel']=$this->url;
		$data['page']=$this->page.'tambah';
		$data['supplier'] = $this->GlobalModel->getData('master_supplier',null);
		$data['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$data['products'] = $this->GlobalModel->getData('product',array('hapus'=>0));
		$this->load->view($this->layout,$data);
	}

	public function cari($id='')
	{
		$tgl = $this->input->get('tgl');
		$getId = $this->input->get('id');
		//$data = $this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=>$getId));
		$sql="SELECT * FROM barangkeluarharian_detail WHERE hapus=0 and idpersediaan='".$getId."' AND tanggal <='".$tgl."' ORDER BY tanggal DESC LIMIT 1 ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		echo json_encode($data);
	}

	public function save(){
		$data=$this->input->post();
		$this->AlatsukabumiModel->insert($data);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->url);
	}

	public function distribusi(){
		$data=[];
		$data['title']='Pengiriman Alat-alat Di Sukabumi Ke CMT ';
		$get=$this->input->get();
		$url='';
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
			$url.='&tanggal1='.$tanggal1;
		}else{
			$tanggal1=null;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
			$url.='&tanggal2='.$tanggal2;
		}else{
			$tanggal2=null;
		}
		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
			$url.='&cmt='.$cmt;
		}else{
			$cmt=null;
		}		
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['selcmt']=$cmt;
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
		);
		$data['prods']=$this->AlatsukabumiModel->distribusi($filter);
		$data['action']=$this->url.'distribusi_save';
		$data['cmt']	= $this->GlobalModel->GetData('master_cmt',array('hapus'=>0,'lokasi'=>3));
		$data['alat']	= $this->GlobalModel->GetData('stok_barang_skb',array('hapus'=>0));
		$data['page']=$this->page.'distribusi';
		$this->load->view($this->layout,$data);
	}

	public function distribusi_save(){
		$this->AlatsukabumiModel->distribusi_save();
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->url.'distribusi');
	}

	public function cariproduct($id='')
	{
		$getId = $this->input->get('id');
		$data = $this->GlobalModel->getDataRow('stok_barang_skb',array('id_persediaan'=>$getId));
		echo json_encode($data);
	}

	public function distribusi_hapus($id){
		$this->AlatsukabumiModel->distribusi_hapus($id);
	}

	public function distribusi_validasi($id){
		$this->AlatsukabumiModel->distribusi_validasi($id);
	}

}