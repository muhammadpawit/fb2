<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alatsukabumi extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/Alatsukabumi/';
		$this->url=BASEURL.'Alatsukabumi/';
		$this->load->model('AlatsukabumiModel');
	}

	public function index(){
		$data=[];
		$data['title']='Penerimaan Alat-alat Di Sukabumi';
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
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
		);
		$data['prods']=$this->AlatsukabumiModel->show($filter);
		$data['page']=$this->page.'list_penerimaan';
		$this->load->view($this->layout,$data);
	}

}