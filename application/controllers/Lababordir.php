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



		// Hitung / Ambil periode Sabtu - Jumat untuk Gaji Operator & Buang Benang Bordir
		if (isset($get['tgl_sabtu']) && !empty($get['tgl_sabtu'])) {
			$tgl_sabtu = $get['tgl_sabtu'];
		} else {
			$day1 = date('N', strtotime($tanggal1));
			$tgl_sabtu = ($day1 == 6) ? $tanggal1 : date('Y-m-d', strtotime('last Saturday', strtotime($tanggal1)));
		}

		if (isset($get['tgl_jumat']) && !empty($get['tgl_jumat'])) {
			$tgl_jumat = $get['tgl_jumat'];
		} else {
			$day2 = date('N', strtotime($tanggal2));
			if ($day2 == 5) {
				$tgl_jumat = $tanggal2;
			} else {
				$tgl_jumat = date('Y-m-d', strtotime('this Friday', strtotime($tanggal2)));
				if (strtotime($tgl_jumat) < strtotime($tgl_sabtu)) {
					$tgl_jumat = date('Y-m-d', strtotime($tgl_sabtu . ' + 6 days'));
				}
			}
		}
		$data['tgl_sabtu'] = $tgl_sabtu;
		$data['tgl_jumat'] = $tgl_jumat;

		// Belanja Bordir = Pembelian Bahan Baku ambil dari alokasi_transfer
		$data['belanjabordir']=0;
		$data['belanjabordir']=$this->LababordirModel->operasional($tanggal1,$tanggal2,1);
		$data['operasional']=0;
		$ops=$this->LaporanmingguanModel->alokasi_bordir_between($tanggal1,$tanggal2,2,2);
		$data['operasional']=($this->LababordirModel->operasional($tanggal1,$tanggal2,2)+$ops);
		
		// 1) Gaji Operator / Borongan Bordir (Ambil dari data Bordir/gajioperator: gaji_operator & gaji_operator_new)
		$data['gajioperator'] = 0;
		$q_go = $this->db->query("
			SELECT id 
			FROM gaji_operator 
			WHERE hapus = 0 
			  AND (
				  (DATE(tanggal1) >= '".$tgl_sabtu."' AND DATE(tanggal2) <= '".$tgl_jumat."')
				  OR DATE(tanggal1) BETWEEN '".$tgl_sabtu."' AND '".$tgl_jumat."'
				  OR DATE(tanggal2) BETWEEN '".$tgl_sabtu."' AND '".$tgl_jumat."'
			  )
		")->result_array();

		if (!empty($q_go)) {
			foreach ($q_go as $go_item) {
				$id_go = $go_item['id'];
				$q_sum = $this->db->query("
					SELECT COALESCE(SUM(grandtotal), 0) as total 
					FROM gaji_operator_new 
					WHERE hapus = 0 AND idgajiopt = '".$id_go."'
				")->row_array();
				
				$total_opt = isset($q_sum['total']) ? (float)$q_sum['total'] : 0;
				
				// Uang makan mandor malam jika ada
				$manMalam = $this->ReportModel->getMandor_c($id_go, 2);
				$ummalam = ($manMalam > 0) ? 21000 : 0;
				
				$data['gajioperator'] += ($total_opt + $ummalam);
			}
		}

		// 2) Gaji Buang Benang Bordir (Periode Sabtu ke Jumat)
		$data['gajibuangbenang'] = 0;
		$q_bb = $this->db->query("
			SELECT COALESCE(SUM(qty_buang_benang * harga_buang_benan), 0) as total
			FROM kelolapo_buang_benang
			WHERE hapus = 0
			  AND DATE(created_date) BETWEEN '".$tgl_sabtu."' AND '".$tgl_jumat."'
		")->row_array();
		if (!empty($q_bb['total'])) {
			$data['gajibuangbenang'] = (float)$q_bb['total'];
		}

		// 3) Gaji Bulanan khusus Bordir (divisi 1 & 16)
		$data['gajibulanan'] = 0;
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
			$data['gajibulanan'] = (float)$q_gb['total'];
		}

		// 4) Kasbon khusus Bordir
		$data['kasbon'] = 0;
		$q_kasbon = $this->db->query("
			SELECT COALESCE(SUM(ks.nominal_acc), 0) as total
			FROM kasbon ks
			LEFT JOIN karyawan k ON k.id = ks.idkaryawan
			WHERE ks.hapus = 0
			  AND (ks.bagian IN (1, 16) OR k.divisi IN (1, 16))
			  AND DATE(ks.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'
		")->row_array();
		if (!empty($q_kasbon['total'])) {
			$data['kasbon'] = (float)$q_kasbon['total'];
		}

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

		$totalpengeluaran=($data['belanjabordir']+$data['gajioperator']+$data['gajibuangbenang']+$data['gajibulanan']+$data['kasbon']+$data['operasional']+$data['service']+$data['potonganwarteg']);
		$data['lababersih']=round($data['pend']-$totalpengeluaran);

		$url='';
		if(!empty($tanggal1)){
			$url.="&tanggal1=".$tanggal1;
		}
		if(!empty($tanggal2)){
			$url.="&tanggal2=".$tanggal2;
		}
		if(!empty($tgl_sabtu)){
			$url.="&tgl_sabtu=".$tgl_sabtu;
		}
		if(!empty($tgl_jumat)){
			$url.="&tgl_jumat=".$tgl_jumat;
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