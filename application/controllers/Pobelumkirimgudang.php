<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pobelumkirimgudang extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/pobelumkirim/';
		$this->url=BASEURL.'Pobelumkirimgudang/';
		$this->load->model('AdjustModel');
	}

	public function index(){
		$data['title']='PO Belum Kirim Ke Gudang Tanah Abang';
		$get=$this->input->get();
		if(isset($get['kode_po'])){
			$kodepo=$get['kode_po'];
		}else{
			$kodepo=null;
		}

		$data['kode_po']=$kodepo;
		
		$sql="SELECT * FROM produksi_po WHERE hapus=0 AND kategori_po='DALAM' AND kode_po IN(select kode_po FROM kelolapo_kirim_setor WHERE progress='SETOR' AND kategori_cmt='JAHIT') AND kode_PO NOT IN (select kode_po FROM finishing_kirim_gudang ) AND kode_po IN(SELECT kode_po FROM konveksi_buku_potongan) AND nama_po NOT LIKE 'BJ%' ";
		$sql.=" ORDER BY id_produksi_po ASC ";
		$results=[];
		$data['prods']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$potongan=$this->GlobalModel->getDataRow('konveksi_buku_potongan',array('idpo'=>$r['id_produksi_po']));
			$data['prods'][]=array(
				'no'=>$no++,
				'tanggal'=>date('d-m-Y',strtotime($r['created_date'])),
				'kode_po'=>$r['kode_po'],
				'dz'=>!empty($potongan)?$potongan['hasil_lusinan_potongan']:0,
				'pcs'=>!empty($potongan)?$potongan['hasil_pieces_potongan']:0,
			);
		}
		$data['simpan']=$this->url.'simpan';
		$data['page']=$this->page.'cmt';
		$this->load->view($this->layout,$data);
	}

	public function simpan(){
		$data=$this->input->post();
		$po = explode('-',$data['kode_po']);
		$insert=array(
			'tahun'=>$data['tahun'],
			'idpo'=>$po[0],
			'kode_po'=>$po[1].' '.$data['tahun'],
			'keterangan'=>$data['keterangan'],
			'tglinput'=>date('Y-m-d H:i:s'),
			'hapus'=>0
		);
		$this->db->insert('pogagalproduksi',$insert);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->url);
	}

}