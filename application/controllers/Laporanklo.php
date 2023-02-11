<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanklo extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('KirimsetorModel');
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
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

		$data['tanggal1_bupot']=date('d M',strtotime($tanggal1."-3 days"));
		$data['tanggal2_bupot']=date('d M Y',strtotime($tanggal1."+3 days"));

		$tanggal1_bupot=date('Y-m-d',strtotime($tanggal1."-3 days"));
		$tanggal2_bupot=date('Y-m-d',strtotime($tanggal1."+3 days"));

		$jenis=$this->GlobalModel->QueryManual("SELECT * FROM master_jenis_po WHERE nama_jenis_po IN (SELECT SUBSTR(kode_po,1, 3) AS po FROM konveksi_buku_potongan ) ");
		$tim=$this->GlobalModel->QueryManual("SELECT * FROM timpotong WHERE id IN (SELECT tim_potong_potongan FROM konveksi_buku_potongan  WHERE DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ");
		$prods=[];
		$jml=[];
		$no=1;

		$noh=1;
		$data['bupot']=[];
		$timptg=$this->GlobalModel->getData('timpotong',array('hapus'=>0));
		$detbupot=[];
		foreach($tim as $t){
			$detbupot=$this->ReportModel->laporanbukupotonganklo($t['id'],$tanggal1_bupot,$tanggal2_bupot);
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
		
		//$sqlsablon.=" AND id_cmt IN(SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE hapus=0 AND DATE(create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."') ";
		$notinidcmt=" AND id_cmt NOT IN (63) ";
		$kirim=[];
		$setor=[];
		$sqlsablon="SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk='SABLON' ".$notinidcmt;
		$sqlsablon.=" AND id_cmt IN (SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE DATE(create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ";
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
		
		//pre($stoksablon);
		$data['jahit']=[]; // kaos
		$kjahit='JAHIT';
		$sqljahit="SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk='JAHIT' ";
		$sqljahit.=" AND jenis_po IN(1,3) ".$notinidcmt;
		$sqljahit.=" AND id_cmt IN (SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE DATE(create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ";
		$cmtjahit=$this->GlobalModel->QueryManual($sqljahit);
		$no=1;
		foreach($cmtjahit as $c){
			$kirim=$this->ReportModel->klo_mingguan($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','KIRIM');
			$setor=$this->ReportModel->klo_mingguan($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','SETOR');
			$kirimjeans=$this->ReportModel->klo_mingguanjeans($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','KIRIM');
			$setorjeans=$this->ReportModel->klo_mingguanjeans($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','SETOR');
			$data['jahit'][]=array(
				'no'=>$no++,
				'nama'=>strtolower($c['cmt_name']),
				'kirimkaosjml'=>!empty($kirim)?$kirim['jmlpo']:0,
				'kirimkaosdz'=>!empty($kirim)?$kirim['dz']:0,
				'kirimkaospcs'=>!empty($kirim)?$kirim['pcs']:0,
				'setorkaosjml'=>!empty($setor)?$setor['jmlpo']:0,
				'setorkaosdz'=>!empty($setor)?$setor['dz']:0,
				'setorkaospcs'=>!empty($setor)?$setor['pcs']:0,
				'stokakhirkaosjml'=>0,
				'stokakhirkaosdz'=>0,
				'kirimjeansjml'=>!empty($kirimjeans)?$kirimjeans['jmlpo']:0,
				'kirimjeansdz'=>!empty($kirimjeans)?$kirimjeans['dz']:0,
				'kirimjeanspcs'=>!empty($kirimjeans)?$kirimjeans['pcs']:0,
				'setorjeansjml'=>!empty($setorjeans)?$setorjeans['jmlpo']:0,
				'setorjeansdz'=>!empty($setorjeans)?$setorjeans['dz']:0,
				'setorjeanspcs'=>!empty($setorjeans)?$setorjeans['pcs']:0,
			);
		}
		//pre($data['jahit']);
		
		$data['jahitk']=[]; // kemeja
		$slqkemeja="SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk='JAHIT' ";
		$slqkemeja.=" AND jenis_po IN(2) ".$notinidcmt;
		$slqkemeja.=" AND id_cmt IN (SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE DATE(create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ";
		$cmtkemeja=$this->GlobalModel->QueryManual($slqkemeja);
		$nok=1;
		foreach($cmtkemeja as $c){
			$kirim=$this->ReportModel->klo_mingguan($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','KIRIM');
			$setor=$this->ReportModel->klo_mingguan($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','SETOR');
			$data['jahitk'][]=array(
				'no'=>$nok++,
				'nama'=>strtolower($c['cmt_name']),
				'kirimkemejajml'=>!empty($kirim)?$kirim['jmlpo']:0,
				'kirimkemejadz'=>!empty($kirim)?$kirim['dz']:0,
				'setorkemejajml'=>!empty($setor)?$setor['jmlpo']:0,
				'setorkemejadz'=>!empty($setor)?$setor['dz']:0,
				'stokakhirkemejajml'=>1212,
				'stokakhirkemejadz'=>0,
			);
		}
		
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