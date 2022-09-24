<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {


	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('GlobalModel');
		$this->page='newtheme/page/monitoring/';
		$this->layout='newtheme/page/';
	}

	public function index() {
		$data=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
			$rekap1=$get['tanggal1'];
		}else{
			//$tanggal1=date('Y-m-d',strtotime("first day of this month"));
			$tanggal1=periodeproduksi()['tahun'].'-'.periodeproduksi()['bulan'].'-01';
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

		$data['title']='Monitoring PO Terpotong';
    	$data['rekappotongan']=[];
    	$j=1;
		$pdz=0;
		$ppcs=0;
		$jmlpo=0;
		$arpo=array(
			array('type'=>'Kemeja','id'=>1),
			array('type'=>'Kaos','id'=>2),
			array('type'=>'Celana','id'=>3),
		);
		// $d=$this->ReportModel->ge('assas',2);
		// pre($d);
		foreach($arpo as $arp){
			$pdz=$this->ReportModel->ppcs_filter($arp['id'],$tanggal1,$tanggal2);
			$jmlpo=$this->ReportModel->ppcsjml_filter($arp['id'],$tanggal1,$tanggal2);
			$data['rekappotongan'][]=array(
				'no'=>$j,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'pdz'=>$pdz/12,
				'ppcs'=>$pdz,
				'jmlpo'=>round($jmlpo),
			);
			$j++;
		}

		// kemeja
		$kemeja=$this->GlobalModel->Getdata('master_jenis_po',array('status'=>1,'idjenis'=>1,'tampil'=>1));
		$nok=1;
		foreach($kemeja as $k){
			$perkalian=$k['perkalian'];
			$data['kemeja'][]=array(
				'no'=>$nok++,
				'nama'=>strtoupper($k['nama_jenis_po']),
				'jmlpo'=>$this->ReportModel->ge($k['nama_jenis_po'],1,$tanggal1,$tanggal2),
				'pdz'=>$this->ReportModel->ge($k['nama_jenis_po'],2,$tanggal1,$tanggal2),
				'ppcs'=>$this->ReportModel->ge($k['nama_jenis_po'],3,$tanggal1,$tanggal2),
			);
		}
		
		// kaos 
		$kaos=$this->GlobalModel->Getdata('master_jenis_po',array('status'=>1,'idjenis'=>2,'tampil'=>1));
		$nokaos=1;
		foreach($kaos as $k){
			$data['kaos'][]=array(
				'no'=>$nokaos++,
				'nama'=>strtoupper($k['nama_jenis_po']),
				'jmlpo'=>$this->ReportModel->ge($k['nama_jenis_po'],1,$tanggal1,$tanggal2),
				'pdz'=>$this->ReportModel->ge($k['nama_jenis_po'],2,$tanggal1,$tanggal2),
				'ppcs'=>$this->ReportModel->ge($k['nama_jenis_po'],3,$tanggal1,$tanggal2),
			);
		}

		//pre($data['kaos']);

		// celana
		$celana=$this->GlobalModel->Getdata('master_jenis_po',array('status'=>1,'idjenis'=>3,'tampil'=>1));
		$nocelana=1;
		foreach($celana as $k){
			$data['celana'][]=array(
				'no'=>$nocelana++,
				'nama'=>strtoupper($k['nama_jenis_po']),
				'jmlpo'=>$this->ReportModel->ge($k['nama_jenis_po'],1,$tanggal1,$tanggal2),
				'pdz'=>$this->ReportModel->ge($k['nama_jenis_po'],2,$tanggal1,$tanggal2),
				'ppcs'=>$this->ReportModel->ge($k['nama_jenis_po'],3,$tanggal1,$tanggal2),
			);
		}

		$data['page']=$this->page.'monitoring';
		$this->load->view($this->layout.'main',$data);
	}

	public function kirimsetorcmt() {
		$data=[];
		$data['title']='Monitoring Kirim Setor CMT ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of previous month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime('last day of this month'));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
    	$j=1;
		$pdz=0;
		$ppcs=0;
		$jmlpo=0;
		$arpo=array(
			array('type'=>'Kemeja','id'=>1),
			array('type'=>'Kaos','id'=>2),
			array('type'=>'Celana','id'=>3),
		);
		
		$i=1;
		$qty=0;
		$qtysetor=0;
		$ckirim=0;
		$csetor=0;
		foreach($arpo as $arp){
			$qty=$this->ReportModel->rpdashkirim($arp['id'],$tanggal1,$tanggal2);
			$qtysetor=$this->ReportModel->rpdashsetor($arp['id'],$tanggal1,$tanggal2);
			$ckirim=$this->ReportModel->countdashkirim($arp['id'],$tanggal1,$tanggal2);
			$csetor=$this->ReportModel->countdashsetor($arp['id'],$tanggal1,$tanggal2);
			$data['rekap'][]=array(
				'no'=>$i,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'countkirim'=>$ckirim,
				'qtykirimdz'=>($qty/12),
				'qtykirimpcs'=>($qty),
				'countsetor'=>$csetor,
				'qtysetordz'=>($qtysetor/12),
				'qtysetorpcs'=>($qtysetor),
				'keterangan'=>'PO Beredar : '.($ckirim-$csetor),
			);
			$i++;
		}

		// kemeja
		$kemeja=$this->GlobalModel->Getdata('master_jenis_po',array('tampil'=>1,'status'=>1,'idjenis'=>1));
		$nok=1;
		foreach($kemeja as $k){
			$qty=$this->ReportModel->rpdashkirim_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$qtysetor=$this->ReportModel->rpdashsetor_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$ckirim=$this->ReportModel->countdashkirim_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$csetor=$this->ReportModel->countdashsetor_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$data['rekapkemeja'][]=array(
				'no'=>$nok++,
				'id'=>$arp['id'],
				'type'=>$k['nama_jenis_po'],
				'countkirim'=>$ckirim,
				'qtykirimdz'=>($qty/12),
				'qtykirimpcs'=>($qty),
				'countsetor'=>$csetor,
				'qtysetordz'=>($qtysetor/12),
				'qtysetorpcs'=>($qtysetor),
				'keterangan'=>'PO Beredar : '.($ckirim-$csetor),
			);
		}

		
		
		// kaos 
		$kaos=$this->GlobalModel->Getdata('master_jenis_po',array('tampil'=>1,'status'=>1,'idjenis'=>2));
		$nokaos=1;
		foreach($kaos as $k){
			$qty=$this->ReportModel->rpdashkirim_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$qtysetor=$this->ReportModel->rpdashsetor_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$ckirim=$this->ReportModel->countdashkirim_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$csetor=$this->ReportModel->countdashsetor_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$data['rekapkaos'][]=array(
				'no'=>$nokaos++,
				'id'=>$arp['id'],
				'type'=>$k['nama_jenis_po'],
				'countkirim'=>$ckirim,
				'qtykirimdz'=>($qty/12),
				'qtykirimpcs'=>($qty),
				'countsetor'=>$csetor,
				'qtysetordz'=>($qtysetor/12),
				'qtysetorpcs'=>($qtysetor),
				'keterangan'=>'PO Beredar : '.($ckirim-$csetor),
			);
		}

		// celana
		$celana=$this->GlobalModel->Getdata('master_jenis_po',array('status'=>1,'idjenis'=>3));
		$nocelana=1;
		foreach($celana as $k){
			$qty=$this->ReportModel->rpdashkirim_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$qtysetor=$this->ReportModel->rpdashsetor_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$ckirim=$this->ReportModel->countdashkirim_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$csetor=$this->ReportModel->countdashsetor_monitoring($k['nama_jenis_po'],$tanggal1,$tanggal2);
			$data['rekapcelana'][]=array(
				'no'=>$nocelana++,
				'id'=>$arp['id'],
				'type'=>$k['nama_jenis_po'],
				'countkirim'=>$ckirim,
				'qtykirimdz'=>($qty/12),
				'qtykirimpcs'=>($qty),
				'countsetor'=>$csetor,
				'qtysetordz'=>($qtysetor/12),
				'qtysetorpcs'=>($qtysetor),
				'keterangan'=>'PO Beredar : '.($ckirim-$csetor),
			);
		}

		// adjustment
		$this->load->model('AdjustModel');
		$adjustment=[];
		$filter_adj=array(
			'tampil'=>1,
			'hapus'=>0,
		);
		$adjustment=$this->AdjustModel->adjust_kirimsetorcmt($filter_adj);
		$data['adjustment'] = $adjustment;


		$data['page']=$this->page.'kirimsetorcmt';
		$this->load->view($this->layout.'main',$data);
	}


	public function kirimgudang() {
		$data=[];
		$data['title']='Monitoring Kirim Gudang';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of previous month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime('last day of this month'));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
    	$j=1;
		$pdz=0;
		$ppcs=0;
		$jmlpo=0;
		$arpo=array(
			array('type'=>'Kemeja','id'=>1),
			array('type'=>'Kaos','id'=>2),
			array('type'=>'Celana','id'=>3),
		);
		
		$i=1;
		$qty=0;
		$qtysetor=0;
		$ckirim=0;
		$csetor=0;
		foreach($arpo as $arp){
			$data['rekap'][]=array(
				'no'=>$i,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'po'=>$this->ReportModel->count_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2),
				'dz'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2)/12,
				'pcs'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2),
				'total'=>$this->ReportModel->pcs_monitoring_kirimgudang_harga($arp['id'],$tanggal1,$tanggal2),
			);
			$i++;
		}

		// kemeja
		$kemeja=$this->GlobalModel->Getdata('master_jenis_po',array('tampil'=>1,'status'=>1,'idjenis'=>1));
		$nok=1;
		foreach($kemeja as $k){
			$data['rekapkemeja'][]=array(
				'no'=>$nok++,
				'id'=>$arp['id'],
				'type'=>$k['nama_jenis_po'],
				'po'=>$this->ReportModel->count_monitoring_kirimgudang_detail($k['nama_jenis_po'],$tanggal1,$tanggal2)*$k['perkalian'],
				'dz'=>$this->ReportModel->pcs_monitoring_kirimgudang_detail($k['nama_jenis_po'],$tanggal1,$tanggal2)/12,
				'pcs'=>$this->ReportModel->pcs_monitoring_kirimgudang_detail($k['nama_jenis_po'],$tanggal1,$tanggal2),
				'total'=>0,
			);
		}

		//pre($data['rekapkemeja']);

		
		
		// kaos 
		$kaos=$this->GlobalModel->Getdata('master_jenis_po',array('tampil'=>1,'status'=>1,'idjenis'=>2));
		$nokaos=1;
		foreach($kaos as $k){
			$data['rekapkaos'][]=array(
				'no'=>$nokaos++,
				'id'=>$arp['id'],
				'type'=>$k['nama_jenis_po'],
				'po'=>$this->ReportModel->count_monitoring_kirimgudang_detail($k['nama_jenis_po'],$tanggal1,$tanggal2)*$k['perkalian'],
				'dz'=>$this->ReportModel->pcs_monitoring_kirimgudang_detail($k['nama_jenis_po'],$tanggal1,$tanggal2)/12,
				'pcs'=>$this->ReportModel->pcs_monitoring_kirimgudang_detail($k['nama_jenis_po'],$tanggal1,$tanggal2),
				'total'=>0,
			);
		}

		// celana
		$celana=$this->GlobalModel->Getdata('master_jenis_po',array('tampil'=>1,'status'=>1,'idjenis'=>3));
		$nocelana=1;
		
		foreach($celana as $k){
			$data['rekapcelana'][]=array(
				'no'=>$nocelana++,
				'id'=>$arp['id'],
				'type'=>$k['nama_jenis_po'],
				'po'=>$this->ReportModel->count_monitoring_kirimgudang_detail($k['nama_jenis_po'],$tanggal1,$tanggal2)*$k['perkalian'],
				'dz'=>$this->ReportModel->pcs_monitoring_kirimgudang_detail($k['nama_jenis_po'],$tanggal1,$tanggal2)/12,
				'pcs'=>$this->ReportModel->pcs_monitoring_kirimgudang_detail($k['nama_jenis_po'],$tanggal1,$tanggal2),
				'total'=>0,
			);
		}


		//adjustment
		$this->load->model('AdjustModel');
		$adjustment=[];
		$filter_adj=array(
			'tampil'=>1,
			'hapus'=>0,
		);
		$adjustment=$this->AdjustModel->kirimgudang($filter_adj);
		$data['adjustment'] = $adjustment;
		$data['adjustment_detail']=[];
		$adjustment_detail=$this->AdjustModel->kirimgudang_detail($filter_adj);
		$data['adjustment_detail'] = $adjustment_detail;

		$data['page']=$this->page.'kirimgudang';
		$this->load->view($this->layout.'main',$data);
	}

}