<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Labakonveksi extends CI_Controller {
	public $layout;
	public $page;
	public $url;
	public $login;
	public $auth;
	public $session;
	public $GlobalModel;
	public $input;
	public $db;
	public $ReportModel;
	public $upload;
	public $viewData;
	public $pdfgenerator;
	public $pagination;
	public $uri;
	public $pdf;
	public $data;
	public $KirimsetorModel;
	
	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/labakonveksi/';
		$this->url=BASEURL.'Labakonveksi/';
		$this->load->model('LabakonveksiModel');
		$this->load->model('KirimsetorModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='LAPORAN LABA-RUGI KONVEKSI';
		$data['prods']=[];
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

		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'nomesin'=>null,
		);
		
		$jumlah=0;
		$i=0;
		$j=array();
		$totalpendapatan=0;
		// pendapatan
		$data['pendapatan'] = [];
		$data['pengeluaran'] = [];
		$data['resume']=[];
		$resume=$this->KirimsetorModel->kirimgudangharianresume($filter);
		foreach($resume as $row){
			$idjenis=$this->GlobalModel->GetDataRow('master_jenis_po',array('nama_jenis_po'=>$row['nama']));
			$data['resume'][]=array(
				'id'=>$idjenis['idjenis'], // 1 kemeja 2 kaos 3 celana
				'jml'=>$row['jml'],
				'nama'=>$row['nama'],
				'nilai'=>$row['nilai'],
				'dz'=>$row['pcs'],
				'keterangan'=>'Dikirim Gudang Tanah Abang',
			);
		}
		// pre($data['pengeluaran']);
		$url='';
		if(!empty($tanggal1)){
			$url.="&tanggal1=".$tanggal1;
		}
		if(!empty($tanggal2)){
			$url.="&tanggal2=".$tanggal2;
		}
		$data['excel']=$this->url.'?&excel=true'.$url;
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;		
		if(isset($get['excel'])){
			$this->load->view($this->page.'/list_excel',$data);	
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);	
		}

	}

}