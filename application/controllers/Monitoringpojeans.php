<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoringpojeans extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/monitoringpojeans/';
		$this->url=BASEURL.'Monitoringpojeans/';
		$this->load->model('MonitoringpojeansModel');
	}

	public function kirimgudang(){
		$data=[];
		$data['title']='PO Jeans yang sudah kirim gudang ';
		$no=1;
		$get=$this->input->get();
		$url='';
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
			$url.='&tanggal1='.$tanggal1;
			$limit=1;
		}else{
			$tanggal1=null;
			$limit=0;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
			$url.='&tanggal2='.$tanggal2;
			$limit+=1;
		}else{
			$tanggal2=null;
			$limit=0;
		}		
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['products']=[];
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			//'tampil'=>1,
			'hapus'=>0,
			'limit'=>$limit,
		);
		//pre($filter);
		$products=$this->MonitoringpojeansModel->getdata($filter);
		$data['products'] = $products;
		$data['tambah']=$this->url.'tambah';
		$data['page']=$this->page.'kirimgudang';
		$data['url']=$this->url;
		$this->load->view($this->layout,$data);
	}

	public function tambah(){
		$data=[];
		$data['title']='tambah transport homie noya ';
		$data['page']=$this->page.'tambah';
		$data['action']=$this->url.'simpan';
		$data['cmt']=$this->GlobalModel->getdata('master_cmt',array('hapus'=>0));
		$data['url']=$this->url;
		$this->load->view($this->layout,$data);
	}

	public function simpan(){
		$data=$this->input->post();
		$this->TransportModel->insert_pendapatan($data);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->url.'pendapatan');
	}


	public function tampil($id){
		$this->TransportModel->kirimgudang_tampil($id);
		$this->session->set_flashdata('msg','Data berhasil diupdate');
		redirect($this->url);
	}

	public function hapus_pendapatan($id){
		$this->TransportModel->hapus_pendapatan($id);
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect($this->url.'pendapatan');
	}

	// driver
	public function driver(){
		$data=[];
		$data['title']='Biaya transport driver ';
		$no=1;
		$get=$this->input->get();
		$url='';
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
			$url.='&tanggal1='.$tanggal1;
			$limit=1;
		}else{
			$tanggal1=null;
			$limit=0;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
			$url.='&tanggal2='.$tanggal2;
			$limit+=1;
		}else{
			$tanggal2=null;
			$limit=0;
		}		
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['products']=[];
		$filter=array(
			'tanggal1',$tanggal1,
			'tanggal2'=>$tanggal2,
			//'tampil'=>1,
			'hapus'=>0,
			'limit'=>$limit,
		);
		//pre($filter);
		$products=$this->TransportModel->getdata_driver($filter);
		$data['products'] = $products;
		$data['tambah']=$this->url.'tambah_driver';
		$data['page']=$this->page.'driver';
		$data['url']=$this->url;
		$this->load->view($this->layout,$data);
	}

	public function tambah_driver(){
		$data=[];
		$data['title']='tambah transport driver ';
		$data['page']=$this->page.'tambah_driver';
		$data['action']=$this->url.'simpan_driver';
		$data['url']=$this->url.'driver';
		$this->load->view($this->layout,$data);
	}

	public function simpan_driver(){
		$data=$this->input->post();
		$this->TransportModel->insert_driver($data);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->url.'driver');
	}


	public function tampil_driver($id){
		$this->TransportModel->kirimgudang_tampil($id);
		$this->session->set_flashdata('msg','Data berhasil diupdate');
		redirect($this->url.'driver');
	}

	public function hapus_driver($id){
		$this->TransportModel->hapus_driver($id);
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect($this->url.'driver');
	}

	public function prosespo(){
		$data=[];
		$data['title']='Monitoring Proses PO Setelan Jeans ';
		$data['page']=$this->page.'prosespo';
		$this->load->view($this->layout,$data);
	}


}