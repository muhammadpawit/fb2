<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporanexpedisi extends CI_Controller {

	function __construct() {

		parent::__construct();

		//sessionLogin(URLPATH."\\".$this->uri->segment(1));

		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');

		$this->page='newtheme/page/laporanexpedisi/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Laporanexpedisi/';
		$this->load->model('TransportModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
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

	function mingguan(){
		$data=[];
		$data['title']='Laporan Ekspedisi Mingguan';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("monday this week"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime('saturday this week'));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['prods']=[];
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'hapus'=>0,
			'limit'=>null,
		);
		$pendapatan=[];
		$pengeluaran=[];
		foreach(looping_tanggal($tanggal1,$tanggal2) as $r){
			$pendapatan=$this->TransportModel->getdata_where($r['tanggal']);
			$pengeluaran=$this->TransportModel->getdata_drive_where($r['tanggal']);
			$data['prods'][]=array(
				'tanggal'=>$r['tanggal'],
				'pendapatan'=>$pendapatan,
				'pengeluaran'=>$pengeluaran,
			);
		}
		//pre($data['prods']);
		if(isset($get['excel'])){
			$this->load->view($this->page.'laporanexpedisi_excel_mingguan',$data);
		}else{
			$data['page']=$this->page.'laporanexpedisi_mingguan';
			$this->load->view($this->layout,$data);
		}
	}
}