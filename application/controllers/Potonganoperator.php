<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Potonganoperator extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/potonganoperator/';
		$this->url=BASEURL.'Potonganoperator/';
		$this->load->model("M_potonganoperator");
	}


	public function index(){
		$data['title']='Potongan Operator Bordir';
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

		if(isset($get['nama'])){
			$nama=$get['nama'];
			$url.='&nama='.$nama;
		}else{
			$nama=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['nama']=$nama;
		$data['prods']=[];
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'nama'=>$nama,
		);
		$results=$this->M_potonganoperator->getData($filter);
		foreach($results as $r){
			$data['prods'][]=array(
				'id'=>$r['id'],
				'tanggal'=>$r['tanggal'],
				'nama'=>$r['nama'],
				'nominal'=>$r['nominal'],
				'jenis'=>$this->GlobalModel->GetDataRow('jenis_potongan',array('id'=>$r['jenis_potongan'])),
				'keterangan'=>$r['keterangan'],
				'hapus'=>$this->url.'delete/'.$r['id'],
			);
		}
		$data['tambah']=$this->url.'add';
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	public function add(){
		$data['title']='Tambah Potongan Operator';
		$data['cancel']=$this->url;
		$data['action']=$this->url.'insert';
		$data['page']=$this->page.'add';
		$data['jenis']=$this->GlobalModel->getData('jenis_potongan',array('hapus'=>0));
		$this->load->view($this->layout,$data);
	}

	public function insert(){	
		$this->M_potonganoperator->insert($this->input->post());
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect($this->url);
	}


	public function delete($id){	
		$this->M_potonganoperator->delete(array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect($this->url);
	}

}