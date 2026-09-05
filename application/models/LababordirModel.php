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

		// Batch pre-fetch aggregated data to avoid N+1 queries
		$stich_map = [];
		$q_stich = $this->db->query("
			SELECT mesin_bordir, shift, COALESCE(SUM(total_stich),0) as total
			FROM kelola_mesin_bordir
			WHERE hapus=0 AND mesin_bordir<>11
			  AND DATE(created_date) BETWEEN '$tanggal1' AND '$tanggal2'
			GROUP BY mesin_bordir, shift
		")->result_array();
		foreach ($q_stich as $r) {
			$stich_map[$r['mesin_bordir'] . '_' . $r['shift']] = (float)$r['total'];
		}

		$t018_map = [];
		$q_018 = $this->db->query("
			SELECT mesin_bordir, shift, COALESCE(SUM(total_stich*perkalian_tarif),0) as total
			FROM kelola_mesin_bordir
			WHERE hapus=0 AND jenis=1 AND mesin_bordir<>11
			  AND DATE(created_date) BETWEEN '$tanggal1' AND '$tanggal2'
			GROUP BY mesin_bordir, shift
		")->result_array();
		foreach ($q_018 as $r) {
			$t018_map[$r['mesin_bordir'] . '_' . $r['shift']] = (float)$r['total'];
		}

		$t02_map = [];
		$q_02 = $this->db->query("
			SELECT a.mesin_bordir, a.shift,
			    COALESCE(SUM(
			        CASE
			            WHEN c.id = 4 AND a.stich = 4000 THEN a.jumlah_naik_mesin * 700
			            ELSE a.total_stich * a.perkalian_tarif
			        END
			    ), 0) AS total
			FROM kelola_mesin_bordir a
			LEFT JOIN master_po_luar b ON b.id = a.kode_po
			LEFT JOIN pemilik_poluar c ON c.id = b.idpemilik
			WHERE a.hapus = 0 AND a.jenis = 2
			  AND DATE(a.created_date) BETWEEN '$tanggal1' AND '$tanggal2'
			GROUP BY a.mesin_bordir, a.shift
		")->result_array();
		foreach ($q_02 as $r) {
			$t02_map[$r['mesin_bordir'] . '_' . $r['shift']] = (float)$r['total'];
		}

		$t015_map = [];
		$q_015 = $this->db->query("
			SELECT mesin_bordir, shift, COALESCE(SUM(total_stich*0.15),0) as total
			FROM kelola_mesin_bordir
			WHERE hapus=0 AND jenis=1 AND mesin_bordir<>11
			  AND DATE(created_date) BETWEEN '$tanggal1' AND '$tanggal2'
			GROUP BY mesin_bordir, shift
		")->result_array();
		foreach ($q_015 as $r) {
			$t015_map[$r['mesin_bordir'] . '_' . $r['shift']] = (float)$r['total'];
		}

		$jumlah_map = [];
		$q_jumlah = $this->db->query("
			SELECT mesin_bordir, COALESCE(SUM(total_stich*perkalian_tarif),0) as total
			FROM kelola_mesin_bordir
			WHERE hapus=0 AND mesin_bordir<>11
			  AND DATE(created_date) BETWEEN '$tanggal1' AND '$tanggal2'
			GROUP BY mesin_bordir
		")->result_array();
		foreach ($q_jumlah as $r) {
			$jumlah_map[$r['mesin_bordir']] = (float)$r['total'];
		}

		$luar_detail_map = [];
		$q_luar_detail = $this->db->query("
			SELECT a.mesin_bordir, a.shift, c.id as idpemilik,
				SUM(a.jumlah_naik_mesin) as qty,
				CASE 
					WHEN SUM(a.total_stich * a.perkalian_tarif) - FLOOR(SUM(a.total_stich * a.perkalian_tarif)) >= 0.5 
					THEN CEILING(SUM(a.total_stich * a.perkalian_tarif))
					ELSE FLOOR(SUM(a.total_stich * a.perkalian_tarif))
				END AS total
			FROM kelola_mesin_bordir a
			LEFT JOIN master_po_luar b ON b.id=a.kode_po
			LEFT JOIN pemilik_poluar c ON c.id=b.idpemilik
			WHERE a.hapus=0 AND a.jenis=2
			  AND DATE(a.created_date) BETWEEN '$tanggal1' AND '$tanggal2'
			GROUP BY a.mesin_bordir, a.shift, c.id
		")->result_array();
		foreach ($q_luar_detail as $r) {
			$luar_detail_map[$r['mesin_bordir'] . '_' . $r['shift'] . '_' . $r['idpemilik']] = [
				'qty' => (float)$r['qty'],
				'total' => (float)$r['total'],
			];
		}
		
		$products = [];
		foreach($mesin as $mes){
			$key = $mes['nomor'] . '_' . $mes['shift'];
			$totalstich = isset($stich_map[$key]) ? $stich_map[$key] : 0;
			$total018 = isset($t018_map[$key]) ? $t018_map[$key] : 0;
			$total02 = isset($t02_map[$key]) ? $t02_map[$key] : 0;
			$total015 = isset($t015_map[$key]) ? $t015_map[$key] : 0;
			$jumlah = isset($jumlah_map[$mes['nomor']]) ? $jumlah_map[$mes['nomor']] : 0;

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
				$key_luar = $p['nomesin'] . '_' . $p['shift'] . '_' . $b['idpemilik'];
				$item_luar = isset($luar_detail_map[$key_luar]) ? $luar_detail_map[$key_luar] : ['total' => 0, 'qty' => 0];
				$nilaiData = $item_luar['total'];
				$qtyData = $item_luar['qty'];

				// Khusus ID 4 (Dedi) : Qty * 900
				if ($b['idpemilik'] == 4) {
					$nilaiData = $qtyData * 900;
				}

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

		$result = [
			'data' => $data_rows,
			'total' => [
				'stich' => $total_stich,
				'total_0_15' => $total_0_15,
				'total_0_18' => $total_0_18,
				'total_luar' => array_sum($total_jumlah_luar),
				'total_jumlah_per_mesin' => $total_jumlah_per_mesin,
				'grand_total' => $grand_total,
				'luar_details' => $total_jumlah_luar
			]
		];

		return $result;

	}

}