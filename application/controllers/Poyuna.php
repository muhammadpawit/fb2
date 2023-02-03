<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poyuna extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/poyuna/';
		$this->url=BASEURL.'Poyuna/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
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
		$sql.=" ORDER BY p.kode_po ASC ";
		$results	= $this->GlobalModel->queryManual($sql);
		$cp=null;
		$data['prods']=[];
		foreach($results as $result){
			$action=[];
			$pot=$this->GlobalModel->getDataRow('konveksi_buku_potongan',array('kode_po'=>$result['kode_po']));
			$harga=$this->GlobalModel->getDataRow('daftarharga_cmt',array('hapus'=>0,'namapo'=>substr($result['kode_po'],0,3)));
			$setoran=$this->GlobalModel->getDataRow('kelolapo_kirim_setor',array('kode_po'=>$result['kode_po'],'progress'=>'SETOR','kategori_cmt'=>'JAHIT'));
			$data['prods'][]=array(
				'no'=>$j,
				'kode_po'=>$result['kode_po'],
				'pot_pcs'=>$pot['hasil_pieces_potongan'],
				'pot_dz'=>$pot['hasil_lusinan_potongan'],
				'harga'=>$harga['hargabaru'],
				'jumlah'=>round($pot['hasil_lusinan_potongan']*$harga['hargabaru']),
				'setoran_pcs'=>$setoran['qty_tot_pcs'],
				'setoran_dz'=>round($setoran['qty_tot_pcs']/12),
				'kekuarangan'=>round($pot['hasil_pieces_potongan']-$setoran['qty_tot_pcs']),
				'action'=>$action,
			);

			$j++;
		}

		$data['page']=$this->page.'potongansetoran';

		$this->load->view($this->layout,$data);
	}
}