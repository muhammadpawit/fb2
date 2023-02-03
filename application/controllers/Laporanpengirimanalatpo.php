<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpengirimanalatpo extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/laporanpengirimanalatpo/';
		$this->url=BASEURL.'Laporanpengirimanalatpo/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function mingguan(){
		$data=[];
		$data['title']='Laporan Rekap Pengiriman Alat - Alat ';
		$get=$this->input->get();
		$url='';
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("Monday this week"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Saturday this week"));;
		}		
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$update=$this->GlobalModel->QueryManualRow("SELECT * FROM gudang_item_keluar WHERE hapus=0 ORDER BY created_date DESC LIMIT 1 ");
		$sql="SELECT id_item_keluar, nama_penerima, tujuan_item FROM gudang_item_keluar WHERE hapus=0 "; 
		if(!empty($tanggal1)){
			$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" GROUP BY nama_penerima ASC ";
		//pre($sql);
		$results=[];
		$results=$this->GlobalModel->Querymanual($sql);
		foreach($results as $r){
			$d=$this->ReportModel->getrekapalat(strtolower($r['nama_penerima']),$tanggal1,$tanggal2);
			$data['results'][]=array(
				'nama'=>strtolower($r['nama_penerima']),
				'alamat'=>strtolower($r['tujuan_item']),
				'po'=>implode(",", $d),
				'jumlah'=>count($d),
			);
		}
		//pre($data['results']);
		$data['update']=date('d F Y',strtotime($update['created_date']));
		if(isset($get['excel'])){
			$this->load->view($this->page.'mingguan_excel',$data);
		}else{
			$data['page']=$this->page.'mingguan';
			$this->load->view($this->layout,$data);
		}
	}

	public function bulanan(){
		$data=[];
		$data['title']='Laporan Rekap Pengiriman Alat - Alat ';
		$get=$this->input->get();
		$url='';
		if(isset($get['bulan'])){
			$tanggal1=$get['bulan'];
		}else{
			$tanggal1=date('n',strtotime("-1 month"));
		}
		if(isset($get['tahun'])){
			$tanggal2=$get['tahun'];
		}else{
			$tanggal2=date('Y');;
		}		
		$data['bulan']=$tanggal1;
		$data['tahun']=$tanggal2;
		$update=$this->GlobalModel->QueryManualRow("SELECT * FROM gudang_item_keluar WHERE hapus=0 ORDER BY created_date DESC LIMIT 1 ");
		$sql="SELECT id_item_keluar, nama_penerima, tujuan_item FROM gudang_item_keluar WHERE hapus=0 "; 
		if(!empty($tanggal1)){
			$sql.=" AND MONTH(created_date) = '".$tanggal1."' ";
		}

		if(!empty($tanggal1)){
			$sql.=" AND YEAR(created_date) = '".$tanggal2."' ";
		}

		$sql.=" GROUP BY nama_penerima ASC ";
		//pre($sql);
		$results=[];
		$results=$this->GlobalModel->Querymanual($sql);
		foreach($results as $r){
			$d=$this->ReportModel->getrekapalatbulan(strtolower($r['nama_penerima']),$tanggal1,$tanggal2);
			$data['results'][]=array(
				'nama'=>strtolower($r['nama_penerima']),
				'alamat'=>strtolower($r['tujuan_item']),
				'po'=>implode(",", $d),
				'jumlah'=>count($d),
			);
		}
		//pre($data['results']);
		$data['update']=date('d F Y',strtotime($update['created_date']));
		if(isset($get['excel'])){
			$this->load->view($this->page.'bulanan_excel',$data);
		}else{
			$data['page']=$this->page.'bulanan';
			$this->load->view($this->layout,$data);
		}
	}

}