<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pogagalproduksi extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/pogagalproduksi/';
		$this->url=BASEURL.'Pogagalproduksi/';
		$this->load->model('AdjustModel');
	}

	public function index(){
		$data['title']='PO Gagal Produksi';
		$get=$this->input->get();
		if(isset($get['kode_po'])){
			$kodepo=$get['kode_po'];
		}else{
			$kodepo=null;
		}

		if(isset($get['tahun'])){
			$tahun=$get['tahun'];
		}else{
			$tahun=null;
		}
		$data['kode_po']=$kodepo;
		$data['tahun']=$tahun;
		$sql="SELECT * FROM pogagalproduksi WHERE hapus=0 ";
		if(!empty($tahun)){
			$sql .= " AND tahun='".$tahun."' ";
		}
		if(!empty($kodepo)){
			$sql .= " AND kode_po LIKE '%".$kodepo."%' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=[];
		$data['prods']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['prods'][]=array(
				'no'=>$no++,
				'id'=>$r['id'],
				'tahun'=>$r['tahun'],
				'idpo'=>$r['idpo'],
				'kode_po'=>$r['kode_po'],
				'keterangan'=>$r['keterangan'],
			);
		}
		$data['simpan']=$this->url.'simpan';
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	public function simpan(){
		$data=$this->input->post();
		$po = explode('-',$data['kode_po']);
		$insert=array(
			'tahun'=>$data['tahun'],
			'idpo'=>$po[0],
			'kode_po'=>$po[1],
			'keterangan'=>$data['keterangan'].' '.$data['tahun'],
			'tglinput'=>date('Y-m-d H:i:s'),
			'hapus'=>0
		);
		$this->db->insert('pogagalproduksi',$insert);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->url);
	}

}