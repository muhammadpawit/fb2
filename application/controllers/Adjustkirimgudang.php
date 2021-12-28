<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adjustkirimgudang extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/adjustment/';
		$this->url=BASEURL.'Adjustkirimgudang/';
		$this->load->model('AdjustModel');
	}

	public function index(){
		$data=[];
		$data['title']='Adjustment Kirim Gudang ';
		$no=1;
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
		$data['products']=[];
		$filter=array(
			'tanggal1',$tanggal1,
			'tanggal2'=>$tanggal2,
			//'tampil'=>1,
			'hapus'=>0,
		);
		$products=$this->AdjustModel->kirimgudang($filter);
		$data['products'] = $products;
		$data['details']=[];
		$details=$this->AdjustModel->kirimgudang_detail($filter);
		$data['details'] = $details;
		$data['tambah']=$this->url.'tambah';
		$data['page']=$this->page.'list';
		$data['url']=$this->url;
		$this->load->view($this->layout,$data);
	}

	public function tambah(){
		$data=[];
		$data['title']='Tambah Adjust Kirim Gudang';
		$data['page']=$this->page.'tambah';
		$data['action']=$this->url.'simpan';
		$data['url']=$this->url;
		$this->load->view($this->layout,$data);
	}

	public function simpan(){
		$data=$this->input->post();
		$this->AdjustModel->kirimgudang_insert($data);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->url);
	}


	public function tampil($id){
		$this->AdjustModel->kirimgudang_tampil($id);
		$this->session->set_flashdata('msg','Data berhasil diupdate');
		redirect($this->url);
	}

	public function hide($id){
		$this->AdjustModel->kirimgudang_hide($id);
		$this->session->set_flashdata('msg','Data berhasil diupdate');
		redirect($this->url);
	}

	public function hapus($id){
		$this->AdjustModel->kirimgudang_hapus($id);
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect($this->url);
	}


}