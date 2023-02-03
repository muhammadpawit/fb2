<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Laporanrinciansetoran extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/laporanrinciansetoran/';
		$this->url=BASEURL.'Laporanrinciansetoran/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Laporan Rincian Setor CMT';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cm']=$cmt;
		$sql="SELECT * FROM kelolapo_rincian_setor_cmt WHERE id_kelolapo_rincian_setor_cmt > 0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		if(!empty($cmt)){
			$sql.=" AND lower(nama_cmt)='".strtolower($cmt)."' ";
		}
		$sql.=" ORDER BY id_kelolapo_rincian_setor_cmt DESC ";
		$res=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$data['prods']=[];
		$cabang=null;
		$lokasi=null;
		foreach($res as $r){
			$cabang=$this->GlobalModel->QueryManualRow("SELECT * FROM master_cmt WHERE lower(cmt_name)='".strtolower($r['nama_cmt'])."' AND hapus=0 ");
			if(!empty($cabang)){
				$lokasi=$this->GlobalModel->GetDataRow('lokasi_cmt',array('id'=>$cabang['lokasi']));
			}
			$potong=$this->GlobalModel->GetDataRow('konveksi_buku_potongan',array('kode_po'=>$r['kode_po']));
			$pcs_kirim=$this->GlobalModel->QueryManualRow("SELECT SUM(jumlah_pcs) as total FROM kirimcmt_detail WHERE kode_po='".$r['kode_po']."' ");
			$data['prods'][]=array(
				'no'=>$no,
				'tanggal'=>date('d/m/Y',strtotime($r['created_date'])),
				'kode_po'=>$r['kode_po'],
				'potong'=>$potong['hasil_lusinan_potongan'],
				'tgl_kirim'=>null,
				'pcs_kirim'=>$pcs_kirim['total'],
				'pcs_setor'=>$r['jml_setor_qty'],
				'pcs_bagus'=>($r['jumlah_piece_diterima']-$r['bangke_qty']),
				'size'=>$this->GlobalModel->GetData('kelolapo_rincian_setor_cmt_finish',array('kode_po'=>$r['kode_po'])),
				'bangke'=>$r['bangke_qty'],
				'bs'=>$r['barang_cacad_qty'],
				'cabang'=>!empty($lokasi)?$lokasi['lokasi']:'',
				'cmt'=>$r['nama_cmt'],
				'keterangan'=>null,
			);
			$no++;
		}
		$data['cmt']=$this->GlobalModel->GetData('master_cmt',array('cmt_job_desk'=>'JAHIT','hapus'=>0));
		if(isset($get['excel'])){
			$this->load->view($this->page.'list_excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);	
		}	}

}

?>