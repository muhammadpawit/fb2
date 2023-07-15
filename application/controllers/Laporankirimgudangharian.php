<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Laporankirimgudangharian extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->load->model('ReportModel');
		$this->load->model('KirimsetorModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	function index(){
		$data=[];
		$data['title']='Laporan Kirim Gudang Minggu Ini';
		$get=$this->input->get();
		$data['products']=[];
		$results=array();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("sunday last week"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("saturday this month"));
		}

		if(isset($get['bulan'])){
			$bulan=$get['bulan'];
		}else{
			$bulan=date('n');
		}
		if(isset($get['tahun'])){
			$tahun=$get['tahun'];
		}else{
			$tahun=date('Y');
		}

		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
		);

		$results=$this->KirimsetorModel->kirimgudangharian_group($filter);
		//pre($results);
		$no=1;
		$prev=null;
		$h=null;
		$dets=[];
		foreach($results as $row){
			$hari=hari(date('l',strtotime($row['tanggal'])));
			$dets = $this->KirimsetorModel->kirimgudangharian_hari($filter,$hari);
			$ket = strtoupper($row['tujuan']);
			$data['products'][]=array(
				'no'=>$no,
				'hari'=>$hari,
				'tanggal'=>date('d-m-Y',strtotime($row['tanggal'])),
				'jml'=>null,
				'dz'=>$row['dz'],
				'nama'=>null,//$row['nama'],
				'nilai'=>$row['nilai'],//$row['nilai'],
				'keterangan'=>$row['keterangan'],//!empty($row['keterangan']) ? $ket.' ('.$row['keterangan'].')' : $ket,
				'dets' => $dets,
			);
			$no++;
		}
		//pre($data['products']);
		$data['resume']=[];
		$resume=$this->KirimsetorModel->kirimgudangharianresume($filter);
		foreach($resume as $row){
			$idjenis=$this->GlobalModel->GetDataRow('master_jenis_po',array('nama_jenis_po'=>$row['nama']));
			$data['resume'][]=array(
				'id'=>$idjenis['idjenis'], // 1 kemeja 2 kaos 3 celana
				'jml'=>$row['jml'],
				'nama'=>$row['nama'],
				'nilai'=>$row['nilai'],
				'dz'=>$row['pcs']/12,
				'keterangan'=>'Dikirim Gudang Tanah Abang',
			);
		}

		$url='';
		if(!empty($tanggal1)){
			$url.="&tanggal1=".$tanggal1;
		}
		if(!empty($tanggal2)){
			$url.="&tanggal2=".$tanggal2;
		}
		$data['excel']=BASEURL.'laporankirimgudangharian?&excel=true'.$url;
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['bulan']=$bulan;
		$data['tahun'] =$tahun;
		$data['log']   = $this->GlobalModel->QueryManualRow("SELECT * FROM finishing_kirim_gudang ORDER BY id_finishing_kirim_gudang DESC limit 1");
		if(isset($get['excel'])){
			$this->load->view($this->page.'report/kirimgudang_excel',$data);	
		}else{
			$data['page']=$this->page.'report/laporankirimgudangharian';
			$this->load->view($this->layout,$data);	
		}
	}
}