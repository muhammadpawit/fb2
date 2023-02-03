<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafikpendapatanbordirperbulan extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/grafikpendapatanbordirperbulan/';
		$this->url=BASEURL.'Grafikpendapatanbordirperbulan/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Grafik Pendapatan Bordir Bulanan';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 day"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['prods']=[];
		$po=$this->ReportModel->getPO(array());
		$kirimgudang=$this->ReportModel->getPOKirimGudang(array());
		$data['po']=($po);
		$bulan=$this->ReportModel->month();
		$data['bulan']=json_encode($bulan);
		$data['jml']=$this->ReportModel->grafikpendapatanbordirbulanan(array());
		//pre($data['jml']);
		//echo implode(",", $data['jml']) ;exit;
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}
}