<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LababordirModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function getPodalam($data){
		$sql="SELECT sum(total_stich) as total_stich FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(created_date) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		if(!empty($data['nomesin'])){
			$sql.=" AND mesin_bordir='".$data['nomesin']."' ";
		}
		$d=$this->db->query($sql);
		return $d->result_array();
	}

	public function Getkeluar($data){
		$aruskas=0;
		$tf=0;
		$hasil=0;
		$sql1="SELECT SUM(saldokeluar) as total FROM aruskas WHERE hapus=0 AND bagian=2 ";
		if(!empty($data['tanggal1'])){
			$sql1.=" AND date(tanggal) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$s1=$this->GlobalModel->QueryManualRow($sql1);
		if(!empty($s1)){
			$aruskas=$s1['total'];
		}

		$sql2="SELECT SUM(nominal) as total FROM transferan WHERE hapus=0 AND bagian=2 ";
		if(!empty($data['tanggal1'])){
			$sql2.=" AND date(tanggal) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$s2=$this->GlobalModel->QueryManualRow($sql2);
		if(!empty($s2)){
			$tf=$s2['total'];
		}

		$hasil=($aruskas+$tf);
		return $hasil;
	}


	public function operasional($tanggal1,$tanggal2,$pengalokasian){
		$hasil=0;
		$sql="SELECT COALESCE(SUM(nominal),0) as total FROM alokasi_transferan WHERE hapus=0 AND bagian='2' AND pengalokasian =$pengalokasian ";
		$sql.=" AND DATE(tanggal) BETWEEN '".date('Y-m-d',strtotime($tanggal1))."' AND '".date('Y-m-d',strtotime($tanggal2))."' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data['total'])){
			$hasil=$data['total'];
		}
		return $hasil;
	}

	function pendapatan($tanggal1,$tanggal2,$nomesin){
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'nomesin'=>$nomesin,
		);
		// $products=$this->ReportModel->pendapatanbordirall($filter);
		$jumlah=0;
		$i=0;
		$j=array();
		$totalpendapatan=0;
		$totalstich=0;
		$total018=0;
		$total02=0;
		$total015=0;
		$prev=null;
		$luar=0;
		$poluar=[];
		$globalstich=0;
		$g018=0;
		$g02=0;
		$g015=0;
		$gpendapatan=0;
		$total015=0;
		$sm="SELECT * FROM mesin_bordir WHERE id>0 AND nomor NOT IN(11) ";
		
		if(!empty($nomesin)){
			$sm.=" AND nomor='$nomesin' ";
		}
		$mesin=$this->GlobalModel->QueryManual($sm);
		$luar=[];
		$luar=$this->GlobalModel->QueryManual("
		SELECT a.mesin_bordir, a.laporan_perkalian_tarif as perkalian, c.id as idpemilik, c.nama FROM kelola_mesin_bordir a
		LEFT JOIN master_po_luar b ON b.id=a.kode_po
		LEFT JOIN pemilik_poluar c ON c.id=b.idpemilik
		WHERE a.hapus=0 AND jenis=2 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."'  
		AND laporan_perkalian_tarif IS NOT NULL 
		GROUP BY a.laporan_perkalian_tarif, b.idpemilik order by laporan_perkalian_tarif DESC
		");
		
		foreach($mesin as $mes){
			$totalstich=$this->ReportModel->totalStich($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total018=$this->ReportModel->total018($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total02=$this->ReportModel->total02($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total015=$this->ReportModel->total015($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$jumlah=$this->ReportModel->jumlahpendapatanbordir($mes['nomor'],$tanggal1,$tanggal2);
			$globalstich+=($totalstich);
			$g018+=($total018);
			$g02+=($total02);
			$g015+=($total015);
			$gpendapatan+=($total018+$total02);
			$products[]=array(
				'tanggal1'=>$tanggal1,
				'tanggal2'=>$tanggal2,
				'nomesin'=>$mes['nomor'],
				'shift'=>$mes['shift'],
				'stich'=>($totalstich),
				'0.18'=>!empty($total018)?($total018):0,
				'0.2'=>($total02),
				'0.18yn'=>0,
				'0.15'=>($total015),
				'pendapatan'=>($total018+$total02),
				'jumlah'=>($jumlah),
				'i'=>$i++,
				'keterangan'=>null,
				'dets'=>[],
			);
		}
		// pre($products);

		$total_per_mesin = [];
		$grand_total = 0; // Total pendapatan keseluruhan
		$total_jumlah_per_mesin = 0; // Total jumlah per mesin keseluruhan

		// Hitung total per mesin untuk setiap shift pagi dan malam
		foreach ($products as $p) {
			if (!isset($total_per_mesin[$p['nomesin']])) {
				$total_per_mesin[$p['nomesin']] = 0;
			}
			// Tambahkan pendapatan shift ke total mesin
			$total_per_mesin[$p['nomesin']] += $p['pendapatan'];
		}

		// Inisialisasi total kolom
		$total_stich = 0;
		$total_0_15 = 0;
		$total_0_18 = 0;
		$total_jumlah_luar = array_fill(0, count($luar), 0); // Total untuk kolom luar

		// Simpan data untuk setiap baris
		$data_rows = [];

		foreach($products as $p) {
			$row = [];
			$row[] = 'Mesin ' . $p['nomesin'];
			$row[] = $p['shift'];
			$row[] = number_format($p['stich']);
			$row[] = number_format($p['0.15']);
			$row[] = number_format($p['0.18']);

			$jumlah_permesin = $p['0.18']; // Mulai dengan nilai dari 0.18
			foreach($luar as $index => $b) {
				// Ambil nilai kolom dinamis
				$hasil = json_encode($this->ReportModel->total02_array($p['nomesin'], $p['shift'], $p['tanggal1'], $p['tanggal2'], $b['idpemilik']));
				$data = json_decode($hasil);
				$nilaiData = isset($data->data) ? $data->data : 0;
				$jumlah_permesin += $nilaiData; // Tambahkan nilai dinamis ke jumlah per mesin
				$row[] = number_format($nilaiData); // Tambahkan nilai dinamis ke baris

				// Tambahkan nilai ke total kolom luar
				$total_jumlah_luar[$index] += $nilaiData; 
			}

			// Tampilkan jumlah per mesin
			$row[] = number_format($jumlah_permesin);
			$total_jumlah_per_mesin += $jumlah_permesin; // Hitung total jumlah per mesin

			// Pendapatan Per Mesin
			if ($p['shift'] == 'MALAM' && isset($total_per_mesin[$p['nomesin']])) {
				$row[] = number_format($total_per_mesin[$p['nomesin']]);
				$grand_total += $total_per_mesin[$p['nomesin']]; // Tambahkan ke grand total
			} else {
				$row[] = 0;
			}
			$row[] = ''; // Keterangan

			// Simpan baris
			$data_rows[] = $row;

			// Tambahkan nilai untuk total kolom tetap
			$total_stich += $p['stich'];
			$total_0_15 += $p['0.15'];
			$total_0_18 += $p['0.18'];
		}

		// Tampilkan total di footer
		$total_footer = [];
		// $total_footer[] = 'Total';
		// $total_footer[] = '';
		$total_footer[] = number_format($total_stich);
		$total_footer[] = number_format($total_0_15);
		$total_footer[] = number_format($total_0_18);

		foreach($total_jumlah_luar as $total_luar) {
			$total_footer[] = number_format($total_luar);
		}
		$total_footer[] = ($total_jumlah_per_mesin);
		$total_footer[] = number_format($grand_total);
		// $total_footer[] = '';

		// Data yang disimpan
		$result = [
			'data' => $data_rows,
			'total' => $total_footer
		];

		// Anda dapat mengembalikan hasil ini sesuai kebutuhan
		return $result;

	}

}