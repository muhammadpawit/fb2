<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporankeuanganbulanan extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/laporankeuanganbulanan/';
		$this->link='Laporankeuanganbulanan/';
		$this->load->model('ReportModel');
		$this->load->model('LaporanmingguanModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	function konveksi(){
		$data				= [];
		$data['title']		= 'Laporan Keuangan Bulanan Konveksi';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
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
		$index=0;
		while($is<=$it){
			if(date("D",$is) == "Sun"){
			    $data['prods'][]=array(
			    	'index'=>$index++,
			    	'a'=>date('Y-m-d',$is),
			    	'tanggal'=>date('Y-m-d',$is),
			    );
			    $c[]=date('Y-m-d',$is);
			}
			$tgl=date('Y-m-d',$is);
            $is=strtotime($tgl."+1 day");
		}
		$data['c']=$c;
		//pre( loopmingguan1('5',2023) );
		if(isset($get['excel'])){
			$this->load->view($this->page.'konveksi_excel',$data);
		}else{
			$data['page']=$this->page.'konveksi';
			$this->load->view($this->layout,$data);
		}
	}
}