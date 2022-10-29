<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporangajikaryawan extends CI_Controller {

	function __construct() {
		parent::__construct();
		////sessionLogin(URLPATH."\\".$this->uri->segment(1));
		////session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/laporangajikaryawan/';
		$this->url=BASEURL.'Laporangajikaryawan/';
		
	}

	public function index(){
		$data=[];
		$data['title']='Laporan Gaji Karyawan Forboys Production';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("Monday this week"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;

		if(isset($get['divisi'])){
			$divisi=$get['divisi'];
		}else{
			$divisi=null;
		}

		$sql="SELECT * FROM karyawan where hapus=0 ";
		if(!empty($divisi)){
			$sql.=" AND divisi='".$divisi."' ";
		}
		$sql.=" ORDER BY nama ASC ";
		$no=1;
		$prods=$this->GlobalModel->QueryManual($sql);
		$kasbon=[];
		$pinjaman=0;
		$sisapinjaman=0;
		$sisagaji=0;
		foreach($prods as $p){
			$bagian=$this->GlobalModel->GetDataRow('jabatan',array('hapus'=>0,'id'=>$p['jabatan']));
			$data['prods'][]=array(
				'no'=>$no++,
				'nama'=>$p['nama'],
				'bagian'=>!empty($bagian)?$bagian['nama']:null,
				'tglmasuk'=>date('Y-m-d',strtotime($p['tglmasuk'])),
				'gaji'=>$p['gajipokok'],
			);
		}
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}
}