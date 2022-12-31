<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historypokirimgudang extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/historypokirimgudang/';
		$this->url=BASEURL.'Historypokirimgudang/';
	}

	public function index(){
		$data=[];
		$data['title']='History PO Kirim Gudang ';
		$get=$this->input->get();
		if(isset($get['kode_po'])){
			$kode_po=$get['kode_po'];
		}else{
			$kode_po=null;
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['kode_po']=$kode_po;
		$idpo=!empty($kode_po)?explode("-", $kode_po):null;
		//pre($idpo);
		$data['tanggal2']=$tanggal2;
		$data['results']=[];
		$results=$this->ReportModel->historypokirimgudang(!empty($idpo)?$idpo[0]:0);
		//pre($results);
		$data['results']=$results;
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}
}