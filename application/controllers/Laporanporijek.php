<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanporijek extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/laporanporijek/';
		$this->url=BASEURL.'Laporanporijek/';
	}

	public function index(){
		$data['title']='Laporan PO Rijek';
		$sql ="SELECT p.kode_po,SUM(krs.barang_cacad_qty) as rijek,SUM(krs.bangke_qty) as bangke FROM kelolapo_rincian_setor_cmt krs JOIN produksi_po p ON (p.id_produksi_po=krs.idpo) where p.hapus=0 AND barang_cacad_qty > 0 OR bangke_qty > 0 GROUP BY idpo ORDER BY kode_po ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		$data['prods']=[];
		$no=1;
		foreach($results as $r){
			$data['prods'][]=array(
				'no'=>$no++,
				'kode_po'=>$r['kode_po'],
				'bangke'=>$r['bangke'],
				'rijek'=>$r['rijek'],
			);
		}
		$data['page']=$this->page.'rijek';
		$this->load->view($this->layout,$data);
	}
}
