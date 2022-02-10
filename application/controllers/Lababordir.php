<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lababordir extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/lababordir/';
		$this->url=BASEURL.'Lababordir/';
		$this->load->model('LababordirModel');
	}

	public function index(){
		$data=[];
		$data['title']='Laba Bordir';
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
		$products=$this->ReportModel->pendapatanbordirdalam($filter,1);
		$jumlah=0;
		$i=0;
		$j=array();
		$totalpendapatan=0;
		foreach($products as $p){
			$totalpendapatan+=(((($p['total_stich']*0.18))+(0)));
		}
		$data['podalam']=($totalpendapatan);
		$luar=$this->ReportModel->pendapatanbordir($filter,2);
		$totalpoluar=0;
		foreach($luar as $p){
			$totalpoluar+=(((($p['total_stich']*0.2))+(0)));
		}
		$data['poluar']=($totalpoluar);

		$data['totalpen']=($totalpendapatan+$totalpoluar);
		// end

		// pengeluaran 
		$keluar=0;
		$keluar=$this->LababordirModel->Getkeluar($filter);
		$data['keluar']=$keluar;
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