<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poretur extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/poretur/';
		$this->url=BASEURL.'Poretur/';
		$this->load->model('AdjustModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data['title']='PO Retur';
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

        $data['tanggal1']=$tanggal1;
        $data['tanggal2']=$tanggal2;

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
		$data['tambah']=$this->url.'add';
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

    function caripo(){
        $get = $this->input->get();
        $lastyear=date('Y',strtotime('-1 year'));
        $tahun=$lastyear.'_'.date('Y');
        $sql="SELECT kd.* FROM finishing_kirim_gudang_".$tahun." fkg ";
        $sql.=" LEFT JOIN finishing_kirim_gudang_rincian_".$tahun." kd ON kd.id_finishing_kirim_gudang=fkg.id_finishing_kirim_gudang ";
        $sql.=" WHERE fkg.kode_po='".$get['kode_po']."' ";
        $data = $this->GlobalModel->QueryManual($sql);
        echo json_encode($data);
    }

    public function add(){
		$data['title']='PO Retur';
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
		
        $data['action']=$this->url.'save';
		$data['page']=$this->page.'form';
		$this->load->view($this->layout,$data);
	}

    public function save(){
        $post = $this->input->post();
        pre($post);
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