<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporantimpotong extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/laporantimpotong/';
		$this->url=BASEURL.'Laporantimpotong/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function bulanan(){
		$data=[];
		$data['title']='Laporan Potongan Bulanan';
		$get=$this->input->get();
		$data['jenis']=[];
		$results=array();
		if(isset($get['bulan'])){
			$bulan=$get['bulan'];
		}else{
			$bulan=date('n',strtotime("-1 month"));
		}
		if(isset($get['tahun'])){
			$tahun=$get['tahun'];
		}else{
			$tahun=date('Y');
		}
		$data['bulan']=$bulan;
		$data['tahun']=$tahun;

		$jenis=$this->GlobalModel->QueryManual("SELECT * FROM master_jenis_po WHERE nama_jenis_po IN (SELECT SUBSTR(kode_po,1, 3) AS po FROM konveksi_buku_potongan ) ");
		$tim=$this->GlobalModel->QueryManual("SELECT * FROM timpotong WHERE id IN (SELECT tim_potong_potongan FROM konveksi_buku_potongan WHERE hapus=0 AND MONTH(created_date)='".$bulan."' AND YEAR(created_date)='".$tahun."' ) ");
		$prods=[];
		$jml=[];
		$no=1;

		$noh=1;
		$data['bupot']=[];
		$timptg=$this->GlobalModel->getData('timpotong',array('hapus'=>0));
		$detbupot=[];
		foreach($tim as $t){
			$detbupot=$this->ReportModel->bukupotongan_bulanan($t['id'],$bulan,$tahun);
			$data['bupot'][]=array(
				
				'nama'=>$t['nama'],
				'dets'=>$detbupot
			);
		}
		
		$data['page']=$this->page.'bulanan';
		$this->load->view($this->layout,$data);
	}
}