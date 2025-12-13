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


	function packing($type){
		$sql ="SELECT * FROM `packing` WHERE id_produksi_po NOT IN (SELECT idpo FROM finishing_kirim_gudang) and hapus=0";
		$sql.=" AND date(creted_data) BETWEEN '".date('Y-m-d',strtotime("Monday this week"))."' AND '".date('Y-m-d',strtotime("Saturday this week"))."' ";
		$sql.=" ORDER BY creted_data DESC ";
		$data = $this->GlobalModel->QueryManual($sql);
		if($type=='count'){
			return count($data);
		}else{
			echo json_encode($data);
		}
		
	}


	function penerimaancmtmingguini(){
		$results=[];
		$tanggal1 = date('Y-m-d', strtotime("tuesday this week"));
		$tanggal2=date('Y-m-d');
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


	function ajuanharian(){
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
		$sql="SELECT * FROM buang_benang_finishing WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
		$sql.=" ORDER BY tanggal DESC ";
		$data=$this->GlobalModel->queryManual($sql);

		if($type=='count'){
			return count($data);
		}else{
			return $data;
		}
	}

	function Cucian($type){
		$tanggal_awal = date('Y-m-d',strtotime("Saturday last week"));
		$tanggal_akhir = date('Y-m-d',strtotime("Friday this week"));
		$sql="SELECT * FROM cucian WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
		$sql.=" ORDER BY tanggal DESC ";
		$data=$this->GlobalModel->queryManual($sql);
		
		if($type=='count'){
			return count($data);
		}else{
			return $data;
		}
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

		$sql="SELECT boronganmesin.*,ki.nama as karyawan FROM boronganmesin JOIN karyawan_harian ki ON(ki.id=boronganmesin.idkaryawanharian) WHERE boronganmesin.hapus=0 and boronganmesin.kategori='$kategori' ";
		$sql.=" AND date(boronganmesin.creted_date) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
		$sql.=" ORDER BY boronganmesin.creted_date DESC ";
		$data=$this->GlobalModel->queryManual($sql);

		if($type=='count'){
			return count($data);
		}else{
			return $data;
		}


	}


	function produksi($type,$kategori,$proses){
		$tanggal_awal = date('Y-m-d',strtotime("Monday this week"));
		$tanggal_akhir = date('Y-m-d',strtotime("Saturday this week"));
		$sql=" SELECT * FROM kelolapo_kirim_setor WHERE hapus=0 AND `progress` = '$proses' AND `kategori_cmt` = '$kategori' ";
		$sql.=" AND date(create_date) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
		$sql.=" ORDER BY create_date DESC ";
		$data=$this->GlobalModel->queryManual($sql);

		if($type=='count'){
			return count($data);
		}else{
			return $data;
		}


	}

}
