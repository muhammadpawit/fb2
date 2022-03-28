<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Laporanexpedisi extends CI_Controller {



	function __construct() {

		parent::__construct();

		sessionLogin(URLPATH."\\".$this->uri->segment(1));

		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');

		$this->page='newtheme/page/laporanexpedisi/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Laporanexpedisi/';
	}

	function index(){
		$data=[];
		$data['title']='Laporan Ekspedisi';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of previous month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime('last day of this month'));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['prods']=[];
		
		$begin = new DateTime($tanggal1);
		$end   = new DateTime($tanggal2);
		$is=strtotime($tanggal1);
		$it=strtotime($tanggal2);
		$c=[];
		while($is<=$it){
			if(date("D",$is) == "Sun"){
			    $data['prods'][]=array(
			    	'a'=>date('Y-m-d',$is),
			    	'tanggal'=>date('Y-m-d',$is),
			    );
			    $c[]=date('Y-m-d',$is);
			}
			$tgl=date('Y-m-d',$is);
            $is=strtotime($tgl."+1 day");
		}
		$data['c']=$c;
		//pre($data['prods']);
		if(isset($get['excel'])){
			$this->load->view($this->page.'laporanexpedisi_excel',$data);
		}else{
			$data['page']=$this->page.'laporanexpedisi';
			$this->load->view($this->layout,$data);
		}
	}
}