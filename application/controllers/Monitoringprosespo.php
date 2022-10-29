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
	}


	public function index(){
		$data=[];
		$data['title']='';
		$arpo=array(
			array('type'=>'Kemeja','id'=>1),
			array('type'=>'Kaos','id'=>2),
			array('type'=>'Celana','id'=>3),
		);
		
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
		foreach($kaos as $k){
			$data['kaos'][]=array(
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
			);
		}

		$data['po']=$this->GlobalModel->Getdata('produksi_po',array('hapus'=>0));
		$data['qc']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=1');
		$data['kancing']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=2');
		$data['siapcucian']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=3');
		$data['prosescucian']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=4');
		$data['siapbuangbenang']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=5');
		$data['prosesbuangbenang']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=6');
		$data['siappacking']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=7');
		$data['prosespacking']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=8');
		$data['siapkirimgudang']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=9');
		$data['pending']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=10');
		$data['retur']=$this->GlobalModel->QueryManual('SELECT p.nama_po,p.kode_po FROM produksi_po p JOIN proses_po pp ON(pp.kode_po=p.kode_po) AND proses=12');

		$data['action']=$this->url.'proses_save';
		$data['page']=$this->page.'finishing/monitoringprosespo';
		$this->load->view($this->layout,$data);
	}

	public function proses_save(){
		$data=$this->input->post();
		
		if(isset($data['prods'])){
			foreach($data['prods'] as $p){
				$explode=explode('-',$p['kode_po']);
				$cek=$this->GlobalModel->GetDataRow('proses_po',array('kode_po'=>$explode[1],'proses'=>($data['proses']-1)));
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
			//pre($cek);
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
		}else{
			$this->session->set_flashdata('gagal','Data gagal disimpan');
			redirect($this->url);
		}
	}
}