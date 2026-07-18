<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Model {

	function __construct() {
	
		parent::__construct();
	}


	function Pendingpo(){
		$pendingkirimsudahpotong=[];
		$data['pendingkirimsudahpotong']=[];
		$pendingkirimsudahpotong=$this->GlobalModel->QueryManual("

		SELECT kp.idpo, kp.kode_po, kp.created_date
			FROM konveksi_buku_potongan kp
			LEFT JOIN finishing_kirim_gudang fk ON kp.idpo = fk.idpo
			WHERE fk.idpo IS NULL 
			AND kp.kode_po NOT LIKE 'BJK%' 
			AND kp.kode_po NOT LIKE 'TEST%' 
			AND kp.kode_po NOT LIKE 'BJF%' 
			AND kp.kode_po NOT LIKE 'AQO%' 
			AND kp.kode_po NOT LIKE 'AQS%' 
			AND kp.kode_po NOT LIKE 'PSL%'
			AND kp.kode_po NOT LIKE 'PUS%'
			AND kp.kode_po NOT LIKE 'POB%'
			AND kp.kode_po NOT LIKE 'BKK%'
			AND kp.created_date < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
			AND kp.created_date >= '2024-05-01'
			ORDER BY kp.created_date ASC,kp.kode_po
		");

		foreach($pendingkirimsudahpotong as $p){
			$data['pendingkirimsudahpotong'][] = array(
				'kode_po' 		=> $p['kode_po'],
				'created_date'	=> $p['created_date'],
				'posisi'		=> $this->posisi($p['idpo']),
			);
		}

		return $data['pendingkirimsudahpotong'];
	}

	/**
	 * Count pending PO only (without fetching posisi for each row)
	 * Used by dashboard summary box to avoid N+1 query problem
	 */
	function PendingpoCount(){
		$sql = "
			SELECT COUNT(*) as total
			FROM konveksi_buku_potongan kp
			LEFT JOIN finishing_kirim_gudang fk ON kp.idpo = fk.idpo
			WHERE fk.idpo IS NULL 
			AND kp.kode_po NOT LIKE 'BJK%' 
			AND kp.kode_po NOT LIKE 'TEST%' 
			AND kp.kode_po NOT LIKE 'BJF%' 
			AND kp.kode_po NOT LIKE 'AQO%' 
			AND kp.kode_po NOT LIKE 'AQS%' 
			AND kp.kode_po NOT LIKE 'PSL%'
			AND kp.kode_po NOT LIKE 'PUS%'
			AND kp.kode_po NOT LIKE 'POB%'
			AND kp.kode_po NOT LIKE 'BKK%'
			AND kp.created_date < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
			AND kp.created_date >= '2024-05-01'
		";
		$data = $this->GlobalModel->QueryManualRow($sql);
		return !empty($data) ? (int)$data['total'] : 0;
	}

	function posisi($idpo){
		$posisi='Dikirim Ke CMT';
		// kirim gudang
		$where = array(
			'idpo' => $idpo,
		);
		
		$kg = $this->GlobalModel->getDataRow('finishing_kirim_gudang',$where);
		if(isset($kg['idpo'])){
			$posisi='Kirim Gudang';
		}

		$whereinsetor = array(
			'idpo' => $idpo,
			'hapus' =>0,
			'progress' => 'SETOR',
			'kategori_cmt' => 'JAHIT',
		);
		// $st = $this->GlobalModel->getDataRow('kelolapo_kirim_setor',$whereinsetor);
		$st = $this->GlobalModel->QueryManualRow("
			SELECT * FROM kelolapo_kirim_setor WHERE hapus=0 AND progress='SETOR'
			AND kategori_cmt='JAHIT' AND idpo='".$idpo."' AND id_master_cmt_job NOT IN(138)
		");
		if(isset($st['idpo'])){
			$posisi='Disetor CMT';
		}

		// $whereinkirim = array(
		// 	'idpo' => $idpo,
		// 	'hapus' =>0,
		// 	'progress' => 'Kirim',
		// 	'kategori_cmt' => 'JAHIT'
		// );
		// $kr = $this->GlobalModel->getDataRow('kelolapo_kirim_setor',$whereinkirim);
		// if(isset($kr['idpo'])){
		// 	$posisi='Kirim CMT';
		// }

		return $posisi;


	}


	// id_produksi_po NOT IN (SELECT idpo FROM finishing_kirim_gudang) and 
	function packing($type){ 
		if($type=='count'){
			$sql ="SELECT COUNT(*) as total FROM `packing` WHERE hapus=0";
			$sql.=" AND date(creted_date) BETWEEN '".date('Y-m-d',strtotime("Monday last week"))."' AND '".date('Y-m-d',strtotime("Saturday this week"))."' ";
			$data = $this->GlobalModel->QueryManualRow($sql);
			return !empty($data) ? (int)$data['total'] : 0;
		}else{
			$sql ="SELECT * FROM `packing` WHERE hapus=0";
			$sql.=" AND date(creted_date) BETWEEN '".date('Y-m-d',strtotime("Monday last week"))."' AND '".date('Y-m-d',strtotime("Saturday this week"))."' ";
			$sql.=" ORDER BY creted_date DESC ";
			$data = $this->GlobalModel->QueryManual($sql);
			echo json_encode($data);
		}
		
	}


	function penerimaancmtmingguini($type=null){
		$tanggal1 = date('Y-m-d', strtotime("tuesday this week"));
		$tanggal2=date('Y-m-d');

		if($type=='count'){
			$sql="SELECT COUNT(*) as total FROM setorcmt a LEFT JOIN setorcmt_detail b on b.idsetor=a.id  LEFT JOIN produksi_po p on p.id_produksi_po=b.kode_po
			 WHERE a.hapus=0 AND a.cmtKat='JAHIT' ";
			$sql.=" AND p.id_produksi_po NOT IN (SELECT idpo FROM finishing_kirim_gudang) ";
			$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			$data = $this->GlobalModel->QueryManualRow($sql);
			return !empty($data) ? (int)$data['total'] : 0;
		}

		$results=[];
		$sql="SELECT a.id as ids_setor, a.tanggal, b.*, p.kode_po as nama_po FROM setorcmt a LEFT JOIN setorcmt_detail b on b.idsetor=a.id  LEFT JOIN produksi_po p on p.id_produksi_po=b.kode_po
		 WHERE a.hapus=0 AND a.cmtKat='JAHIT' ";

		 $sql.=" AND p.id_produksi_po NOT IN (SELECT idpo FROM finishing_kirim_gudang) ";
		
		if(!empty($cmt)){
			$sql.=" AND idcmt='".$cmt."' ";
		}else{
			$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		
		$sql.=" ORDER BY id DESC ";
		$results= $this->GlobalModel->queryManual($sql);
		return $results;
	}


	function ajuanharian($type=null){
		if($type=='count'){
			$sql="SELECT COUNT(*) as total FROM pengajuan_harian_new WHERE hapus=0 AND `status` = '0' AND `tanggal` > '2025-05-01' ";
			$data = $this->db->query($sql)->row_array();
			return !empty($data) ? (int)$data['total'] : 0;
		}
		$sql="SELECT * FROM pengajuan_harian_new WHERE hapus=0 AND  `status` = '0' AND `tanggal` > '2025-05-01' ";
		$data = $this->db->query($sql)->result_array();
		return $data;
	}

	public function kirimgudangjson($jenis,$tgl1,$tgl2){
		$h=0;
		$data=array();
		$h=0;
		$sql="SELECT p.kode_po as nama_po, kbp.tanggal_kirim as creted_date FROM `finishing_kirim_gudang` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) 
		
		WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.tahunpo IS NULL AND mjp.tampil=1 AND kbp.susulan=2 ";
		$sql.=" AND p.hapus=0 ";
		$sql.=" AND lower(kbp.keterangan) NOT IN('kirim sample','po susulan') ";
		if(!empty($tgl1)){
			$sql.=" AND DATE(tanggal_kirim) BETWEEN '".$tgl1."' and '".$tgl2."' ";
		}		
		$data=$this->GlobalModel->QueryManual($sql);
		
		return $data;
	}

	public function kirimsetorjson($jenis,$tanggal1,$tanggal2,$proses){
		$data=[];
		$sql="SELECT p.kode_po as nama_po, kbp.create_date as creted_date  FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis ='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='$proses' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) ";
		$sql.=" AND kbp.id_master_cmt NOT IN(85) ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$sql.=" GROUP BY p.id_produksi_po ";
		$data=$this->GlobalModel->QueryManual($sql);
		return $data;
	}


	function BuangBenang($type){
		$tanggal_awal = date('Y-m-d',strtotime("Saturday last week"));
		$tanggal_akhir = date('Y-m-d',strtotime("Friday this week"));

		if($type=='count'){
			$sql="SELECT COUNT(*) as total FROM buang_benang_finishing WHERE hapus=0 ";
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
			$data=$this->GlobalModel->QueryManualRow($sql);
			return !empty($data) ? (int)$data['total'] : 0;
		}

		$sql="SELECT * FROM buang_benang_finishing WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
		$sql.=" ORDER BY tanggal DESC ";
		$data=$this->GlobalModel->queryManual($sql);
		return $data;
	}

	function Cucian($type){
		$tanggal_awal = date('Y-m-d',strtotime("Saturday last week"));
		$tanggal_akhir = date('Y-m-d',strtotime("Friday this week"));

		if($type=='count'){
			$sql="SELECT COUNT(*) as total FROM cucian WHERE hapus=0 ";
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
			$data=$this->GlobalModel->QueryManualRow($sql);
			return !empty($data) ? (int)$data['total'] : 0;
		}

		$sql="SELECT * FROM cucian WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
		$sql.=" ORDER BY tanggal DESC ";
		$data=$this->GlobalModel->queryManual($sql);
		return $data;
	}

	function borongan($jenis,$type){
		$tanggal_awal = date('Y-m-d',strtotime("Saturday last week"));
		$tanggal_akhir = date('Y-m-d',strtotime("Friday this week"));
		if($jenis==1){
			$title="Lobang Kancing";
			$kategori="LOBANG KANCING";
		}else if($jenis==2){
			$title="Pasang Kancing";
			$kategori="PASANG KANCING";
		}else if($jenis==3){
			$title="Tress";
			$kategori="TRESS";
		}

		if($type=='count'){
			$sql="SELECT COUNT(*) as total FROM boronganmesin WHERE hapus=0 AND kategori='$kategori' ";
			$sql.=" AND date(creted_date) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
			$data=$this->GlobalModel->QueryManualRow($sql);
			return !empty($data) ? (int)$data['total'] : 0;
		}

		$sql="SELECT boronganmesin.*,ki.nama as karyawan FROM boronganmesin JOIN karyawan_harian ki ON(ki.id=boronganmesin.idkaryawanharian) WHERE boronganmesin.hapus=0 and boronganmesin.kategori='$kategori' ";
		$sql.=" AND date(boronganmesin.creted_date) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
		$sql.=" ORDER BY boronganmesin.creted_date DESC ";
		$data=$this->GlobalModel->queryManual($sql);
		return $data;
	}


	function produksi($type,$kategori,$proses){
		$tanggal_awal = date('Y-m-d',strtotime("Monday this week"));
		$tanggal_akhir = date('Y-m-d',strtotime("Saturday this week"));

		if($type=='count'){
			$sql=" SELECT COUNT(*) as total FROM kelolapo_kirim_setor WHERE hapus=0 AND `progress` = '$proses' AND `kategori_cmt` = '$kategori' ";
			$sql.=" AND date(create_date) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
			$data=$this->GlobalModel->QueryManualRow($sql);
			return !empty($data) ? (int)$data['total'] : 0;
		}

		$sql=" SELECT * FROM kelolapo_kirim_setor WHERE hapus=0 AND `progress` = '$proses' AND `kategori_cmt` = '$kategori' ";
		$sql.=" AND date(create_date) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
		$sql.=" ORDER BY create_date DESC ";
		$data=$this->GlobalModel->queryManual($sql);
		return $data;
	}

	function poCMT($type){
		$sql = "SELECT kbp.kode_po as nama_po, kbp.create_date as creted_date, kbp.kategori_cmt as proses, kbp.nama_cmt FROM `kelolapo_kirim_setor` kbp 
				JOIN produksi_po p ON (p.id_produksi_po=kbp.idpo) 
				LEFT JOIN master_jenis_po mjp ON (mjp.nama_jenis_po=p.nama_po) 
				WHERE kbp.kategori_cmt IN ('JAHIT','SABLON') 
				AND kbp.progress='KIRIM' 
				AND kbp.hapus=0 
				AND mjp.tampil=1 
				AND kbp.id_master_cmt NOT IN (63, 85)
				AND p.id_produksi_po NOT IN (SELECT idpo FROM finishing_kirim_gudang) 
				AND NOT EXISTS (
					SELECT 1 FROM kelolapo_kirim_setor kks2 
					WHERE kks2.kode_po = kbp.kode_po 
					AND kks2.kategori_cmt = kbp.kategori_cmt 
					AND kks2.progress = 'SETOR' 
					AND kks2.hapus = 0
				)
		";
		if($type=='count'){
			// For count only, wrap in a count query to avoid fetching all rows
			$countSql = "SELECT COUNT(*) as total FROM ({$sql} GROUP BY kbp.kode_po, kbp.kategori_cmt) as sub";
			$data = $this->GlobalModel->QueryManualRow($countSql);
			return !empty($data) ? (int)$data['total'] : 0;
		}
		$sql .= " GROUP BY kbp.kode_po, kbp.kategori_cmt ";
		$data = $this->GlobalModel->QueryManual($sql);
		return $data;
	}

	/**
	 * Combine BeredarPo(SABLON) + BeredarPo(BORDIR) + KLOPo(kaos) into one efficient query
	 * This replaces 3 separate heavy queries with correlated subqueries
	 */
	function popendingCount(){
		// BeredarPo SABLON: count PO yang kirim sablon tapi belum setor sablon dan belum di-jahit
		$sqlSablon = "
			SELECT COALESCE(COUNT(a.kode_po),0) AS total FROM kelolapo_kirim_setor a 
			LEFT JOIN produksi_po b ON b.kode_po=a.kode_po
			LEFT JOIN master_jenis_po c ON c.nama_jenis_po=b.nama_po 
			WHERE a.hapus=0 AND a.kategori_cmt='SABLON' AND a.progress='KIRIM' AND c.tampil=1
			AND a.kode_po NOT IN (SELECT kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND kategori_cmt != 'SABLON') 
			AND a.kode_po NOT IN (SELECT kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND kategori_cmt = 'SABLON' AND progress='SETOR')
		";
		$dataSablon = $this->GlobalModel->QueryManualRow($sqlSablon);
		$beredarSablon = !empty($dataSablon) ? (int)$dataSablon['total'] : 0;

		// BeredarPo BORDIR
		$sqlBordir = "
			SELECT COALESCE(COUNT(a.kode_po),0) AS total FROM kelolapo_kirim_setor a 
			LEFT JOIN produksi_po b ON b.kode_po=a.kode_po
			LEFT JOIN master_jenis_po c ON c.nama_jenis_po=b.nama_po 
			WHERE a.hapus=0 AND a.kategori_cmt='BORDIR' AND a.progress='KIRIM' AND c.tampil=1
			AND a.kode_po NOT IN (SELECT kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND kategori_cmt != 'BORDIR') 
			AND a.kode_po NOT IN (SELECT kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND kategori_cmt = 'BORDIR' AND progress='SETOR')
		";
		$dataBordir = $this->GlobalModel->QueryManualRow($sqlBordir);
		$beredarBordir = !empty($dataBordir) ? (int)$dataBordir['total'] : 0;

		// KLOPo kaos
		$sqlKlo = "
			SELECT COALESCE(COUNT(a.kode_po)) AS total FROM konveksi_buku_potongan a 
			LEFT JOIN produksi_po b ON b.id_produksi_po=a.idpo
			LEFT JOIN master_jenis_po c ON c.nama_jenis_po=b.nama_po 
			WHERE a.hapus = 0 AND c.tampil = 1 AND c.idjenis='2'
			AND a.kode_po IN (
				SELECT kode_po FROM kelolapo_kirim_setor 
				WHERE hapus = 0 AND kategori_cmt IN ('SABLON') AND progress IN ('SETOR') 
				AND kode_po NOT IN (
					SELECT kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND kategori_cmt='JAHIT'
				)
				GROUP BY kode_po
			)
		";
		$dataKlo = $this->GlobalModel->QueryManualRow($sqlKlo);
		$klo = !empty($dataKlo) ? (int)$dataKlo['total'] : 0;

		return $beredarSablon + $beredarBordir + $klo;
	}

	/**
	 * Count form pengambilan alat menunggu validasi (status=2, bagian=2)
	 * Uses COUNT(*) instead of fetching all rows
	 */
	function formAlatMenungguCount(){
		$sql = "SELECT COUNT(*) as total FROM formpengambilanalat WHERE hapus=0 AND status=2 AND bagian=2";
		$data = $this->GlobalModel->QueryManualRow($sql);
		return !empty($data) ? (int)$data['total'] : 0;
	}
}
