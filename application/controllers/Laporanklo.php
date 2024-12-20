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

		if(isset($get['tanggal1_pot'])){
			$tanggal1_pot=$get['tanggal1_pot'];
		}else{
			$tanggal1_pot=date('Y-m-d',strtotime("sunday last week"));
		}
		if(isset($get['tanggal2_pot'])){
			$tanggal2_pot=$get['tanggal2_pot'];
		}else{
			$tanggal2_pot=date('Y-m-d',strtotime("saturday this week"));
		}

		$data['tanggal1_bupot']=$tanggal1_pot;
		$data['tanggal2_bupot']=$tanggal2_pot;

		$tanggal1_bupot=$tanggal1_pot;
		$tanggal2_bupot=$tanggal2_pot;

		$jenis=$this->GlobalModel->QueryManual("SELECT * FROM master_jenis_po WHERE nama_jenis_po IN (SELECT SUBSTR(kode_po,1, 3) AS po FROM konveksi_buku_potongan ) ");
		$tim=$this->GlobalModel->QueryManual("SELECT * FROM timpotong WHERE id IN (SELECT tim_potong_potongan FROM konveksi_buku_potongan  WHERE DATE(created_date) BETWEEN '".$tanggal1_pot."' AND '".$tanggal2_pot."' ) ");
		$prods=[];
		$jml=[];
		$no=1;

		$noh=1;
		$data['bupot']=[];
		$timptg=$this->GlobalModel->getData('timpotong',array('hapus'=>0));
		$detbupot=[];
		foreach($tim as $t){
			$detbupot=$this->ReportModel->laporanbukupotonganklo($t['id'],$tanggal1_pot,$tanggal2_pot);
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
		$stoksebelumnya=0;
		$stoksebelumnya_pcs=0;
		foreach($cmtsablon as $s){
			$stoksebelumnya=$this->ReportModel->klo_mingguan_seblelumnya($s['id_cmt'],$tanggal1,'SABLON','KIRIM');
			$stoksebelumnya_pcs=$this->ReportModel->klo_mingguan_seblelumnya_pcs($s['id_cmt'],$tanggal1,'SABLON','KIRIM');
			$kirim=$this->ReportModel->klo_mingguan($s['id_cmt'],$tanggal1,$tanggal2,'SABLON','KIRIM');
			$setor=$this->ReportModel->klo_mingguan($s['id_cmt'],$tanggal1,$tanggal2,'SABLON','SETOR');
			$stok =$this->ReportModel->stok_sablon($s['id_cmt']);
			$data['sablon'][]=array(
				'id'=>$s['id_cmt'],
				'no'=>$nos,
				'stokawal'=>json_encode($stoksebelumnya),
				'stokawal_dz' => ($stoksebelumnya_pcs/12),
				'nama'=>strtolower($s['cmt_name']),
				'kirimjml'=>!empty($kirim)?$kirim['jmlpo']:0,
				'kirimdz'=>!empty($kirim)?$kirim['dz']:0,
				'setorjml'=>!empty($setor)?$setor['jmlpo']:0,
				'setordz'=>!empty($setor)?$setor['dz']:0,
				'stokjml'=>$stok['jml'],
				'stokdz'=>$stoksebelumnya_pcs/12,
			);
			$nos++;
		}
		//pre($data['sablon']);
		//pre($stoksablon);
		$data['jahit']=[]; // kaos
		$kjahit='JAHIT';
		$sqljahit="SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk='JAHIT' ";
		$sqljahit.=" AND jenis_po IN(1,3) ".$notinidcmt;
		$sqljahit.=" AND id_cmt IN (SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE DATE(create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ";
		$cmtjahit=$this->GlobalModel->QueryManual($sqljahit);
		$no=1;
		$stoksebelumnya_jeans=0;
		$stoksebelumnya_pcs_jeans=0;
		$stoksebelumnya=0;
		$stoksebelumnya_pcs=0;
		$stokawaljml=0;
		$stokawal_dz=0;
		$stokawal_pcs=0;
		foreach($cmtjahit as $c){
			$stoksebelumnya=$this->ReportModel->klo_mingguan_seblelumnya($c['id_cmt'],$tanggal1,'JAHIT','KIRIM');
			$stoksebelumnya_pcs=$this->ReportModel->klo_mingguan_seblelumnya_pcs($c['id_cmt'],$tanggal1,'JAHIT','KIRIM');
			$stoksebelumnya_jeans=$this->ReportModel->klo_mingguan_seblelumnya_jeans($c['id_cmt'],$tanggal1,'JAHIT','KIRIM');
			$stoksebelumnya_pcs_jeans=$this->ReportModel->klo_mingguan_seblelumnya_pcs_jeans($c['id_cmt'],$tanggal1,'JAHIT','KIRIM');
			$kirim=$this->ReportModel->klo_mingguan($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','KIRIM');
			$setor=$this->ReportModel->klo_mingguan($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','SETOR');
			$kirimjeans=$this->ReportModel->klo_mingguanjeans($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','KIRIM');
			$setorjeans=$this->ReportModel->klo_mingguanjeans($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','SETOR');
			$stok=$this->ReportModel->stok_akhir_cmt($c['id_cmt']);
			
			$stokawaljml		= $stoksebelumnya+$stoksebelumnya_jeans;
			$stokawal_dz		= ($stoksebelumnya_pcs/12) + ($stoksebelumnya_pcs_jeans/12);
			$stokawal_pcs 		= ($stoksebelumnya_pcs) + ($stoksebelumnya_pcs_jeans);
			
			$data['jahit'][]=array(
				'no'=>$no++,
				'nama'=>strtolower($c['cmt_name']),
				'stokawalkaosjml' =>$stokawaljml,
				'stokawalkaosdz' =>$stokawal_dz,
				'stokawalkaospcs' =>$stokawal_pcs,
				'kirimkaosjml'=>!empty($kirim)?$kirim['jmlpo']:0,
				'kirimkaosdz'=>!empty($kirim)?$kirim['dz']:0,
				'kirimkaospcs'=>!empty($kirim)?$kirim['pcs']:0,
				'setorkaosjml'=>!empty($setor)?$setor['jmlpo']:0,
				'setorkaosdz'=>!empty($setor)?$setor['dz']:0,
				'setorkaospcs'=>!empty($setor)?$setor['pcs']:0,
				'stokakhirkaosjml'=>( $stokawaljml - ($setor['jmlpo']+$setorjeans['jmlpo']) ),
				'stokakhirkaosdz'=>( $stokawal_dz - ($setor['dz']+$setorjeans['dz']) ),
				'stokakhirkaospcs'=>( $stokawal_pcs - ($setor['pcs']+$setorjeans['pcs'])  ),
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
		//$slqkemeja.=" AND id_cmt IN (SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE DATE(create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ";
		$cmtkemeja=$this->GlobalModel->QueryManual($slqkemeja);
		$nok=1;
		foreach($cmtkemeja as $c){
			$kirim=$this->ReportModel->klo_mingguan($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','KIRIM');
			$setor=$this->ReportModel->klo_mingguan($c['id_cmt'],$tanggal1,$tanggal2,'JAHIT','SETOR');
			$stok=$this->ReportModel->stok_akhir_cmt($c['id_cmt']);
			$data['jahitk'][]=array(
				'no'=>$nok++,
				'nama'=>strtolower($c['cmt_name']),
				'kirimkemejajml'=>!empty($kirim)?$kirim['jmlpo']:0,
				'kirimkemejadz'=>!empty($kirim)?$kirim['dz']:0,
				'setorkemejajml'=>!empty($setor)?$setor['jmlpo']:0,
				'setorkemejadz'=>!empty($setor)?$setor['dz']:0,
				'stokakhirkemejajml'=>$stok['jmlpo'],
				'stokakhirkemejadz'=>($stok['pcs']/12),
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