<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Alokasitransferkonveksi extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/alokasitransfer/';
		$this->url=BASEURL.'Alokasitransferkonveksi/';
	}

	public function index(){
		$data=[];
		$data['title']='Alokasi Transfer Konveksi';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$bagian=1;
		$sql = "SELECT * FROM alokasi_transferan WHERE hapus=0 AND bagian='$bagian' ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		$data['prods']=[];
		foreach($results as $r){
			$data['prods'][]=array(
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'keterangan'=>$r['keterangan'],
				'nominal'=>$r['nominal'],
			);
		}
		$data['action']=$this->url.'save';
		$data['alokasi']=$this->GlobalModel->Getdata("pengalokasian",array('hapus'=>0,'bagian'=>$bagian));
		$data['page']=$this->page.'bordir';
		$data['bagian']=$bagian;
		$this->load->view($this->layout,$data);
	}

	public function save(){
		$data=$this->input->post();
		$insert=array(
			'tanggal'=>$data['tanggal'],
			'bagian'=>$data['bagian'],
			'nominal'=>$data['nominal'],
			'keterangan'=>$data['keterangan'],
			'pengalokasian'=>$data['pengalokasian'],
			'hapus'=>0,
		);
		$this->db->insert('alokasi_transferan',$insert);
		$this->session->set_flashdata('msg','Berhasil Di Simpan');
		redirect($this->url);
	}
}