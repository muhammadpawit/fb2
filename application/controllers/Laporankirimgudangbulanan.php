<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporankirimgudangbulanan extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/grafikpendapatankirimgudang/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Laporankirimgudangbulanan/';
	}

	public function index() {

		$data =[];

		$data['title'] ='Grafik Pendapatan Kirim Gudang';
		$get=$this->input->get();
		$periode=$this->ReportModel->periode();

		for ($i = 0; $i < 12; $i++) {

		    $timestamp = mktime(0, 0, 0, $periode['bulan'] + $i, 1,$periode['tahun']); // angka 6 bulan juni, periode awal potongan

		    $bulan[]=$months[date('n', $timestamp)] = date('M Y', $timestamp);

		}

		$data['prods']=[];

		$kemeja=[];

		$kaos=[];

		$celana=[];

		$total=0;

		foreach($bulan as $b=>$val){

			$b=explode(" ", $val);

			$g=date('n',strtotime($b[0]));

			$t=explode(" ", $val);

			$timestamp = mktime(0, 0, 0, $g + $i, 1,$t[1]);

			$month=$months[date('n', $timestamp)] = date('n', $timestamp);

			$y=$t[1];

				$data['prods'][]=array(

					'bulan'=>$val,

					'bln'=>$month,

					'year'=>$y,

					'kemeja'=>$this->ReportModel->pendapatanbulanan($month,$y,1),

					'kaos'=>$this->ReportModel->pendapatanbulanan($month,$y,2),

					'celana'=>$this->ReportModel->pendapatanbulanan($month,$y,3),

					'keterangan'=>null,

				);

			$kemeja[]=array(

					'tot'=>$this->ReportModel->pendapatanbulanan($month,$y,1)==null?0:$this->ReportModel->pendapatanbulanan($month,$y,1),

				);

			$kaos[]=array(

					'tot'=>$this->ReportModel->pendapatanbulanan($month,$y,2)==null?0:$this->ReportModel->pendapatanbulanan($month,$y,2),

				);

			$celana[]=array(

					'tot'=>$this->ReportModel->pendapatanbulanan($month,$y,3)==null?0:$this->ReportModel->pendapatanbulanan($month,$y,3),

				);

		}

		$data['kem']=implode(",", array_column($kemeja, 'tot'));

		$data['kao']=implode(",", array_column($kaos, 'tot'));

		$data['cel']=implode(",", array_column($celana, 'tot'));

		//pre($data['cel']);

		$bulan=$this->ReportModel->month();

		$data['bulan']=json_encode($bulan);

		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';

			$this->load->view($this->layout,$data);
		}

	}
}