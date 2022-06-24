<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensioperator extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/absensioperator/';
		$this->url=BASEURL.'Absensioperator/';
	}

	public function index(){
		$data=[];
		$data['title']='Laporan Absensi Bordir';
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
		$results=looping_tanggal($tanggal1,$tanggal2);
		$no=1;
		$absen=[];
		foreach($results as $r){
			$absen=$this->ReportModel->absenopt($r['tanggal']);
			$data['prods'][]=array(
				'no'=>$no,
				'tanggal'=>$r['tanggal'],
				'dets'=>$absen,
			);
			$no++;
		}
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}
}