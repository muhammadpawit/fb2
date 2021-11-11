<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poyuna extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/poyuna/';
		$this->url=BASEURL.'Poyuna/';
	}

	public function potongansetoran(){
		$data=[];
		$data['title']='Laporan Potongan PO dan Setor Pak Yuna';
		$get=$this->input->get();
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
		if(isset($get['kode_po'])){
			$kode_po=$get['kode_po'];
		}else{
			$kode_po=null;
		}
		if(isset($get['refpo'])){
			$refpo=$get['refpo'];
		}else{
			$refpo=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$j=1;
		$sql="SELECT kbp.*,kbp.kode_po as nama_po,kbp.created_date as tanggalProd, kbp.tim_potong_potongan FROM konveksi_buku_potongan kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) WHERE id_potongan > 0 AND p.nama_po LIKE 'PFK%' ";
		if(empty($kode_po)){
			if(!empty($tanggal1)){
				$sql.=" AND date(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
		}else{
			$sql.=" AND kbp.kode_po='".$kode_po."' ";
		}
		if(!empty($refpo)){
			$sql.=" AND refpo='".$refpo."' ";
		}
		$sql.=" ORDER BY kbp.created_date DESC ";
		$results	= $this->GlobalModel->queryManual($sql);
		$cp=null;
		$data['prods']=[];
		foreach($results as $result){
			$action=[];
			$data['prods'][]=array(
				'no'=>$j,
				'kode_po'=>$result['kode_po'],
				'action'=>$action,
			);

			$j++;
		}

		$data['page']=$this->page.'potongansetoran';

		$this->load->view($this->layout,$data);
	}
}