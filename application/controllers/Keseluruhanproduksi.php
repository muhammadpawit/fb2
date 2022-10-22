<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keseluruhanproduksi extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/keseluruhanproduksi/';
		$this->url=BASEURL.'Keseluruhanproduksi/';
		$this->load->model('ReportModel');
	}

	public function index(){
		$data['title']='Keseluruhan Produksi ';
		$get=$this->input->get();
		$tanggal1='2021-05-25';
		$tanggal2=date('Y-m-d');
		$data['tanggal1']=date('d F Y',strtotime($tanggal1));
		$data['tanggal2']=date('d F Y',strtotime($tanggal2));
		$tanggalm1=date('Y-m-d',strtotime("Monday previous week"));
		$tanggalm2=date('Y-m-d');
		$data['tanggalm1']=date('d F Y',strtotime($tanggalm1));
		$data['tanggalm2']=date('d F Y',strtotime($tanggalm2));
		$data['rekap']=[];
		$arpo=array(
			array('type'=>'Kemeja','id'=>1,'color'=>'#32a852'),
			array('type'=>'Kaos','id'=>2,'color'=>'#3269a8'),
			array('type'=>'Celana','id'=>3,'color'=>'#cfc930'),
		);
		// potongan
		$npm=1;
		foreach($arpo as $arp){
			$pdz=$this->ReportModel->ppcs_filter($arp['id'],$tanggalm1,$tanggalm2);
			$jmlpo=$this->ReportModel->ppcsjml_filter($arp['id'],$tanggalm1,$tanggalm2);
			$data['rekappotm'][]=array(
				'no'=>$npm,
				'id'=>$arp['id'],
				'type'=>'<a href="'.$this->url.'potonganmingguan/'.$arp['id'].'">'.$arp['type'].'</a>',
				'dz'=>$pdz/12,
				'pcs'=>$pdz,
				'po'=>round($jmlpo),
			);
			$npm++;
		}


		$np=1;
		foreach($arpo as $arp){
			$pdz=$this->ReportModel->ppcs_filter($arp['id'],$tanggal1,$tanggal2);
			$jmlpo=$this->ReportModel->ppcsjml_filter($arp['id'],$tanggal1,$tanggal2);
			$data['rekappot'][]=array(
				'no'=>$np,
				'id'=>$arp['id'],
				'type'=>'<a href="'.$this->url.'potonganrekap/'.$arp['id'].'">'.$arp['type'].'</a>',
				'dz'=>$pdz/12,
				'pcs'=>$pdz,
				'po'=>round($jmlpo),
			);
			$np++;
		}
		// end potongan

		// global finishing_kirim_gudang

		$ikg=1;
		$qty=0;
		$qtysetor=0;
		$ckirim=0;
		$csetor=0;
		foreach($arpo as $arp){
			$data['rekapkg'][]=array(
				'no'=>$ikg,
				'id'=>$arp['id'],
				'type'=>'<a href="'.$this->url.'kirimgudangrekap/'.$arp['id'].'">'.$arp['type'].'</a>',
				'po'=>$this->ReportModel->count_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2),
				'dz'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2)/12,
				'pcs'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2),
				'total'=>$this->ReportModel->pcs_monitoring_kirimgudang_harga($arp['id'],$tanggal1,$tanggal2),
			);
			$ikg++;
		}

		
		$data['tanggalm1']=date('d F Y',strtotime($tanggalm1));
		$data['tanggalm2']=date('d F Y',strtotime($tanggalm2));
		$ikgm=1;
		foreach($arpo as $arp){
			$data['rekapkgmingguan'][]=array(
				'no'=>$ikgm,
				'id'=>$arp['id'],
				'type'=>'<a href="'.$this->url.'kirimgudangmingguan/'.$arp['id'].'">'.$arp['type'].'</a>',
				'po'=>$this->ReportModel->count_monitoring_kirimgudang($arp['id'],$tanggalm1,$tanggalm2),
				'dz'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggalm1,$tanggalm2)/12,
				'pcs'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggalm1,$tanggalm2),
				'total'=>$this->ReportModel->pcs_monitoring_kirimgudang_harga($arp['id'],$tanggalm1,$tanggalm2),
			);
			$ikgm++;
		}

		//end kirim gudang


		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	public function mingguan(){
		$data['title']='Laporan Produksi Mingguan';
		$get=$this->input->get();
		$tanggal1='2021-05-25';
		$tanggal2=date('Y-m-d');
		$data['tanggal1']=date('d F Y',strtotime($tanggal1));
		$data['tanggal2']=date('d F Y',strtotime($tanggal2));
		$tanggalm1=date('Y-m-d',strtotime("Monday previous week"));
		$tanggalm2=date('Y-m-d');
		$data['tanggalm1']=date('d F Y',strtotime($tanggalm1));
		$data['tanggalm2']=date('d F Y',strtotime($tanggalm2));
		$data['rekap']=[];
		$arpo=array(
			array('type'=>'Kemeja','id'=>1,'color'=>'#32a852'),
			array('type'=>'Kaos','id'=>2,'color'=>'#3269a8'),
			array('type'=>'Celana','id'=>3,'color'=>'#cfc930'),
		);
		// potongan
		$npm=1;
		foreach($arpo as $arp){
			$pdz=$this->ReportModel->ppcs_filter($arp['id'],$tanggalm1,$tanggalm2);
			$jmlpo=$this->ReportModel->ppcsjml_filter($arp['id'],$tanggalm1,$tanggalm2);
			$data['rekappotm'][]=array(
				'no'=>$npm,
				'id'=>$arp['id'],
				'type'=>'<a href="'.$this->url.'potonganmingguan/'.$arp['id'].'">'.$arp['type'].'</a>',
				'dz'=>$pdz/12,
				'pcs'=>$pdz,
				'po'=>round($jmlpo),
			);
			$npm++;
		}


		$np=1;
		foreach($arpo as $arp){
			$pdz=$this->ReportModel->ppcs_filter($arp['id'],$tanggal1,$tanggal2);
			$jmlpo=$this->ReportModel->ppcsjml_filter($arp['id'],$tanggal1,$tanggal2);
			$data['rekappot'][]=array(
				'no'=>$np,
				'id'=>$arp['id'],
				'type'=>'<a href="'.$this->url.'potonganrekap/'.$arp['id'].'">'.$arp['type'].'</a>',
				'dz'=>$pdz/12,
				'pcs'=>$pdz,
				'po'=>round($jmlpo),
			);
			$np++;
		}
		// end potongan

		// global finishing_kirim_gudang

		$ikg=1;
		$qty=0;
		$qtysetor=0;
		$ckirim=0;
		$csetor=0;
		foreach($arpo as $arp){
			$data['rekapkg'][]=array(
				'no'=>$ikg,
				'id'=>$arp['id'],
				'type'=>'<a href="'.$this->url.'kirimgudangrekap/'.$arp['id'].'">'.$arp['type'].'</a>',
				'po'=>$this->ReportModel->count_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2),
				'dz'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2)/12,
				'pcs'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2),
				'total'=>$this->ReportModel->pcs_monitoring_kirimgudang_harga($arp['id'],$tanggal1,$tanggal2),
			);
			$ikg++;
		}

		
		$data['tanggalm1']=date('d F Y',strtotime($tanggalm1));
		$data['tanggalm2']=date('d F Y',strtotime($tanggalm2));
		$ikgm=1;
		foreach($arpo as $arp){
			$data['rekapkgmingguan'][]=array(
				'no'=>$ikgm,
				'id'=>$arp['id'],
				'type'=>'<a href="'.$this->url.'kirimgudangmingguan/'.$arp['id'].'">'.$arp['type'].'</a>',
				'po'=>$this->ReportModel->count_monitoring_kirimgudang($arp['id'],$tanggalm1,$tanggalm2),
				'dz'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggalm1,$tanggalm2)/12,
				'pcs'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggalm1,$tanggalm2),
				'total'=>$this->ReportModel->pcs_monitoring_kirimgudang_harga($arp['id'],$tanggalm1,$tanggalm2),
			);
			$ikgm++;
		}

		//end kirim gudang


		$data['page']=$this->page.'mingguan';
		$this->load->view($this->layout,$data);
	}

	public function potonganmingguan($jenis){
		$data=[];
		$data['title']='Rincian Potonganmingguan ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
			$rekap1=$get['tanggal1'];
		}else{
			//$tanggal1=date('Y-m-d',strtotime("first day of this month"));
			$tanggal1=date('Y-m-d',strtotime("Monday previous week"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
			//$rekap2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
			//$rekap2=date('Y-m-d',strtotime("last day of this month"));
		}

		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['prods']=[];
		$data['jenis']=null;
		if($jenis==1){
			// kemeja
			$data['jenis']='Kemeja';
			$kemeja=$this->GlobalModel->Getdata('master_jenis_po',array('status'=>1,'idjenis'=>1,'tampil'=>1));
			$nok=1;
			foreach($kemeja as $k){
				$perkalian=$k['perkalian'];
				$data['prods'][]=array(
					'no'=>$nok++,
					'nama'=>strtoupper($k['nama_jenis_po']),
					'jmlpo'=>$this->ReportModel->ge($k['nama_jenis_po'],1,$tanggal1,$tanggal2),
					'pdz'=>$this->ReportModel->ge($k['nama_jenis_po'],2,$tanggal1,$tanggal2),
					'ppcs'=>$this->ReportModel->ge($k['nama_jenis_po'],3,$tanggal1,$tanggal2),
				);
			}
		}else if($jenis==2){
			// kaos 
			$data['jenis']='Kaos';
			$kaos=$this->GlobalModel->Getdata('master_jenis_po',array('status'=>1,'idjenis'=>2));
			$nokaos=1;
			foreach($kaos as $k){
				$data['prods'][]=array(
					'no'=>$nokaos++,
					'nama'=>strtoupper($k['nama_jenis_po']),
					'jmlpo'=>$this->ReportModel->ge($k['nama_jenis_po'],1,$tanggal1,$tanggal2),
					'pdz'=>$this->ReportModel->ge($k['nama_jenis_po'],2,$tanggal1,$tanggal2),
					'ppcs'=>$this->ReportModel->ge($k['nama_jenis_po'],3,$tanggal1,$tanggal2),
				);
			}
		}else{
			// celana
			$data['jenis']='Celana';
			$celana=$this->GlobalModel->Getdata('master_jenis_po',array('status'=>1,'idjenis'=>3));
			$nocelana=1;
			foreach($celana as $k){
				$data['prods'][]=array(
					'no'=>$nocelana++,
					'nama'=>strtoupper($k['nama_jenis_po']),
					'jmlpo'=>$this->ReportModel->ge($k['nama_jenis_po'],1,$tanggal1,$tanggal2),
					'pdz'=>$this->ReportModel->ge($k['nama_jenis_po'],2,$tanggal1,$tanggal2),
					'ppcs'=>$this->ReportModel->ge($k['nama_jenis_po'],3,$tanggal1,$tanggal2),
				);
			}
		}
		$data['cancel']=$this->url.'mingguan';
		$data['page']=$this->page.'potonganmingguan';
		$this->load->view($this->layout,$data);	
	}
}