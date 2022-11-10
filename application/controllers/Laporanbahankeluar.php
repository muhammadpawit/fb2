<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanbahankeluar extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/laporanbahankeluar/';
		$this->url=BASEURL.'Laporanbahankeluar/';
	}

	public function index(){
		$data=[];
		$data['title']='Laporan Bahan Keluar';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-12 day"));
		}
		//pre(date('m',strtotime($tanggal1)));
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['prods']=[];
		$no=1;
		$sql="SELECT tanggal,id_persediaan,nama, satuan_ukuran, SUM(jumlah) as roll, SUM(ukuran) as yardkg, SUM(ukuran*harga) as total, harga FROM barangkeluar_harian_detail WHERE hapus=0 ";
		$sql.=" AND jenis=3 ";
		if(!empty($tanggal1)){
			$sql.=" AND MONTH(tanggal)='".date('m',strtotime($tanggal1))."' ";
			$sql.=" AND YEAR(tanggal)='".date('Y',strtotime($tanggal1))."' ";
		}
		$sql.=" GROUP BY id_persediaan ";
		$sql.=" ORDER BY satuan_ukuran ASC, nama ASC ";		
		$results=$this->GlobalModel->QueryManual($sql);
		$roll=0;
		$yardkg=0;
		$total=0;
		foreach($results as $r){
			$roll+=$r['roll'];
			$yardkg+=$r['yardkg'];
			$total+=$r['total'];
			$data['prods'][]=array(
				'no'=>$no,
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'id'=>$r['id_persediaan'],
				'nama'=>$r['nama'],
				'roll'=>$r['roll'],
				'yardkg'=>$r['yardkg'],
				'satuan'=>$r['satuan_ukuran'],
				'harga'=>$r['harga'],
				'total'=>$r['total'],
			);
			$no++;
		}
		$data['roll']=$roll;
		$data['yardkg']=$yardkg;
		$data['total']=$total;
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}
}