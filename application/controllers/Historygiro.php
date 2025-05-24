<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historygiro extends CI_Controller {

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
	public $bg_warning;
	public $bg_danger;
	public $bg_success;
	public $bg_info;


	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/historygiro/';
		$this->layout='newtheme/page/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
		$this->load->model('PembayaranModel');
	}

	public function index(){
		$data=[];
		$data['title']='History Giro';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('Monday last week'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$sql="SELECT * FROM gaji_finishing WHERE hapus=0 AND bagian LIKE 'GUDANG%' ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$data['prods']=[];
		foreach($results as $r){
			$data['prods'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'bagian'=>'Gudang',
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'detail'=>BASEURL.'Gaji/gudangdetail/'.$r['id'],
				'hapus'=>BASEURL.'Gaji/pressqchapus/'.$r['id'],
				'excel'=>BASEURL.'Gaji/gudangdetail/'.$r['id'].'?&excel=1',
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Gaji/gudang_add';
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout.'main',$data);
		}
	}

}