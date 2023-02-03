<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stokalatskb extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/alatsukabumi/';
		$this->url=BASEURL.'Alatsukabumi/';
		$this->load->model('AlatsukabumiModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Stock Alat-alat Di Sukabumi';
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
		$data['prods']=$this->AlatsukabumiModel->stock($filter);
		$data['tambah']=$this->url.'tambah';
		$data['page']=$this->page.'stock';
		$this->load->view($this->layout,$data);
	}

	public function tambah(){
		$data=[];
		$data['title']='Terima Alat-alat Di Sukabumi';
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
		$data['simpan']=$this->url.'save';
		$data['cancel']=$this->url;
		$data['page']=$this->page.'tambah';
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

}