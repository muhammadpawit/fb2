<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulanangudang extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/bulanangudang/';
        $this->url=BASEURL.'Bulanangudang';
		$this->load->model('BulananModel');
        $this->load->model('KirimsetorModel');
		$this->load->model('M_potonganoperator');
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

    function index(){
        $data=[];
		$data['title']='Laporan Bulanan Kirim Gudang';
		$data['products']=array();
		$no=1;
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
        $bulan   = $this->BulananModel->get();
        $data['prods']   = [];
        foreach($bulan as $b){
            $data['prods'][] = array(
                'bulan' => bulan()[$b['bulan']].' '.$b['tahun'],
                'link' => $this->url.'?&bulan='.$b['bulan'].'&tahun='.$b['tahun'],
            );
        }

        $data['mingguan']=[];
        $data['products']=[];
        if(isset($get['bulan'])){
            $url='?&bulan='.$get['bulan'].'&tahun='.$get['tahun'];
            // Contoh penggunaan
            $year = $get['tahun'];
            $month = $get['bulan'];
            $weeks = getWeeksInMonth($year, $month);

            foreach ($weeks as $week) {
                $start_date = $week['start_date']->format('Y-m-d');
                $end_date = $week['end_date']->format('Y-m-d');
                // echo "Minggu dari tanggal $start_date sampai $end_date <br>";
                $data['mingguan'][] = array(
                    'minggu'    => $this->url.$url.'&tanggal1='.$start_date.'&tanggal2='.$end_date,
                    'minggu1'   => date('d F Y',strtotime($start_date)),
                    'minggu2'   => date('d F Y',strtotime($end_date)),
                );
            }

            $filter=array(
                'tanggal1'=>$tanggal1,
                'tanggal2'=>$tanggal2,
            );
            $results=$this->KirimsetorModel->kirimgudangharian_group($filter);
            $no=1;
            $prev=null;
            $h=null;
            $dets=[];
            foreach($results as $row){
                $hari=hari(date('l',strtotime($row['tanggal'])));
                $dets = $this->KirimsetorModel->kirimgudangharian_hari($row['tanggal'],$hari);
                $ket = strtoupper($row['tujuan']);
                $data['products'][]=array(
                    'no'=>$no,
                    'hari'=>$hari,
                    'tanggal'=>date('d-m-Y',strtotime($row['tanggal'])),
                    'jml'=>$row['jml'],
                    'dz'=>$row['dz'],
                    'nama'=>null,//$row['nama'],
                    'nilai'=>$row['nilai'],//$row['nilai'],
                    'keterangan'=>$row['keterangan'],//!empty($row['keterangan']) ? $ket.' ('.$row['keterangan'].')' : $ket,
                    'dets' => $dets,
                );
                $no++;
            }
        }

        //pre($data['mingguan']);
        

        $data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);	
    }
}