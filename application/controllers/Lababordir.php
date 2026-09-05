<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lababordir extends CI_Controller {

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
		$this->url=BASEURL.'Lababordir/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
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



		// Belanja Bordir = Pembelian Bahan Baku ambil dari alokasi_transfer
		$data['belanjabordir']=0;
		$data['belanjabordir']=$this->LababordirModel->operasional($tanggal1,$tanggal2,1);
		$data['operasional']=0;
		$ops=$this->LaporanmingguanModel->alokasi_bordir_between($tanggal1,$tanggal2,2,2);
		$data['operasional']=($this->LababordirModel->operasional($tanggal1,$tanggal2,2)+$ops);
		$data['gajibordir']=0;
		$gaji=$this->LaporanmingguanModel->alokasi_bordir_between($tanggal1,$tanggal2,2,3);

		// Gaji Bulanan khusus Bordir (divisi 1 & 16)
		$gaji_bulanan_bordir = 0;
		$q_gb = $this->db->query("
			SELECT COALESCE(SUM(gb.total), 0) as total
			FROM gaji_bulanan gb
			JOIN karyawan k ON k.id = gb.idkaryawan
			WHERE gb.hapus = 0
			  AND k.divisi IN (1, 16)
			  AND k.hapus = 0
			  AND DATE(gb.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'
		")->row_array();
		if (!empty($q_gb['total'])) {
			$gaji_bulanan_bordir = (float)$q_gb['total'];
		}

		// Kasbon khusus Bordir
		$kasbon_bordir = 0;
		$q_kasbon = $this->db->query("
			SELECT COALESCE(SUM(ks.nominal_acc), 0) as total
			FROM kasbon ks
			LEFT JOIN karyawan k ON k.id = ks.idkaryawan
			WHERE ks.hapus = 0
			  AND (ks.bagian IN (1, 16) OR k.divisi IN (1, 16))
			  AND DATE(ks.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'
		")->row_array();
		if (!empty($q_kasbon['total'])) {
			$kasbon_bordir = (float)$q_kasbon['total'];
		}

		// Gaji Karyawan (Alokasi + Gaji Bulanan + Kasbon)
		$data['gajibordir']=($this->LababordirModel->operasional($tanggal1,$tanggal2,3) + $gaji + $gaji_bulanan_bordir + $kasbon_bordir);

		$data['service']=0;
		$data['service']=$this->LababordirModel->operasional($tanggal1,$tanggal2,4);

		// Potongan Warteg dari potongan_operator
		$data['potonganwarteg']=0;
		$q_pw = $this->db->query("
			SELECT COALESCE(SUM(nominal), 0) as total
			FROM potongan_operator
			WHERE hapus = 0
			  AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'
		")->row_array();
		if (!empty($q_pw['total'])) {
			$data['potonganwarteg'] = (float)$q_pw['total'];
		}

		$data['pendapatan']=$this->LababordirModel->pendapatan($tanggal1,$tanggal2,null);
		$data['totalpendapatan'] = $data['pendapatan']['total']['total_0_18'];
		$data['totalpoluar']     = $data['pendapatan']['total']['total_luar'];
		$data['pend']            = $data['pendapatan']['total']['total_jumlah_per_mesin'];

		$totalpengeluaran=($data['belanjabordir']+$data['gajibordir']+$data['operasional']+$data['service']+$data['potonganwarteg']);
		$data['lababersih']=round($data['pend']-$totalpengeluaran);

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
			$this->load->view($this->page.'laporanbordir/mingguan_excel',$data);	
		}else{
			$data['page']=$this->page.'laporanbordir/mingguan';
			$this->load->view($this->layout,$data);	
		}

	}

}