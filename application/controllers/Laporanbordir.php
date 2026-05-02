<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanbordir extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('KirimsetorModel');
		$this->load->model('LababordirModel');
		$this->load->model('LaporanmingguanModel');
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Laporanbordir/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function mingguan(){
		$data=[];
		$data['title']='Laporan Pendapatan dan Pengeluaran Bordir ';
		$get=$this->input->get();
		$data['jenis']=[];
		$results=array();
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
		$data['totalpendapatan']=($totalpendapatan);
				$totalpoluar=0;
		$totalpoluar=$this->ReportModel->getSumPendapatanpoluar($filter,2);
		$p15=0;
		$pe15=[];
		$pe15=$this->ReportModel->pendapatanbordirdalam15($filter,1);
		if(!empty($pe15)){
			foreach($pe15 as $p){
				$p15+=(((($p['total_stich']*0.15))+(0)));
			}
		}
		$data['p15']=($p15);
		$data['totalpoluar']=round($totalpoluar);
		// end
		
		// Belanja Bordir = Pembelian Bahan Baku ambil dari alokasi_transfer
		$data['belanjabordir']=0;
		$data['belanjabordir']=$this->LababordirModel->operasional($tanggal1,$tanggal2,1);
		$data['operasional']=0;
		$ops=$this->LaporanmingguanModel->alokasi_bordir_between($tanggal1,$tanggal2,2,2);
		$data['operasional']=($this->LababordirModel->operasional($tanggal1,$tanggal2,2)+$ops);
		$data['gajibordir']=0;
		$gaji=$this->LaporanmingguanModel->alokasi_bordir_between($tanggal1,$tanggal2,2,3);
		$data['gajibordir']=($this->LababordirModel->operasional($tanggal1,$tanggal2,3) + $gaji);
		$data['service']=0;
		$data['service']=$this->LababordirModel->operasional($tanggal1,$tanggal2,4);

		$data['pendapatan']=$this->LababordirModel->pendapatan($tanggal1,$tanggal2,null);
		$data['totalpendapatan'] = $data['pendapatan']['total']['total_0_18'];
		$data['totalpoluar']     = $data['pendapatan']['total']['total_luar'];
		$data['pend']            = $data['pendapatan']['total']['total_jumlah_per_mesin'];

		$totalpengeluaran=($data['belanjabordir']+$data['gajibordir']+$data['operasional']+$data['service']);
		$data['lababersih']=round($data['pend']-$totalpengeluaran);

		$url='';
		if(!empty($tanggal1)){
			$url.="&tanggal1=".$tanggal1;
		}
		if(!empty($tanggal2)){
			$url.="&tanggal2=".$tanggal2;
		}
		$data['excel']=$this->url.'mingguan?&excel=true'.$url;
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;		
		if(isset($get['excel'])){
			$this->load->view($this->page.'laporanbordir/mingguan_excel',$data);	
		}else{
			$data['page']=$this->page.'laporanbordir/mingguan';
			$this->load->view($this->layout,$data);	
		}
	}

}