<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanporijek extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/laporanporijek/';
		$this->url=BASEURL.'Laporanporijek/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data['title']='Laporan PO Rijek';
		$get = $this->input->get();
		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
		}else{
			$jenis=null;
		}
		$data['jenis']=$jenis;
		if(!empty($jenis)){
			
			$join=' LEFT JOIN master_jenis_po mjp ON mjp.nama_jenis_po=p.nama_po ';
			$where=' AND mjp.idjenis= '.$jenis;
		}else{
			$join='';
			$where=' ';
		}
		$sql ="SELECT p.kode_po,SUM(krs.barang_cacad_qty) as rijek,SUM(krs.bangke_qty) as bangke FROM kelolapo_rincian_setor_cmt krs JOIN produksi_po p ON (p.id_produksi_po=krs.idpo) $join where p.hapus=0 $where ";
		
		//$sql.=" AND barang_cacad_qty > 0 OR bangke_qty > 0  ";
		$sql.=" AND bangke_qty > 0  ";
		$sql.=" GROUP BY idpo ORDER BY kode_po ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($results);
		$data['prods']=[];
		$no=1;
		$rjk=0;
		$kembali=0;
		$bangke=0;
		foreach($results as $r){
			$rjk=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(pcs),0) as total FROM rijek where kode_po='".$r['kode_po']."' ");
			$bangke=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(rincian_bangke),0) as total FROM kelolapo_rincian_setor_cmt_finish where kode_po='".$r['kode_po']."' ");
			$kembali=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(qty),0) as total FROM pengembalian_bangke where kode_po='".$r['kode_po']."' ");
			$sisa = $bangke['total']-$kembali['total'];
			
			if($sisa<>0){
				$data['prods'][]=array(
					'no'=>$no++,
					'kode_po'=>$r['kode_po'],
					'bangke'=>$sisa,
					'rijek'=>$rjk['total'],
				);
			}
		}
		if(isset($get['excel'])){
			$this->load->view($this->page.'rijek_excel',$data);
		}else{
			$data['page']=$this->page.'rijek';
			$this->load->view($this->layout,$data);
		}
	}
}
