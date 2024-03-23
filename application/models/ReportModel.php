<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->tgl_stokawal='2022-04-30';
		$this->tglperkalianbaru='2022-07-19';
	}

	function crosscek($jenis){
		$hasil=[];
		$query="SELECT * FROM croscek_admin WHERE jenis_laporan='$jenis' ";

		$query.=" ORDER BY id DESC LIMIT 1";
		$data=$this->GlobalModel->QueryManualRow($query);
		if(!empty($data)){
			$hasil=$data;
		}
		return $hasil;
	}

	public function barangkeluar_bulanan($type,$jenis,$bulan,$tahun){
		$hasil=0;
		if($type==1){ // roll
			$sql=" SELECT SUM(jumlah) as total ";
		}else{
			$sql=" SELECT SUM(ukuran) as total "; // yard
		}
		$sql.=" FROM barangkeluar_harian_detail LEFT JOIN product ON product.product_id=barangkeluar_harian_detail.id_persediaan WHERE barangkeluar_harian_detail.hapus=0 AND barangkeluar_harian_detail.jenis=3 AND MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun' AND product.kategori='$jenis' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}
		return $hasil;
	}


	public function uangmakanbordir($idkaryawan,$tanggal1){
		$hasil=0;
		$sql1="SELECT * FROM absensi_bordir ab JOIN absensi_bordir_detail abd ON(ab.id=abd.idabsensi) WHERE DATE(ab.tanggal) ='$tanggal1' AND idkaryawan='$idkaryawan' and ab.hapus=0 AND ab.shift='Malam' AND abd.hapus=0 ";
		$d=$this->GlobalModel->queryManualRow($sql1);
		if(!empty($d)){
			$hasil=3000;
		}
		return $hasil;
	}
	
	public function getumbordir($idkaryawan,$tanggal1,$tanggal2,$tempat){
		$hasil=0;
		$sql1="SELECT count(*) as total FROM absensi_bordir ab JOIN absensi_bordir_detail abd ON(ab.id=abd.idabsensi) WHERE DATE(ab.tanggal) BETWEEN '$tanggal1' AND '$tanggal2' AND idkaryawan='$idkaryawan' and ab.hapus=0 AND ab.shift='Malam' AND abd.hapus=0 AND tempat='$tempat'";
		$d=$this->GlobalModel->queryManualRow($sql1);
		if(!empty($d)){
			$hasil=$d['total']*3000;
		}
		return $hasil;
	}


	public function GetGajipacking($idkaryawan,$tanggal1,$tanggal2){
		$hasil=0;
		$sql1="SELECT SUM(jumlah_pendapatan) as total FROM packing WHERE gaji=1 AND DATE(creted_date) BETWEEN '$tanggal1' AND '$tanggal2' AND idkaryawanharian='$idkaryawan' and hapus=0 ";
		$d=$this->GlobalModel->queryManualRow($sql1);
		if(!empty($d)){
			$hasil=$d['total'];
		}
		return $hasil;
	}

	public function GetGajibb($idkaryawan,$tanggal1,$tanggal2){
		$hasil=0;
		$sql1="SELECT SUM(total) as total FROM buang_benang_finishing WHERE gaji=1 AND DATE(tanggal) BETWEEN '$tanggal1' AND '$tanggal2' AND idkaryawan='$idkaryawan' and hapus=0 ";
		$d=$this->GlobalModel->queryManualRow($sql1);
		if(!empty($d)){
			$hasil=$d['total'];
		}
		return $hasil;
	}

	public function GetGajiCucian($idkaryawan,$tanggal1,$tanggal2){
		$hasil=0;
		$sql1="SELECT SUM(total) as total FROM cucian WHERE jenis=1 and DATE(tanggal) BETWEEN '$tanggal1' AND '$tanggal2' AND idkaryawan='$idkaryawan' and hapus=0 ";
		$d=$this->GlobalModel->queryManualRow($sql1);
		if(!empty($d)){
			$hasil=$d['total'];
		}
		return $hasil;
	}

	public function getGajiBorongan($idkaryawan,$tanggal1,$tanggal2){
		$hasil=0;
		$sql1="SELECT SUM(jumlah_pendapatan*perkalian) as total FROM boronganmesin WHERE gaji=1 AND DATE(creted_date) BETWEEN '$tanggal1' AND '$tanggal2' AND idkaryawanharian='$idkaryawan' and hapus=0 ";
		$d=$this->GlobalModel->queryManualRow($sql1);
		if(!empty($d)){
			$hasil=$d['total'];
		}
		return $hasil;
	}

	
	public function pcs_monitoring_kirimgudang_detail($jenis,$tgl1,$tgl2){
		$h=0;
		$sql="SELECT COALESCE(SUM(jumlah_piece_diterima),0) as total FROM `finishing_kirim_gudang` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.nama_jenis_po='$jenis' ";		
		if(!empty($tgl1)){
			$sql.=" AND DATE(tanggal_kirim) BETWEEN '".$tgl1."' and '".$tgl2."' ";
		}
		$sql.=" AND p.hapus=0 AND kbp.tahunpo IS NULL ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$h=$data['total'];
		}
		return $h;
	}

	public function count_monitoring_kirimgudang_detail($jenis,$tgl1,$tgl2){
		$h=0;
		$sql="SELECT COUNT(DISTINCT kbp.kode_po) as total FROM `finishing_kirim_gudang` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.nama_jenis_po='$jenis' ";
		$sql.=" AND p.hapus=0 AND kbp.tahunpo IS NULL ";
		$sql.=" AND lower(kbp.keterangan) NOT IN('kirim sample','po susulan') ";
		if(!empty($tgl1)){
			$sql.=" AND DATE(tanggal_kirim) BETWEEN '".$tgl1."' and '".$tgl2."' ";
		}		
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$h=$data['total'];
		}
		return $h;
	}

	public function pcs_monitoring_kirimgudang($jenis,$tgl1,$tgl2){
		$h=0;
		$sql="SELECT COALESCE(SUM(jumlah_piece_diterima),0) as total FROM `finishing_kirim_gudang` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis ='$jenis' ";
		if(!empty($tgl1)){
			$sql.=" AND DATE(tanggal_kirim) BETWEEN '".$tgl1."' and '".$tgl2."' ";
		}
		$sql.=" AND p.hapus=0 AND kbp.tahunpo IS NULL AND mjp.tampil=1 ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$h=$data['total'];
		}
		return $h;
	}

	public function count_monitoring_kirimgudang($jenis,$tgl1,$tgl2){
		$h=0;
		$data=array('total'=>0);
		/*
		$sql=" SELECT SUM(jumlah_piece_diterima) as pcs,kg.tanggal_kirim,
		count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,
		SUM(kg.jumlah_harga_piece) as nilai, tujuan, kg.keterangan FROM finishing_kirim_gudang kg  ";
		$sql.=" JOIN produksi_po p ON(p.kode_po=kg.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) ";
		$sql.=" WHERE p.hapus=0 ";
		if(!empty($tgl1)){
			$sql.=" AND DATE(tanggal_kirim) BETWEEN '".$tgl1."' and '".$tgl2."' ";
		}		
		$sql.=" and mjp.idjenis='$jenis' and mjp.tampil=1 ";
		$sql.=" AND lower(kg.keterangan) NOT IN('kirim sample','po susulan') ";
		$sql.=" GROUP BY mjp.nama_jenis_po,kg.tanggal_kirim ";
		$data=$this->GlobalModel->QueryManual($sql);
		if(!empty($data)){
			foreach($data as $d){
				$h+=$d['jml']*$d['perkalian'];
			}
		}
		return $h;
		*/
		$h=0;
		$sql="SELECT COUNT(DISTINCT kbp.kode_po) as total FROM `finishing_kirim_gudang` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) 
		
		WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.tahunpo IS NULL AND mjp.tampil=1 ";
		$sql.=" AND p.hapus=0 ";
		$sql.=" AND lower(kbp.keterangan) NOT IN('kirim sample','po susulan') ";
		if(!empty($tgl1)){
			$sql.=" AND DATE(tanggal_kirim) BETWEEN '".$tgl1."' and '".$tgl2."' ";
		}		
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$h=$data['total'];
		}
		return $h;
	}

	


	public function countdashkirim_monitoring($jenis,$tanggal1,$tanggal2){
		$hasil=null;
		$sql="SELECT count(Distinct kbp.kode_po) as total,mjp.nama_jenis_po,mjp.perkalian FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.nama_jenis_po ='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='KIRIM' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$row=$this->db->query($sql)->row_array();
		$d=$row;
		if($d['total']>0){
			$hasil=$d['total'];
				if($d['nama_jenis_po']=="SKF" OR strtoupper($d['nama_jenis_po'])=="SIMULASI SKF"){
					$hasil=round($d['total']*$d['perkalian']);
				}
		}else{
			$out=0;
			$hasil=$out;
		}
		return $hasil;
	}

	public function countdashsetor_monitoring($jenis,$tanggal1,$tanggal2){
		$hasil=null;
		//$sql="SELECT count(*) as total,mjp.nama_jenis_po,mjp.perkalian FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.nama_jenis_po LIKE '$jenis%' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) ";
		$sql="SELECT count(DISTINCT kbp.kode_po) as total,mjp.nama_jenis_po,mjp.perkalian FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.nama_jenis_po ='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$row=$this->db->query($sql)->row_array();
		$d=$row;
		if($d['total']>0){
			$hasil=$d['total'];
				if($d['nama_jenis_po']=="SKF" OR strtoupper($d['nama_jenis_po'])=="SIMULASI SKF"){
					$hasil=round($d['total']*$d['perkalian']);
				}
			// return ($hasil['total']);
		}else{
			$out=0;
			$hasil=$out;
			//return $out;
		}

		return $hasil;
	}

	public function rpdashkirim_monitoring($jenis,$tanggal1,$tanggal2){
		$hasil=null;
		//$sql="SELECT SUM(qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.nama_jenis_po LIKE '$jenis%' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='KIRIM' AND kbp.hapus=0";
		$sql="SELECT COALESCE(SUM(kbp.qty_tot_pcs),0) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.nama_jenis_po ='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='KIRIM' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$sql.=" AND p.hapus=0 ";
		//$sql.=" GROUP BY kbp.kode_po ";
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}

	public function rpdashsetor_monitoring($jenis,$tanggal1,$tanggal2){
		$hasil=null;	
		// $sql="SELECT COALESCE(SUM(rincian_lusin*12+rincian_piece),0) as total FROM kelolapo_rincian_setor_cmt_finish rpo ";
		// $sql.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po LEFT JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.nama_jenis_po='$jenis' and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0";

		$sql="SELECT COALESCE(SUM(qty_tot_pcs),0) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.nama_jenis_po ='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$sql.=" AND p.hapus=0 ";
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
			/*
				$bangke="SELECT COALESCE(SUM(jml_setor_qty-bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt rpo ";
				$bangke.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po LEFT JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.id_master_cmt='$idcmt' and  mjp.tampil=1 AND kbp.kategori_cmt='$cmtkat' AND kbp.progress='$progress' AND kbp.hapus=0";
				if(!empty($bulan)){
					$bangke.=" AND DATE(kbp.create_date) BETWEEN '".$bulan."' AND '".$tahun."' ";
				}
				$dbangke=$this->db->query($bangke)->row();
				$bangkenya=0;
				if(!empty($dbangke)){
					$bangkenya=$dbangke->total;
				}
			*/
			// $bangke="SELECT COALESCE(SUM(jml_setor_qty-bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt rpo ";
			// $bangke.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po LEFT JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.nama_jenis_po='$jenis' and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0";
			// if(!empty($tanggal1)){
			// 	//$bangke.=" AND DATE(kbp.create_date) BETWEEN '".$bulan."' AND '".$tahun."' ";
			// 	$bangke.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
			// }
			$bangke="SELECT COALESCE(SUM(jml_setor_qty-bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt rpo ";
			$bangke.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po LEFT JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.nama_jenis_po='$jenis' and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0";
			if(!empty($tanggal1)){
				$bangke.=" AND DATE(kbp.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
			$dbangke=$this->db->query($bangke)->row();
			$bangkenya=0;
			if(!empty($dbangke)){
				$bangkenya=$dbangke->total;
			}
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}

	
	
	public function ge($jenis,$type,$tanggal1,$tanggal2){
		$hasil=0;
		if($type==1){
			$sql="SELECT count(DISTINCT kbp.kode_po) as total,mjp.nama_jenis_po,mjp.perkalian FROM konveksi_buku_potongan kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.hapus=0 AND mjp.tampil=1 and mjp.nama_jenis_po = '".$jenis."' ";
		}else if($type==2){
			$sql="SELECT COALESCE(SUM(hasil_lusinan_potongan),0) as total ,mjp.nama_jenis_po,mjp.perkalian FROM konveksi_buku_potongan kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.hapus=0 AND mjp.tampil=1 and mjp.nama_jenis_po = '".$jenis."' ";
		}else{
			$sql="SELECT COALESCE(SUM(hasil_pieces_potongan),0) as total ,mjp.nama_jenis_po,mjp.perkalian FROM konveksi_buku_potongan kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.hapus=0 AND mjp.tampil=1 and mjp.nama_jenis_po = '".$jenis."' ";
		}
		$sql.=" AND kbp.kode_po NOT iN (select kode_po from pogagalproduksi where hapus=0)";
		$sql.=" AND DATE(kbp.created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$d=$this->GlobalModel->queryManualRow($sql);
		if(!empty($d)){
			if($type==1){
				$hasil=$d['total'];
				if($d['nama_jenis_po']=="SKF" OR strtoupper($d['nama_jenis_po'])=="SIMULASI SKF"){
					$hasil=round($d['total']*$d['perkalian']);
				}
				return $hasil;
			}else{
				return $hasil=$d['total'];
			}
			
		}else{
			return $hasil;
		}
		
	}

	public function ge_size($jenis,$type,$tanggal1,$tanggal2){
		$hasil=[];
		if($type==1){
			$sql="SELECT count(DISTINCT kbp.kode_po) as total,mjp.nama_jenis_po,mjp.perkalian, size_potongan FROM konveksi_buku_potongan kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.hapus=0 AND mjp.tampil=1 and mjp.nama_jenis_po = '".$jenis."' ";
		}else if($type==2){
			$sql="SELECT COALESCE(SUM(hasil_lusinan_potongan),0) as total ,mjp.nama_jenis_po,mjp.perkalian, size_potongan FROM konveksi_buku_potongan kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.hapus=0 AND mjp.tampil=1 and mjp.nama_jenis_po = '".$jenis."' ";
		}else{
			$sql="SELECT count(DISTINCT kbp.kode_po) as jml,COALESCE(SUM(hasil_pieces_potongan),0) as total ,mjp.nama_jenis_po,mjp.perkalian, size_potongan FROM konveksi_buku_potongan kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.hapus=0 AND mjp.tampil=1 and mjp.nama_jenis_po = '".$jenis."' ";
		}
		$sql.=" AND kbp.kode_po NOT iN (select kode_po from pogagalproduksi where hapus=0)";
		$sql.=" AND DATE(kbp.created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" GROUP BY size_potongan ";
		$dat=$this->GlobalModel->queryManual($sql);
		if(!empty($dat)){
			foreach($dat as $d){
				// if($type==1){
				// 	$hasil[]=array(
				// 		'size' => $d['size_potongan'],
				// 		'total'=> $d['total'],
				// 	);
				// 	if($d['nama_jenis_po']=="SKF"){
				// 		$hasil[]=round($d['total']*$d['perkalian']);
				// 	}
				// 	//return $hasil;
				// }else{
					$hasil[]=array(
						'size' => $d['size_potongan'],
						'total'=> $d['total'],
						'jml'	=> $d['jml']*$d['perkalian'],
					);
				//}
			}
			
		}else{
			return $hasil;
		}

		return $hasil;
		
	}

	/*
	public function ge($jenis,$type,$tanggal1,$tanggal2){
		$hasil=0;
		if($type==1){
			$sql="SELECT count(*) as total FROM konveksi_buku_potongan  WHERE kode_po LIKE '".$jenis."%' ";
		}else if($type==2){
			$sql="SELECT SUM(hasil_lusinan_potongan) as total FROM konveksi_buku_potongan WHERE kode_po LIKE '".$jenis."%' ";
		}else{
			$sql="SELECT SUM(hasil_pieces_potongan) as total FROM konveksi_buku_potongan WHERE kode_po LIKE '".$jenis."%' ";
		}
		$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$d=$this->GlobalModel->queryManualRow($sql);
		if(!empty($d)){
			return $hasil=$d['total'];
		}else{
			return $hasil;
		}
		
	}
	*/

	function pcsRijek($kode_po,$jenis,$namajenis){
		$query = "SELECT COALESCE(SUM(rpo.pcs),0) as total FROM rijek rpo ";
		$query.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po LEFT JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE   mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0";
		if(!empty($jenis)){
			$query.=" AND mjp.idjenis='$jenis' ";
		}
		
		if(!empty($kode_po)){
			$query .=" AND rpo.kode_po='".$kode_po."'  ";
		}
		$data = $this->GlobalModel->QueryManualRow($query);
		return $data['total'];
	}

	public function getpcsK($kodepo,$kat,$progress){
		$hasil=0;
		$qtykembalianbangke=0;
		$sql="SELECT COALESCE(SUM(qty_tot_pcs),0) as pcs FROM kelolapo_kirim_setor WHERE hapus=0 AND kode_po='$kodepo' AND kategori_cmt='$kat' AND progress='$progress' ";
		$d=$this->GlobalModel->queryManualRow($sql);

			$bangke="SELECT COALESCE(SUM(bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt rpo WHERE rpo.kode_po='".$kodepo."' ";
			$kbangke=$this->db->query("SELECT COALESCE(SUM(qty),0) as total FROM pengembalian_bangke rpo WHERE rpo.kode_po='".$kodepo."' and idpembayaran >554 ")->row();
			if(!empty($kbangke)){
				$qtykembalianbangke=$kbangke->total;
			}
			if(!empty($bulan)){
				$bangke.=" AND DATE(kbp.create_date) BETWEEN '".$bulan."' AND '".$tahun."' ";
			}
			$dbangke=$this->db->query($bangke)->row();
			$bangkenya=0;
			if($progress=='SETOR' && $kat=='JAHIT'){
				// if(!empty($dbangke)){
				// 	$bangkenya=$dbangke->total - $qtykembalianbangke;
				// }
				$rjk=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(pcs),0) as total FROM rijek where kode_po LIKE '%".$kodepo."%' ");
				$bangke=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(rincian_bangke),0) as total FROM kelolapo_rincian_setor_cmt_finish where kode_po LIKE '%".$kodepo."%' ");
				$keterangan_bangke=$this->GlobalModel->QueryManualRow("SELECT created_date,rincian_keterangan as keterangan FROM kelolapo_rincian_setor_cmt_finish where rincian_bangke > 0 AND  kode_po LIKE '%".$kodepo."%' AND rincian_keterangan IS NOT NULL and rincian_keterangan <>'-' ");
				$cmt=$this->GlobalModel->QueryManualRow(" 
					SELECT * FROM kelolapo_rincian_setor_cmt WHERE kode_po LIKE '%".$kodepo."%'
				");
				// $kembali=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(qty),0) as total FROM pengembalian_bangke where hapus=0 and kode_po LIKE '%".$kodepo."%' ");
				// $pot_drikeu=$this->GlobalModel->QueryManualRow("SELECT * FROM potongan_bangke where hapus=0 and kode_po LIKE '%".$kodepo."%' ");
				if(empty($pot_drikeu)){
					// $diterima_seharusnya=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(jumlah_piece_diterima),0) as total FROM kelolapo_rincian_setor_cmt  where kode_po LIKE '%".$kodepo."%' GROUP BY id_kelolapo_rincian_setor_cmt ORDER BY id_kelolapo_rincian_setor_cmt ASC LIMIT 1 ");
					// $bangke=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(rincian_bangke),0) as total FROM kelolapo_rincian_setor_cmt_finish where kode_po LIKE '%".$kodepo."%' ");
					// $kembali=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(rincian_lusin*12)+SUM(rincian_piece+rincian_bangke),0) as total FROM kelolapo_rincian_setor_cmt_finish where kode_po LIKE '%".$kodepo."%' ");
					// $bangkenya = ($diterima_seharusnya['total']+$bangke['total']) - $kembali['total'];
				}else{
					$diterima_seharusnya=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(jumlah_piece_diterima),0) as total FROM kelolapo_rincian_setor_cmt  where kode_po LIKE '%".$kodepo."%' GROUP BY id_kelolapo_rincian_setor_cmt ORDER BY id_kelolapo_rincian_setor_cmt ASC LIMIT 1 ");
					$kembali=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(rincian_lusin*12)+SUM(rincian_piece+rincian_bangke),0) as total FROM kelolapo_rincian_setor_cmt_finish where kode_po LIKE '%".$kodepo."%' ");
					$bangkenya = $kembali['total'];
					//$bangkenya = $bangke['total']-$kembali['total'];
				}
			}

		if(!empty($d)){
		 	$hasil=$d['pcs']-$bangkenya;
		}else{
			$hasil=0;
		}
		return $hasil;
	}

	public function getpcs($kodepo,$table){
		$hasil=0;
		if($table==1){
			$sql="SELECT COALESCE(SUM(hasil_pieces_potongan),0) as pcs FROM konveksi_buku_potongan WHERE kode_po='$kodepo' and hapus=0 ";
		}else if($table==2){
			$sql="SELECT jumlah_total_potongan as pcs FROM kelolapo_pengecekan_potongan WHERE kode_po='$kodepo' ";
		}else if($table==3){
			
		}

		$d=$this->GlobalModel->queryManualRow($sql);
		if(!empty($d)){
			return $hasil=$d['pcs'];
		}else{
			return $hasil;
		}
	}
	public function bonusoperatorbordir($id,$tanggal1,$tanggal2,$tempat){
		$hasil=0;
		$sql="SELECT SUM(abd.bonus) as total from absensi_bordir_detail abd JOIN absensi_bordir ab ON(ab.id=abd.idabsensi) WHERE date(ab.tanggal) BETWEEN '$tanggal1' AND '$tanggal2' AND abd.idkaryawan='$id' AND abd.hapus=0 and ab.tempat='$tempat' ";
		$data=$this->GlobalModel->queryManualRow($sql);
		$hasil=$data['total'];
		return $hasil;
	}

	public function ppcsmingguan($jenis,$tanggal1,$tanggal2){
		
		$hasil=null;
		$sql="SELECT SUM(kbp.hasil_pieces_potongan) as total FROM `konveksi_buku_potongan` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis=$jenis";
		$sql.=" AND DATE(kbp.created_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		$sql.=" AND p.hapus=0 ";
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}

	public function ppcsjmlmingguan($jenis,$tanggal1,$tanggal2){
		$hasil=null;
			$sql="SELECT count(kbp.kode_po) as total FROM `konveksi_buku_potongan` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis=$jenis";
		$sql.=" AND DATE(kbp.created_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		$sql.=" AND p.hapus=0 ";
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}

	public function ppcsjml_filter($jenis,$tanggal1,$tanggal2){
		$hasil=0;
		//$sql="SELECT count(*) as total,mjp.nama_jenis_po,mjp.perkalian FROM konveksi_buku_potongan kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.tampil=1 and mjp.idjenis = '".$jenis."' ";
		$sql="SELECT count(DISTINCT kbp.kode_po) as total,mjp.perkalian,mjp.nama_jenis_po FROM `konveksi_buku_potongan` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis=$jenis AND p.nama_po<>'SKF' and mjp.tampil=1 ";
		$sql.=" AND kbp.kode_po NOT iN (select kode_po from pogagalproduksi where hapus=0)";
		$sql.=" and p.hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row=$this->db->query($sql)->row_array();
		$d=$row;
		if(!empty($d)){
			$hasil=$d['total'];
		}

		$hasil2=0;
		$sql2="SELECT count(DISTINCT kbp.kode_po) as total,mjp.perkalian,mjp.nama_jenis_po FROM `konveksi_buku_potongan` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis=$jenis AND p.nama_po='SKF' and mjp.tampil=1 ";
		$sql2.=" AND kbp.kode_po NOT iN (select kode_po from pogagalproduksi where hapus=0)";
		if(!empty($tanggal1)){
			$sql2.=" AND DATE(kbp.created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row2=$this->db->query($sql2)->row_array();
		$d2=$row2;
		if(!empty($d2)){
			$hasil2=$d2['total']*0.5;
		}

		return $hasil+$hasil2;
	}

	public function ppcs_filter($jenis,$tanggal1,$tanggal2){
		$hasil=null;
		$sql="SELECT COALESCE(SUM(kbp.hasil_pieces_potongan),0) as total FROM `konveksi_buku_potongan` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.hapus=0 AND mjp.idjenis=$jenis and  mjp.tampil=1 ";
		$sql.=" AND kbp.kode_po NOT iN (select kode_po from pogagalproduksi where hapus=0)";
		$sql.=" and p.hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}


	public function ppcsjml($jenis){
		$hasil=null;
		$sql="SELECT count(kbp.kode_po) as total FROM `konveksi_buku_potongan` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis=$jenis AND  mjp.tampil=1 ";
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}

	public function ppcs($jenis){
		$hasil=null;
		$sql="SELECT SUM(kbp.hasil_pieces_potongan) as total FROM `konveksi_buku_potongan` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis=$jenis AND  mjp.tampil=1";
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}

	public function countdashkirim($jenis,$tanggal1,$tanggal2){
		/*
		$hasil=null;
		$sql="SELECT count(*) as total,mjp.nama_jenis_po,mjp.perkalian FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis ='$jenis' ";
		$sql .=" AND kbp.kategori_cmt='JAHIT' AND kbp.progress='KIRIM' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$sql.=" GROUP BY mjp.nama_jenis_po ";
		$row=$this->db->query($sql)->result_array();
		if(!empty($row)){
			foreach($row as $d){
				$hasil+=round($d['total']*$d['perkalian']);
			}
		}else{
			$hasil=0;	
		}
		return $hasil;
		*/
		$hasil=null;
		$sql="SELECT count(Distinct kbp.kode_po) as total,mjp.nama_jenis_po,mjp.perkalian FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis ='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='KIRIM' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$row=$this->db->query($sql)->row_array();
		$d=$row;
		if($d['total']>0){
			$hasil=$d['total'];
				if($d['nama_jenis_po']=="SKF" OR strtoupper($d['nama_jenis_po'])=="SIMULASI SKF"){
					$hasil=round($d['total']*$d['perkalian']);
				}
		}else{
			$out=0;
			$hasil=$out;
		}
		return $hasil;
	}

	public function countdashsetor($jenis,$tanggal1,$tanggal2){
		$hasil=null;
		// $sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0";
		// if(!empty($tanggal1)){
		// 	$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		// }
		// $row=$this->db->query($sql)->row_array();
		// $hasil=$row;
		// if($hasil['total']>0){
		// 	return ($hasil['total']);
		// }else{
		// 	$out=0;
		// 	return $out;
		// }
		$sql="SELECT count(*) as total,mjp.nama_jenis_po,mjp.perkalian FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis ='$jenis' ";
		$sql .=" AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$sql.=" GROUP BY mjp.nama_jenis_po ";
		$row=$this->db->query($sql)->result_array();
		if(!empty($row)){
			foreach($row as $d){
				$hasil+=round($d['total']*$d['perkalian']);
			}
		}else{
			$hasil=0;	
		}
		return $hasil;
	}

	public function rpdashkirim($jenis,$tanggal1,$tanggal2){
		$hasil=null;
		$sql="SELECT SUM(qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='KIRIM' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}

	public function rpdashsetor($jenis,$tanggal1,$tanggal2){
		$hasil=null;
		// $sql="SELECT COALESCE(SUM(rincian_lusin*12+rincian_piece),0) as total FROM kelolapo_rincian_setor_cmt_finish rpo ";
		// $sql.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po LEFT JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0";
		$sql="SELECT SUM(qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;

			$bangke="SELECT COALESCE(SUM(jml_setor_qty-bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt rpo ";
			$bangke.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po LEFT JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0";
			if(!empty($tanggal1)){
				//$bangke.=" AND DATE(kbp.create_date) BETWEEN '".$bulan."' AND '".$tahun."' ";
				$bangke.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
			}
			$dbangke=$this->db->query($bangke)->row();
			$bangkenya=0;
			if(!empty($dbangke)){
				$bangkenya=$dbangke->total;
			}
		if($hasil['total']>0){
			// return ($hasil['total']-$bangkenya);
			// return ($bangkenya);
			return $hasil['total'];
		}else{
			$out=0;
			return $out;
		}
	}

	public function dashpotongpcs($kodepo){
		$hasil=null;
		$sql="SELECT SUM(hasil_pieces_potongan) as total FROM `konveksi_buku_potongan` WHERE kode_po='$kodepo' ";		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return number_format($hasil['total']);
		}else{
			$out='-';
			return $out;
		}
	}

	public function dashkirimgdgpcs($kodepo){
		$out=0;
		$sql="SELECT COALESCE(sum(jumlah_piece_diterima),0) as total FROM `finishing_kirim_gudang` WHERE kode_po='$kodepo' AND tahunpo IS NULL ";		
		$row=$this->GlobalModel->QueryManualRow($sql);
		return (int)$row['total'];
		
	}

	public function selisih($kodepo){
		$potong=0;
		$kirim=0;
		$selisih=0;
		$rijek=0;
		$skirim="SELECT COALESCE(sum(jumlah_piece_diterima),0) as total FROM `finishing_kirim_gudang` WHERE kode_po='$kodepo' ";		
		$kir=$this->GlobalModel->QueryManualRow($skirim);
		if(!empty($kir)){
			$kirim=$kir['total'];
		}
		$spotong="SELECT COALESCE(sum(hasil_pieces_potongan),0) as total FROM konveksi_buku_potongan WHERE kode_po='$kodepo' AND hapus=0 ";		
		$pot=$this->GlobalModel->QueryManualRow($spotong);
		if(!empty($pot)){
			$potong=$pot['total'];
		}

		$sqijek="SELECT COALESCE(sum(pcs),0) as total FROM rijek WHERE kode_po='$kodepo' ";	
		$rjpot=$this->GlobalModel->QueryManualRow($sqijek);
		if(!empty($rjpot)){
			$rijek=$rjpot['total'];
		}

		$bangke=0;
		$sql_bangke="SELECT COALESCE(sum(bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt WHERE kode_po='$kodepo' ";	
		$rbangke=$this->GlobalModel->QueryManualRow($sql_bangke);
		if(!empty($rbangke)){
			$bangke=$rbangke['total'];
		}


		$selisih=($kirim-$potong+$rijek+$bangke);

		return $selisih;

		
		
	}

	function bangke($kodepo){
		$bangke=0;
		$sql_bangke="SELECT COALESCE(sum(bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt WHERE kode_po='$kodepo' ";	
		$rbangke=$this->GlobalModel->QueryManualRow($sql_bangke);
		if(!empty($rbangke)){
			$bangke=$rbangke['total'];
		}
		return $bangke;
	}

	public function globaljmlpotong($data,$timpotong){
		$hasil=null;
		$sql="SELECT count(*) as total FROM `konveksi_buku_potongan` WHERE tim_potong_potongan='".$timpotong."' AND kode_po NOT Like 'SWK%' AND kode_po NOT Like 'SWF%' AND kode_po NOT Like 'SKF%' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return $hasil['total'];
		}else{
			$out='-';
			return $out;
		}
	}

	public function globaljmlpotongpcs($data,$timpotong){
		$hasil=null;
		$sql="SELECT SUM(hasil_pieces_potongan) as total FROM `konveksi_buku_potongan` WHERE tim_potong_potongan='".$timpotong."' AND kode_po NOT Like 'SWK%' AND kode_po NOT Like 'SWF%' AND kode_po NOT Like 'SKF%' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return number_format($hasil['total']);
		}else{
			$out='-';
			return $out;
		}
		//return $sql;
	}

	public function jmlpotong($data,$timpotong,$jenis){
		$hasil=null;
		$sql="SELECT count(*) as total FROM `konveksi_buku_potongan` WHERE tim_potong_potongan='".$timpotong."' and kode_po LIKE'$jenis%' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return $hasil['total'];
		}else{
			$out='-';
			return $out;
		}
		//return $sql;
	}

	public function jmlpotongpcs($data,$timpotong,$jenis){
		$hasil=null;
		$sql="SELECT SUM(hasil_pieces_potongan) as total FROM `konveksi_buku_potongan` WHERE tim_potong_potongan='".$timpotong."' and kode_po LIKE'$jenis%' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return number_format($hasil['total']);
		}else{
			$out='-';
			return $out;
		}
		//return $sql;
	}

	public function jmlpotongsize($data,$timpotong,$jenis,$size){
		$hasil=null;
		$sql="SELECT count(*) as total FROM `konveksi_buku_potongan` WHERE tim_potong_potongan='".$timpotong."' AND kode_po LIKE'$jenis%'  AND size_potongan LIKE'$size%'";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return number_format($hasil['total']);
		}else{
			$out='-';
			return $out;
		}
		//return $sql;
	}

	public function jmlpotongsizepcs($data,$timpotong,$jenis,$size){
		$hasil=null;
		$sql="SELECT SUM(hasil_pieces_potongan) as total FROM `konveksi_buku_potongan` WHERE tim_potong_potongan='".$timpotong."' AND kode_po LIKE'$jenis%'  AND size_potongan LIKE'$size%'";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return number_format($hasil['total']);
		}else{
			$out='-';
			return $out;
		}
		//return $sql;
	}

	// pengecekan potongan 
	public function globalpengecekan($data){
		$hasil=null;
		$sql="SELECT count(kpp.kode_po) as total FROM `kelolapo_pengecekan_potongan` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kbp.kode_po NOT Like 'SWK%' AND kbp.kode_po NOT Like 'SWF%' AND kbp.kode_po NOT Like 'SKF%' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return $hasil['total'];
		}else{
			$out='-';
			return $out;
		}
	}

	public function globalpengecekanpcs($data){
		$hasil=null;
		$sql="SELECT sum(jumlah_total_potongan) as total FROM `kelolapo_pengecekan_potongan` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kbp.kode_po NOT Like 'SWK%' AND kbp.kode_po NOT Like 'SWF%' AND kbp.kode_po NOT Like 'SKF%' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return number_format($hasil['total']);
		}else{
			$out='-';
			return $out;
		}
	}

	public function jumlahpengecekan($data,$jenis){
		$hasil=null;
		$sql="SELECT count(kpp.kode_po) as total FROM `kelolapo_pengecekan_potongan` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kpp.kode_po LIKE '$jenis%' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return $hasil['total'];
		}else{
			$out='-';
			return $out;
		}
	}

	public function jumlahpengecekanpcs($data,$jenis){
		$hasil=null;
		$sql="SELECT SUM(jumlah_total_potongan) as total FROM `kelolapo_pengecekan_potongan` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kpp.kode_po LIKE '$jenis%' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return number_format($hasil['total']);
		}else{
			$out='-';
			return $out;
		}
	}

	public function jumlahpengecekansize($data,$jenis,$size){
		$hasil=null;
		$sql="SELECT count(kpp.kode_po) as total FROM `kelolapo_pengecekan_potongan` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kpp.kode_po LIKE '$jenis%' AND kbp.size_potongan='$size'";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return $hasil['total'];
		}else{
			$out='-';
			return $out;
		}
	}

	public function jumlahpengecekansizepcs($data,$jenis,$size){
		$hasil=null;
		$sql="SELECT SUM(jumlah_total_potongan) as total FROM `kelolapo_pengecekan_potongan` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kpp.kode_po LIKE '$jenis%' AND kbp.size_potongan='$size' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.created_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return number_format($hasil['total']);
		}else{
			$out='-';
			return $out;
		}
	}

	// end pengecekan

	// sablon 
	public function globalsablon($data,$idcmt,$proses,$jobdesk){
		$hasil=null;
		$sql="SELECT count(kpp.kode_po) as total FROM `kelolapo_kirim_setor` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kbp.kode_po NOT Like 'SWK%' AND kbp.kode_po NOT Like 'SWF%' AND kbp.kode_po NOT Like 'SKF%' ";
		$sql.=" AND kpp.id_master_cmt='$idcmt' AND kpp.progress='$proses' AND kpp.kategori_cmt='$jobdesk' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.create_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return $hasil['total'];
		}else{
			$out='-';
			return $out;
		}
	}

	public function globalsablonpcs($data,$idcmt,$proses,$jobdesk){
		$hasil=null;
		$sql="SELECT SUM(kpp.qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kbp.kode_po NOT Like 'SWK%' AND kbp.kode_po NOT Like 'SWF%' AND kbp.kode_po NOT Like 'SKF%' ";
		$sql.=" AND kpp.id_master_cmt='$idcmt' AND kpp.progress='$proses' AND kpp.kategori_cmt='$jobdesk' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.create_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return number_format($hasil['total']);
		}else{
			$out='-';
			return $out;
		}
	}

	public function jumlahsablon($data,$idcmt,$proses,$jobdesk,$jenis){
		$hasil=null;
		$sql="SELECT count(kpp.kode_po) as total FROM `kelolapo_kirim_setor` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kbp.kode_po Like '$jenis%'";
		$sql.=" AND kpp.id_master_cmt='$idcmt' AND kpp.progress='$proses' AND kpp.kategori_cmt='$jobdesk' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.create_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return $hasil['total'];
		}else{
			$out='-';
			return $out;
		}
	}

	public function jumlahsablonpcs($data,$idcmt,$proses,$jobdesk,$jenis){
		$hasil=null;
		$sql="SELECT SUM(kpp.qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kbp.kode_po Like '$jenis%'";
		$sql.=" AND kpp.id_master_cmt='$idcmt' AND kpp.progress='$proses' AND kpp.kategori_cmt='$jobdesk' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.create_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return number_format($hasil['total']);
		}else{
			$out='-';
			return $out;
		}
	}

	public function jumlahsablonsize($data,$idcmt,$proses,$jobdesk,$jenis,$size){
		$hasil=null;
		$sql="SELECT count(kpp.kode_po) as total FROM `kelolapo_kirim_setor` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kbp.kode_po Like '$jenis%' AND kbp.size_potongan='$size' ";
		$sql.=" AND kpp.id_master_cmt='$idcmt' AND kpp.progress='$proses' AND kpp.kategori_cmt='$jobdesk' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.create_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return $hasil['total'];
		}else{
			$out='-';
			return $out;
		}
	}

	public function jumlahsablonsizepcs($data,$idcmt,$proses,$jobdesk,$jenis,$size){
		$hasil=null;
		$sql="SELECT SUM(kpp.qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kpp JOIN konveksi_buku_potongan kbp ON(kpp.kode_po=kbp.kode_po) WHERE kbp.kode_po Like '$jenis%' AND kbp.size_potongan='$size' ";
		$sql.=" AND kpp.id_master_cmt='$idcmt' AND kpp.progress='$proses' AND kpp.kategori_cmt='$jobdesk' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(kpp.create_date) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return number_format($hasil['total']);
		}else{
			$out='-';
			return $out;
		}
	}

	// end sablon
	public function sumkasall($column,$tanggal){
		$sql="SELECT SUM($column) as total FROM aruskas WHERE date(tanggal)='$tanggal'";
		$data=$this->db->query($sql)->row_array();
		return $hasil=$data['total'];
	}

	public function sumkas($column,$tanggal,$bagian){
		$sql="SELECT SUM($column) as total FROM aruskas WHERE date(tanggal)='$tanggal'";
		if(!empty($bagian)){
			$sql.=" and bagian='$bagian' ";
		}
		$data=$this->db->query($sql)->row_array();
		return $hasil=$data['total'];
	}

	public function rekapjml($bulan,$tahun,$idcmt,$cmtkat,$progress){
		$hasil=0;
		// $sql="SELECT COALESCE(count(kelolapo_kirim_setor.kode_po),0) as total, mjp.perkalian FROM `kelolapo_kirim_setor` ";
		// $sql.=" LEFT JOIN produksi_po ON produksi_po.id_produksi_po=kelolapo_kirim_setor.idpo ";
		// $sql.=" LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=produksi_po.nama_po) ";
		// $sql.=" WHERE kelolapo_kirim_setor.hapus=0 AND id_master_cmt=$idcmt AND progress='$progress' ";

		$sql="SELECT count(kbp.kode_po) as total, mjp.perkalian FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.id_master_cmt='$idcmt' AND kbp.progress='$progress' AND kbp.hapus=0 AND mjp.idjenis IN(1,2,3) and mjp.tampil=1 ";
		if(!empty($bulan)){
			$sql.=" AND MONTH(create_date)='$bulan' AND YEAR(create_date) ='$tahun' ";
		}

		if(!empty($cmtkat)){
			$sql.=" AND kategori_cmt='$cmtkat' ";
		}
		
		$sql.=" GROUP BY mjp.perkalian ";
		
		$data=$this->GlobalModel->QueryManual($sql);
		if(!empty($data)){
			foreach($data as $d){
				$hasil+=$d['total']*$d['perkalian'];
			}
		}
		
		return $hasil;
		//return $hasil=$data['total']*$data['perkalian'];
		
	}

	public function rekapjml_tgl($bulan,$tahun,$idcmt,$cmtkat,$progress){
		$hasil=0;
		/*
		$sql="SELECT COALESCE(count(idpo),0) as total, mjp.perkalian FROM `kelolapo_kirim_setor` ";
		$sql.=" LEFT JOIN produksi_po ON produksi_po.id_produksi_po=kelolapo_kirim_setor.idpo ";
		$sql.=" LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=produksi_po.nama_po) ";
		$sql.=" WHERE kelolapo_kirim_setor.hapus=0 AND id_master_cmt=$idcmt AND progress='$progress' ";
		if(!empty($bulan)){
			$sql.=" AND DATE(create_date) BETWEEN '".$bulan."' AND '".$tahun."' ";
		}
		
		$sql.=" GROUP BY mjp.perkalian ";
		if(!empty($cmtkat)){
			$sql.=" AND kategori_cmt='$cmtkat' ";
		}
		$data=$this->GlobalModel->QueryManual($sql);
		if(!empty($data)){
			foreach($data as $d){
				$hasil+=$d['total']*$d['perkalian'];
			}
		}
		*/
		$sql="SELECT count(kbp.kode_po) as total,mjp.nama_jenis_po,mjp.perkalian FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.id_master_cmt='".$idcmt."' ";
		$sql .=" AND kbp.kategori_cmt='$cmtkat' AND kbp.progress='$progress' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) ";
		if(!empty($bulan)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '".$bulan."' AND '".$tahun."' ";
		}
		$sql.=" GROUP BY mjp.nama_jenis_po ";
		$row=$this->db->query($sql)->result_array();
		if(!empty($row)){
			foreach($row as $d){
				$hasil+=round($d['total']*$d['perkalian']);
			}
		}else{
			$hasil=0;	
		}
		
		return $hasil;
		//return $hasil=$data['total']*$data['perkalian'];
		
	}

	public function rekapdz($bulan,$tahun,$idcmt,$cmtkat,$progress){
		$hasil=null;
		$sql="SELECT SUM(qty_tot_pcs) as total FROM `kelolapo_kirim_setor` WHERE hapus=0 AND MONTH(create_date)='$bulan' AND YEAR(create_date) ='$tahun' AND progress='$progress' AND id_master_cmt=$idcmt";
		if(!empty($cmtkat)){
			$sql.=" AND kategori_cmt='$cmtkat' ";
		}
		$data=$this->db->query($sql)->row_array();
		return $hasil=$data['total'];
	}

	public function rekappcs($bulan,$tahun,$idcmt,$cmtkat,$progress){
		$hasil=null;
		$bangkenya=0;
		//$sql="SELECT SUM(qty_tot_pcs) as total FROM `kelolapo_kirim_setor` WHERE hapus=0 AND progress='$progress' AND id_master_cmt=$idcmt";
		$sql="SELECT SUM(kbp.qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp ";
			$sql.=" JOIN produksi_po p ON(p.kode_po=kbp.kode_po) 
					LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po)
				";

			$sql.="WHERE kbp.hapus=0 AND progress='$progress' AND id_master_cmt=$idcmt";
			$sql.=" AND mjp.idjenis IN(1,2,3) and mjp.tampil=1 ";
		if(!empty($bulan)){
			$sql .=" AND MONTH(create_date)='$bulan' AND YEAR(create_date) ='$tahun' ";
		}
		if(!empty($cmtkat)){
			$sql.=" AND kategori_cmt='$cmtkat' ";
		}
		$data=$this->db->query($sql)->row_array();
		if($progress=='SETOR'){
			// bangke 
			//pre($sql);
			$bangke="SELECT COALESCE(SUM(bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt rpo ";
			$bangke.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po LEFT JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.id_master_cmt='$idcmt' AND mjp.idjenis IN(1,2,3) and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='$progress' AND kbp.hapus=0";
			if(!empty($bulan)){
				$bangke .=" AND MONTH(create_date)='$bulan' AND YEAR(create_date) ='$tahun' ";
			}
			$dbangke=$this->db->query($bangke)->row();
			
			if(!empty($dbangke)){
				$bangkenya=$dbangke->total;
			}
		}
		return $hasil=$data['total']-$bangkenya;
	}

	public function rekappcs_tgl($bulan,$tahun,$idcmt,$cmtkat,$progress){
		$hasil=null;
		$sisa=0;
		$bangkenya=0;
			$sql="SELECT SUM(kbp.qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp ";
			$sql.=" JOIN produksi_po p ON(p.kode_po=kbp.kode_po) 
					LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po)
				";

			$sql.="WHERE kbp.hapus=0 AND progress='$progress' AND id_master_cmt=$idcmt";
			$sql.=" AND mjp.idjenis IN(1,2,3) and mjp.tampil=1 ";
			if(!empty($bulan)){
				$sql .=" AND DATE(kbp.create_date) BETWEEN '".$bulan."' AND '".$tahun."' ";
			}
			if(!empty($cmtkat)){
				$sql.=" AND kbp.kategori_cmt='$cmtkat' ";
			}
		if($progress=='SETOR' && $cmtkat=='JAHIT'){
			// bangke 
			
			$bangke="SELECT COALESCE(SUM(jml_setor_qty-bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt rpo ";
			$bangke.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po LEFT JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE kbp.id_master_cmt='$idcmt' and  mjp.tampil=1 AND kbp.kategori_cmt='$cmtkat' AND kbp.progress='$progress' AND kbp.hapus=0";
			if(!empty($bulan)){
				$bangke.=" AND DATE(kbp.create_date) BETWEEN '".$bulan."' AND '".$tahun."' ";
			}
			$dbangke=$this->db->query($bangke)->row();
			$bangkenya=0;
			if(!empty($dbangke)){
				$bangkenya=$dbangke->total;
			}
			

			// $susulan = $this->GlobalModel->QueryManualRow(
			// 	"SELECT COALESCE(SUM(a.jml_setor_qty),0) as total FROM kelolapo_rincian_setor_cmt a
			// 	LEFT JOIN produksi_po b ON b.id_produksi_po=a.idpo
				
			// 	WHERE 1=1 AND mjp.nama_jenis_po=''
			// 	"
			// );


			// // pengembalian bangke
			// $susulan=[];
			// $kembali=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(qty),0) as total FROM pengembalian_bangke where hapus=0 and kode_po LIKE '%".$jenis."%' ");
			// $pot_drikeu=$this->GlobalModel->QueryManualRow("SELECT * FROM potongan_bangke where hapus=0 and kode_po LIKE '%".$jenis."%' ");
			// if(empty($pot_drikeu)){
			// 	$diterima_seharusnya=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(jumlah_piece_diterima),0) as total FROM kelolapo_rincian_setor_cmt  where kode_po LIKE '%".$jenis."%' GROUP BY id_kelolapo_rincian_setor_cmt ORDER BY id_kelolapo_rincian_setor_cmt ASC LIMIT 1 ");
			// 	$bangke=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(rincian_bangke),0) as total FROM kelolapo_rincian_setor_cmt_finish where kode_po LIKE '%".$jenis."%' ");
			// 	$kembali=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(rincian_lusin*12)+SUM(rincian_piece+rincian_bangke),0) as total FROM kelolapo_rincian_setor_cmt_finish where kode_po LIKE '%".$jenis."%'  ");
			// 	$sisa = 0;
			// }else{
			// 	$susulan=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(jumlah_piece_diterima),0) as total FROM kelolapo_rincian_setor_cmt  where kode_po LIKE '%".$jenis."%' GROUP BY id_kelolapo_rincian_setor_cmt LIMIT 18446744073709551615 OFFSET 1");
			// 	// $sisa = $bangke['total']-$kembali['total'];
			// 	$susul = !empty($susulan['total']) ? $susulan['total']:0;
			// 	$sisa = $dbangke->total;
			// }
			
			return $bangkenya;
		}else{
			$data=$this->db->query($sql)->row_array();
			return $hasil=$data['total']-$bangkenya;
		}
		
	}

	public function stockjumlah($data,$idcmt){
		//$sql="SELECT count(*) as total FROM kirimcmt WHERE hapus=0 AND idcmt='$idcmt' and status=0 ";
		$sql="SELECT count(kd.kode_po) as total FROM kirimcmt_detail kd JOIN kirimcmt k ON (k.id=kd.idkirim) WHERE k.hapus=0 AND kd.hapus=0 AND  k.idcmt='$idcmt' AND kd.jumlah_pcs<>kd.totalsetor ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND DATE(k.tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$data=$this->db->query($sql)->row_array();
		$hasil=$data['total'];
		return $hasil;
	}

	public function stockpcs($data,$idcmt){
		$sql="SELECT sum(totalkirim-totalsetor) as total FROM kirimcmt WHERE hapus=0 AND idcmt='$idcmt'";
		if(!empty($data['tanggal1'])){
			$sql.=" AND DATE(tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$data=$this->db->query($sql)->row_array();
		$hasil=$data['total'];
		return $hasil;
	}

	public function Grouptransferkas($data,$table){
		$hasil=array();
		$sql="SELECT tanggal FROM $table WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		$sql.=" GROUP BY tanggal ORDER BY tanggal ASC ";
		$data=$this->db->query($sql)->result_array();
		$hasil=$data;
		return $hasil;
	}

	public function transferkas($tanggal,$bagian){
		$hasil=array();
		$sql="SELECT * FROM transferan WHERE hapus=0 ";
		$sql.=" AND date(tanggal)= '".$tanggal."' ";
		if(!empty($bagian)){
			$sql.=" AND bagian='".$bagian."' ";	
		}
		//$sql.=" AND date(tanggal)= '".$tanggal."' AND bagian='".$bagian."' ";
		$sql.=" ORDER BY tanggal ASC ";
		$data=$this->db->query($sql)->result_array();
		$hasil=$data;
		return $hasil;
	}

	public function oprkas($tanggal,$bagian){
		$hasil=array();
		$sql="SELECT * FROM aruskas WHERE hapus=0 ";
		$sql.=" AND date(tanggal)= '".$tanggal."' ";
		//$sql.=" AND date(tanggal)= '".$tanggal."' AND bagian='".$bagian."' ";
		$sql.=" ORDER BY bagian ASC ";
		$data=$this->db->query($sql)->result_array();
		$hasil=$data;
		return $hasil;
	}

	public function getPOKirimGudang($data){
		$lusin=array();
		$hasil=array();
		//$sql="SELECT * FROM master_jenis_po WHERE status=1 and tampil=1 ";
		$sql="SELECT mjp.* FROM master_jenis_po mjp ";
		$sql.=" LEFT JOIN produksi_po p ON p.nama_po=mjp.nama_jenis_po ";
		$sql .=" WHERE mjp.status=1 and tampil=1 and p.hapus=0 and p.kode_po IN(SELECT kode_po FROM finishing_kirim_gudang) ";
		$sql.=" GROUP BY mjp.nama_jenis_po ";
		$po=$this->db->query($sql)->result_array();
		$periode=$this->periode();
		foreach($po as $p){
			for ($i = 0; $i < 12; $i++) {
		    	$timestamp = mktime(0, 0, 0, $periode['bulan'] + $i, 1,$periode['tahun']);
		    	$bulan=$months[date('n', $timestamp)] = date('n', $timestamp);
		    	$tahun=$yearrs[date('n', $timestamp)] = date('Y', $timestamp);
		    	$sql="SELECT SUM(jumlah_piece_diterima/12) as dz,mjp.nama_jenis_po as nama FROM `finishing_kirim_gudang` kbp JOIN produksi_po po ON (po.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(po.nama_po=mjp.nama_jenis_po) WHERE po.hapus=0 and mjp.nama_jenis_po='".$p['nama_jenis_po']."' and MONTH(kbp.tanggal_kirim) ='".$bulan."' AND YEAR(kbp.tanggal_kirim)='".$tahun."' ";
		    	$d=$this->db->query($sql)->row_array();
		    	$lusin[$p['nama_jenis_po']][]=$d['dz']==null?0:$d['dz'];
			}

			$hasil[]=array(
				'namapo'=>$p['nama_jenis_po'],
				//'lusin'=>implode(",", $lusin),
				'lusin'=>$lusin[$p['nama_jenis_po']],
			);
		}
		return $hasil;
	}

	public function getjumlahpendapatan($mesin,$tgl){
		$sql="SELECT sum(total_stich*0.18) as jumlah FROM `kelola_mesin_bordir`WHERE mesin_bordir='$mesin' AND date(created_date)='$tgl' and hapus=0 and jenis=1 ";
		$d=$this->db->query($sql);
		$row=$d->row();
		return $row->jumlah;
	}

	public function getsumroll($kode_po,$kategori){
		$sql="SELECT SUM(jumlah_item_keluar) as roll FROM `gudang_bahan_keluar` WHERE kode_po='$kode_po' AND bahan_kategori='$kategori' AND hapus=0";
		$d=$this->db->query($sql);
		$row=$d->row();
		return $row;
	}
	public function pendapatanbordir($data,$jenis){
		$sql="SELECT sum(total_stich) as total_stich,shift,mesin_bordir,created_date FROM kelola_mesin_bordir WHERE hapus=0 and jenis=$jenis ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(created_date) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		if(!empty($data['nomesin'])){
			$sql.=" AND mesin_bordir='".$data['nomesin']."' ";
		}
		//$sql.=' GROUP BY mesin_bordir,shift,created_date';
		//$sql.=" ORDER BY mesin_bordir ASC";
		$d=$this->db->query($sql);
		return $d->result_array();
	}
	public function pendapatanbordirall($data){
		$sql="SELECT COALESCE(sum(total_stich),0) as total_stich,shift,mesin_bordir,created_date FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1";
		if(isset($data['bulan'])){
			$sql .=" AND MONTH(created_date)='".$data['bulan']."' AND YEAR(created_date)='".$data['tahun']."' ";
		}else{
			if(!empty($data['tanggal1'])){
				$sql.=" AND date(created_date) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
			}
			if(!empty($data['nomesin'])){
				$sql.=" AND mesin_bordir='".$data['nomesin']."' ";
			}
		}
		
		$sql.=' GROUP BY mesin_bordir,shift,created_date';
		$sql.=" ORDER BY mesin_bordir ASC";
		$d=$this->db->query($sql);
		return $d->result_array();
	}
	public function potongan($data){
		// $sql="SELECT kbp.*, mjp.nama_jenis_po as nama_po FROM konveksi_buku_potongan kbp ";
		$sql =" SELECT kbp.*, mjp.nama_jenis_po as nama_po ";
		$sql.="  FROM konveksi_buku_potongan kbp ";
		
		$sql.=" JOIN produksi_po p ON p.id_produksi_po=kbp.idpo ";
		$sql.=" JOIN master_jenis_po mjp ON mjp.nama_jenis_po=p.nama_po ";
		$sql.=" WHERE kbp.hapus=0 ";
		$sql.=" AND kbp.kode_po NOT LIKE 'BJF%' ";
		$sql.=" AND kbp.kode_po NOT LIKE 'BJK%' ";

		if(!empty($data['tim'])){
			$sql.=" AND tim_potong_potongan ='".$data['tim']."' ";
		}

		if(!empty($data['jenis'])){
			 $sql.=" AND kbp.kode_po LIKE '".$data['jenis']."%' ";
			if(!empty($data['tanggal1'])){
				$sql.=" AND date(kbp.created_date) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
			}
		}else{
			if(!empty($data['tanggal1'])){
				$sql.=" AND date(kbp.created_date) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
			}
		}
		// $sql.=" GROUP BY kbp.kode_po ";
		$sql.=" ORDER BY date(kbp.created_date) ASC, kbp.kode_po ASC ";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	public function getangkapotongan($kode_po){
		$hasil=0;
		$d=$this->GlobalModel->QueryManualRow("SELECT SUM(hasil_lusinan_potongan) as lusin FROM konveksi_buku_potongan WHERE hapus=0 AND kode_po='".$kode_po."' ");
		return !empty($d)?$d['lusin']:0;
	}

	public function getPO($data){
		$lusin=array();
		$hasil=array();
		$sql="SELECT mjp.* FROM master_jenis_po mjp ";
		$sql.=" LEFT JOIN produksi_po p ON p.nama_po=mjp.nama_jenis_po ";
		$sql .=" WHERE mjp.status=1 and tampil=1 and p.hapus=0 and p.kode_po IN(SELECT kode_po FROM konveksi_buku_potongan) ";
		$sql.=" GROUP BY mjp.nama_jenis_po ";
		$po=$this->db->query($sql)->result_array();
		$periode=$this->periode();
		foreach($po as $p){
			for ($i = 0; $i < 12; $i++) {
		    	$timestamp = mktime(0, 0, 0, $periode['bulan'] + $i, 1,$periode['tahun']);
		    	$bulan=$months[date('n', $timestamp)] = date('n', $timestamp);
		    	$tahun=$yearrs[date('n', $timestamp)] = date('Y', $timestamp);
		    	$sql="SELECT SUM(hasil_lusinan_potongan) as dz,mjp.nama_jenis_po as nama FROM `konveksi_buku_potongan` kbp JOIN produksi_po po ON (po.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(po.nama_po=mjp.nama_jenis_po) WHERE po.hapus=0 and mjp.nama_jenis_po='".$p['nama_jenis_po']."' and MONTH(kbp.created_date) ='".$bulan."' AND YEAR(kbp.created_date)='".$tahun."' ";
		    	$d=$this->db->query($sql)->row_array();
		    	$lusin[$p['nama_jenis_po']][]=$d['dz']==null?0:$d['dz'];
			}

			$hasil[]=array(
				'namapo'=>$p['nama_jenis_po'],
				//'lusin'=>implode(",", $lusin),
				'lusin'=>$lusin[$p['nama_jenis_po']],
			);
		}
		return $hasil;
	}

	public function month(){
		$months = array();
		$periode=$this->periode();
		for ($i = 0; $i < 12; $i++) {
		    $timestamp = mktime(0, 0, 0, $periode['bulan'] + $i, 1,$periode['tahun']); // angka 6 bulan juni, periode awal potongan
		    $bulan[]=$months[date('n', $timestamp)] = date('M Y', $timestamp);
		}
		
		return $bulan;
	}

	public function periode(){
		$hasil=array();
		$data=$this->GlobalModel->getDataRow('periodeproduksi',array());
		return $data;
	}

	public function rekapkirim($jenis,$bulan,$tahun){
		$hasil=null;
		$sql="SELECT SUM(qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='KIRIM' AND kbp.hapus=0";
		if(!empty($bulan)){
			$sql.=" AND MONTH(create_date)='$bulan' AND YEAR(create_date) ='$tahun' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}

	public function rekapsetor($jenis,$bulan,$tahun){
		$hasil=null;
		$sql="SELECT SUM(qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0";
		if(!empty($bulan)){
			$sql.=" AND MONTH(create_date)='$bulan' AND YEAR(create_date) ='$tahun' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}

	public function hkirim($jenis,$bulan,$tahun){
		$hasil=null;
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='KIRIM' AND kbp.hapus=0";
		if(!empty($bulan)){
			$sql.=" AND MONTH(create_date)='$bulan' AND YEAR(create_date) ='$tahun' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}

	public function hsetor($jenis,$bulan,$tahun){
		$hasil=null;
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.progress='SETOR' AND kbp.hapus=0";
		if(!empty($bulan)){
			$sql.=" AND MONTH(create_date)='$bulan' AND YEAR(create_date) ='$tahun' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}

	public function getPotonganP(){
		$lusin=array();
		$hasil=array();
		$sql="SELECT * FROM master_jenis_po WHERE status=1 and tampil=1 GROUP BY idjenis ";
		$po=$this->db->query($sql)->result_array();
		$periode=$this->periode();
		foreach($po as $p){
			for ($i = 0; $i < 12; $i++) {
		    	$timestamp = mktime(0, 0, 0, $periode['bulan'] + $i, 1,$periode['tahun']);
		    	$bulan=$months[date('n', $timestamp)] = date('n', $timestamp);
		    	$tahun=$yearrs[date('n', $timestamp)] = date('Y', $timestamp);
		    	$sql="SELECT SUM(hasil_lusinan_potongan) as dz,mjp.nama_jenis_po as nama FROM `konveksi_buku_potongan` kbp JOIN produksi_po po ON (po.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(po.nama_po=mjp.nama_jenis_po) WHERE po.hapus=0 and mjp.idjenis='".$p['idjenis']."' and MONTH(kbp.created_date) ='".$bulan."' AND YEAR(kbp.created_date)='".$tahun."' ";
		    	$d=$this->db->query($sql)->row_array();
		    	$lusin[$p['nama_jenis_po']][]=$d['dz']==null?0:number_format($d['dz'],2,'.','');
			}
			if($p['idjenis']==1){
				$je='kemeja';
			}else if($p['idjenis']==2){
				$je='kaos';
			}else{
				$je='Celana';
			}
			$hasil[]=array(
				'namapo'=>$je,
				//'lusin'=>implode(",", $lusin),
				'lusin'=>$lusin[$p['nama_jenis_po']],
			);
		}
		return $hasil;
	}


	public function monitoring_jml($nama,$proses){
		$hasil=0;
		//$sql="SELECTs COUNT(proses_po.kode_po) as total FROM proses_po WHERE hapus=0 and namapo='$nama' and proses='$proses' ";
		$sql="
			SELECT COUNT(proses_po.kode_po) as total
			FROM proses_po
			LEFT JOIN produksi_po ON produksi_po.kode_po = proses_po.kode_po
			WHERE produksi_po.nama_po = '$nama' AND produksi_po.hapus = 0 and proses_po.proses='$proses' 
		";
		if($proses==1){
			$sql .=" AND proses_po.proses IN(2,3,4,5,6,7,8,9,11) ";
		}else if($proses==9){
			$sql .=" AND proses_po.proses IN(1,2,3,4,5,6,7,8,11) ";
		}else if($proses==10){
			$sql .=" AND proses_po.proses IN(1,2,3,4,5,6,7,8,11) ";
		}
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}

		return $hasil;
	}

	public function monitoring_jmlall($nama){
		$hasil=0;
		$sql="SELECT COUNT(DISTINCT proses_po.kode_po) as total
		FROM proses_po
		LEFT JOIN produksi_po ON produksi_po.kode_po = proses_po.kode_po
		WHERE produksi_po.nama_po = '$nama' AND proses_po.hapus = 0 AND produksi_po.hapus = 0
		
		 ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}

		return $hasil;
	}

	public function monitoring_jml_details($nama){
		$hasil=[];
		$sql="SELECT * FROM proses_po WHERE namapo='$nama' and hapus=0 ";
		$data=$this->GlobalModel->QueryManual($sql);
		if(!empty($data)){
			$hasil=$data;
		}

		return $hasil;
	}

	public function ppcs_filter_global($jenis,$tanggal1,$tanggal2){
		$hasil=null;
		$sql="SELECT SUM(kbp.hasil_pieces_potongan) as total FROM `konveksi_buku_potongan` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis=$jenis and  mjp.tampil=1 ";
		$sql.=" and p.hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']);
		}else{
			$out=0;
			return $out;
		}
	}
	
	public function totalStich($nomor,$shift,$tanggal1,$tanggal2){
		$total=0;
		$sql="SELECT COALESCE(SUM(total_stich),0) as total FROM kelola_mesin_bordir WHERE hapus=0";
		$sql.= " AND mesin_bordir='$nomor' AND shift='$shift' ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($row)){
			$total=$row['total'];
		}
		return $total;
	}

	public function totalStich_bulan($nomor,$shift,$bulan,$tahun){
		$total=0;
		$sql="SELECT COALESCE(SUM(total_stich),0) as total FROM kelola_mesin_bordir WHERE hapus=0";
		$sql.= " AND mesin_bordir='$nomor' AND shift='$shift' ";
		if(!empty($bulan)){
			$sql.=" AND MONTH(created_date) = '".$bulan."' AND YEAR(created_date)='".$tahun."' ";
		}
		$row=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($row)){
			$total=$row['total'];
		}
		return $total;
	}

	public function total018_bulan($nomor,$shift,$bulan,$tahun,$jenis,$perkalian){
		$total=0;
		if($jenis==1){
			$sql="SELECT COALESCE(SUM(total_stich*$perkalian),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis='".$jenis."' ";
		}else if($jenis==2){
			$sql="SELECT COALESCE(sum(total_stich*laporan_perkalian_tarif),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=2 ";
		}else{
			$sql="SELECT COALESCE(SUM(total_stich*$perkalian),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis IN(1,2) ";
		}
		
		$sql.= " AND mesin_bordir='$nomor' AND mesin_bordir<>11 AND shift='$shift' ";
		if(!empty($bulan)){
			$sql.=" AND MONTH(created_date) = '".$bulan."' AND YEAR(created_date)='".$tahun."' ";
		}
		
		$row=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($row)){
			$total=$row['total'];
		}
		return $total;
	}

	public function total018($nomor,$shift,$tanggal1,$tanggal2){
		$total=0;
		$sql="SELECT COALESCE(SUM(total_stich*0.18),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 ";
		$sql.= " AND mesin_bordir='$nomor' AND mesin_bordir<>11 AND shift='$shift' ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($row)){
			$total=$row['total'];
		}
		return $total;
	}

	public function total02($nomor,$shift,$tanggal1,$tanggal2){
		$total=0;
		$sql="SELECT COALESCE(sum(total_stich*laporan_perkalian_tarif),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=2 ";
		$sql.= " AND mesin_bordir='$nomor' AND shift='$shift' ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row=$this->GlobalModel->QueryManualRow($sql);
		//pre($sql);
		if(!empty($row)){
			$total=$row['total'];
		}
		return $total;
	}

	

	public function total02_array_bulan($nomor,$shift,$tanggal1,$tanggal2){
		$total=['total'=>0,'0.2'=>0,'0.3'=>0];
		$sql="SELECT COALESCE(sum(total_stich*laporan_perkalian_tarif),0) as total,laporan_perkalian_tarif as tarif FROM kelola_mesin_bordir WHERE hapus=0 and jenis=2 ";
		$sql.= " AND mesin_bordir='$nomor' AND shift='$shift' ";
		if(!empty($bulan)){
			$sql.=" AND MONTH(created_date)='".$tanggal1."' AND YEAR(created_date)='".$tahun."' ";
		}
		$sql.=" AND laporan_perkalian_tarif IS NOT NULL GROUP BY laporan_perkalian_tarif ";
		$row=$this->GlobalModel->QueryManual($sql);
		//pre($sql);
		$tarif=0;
		if(!empty($row)){
			foreach($row as $r){
				$total[$r['tarif']]=$r['total'];
			}
		}
		return $total;
	}

	public function total02_array($nomor,$shift,$tanggal1,$tanggal2,$pemilik){
		//$total=['total'=>0,'0.2'=>0,'0.3'=>0];
		$sql="
		SELECT ROUND(COALESCE(SUM(a.total_stich * a.laporan_perkalian_tarif), 0), 0) as total, a.laporan_perkalian_tarif as tarif
		FROM kelola_mesin_bordir a
		LEFT JOIN master_po_luar b ON b.id=a.kode_po
		LEFT JOIN pemilik_poluar c ON c.id=b.idpemilik
		WHERE a.hapus=0 and a.jenis=2 ";
		$sql.= " AND a.mesin_bordir='$nomor' AND shift='$shift' ";
		if(!empty($tanggal1)){
			//$sql.=" AND DATE(a.created_date)='".$tanggal1."'";
			$sql.=" AND DATE(a.created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		if(!empty($pemilik)){
			$sql.=" AND c.id='".$pemilik."' ";
		}
		$sql.=" AND laporan_perkalian_tarif IS NOT NULL ";
		$row=$this->GlobalModel->QueryManual($sql);
		//pre($sql);
		$tarif=0;
		if(!empty($row)){
			foreach($row as $r){
				$total['data']=$r['total'];
			}
		}
		return $total;
	}

	public function total02sql($nomor,$shift,$tanggal1,$tanggal2){
		$total=0;
		if($tanggal2>=$this->tglperkalianbaru){
			$perkalian=0.3;
		}else{
			$perkalian=0.2;
		}
		$sql="SELECT COALESCE(sum(total_stich*laporan_perkalian_tarif),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=2 ";
		$sql.= " AND mesin_bordir='$nomor' AND shift='$shift' ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row=$this->GlobalModel->QueryManualRow($sql);
		//pre($sql);
		if(!empty($row)){
			$total=$row['total'];
		}
		return $sql;
	}

	public function total015($nomor,$shift,$tanggal1,$tanggal2){
		$total=0;
		$sql="SELECT COALESCE(SUM(total_stich*0.15),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis IN(1,2) ";
		$sql.= " AND mesin_bordir='$nomor' AND shift='$shift' ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($row)){
			$total=$row['total'];
		}
		return $total;
	}

	public function jumlahpendapatanbordir($nomor,$tanggal1,$tanggal2){
		$hasil=0;
		$total1=0;
		//$sql1="SELECT SUM(total_stich*0.18) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 AND perkalian_tarif LIKE '%0.18%' ";
		$sql1="SELECT COALESCE(SUM(total_stich*0.18),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 ";
		$sql1.= " AND mesin_bordir='$nomor'";
		if(!empty($tanggal1)){
			$sql1.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row1=$this->GlobalModel->QueryManualRow($sql1);
		if(!empty($row1)){
			$total1=$row1['total'];
		}

		$total2=0;
		//$sql2="SELECT SUM(total_stich*0.2) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=2 AND perkalian_tarif LIKE '%0.2%' ";
		if($tanggal2>=$this->tglperkalianbaru){
			$perkalian=0.3;
		}else{
			$perkalian=0.2;
		}
		$sql2="SELECT COALESCE(SUM(total_stich*laporan_perkalian_tarif),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=2 ";
		$sql2.= " AND mesin_bordir='$nomor'";
		if(!empty($tanggal1)){
			$sql2.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row2=$this->GlobalModel->QueryManualRow($sql2);
		if(!empty($row2)){
			$total2=$row2['total'];
		}

		$total3=0;
		//$sql3="SELECT SUM(total_stich*0.15) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 AND perkalian_tarif LIKE '%0.15%' ";
		$sql3="SELECT COALESCE(SUM(total_stich*0.15),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis IN(1,2) ";
		$sql3.= " AND mesin_bordir='$nomor'";
		if(!empty($tanggal1)){
			$sql3.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$row3=$this->GlobalModel->QueryManualRow($sql3);
		if(!empty($row3)){
			//$total3=$row3['total'];
		}
		$hasil=($total1+$total2+$total3);
		return $hasil;
	}

	public function jumlahpendapatanbordir_bulan($nomor,$bulan,$tahun){
		$hasil=0;
		$total1=0;
		//$sql1="SELECT SUM(total_stich*0.18) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 AND perkalian_tarif LIKE '%0.18%' ";
		$sql1="SELECT COALESCE(SUM(total_stich*0.18),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 ";
		$sql1.= " AND mesin_bordir='$nomor'";
		if(!empty($bulan)){
			$sql1.=" AND MONTH(created_date)='".$bulan."' AND YEAR(created_date)='".$tahun."' ";
		}
		$row1=$this->GlobalModel->QueryManualRow($sql1);
		if(!empty($row1)){
			$total1=$row1['total'];
		}

		$total2=0;
		//$sql2="SELECT SUM(total_stich*0.2) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=2 AND perkalian_tarif LIKE '%0.2%' ";
		$sql2="SELECT COALESCE(SUM(total_stich*laporan_perkalian_tarif),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=2 ";
		$sql2.= " AND mesin_bordir='$nomor'";
		if(!empty($bulan)){
			$sql2.=" AND MONTH(created_date)='".$bulan."' AND YEAR(created_date)='".$tahun."' ";
		}
		$row2=$this->GlobalModel->QueryManualRow($sql2);
		if(!empty($row2)){
			$total2=$row2['total'];
		}

		$total3=0;
		//$sql3="SELECT SUM(total_stich*0.15) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 AND perkalian_tarif LIKE '%0.15%' ";
		$sql3="SELECT COALESCE(SUM(total_stich*0.15),0) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis IN(1,2) ";
		$sql3.= " AND mesin_bordir='$nomor'";
		if(!empty($bulan)){
			$sql3.=" AND MONTH(created_date)='".$bulan."' AND YEAR(created_date)='".$tahun."' ";
		}
		$row3=$this->GlobalModel->QueryManualRow($sql3);
		if(!empty($row3)){
			//$total3=$row3['total'];
		}
		$hasil=($total1+$total2+$total3);
		return $hasil;
	}

	public function pendapatanbordirdalam($data,$jenis){
		$sql="SELECT COALESCE(sum(total_stich),0) as total_stich FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 and perkalian_tarif LIKE '%0.18%' ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(created_date) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		if(!empty($data['nomesin'])){
			$sql.=" AND mesin_bordir='".$data['nomesin']."' ";
		}
		$d=$this->db->query($sql);
		return $d->result_array();
	}

	public function pendapatanbordirdalam15($data,$jenis){
		$sql="SELECT COALESCE(sum(total_stich),0) as total_stich FROM kelola_mesin_bordir WHERE hapus=0 AND mesin_bordir=11 ";
		if(isset($data['bulan'])){
			$sql.=" AND MONTH(created_date)='".$data['bulan']."' AND  YEAR(created_date)='".$data['tahun']."' ";
		}else{
			if(!empty($data['tanggal1'])){
				$sql.=" AND date(created_date) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
			}
		}
		
		$d=$this->db->query($sql);
		return $d->result_array();
	}

	public function stokawal($id,$tgl){
		$date=$this->tgl_stokawal;
		$tglendstok=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $tgl) ) ));
		$hasil=array('roll'=>0,'yard'=>0,'harga'=>0);
		$sql = "SELECT SUM(pid.ukuran) as yard,SUM(pid.jumlah) as roll,pid.harga FROM penerimaan_item_detail pid JOIN penerimaan_item pi ON(pi.id=pid.penerimaan_item_id) WHERE pi.hapus=0";
		$sql.=" AND id_persediaan='$id' AND DATE(pi.tanggal) < '".$tgl."' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			if($tglendstok=='2022-05-31'){
				$hasil=array(
					'roll'=>14,
					'yard'=>14,
				);
			}else{
				//$sqlhistrory="SELECT saldoawal_uk as yard, saldoawal_qty as roll FROM kartustok_product WHERE idproduct='$id' ";
				$sqlhistrory="SELECT sisa_uk as yard, sisa_qty as roll FROM kartustok_product WHERE idproduct='$id' ";
				// $sqlhistrory.=" AND DATE(tanggal) < '$tglendstok' ";
				$sqlhistrory.=" AND DATE(tanggal) <= '$tglendstok' ";
				$sqlhistrory.=" ORDER BY id DESC limit 1 ";
				$ds=$this->GlobalModel->QueryManualRow($sqlhistrory);
				if(!empty($ds)){
					$hasil=$ds;
				}
				//pre($hasil);
			}
			
		}
		return $hasil;
	}

	public function stokmasuk($id,$tgl,$tgl2){
		$hasil=array('roll'=>0,'yard'=>0,'harga'=>0);
		$sql = "SELECT SUM(pid.ukuran) as yard,SUM(pid.jumlah) as roll,pid.harga FROM penerimaan_item_detail pid JOIN penerimaan_item pi ON(pi.id=pid.penerimaan_item_id) WHERE pi.hapus=0 AND pid.hapus=0";
		$sql.=" AND id_persediaan='$id' AND DATE(pi.tanggal) BETWEEN '".$tgl."' AND '".$tgl2."' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d;
		}
		return $hasil;
	}

	public function stokmasuk_bulanan($id,$bulan,$tahun){
		$hasil=array('roll'=>0,'yard'=>0,'harga'=>0);
		$sql = "SELECT SUM(pid.ukuran) as yard,SUM(pid.jumlah) as roll,pid.harga FROM penerimaan_item_detail pid JOIN penerimaan_item pi ON(pi.id=pid.penerimaan_item_id) WHERE pi.hapus=0 AND pid.hapus=0";
		$sql.=" AND id_persediaan='$id' AND YEAR(pi.tanggal)='".$tahun."' AND MONTH(pi.tanggal)='".$bulan."' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d;
		}
		return $hasil;
	}

	public function stokkeluar_bulanan($id,$bulan,$tahun){
		$hasil=array('roll'=>0,'yard'=>0,'harga'=>0);
		$sql = "SELECT SUM(pid.ukuran) as yard,SUM(pid.jumlah) as roll,pid.harga FROM barangkeluar_harian_detail pid JOIN barangkeluar_harian pi ON(pi.id=pid.idbarangkeluar) WHERE pi.hapus=0 AND pid.hapus=0";
		if(!empty($tgl)){
			$sql.=" AND id_persediaan='$id' AND DATE(pi.tanggal) BETWEEN '".$tgl."' AND '".$tgl2."' ";
		}

		if(!empty($bulan)){
			$sql.=" AND id_persediaan='$id' AND MONTH(pi.tanggal)='".$bulan."' AND YEAR(pi.tanggal)='".$tahun."' ";
		}
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d;
		}
		return $hasil;
	}

	public function stok_akhir_bahan($id){
		$query = "SELECT ukuran_item as yard, jumlah_item as roll FROM gudang_persediaan_item WHERE id_persediaan='$id' ";
		return $this->GlobalModel->QueryManualRow($query);
	}

	public function stokkeluar($id,$tgl,$tgl2){
		$hasil=array('roll'=>0,'yard'=>0,'harga'=>0);
		$sql = "SELECT SUM(pid.ukuran) as yard,SUM(pid.jumlah) as roll,pid.harga FROM barangkeluar_harian_detail pid JOIN barangkeluar_harian pi ON(pi.id=pid.idbarangkeluar) WHERE pi.hapus=0 AND pid.hapus=0";
		$sql.=" AND id_persediaan='$id' AND DATE(pi.tanggal) BETWEEN '".$tgl."' AND '".$tgl2."' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d;
		}
		return $hasil;
	}

	public function pcs_monitoring_kirimgudang_harga($jenis,$tgl1,$tgl2){
		$h=0;
		$sql="SELECT COALESCE(SUM(kbp.jumlah_piece_diterima*kbp.harga_satuan),0) as total FROM `finishing_kirim_gudang` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis ='$jenis' ";	
		if(!empty($tgl1)){
			$sql.=" AND DATE(tanggal_kirim) BETWEEN '".$tgl1."' and '".$tgl2."' ";
		}	
		$sql.=" AND p.hapus=0 AND kbp.tahunpo IS NULL AND mjp.tampil=1 ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$h=$data['total'];
		}
		return $h;
	}

	public function pcs_monitoring_kirimgudang_harga_det($jenis,$tgl1,$tgl2){
		$h=0;
		$sql="SELECT COALESCE(SUM(kbp.jumlah_piece_diterima*kbp.harga_satuan),0) as total FROM `finishing_kirim_gudang` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.id_jenis_po ='$jenis' ";	
		$sql.=" AND p.hapus=0 AND kbp.tahunpo IS NULL ";
		if(!empty($tgl1)){
			$sql.=" AND DATE(tanggal_kirim) BETWEEN '".$tgl1."' and '".$tgl2."' ";
		}	
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$h=$data['total'];
		}
		return $h;
	}

	public function stokawal_alat($id,$tgl){
		//$hasil=array('roll'=>0,'yard'=>0,'harga'=>0);
		/*$sql = "SELECT SUM(pid.jumlah) as total,pid.harga FROM penerimaan_item_detail pid JOIN penerimaan_item pi ON(pi.id=pid.penerimaan_item_id) WHERE pi.hapus=0";
		$sql.=" AND id_persediaan='$id' AND DATE(pi.tanggal) < '".$tgl."' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d['total'];
		}
		$hasil2=0;
		$sql2="SELECT SUM(jumlah) as total FROM barangkeluarharian_detail WHERE hapus=0 AND idpersediaan='$id' ";
		$sql2.=" AND DATE(tanggal) < '".$tgl."' ";
		$s2=$this->GlobalModel->QueryManualRow($sql2);
		if(!empty($s2)){
			$hasil2=$s2['total'];
		}*/
		$hasil=0;
		$total=0;
		$sql = "SELECT (sisa_qty) as total FROM kartustok_product WHERE hapus=0";
		$sql.=" AND idproduct='$id' AND DATE(tanggal) < '".$tgl."' ORDER BY tanggal DESC LIMIT 1";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d['total'];
		}
		$hasil;
		return $hasil;
	}

	public function stokmasuk_alat($id,$tgl,$tgl2){
		$hasil=array('roll'=>0,'yard'=>0,'harga'=>0);
		$sql = "SELECT SUM(pid.ukuran) as yard,SUM(pid.jumlah) as roll,pid.harga FROM penerimaan_item_detail pid JOIN penerimaan_item pi ON(pi.id=pid.penerimaan_item_id) WHERE pi.hapus=0";
		$sql.=" AND pid.hapus=0 AND id_persediaan='$id' AND DATE(pi.tanggal) BETWEEN '".$tgl."' AND '".$tgl2."' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d;
		}
		return $hasil;
	}

	public function stokmasuk_alat_last($id){
		$hasil=array('roll'=>0,'yard'=>0,'harga'=>0);
		$sql = "SELECT SUM(pid.ukuran) as yard,SUM(pid.jumlah) as roll,pid.harga FROM penerimaan_item_detail pid JOIN penerimaan_item pi ON(pi.id=pid.penerimaan_item_id) WHERE pi.hapus=0";
		$sql.=" AND pid.hapus=0 AND id_persediaan='$id' GROUP BY pi.tanggal ORDER BY pi.tanggal DESC LIMIT 1 ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d['roll'];
		}
		return $hasil;
	}

	public function stokkeluar_alat($id,$tgl,$tgl2){
		$hasil=0;
		$sql = "SELECT SUM(gik.jumlah_item_keluar) as pcs FROM gudang_item_keluar gik WHERE gik.hapus=0";
		$sql.=" AND id_persediaan='$id' AND DATE(gik.created_date) BETWEEN '".$tgl."' AND '".$tgl2."' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d['pcs'];
		}
		$hasil2=0;
		$sql2="SELECT SUM(jumlah) as total FROM barangkeluarharian_detail WHERE hapus=0 AND idpersediaan='$id' ";
		$sql2.=" AND DATE(tanggal) BETWEEN '".$tgl."' AND '".$tgl2."' ";
		$s2=$this->GlobalModel->QueryManualRow($sql2);
		if(!empty($s2)){
			$hasil2=$s2['total'];
		}
		$total=0;
		$total=$hasil+$hasil2;
		return $total;
	}

	public function stokkeluar_alat_last($id){
		$hasil=0;
		$sql = "SELECT SUM(gik.jumlah_item_keluar) as pcs FROM gudang_item_keluar gik WHERE gik.hapus=0";
		$sql.=" AND id_persediaan='$id' GROUP BY gik.created_date ORDER BY gik.created_date DESC LIMIT 1 ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d['pcs'];
		}
		$hasil2=0;
		$sql2="SELECT SUM(jumlah) as total FROM barangkeluarharian_detail WHERE hapus=0 AND idpersediaan='$id' ";
		$sql2.=" GROUP BY tanggal ORDER BY tanggal DESC LIMIT 1  ";
		$s2=$this->GlobalModel->QueryManualRow($sql2);
		if(!empty($s2)){
			$hasil2=$s2['total'];
		}
		$total=0;
		$total=$hasil+$hasil2;
		return $total;
	}

	public function SumBonusOptBordir($id,$shift){
		$hasil=0;
		$sql = "SELECT SUM(bonus) as bonus FROM gaji_operator go JOIN gaji_operator_new gon ON(gon.idgajiopt=go.id) JOIN gaji_operator_detail_new godn ON(godn.idgaji=gon.id) AND gon.idgajiopt='$id' AND godn.shift='$shift' and godn.hapus=0 ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d['bonus'];
		}
		return $hasil;
	}

	public function SumUmOptBordir($id,$shift){
		$hasil=0;
		$sql = "SELECT SUM(um) as um FROM gaji_operator go JOIN gaji_operator_new gon ON(gon.idgajiopt=go.id) JOIN gaji_operator_detail_new godn ON(godn.idgaji=gon.id) AND gon.idgajiopt='$id' AND godn.shift='$shift' AND godn.idgaji='$id' AND godn.hapus=0 ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d['um'];
		}
		return $hasil;
	}

	public function getMandor($id,$shift){
		$hasil=[];
		$sql = "SELECT lower(mandor) as mandor,COUNT(lower(mandor)) as jml FROM gaji_operator go JOIN gaji_operator_new gon ON(gon.idgajiopt=go.id) JOIN gaji_operator_detail_new godn ON(godn.idgaji=gon.id) AND go.id='$id' AND godn.shift='$shift' AND godn.gaji >0 and godn.hapus=0 GROUP BY lower(mandor) HAVING jml >6";
		$d=$this->GlobalModel->QueryManual($sql);
		if(!empty($d)){
			foreach($d as $de){
				$hasil[]=$de['mandor'];
			}
		}
		return implode(",", $hasil);
	}

	public function getMandor_c($id,$shift){
		$hasil=[];
		$sql = "SELECT lower(mandor) as mandor,COUNT(lower(mandor)) as jml FROM gaji_operator go JOIN gaji_operator_new gon ON(gon.idgajiopt=go.id) JOIN gaji_operator_detail_new godn ON(godn.idgaji=gon.id) AND go.id='$id' AND godn.shift='$shift' AND godn.gaji >0 and godn.hapus=0 GROUP BY lower(mandor) HAVING jml >1";
		$d=$this->GlobalModel->QueryManual($sql);
		if(!empty($d)){
			foreach($d as $de){
				$hasil[]=!empty($de['mandor'])?$de['mandor']:null;
			}
		}
		return count($hasil);
	}

	public function rekap_cmt($idcmt,$proses,$bulan,$tahun){
		$hasil=[];
		foreach(nama_po() as $p){
			$jml=$this->KirimsetorModel->rekapjumlah($p['id_jenis_po'],$idcmt,'KIRIM',$bulan,$tahun);
			$hasil[]=array(
				'nama'=>$p['nama_jenis_po'],
				'jmlkirim'=>$jml,
				'kirimdz'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$idcmt,'KIRIM',$bulan,$tahun))/12,
				'kirimpcs'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$idcmt,'KIRIM',$bulan,$tahun)),
				'jmlsetor'=>$this->KirimsetorModel->rekapjumlah($p['id_jenis_po'],$idcmt,'SETOR',$bulan,$tahun),
				'setordz'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$idcmt,'SETOR',$bulan,$tahun))/12,
				'setorpcs'=>($this->KirimsetorModel->rekappcs($p['id_jenis_po'],$idcmt,'SETOR',$bulan,$tahun)),
			);
		}

		return $hasil;

	}

	public function sum_jumlah_alat_used_po($id,$po,$tgl1,$tgl2){
		$hasil=0;
		$sql="SELECT SUM(jumlah_item_keluar) as total FROM gudang_item_keluar WHERE hapus=0  ";
		if(!empty($tgl1)){
			$sql.="AND DATE(created_date) BETWEEN '$tgl1' AND '$tgl2'  ";
		}
		$sql.=" AND id_persediaan='$id' AND kode_po LIKE '".$po."%' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}

		return $hasil;
	}

	public function sum_jumlah_bahan_used_po($id,$po,$tgl1,$tgl2){
		$hasil=[];
		$sql="SELECT SUM(ukuran_item_keluar) as yard, SUM(jumlah_item_keluar) as roll FROM gudang_bahan_keluar WHERE hapus=0  ";
		if(!empty($tgl1)){
			$sql.="AND DATE(created_date) BETWEEN '$tgl1' AND '$tgl2'  ";
		}
		$sql.=" AND lower(nama_item_keluar)='".strtolower($id)."' AND kode_po LIKE '".$po."%' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=array(
				'yard'=>number_format($data['yard'],2),
				'roll'=>number_format($data['roll'],2),
			);
		}

		return $hasil;
	}


	public function pendapatanbulanan($bulan,$tahun,$jenis){
		$h=0;
		$sql="SELECT COALESCE(SUM(kbp.jumlah_piece_diterima*kbp.harga_satuan),0) as total FROM `finishing_kirim_gudang` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis ='$jenis' ";	
		if(!empty($bulan)){
			$sql.=" AND MONTH(tanggal_kirim) ='".$bulan."' and YEAR(tanggal_kirim)='".$tahun."' ";
		}	
		$sql.=" AND p.hapus=0 ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$h=$data['total'];
		}
		return $h;
	}

	public function potonganbulanan($bulan,$tahun,$jenis){
		$hasil=null;
		$sql="SELECT SUM(kbp.hasil_pieces_potongan) as total FROM `konveksi_buku_potongan` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis=$jenis and  mjp.tampil=1 ";
		if(!empty($bulan)){
			$sql.=" AND MONTH(kbp.created_date) ='".$bulan."' and YEAR(kbp.created_date)='".$tahun."' ";
		}	
		$sql.=" AND p.hapus=0 ";
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']/12);
		}else{
			$out=0;
			return $out;
		}
	}

	public function jmlpotonganbulanan($bulan,$tahun,$jenis){
		if($jenis==2){
			$hasil=null;
			$sql="SELECT count(DISTINCT kbp.kode_po) as total,mjp.perkalian,mjp.nama_jenis_po FROM `konveksi_buku_potongan` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis=$jenis and mjp.tampil=1 ";
			if(!empty($bulan)){
				$sql.=" AND MONTH(kbp.created_date) ='".$bulan."' and YEAR(kbp.created_date)='".$tahun."' ";
			}
			$sql.=" AND p.hapus=0 ";
			$row=$this->db->query($sql)->row_array();
			$hasil=$row;
			if($hasil['total']>0){
				$out =($hasil['total']*$hasil['perkalian']);
			}else{
				$out=0;
			}
			return $out;
		}else{
			$hasil=0;
			$sql="SELECT count(*) as total,mjp.perkalian FROM `konveksi_buku_potongan` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' AND mjp.tampil=1 ";
			$sql.=" AND kbp.kode_po NOT iN (select kode_po from pogagalproduksi where hapus=0)";
			if(!empty($bulan)){
				$sql.=" AND MONTH(kbp.created_date) ='".$bulan."' and YEAR(kbp.created_date)='".$tahun."' ";
			}
			$sql.=" GROUP BY perkalian ";
			$d=$this->GlobalModel->queryManual($sql);
			if(!empty($d)){
				foreach($d as $e){
					$hasil+=($e['total']*$e['perkalian']);
				}
			}

			return $hasil;
		}
	}

	public function ekspedisi($tanggal1,$tanggal2,$jenis){
		$hasil=0;
		if($jenis==1){
			$sql="SELECT COALESCE(SUM(biaya_transport),0) as total FROM pembayaran_cmt WHERE hapus=0 ";
			$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			$d=$this->GlobalModel->queryManualRow($sql);
			if(!empty($d)){
				$hasil=$d['total'];
			}

			// homie noya
			$hasil2=0;
			$sql2="SELECT COALESCE(SUM(nominal),0) as total FROM pendapatan_transport WHERE hapus=0 ";
			$sql2.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			$d2=$this->GlobalModel->queryManualRow($sql2);
			if(!empty($d2)){
				$hasil2=$d2['total'];
			}

			// transport pak dede ke jawa
			$hasil3=0;
			$sql3="SELECT COALESCE(SUM(phnd.harga),0) as total FROM pengajuan_harian_new_detail phnd JOIN pengajuan_harian_new phn ON(phn.id=phnd.idpengajuan) WHERE nama_item LIKE '%Transport pak Dede Ke Jawa%'  AND phn.hapus=0 and phnd.hapus=0 ";
			$sql3.=" AND DATE(phn.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			$d3=$this->GlobalModel->queryManualRow($sql3);
			if(!empty($d3)){
				$hasil3=$d3['total'];
			}


			return $hasil+$hasil2+$hasil3;
		}else{
			// transport driver
			$sql="SELECT COALESCE(SUM(nominal),0) as total FROM transport_driver WHERE hapus=0 ";
			$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			$d=$this->GlobalModel->queryManualRow($sql);
			if(!empty($d)){
				$hasil=$d['total'];
			}
			return $hasil;
		}
	}

	public function barangmasukterakhir($id,$tanggal1,$tanggal2){
		$hasil=[];
		$sql="SELECT pid.*, pi.tanggal FROM penerimaan_item_detail pid JOIN penerimaan_item pi ON (pi.id=pid.penerimaan_item_id) WHERE pi.hapus=0 ";
		$sql.=" AND DATE(pid.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		//$sql.=" AND DATE(tanggal) <= '".$tanggal2."' ";
		$sql.=" AND pid.id_persediaan='".$id."' AND jumlah > 0 ";
		$sql.=" ORDER BY pi.id DESC ";
		$d=$this->GlobalModel->queryManualRow($sql);
		if(!empty($d)){
			$hasil=$d;
		}else{
			$sql="SELECT pid.*, pi.tanggal FROM penerimaan_item_detail pid JOIN penerimaan_item pi ON (pi.id=pid.penerimaan_item_id) WHERE pi.hapus=0 ";
			//$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			$sql.=" AND DATE(pid.tanggal) <= '".$tanggal2."' ";
			$sql.=" AND pid.id_persediaan='".$id."' ";
			$sql.=" ORDER BY pi.id DESC LIMIT 1";
			$d=$this->GlobalModel->queryManualRow($sql);
			$hasil=$d;
		}
		return $hasil;
	}

	public function rataratabarangkeluar($id,$tanggal1,$tanggal2,$bulan){
		$bk=0;
		$gd=0;
		$hasil=0;
		$tahun=date('Y',strtotime($tanggal1));
		$sql1="SELECT COALESCE(SUM(jumlah),0) as total FROM barangkeluarharian_detail WHERE hapus=0 ";
		//$sql1.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		if(!empty($bulan)){
			$sql1.=" AND MONTH(tanggal) ='".$bulan."' AND YEAR(tanggal) ='".$tahun."' ";
		}else{
			$sql1.=" AND MONTH(tanggal) ='".date('n')."' AND YEAR(tanggal) ='".$tahun."' ";
		}
		$sql1.=" AND idpersediaan='".$id."' ";
		$d1=$this->GlobalModel->queryManualRow($sql1);
		if(!empty($d1)){
			$bk=$d1['total'];
		}
		$sql="SELECT COALESCE(SUM(jumlah_item_keluar),0) as total FROM gudang_item_keluar WHERE hapus=0 ";
		//$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		if(!empty($bulan)){
			$sql1.=" AND MONTH(created_date) ='".$bulan."' AND YEAR(created_date) ='".$tahun."' ";
		}else{
			$sql1.=" AND MONTH(created_date) ='".date('n')."' AND YEAR(created_date) ='".$tahun."' ";
		}
		$sql.=" AND id_persediaan='".$id."' ";
		$d=$this->GlobalModel->queryManualRow($sql);
		if(!empty($d)){
			$gd=$d['total'];
		}
		
		$bagi=4;
		if(empty($bulan)){
			$bagi=7;
		}
		
		if(!empty($bulan)){
			//$hasil=($bk+$gd)/$bagi;
			$hasil=$this->stokkeluar_alat($id,$tanggal1,$tanggal2)/30;
		}else{
			$hasil=$this->stokkeluar_alat($id,$tanggal1,$tanggal2)/7;
		}
		
		//$hasil=$this->stokkeluar_alat($id,$tanggal1,$tanggal2)/$bagi;
		return $hasil;
	}

	public function getstoksablon($id){
		$hasil=[];
		$data=[];
		$dz=0;
		$data=$this->GlobalModel->QueryManual("SELECT k.idcmt,k.nosj,kd.* FROM kirimcmtsablon k JOIN kirimcmtsablon_detail kd ON(kd.idkirim=k.id) WHERE idcmt='".$id."' AND k.hapus=0 and kd.hapus=0 AND kd.kode_po NOT IN (SELECT kode_po FROM setorcmt_sablon_detail) ");
		foreach($data as $d){
			$dz+=($d['jumlah_pcs']);
		}
		$hasil=array(
			'count'=>count($data),
			'dz'=>$dz,
		);
		return $hasil;
	}

	public function getket($tanggal,$bagian){
			$sql3="SELECT DISTINCT keterangan FROM aruskas WHERE hapus=0 ";
			$sql3.=" AND date(tanggal) ='".$tanggal."' ";
			$sql3.=" AND bagian";
			$sql3.=" AND saldomasuk>0";
			$ket=$this->GlobalModel->QueryManual($sql3);
			$hasil=[];
			foreach($ket as $k){
				$hasil[]=$k['keterangan'];
			}
			$unique=array_unique($hasil);
			return $unique;
	}

	public function bukupotongan($tim,$tanggal1,$tanggal2){
		$hasil=[];
		$no=1;
		$jenis=$this->GlobalModel->QueryManual("SELECT * FROM master_jenis_po mjp JOIN produksi_po p ON(p.nama_po=mjp.nama_jenis_po) WHERE p.id_produksi_po IN(SELECT idpo FROM konveksi_buku_potongan WHERE DATE(created_date) BETWEEN '".$tanggal1."' and '".$tanggal2."' and tim_potong_potongan='$tim' ) AND mjp.tampil=1 GROUP BY nama_jenis_po ORDER BY nama_jenis_po ASC ");
		foreach($jenis as $t){
			$prods=$this->GlobalModel->QueryManualRow("SELECT count(kode_po) as jml,SUM(hasil_lusinan_potongan) as dz,SUM(hasil_pieces_potongan) as pcs FROM konveksi_buku_potongan WHERE kode_po LIKE '".$t['nama_jenis_po']."%' AND DATE(created_date) BETWEEN '".$tanggal1."' and '".$tanggal2."' and tim_potong_potongan='$tim' ");
			$hasil[]=array(
				'no'=>$no++,
				'nama'=>$t['nama_jenis_po'],
				'jml'=>$prods['jml']*$t['perkalian'],
				'dz'=>$prods['dz'],
				'pcs'=>$prods['pcs'],
			);
		}

		return $hasil;
	}

	public function bukupotongan_bulanan($tim,$bulan,$tahun){
		$hasil=[];
		$no=1;
		$jenis=$this->GlobalModel->QueryManual("SELECT * FROM master_jenis_po mjp JOIN produksi_po p ON(p.nama_po=mjp.nama_jenis_po) WHERE p.id_produksi_po IN(SELECT idpo FROM konveksi_buku_potongan WHERE MONTH(created_date)='".$bulan."' AND YEAR(created_date)='".$tahun."' AND hapus=0 and tim_potong_potongan='$tim' ) AND mjp.tampil=1 GROUP BY nama_jenis_po ORDER BY nama_jenis_po ASC ");
		foreach($jenis as $t){
			$prods=$this->GlobalModel->QueryManualRow("SELECT count(DISTINCT kbp.kode_po) as jml,SUM(hasil_lusinan_potongan) as dz,SUM(hasil_pieces_potongan) as pcs FROM konveksi_buku_potongan kbp JOIN produksi_po p ON p.kode_po=kbp.kode_po LEFT JOIN master_jenis_po mjp ON mjp.nama_jenis_po=p.nama_po WHERE mjp.nama_jenis_po ='".$t['nama_jenis_po']."' AND MONTH(kbp.created_date)='".$bulan."' AND YEAR(kbp.created_date)='".$tahun."' and tim_potong_potongan='$tim' ");
			$hasil[]=array(
				'no'=>$no++,
				'nama'=>$t['nama_jenis_po'],
				'jml'=>$prods['jml']*$t['perkalian'],
				'dz'=>$prods['dz'],
				'pcs'=>$prods['pcs'],
			);
		}

		return $hasil;
	}	

	public function gaji_opt($idopt,$tanggal1,$tanggal2,$tempat){
		$hasil=[];
		foreach(looping_tanggal($tanggal1,$tanggal2) as $s ){
			$sql="SELECT COALESCE(sum(gaji),0) as total,shift,mandor,mesin_bordir as mesin FROM kelola_mesin_bordir WHERE hapus=0 ";
			$sql.=" AND nama_operator='$idopt' AND DATE(created_date)='".$s['tanggal']."' ";
			$d=$this->GlobalModel->QueryManualRow($sql);
			$pot=$this->GlobalModel->QueryManualRow("SELECT COALESCE(sum(nominal),0) as total FROM potongan_operator WHERE hapus=0 AND tempat='".$tempat."' AND DATE(tanggal)='".$s['tanggal']."' AND idkaryawan='".$idopt."'");
			if(!empty($d)){
				$hasil[]=array(
					'tanggal'=>date('d-m-Y',strtotime($s['tanggal'])),
					'hari'=>hari(date('l',strtotime($s['tanggal']))),
					'nominal'=>$d['total'],
					'shift'=>$d['shift'],
					'mandor'=>$d['mandor'],
					'potongan'=>!empty($pot)?$pot['total']:0,
					'keterangan'=>'Mesin '.$d['mesin'],
				);
			}
		}
		return $hasil;
	}

	public function klo_mingguan($idcmt,$tanggal1,$tanggal2,$kategori,$proses){
		$hasil=[];
		$sql="SELECT COALESCE(COUNT(kks.kode_po),0) as jmlpo, COALESCE(SUM(kks.qty_tot_pcs),0) as pcs, mjp.perkalian FROM kelolapo_kirim_setor kks JOIN produksi_po p ON p.id_produksi_po=kks.idpo JOIN master_jenis_po mjp ON p.nama_po=mjp.nama_jenis_po WHERE p.hapus=0 and kks.hapus=0  AND p.hapus=0 ";
		$sql.=" AND mjp.id_jenis_po NOT IN (42,37,36)";
		$sql.=" AND kks.id_master_cmt='$idcmt' AND DATE(kks.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND kks.kategori_cmt='".$kategori."' AND kks.progress='".$proses."' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=array(
				'jmlpo'=>$d['jmlpo']*$d['perkalian'],
				'pcs'=>round($d['pcs']),
				'dz'=>round($d['pcs']/12),
			);
		}
		return $hasil;
	}

	public function klo_mingguan_seblelumnya($idcmt,$tanggal1,$kategori,$proses){
		$hasil=0;
		$hasil_2=0;
		$sql="SELECT COALESCE(COUNT(kks.kode_po),0) as jmlpo, COALESCE(SUM(kks.qty_tot_pcs),0) as pcs, mjp.perkalian FROM kelolapo_kirim_setor kks JOIN produksi_po p ON p.id_produksi_po=kks.idpo JOIN master_jenis_po mjp ON p.nama_po=mjp.nama_jenis_po WHERE p.hapus=0 and kks.hapus=0  AND p.hapus=0 ";
		$sql.=" AND mjp.id_jenis_po NOT IN (42,37,36)";
		$sql.=" AND kks.id_master_cmt='$idcmt' AND DATE(kks.create_date) < '".$tanggal1."' AND kks.kategori_cmt='".$kategori."' AND kks.progress='KIRIM' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		$sql_2="SELECT COALESCE(COUNT(kks.kode_po),0) as jmlpo, COALESCE(SUM(kks.qty_tot_pcs),0) as pcs, mjp.perkalian FROM kelolapo_kirim_setor kks JOIN produksi_po p ON p.id_produksi_po=kks.idpo JOIN master_jenis_po mjp ON p.nama_po=mjp.nama_jenis_po WHERE p.hapus=0 and kks.hapus=0  AND p.hapus=0 ";
		$sql_2.=" AND mjp.id_jenis_po NOT IN (42,37,36)";
		$sql_2.=" AND kks.id_master_cmt='$idcmt' AND DATE(kks.create_date) < '".$tanggal1."' AND kks.kategori_cmt='".$kategori."' AND kks.progress='SETOR' ";
		$d_2=$this->GlobalModel->QueryManualRow($sql_2);
		if(!empty($d)){
			$hasil=$d['jmlpo']*$d['perkalian'];
		}
		if(!empty($d_2)){
			$hasil_2=$d_2['jmlpo']*$d_2['perkalian'];
		}
		return $hasil-$hasil_2;;
	}

	public function klo_mingguan_seblelumnya_jeans($idcmt,$tanggal1,$kategori,$proses){
		$hasil=0;
		$hasil_2=0;
		$sql="SELECT COALESCE(COUNT(kks.kode_po),0) as jmlpo, COALESCE(SUM(kks.qty_tot_pcs),0) as pcs, mjp.perkalian FROM kelolapo_kirim_setor kks JOIN produksi_po p ON p.id_produksi_po=kks.idpo JOIN master_jenis_po mjp ON p.nama_po=mjp.nama_jenis_po WHERE p.hapus=0 and kks.hapus=0  AND p.hapus=0 ";
		$sql.=" AND mjp.id_jenis_po IN (42,37,36)";
		$sql.=" AND kks.id_master_cmt='$idcmt' AND DATE(kks.create_date) < '".$tanggal1."' AND kks.kategori_cmt='".$kategori."' AND kks.progress='KIRIM' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		$sql_2="SELECT COALESCE(COUNT(kks.kode_po),0) as jmlpo, COALESCE(SUM(kks.qty_tot_pcs),0) as pcs, mjp.perkalian FROM kelolapo_kirim_setor kks JOIN produksi_po p ON p.id_produksi_po=kks.idpo JOIN master_jenis_po mjp ON p.nama_po=mjp.nama_jenis_po WHERE p.hapus=0 and kks.hapus=0  AND p.hapus=0 ";
		$sql_2.=" AND mjp.id_jenis_po IN (42,37,36)";
		$sql_2.=" AND kks.id_master_cmt='$idcmt' AND DATE(kks.create_date) < '".$tanggal1."' AND kks.kategori_cmt='".$kategori."' AND kks.progress='SETOR' ";
		$d_2=$this->GlobalModel->QueryManualRow($sql_2);
		if(!empty($d)){
			$hasil=$d['jmlpo']*$d['perkalian'];
		}
		if(!empty($d_2)){
			$hasil_2=$d_2['jmlpo']*$d_2['perkalian'];
		}
		return $hasil-$hasil_2;;
	}

	public function klo_mingguan_seblelumnya_pcs_jeans($idcmt,$tanggal1,$kategori,$proses){
		$hasil=0;
		$hasil_2=0;
		$sql="SELECT COALESCE(COUNT(kks.kode_po),0) as jmlpo, COALESCE(SUM(kks.qty_tot_pcs),0) as pcs, mjp.perkalian FROM kelolapo_kirim_setor kks JOIN produksi_po p ON p.id_produksi_po=kks.idpo JOIN master_jenis_po mjp ON p.nama_po=mjp.nama_jenis_po WHERE p.hapus=0 and kks.hapus=0  AND p.hapus=0 ";
		$sql.=" AND mjp.id_jenis_po  IN (42,37,36)";
		$sql.=" AND kks.id_master_cmt='$idcmt' AND DATE(kks.create_date) < '".$tanggal1."' AND kks.kategori_cmt='".$kategori."' AND kks.progress='KIRIM' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		$sql_2="SELECT COALESCE(COUNT(kks.kode_po),0) as jmlpo, COALESCE(SUM(kks.qty_tot_pcs),0) as pcs, mjp.perkalian FROM kelolapo_kirim_setor kks JOIN produksi_po p ON p.id_produksi_po=kks.idpo JOIN master_jenis_po mjp ON p.nama_po=mjp.nama_jenis_po WHERE p.hapus=0 and kks.hapus=0  AND p.hapus=0 ";
		$sql_2.=" AND mjp.id_jenis_po IN (42,37,36)";
		$sql_2.=" AND kks.id_master_cmt='$idcmt' AND DATE(kks.create_date) < '".$tanggal1."' AND kks.kategori_cmt='".$kategori."' AND kks.progress='SETOR' ";
		$d_2=$this->GlobalModel->QueryManualRow($sql_2);
		if(!empty($d)){
			$hasil=$d['pcs'];
		}
		if(!empty($d_2)){
			$hasil_2=$d_2['pcs'];
		}
		return $hasil-$hasil_2;;
	}

	public function klo_mingguan_seblelumnya_pcs($idcmt,$tanggal1,$kategori,$proses){
		$hasil=0;
		$hasil_2=0;
		$sql="SELECT COALESCE(COUNT(kks.kode_po),0) as jmlpo, COALESCE(SUM(kks.qty_tot_pcs),0) as pcs, mjp.perkalian FROM kelolapo_kirim_setor kks JOIN produksi_po p ON p.id_produksi_po=kks.idpo JOIN master_jenis_po mjp ON p.nama_po=mjp.nama_jenis_po WHERE p.hapus=0 and kks.hapus=0  AND p.hapus=0 ";
		$sql.=" AND mjp.id_jenis_po NOT IN (42,37,36)";
		$sql.=" AND kks.id_master_cmt='$idcmt' AND DATE(kks.create_date) < '".$tanggal1."' AND kks.kategori_cmt='".$kategori."' AND kks.progress='KIRIM' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		$sql_2="SELECT COALESCE(COUNT(kks.kode_po),0) as jmlpo, COALESCE(SUM(kks.qty_tot_pcs),0) as pcs, mjp.perkalian FROM kelolapo_kirim_setor kks JOIN produksi_po p ON p.id_produksi_po=kks.idpo JOIN master_jenis_po mjp ON p.nama_po=mjp.nama_jenis_po WHERE p.hapus=0 and kks.hapus=0  AND p.hapus=0 ";
		$sql_2.=" AND mjp.id_jenis_po NOT IN (42,37,36)";
		$sql_2.=" AND kks.id_master_cmt='$idcmt' AND DATE(kks.create_date) < '".$tanggal1."' AND kks.kategori_cmt='".$kategori."' AND kks.progress='SETOR' ";
		$d_2=$this->GlobalModel->QueryManualRow($sql_2);
		if(!empty($d)){
			$hasil=$d['pcs'];
		}
		if(!empty($d_2)){
			$hasil_2=$d_2['pcs'];
		}
		return $hasil-$hasil_2;;
	}

	function stok_sablon($idcmt){
		$query ="SELECT count(kd.kode_po) as jml, COALESCE(SUM(kd.jumlah_pcs)) as pcs FROM kirimcmtsablon k JOIN kirimcmtsablon_detail kd ON(kd.idkirim=k.id) WHERE idcmt='".$idcmt."' AND k.hapus=0 and kd.hapus=0 AND kd.kode_po NOT IN (SELECT kode_po FROM setorcmt_sablon_detail WHERE hapus=0 ) ";
		$data = $this->GlobalModel->QueryManualRow($query);
		return $data;
	}

	public function klo_mingguanjeans($idcmt,$tanggal1,$tanggal2,$kategori,$proses){
		$hasil=[];
		$sql="SELECT COUNT(kks.kode_po) as jmlpo, COALESCE(SUM(kks.qty_tot_pcs),0) as pcs, mjp.perkalian FROM kelolapo_kirim_setor kks JOIN produksi_po p ON p.id_produksi_po=kks.idpo JOIN master_jenis_po mjp ON p.nama_po=mjp.nama_jenis_po WHERE kks.hapus=0  AND p.hapus=0 ";
		$sql.=" AND mjp.id_jenis_po IN (42,37,36)";
		$sql.=" AND kks.id_master_cmt='$idcmt' AND DATE(kks.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND kks.kategori_cmt='".$kategori."' AND kks.progress='".$proses."' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=array(
				'jmlpo'=>$d['jmlpo']*$d['perkalian'],
				'pcs'=>round($d['pcs']),
				'dz'=>round($d['pcs']/12),
			);
		}
		return $hasil;
	}

	public function absenopt($tanggal){
		$hasil=[];
		$sql="SELECT DISTINCT master_karyawan_bordir.nama_karyawan_bordir as nama,kehadiran_operator,shift FROM kelola_mesin_bordir LEFT JOIN master_karyawan_bordir ON (master_karyawan_bordir.id_master_karyawan_bordir=kelola_mesin_bordir.nama_operator) WHERE kelola_mesin_bordir.hapus=0 ";
		$sql.=" AND DATE(created_date)='".$tanggal."' ";
		$d=$this->GlobalModel->QueryManual($sql);
		if(!empty($d)){
			$hasil=$d;
		}
		$absen=$this->GlobalModel->QueryManual("SELECT nama_karyawan_bordir as nama FROM master_karyawan_bordir WHERE hapus=0 AND id_master_karyawan_bordir NOT IN (SELECT nama_operator FROM kelola_mesin_bordir WHERE hapus=0 AND DATE(created_date)='".$tanggal."') AND tampil=1 ");
		$e=array_merge($hasil,$absen);
		return $e;
	}

	public function grafikpendapatanbordirbulanan($data){
		$lusin=array();
		$hasil=array();
		$sql="SELECT * FROM master_jenis_po WHERE status=1 ";
		$po=$this->db->query($sql)->result_array();
		$periode=$this->periode();
		
			for ($i = 0; $i < 12; $i++) {
		    	$timestamp = mktime(0, 0, 0, $periode['bulan'] + $i, 1,$periode['tahun']);
		    	$bulan=$months[date('n', $timestamp)] = date('n', $timestamp);
		    	$tahun=$yearrs[date('n', $timestamp)] = date('Y', $timestamp);
		    	$total=0;
		    	$total2=0;
		    	$pengeluaran=0;
				$sql="SELECT SUM(total_stich*laporan_perkalian_tarif) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 ";
				$sql.= " AND mesin_bordir<>11 ";
				 $sql.=" AND MONTH(created_date) ='".$bulan."' ";
				$row=$this->GlobalModel->QueryManualRow($sql);
				if(!empty($row)){
					$total=$row['total'];
				}
					$sql2="SELECT SUM(total_stich*laporan_perkalian_tarif) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=2 ";
				
				
				$sql2.= " AND mesin_bordir<>11 ";
				 $sql2.=" AND MONTH(created_date) ='".$bulan."' ";
				$row2=$this->GlobalModel->QueryManualRow($sql2);
				if(!empty($row2)){
					$total2=$row2['total'];
				}

				// pengeluaran
				$peng=$this->GlobalModel->QueryManualRow("SELECT SUM(total) as total FROM `pengeluaran_bordir` WHERE hapus=0 AND MONTH(tanggal)='".$bulan."' ");
				if(!empty($peng)){
					$pengeluaran=$peng['total'];
				}

		    	$lusin['bulan'][]=$total==null?0:($total+$total2-$pengeluaran);
			}

			$hasil=$lusin['bulan'];
		
		return $hasil;
	}

	public function bordirbulanan($data){
		$lusin=array();
		$hasil=array();
		$sql="SELECT * FROM master_jenis_po WHERE status=1 ";
		$po=$this->db->query($sql)->result_array();
		$periode=$this->periode();
		
			for ($i = 0; $i < 12; $i++) {
		    	$timestamp = mktime(0, 0, 0, $periode['bulan'] + $i, 1,$periode['tahun']);
		    	$bulan=$months[date('n', $timestamp)] = date('n', $timestamp);
		    	$tahun=$yearrs[date('n', $timestamp)] = date('Y', $timestamp);
		    	$total=0;
		    	$total2=0;
		    	$pengeluaran=1000;
				$sql="SELECT SUM(total_stich*laporan_perkalian_tarif) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 ";
				$sql.= " AND mesin_bordir<>11 ";
				 $sql.=" AND MONTH(created_date) ='".$bulan."' ";
				$row=$this->GlobalModel->QueryManualRow($sql);
				if(!empty($row)){
					$total=$row['total'];
				}

					$sql2="SELECT SUM(total_stich*laporan_perkalian_tarif) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=2 ";
				
				
				$sql2.= " AND mesin_bordir<>11 ";
				 $sql2.=" AND MONTH(created_date) ='".$bulan."' ";
				$row2=$this->GlobalModel->QueryManualRow($sql2);
				if(!empty($row2)){
					$total2=$row2['total'];
				}
				// pengeluaran
				$peng=$this->GlobalModel->QueryManualRow("SELECT SUM(total) as total FROM `pengeluaran_bordir` WHERE hapus=0 AND MONTH(tanggal)='".$bulan."' ");
				if(!empty($peng)){
					$pengeluaran=$peng['total'];
				}

		    	$lusin['bulan'][]=array(
		    		'bulan'=>$bulan,
		    		'tahun'=>$tahun,
		    		'total'=>$total==null?0:($total+$total2-$pengeluaran),
		    	);
			}

			$hasil=$lusin['bulan'];
		
		return $hasil;
	}

	public function totalsup($id,$tanggal1,$tanggal2){
		$hasil=0;
		$sql="SELECT ROUND(SUM(pid.jumlah*pid.harga)) as total FROM penerimaan_item_detail pid JOIN penerimaan_item pi ON (pi.id=pid.penerimaan_item_id) WHERE pi.hapus=0 and pid.hapus=0 AND pi.supplier='$id' AND DATE(pi.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d['total'];
		}
		return $hasil;
	}

	public function totalsuplaporan($supplier,$id){
		$hasil=0;
		$spid="SELECT tanggal_akhir FROM rekapbarangsupplier_detail where idrekap='".$id."' ORDER BY tanggal_akhir DESC LIMIT 1 ";
		$pid=$this->GlobalModel->QueryManualRow($spid);
		$sql="SELECT SUM(pid.jumlah*pid.harga) as total FROM penerimaan_item_detail pid JOIN penerimaan_item pi ON (pi.id=pid.penerimaan_item_id) WHERE pi.hapus=0 and pid.hapus=0 AND pi.supplier='$supplier' AND MONTH(pi.tanggal)='".date('n',strtotime($pid['tanggal_akhir']))."' ";
		$d=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($d)){
			$hasil=$d['total'];
		}
		return $hasil;
	}

	public function getrekapalat($penerima,$tanggal1,$tanggal2){
		$hasil=[];
		$sql="SELECT * FROM gudang_item_keluar WHERE hapus=0 AND LOWER(nama_penerima)='".strtolower($penerima)."' ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" GROUP BY kode_po ";
		$d=$this->GlobalModel->QueryManual($sql);
		if(!empty($d)){
			foreach($d as $dat){
				$hasil[]=$dat['kode_po'];
			}
		}
		return $hasil;
	}

	public function getrekapalatbulan($penerima,$tanggal1,$tanggal2){
		$hasil=[];
		$sql="SELECT * FROM gudang_item_keluar WHERE hapus=0 AND LOWER(nama_penerima)='".strtolower($penerima)."' ";
		if(!empty($tanggal1)){
			$sql.=" AND MONTH(created_date) = '".$tanggal1."' ";
		}

		if(!empty($tanggal1)){
			$sql.=" AND YEAR(created_date) = '".$tanggal2."' ";
		}
		$sql.=" GROUP BY kode_po ";
		$d=$this->GlobalModel->QueryManual($sql);
		if(!empty($d)){
			foreach($d as $dat){
				$hasil[]=$dat['kode_po'];
			}
		}
		return $hasil;
	}

	// fungsi baru untuk laporan pendapatan po luar bordir
	public function getSumPendapatanpoluar($data,$jenis){
		$sql="SELECT sum(total_stich*laporan_perkalian_tarif) as total FROM kelola_mesin_bordir WHERE hapus=0 and jenis=$jenis ";
		if(isset($data['bulan'])){
			$sql .=" AND MONTH(created_date)='".$data['bulan']."' AND YEAR(created_date)='".$data['tahun']."' ";
		}else{
			if(!empty($data['tanggal1'])){
				$sql.=" AND date(created_date) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
			}
		}
		
		if(!empty($data['nomesin'])){
			$sql.=" AND mesin_bordir='".$data['nomesin']."' ";
		}
		$d=$this->GlobalModel->QueryManualRow($sql);
		$hasil=0;
		if(!empty($d)){
			$hasil=(int)$d['total'];
		}
		return $hasil;
	}

	// laporan buku potongan yang digabung dengan laporan mingguan klo karena berbeda harinya
	public function laporanbukupotonganklo($tim,$tanggal1,$tanggal2){
		$hasil=[];
		$no=1;
		$jenis=$this->GlobalModel->QueryManual("SELECT * FROM master_jenis_po mjp JOIN produksi_po p ON(p.nama_po=mjp.nama_jenis_po) WHERE p.id_produksi_po IN(SELECT idpo FROM konveksi_buku_potongan WHERE DATE(created_date) BETWEEN '".$tanggal1."' and '".$tanggal2."' and tim_potong_potongan='$tim' ) AND mjp.tampil=1 GROUP BY nama_jenis_po ORDER BY nama_jenis_po ASC ");
		foreach($jenis as $t){
			$prods=$this->GlobalModel->QueryManualRow("SELECT count(kbp.kode_po) as jml,SUM(kbp.hasil_lusinan_potongan) as dz,SUM(kbp.hasil_pieces_potongan) as pcs FROM konveksi_buku_potongan kbp LEFT JOIN produksi_po p ON p.id_produksi_po=kbp.idpo WHERE p.nama_po = '".$t['nama_jenis_po']."' AND DATE(kbp.created_date) BETWEEN '".$tanggal1."' and '".$tanggal2."' and tim_potong_potongan='$tim' ");
			$hasil[]=array(
				'no'=>$no++,
				'nama'=>$t['nama_jenis_po'],
				'jml'=>$prods['jml']*$t['perkalian'],
				'dz'=>$prods['dz'],
				'pcs'=>$prods['pcs'],
			);
		}
		return $hasil;
	}

	public function historypokirimgudang($idpo){
		$hasil=[];
		// rincian setoran
		$setoran=[];
		$setoran=$this->GlobalModel->QueryManual("SELECT * FROM kelolapo_rincian_setor_cmt WHERE idpo = '".$idpo."'");
		$st=[];
		$std=[];
		foreach($setoran as $s){
			$st[] = array(
				'id'=>$s['id_kelolapo_rincian_setor_cmt'],
				'kode_po'=>$s['kode_po'],
				'tgl'=>hari(date('l',strtotime($s['created_date']))).', '.date('d-m-Y',strtotime($s['created_date'])),
				'detail'=>$this->GlobalModel->GetData('kelolapo_rincian_setor_cmt_finish',array('id_kelolapo_rincian_setor_cmt'=>$s['id_kelolapo_rincian_setor_cmt'])),
			);
		}
		$kirimgudang=[];
		$kirimgudang=$this->GlobalModel->QueryManual("SELECT * FROM finishing_kirim_gudang WHERE idpo = '".$idpo."'");
		$detail=[];
		$kirimgd=[];
		foreach($kirimgudang as $kg){
			$kirimgd[]=array(
				'id_finishing_kirim_gudang'=>$kg['id_finishing_kirim_gudang'],
				'kode_po'=>$kg['kode_po'],
				'kirim'=>$kg['jumlah_piece_diterima'],
				'tgl'=>hari(date('l',strtotime($kg['created_date']))).', '.date('d-m-Y',strtotime($kg['created_date'])),
				'detail'=>$this->GlobalModel->GetData('finishing_kirim_gudang_rincian',array('id_finishing_kirim_gudang'=>$kg['id_finishing_kirim_gudang'])),
			);
		}

		$stokset=[];
		//pre($st);
		foreach($st as $s){
			foreach($s['detail'] as $sd){
				$stokset[$sd['rincian_size']]+=$sd['rincian_lusin'];
			}
		}

		foreach($kirimgd as $s){
			foreach($s['detail'] as $sd){
				$kirimgdset[$sd['rincian_size']]+=$sd['rincian_lusin'];
			}
		}

		$merge=[];
		foreach($st as $s){
			foreach($s['detail'] as $sd){
				$merge[$sd['rincian_size']]=$sd['rincian_lusin']-$kirimgdset[$sd['rincian_size']];
			}
		}

		$hasil=array(
			'setoran'=>$st,
			'kirimgudang'=>$kirimgd,
			'stokset'=>$stokset,
			'kirimgdset'=>!empty($kirimgdset)?$kirimgdset:null,
			'stok'=>$merge,
		);
		return $hasil;
	}

	public function stok_akhir_cmt($idcmt){
		// $query="SELECT count(*) as jmlpo,SUM(kd.jumlah_pcs-kd.totalsetor) as pcs,mjp.perkalian FROM kirimcmt_detail kd JOIN kirimcmt k ON(k.id=kd.idkirim) LEFT JOIN produksi_po pp ON(kd.kode_po=pp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=pp.nama_po) WHERE 
		// k.idcmt='$idcmt' AND k.hapus=0 AND kd.hapus=0 AND kd.jumlah_pcs<>kd.totalsetor ";
		// $dataReturn = $this->db->query($query)->row_array();
		// return $dataReturn;
		$query="SELECT COUNT(kd.kode_po) as jmlpo,SUM(kd.jumlah_pcs-kd.totalsetor) as pcs,mjp.perkalian FROM kirimcmt_detail kd JOIN kirimcmt k ON(k.id=kd.idkirim) LEFT JOIN produksi_po pp ON(kd.kode_po=pp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=pp.nama_po) WHERE pp.hapus=0 AND k.idcmt='$idcmt' AND k.hapus=0 AND kd.hapus=0 AND kd.jumlah_pcs<>kd.totalsetor ";
		//$query .="  HAVING SUM(kd.jumlah_pcs-kd.totalsetor) > 3";
		$dataReturn = $this->GlobalModel->QueryManual($query);
		foreach($dataReturn as $d){
			$hasil = array(
				'jmlpo'=>floor($d['jmlpo']*$d['perkalian']),
				'pcs'=>$d['pcs'],
			);
		}
		//pre($hasil);
		return $hasil;
	}

	function hitungAlokasiPo($idcmt,$jenis,$idalokasi){
		$jenis = implode(",",$jenis);
		$sql ="
		SELECT COUNT(a.kode_po) as total FROM alokasi_po_detail a 
		JOIN produksi_po p ON p.kode_po=a.kode_po
		LEFT JOIN master_jenis_kaos mk ON mk.nama_jenis_kaos=p.jenis_po
		JOIN alokasi_po ap ON ap.id=a.idalokasi
		LEFT JOIN master_cmt mc ON mc.id_cmt=ap.idcmt";
		$sql.=" WHERE ap.id='".$idalokasi."' and mk.master_jenis_kaos_id IN (".$jenis.") ";
		//$sql.=" AND ap.idcmt='".$idcmt."' ";
		//$sql.="GROUP BY mk.master_jenis_kaos_id";
		$sql.="ORDER BY mc.cmt_name
		";
		$hasil=$this->db->query($sql)->row_array();
		return !empty($hasil) ? $hasil['total'] : 0;
	}

	function hitungAlokasiPoKLO($idcmt,$jenis,$idalokasi){
		$jenis = implode(",",$jenis);
		$sql ="
		SELECT COUNT(a.kode_po) as total FROM alokasi_po_detail a 
		JOIN produksi_po p ON p.kode_po=a.kode_po
		LEFT JOIN master_jenis_kaos mk ON mk.nama_jenis_kaos=p.jenis_po
		JOIN alokasi_po ap ON ap.id=a.idalokasi
		LEFT JOIN master_cmt mc ON mc.id_cmt=ap.idcmt
		LEFT JOIN kelolapo_kirim_setor klo ON klo.kode_po = a.kode_po
		";
		$sql.=" WHERE ap.id='".$idalokasi."' and mk.master_jenis_kaos_id IN (".$jenis.") ";
		$sql.=" AND a.kode_po NOT IN(SELECT kode_po FROM kelolapo_kirim_setor where hapus=0 and progress='SETOR'
		and kategori_cmt='JAHIT' ) ";
		$sql.=" AND ap.idcmt='".$idcmt."' ";
		//$sql.="GROUP BY mk.master_jenis_kaos_id";
		$sql.="ORDER BY mc.cmt_name
		";
		$hasil=$this->db->query($sql)->row_array();
		return !empty($hasil) ? $hasil['total'] : 0;
	}

	function hitungAlokasiPo_($idcmt,$jenis,$idalokasi,$kodepo){
		$jenis = implode(",",$jenis);
		$sql ="
		SELECT COUNT(a.kode_po) as total FROM podiluaralokasi_detail a 
		JOIN produksi_po p ON p.kode_po=a.kode_po
		LEFT JOIN master_jenis_kaos mk ON mk.nama_jenis_kaos=p.jenis_po
		JOIN podiluaralokasi ap ON ap.id=a.idalokasi
		LEFT JOIN master_cmt mc ON mc.id_cmt=ap.idcmt";
		$sql.=" WHERE ap.id='".$idalokasi."' and mk.master_jenis_kaos_id IN (".$jenis.") ";
		$sql .=" and p.kode_po='".$kodepo."' ";
		//$sql.=" AND ap.idcmt='".$idcmt."' ";
		//$sql.="GROUP BY mk.master_jenis_kaos_id";
		$sql.="ORDER BY mc.cmt_name
		";
		$hasil=$this->db->query($sql)->row_array();
		return !empty($hasil) ? $hasil['total'] : 0;
	}

	function getJumlahJenisPoCmtGrup($idjenis,$lokasicmt){
		$sql="SELECT count(Distinct kbp.kode_po) as total,mjp.nama_jenis_po,mjp.perkalian FROM `kelolapo_kirim_setor` kbp 
		JOIN produksi_po p ON(p.kode_po=kbp.kode_po) 
		LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) 
		LEFT JOIN master_cmt mc ON mc.id_cmt=kbp.id_master_cmt
		WHERE mjp.id_jenis_po ='$idjenis' AND kbp.kategori_cmt='JAHIT' 
		AND kbp.progress='KIRIM' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) 
		
		";

		if(!empty($lokasicmt)){
			$sql.=" AND mc.lokasi='".$lokasicmt."' ";
		}
		
		//$sql.="GROUP BY kbp.kode_po ";
		$row=$this->db->query($sql)->row_array();
		$d=$row;
		if($d['total']>0){
			$hasil=$d['total'];
				if($d['nama_jenis_po']=="SKF" OR strtoupper($d['nama_jenis_po'])=="SIMULASI SKF"){
					$hasil=round($d['total']*$d['perkalian']);
				}
			// return ($hasil['total']);
		}else{
			$out=0;
			$hasil=$out;
			//return $out;
		}

		// setor 
		$hasil_2=0;
		$sql_2="SELECT count(Distinct kbp.kode_po) as total,mjp.nama_jenis_po,mjp.perkalian FROM `kelolapo_kirim_setor` kbp 
		JOIN produksi_po p ON(p.kode_po=kbp.kode_po) 
		LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) 
		LEFT JOIN master_cmt mc ON mc.id_cmt=kbp.id_master_cmt
		WHERE mjp.id_jenis_po ='$idjenis' AND kbp.kategori_cmt='JAHIT' 
		AND kbp.progress='SETOR' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) 
		
		";
		
		if(!empty($lokasicmt)){
			$sql_2.=" AND mc.lokasi='".$lokasicmt."' ";
		}

		//$sql.="GROUP BY kbp.kode_po ";
		$row_2=$this->db->query($sql_2)->row_array();
		$d_2=$row_2 ?? null;
		if($d['total']>0){
			$hasil_2=$d_2['total'];
				if (!empty($d_2)) {
					if ($d_2['nama_jenis_po'] && (strtoupper($d_2['nama_jenis_po']) === "SKF" || strtoupper($d_2['nama_jenis_po']) === "SIMULASI SKF")) {
						$hasil_2 = round($d_2['total'] * $d_2['perkalian']);
					}
				}
			// return ($hasil['total']);
		}else{
			$out=0;
			$hasil_2=$out;
			//return $out;
		}
		
		return $hasil-$hasil_2;
	}

	function getJumlahJenisPoCmtGrupLokasi($lokasicmt,$idjenis){
		$sql="SELECT count(Distinct kbp.kode_po) as total,mjp.nama_jenis_po,mjp.perkalian FROM `kelolapo_kirim_setor` kbp 
		JOIN produksi_po p ON(p.kode_po=kbp.kode_po) 
		LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) 
		LEFT JOIN master_cmt mc ON mc.id_cmt=kbp.id_master_cmt
		WHERE  kbp.kategori_cmt='JAHIT' 
		AND kbp.progress='KIRIM' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) 
		AND mc.lokasi='".$lokasicmt."' AND mjp.idjenis='$idjenis'
		";
		
		//$sql.="GROUP BY kbp.kode_po ";
		$row=$this->db->query($sql)->row_array();
		$d=$row;
		if($d['total']>0){
			$hasil=$d['total'];
				if($d['nama_jenis_po']=="SKF" OR strtoupper($d['nama_jenis_po'])=="SIMULASI SKF"){
					$hasil=round($d['total']*$d['perkalian']);
				}
			// return ($hasil['total']);
		}else{
			$out=0;
			$hasil=$out;
			//return $out;
		}

		// setor 
		$hasil_2=0;
		$sql_2="SELECT count(Distinct kbp.kode_po) as total,mjp.nama_jenis_po,mjp.perkalian FROM `kelolapo_kirim_setor` kbp 
		JOIN produksi_po p ON(p.kode_po=kbp.kode_po) 
		LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) 
		LEFT JOIN master_cmt mc ON mc.id_cmt=kbp.id_master_cmt
		WHERE kbp.kategori_cmt='JAHIT' 
		AND kbp.progress='SETOR' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) 
		AND mc.lokasi='".$lokasicmt."' AND mjp.idjenis='$idjenis'
		";
		
		//$sql.="GROUP BY kbp.kode_po ";
		$row_2=$this->db->query($sql_2)->row_array();
		$d_2=$row_2;
		if($d['total']>0){
			$hasil_2=$d_2['total'];
				if(!empty($d_2['nama_jenis_po'])){
					if($d_2['nama_jenis_po']=="SKF" OR strtoupper($d_2['nama_jenis_po'])=="SIMULASI SKF"){
						$hasil_2=round($d_2['total']*$d_2['perkalian']);
					}
				}
				
			// return ($hasil['total']);
		}else{
			$out=0;
			$hasil_2=$out;
			//return $out;
		}
		
		return $hasil-$hasil_2;
	}

	function pendingPo($namapo){
		$sql ="SELECT COALESCE(COUNT(a.kode_po)) AS total FROM konveksi_buku_potongan a ";
		$sql.=" LEFT JOIN produksi_po b ON b.id_produksi_po=a.idpo";
		$sql.=" LEFT JOIN master_jenis_po c ON c.nama_jenis_po=b.nama_po ";
		$sql.=" WHERE a.hapus=0 AND c.tampil=1 and a.kode_po NOT IN (select kode_po FROM kelolapo_kirim_setor WHERE hapus=0) ";
		
		if( !empty($namapo) ){
			if($namapo=='kaos'){
				$sql.=" AND c.idjenis='2' ";
			}else{
				$sql.=" AND c.id_jenis_po='$namapo' ";
			}
		}

		

		$data = $this->GlobalModel->QueryManualRow($sql);
		return !empty($data) ? $data['total']:0;
	}

	function BeredarPo($namapo,$kategori){
		$sql ="SELECT COALESCE(COUNT(a.kode_po),0) AS total FROM kelolapo_kirim_setor a ";
		$sql.=" LEFT JOIN produksi_po b ON b.kode_po=a.kode_po";
		$sql.=" LEFT JOIN master_jenis_po c ON c.nama_jenis_po=b.nama_po ";
		
		if(!empty($kategori)){
			$sql.=" WHERE a.hapus=0 and a.kategori_cmt='$kategori' AND a.progress='KIRIM' AND c.tampil=1
			AND a.kode_po NOT IN (select kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND kategori_cmt != '$kategori' ) 
			AND a.kode_po NOT IN (select kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND kategori_cmt = '$kategori' AND progress='SETOR'  )
			";
		}

		if( !empty($namapo) ){
			$sql.=" AND c.id_jenis_po='$namapo' ";
		}
		
		$data = $this->GlobalModel->QueryManualRow($sql);
		return !empty($data) ? $data['total']:0;
	}

	function BeredarPoDetail($namapo,$kategori){
		$data=[];
		$sql ="SELECT a.kode_po FROM kelolapo_kirim_setor a ";
		$sql.=" LEFT JOIN produksi_po b ON b.kode_po=a.kode_po";
		$sql.=" LEFT JOIN master_jenis_po c ON c.nama_jenis_po=b.nama_po ";
		$sql.=" WHERE a.hapus=0 and a.kategori_cmt='$kategori' AND a.progress='KIRIM' AND c.tampil=1
		AND a.kode_po NOT IN (select kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND kategori_cmt != '$kategori' ) 
		AND a.kode_po NOT IN (select kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND kategori_cmt = '$kategori' AND progress='SETOR'  )
		";

		if( !empty($namapo) ){
			$sql.=" AND c.id_jenis_po='$namapo' ";
		}
		
		$data = $this->GlobalModel->QueryManual($sql);
		return $data;
	}

	function BeredarPoPerjalanan($lokasi,$type){
		$data = null;
		if($type=='total'){
			$sqlfirst = "SELECT COALESCE(COUNT(*),0) as total ";
		}else{
			$sqlfirst = "SELECT * ";
		}
		$sql ="
		
		$sqlfirst FROM produksi_po pp JOIN kelolapo_kirim_setor kks ON pp.kode_po=kks.kode_po 
		LEFT JOIN master_jenis_po mjp ON pp.nama_po=mjp.nama_jenis_po
		LEFT JOIN master_cmt mc ON mc.id_cmt=kks.id_master_cmt
		WHERE pp.hapus=0 and  kks.progress='FINISHING' AND kks.hapus=0 and pp.kode_po NOT LIKE 'BJK%' AND mjp.idjenis=1 
		AND pp.id_produksi_po NOT IN (SELECT idpo FROM kelolapo_rincian_setor_cmt) AND mc.lokasi='$lokasi'

		";

		if($type=='total'){
			$data = $this->GlobalModel->QueryManualRow($sql);
		}else{
			$data = $this->GlobalModel->QueryManual($sql);
		}

		return ($type=='total') ? $data['total']:$data;
	}

	function BeredarPoPerjalananBelumLengkap($lokasi,$type){
		$data = null;
		if($type=='total'){
			$sqlfirst = "SELECT COALESCE(COUNT(*),0) as total ";
		}else{
			$sqlfirst = "SELECT * ";
		}
		$sql ="
		
		$sqlfirst FROM produksi_po pp JOIN kelolapo_kirim_setor kks ON pp.kode_po=kks.kode_po 
		LEFT JOIN master_jenis_po mjp ON pp.nama_po=mjp.nama_jenis_po
		LEFT JOIN master_cmt mc ON mc.id_cmt=kks.id_master_cmt
		WHERE pp.hapus=0 and  kks.progress='FINISHING' AND kks.hapus=0 and pp.kode_po NOT LIKE 'BJK%' AND mjp.idjenis=1 
		AND pp.id_produksi_po NOT IN (SELECT idpo FROM kelolapo_rincian_setor_cmt) AND mc.lokasi='$lokasi'

		";

		if($type=='total'){
			$data = $this->GlobalModel->QueryManualRow($sql);
		}else{
			$data = $this->GlobalModel->QueryManual($sql);
		}

		return ($type=='total') ? $data['total']:$data;
	}

	function BeredarPoSum($id_jenis_po,$kategori){
		$sql ="SELECT COALESCE(COUNT(a.kode_po),0) AS total FROM kelolapo_kirim_setor a ";
		$sql.=" LEFT JOIN produksi_po b ON b.kode_po=a.kode_po";
		$sql.=" LEFT JOIN master_jenis_po c ON c.nama_jenis_po=b.nama_po ";
		
		if(!empty($kategori)){
			$sql.=" WHERE a.hapus=0 and a.kategori_cmt='$kategori' AND a.progress='KIRIM' AND c.tampil=1
			AND a.kode_po NOT IN (select kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND kategori_cmt != '$kategori' ) 
			AND a.kode_po NOT IN (select kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND kategori_cmt = '$kategori' AND progress='SETOR'  )
			";
		}

		if( !empty($id_jenis_po) ){
			$sql.=" AND c.idjenis='$id_jenis_po' ";
		}
		
		$data = $this->GlobalModel->QueryManualRow($sql);
		return !empty($data) ? $data['total']:0;
	}

	function pendingPoDetail($namapo){
		$sql ="SELECT a.kode_po FROM konveksi_buku_potongan a ";
		$sql.=" LEFT JOIN produksi_po b ON b.id_produksi_po=a.idpo";
		$sql.=" LEFT JOIN master_jenis_po c ON c.nama_jenis_po=b.nama_po ";
		$sql.=" WHERE a.hapus=0 AND c.tampil=1 and a.kode_po NOT IN (select kode_po FROM kelolapo_kirim_setor WHERE hapus=0) ";
		
		if( !empty($namapo) ){
			$sql.=" AND c.id_jenis_po='$namapo' ";
		}

		$data = $this->GlobalModel->QueryManual($sql);
		return $data;
	}

	function getJumlahJenisPoCmtGrupDetail($idjenis,$lokasicmt){
		$sql="SELECT kbp.kode_po FROM `kelolapo_kirim_setor` kbp 
		JOIN produksi_po p ON(p.kode_po=kbp.kode_po) 
		LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) 
		LEFT JOIN master_cmt mc ON mc.id_cmt=kbp.id_master_cmt
		WHERE mjp.id_jenis_po ='$idjenis' AND kbp.kategori_cmt='JAHIT' 
		AND kbp.progress='KIRIM' AND kbp.hapus=0 and mjp.tampil=1 AND kbp.id_master_cmt NOT IN(63) 
		AND mc.lokasi='".$lokasicmt."' 

		AND kbp.kode_po NOT IN (SELECT kode_po FROM kelolapo_kirim_setor WHERE hapus=0 AND progress='SETOR' AND id_master_cmt NOT IN (63) AND kategori_cmt='JAHIT' )
		";
		$row=$this->GlobalModel->QueryManual($sql);
		return $row;
	}

	function KLOPo($namapo){
		$sql ="SELECT COALESCE(COUNT(a.kode_po)) AS total FROM konveksi_buku_potongan a ";
		$sql.=" LEFT JOIN produksi_po b ON b.id_produksi_po=a.idpo";
		$sql.=" LEFT JOIN master_jenis_po c ON c.nama_jenis_po=b.nama_po ";
		$sql.=" WHERE a.hapus = 0 
		AND c.tampil = 1 
		AND a.kode_po IN (
			SELECT kode_po 
			FROM kelolapo_kirim_setor 
			WHERE hapus = 0 
			AND kategori_cmt IN ('SABLON') 
			AND progress IN ('SETOR') 
				AND kode_po NOT IN (
					SELECT kode_po FROM kelolapo_kirim_setor 
					WHERE hapus=0
					AND kategori_cmt='JAHIT'
				)
			GROUP BY kode_po
		) ";

		if( !empty($namapo) ){
			if($namapo=='kemeja'){
				$sql.=" AND c.idjenis='1' ";
			}else if($namapo=='kaos'){
				$sql.=" AND c.idjenis='2' ";
			}else{
				$sql.=" AND c.id_jenis_po='$namapo' ";
			}
		}

		$data = $this->GlobalModel->QueryManualRow($sql);
		return !empty($data) ? $data['total']:0;
	}

	function kloPoDetail($namapo){
		$sql ="SELECT b.kode_po 
		FROM konveksi_buku_potongan a  ";
		$sql.=" LEFT JOIN produksi_po b ON b.id_produksi_po=a.idpo";
		$sql.=" LEFT JOIN master_jenis_po c ON c.nama_jenis_po=b.nama_po ";
		$sql.=" WHERE a.hapus = 0 
		AND c.tampil = 1 
		AND a.kode_po IN (
			SELECT kode_po 
			FROM kelolapo_kirim_setor 
			WHERE hapus = 0 
			AND kategori_cmt IN ('SABLON') 
			AND progress IN ('SETOR') 
				AND kode_po NOT IN (
					SELECT kode_po FROM kelolapo_kirim_setor 
					WHERE hapus=0
					AND kategori_cmt='JAHIT'
				)
			GROUP BY kode_po
		) ";
		
		if( !empty($namapo) ){
			$sql.=" AND c.id_jenis_po='$namapo' ";
		}

		$data = $this->GlobalModel->QueryManual($sql);
		return $data;
	}

}
