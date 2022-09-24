<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alokasiperminggu extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/alokasiperminggu/';
		$this->url=BASEURL.'Alokasiperminggu/';
		$this->load->model('AdjustModel');
	}

	public function index(){
		$data['title']='Alokasi Mingguan ';
		$get=$this->input->get();
		$url='';
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
			$url.='&tanggal1='.$tanggal1;
		}else{
			$tanggal1=null;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
			$url.='&tanggal2='.$tanggal2;
		}else{
			$tanggal2=null;
		}		
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$serang=$this->GlobalModel->GetData('master_cmt',array('lokasi'=>1,'hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		foreach($serang as $s){
			$data['serang'][]=array(
				'nama'=>strtolower($s['cmt_name']),
			);
		}
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}
}