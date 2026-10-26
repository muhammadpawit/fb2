<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpendapatan extends CI_Controller {
	public $layout;
	public $page;
	public $login;
	public $auth;
	public $session;
	public $GlobalModel;
	public $input;
	public $db;
	public $ReportModel;
	public $uri;

	function __construct() {
		parent::__construct();
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index() {
		$data = [];
		$data['title'] = 'Hitungan Pendapatan Finishing';
		
		$get = $this->input->get();

		// Default: 4 minggu terakhir
		if(isset($get['tanggal1'])){
			$tanggal1 = $get['tanggal1'];
		}else{
			$tanggal1 = date('Y-m-d',strtotime("first day of this month"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2 = $get['tanggal2'];
		}else{
			$tanggal2 = date('Y-m-d',strtotime("saturday this week"));
		}
		
		$data['tanggal1'] = $tanggal1;
		$data['tanggal2'] = $tanggal2;
		
		// Generate weekly periods (Mon-Sat) within the date range
		$weeks = [];
		$currentMonday = date('Y-m-d', strtotime('monday this week', strtotime($tanggal1)));
		if(strtotime($currentMonday) < strtotime($tanggal1)){
			$currentMonday = date('Y-m-d', strtotime($currentMonday . ' +7 days'));
		}
		// If tanggal1 itself is a Monday or before it in the week
		$currentMonday = date('Y-m-d', strtotime('monday this week', strtotime($tanggal1)));
		
		while(strtotime($currentMonday) <= strtotime($tanggal2)){
			$saturday = date('Y-m-d', strtotime($currentMonday . ' +5 days'));
			if(strtotime($saturday) > strtotime($tanggal2)){
				$saturday = $tanggal2;
			}
			$weeks[] = array(
				'start' => $currentMonday,
				'end' => $saturday,
				'label' => date('d', strtotime($currentMonday)) . ' ' . $this->_bulanPendek(date('m', strtotime($currentMonday))) . ' - ' . date('d', strtotime($saturday)) . ' ' . $this->_bulanPendek(date('m', strtotime($saturday))) . ' ' . date('Y', strtotime($saturday))
			);
			$currentMonday = date('Y-m-d', strtotime($currentMonday . ' +7 days'));
		}
		
		// Build data per week
		$allWeeks = [];
		foreach($weeks as $week){
			$w1 = $week['start'];
			$w2 = $week['end'];
			
			// Get pendapatan per jenis PO for this week
			$sql = "SELECT 
						COALESCE(pr.nama_po, p.nama_po) as jenis_po, 
						SUM(p.jumlah_dz) as total_dz, 
						COALESCE(MAX(mjp.perkalian_pendapatan_finishing), 0) as nominal_perkalian,
						IF(COALESCE(MAX(mjp.perkalian_pendapatan_finishing), 0) > 0, 
							SUM(p.jumlah_dz) * MAX(mjp.perkalian_pendapatan_finishing), 
							SUM(p.jumlah_pendapatan)
						) as total_pendapatan 
					FROM packing p 
					LEFT JOIN produksi_po pr ON pr.kode_po = p.nama_po 
					LEFT JOIN master_jenis_po mjp ON mjp.nama_jenis_po = COALESCE(pr.nama_po, p.nama_po)
					WHERE p.hapus=0 AND DATE(p.creted_date) BETWEEN '$w1' AND '$w2' 
					GROUP BY COALESCE(pr.nama_po, p.nama_po) 
					ORDER BY total_pendapatan DESC";
			$pendapatan = $this->GlobalModel->queryManual($sql);
			
			// Pengeluaran: Anak Harian (total pembulatan dari gaji_finishing bagian FINISHING)
			$anakHarian = 0;
			$g = $this->GlobalModel->queryManualRow("SELECT * FROM gaji_finishing WHERE hapus=0 AND DATE(tanggal1)='".$w1."' AND bagian LIKE '%Finishing%' ");
			if(!empty($g)){
				$details = $this->GlobalModel->getData('gaji_finishing_detail', array('idgaji'=>$g['id']));
				foreach($details as $d){
					$gaji = $this->GlobalModel->getDataRow('karyawan_harian', array('id'=>$d['idkaryawan']));
					if(!empty($gaji)){
						$sub = round($gaji['gaji']/12*$d['senin']) 
							 + round($gaji['gaji']/12*$d['selasa']) 
							 + round($gaji['gaji']/12*$d['rabu']) 
							 + round($gaji['gaji']/12*$d['kamis']) 
							 + round($gaji['gaji']/12*$d['jumat']) 
							 + round($gaji['gaji']/12*$d['sabtu']) 
							 + round($gaji['gaji']/12*$d['minggu']);
						$sub += ($d['lembur']>0 ? $d['lembur'] : 0);
						$sub += ($d['insentif']==1 ? $gaji['gaji'] : 0);
						$sub -= (isset($d['claim']) ? $d['claim'] : 0);
						$sub -= (isset($d['pinjaman']) ? $d['pinjaman'] : 0);
						$sub -= (isset($d['warteg']) ? $d['warteg'] : 0);
						$grand = $sub;
						if(isset($d['saving'])){
							$grand = $grand - $d['saving'] + (isset($d['keluarkansaving']) ? $d['keluarkansaving'] : 0);
						}
						$anakHarian += pembulatmurni($grand);
					}
				}
			}
			
			// Pengeluaran: Anak Borongan (sesuai logic Finishing/resumegaji)
			// Hitung periode gaji borongan (Sabtu minggu kemarin ke Jumat minggu ini, berlaku mulai 17 Oktober 2026)
			$day1 = date('N', strtotime($w1));
			if ($day1 == 6) {
				$calc_sabtu = $w1;
			} else {
				$calc_sabtu = date('Y-m-d', strtotime('last Saturday', strtotime($w1)));
			}

			$day2 = date('N', strtotime($w2));
			if ($day2 == 5) {
				$calc_jumat = $w2;
			} elseif ($day2 == 6) {
				$calc_jumat = date('Y-m-d', strtotime($w2 . ' - 1 day'));
			} elseif ($day2 == 7) {
				$calc_jumat = date('Y-m-d', strtotime($w2 . ' - 2 days'));
			} else {
				$calc_jumat = date('Y-m-d', strtotime($calc_sabtu . ' + 6 days'));
			}

			if (strtotime($calc_jumat) < strtotime($calc_sabtu)) {
				$calc_jumat = date('Y-m-d', strtotime($calc_sabtu . ' + 6 days'));
			}

			// Aturan: Berlaku mulai tanggal 17 Oktober 2026
			if (strtotime($calc_sabtu) >= strtotime('2026-10-17')) {
				$tgl_borongan1 = $calc_sabtu;
				$tgl_borongan2 = $calc_jumat;
			} else {
				$tgl_borongan1 = $w1;
				$tgl_borongan2 = $w2;
			}

			$anakBorongan = 0;
			// Borongan mesin
			$prods = $this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE id IN(SELECT idkaryawanharian FROM boronganmesin WHERE gaji=1 AND (kategori LIKE 'KANCING%' OR kategori LIKE 'TRESS' OR kategori LIKE 'PASANG KANCING%' OR kategori LIKE 'LOBANG KANCING') AND DATE(creted_date) BETWEEN '".$tgl_borongan1."' AND '".$tgl_borongan2."' ) AND status_gaji=1 ");
			$gajim = 0;
			foreach($prods as $p){
				$gajimesin = $this->ReportModel->getGajiBorongan($p['id'],$tgl_borongan1,$tgl_borongan2);
				$gajim += $gajimesin;
			}
			// Cucian
			$c = $this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE status_gaji=1 AND id IN(SELECT idkaryawan FROM cucian WHERE hapus=0 and jenis=1 AND DATE(tanggal) BETWEEN '".$tgl_borongan1."' AND '".$tgl_borongan2."' ) ");
			$cucians = 0;
			foreach($c as $p){
				$gajimesin = $this->ReportModel->GetGajiCucian($p['id'],$tgl_borongan1,$tgl_borongan2);
				$cucians += $gajimesin;
			}
			// Buang benang
			$bb = $this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE status_gaji=1 AND id IN(SELECT idkaryawan FROM buang_benang_finishing WHERE hapus=0 AND gaji=1 AND DATE(tanggal) BETWEEN '".$tgl_borongan1."' AND '".$tgl_borongan2."') ");
			$bbs = 0;
			if(!empty($bb)){
				foreach($bb as $p){
					$gajimesin = $this->ReportModel->GetGajibb($p['id'],$tgl_borongan1,$tgl_borongan2);
					$bbs += $gajimesin;
				}
			}
			// Packing
			$pk = $this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE status_gaji=1 AND id IN(SELECT idkaryawanharian FROM packing WHERE hapus=0 AND gaji=1 AND DATE(creted_date) BETWEEN '".$tgl_borongan1."' AND '".$tgl_borongan2."') ");
			$pkg = 0;
			foreach($pk as $p){
				$gajimesin = $this->ReportModel->GetGajipacking($p['id'],$tgl_borongan1,$tgl_borongan2);
				$pkg += $gajimesin;
			}
			$anakBorongan = pembulatangaji($gajim) + pembulatangaji($cucians) + pembulatangaji($bbs) + pembulatangaji($pkg);

			// Format label tanggal untuk anak borongan
			$labelAnakBorongan = 'Anak Borongan';
			if ($tgl_borongan1 != $w1 || $tgl_borongan2 != $w2) {
				$labelAnakBorongan = 'Anak Borongan<br><small style="font-size:10px; color:#666;">(Periode: ' . date('d-m-Y', strtotime($tgl_borongan1)) . ' s.d ' . date('d-m-Y', strtotime($tgl_borongan2)) . ')</small>';
			}
			
			// Tabung gas
			$tabungGas = 0;
			$namaTabungGas = '';
			$gas = $this->GlobalModel->queryManualRow("SELECT SUM(nominal) as total, GROUP_CONCAT(DISTINCT keterangan SEPARATOR ', ') as ket FROM pengeluaran_finishing WHERE hapus=0 AND DATE(tanggal) BETWEEN '".$w1."' AND '".$w2."' AND lower(keterangan) LIKE '%tabung gas%' ");
			if(!empty($gas) && $gas['total'] > 0){
				$tabungGas = $gas['total'];
				if(!empty($gas['ket'])) {
					$namaTabungGas = $gas['ket'];
				}
			}
			
			// Get the week number for tabung gas label fallback
			$weekNum = date('W', strtotime($w1));
			if(empty($namaTabungGas)){
				$namaTabungGas = 'Tabung Gas ';
			}
			
			$allWeeks[] = array(
				'label' => $week['label'],
				'start' => $w1,
				'end' => $w2,
				'pendapatan' => $pendapatan,
				'anak_harian' => $anakHarian,
				'anak_borongan' => $anakBorongan,
				'label_anak_borongan' => $labelAnakBorongan,
				'tgl_borongan1' => $tgl_borongan1,
				'tgl_borongan2' => $tgl_borongan2,
				'tabung_gas' => $tabungGas,
				'nama_tabung_gas' => $namaTabungGas,
				'week_num' => $weekNum,
			);
		}
		
		$data['weeks'] = $allWeeks;
		
		if(isset($get['pdf'])){
			$this->load->library('pdfgenerator');
			$data['title_pdf'] = 'Laporan Pendapatan Finishing';
			$file_pdf = 'Laporan_Pendapatan_Finishing_'.time();
			$paper = 'A4';
			$orientation = "landscape";
			
			$html = $this->load->view($this->page.'laporanpendapatan/index_pdf', $data, true);
			$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
		} else {
			$data['page'] = $this->page . 'laporanpendapatan/index';
			$this->load->view($this->layout, $data);
		}
	}
	
	private function _bulanPendek($m){
		$bulan = array(
			'01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April',
			'05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus',
			'09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
		);
		return isset($bulan[$m]) ? $bulan[$m] : $m;
	}
}
