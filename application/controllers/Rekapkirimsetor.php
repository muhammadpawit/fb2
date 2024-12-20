<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapkirimsetor extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('KirimsetorModel');
		$this->page='newtheme/page/report/';
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Laporan Rekap Kirim Setor';
		$get=$this->input->get();
		$data['products']=[];
		$results=array();
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
		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}

		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=null;
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=null;
		}

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}

		$filter=array(
			'bulan'=>$bulan,
			'tahun'=>$tahun,
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
		);
		$data['bulan']=$bulan;
		$data['tahun'] =$tahun;
		$data['cmt'] =$cmt;
		$data['tanggal1'] =$tanggal1;
		$data['tanggal2'] =$tanggal2;
		$url='';
		if(!empty($bulan)){
			$url.="&bulan=".$bulan;
		}
		if(!empty($tahun)){
			$url.="&tahun=".$tahun;
		}
		if(!empty($cmt)){
			$url.="&cmt=".$cmt;
		}
		if(!empty($tanggal1)){
			$url.="&tanggal1=".$tanggal1;
			$url.="&tanggal2=".$tanggal2;
		}
		$data['excel']=BASEURL.'Rekapkirimsetor?&excel=true'.$url;
		$cmtd=null;
		$monthNum  = $bulan;
		$dateObj   = DateTime::createFromFormat('!m', $monthNum);
		$monthName = $dateObj->format('F'); // March
		$data['bln']=$monthName;
		$data['cmtnya']=null;
		if(!empty($cmt)){
			$cmtd=$this->GlobalModel->GetdataRow('master_cmt',array('id_cmt'=>$cmt));
			$data['cmtnya']=$cmtd['cmt_name'];
		}
		$no=1;
		$jml=0;
		$master_cmt=$this->GlobalModel->QueryManual("SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk != 'BORDIR' AND id_cmt IN(SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE hapus=0) ");
		if($cmt=='all'){
			foreach($master_cmt as $c){
				$cmt=$c['id_cmt'];
				foreach(nama_po() as $p){
					if(!empty($tanggal1)){
						$jml=$this->KirimsetorModel->rekapjumlah_tglklo($p['id_jenis_po'],$cmt,'KIRIM',$tanggal1,$tanggal2);
						$data['products'][]=array(
							'no'=>$no++,
							'nama'=>$p['nama_jenis_po'],
							'jmlkirim'=>$jml,
							'kirimdz'=>($this->KirimsetorModel->rekappcs_tgl($p['id_jenis_po'],$cmt,'KIRIM',$tanggal1,$tanggal2))/12,
							'kirimpcs'=>($this->KirimsetorModel->rekappcs_tgl($p['id_jenis_po'],$cmt,'KIRIM',$tanggal1,$tanggal2)),
							'jmlsetor'=>$this->KirimsetorModel->rekapjumlah_tglklo($p['id_jenis_po'],$cmt,'SETOR',$tanggal1,$tanggal2),
							'setordz'=>($this->KirimsetorModel->rekappcs_tgl($p['id_jenis_po'],$cmt,'SETOR',$tanggal1,$tanggal2))/12,
							'setorpcs'=>($this->KirimsetorModel->rekappcs_tgl($p['id_jenis_po'],$cmt,'SETOR',$tanggal1,$tanggal2)),
						);
					}else{
						$jml=$this->KirimsetorModel->rekapjumlah($p['id_jenis_po'],$cmt,'KIRIM',$bulan,$tahun);
						$data['products'][]=array(
							'no'=>$no++,
							'nama'=>$p['nama_jenis_po'],
							'jmlkirim'=>$jml,
							'kirimdz'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$cmt,'KIRIM',$bulan,$tahun))/12,
							'kirimpcs'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$cmt,'KIRIM',$bulan,$tahun)),
							'jmlsetor'=>$this->KirimsetorModel->rekapjumlah($p['id_jenis_po'],$cmt,'SETOR',$bulan,$tahun),
							'setordz'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$cmt,'SETOR',$bulan,$tahun))/12,
							'setorpcs'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$cmt,'SETOR',$bulan,$tahun)),
						);
					}
					
				}
			}
		}else{
			foreach(nama_po() as $p){
				if(!empty($tanggal1)){
					$jml=$this->KirimsetorModel->rekapjumlah_tglklo($p['id_jenis_po'],$cmt,'KIRIM',$tanggal1,$tanggal2);
					$data['products'][]=array(
						'no'=>$no++,
						'nama'=>$p['nama_jenis_po'],
						'jmlkirim'=>$jml,
						'kirimdz'=>($this->KirimsetorModel->rekappcs_tglklo($p['id_jenis_po'],$cmt,'KIRIM',$tanggal1,$tanggal2))/12,
						'kirimpcs'=>($this->KirimsetorModel->rekappcs_tglklo($p['id_jenis_po'],$cmt,'KIRIM',$tanggal1,$tanggal2)),
						'jmlsetor'=>$this->KirimsetorModel->rekapjumlah_tglklo($p['id_jenis_po'],$cmt,'SETOR',$tanggal1,$tanggal2),
						'setordz'=>($this->KirimsetorModel->rekappcs_tglklo($p['id_jenis_po'],$cmt,'SETOR',$tanggal1,$tanggal2))/12,
						'setorpcs'=>($this->KirimsetorModel->rekappcs_tglklo($p['id_jenis_po'],$cmt,'SETOR',$tanggal1,$tanggal2)),
					);
				}else{
					$jml=$this->KirimsetorModel->rekapjumlah_tglklo($p['id_jenis_po'],$cmt,'KIRIM',$bulan,$tahun);
					$data['products'][]=array(
						'no'=>$no++,
						'nama'=>$p['nama_jenis_po'],
						'jmlkirim'=>$jml,
						'kirimdz'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$cmt,'KIRIM',$bulan,$tahun))/12,
						'kirimpcs'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$cmt,'KIRIM',$bulan,$tahun)),
						'jmlsetor'=>$this->KirimsetorModel->rekapjumlah($p['id_jenis_po'],$cmt,'SETOR',$bulan,$tahun),
						'setordz'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$cmt,'SETOR',$bulan,$tahun))/12,
						'setorpcs'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$cmt,'SETOR',$bulan,$tahun)),
					);
				}
				
			}
		}
		

		$data['jahitk']=[]; // kemeja
		$kjahit='JAHIT';		
		// $resultsk=$this->GlobalModel->QueryManual("SELECT * FROM master_cmt WHERE hapus=0 AND id_cmt IN(SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE kategori_cmt='$kjahit') and jenis_po IN(2,3) ");
		$resultsk=[];
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
			$kirimkaosjml=$this->KirimsetorModel->rjumlah(2,$bulan,$tahun,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkaosdz=$this->KirimsetorModel->rdz(2,$bulan,$tahun,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkemejajml=$this->KirimsetorModel->rjumlah(1,$bulan,$tahun,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkemejadz=$this->KirimsetorModel->rdz(1,$bulan,$tahun,$c['id_cmt'],'KIRIM',$kjahit);
			$setorkaosjml=$this->KirimsetorModel->rjumlah(2,$bulan,$tahun,$c['id_cmt'],'SETOR',$kjahit);
			$setorkaosdz=$this->KirimsetorModel->rdz(2,$bulan,$tahun,$c['id_cmt'],'SETOR',$kjahit);
			$setorkemejajml=$this->KirimsetorModel->rjumlah(1,$bulan,$tahun,$c['id_cmt'],'SETOR',$kjahit);
			$setorkemejadz=$this->KirimsetorModel->rdz(1,$bulan,$tahun,$c['id_cmt'],'SETOR',$kjahit);
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
				'stokakhirkaosjml'=>($stokawalkaosjml-$setorkaosjml+$kirimkaosjml),
				'stokakhirkaosdz'=>($stokawalkaosdz-$setorkaosdz+$kirimkaosdz),
				'stokakhirkemejajml'=>($stokawalkemejajml-$setorkemejajml+$kirimkemejajml),
				'stokakhirkemejadz'=>($stokawalkemejadz-$setorkemejadz+$kirimkemejadz),
			);
		}

		$data['log']   = $this->GlobalModel->QueryManualRow("SELECT * FROM kelolapo_rincian_setor_cmt ORDER BY id_kelolapo_rincian_setor_cmt DESC limit 1");

		if(isset($get['excel'])){
			$this->load->view($this->page.'rekapkirimsetor_excel',$data);	
		}else{
			$data['page']=$this->page.'rekapkirimsetor';
			$this->load->view($this->layout,$data);	
		}
	}

}