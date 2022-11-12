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
		// rekap perbulan kemeja
		$periode=$this->ReportModel->periode();
		for ($i = 0; $i < 12; $i++) {
		    $timestamp = mktime(0, 0, 0, $periode['bulan'] + $i, 1,$periode['tahun']); // angka 6 bulan juni, periode awal potongan
		    $bulan[]=$months[date('n', $timestamp)] = date('M Y', $timestamp);
		}
		$data['rkemeja']=[];
		$data['rkaos']=[];
		$data['rcelana']=[];
		$kemeja=[];
		$kaos=[];
		$celana=[];
		$data['perminggu']=[];
		$total=0;
		foreach($bulan as $b=>$val){
			$b=explode(" ", $val);
			$g=date('n',strtotime($b[0]));
			$t=explode(" ", $val);
			$timestamp = mktime(0, 0, 0, $g + $i, 1,$t[1]);
			$month=$months[date('n', $timestamp)] = date('n', $timestamp);
			$y=$t[1];
				$data['rkemeja'][]=array(
					'bulan'=>$val,
					'bln'=>$month,
					'year'=>$y,
					'roll'=>$this->ReportModel->barangkeluar_bulanan(1,17,$month,$y),
					'yard'=>$this->ReportModel->barangkeluar_bulanan(2,17,$month,$y),
				);
				$data['rkaos'][]=array(
					'bulan'=>$val,
					'bln'=>$month,
					'year'=>$y,
					'roll'=>$this->ReportModel->barangkeluar_bulanan(1,15,$month,$y),
					'kg'=>$this->ReportModel->barangkeluar_bulanan(2,15,$month,$y),
				);
				$data['rcelana'][]=array(
					'bulan'=>$val,
					'bln'=>$month,
					'year'=>$y,
					'roll'=>$this->ReportModel->barangkeluar_bulanan(1,16,$month,$y),
					'yard'=>$this->ReportModel->barangkeluar_bulanan(2,16,$month,$y),
				);
			$kemeja[]=array(
					'tot'=>!empty($this->ReportModel->barangkeluar_bulanan(1,17,$month,$y))?$this->ReportModel->barangkeluar_bulanan(1,17,$month,$y):0,
				);
			$kaos[]=array(
					'tot'=>!empty($this->ReportModel->barangkeluar_bulanan(1,15,$month,$y))?$this->ReportModel->barangkeluar_bulanan(1,17,$month,$y):0,
				);
			$celana[]=array(
					'tot'=>!empty($this->ReportModel->barangkeluar_bulanan(1,16,$month,$y))?$this->ReportModel->barangkeluar_bulanan(1,17,$month,$y):0,
				);
		}
		$data['kem']=implode(",", array_column($kemeja, 'tot'));
		//pre($data['kem']);
		$data['kao']=implode(",", array_column($kaos, 'tot'));
		$data['cel']=implode(",", array_column($celana, 'tot'));
		$bulan=$this->ReportModel->month();
		$data['bulan']=json_encode($bulan);
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}
}