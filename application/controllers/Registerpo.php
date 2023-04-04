<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registerpo extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->link=BASEURL.'Registerpo';
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/registerpo/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index()
	{
		$data=[];
		$data['title']='Register PO Per Tanggal '.date('d-m-Y');
		$data['no']=1;
		$get=$this->input->get();
		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
		}else{
			$jenis=null;
		}

		if(isset($get['excel'])){
			$excel=$get['excel'];
		}else{
			$excel=null;
		}

		$data['products']=array();

		$sql="SELECT * FROM produksi_po WHERE hapus=0 ";
		
		if(!empty($jenis)){
			$sql.=" AND LOWER(nama_po) LIKE '%".$jenis."%' ";
		}

		//$sql.=" LIMIT 20";
		$data['jenis']=$jenis;
		$results=$this->GlobalModel->querymanual($sql);
		$tanggalkirim=null;
		$tanggalsetor=null;
		$tanggalkirimgudang=null;
		$cmt=null;
		$i=1;
		$ket=null;
		$h=0;
		$size=null;
		foreach($results as $result){
			$cmt=$this->GlobalModel->querymanualrow("SELECT * FROM kelolapo_kirim_setor JOIN master_cmt ON(master_cmt.id_cmt=kelolapo_kirim_setor.id_master_cmt) WHERE hapus=0 AND kode_po='".$result['kode_po']."' AND progress='KIRIM' AND kategori_cmt='JAHIT'  ");
			$tanggalsetor=$this->GlobalModel->querymanualrow("SELECT * FROM kelolapo_kirim_setor JOIN master_cmt ON(master_cmt.id_cmt=kelolapo_kirim_setor.id_master_cmt) WHERE kode_po='".$result['kode_po']."' AND progress='SETOR' AND kategori_cmt='JAHIT' ");
			$tanggalkirimgudang=$this->GlobalModel->querymanualrow("SELECT * FROM finishing_kirim_gudang WHERE kode_po='".$result['kode_po']."' ");

			if(!empty($cmt['create_date'])){
				$h=1;
			}else{
				$h=0;
			}

			if(!empty($tanggalsetor['create_date'])){
				$h=$h+1;
			}

			if(!empty($tanggalkirimgudang['tanggal_kirim'])){
				$h=$h+1;
			}
			$size=$this->GlobalModel->getDataRow('konveksi_buku_potongan',array('kode_po'=>$result['kode_po']));
			$data['products'][]=array(
				'kode_po'=>$result['kode_po'],
				'size'=>!empty($size)?$size['size_potongan']:'',
				'cmt'=>!empty($cmt)?strtolower($cmt['cmt_name']):'',
				'tglkirim'=>!empty($cmt['create_date'])?date('d-m-Y',strtotime($cmt['create_date'])):'',
				'tglsetor'=>!empty($tanggalsetor['create_date'])?date('d-m-Y',strtotime($tanggalsetor['create_date'])):'',
				'tglkirimgudang'=>!empty($tanggalkirimgudang['tanggal_kirim'])?date('d-m-Y',strtotime($tanggalkirimgudang['tanggal_kirim'])):'',
				'keterangan'=>$h==3?'OK':'',
				'no'=>$i++,
				'lokasi'=>!empty($cmt)?strtolower($cmt['alamat']):'',
			);
		}
		$data['jenispo']=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		if(!empty($excel)){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);	
		}
		
	}
}	