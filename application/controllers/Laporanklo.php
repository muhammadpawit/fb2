<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanklo extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('KirimsetorModel');
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
	}

	public function mingguan(){
		$data=[];
		//$data['title']='Laporan Produksi Kaos / Kemeja';
		$get=$this->input->get();
		$data['jenis']=[];
		$results=array();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("sunday last week"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("saturday this week"));
		}

		$jenis=$this->GlobalModel->QueryManual("SELECT * FROM master_jenis_po WHERE nama_jenis_po IN (SELECT SUBSTR(kode_po,1, 3) AS po FROM konveksi_buku_potongan ) ");
		$tim=$this->GlobalModel->QueryManual("SELECT * FROM timpotong WHERE id IN (SELECT tim_potong_potongan FROM konveksi_buku_potongan ) ");
		$prods=[];
		$jml=[];
		$no=1;

		$noh=1;
		$data['bupot']=[];
		$timptg=$this->GlobalModel->getData('timpotong',array('hapus'=>0));
		$detbupot=[];
		foreach($timptg as $t){
			$detbupot=$this->ReportModel->bukupotongan($t['id'],$tanggal1,$tanggal2);
			$data['bupot'][]=array(
				
				'nama'=>$t['nama'],
				'dets'=>$detbupot
			);
		}
		//pre($data['bupot']);

		
		// kirim setor 

		$data['sablon']=[]; // sablon
		$results=[];
		$nos=1;
		$sqlsablon="SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk='SABLON' ";
		//$sqlsablon.=" AND id_cmt IN(SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE hapus=0 AND DATE(create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."') ";
		$kirim=[];
		$setor=[];
		$cmtsablon=$this->GlobalModel->QueryManual($sqlsablon);
		foreach($cmtsablon as $s){
			$kirim=$this->ReportModel->klo_mingguan($s['id_cmt'],$tanggal1,$tanggal2,'SABLON','KIRIM');
			$setor=$this->ReportModel->klo_mingguan($s['id_cmt'],$tanggal1,$tanggal2,'SABLON','SETOR');
			$data['sablon'][]=array(
				'id'=>$s['id_cmt'],
				'no'=>$nos,
				'nama'=>strtolower($s['cmt_name']),
				'kirimjml'=>!empty($kirim)?$kirim['jmlpo']:0,
				'kirimdz'=>!empty($kirim)?$kirim['dz']:0,
				'setorjml'=>!empty($setor)?$setor['jmlpo']:0,
				'setordz'=>!empty($setor)?$setor['dz']:0,
			);
			$nos++;
		}
		/*
		$results_sablon=$this->GlobalModel->QueryManual("SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk='SABLON' ");
		$no=1;
		$stokawalkaosjml=0;
		$stokawalkaosdz=0;
		$stokawalkemejajml=0;
		$stokawalkemejadz=0;
		$setorkaosjml=0;
		$setorkaosdz=0;
		$setorkemejajml=0;
		$setorkemejadz=0;
		$kirimkaosjml=0;
		$kirimkaosdz=0;
		$stokakhirkaosjml=0;
		$stokakhirkaosdz=0;
		$stokakhirkemejajml=0;
		$stokakhirkemejadz=0;
		foreach($results_sablon as $c){
			$setorkaosjml=$this->KirimsetorModel->jumlah(2,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR','SABLON');
			$setorkaosdz=$this->KirimsetorModel->dz(2,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR','SABLON');
			$setorkemejajml=$this->KirimsetorModel->jumlah(1,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR','SABLON');
			$setorkemejadz=$this->KirimsetorModel->dz(1,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR','SABLON');
			$kirimkaosjml=$this->KirimsetorModel->jumlah(2,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM','SABLON');
			$kirimkaosdz=$this->KirimsetorModel->dz(2,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM','SABLON');
			$kirimkemejajml=$this->KirimsetorModel->jumlah(1,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM','SABLON');
			$kirimkemejadz=$this->KirimsetorModel->dz(1,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM','SABLON');
			$stoksablon=$this->ReportModel->getstoksablon($c['id_cmt']);
			$data['sablon'][]=array(
				'no'=>$no++,
				'nama'=>strtolower($c['cmt_name']),
				'stokawalkaosjml'=>$stokawalkaosjml,
				'stokawalkaosdz'=>$stokawalkaosdz,
				'stokawalkemejajml'=>$stokawalkemejajml,
				'stokawalkemejadz'=>$stokawalkemejadz,
				'setorkaosjml'=>$setorkaosjml,
				'setorkaosdz'=>$setorkaosdz,
				'setorkemejajml'=>$setorkemejajml,
				'setorkemejadz'=>$setorkemejadz,
				'kirimkaosjml'=>$kirimkaosjml,
				'kirimkaosdz'=>$kirimkaosdz,
				'kirimkemejajml'=>$kirimkemejajml,
				'kirimkemejadz'=>$kirimkemejadz,
				'stokakhirkaosjml'=>!empty($stoksablon)?$stoksablon['count']:0,
				'stokakhirkaosdz'=>!empty($stoksablon)?($stoksablon['dz']/12):0,
				'stokakhirkemejajml'=>0,
				'stokakhirkemejadz'=>0,
			);
		}
		*/
		//pre($stoksablon);
		$data['jahit']=[]; // kaos
		$kjahit='JAHIT';
		/*
		$results=$this->GlobalModel->QueryManual("SELECT * FROM master_cmt WHERE hapus=0 AND id_cmt IN(SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE kategori_cmt='$kjahit') and jenis_po IN(1,3)  ");
		$no=1;
		$stokawalkaosjml=0;
		$stokawalkaosdz=0;
		$stokawalkemejajml=0;
		$stokawalkemejadz=0;
		$setorkaosjml=0;
		$setorkaosdz=0;
		$setorkemejajml=0;
		$setorkemejadz=0;
		$kirimkaosjml=0;
		$kirimkaosdz=0;
		$stokakhirkaosjml=0;
		$stokakhirkaosdz=0;
		$stokakhirkemejajml=0;
		$stokakhirkemejadz=0;
		$akhirjml=0;
		$akhirpcs=0;
		foreach($results as $c){
			$setorkaosjml=$this->KirimsetorModel->jumlah(2,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$setorkaosdz=$this->KirimsetorModel->dz(2,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$setorkemejajml=$this->KirimsetorModel->jumlah(1,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$setorkemejadz=$this->KirimsetorModel->dz(1,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$kirimkaosjml=$this->KirimsetorModel->jumlah(2,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkaosdz=$this->KirimsetorModel->dz(2,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkemejajml=$this->KirimsetorModel->jumlah(1,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkemejadz=$this->KirimsetorModel->dz(1,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$setorkaosjml=$this->KirimsetorModel->jumlah(2,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$akhirjml=$this->KirimsetorModel->stok_baru_kaos($c['id_cmt'],2,$tanggal1);
			$data['jahit'][]=array(
				'no'=>$no++,
				'nama'=>strtolower($c['cmt_name']),
				'stokawalkaosjml'=>$stokawalkaosjml,
				'stokawalkaosdz'=>$stokawalkaosdz,
				'stokawalkemejajml'=>$stokawalkemejajml,
				'stokawalkemejadz'=>$stokawalkemejadz,
				'setorkaosjml'=>$setorkaosjml,
				'setorkaosdz'=>$setorkaosdz,
				'setorkemejajml'=>$setorkemejajml,
				'setorkemejadz'=>$setorkemejadz,
				'kirimkaosjml'=>$kirimkaosjml,
				'kirimkaosdz'=>$kirimkaosdz,
				'kirimkemejajml'=>$kirimkemejajml,
				'kirimkemejadz'=>$kirimkemejadz,
				'stokakhirkaosjml'=>($akhirjml['jml']),
				'stokakhirkaosdz'=>($akhirjml['dz']),
				'stokakhirkemejajml'=>0,
				'stokakhirkemejadz'=>0,
			);
		}*/
		$data['jahitk']=[]; // kemeja
		/*
		$resultsk=$this->GlobalModel->QueryManual("SELECT * FROM master_cmt WHERE hapus=0 AND id_cmt IN(SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE kategori_cmt='$kjahit') and jenis_po IN(2,3) ");
		$no=1;
		$stokawalkaosjml=0;
		$stokawalkaosdz=0;
		$stokawalkemejajml=0;
		$stokawalkemejadz=0;
		$setorkaosjml=0;
		$setorkaosdz=0;
		$setorkemejajml=0;
		$setorkemejadz=0;
		$kirimkaosjml=0;
		$kirimkaosdz=0;
		$stokakhirkaosjml=0;
		$stokakhirkaosdz=0;
		$stokakhirkemejajml=0;
		$stokakhirkemejadz=0;

		foreach($resultsk as $c){

			$setorkaosjml=$this->KirimsetorModel->jumlah(2,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$setorkaosdz=$this->KirimsetorModel->dz(2,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$setorkemejajml=$this->KirimsetorModel->jumlah(1,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$setorkemejadz=$this->KirimsetorModel->dz(1,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$kirimkaosjml=$this->KirimsetorModel->jumlah(2,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkaosdz=$this->KirimsetorModel->dz(2,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkemejajml=$this->KirimsetorModel->jumlah(1,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkemejadz=$this->KirimsetorModel->dz(1,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$akhirjml=$this->KirimsetorModel->stok_baru($c['id_cmt'],1);
			$data['jahitk'][]=array(
				'no'=>$no++,
				'nama'=>strtolower($c['cmt_name']),
				'stokawalkaosjml'=>$stokawalkaosjml,
				'stokawalkaosdz'=>$stokawalkaosdz,
				'stokawalkemejajml'=>$stokawalkemejajml,
				'stokawalkemejadz'=>$stokawalkemejadz,
				'setorkaosjml'=>$setorkaosjml,
				'setorkaosdz'=>$setorkaosdz,
				'setorkemejajml'=>$setorkemejajml,
				'setorkemejadz'=>$setorkemejadz,
				'kirimkaosjml'=>$kirimkaosjml,
				'kirimkaosdz'=>$kirimkaosdz,
				'kirimkemejajml'=>$kirimkemejajml,
				'kirimkemejadz'=>$kirimkemejadz,
				'stokakhirkaosjml'=>0,
				'stokakhirkaosdz'=>0,
				'stokakhirkemejajml'=>!empty($akhirjml)?$akhirjml:0,
				'stokakhirkemejadz'=>!empty($akhirjml)?$akhirjml:0,
			);
		}
		*/
		// end
		$url='';
		if(!empty($tanggal1)){
			$url.="&tanggal1=".$tanggal1;
		}
		if(!empty($tanggal2)){
			$url.="&tanggal2=".$tanggal2;
		}
		$data['excel']=BASEURL.'Laporanklo/mingguan?&excel=true'.$url;
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;	
		if(isset($get['excel'])){
			$this->load->view($this->page.'laporanklo/mingguan_excel',$data);	
		}else{
			$data['page']=$this->page.'laporanklo/mingguan';
			$this->load->view($this->layout,$data);	
		}
	}

}