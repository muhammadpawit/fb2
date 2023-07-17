<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoringprosespo extends CI_Controller {


	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('GlobalModel');
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Monitoringprosespo/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}


	public function index(){
		$data=[];
		$data['title']='';
		$arpo=array(
			array('type'=>'Kemeja','id'=>1),
			array('type'=>'Kaos','id'=>2),
			array('type'=>'Celana','id'=>3),
		);

		$get = $this->input->get();
		
		// po kemeja difinishing
		$data['kemeja']=[];
		$kemeja=$this->GlobalModel->getdata('master_jenis_po',array('tampil'=>1,'idjenis'=>1,'status'=>1));
		foreach($kemeja as $k){
			$data['kemeja'][]=array(
				'nama'=>$k['nama_jenis_po'],
				'jmlpo'=>$this->ReportModel->monitoring_jmlall($k['nama_jenis_po'])*$k['perkalian'],
				'qc'=>$this->ReportModel->monitoring_jml($k['nama_jenis_po'],1)*$k['perkalian'],
				'kancing'=>$this->ReportModel->monitoring_jml($k['nama_jenis_po'],2)*$k['perkalian'],
				'siapcucian'=>$this->ReportModel->monitoring_jml($k['nama_jenis_po'],3)*$k['perkalian'],
				'prosescucian'=>$this->ReportModel->monitoring_jml($k['nama_jenis_po'],4)*$k['perkalian'],
				'siapbuangbenang'=>$this->ReportModel->monitoring_jml($k['nama_jenis_po'],5)*$k['perkalian'],
				'prosesbuangbenang'=>$this->ReportModel->monitoring_jml($k['nama_jenis_po'],6)*$k['perkalian'],
				'siappacking'=>$this->ReportModel->monitoring_jml($k['nama_jenis_po'],7)*$k['perkalian'],
				'prosespacking'=>$this->ReportModel->monitoring_jml($k['nama_jenis_po'],8)*$k['perkalian'],
				'siapkirimgudang'=>$this->ReportModel->monitoring_jml($k['nama_jenis_po'],9)*$k['perkalian'],
				'pending'=>$this->ReportModel->monitoring_jml($k['nama_jenis_po'],10)*$k['perkalian'],
				'prods'=>$this->ReportModel->monitoring_jml_details($k['nama_jenis_po']),
			);
		}

		// po kemeja difinishing
		$data['kaos']=[];
		$kaos=$this->GlobalModel->getdata('master_jenis_po',array('tampil'=>1,'idjenis'=>2,'status'=>1));
		$jml=0;
		foreach($kaos as $k){
			//for($i=1;$i<12;$i++){
				$jml=(count_mdetails_perpo(null,$k['nama_jenis_po']));
			//}
			$data['kaos'][]=array(
				'nama'=>$k['nama_jenis_po'],
				//'jmlpo'=>$this->ReportModel->monitoring_jmlall($k['nama_jenis_po'])*$k['perkalian'],
				'jmlpo'=>$jml,
				'qc'=>count_mdetails_perpo(1,$k['nama_jenis_po']),
				'kancing'=>count_mdetails_perpo(2,$k['nama_jenis_po']),
				'siapcucian'=>count_mdetails_perpo(3,$k['nama_jenis_po']),
				'prosescucian'=>count_mdetails_perpo(4,$k['nama_jenis_po']),
				'siapbuangbenang'=>count_mdetails_perpo(5,$k['nama_jenis_po']),
				'prosesbuangbenang'=>count_mdetails_perpo(6,$k['nama_jenis_po']),
				'siappacking'=>count_mdetails_perpo(7,$k['nama_jenis_po']),
				'prosespacking'=>count_mdetails_perpo(8,$k['nama_jenis_po']),
				'siapkirimgudang'=>count_mdetails_perpo(9,$k['nama_jenis_po']),
				'pending'=>count_mdetails_perpo(10,$k['nama_jenis_po']),
				'selesai'=>count_mdetails_perpo(11,$k['nama_jenis_po']),
				'retur'=>count_mdetails_perpo(12,$k['nama_jenis_po']),
				'siapkirimcmt'=>count_mdetails_perpo(13,$k['nama_jenis_po']),
				'kirimsample'=>count_mdetails_perpo(14,$k['nama_jenis_po']),
			);
		}
		//pre($data['kaos']);

		$data['po']=$this->GlobalModel->Getdata('produksi_po',array('hapus'=>0));
		$data['qc']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND  proses=1 WHERE p.hapus=0 AND pp.kode_po NOT in (SELECT kode_po FROM proses_po WHERE proses=9 ) ');
		$data['kancing']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=2 WHERE p.hapus=0');
		$data['siapcucian']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=3 WHERE p.hapus=0');
		$data['prosescucian']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses IN(4,13) WHERE p.hapus=0');
		$data['siapbuangbenang']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=5 WHERE p.hapus=0');
		$data['prosesbuangbenang']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=6 WHERE p.hapus=0');
		$data['siappacking']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=7 WHERE p.hapus=0');
		$data['prosespacking']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=8 WHERE p.hapus=0');
		$data['siapkirimgudang']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses IN(1,9) WHERE p.hapus=0');
		$data['pending']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses IN(9,10) WHERE p.hapus=0');
		$data['retur']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=12 WHERE p.hapus=0');
		$data['selesai']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=11 WHERE p.hapus=0');

		$data['action']=$this->url.'proses_save';
		$data['log']=$this->GlobalModel->QueryManualRow("SELECT * FROM finishing_proses_updated ORDER BY id DESC LIMIT 1 ");
		if(isset($get['excel'])){
			$this->load->view($this->page.'finishing/monitoringprosespo_excel',$data);
		}else{
			$data['page']=$this->page.'finishing/monitoringprosespo';
			$this->load->view($this->layout,$data);
		}
		//pre(callSessUser('nama_user'));
		
	}

	public function proses_save(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['prods'])){
			foreach($data['prods'] as $p){
				$explode=explode('-',$p['kode_po']);
				$cek=$this->GlobalModel->GetDataRow('proses_po',array('kode_po'=>$explode[1],'hapus'=>0));
				if(empty($cek)){
					$insert=array(
						'namapo'=>$explode[0],
						'kode_po'=>$explode[1],
						'proses'=>$data['proses'],
					);
					$this->db->insert('proses_po',$insert);
				}else{
					$insert=array(
						'namapo'=>$explode[0],
						'kode_po'=>$explode[1],
						'proses'=>$data['proses'],
					);
					$this->db->update('proses_po',$insert,array('kode_po'=>$explode[1]));
				}
			}
			$log = array(
				'tanggal'=>date('Y-m-d H:i:s'),
				'oleh'	 =>callSessUser('nama_user'),
			);
			$this->db->insert('finishing_proses_updated',$log);
			//pre($cek);
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
		}else{
			$this->session->set_flashdata('gagal','Data gagal disimpan');
			redirect($this->url);
		}
	}
}