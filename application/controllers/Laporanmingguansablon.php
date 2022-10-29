<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanmingguansablon extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/laporanmingguan/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Laporanmingguansablon/';
		$this->load->model('LaporanmingguanModel');
	}

	public function index(){
		$data=[];
		$data['title']='Laporan Keuangan Mingguan Sablon ';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("Monday last week"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Saturday last week"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$masuk_kas=0;
		$masuk_transfer=0;
		$alokasi=0;
		$keterangan=null;
		$bagian=3;
		foreach (looping_tanggal($tanggal1,$tanggal2) as $dt) {
			$masuk_kas=$this->LaporanmingguanModel->kas_masuk_bordir($dt['tanggal'],$bagian);
			$masuk_transfer=$this->LaporanmingguanModel->transferan_bordir($dt['tanggal'],$bagian);
			$keterangan=$this->LaporanmingguanModel->keterangan_bordir($dt['tanggal'],$bagian);
		    $data['results'][]=array(
		    	'hari'=>hari(date('l',strtotime($dt['tanggal']))),
		    	'tanggal'=>date('d-m-Y',strtotime($dt['tanggal'])),
		    	'transfer'=>$masuk_transfer,
		    	'kas'=>$masuk_kas,
		    	'bahanbaku'=>$this->LaporanmingguanModel->alokasi_bordir($dt['tanggal'],$bagian,12),
		    	'inventaris'=>$this->LaporanmingguanModel->alokasi_bordir($dt['tanggal'],$bagian,13),
		    	'ops'=>$this->LaporanmingguanModel->alokasi_bordir($dt['tanggal'],$bagian,14),
		    	'gaji'=>$this->LaporanmingguanModel->alokasi_bordir($dt['tanggal'],$bagian,15),
		    	'sisa'=>$this->LaporanmingguanModel->alokasi_bordir($dt['tanggal'],$bagian,16),
		    	'keterangan'=>implode(",",$keterangan),
		    );
		} 
		$data['page']=$this->page.'sablon';
		$this->load->view($this->layout,$data);
	}

}