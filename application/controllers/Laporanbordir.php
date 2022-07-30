<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanbordir extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('KirimsetorModel');
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Laporanbordir/';
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
		$data['totalpendapatan']=number_format($totalpendapatan);
		$luar=$this->ReportModel->pendapatanbordir($filter,2);
		$totalpoluar=0;
		foreach($luar as $p){
			if($tanggal2>='2022-07-19'){
				$totalpoluar+=(((($p['total_stich']*0.3))+(0)));
			}else{
				$totalpoluar+=(((($p['total_stich']*0.2))+(0)));	
			}			
		}
		$p15=0;
		$pe15=[];
		$pe15=$this->ReportModel->pendapatanbordirdalam15($filter,1);
		if(!empty($pe15)){
			foreach($pe15 as $p){
				$p15+=(((($p['total_stich']*0.15))+(0)));
			}
		}
		$data['p15']=number_format($p15);
		$data['totalpoluar']=number_format($totalpoluar);
		$data['totalpen']=($totalpendapatan+$totalpoluar+$p15);
		// end

		// pengeluaran bordir
		$sql="SELECT * FROM pengeluaran_bordir WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY id desc ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($sql);
		$nom=1;
		$data['pengeluarans']=[];
		$details=[];
		$totalpengeluaran=0;
		foreach($results as $r){
			$details=$this->GlobalModel->Getdata('pengeluaran_bordir_detail',array('hapus'=>0,'idpengeluaran'=>$r['id']));
			$data['pengeluarans'][]=array(
				'no'=>$nom++,
				'id'=>$r['id'],
				'tanggal'=> date('d F Y',strtotime($r['tanggal'])),
				'total'=>$r['total'],
				'keterangan'=>$r['keterangan'],
				'detail'=>$details,
			);
			$totalpengeluaran+=($r['total']);
		}

		$data['lababersih']=round(($totalpendapatan+$totalpoluar)-$totalpengeluaran);

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