<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formpengambilanalat extends CI_Controller {

	function __construct() {
		parent::__construct();
		////sessionLogin(URLPATH."\\".$this->uri->segment(1));
		////session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/formpengambilanalat/';
		$this->url=BASEURL.'Formpengambilanalat/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Form Pengambilan Alat';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('first day of this month'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime('last day of this month'));
		}
		$sql="SELECT * FROM formpengambilanalat WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY id DESC";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'tanggal'=> date('d F Y',strtotime($r['tanggal'])),
				'mandor'=>$r['mandor'],
				'shift'=>$r['shift'],
				'status'=>$r['status'] == 2 ? '<span class="badge alert-warning"><i class="fa fa-refresh"></i> menunggu validasi</span>':'<span class="badge alert-success"><i class="fa fa-check"></i> tervalidasi</span>',
				'detail'=>$this->url.'detail/'.$r['id'],
				'excel'=>null,
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=$this->url.'add';
		if(isset($get['pdf'])){
			$this->load->view($this->page.'finishing_excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}

	function detail($id){
		$data=[];
		$get=$this->input->get();
		$data['title'] = 'Form Ajuan Pengambilan Alat-alat bordir';
		$data['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0));
		$data['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$data['d'] = $this->GlobalModel->getDataRow('formpengambilanalat',array('id'=>$id,'hapus'=>0));
		$data['dt'] = $this->GlobalModel->getData('formpengambilanalat_detail',array('idform'=>$id,'hapus'=>0));
		$data['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$data['action']=$this->url.'save';
		$data['print']=$this->url.'detail/'.$id.'?&pdf=true';
		$data['batal']=$this->url.'';
		if(isset($get['pdf'])){
			
			$html =  $this->load->view($this->page.'pdf',$data,true);

			$this->load->library('pdfgenerator');
	        
	        // title dari pdf
	        $this->data['title_pdf'] = 'Surat Jalan Kirim Jahit';
	        
	        // filename dari pdf ketika didownload
	        $file_pdf = 'Surat_Jalan_Pengeluaran_Alat_'.time();
	        // setting paper
	        // $paper = 'A4';
	        $paper = array(0,0,800,850);
	        //orientasi paper potrait / landscape
	        $orientation = "potrait";
	        
	        // run dompdf
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			$data['page']=$this->page.'detail';
			$this->load->view($this->layout,$data);
		}
	}

	function getjson(){
		$results=[];
		$post = $this->input->post();
		$results = $this->GlobalModel->getData('formpengambilanalat_detail',array('hapus'=>0,'idform'=> $post['id_form']));
		$sql = "SELECT a.*, b.* FROM formpengambilanalat_detail a JOIN gudang_persediaan_item b ON b.id_persediaan=a.id_persediaan
		WHERE a.hapus=0 AND idform='".$post['id_form']."'
		";
		$results = $this->GlobalModel->QueryManual($sql);
		echo json_encode($results);
	}

	function add(){
		$data=[];
		$data['title'] = 'Form Ajuan Pengambilan Alat-alat bordir';
		$data['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0));
		$data['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$data['action']=$this->url.'save';
		$data['batal']=$this->url.'';
		$data['page']=$this->page.'form';
		$this->load->view($this->layout,$data);
	}

	function save(){
		$post = $this->input->post();
		// pre($post);
		if(isset($post['products'])){
			$insert = array(
				'tanggal' => $post['tanggal'],
				'mandor' => $post['mandor'],
				'shift' => $post['shift'],
				'hapus' => 0,
				'status' => 2, // status 2 belum di validasi, status 1 sudah divalidasi
			);
			$this->db->insert('formpengambilanalat',$insert);
			$id=$this->db->insert_id();
			foreach($post['products'] as $p){
				$detail=array(
					'idform'=>$id,
					'id_persediaan'=>$p['idpersediaan'],
					'kebutuhan'=>$p['jumlah'],
					'stock'=>$p['stok_saatini'],
					'ajuan'=>$p['jumlah'],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0
				);
				$this->db->insert('formpengambilanalat_detail',$detail);
			}
			$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
			redirect($this->url);
		}else{
			$this->session->set_flashdata('gagal','Data Gagal Di Simpan. Coba beberapa saat lagi.');
			redirect($this->url);
		}
	}
}